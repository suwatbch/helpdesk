<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

$host = 'services.portalnet.co.th'; // เปลี่ยนเป็น SMTP เซิร์ฟเวอร์ของ Gmail
$username = 'ptn_admin@services.portalnet.co.th'; // เปลี่ยนเป็นอีเมลของคุณ
$password = 'K3yp6u25$'; // ใช้รหัสผ่านแอปแทนรหัสผ่านปกติ
$from = 'ptn_support@portalnet.co.th'; // กำหนดผู้ส่ง
$to = 'savake.b@portalnet.co.th,savake@gmail.com'; // กำหนดผู้รับ
$subject = 'xทดสอบการส่งเมล';
$body = 'สวัสดี ทุกท่าน ขออนุญาติทดสอบส่งเมล';
//$altbody = 'ส่วนนี้น่าจะเป็นรายละเอียด ของเมลย์';

try {
    // Server settings
    $mail->isSMTP();
    $mail->CharSet = "utf-8";
    $mail->SMTPAuth = true;
    $mail->Host = $host; 
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom($from, 'Mailer');
    
    // แยกอีเมลผู้รับและเพิ่มผู้รับทีละคน
    $recipients = explode(',', $to);
    foreach ($recipients as $recipient) {
        $mail->addAddress(trim($recipient));
    }

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;
    //$mail->AltBody = $altbody;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
