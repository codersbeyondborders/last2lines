<?php
require(__DIR__ . "/../vendor/autoload.php");
require_once("EmailConstants.php");
require_once("connection.php"); // ensures $connection (mysqli) is available
use Mailgun\Mailgun;

/**
 * Common utility functions for Last2Lines
 * @author Abdul…
 */

// ---------------------------
// Sanitization / Helpers
// ---------------------------

/**
 * Escape a value for MySQLi safely (PHP 7/8 friendly).
 */
function mysql_prep($value) {
    global $connection;
    if (!isset($connection) || !$connection) {
        return $value;
    }
    // get_magic_quotes_gpc() is removed in PHP 8 — ignore it safely
    if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    return mysqli_real_escape_string($connection, $value);
}

function redirect_to($location = null) {
    if ($location) {
        header("Location: {$location}");
        exit;
    }
}

/**
 * Fail loudly with the actual DB error.
 */
function confirm_query($result_set) {
    global $connection;
    if (!$result_set) {
        die("Database query failed: " . mysqli_error($connection));
    }
}

// ---------------------------
// Queries (READ)
// ---------------------------

function get_all_authors() {
    global $connection;
    $q = "SELECT * FROM current_table ORDER BY dateTime";
    $rs = mysqli_query($connection, $q);
    confirm_query($rs);
    return $rs;
}

function checkEmail($email) {
    global $connection;
    $email = strtolower($email);
    $email_esc = mysql_prep($email);
    $q = "SELECT 1 FROM current_table WHERE email = '{$email_esc}' LIMIT 1";
    $rs = mysqli_query($connection, $q);
    if (!$rs) return false;
    return mysqli_num_rows($rs) > 0;
}

function get_author_by_email($email) {
    global $connection;
    $email = strtolower($email);
    $email_esc = mysql_prep($email);
    $q = "SELECT * FROM current_table WHERE email = '{$email_esc}' ORDER BY dateTime";
    $rs = mysqli_query($connection, $q);
    confirm_query($rs);
    return $rs;
}

/**
 * Get last author by dateTime (faster & safer than fetching all).
 */
function get_last_author() {
    global $connection;
    $q = "SELECT * FROM current_table ORDER BY dateTime DESC LIMIT 1";
    $rs = mysqli_query($connection, $q);
    if ($rs && mysqli_num_rows($rs) === 1) {
        return mysqli_fetch_assoc($rs);
    }
    return null;
}

function get_all_author_emails() {
    global $connection;
    $emails = [];
    $q = "SELECT LOWER(email) AS email FROM current_table";
    $rs = mysqli_query($connection, $q);
    if ($rs) {
        while ($row = mysqli_fetch_assoc($rs)) {
            $emails[] = $row['email'];
        }
    }
    return $emails;
}

function check_author_email($email) {
    $email = strtolower($email);
    foreach (get_all_author_emails() as $e) {
        if ($email === $e) return true;
    }
    return false;
}

// ---------------------------
// Mutations (WRITE)
// ---------------------------

function delete_author_by_id($id) {
    global $connection;
    $id = (int)$id;
    $q = "DELETE FROM current_table WHERE id = {$id} LIMIT 1";
    $rs = mysqli_query($connection, $q);
    if (!$rs) return false;
    return mysqli_affected_rows($connection) === 1;
}

function update_author_by_id($id, $name, $line1, $line2, $chapterId) {
    global $connection;
    $id = (int)$id;
    $chapterId = (int)$chapterId;
    $name   = mysql_prep($name);
    $line1  = mysql_prep($line1);
    $line2  = mysql_prep($line2);
    $q = "UPDATE current_table 
          SET name='{$name}', line1='{$line1}', line2='{$line2}', chapter_id={$chapterId}
          WHERE id = {$id}";
    $rs = mysqli_query($connection, $q);
    return (bool)$rs;
}

function insertIntoMasterTb($email, $name, $line1, $line2, $token) {
    global $connection;
    $active_chapter = null;
    $active_chapters = get_active_chapter();
    if ($active_chapters) {
        foreach ($active_chapters as $ac) { $active_chapter = $ac; }
    }
    $active_chapter_id = isset($active_chapter['chapter_id']) ? (int)$active_chapter['chapter_id'] : 0;

    // Use prepared statement (avoids quoting issues)
    $sql = "INSERT INTO master_table (email, name, line1, line2, token, chapter_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($connection, $sql)) {
        $email = strtolower($email);
        $token = (int)$token;
        mysqli_stmt_bind_param($stmt, "ssssii", $email, $name, $line1, $line2, $token, $active_chapter_id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }
    return false;
}

