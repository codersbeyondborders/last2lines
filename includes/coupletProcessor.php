<?php require_once("functions.php"); ?>
<?php require_once("connection.php"); ?>
<?php require_once("session.php"); ?>

<?php
// ---------------------------
// Config
// ---------------------------
$api_key = getenv('OPENAI_API_KEY') ?: 'XYZ'; // set real key in hosting panel
$openai_endpoint = 'https://api.openai.com/v1/chat/completions';
$openai_model_primary = 'gpt-4o-mini';     // try this first
$openai_model_fallback = 'gpt-3.5-turbo';  // fallback if primary is unavailable
$openai_timeout = 20;                      // seconds
$openai_max_retries = 3;

// ---------------------------
// Session defaults
// ---------------------------
$_SESSION['tokenTest']     = '';
$_SESSION['authorName']    = '';
$_SESSION['authorEmail']   = '';
$_SESSION['authorLineOne'] = '';
$_SESSION['authorLineTwo'] = '';

// ---------------------------
// Helpers
// ---------------------------
function sanitize_line($s) {
    $s = trim((string)$s);
    $s = preg_replace('/\s+/u', ' ', $s);
    return $s;
}

/**
 * Robust OpenAI call with cURL, retries, backoff, Retry-After support.
 */
function call_openai_chat($endpoint, $api_key, $model, $messages, $timeout = 20, $max_retries = 3) {
    $payload = array(
        'model' => $model,
        'temperature' => 0.1,
        'max_tokens' => 60,
        'n' => 1,
        'messages' => $messages,
    );

    $attempt = 0;
    $backoff = 2; // seconds
    $lastErr = null;

    while ($attempt < $max_retries) {
        $attempt++;

        $raw_headers = array();
        $header_fn = function ($ch, $header_line) use (&$raw_headers) {
            $len = strlen($header_line);
            $parts = explode(':', $header_line, 2);
            if (count($parts) == 2) {
                $raw_headers[strtolower(trim($parts[0]))] = trim($parts[1]);
            }
            return $len;
        };

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            ),
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HEADERFUNCTION => $header_fn,
        ));

        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_err  = curl_error($ch);
        curl_close($ch);

        if ($curl_err) {
            $lastErr = "cURL error: $curl_err";
        } else {
            if ($http_code >= 200 && $http_code < 300) {
                $decoded = json_decode($result, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return array(null, $decoded);
                }
                $lastErr = 'JSON decode error: ' . json_last_error_msg();
            } elseif ($http_code == 429 || ($http_code >= 500 && $http_code <= 599)) {
                // Rate-limit / server error — respect Retry-After if present
                $retry_after = 0;
                if (isset($raw_headers['retry-after'])) {
                    $retry_after = (int)$raw_headers['retry-after'];
                }
                $sleep_for = max($retry_after, $backoff);
                sleep($sleep_for);
                $backoff = min($backoff * 2, 16);
                continue;
            } else {
                $lastErr = "HTTP $http_code: $result";
            }
        }

        if ($attempt < $max_retries) {
            sleep($backoff);
            $backoff = min($backoff * 2, 16);
        }
    }
    return array($lastErr ?: 'Unknown error contacting OpenAI', null);
}

/**
 * Extract two lines; fall back to user lines if needed.
 */
function extract_two_lines($raw, $fallback1, $fallback2) {
    $text = trim((string)$raw);
    $text = preg_replace('/^```[a-zA-Z]*\s*|\s*```$/m', '', $text);

    $parts = preg_split('/\r\n|\r|\n/', $text);
    $clean = array();
    foreach ($parts as $p) {
        $p = trim($p);
        $p = preg_replace('/^\s*(?:\d+\)|[-*•])\s*/', '', $p);
        if ($p !== '') $clean[] = $p;
        if (count($clean) >= 2) break;
    }

    if (count($clean) < 2) {
        return array(sanitize_line($fallback1), sanitize_line($fallback2));
    }
    return array(sanitize_line($clean[0]), sanitize_line($clean[1]));
}

// ---------------------------
// Fetch active chapter
// ---------------------------
$active_chapter = null;
$active_chapters = get_active_chapter();
if ($active_chapters) {
    foreach ($active_chapters as $ac) { $active_chapter = $ac; }
}
$chapter_id   = isset($active_chapter['chapter_id']) ? $active_chapter['chapter_id'] : 0;
$chapter_name = isset($active_chapter['chapter_name']) ? $active_chapter['chapter_name'] : 'the selected theme';

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
$existing_lines = array();
$new_lines_to_edit = array();
$prompts = array();

