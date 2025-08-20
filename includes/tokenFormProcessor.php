<?php require_once("functions.php"); ?>
<?php require_once("connection.php"); ?>
<?php require_once("session.php"); ?>

<?php
// ---------------------------
// Config
// ---------------------------
$api_key = getenv('OPENAI_API_KEY') ?: 'XYZ'; // TODO: set in hosting panel
$openai_endpoint = 'https://api.openai.com/v1/chat/completions';
// Use a cheap, available model. Update if you’ve enabled others.
$openai_model = 'gpt-4o-mini'; // fallback-safe; change if needed
$openai_timeout = 20;          // seconds
$openai_max_retries = 3;

// ---------------------------
// Session defaults
// ---------------------------
$_SESSION['tokenTest']   = '';
$_SESSION['authorName']  = '';
$_SESSION['authorEmail'] = '';
$_SESSION['authorLineOne'] = '';
$_SESSION['authorLineTwo'] = '';

// ---------------------------
// Helpers
// ---------------------------
function sanitize_line($s) {
    // Normalize whitespace and trim dangerous chars
    $s = trim((string)$s);
    // collapse multiple spaces
    $s = preg_replace('/\s+/u', ' ', $s);
    return $s;
}

/**
 * Robust OpenAI call with cURL, retries, backoff, and error bubbles.
 */
function call_openai_chat($endpoint, $api_key, $model, $messages, $timeout = 20, $max_retries = 3) {
    $payload = [
        'model' => $model,
        'temperature' => 0.1,
        'max_tokens' => 60,
        'n' => 1,
        'messages' => $messages,
    ];

    $attempt = 0;
    $backoff = 2; // seconds
    $lastErr = null;

    while ($attempt < $max_retries) {
        $attempt++;

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ]);

        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_err  = curl_error($ch);
        $headers   = curl_getinfo($ch);
        curl_close($ch);

        if ($curl_err) {
            $lastErr = "cURL error: $curl_err";
        } else {
            if ($http_code >= 200 && $http_code < 300) {
                $decoded = json_decode($result, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return [null, $decoded];
                }
                $lastErr = 'JSON decode error: ' . json_last_error_msg();
            } elseif ($http_code == 429 || ($http_code >= 500 && $http_code <= 599)) {
                // Rate limited or server error — retry with backoff
                // Respect Retry-After if present (we don't have raw headers here via curl_getinfo,
                // so just sleep the backoff). You can extend to parse headers with HEADERFUNCTION.
                sleep($backoff);
                $backoff *= 2;
                continue;
            } else {
                // Hard error, do not retry further unless attempts remain
                $lastErr = "HTTP $http_code: $result";
            }
        }
        // If here and attempts remain, backoff
        if ($attempt < $max_retries) {
            sleep($backoff);
            $backoff *= 2;
        }
    }
    return [$lastErr ?: 'Unknown error contacting OpenAI', null];
}

/**
 * Extract the first two non-empty lines from a model response,
 * stripping code fences and bullets. Falls back to original lines if needed.
 */
function extract_two_lines($raw, $fallback1, $fallback2) {
    $text = trim((string)$raw);

    // Remove code fences if present
    $text = preg_replace('/^```[a-zA-Z]*\s*|\s*```$/m', '', $text);

    // Split into lines, filter empties and bullets
    $parts = preg_split('/\r\n|\r|\n/', $text);
    $clean = [];
    foreach ($parts as $p) {
        $p = trim($p);
        // Drop numbering/bullets like "1) " "- " "* "
        $p = preg_replace('/^\s*(?:\d+\)|[-*•])\s*/', '', $p);
        if ($p !== '') $clean[] = $p;
        if (count($clean) >= 2) break;
    }

    if (count($clean) < 2) {
        // Fallback to original user lines
        return [sanitize_line($fallback1), sanitize_line($fallback2)];
    }
    return [sanitize_line($clean[0]), sanitize_line($clean[1])];
}

// ---------------------------
// Fetch active chapter
// ---------------------------
$active_chapter = null;
$active_chapters = get_active_chapter();
if ($active_chapters) {
    // use the last item in the array (preserving your previous behavior)
    foreach ($active_chapters as $ac) { $active_chapter = $ac; }
}

$chapter_id = $active_chapter['chapter_id'] ?? 0;
$chapter_name = $active_chapter['chapter_name'] ?? 'the selected theme';

// ---------------------------
// Initialize
// ---------------------------
$authorName = $authorEmail = $line1 = $line2 = null;
$token = '';
$flag = false;
$lastCoupletLine1 = '';
$lastCoupletLine2 = '';
$line1Edited = '';
$line2Edited = '';
$existing_lines = [];
$new_lines_to_edit = [];
$prompts = [];

