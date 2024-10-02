<?php

						$to = $incident["owner_user_email"];
						$sum = $incident["summary"];
						$encodeid = base64_encode($incident["id"]);
						$link = "http://localhost/helpdesk/v.1/incident/evaluation?incident_id=".$encodeid;
						//$to = 'coconut_wang@icloud.com';
						//$to = 'coconut.som@gmail.com';
						//$subject = "Incident ".$mail_incident." has been assigned to your/subgroup";
						//$message = "Ticket No: ".$mail_incident."&#09";
						$subject = "=?UTF-8?B?".base64_encode("Evaluation : (e-Form) $sum")."?=";
						$strVar = "ข้อความภาษาไทย Incident ".$mail_incident;
						$message = '
<table  width="716" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td colspan="2">เรียน ท่านผู้ขอใช้บริการระบบ Helpdesk</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="37">&nbsp;</td>
    <td width="672">&nbsp;&nbsp;&nbsp;&nbsp;ฝ่าย Corporate IT ขอเรียนแจ้งให้ท่านทราบว่า การขอใช้บริการทางด้านระบบ Helpdesk ของท่าน เจ้าหน้าที่ฝ่าย Corporate IT ได้ดำเนินการตามที่ท่านแจ้งขอใช้บริการเสร็จเรียบร้อยแล้ว และเพื่อเป็นการนำข้อมูลจากผู้ขอใช้บริการไปพัฒนาและเพิ่มประสิทธิภาพการให้บริการดียิ่ง ๆ ขึ้น ฝ่ายฯ ใคร่ขอความร่วมมือจากผู้ขอใช้ บริการทุกท่าน ช่วยทำการประเมินผลการให้บริการของทีมงาน</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>กรุณา click link ด้านล่าง หรือ copy link วางที่ Internet Browser แล้วกดปุ่ม Enter
<a href="'.$link.'">'.$link.'</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อทราบ และ ขอขอบพระคุณอย่างสูงในการใช้บริการ หากท่านมีข้อสงสัย หรือ ต้องการสอบถามรายละเอียดเพิ่มเติม สามารถติดต่อได้ที่เบอร์โทรหมายเลข 8654(ภายใน) หรือ 02-5026000 ต่อ8654(ภายนอก)ได้ตลอด 24 ชั่วโมง หรือ ส่ง eMail มาที่ Helpline@samartcorp.com</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">หมายเหตุ : Ticket การขอใช้บริการของท่านหมายเลข :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Corporate Information Technology Department<br />
    Tel : 8654 (Internal), 0-2502-6000 Ext. 8654 (External) </td>
  </tr>
</table>
						';
						
						 
						$header = "MIME-Version: 1.0\r\n" ;
						$header .= "Content-type: text/html; charset=UTF-8\r\n" ;
						//$header .= "From: no-reply@mailserver.com\r\n" ;
						$header .= "From: Helpdesk@mailserver.com\r\n" ;
						 
						if( @mail( $to , $subject , $message , $header ) ){ 
							//echo 'Complete.';
						}else{
							//echo 'Incomplete.';
                                                        alert_message("Error to sent mail new assigned ,please contact administrator ", "", ERROR_MESSAGE);
//							alert_message(alert_message("Error!! Sent mail new assigned ,please contact Somwang"));
							return false;
						}
?>