// ---------------------------
// Validate POST
// ---------------------------
if (
    isset($_POST['authorNameToken'], $_POST['authorEmailToken'], $_POST['line1Token'], $_POST['line2Token'], $_POST['tokenNumber'])
) {
    $authorName  = sanitize_line($_POST['authorNameToken']);
    $authorEmail = strtolower(trim($_POST['authorEmailToken']));
    $line1       = sanitize_line($_POST['line1Token']);
    $line2       = sanitize_line($_POST['line2Token']);
    $token       = (string)$_POST['tokenNumber'];

    if ($authorName !== '' && $authorEmail !== '' && $line1 !== '' && $line2 !== '' && $token !== '') {
        $flag = true;
    }

    if ($flag && (int)$token === 16) {
        // ---------------------------
        // Step 3. Last couplet
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
        $existing_lines = array();
        if ($lastCoupletLine1 !== '') $existing_lines[] = $lastCoupletLine1;
        if ($lastCoupletLine2 !== '') $existing_lines[] = $lastCoupletLine2;
        if (count($existing_lines) < 2) $existing_lines = array(); // don't force rhyme if missing

        $new_lines_to_edit = array($line1, $line2);

        // ---------------------------
        // Step 4. AI editing (with safe fallbacks)
        // ---------------------------
        $prompts = array();

        $prompt1Content = "Write two lines of poetry on the theme \"{$chapter_name}\" by editing these two lines:\n" . implode("\n", $new_lines_to_edit) . "\n";
        $prompts[] = array('role' => 'user', 'content' => $prompt1Content);

        if (!empty($existing_lines)) {
            $prompt2Content = "Make the two edited lines rhyme naturally with these two lines:\n" . implode("\n", $existing_lines) . "\n";
            $prompts[] = array('role' => 'user', 'content' => $prompt2Content);
        }

        $prompts[] = array(
            'role' => 'user',
            'content' =>
                "Constraints:\n".
                "1) Output exactly TWO lines separated by a single newline.\n".
                "2) Each line should be between 5 and 15 words.\n".
                "3) If there is any hate speech or harmful content, EDIT it out to be safe and respectful.\n".
                "Return ONLY the two lines—no extra text."
        );

        // If API key missing or placeholder, skip calling API
        $edited = '';
        if ($api_key && $api_key !== 'XYZ') {
            // Try primary model
            list($err, $response) = call_openai_chat($openai_endpoint, $api_key, $openai_model_primary, $prompts, $openai_timeout, $openai_max_retries);
            if ($err || !$response || empty($response['choices'][0]['message']['content'])) {
                // Try fallback model once
                list($err2, $response2) = call_openai_chat($openai_endpoint, $api_key, $openai_model_fallback, $prompts, $openai_timeout, $openai_max_retries);
                if (!$err2 && $response2 && !empty($response2['choices'][0]['message']['content'])) {
                    $edited = $response2['choices'][0]['message']['content'];
                }
            } else {
                $edited = $response['choices'][0]['message']['content'];
            }
        }

        if ($edited === '') {
            // Fallback to user-provided lines if moderation fails/rate-limited/no key
            $line1Edited = $line1;
            $line2Edited = $line2;
        } else {
            list($line1Edited, $line2Edited) = extract_two_lines($edited, $line1, $line2);
        }

        // ---------------------------
        // Step 5. DB insert
        // ---------------------------
        insertIntoCurrentTb($authorEmail, $authorName, $line1Edited, $line2Edited, $chapter_id);

        // ---------------------------
        // Step 6/7. Write poem & lastCouplet files
        // ---------------------------
        $myPoemFile = "../poem" . $chapter_id . ".txt";
        if ($fp = @fopen($myPoemFile, 'a')) {
            fwrite($fp, $line1Edited . PHP_EOL);
            fwrite($fp, $line2Edited . PHP_EOL);
            fwrite($fp, $authorName . PHP_EOL);
            fclose($fp);
        }

        $myLastCoupletFile = "../lastCouplet" . $chapter_id . ".txt";
        if ($fp2 = @fopen($myLastCoupletFile, 'w+')) {
            fwrite($fp2, $line1Edited . PHP_EOL);
            fwrite($fp2, $line2Edited . PHP_EOL);
            fwrite($fp2, $authorName . PHP_EOL);
            fclose($fp2);
        }

        // ---------------------------
        // Step 8. Email (best-effort)
        // ---------------------------
        @sendEmailToUser($authorEmail, $authorName);

        // ---------------------------
        // Session + redirect
        // ---------------------------
        $_SESSION['tokenTest']     = 'correctToken';
        $_SESSION['authorName']    = $authorName;
        $_SESSION['authorEmail']   = $authorEmail;
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
        $_SESSION['tokenTest']     = 'wrongToken';
        $_SESSION['authorName']    = $authorName;
        $_SESSION['authorEmail']   = $authorEmail;
        $_SESSION['authorLineOne'] = $line1;
        $_SESSION['authorLineTwo'] = $line2;
    }

} else {
    $_SESSION['tokenTest'] = 'noToken';
}

// redirect_to("../index.php#submittedSection");
?>