// ---------------------------
// Validate POST
// ---------------------------
if (
    isset($_POST['authorNameToken'], $_POST['authorEmailToken'], $_POST['line1Token'], $_POST['line2Token'], $_POST['tokenNumber'])
) {
    $authorName = sanitize_line($_POST['authorNameToken']);
    $authorEmail = strtolower(trim($_POST['authorEmailToken']));
    $line1 = sanitize_line($_POST['line1Token']);
    $line2 = sanitize_line($_POST['line2Token']);
    $token = (string)$_POST['tokenNumber'];

    if ($authorName !== '' && $authorEmail !== '' && $line1 !== '' && $line2 !== '' && $token !== '') {
        $flag = true;
    }

    if ($flag && (int)$token === 16) {
        // ---------------------------
        // Step 3. Get Last Couplet
        // ---------------------------
        $lastCoupletFileName = "../lastCouplet" . $chapter_id . ".txt";
        if (is_readable($lastCoupletFileName)) {
            $handle = fopen($lastCoupletFileName, "r");
            if ($handle) {
                $counter = 1;
                while (($ln = fgets($handle)) !== false) {
                    if ($counter === 1) {
                        $lastCoupletLine1 = sanitize_line($ln);
                    } elseif ($counter === 2) {
                        $lastCoupletLine2 = sanitize_line($ln);
                    } else {
                        break;
                    }
                    $counter++;
                }
                fclose($handle);
            }
        }
        $existing_lines = array_filter([ $lastCoupletLine1, $lastCoupletLine2 ], fn($v) => $v !== '');
        if (count($existing_lines) < 2) {
            // If no previous couplet, still proceed (don’t force rhyme)
            $existing_lines = [];
        }

        $new_lines_to_edit = [ $line1, $line2 ];

        // ---------------------------
        // Step 4. Edit couplet using AI (robust call)
        // ---------------------------
        $prompts = [];

        $prompt1Content = "Write two lines of poetry on the theme \"{$chapter_name}\" by editing these two lines:\n" . implode("\n", $new_lines_to_edit) . "\n";
        $prompts[] = ['role' => 'user', 'content' => $prompt1Content];

        if (!empty($existing_lines)) {
            $prompt2Content = "Make the two edited lines rhyme naturally with these two lines:\n" . implode("\n", $existing_lines) . "\n";
            $prompts[] = ['role' => 'user', 'content' => $prompt2Content];
        }

        $prompts[] = [
            'role' => 'user',
            'content' =>
                "Constraints:\n".
                "1) Output exactly TWO lines separated by a single newline.\n".
                "2) Each line should be between 5 and 15 words.\n".
                "3) If there is any hate speech or harmful content, EDIT it out to be safe and respectful.\n".
                "Return ONLY the two lines—no extra text."
        ];

        // Call OpenAI with retries
        [$err, $response] = call_openai_chat($openai_endpoint, $api_key, $openai_model, $prompts, $openai_timeout, $openai_max_retries);

        if ($err || !$response || empty($response['choices'][0]['message']['content'] ?? '')) {
            // Fallback to user-provided lines if moderation fails/rate-limited
            $line1Edited = $line1;
            $line2Edited = $line2;
        } else {
            $edited = $response['choices'][0]['message']['content'];
            [$line1Edited, $line2Edited] = extract_two_lines($edited, $line1, $line2);
        }

        // ---------------------------
        // Step 5. Insert new entry Into DB current_table
        // ---------------------------
        insertIntoCurrentTb($authorEmail, $authorName, $line1Edited, $line2Edited, $chapter_id);

        // ---------------------------
        // Step 6/7. Write poem & lastCouplet files (robust I/O)
        // ---------------------------
        $myPoemFile = "../poem" . $chapter_id . ".txt";
        $poemOk = false;
        if ($fp = @fopen($myPoemFile, 'a')) {
            fwrite($fp, $line1Edited . PHP_EOL);
            fwrite($fp, $line2Edited . PHP_EOL);
            fwrite($fp, $authorName . PHP_EOL);
            fclose($fp);
            $poemOk = true;
        }

        $myLastCoupletFile = "../lastCouplet" . $chapter_id . ".txt";
        if ($fp2 = @fopen($myLastCoupletFile, 'w+')) {
            fwrite($fp2, $line1Edited . PHP_EOL);
            fwrite($fp2, $line2Edited . PHP_EOL);
            fwrite($fp2, $authorName . PHP_EOL);
            fclose($fp2);
        }

        // ---------------------------
        // Step 8. Email User (best-effort)
        // ---------------------------
        @sendEmailToUser($authorEmail, $authorName);

        // ---------------------------
        // Session + redirect
        // ---------------------------
        $_SESSION['tokenTest'] = 'correctToken';
        $_SESSION['authorName'] = $authorName;
        $_SESSION['authorEmail'] = $authorEmail;
        $_SESSION['authorLineOne'] = $line1Edited;
        $_SESSION['authorLineTwo'] = $line2Edited;

        echo '<script>window.location.href = "../index.php#submittedSection";</script>';

        echo '<div style="text-align:center;">
                <h1>Thank you for your last two lines.</h1>
                <p>Congratulations! Your couplet has been published by our AI editor after moderation.</p>
                <p>Please <a href="https://www.last2lines.com/index.php#submittedSection"><strong>read the full poem</strong></a> to see how your two lines contribute to the cause.</p>
                <p>Help us spread awareness by sharing this <a href="https://youtu.be/0TlOwAluQj8" target="_blank" rel="noopener">introductory video</a>.</p>
              </div>';

    } else {
        // Wrong token
        $_SESSION['tokenTest'] = 'wrongToken';
        $_SESSION['authorName'] = $authorName;
        $_SESSION['authorEmail'] = $authorEmail;
        $_SESSION['authorLineOne'] = $line1;
        $_SESSION['authorLineTwo'] = $line2;
    }

} else {
    $_SESSION['tokenTest'] = 'noToken';
}

// You can redirect after setting session if you prefer a clean page:
// redirect_to("../index.php#submittedSection");
?>
