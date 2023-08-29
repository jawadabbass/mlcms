<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

function sendMailThroughSMTP($postArray)
{
    $to_name = $to_email = $from_name = $from_email = $cc_name = $cc_email = $bcc_name = $bcc_email = $subject = $message = '';

    $to_name = $postArray['to_name'];
    $to_email = $postArray['to_email'];

    $from_name = $postArray['from_name'];
    $from_email = $postArray['from_email'];

    if (
        (isset($postArray['cc_name']) && !empty($postArray['cc_name'])) &&
        (isset($postArray['cc_email']) && !empty($postArray['cc_email']))
    ) {
        $cc_name = $postArray['cc_name'];
        $cc_email = $postArray['cc_email'];
    }
    if (
        (isset($postArray['bcc_name']) && !empty($postArray['bcc_name'])) &&
        (isset($postArray['bcc_email']) && !empty($postArray['bcc_email']))
    ) {
        $bcc_name = $postArray['bcc_name'];
        $bcc_email = $postArray['bcc_email'];
    }
    $subject = $postArray['subject'];
    $message = '<html><head><title>ML Email Testing</title></head><body><p><strong>Details:</strong></p><p>' . $postArray['message'] . '</p></body></html>';

    $mail = new PHPMailer;
    $mail->isHTML();

    if ($_POST['send_with'] == 'mail') {
        $mail->isMail();
    } elseif ($_POST['send_with'] == 'smtp') {
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        $mail->SMTPSecure = $postArray['smtp_encryption'];
        $mail->SMTPAuth = true;
        $mail->Host = $postArray['smtp_host'];
        $mail->Port = $postArray['smtp_port'];
    }

    $mail->Username = $postArray['smtp_username'];
    $mail->Password = $postArray['smtp_password'];
    $mail->setFrom($from_email, $from_name);
    $mail->addReplyTo($from_email, $from_name);
    $mail->addAddress($to_email, $to_name);
    if (!empty($cc_email)) {
        $mail->addCC($cc_email, $cc_name);
    }
    if (!empty($bcc_email)) {
        $mail->addBCC($bcc_email, $bcc_name);
    }

    $mail->Subject = $subject;
    $mail->msgHTML($message);
    $mail->Body = $message;
    //$mail->addAttachment('attachment.txt');
    if (!$mail->send()) {
        $_SESSION['msg'] = 'Mailer Error: ' . $mail->ErrorInfo;
        $_SESSION['msg_type'] = 'danger';
    } else {
        $_SESSION['msg'] = 'Mail sent successfully!';
        $_SESSION['msg_type'] = 'success';
    }
}
function sendEmail($postArray)
{
    $to = $from = $cc = $bcc = $subject = $message = '';
    $to = $postArray['to_name'] . ' <' . $postArray['to_email'] . '>';
    $from = $postArray['from_name'] . ' <' . $postArray['from_email'] . '>';
    if (
        (isset($postArray['cc_name']) && !empty($postArray['cc_name'])) &&
        (isset($postArray['cc_email']) && !empty($postArray['cc_email']))
    ) {
        $cc = $postArray['cc_name'] . ' <' . $postArray['cc_email'] . '>';
    }
    if (
        (isset($postArray['bcc_name']) && !empty($postArray['bcc_name'])) &&
        (isset($postArray['bcc_email']) && !empty($postArray['bcc_email']))
    ) {
        $bcc = $postArray['bcc_name'] . ' <' . $postArray['bcc_email'] . '>';
    }
    $subject = $postArray['subject'];
    $message = '<html><head><title>ML Email Testing</title></head><body><p><strong>Details:</strong></p><p>' . $postArray['message'] . '</p></body></html>';
    $headers['MIME-Version'] = '1.0';
    $headers['Content-type'] = 'text/html; charset=utf-8';
    $headers['From'] = $from;
    $headers['Reply-To'] = $from;
    if (!empty($cc)) {
        $headers['Cc'] = $cc;
    }
    if (!empty($bcc)) {
        $headers['Bcc'] = $bcc;
    }
    $headers['X-Mailer'] = 'PHP/' . phpversion();
    if (mail($to, $subject, $message, $headers)) {
        $_SESSION['msg'] = 'Mail sent successfully!';
        $_SESSION['msg_type'] = 'success';
    } else {
        $_SESSION['msg'] = 'PHP Mail Function failed!';
        $_SESSION['msg_type'] = 'danger';
    }
}