// ---------------------------
// Email routines
// ---------------------------

function sendEmail($email, $name, $line1, $line2) {
    $email = strtolower($email);
    $headers = "From: " . strip_tags(EMAIL_FROM) . "\r\n";
    $headers .= "Reply-To: " . strip_tags(EMAIL_FROM) . "\r\n";
    if (defined('EMAIL_CC') && EMAIL_CC) {
        $headers .= "CC: " . strip_tags(EMAIL_CC) . "\r\n";
    }
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $emailBody = "New submission with following details:<br/>
        Name: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br/>
        Email: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "<br/>
        Line 1: " . htmlspecialchars($line1, ENT_QUOTES, 'UTF-8') . "<br/>
        Line 2: " . htmlspecialchars($line2, ENT_QUOTES, 'UTF-8') . "<br/>";

    // PHP mail fallback (consider SMTP in production)
    @mail(EMAIL_TO, EMAIL_SUBJECT_NEW, $emailBody, $headers);
}

/**
 * Bulk thank-you email to contributors (BCC).
 * NOTE: Large BCC lists may be blocked by hosting. Prefer Mailgun/SMTP in prod.
 */
function sendEmailToUsers($emails) {
    $authorsCount = get_number_of_authors();
    $linesCount = $authorsCount * 2;

    $active_chapter = null;
    $active_chapters = get_active_chapter();
    if ($active_chapters) {
        foreach ($active_chapters as $ac) { $active_chapter = $ac; }
    }
    $chapter = isset($active_chapter['chapter_name']) ? $active_chapter['chapter_name'] : 'our campaign';

    $to = "last2lines@gmail.com";
    $subject = "Thank You For Your Two Lines For: " . $chapter;

    $message = "<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Thank You For Your Two Lines</title>
<style>body{font-family:Arial,sans-serif;line-height:1.6;background:#f5f5f5;color:#333;margin:0;padding:20px}p{margin-bottom:10px}h1,h4,h6{margin:5px 0}a{color:#4285f4;text-decoration:none}a:hover{text-decoration:underline}hr{border:0;height:1px;background:#ddd;margin:20px 0}small{font-size:10px;color:#888}.counter-section{background:#333;color:#fff;padding:50px;border-radius:5px;text-align:center;display:flex;justify-content:space-around}.counter-column{flex:1}</style>
</head>
<body>
<p>Dear Participant,</p>
<p>Thank you for contributing your two lines for the poem: " . htmlspecialchars($chapter, ENT_QUOTES, 'UTF-8') . ". We are pleased to inform you that your couplet has been published and is now part of the complete poem. This proves that we can all be poets, at least for once, at least for a cause.</p>
<p>Please take a moment to <a href='https://www.last2lines.com/fullPoem.php' target='_blank' rel='noopener'>read the full poem</a> and see how your two lines have contributed to the cause.</p>
<hr/>
<h2 style='text-align:center;'>Thanks to your contribution we have reached</h2>
<div class='counter-section'>
  <div class='counter-column'><h1>{$authorsCount}</h1><h4>AUTHORS</h4></div>
  <div class='counter-column'><h1>{$linesCount}</h1><h4>LINES</h4></div>
  <div class='counter-column'><h1 style=\"text-align:center;\">and still counting ...</h1></div>
</div>
<h2 style='text-align:center;'>We are on our way to write the LONGEST POEM on " . htmlspecialchars($chapter, ENT_QUOTES, 'UTF-8') . "</h2>
<hr/>
<p>Your contribution is highly valuable because every voice matters, every verse counts.</p>
<p>Together, we can shape the narrative, one verse at a time.</p>
<p>Thank you,<br/><strong><a href='https://www.last2lines.com'>Team Last2Lines</a></strong><br/>
<a href='https://www.facebook.com/last2lines'><i>facebook.com/last2lines</i></a><br/>
<a href='https://twitter.com/last2lines'><i>twitter.com/last2lines</i></a></p>
<hr/>
<small>Last2Lines.com is primarily about poetry and should not in any case be deemed as a political opinion. Any inclination whatsoever towards or against any political school of thought is the contributor's own opinion and imagination and does not represent the opinion or affinity of Last2Lines.com</small>
</body></html>";

    $bcc = implode(", ", array_map('trim', $emails));

    $headers = "From: last2lines@gmail.com\r\n";
    $headers .= "Reply-To: last2lines@gmail.com\r\n";
    if (!empty($bcc)) $headers .= "Bcc: {$bcc}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    @mail($to, $subject, $message, $headers);
}

function get_number_of_authors() {
    global $connection;
    $active_chapter = null;
    $active_chapters = get_active_chapter();
    if ($active_chapters) {
        foreach ($active_chapters as $ac) { $active_chapter = $ac; }
    }
    $active_chapter_id = isset($active_chapter['chapter_id']) ? (int)$active_chapter['chapter_id'] : 0;
    $q = "SELECT 1 FROM current_table WHERE chapter_id = {$active_chapter_id}";
    $rs = mysqli_query($connection, $q);
    return $rs ? mysqli_num_rows($rs) : 0;
}

function IDcheckIfExists($id) {
    global $connection;
    $id = (int)$id;
    $q = "SELECT 1 FROM current_table WHERE id = {$id} LIMIT 1";
    $rs = mysqli_query($connection, $q);
    return ($rs && mysqli_num_rows($rs) === 1);
}

// Users table helpers

function checkTokenEmail($email) {
    global $connection;
    $email = strtolower($email);
    $email_esc = mysql_prep($email);
    $q = "SELECT 1 FROM users WHERE email = '{$email_esc}' LIMIT 1";
    $rs = mysqli_query($connection, $q);
    return ($rs && mysqli_num_rows($rs) === 1);
}

function authenticateToken($email, $token) {
    global $connection;
    $email = strtolower($email);
    $email_esc = mysql_prep($email);
    $token = (int)$token;
    $q = "SELECT 1 FROM users WHERE email = '{$email_esc}' AND token = {$token} LIMIT 1";
    $rs = mysqli_query($connection, $q);
    return ($rs && mysqli_num_rows($rs) === 1);
}

function get_token_by_email($email) {
    global $connection;
    $email = strtolower($email);
    $email_esc = mysql_prep($email);
    $q = "SELECT * FROM users WHERE email = '{$email_esc}'";
    $rs = mysqli_query($connection, $q);
    confirm_query($rs);
    return $rs;
}

function generateToken($digits = 4) {
    $token = "";
    for ($i = 0; $i < $digits; $i++) {
        $token .= mt_rand(0, 9);
    }
    return $token;
}

function insertIntoUsersTb($email, $token) {
    global $connection;
    $email = strtolower($email);
    $sql = "INSERT INTO users (email, token) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($connection, $sql)) {
        $token = (int)$token;
        mysqli_stmt_bind_param($stmt, "si", $email, $token);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }
    return false;
}

