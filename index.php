

<?php
$to = "recipient@outlook.com";
$from = "elonmusk@tesla.com";
$subject = "Important Message";
$message = "hello xss.";

$headers = "From: $from" . "\r\n" .
    "Reply-To: $from" . "\r\n" .
    "X-Mailer: PHP/" . phpversion();

$smtpServer = "smtp.example.com";
$smtpPort = 25;
$username = "your_username";
$password = "your_password";

$smtpConn = fsockopen($smtpServer, $smtpPort, $errno, $errstr, 30);
if (!$smtpConn) {
    die("SMTP connection failed: $errstr ($errno)");
}

fputs($smtpConn, "EHLO $smtpServer\r\n");
fputs($smtpConn, "AUTH LOGIN\r\n");
fputs($smtpConn, base64_encode($username) . "\r\n");
fputs($smtpConn, base64_encode($password) . "\r\n");

$recipientList = array(
    "abc1@gmail.com",
    "abc2@outlook.com",
    "abc3@aol.com"
);

foreach ($recipientList as $recipient) {
    fputs($smtpConn, "MAIL FROM: <$from>\r\n");
    fputs($smtpConn, "RCPT TO: <$recipient>\r\n");
    fputs($smtpConn, "DATA\r\n");
    fputs($smtpConn, "Subject: $subject\r\n");
    fputs($smtpConn, "To: $recipient\r\n");
    fputs($smtpConn, "From: $from\r\n");
    fputs($smtpConn, "\r\n");
    fputs($smtpConn, "$message\r\n");
    fputs($smtpConn, ".\r\n");
}

fputs($smtpConn, "QUIT\r\n");
fclose($smtpConn);
?>

