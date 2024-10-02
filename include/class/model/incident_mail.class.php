<?php
$field = "prd_tier_name as cas_prd_tier_id1_name ";
$table = "helpdesk_prd_tier";
$condition = "prd_tier_id = '{$incident["cas_prd_tier_id1"]}'";
$result = $this->db->select($field, $table, $condition);
$rows = $this->db->num_rows($result);
if ($rows > 0) {
	$f_incident = $this->db->fetch_array($result);
	$cas_prd_tier_id1_name = $f_incident["cas_prd_tier_id1_name"];
}

$field = "prd_tier_name as cas_prd_tier_id2_name ";
$condition = "prd_tier_id = '{$incident["cas_prd_tier_id2"]}'";
$result = $this->db->select($field, $table, $condition);
$rows = $this->db->num_rows($result);
if ($rows > 0) {
	$f_incident = $this->db->fetch_array($result);
	$cas_prd_tier_id2_name = $f_incident["cas_prd_tier_id2_name"];
}

$field = "prd_tier_name as cas_prd_tier_id3_name ";
$condition = "prd_tier_id = '{$incident["cas_prd_tier_id3"]}'";
$result = $this->db->select($field, $table, $condition);
$rows = $this->db->num_rows($result);
if ($rows > 0) {
	$f_incident = $this->db->fetch_array($result);
	$cas_prd_tier_id3_name = $f_incident["cas_prd_tier_id3_name"];
}

$mail_incident = $id;
$mail_user_id = user_session::get_user_id();
$mail_admin = user_session::get_Email_admin(); //มาจากตัวแปรใน config.inc ที่เก็บใน session แล้ว
$mail_assigneename = $mail_assignee["mail_assignee_arr1"]; //รับค่ามาจาก incident::mail_getmailassignee()
$mail_to = $mail_assignee["mail_assignee_arr2"]; //รับค่ามาจาก incident::mail_getmailassignee()
$mail_subject_person = $mail_assignee["mail_assignee_arr3"]; //รับค่ามาจาก incident::mail_getmailassignee()
$mail_subject_prm = $mail_assignee["mail_assignee_arr4"];
$mail_reason_status = $mail_assignee["mail_assignee_arr5"];
$mail_user_login = $user_Email; //มาจากตัวแปรใน incident.class
$mail_Date = dateUtil::date_dmyhms2($today);
$mail_Emp = $incident["cus_id"];
$mail_Comp = $incident["cus_company"];
$mail_Tel = $incident["cus_phone"];
$mail_Name = $incident["cus_firstname"] . " " . $incident["cus_lastname"];
$mail_Tel = $incident["cus_phone"];
$mail_Dep = $incident["cus_department"];
$mail_Location = $incident["cus_site"];
$mail_Service = $cas_prd_tier_id1_name . "/ " . $cas_prd_tier_id2_name . "/ " . $cas_prd_tier_id3_name;
$mail_Req = $incident["summary"];
$mail_detail = $incident["notes"];
$mail_Pri = trim($incident["ddpriority_id"]);
$mail_status = $incident["status_id"];
$mail_status_rea = $incident["status_res_id"];

if ($mail_Pri == "1") {
	$mail_Pri = "Critical";
} elseif ($mail_Pri == "2") {
	$mail_Pri = "High";
} elseif ($mail_Pri == "3") {
	$mail_Pri = "Medium";
} elseif ($mail_Pri == "4") {
	$mail_Pri = "Low";
}

$to = $mail_to;
$numMail = explode(",", $to);
$NTO = count($numMail);
$texplode = '';
for ($m = 0; $m < $NTO; $m++) {
	$aM = trim($numMail[$m]);
	if (filter_var($aM, FILTER_VALIDATE_EMAIL)) {
		if ($texplode == '') {
			$texplode =  $numMail[$m];
		} else {
			$texplode = $texplode . ' ,' . $numMail[$m];
		}
	}
}
$to = $texplode;