/**
 * Modern Mailgun send (uses API key from env if present).
 */
function sendEmailToken($authorName, $authorEmail, $token) {
    $apiKey = getenv('MAILGUN_API_KEY'); // put this in your hosting env
    $domain = getenv('MAILGUN_DOMAIN') ?: "mail.last2lines.com";

    $subject = "Last2Lines - Your Token is {$token}";
    $msg = "Hi " . htmlspecialchars($authorName, ENT_QUOTES, 'UTF-8') . ",<br>
            Welcome to Last2Lines!<br><br>
            <h3>Your Token: <strong>" . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . "</strong></h3>
            Please use the same for all future submissions.<br><br>
            Regards,<br>Team Last2Lines<br>
            <a href='https://www.last2lines.com'>www.last2lines.com</a>";

    if ($apiKey) {
        // Use Mailgun SDK if configured
        $mg = Mailgun::create($apiKey);
        try {
            $mg->messages()->send($domain, [
                'from'    => EMAIL_FROM,
                'to'      => $authorEmail,
                'subject' => $subject,
                'html'    => $msg,
            ]);
        } catch (\Throwable $e) {
            // Fallback to PHP mail if Mailgun fails
            $headers = "From: " . EMAIL_FROM . "\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n";
            @mail($authorEmail, $subject, $msg, $headers);
        }
    } else {
        // No API key — fallback to PHP mail
        $headers = "From: " . EMAIL_FROM . "\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\n";
        @mail($authorEmail, $subject, $msg, $headers);
    }
}

// ---------------------------
// Chapters / Poems
// ---------------------------

function get_active_chapter() {
    global $connection;
    $q = "SELECT * FROM chapter_table WHERE active = 1 LIMIT 1";
    $rs = mysqli_query($connection, $q);
    return $rs; // caller iterates and grabs the single row
}

function authenticateCoupletChapterID($coupletID, $chapterID) {
    global $connection;
    $coupletID = (int)$coupletID;
    $chapterID = (int)$chapterID;
    $q = "SELECT chapter_id FROM current_table WHERE id = {$coupletID} LIMIT 1";
    $rs = mysqli_query($connection, $q);
    if ($rs && ($row = mysqli_fetch_assoc($rs))) {
        return ((int)$row['chapter_id'] === $chapterID);
    }
    return false;
}

function authenticateChapterID($chapterID) {
    global $connection;
    $chapterID = (int)$chapterID;
    $q = "SELECT 1 FROM chapter_table WHERE chapter_id = {$chapterID} LIMIT 1";
    $rs = mysqli_query($connection, $q);
    return ($rs && mysqli_num_rows($rs) === 1);
}

function getAllChapters() {
    global $connection;
    $q = "SELECT * FROM chapter_table";
    $rs = mysqli_query($connection, $q);
    return $rs ?: null;
}

function getAllCoupletsByChapter($chapter_id) {
    global $connection;
    $chapter_id = (int)$chapter_id;
    $q = "SELECT * FROM current_table WHERE chapter_id = {$chapter_id} ORDER BY dateTime ASC";
    $rs = mysqli_query($connection, $q);
    confirm_query($rs);
    return $rs;
}

function getFirst2Couplets($chapter_id) {
    global $connection;
    $chapter_id = (int)$chapter_id;
    $q = "SELECT * FROM current_table WHERE chapter_id = {$chapter_id} ORDER BY dateTime ASC LIMIT 2";
    $rs = mysqli_query($connection, $q);
    $out = [];
    if ($rs) {
        while (($row = mysqli_fetch_assoc($rs)) && count($out) < 2) {
            $out[] = $row;
        }
    }
    return $out;
}

function getChapterById($chapterID) {
    global $connection;
    $chapterID = (int)$chapterID;
    $q = "SELECT * FROM chapter_table WHERE chapter_id = {$chapterID} LIMIT 1";
    $rs = mysqli_query($connection, $q);
    if ($rs && mysqli_num_rows($rs) === 1) {
        return mysqli_fetch_assoc($rs);
    }
    return null;
}

function getChapterNamebyId($chapterID) {
    $row = getChapterById($chapterID);
    return $row ? $row['chapter_name'] : null;
}

function getEntriesCountFromChapter($chapterId) {
    global $connection;
    $chapterId = (int)$chapterId;
    $q = "SELECT 1 FROM current_table WHERE chapter_id = {$chapterId}";
    $rs = mysqli_query($connection, $q);
    return $rs ? mysqli_num_rows($rs) : 0;
}

function activateChapter($chapterIdToActivate) {
    global $connection;
    $chapterIdToActivate = (int)$chapterIdToActivate;
    $q1 = "UPDATE chapter_table SET active = 1 WHERE chapter_id = {$chapterIdToActivate}";
    $r1 = mysqli_query($connection, $q1);
    if (!$r1) return false;
    $q2 = "UPDATE chapter_table SET active = 0 WHERE chapter_id <> {$chapterIdToActivate}";
    $r2 = mysqli_query($connection, $q2);
    return (bool)$r2;
}

function getEntriesByChapter($chapterId) {
    global $connection;
    $chapterId = (int)$chapterId;
    $q = "SELECT * FROM current_table WHERE chapter_id = {$chapterId} ORDER BY dateTime";
    $rs = mysqli_query($connection, $q);
    confirm_query($rs);
    return $rs;
}

// ---------------------------
// Search helpers
// ---------------------------

function searchTest($key, $chid) {
    global $connection;
    $chid = (int)$chid;
    $key_esc = mysql_prep($key);
    $sql = "SELECT name FROM current_table WHERE chapter_id = {$chid} AND name LIKE '%{$key_esc}%'";
    $result_set = mysqli_query($connection, $sql);

    $array = [];
    if ($result_set) {
        while ($row = mysqli_fetch_assoc($result_set)) {
            $array[] = [
                'label' => $row['name'],
                'value' => $row['name'],
            ];
        }
    }
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($array);
}

function searchDisplay($key, $CHID) {
    global $connection;
    $CHID = (int)$CHID;
    $key_esc = mysql_prep($key);
    $sql = "SELECT line1, line2, name, id 
            FROM current_table 
            WHERE chapter_id = {$CHID} AND name LIKE '%{$key_esc}%'";
    $result_set = mysqli_query($connection, $sql);

    $data = "";
    if ($result_set) {
        while ($row = mysqli_fetch_assoc($result_set)) {
            $data .= htmlspecialchars($row['line1'], ENT_QUOTES, 'UTF-8') . "<br/>";
            $data .= htmlspecialchars($row['line2'], ENT_QUOTES, 'UTF-8') . "<br/>";
            $data .= "<strong>" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "</strong><br/><br/>";
        }
    }
    return $data;
}
?>