$subject = "Incident " . $fetch_email["ident_id_run_project"] . " has been " . $mail_subject_prm;
$strVar = "ข้อความภาษาไทย Incident " . $fetch_email["ident_id_run_project"];
$message = '
<table width="716" border="0">
    <tr>
        <th colspan="2" align="left"><strong>เรียน: </strong></th>
        <td width="255" align="left">' . $mail_assigneename . '</td>
        <th width="103" align="left"></th>
        <td width="182" align="left"></td>
    </tr>
    <tr>
        <th colspan="5" align="left">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="2" align="left"><strong>Ticket No: </strong></th>
        <td width="255" align="left">' . $fetch_email["ident_id_run_project"] . '</td>
        <th width="103" align="left"><strong>Date: </strong></th>
        <td width="182" align="left">' . $mail_Date . '</td>
    </tr>
    <tr>
        <th colspan="5" align="left">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="3" align="left"><strong>Request By </strong></th>
        <th width="103" align="left"></th>
        <td width="182" align="left"></td>
    </tr>
    <tr>
        <th width="32" align="left">&nbsp;</th>
        <th width="122" align="left">Emp No:</th>
        <td width="255" align="left">' . $fetch_email["cus_id"] . '</td>
        <th width="103" align="left">Name:</th>
        <td width="182" align="left">' . $mail_Name . '</td>
    </tr>
    <tr>
        <th width="32" align="left">&nbsp;</th>
        <th width="122" align="left">Company:</th>
        <td width="255" align="left">' . $mail_Comp . '</td>
        <th width="103" align="left">Department:</th>
        <td width="182" align="left">' . $mail_Dep . '</td>
    </tr>
    <tr>
        <th width="32" align="left">&nbsp;</th>
        <th width="122" align="left">Phone:</th>
        <td width="255" align="left">' . $fetch_email["cus_phone"] . '</td>
        <th width="103" align="left">Office:</th>
        <td width="182" align="left">' . $fetch_email["cus_office"] . '</td>
    </tr>
    <tr>
        <th colspan="5" align="left">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="2" align="left">Services:</th>
        <td colspan="3" align="left">' . $mail_Service . '</td>
    </tr>
    <tr>
        <th colspan="2" align="left">Summarize:</th>
        <td colspan="3" align="left">' . $mail_Req . '</td>
    </tr>
    <tr>
        <th colspan="2" align="left">Detail:</th>
        <td colspan="3" align="left">' . $mail_detail . '</td>
    </tr>
    <tr>
        <th colspan="5" align="left">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="2" align="left">Priority:</th>
        <td colspan="3" align="left">' . $fetch_email["priority_desc"] . '</td>
    </tr>
    <tr>
        <th colspan="2" align="left">Ticket Status:</th>
        <td colspan="3" align="left">' . $mail_reason_status . '</td>
    </tr>
    <tr>
        <th colspan="2" align="left">Reason Status:</th>
        <td colspan="3" align="left">' . $fetch_email["status_res_desc"] . '</td>
    </tr>
    <tr>
        <th colspan="5" align="left">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="2" align="left">เข้าใช้งานได้ที่นี่</th>
        <td colspan="3" align="left"><a href="https://services.portalnet.co.th" target="_blank">Helpdesk System</a></td>
    </tr>
</table>
';

// $sid = strtoupper(md5(uniqid(time())));
// $header = "From: $mail_admin\r\n";
// $header .= "X-Mailer: PHP/" . phpversion() . "\n";
// $header .= "MIME-Version: 1.0\n";
// $header .= "Content-type: text/html; charset=UTF-8\n";
// $header .= "Content-Transfer-Encoding: 7bit\n\n";
// if (mail($to, $subject, $message, $header)) {
// 	echo 'Complete.';
// } else {
// 	echo 'Incomplete.';
// 	alert_message("Error to sent mail new assigned ,please contact administrator ", "", ERROR_MESSAGE);
// }

/*$host = 'smtp.gmail.com'; // เปลี่ยนเป็น SMTP เซิร์ฟเวอร์ของ Gmail
$username = 'portalnet099@gmail.com'; // เปลี่ยนเป็นอีเมลของคุณ
$password = 'skdx hxwb rzcu uvha'; // ใช้รหัสผ่านแอปแทนรหัสผ่านปกติ
$from = 'portalnet099@gmail.com'; // กำหนดผู้ส่ง
//$to = 'suwat.bch@hotmail.com'; // กำหนดผู้รับ
$body = $message;
//$altbody = '';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

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
    $mail->setFrom($from, 'PTN_Support');
    
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
    //echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
