<?php
$field = "prd_tier_name as resol_prd_tier_id1_name ";
$table = "helpdesk_prd_tier";
$condition = "prd_tier_id = '{$incident["resol_prdtier1"]}'";
$result = $this->db->select($field, $table, $condition);
$rows = $this->db->num_rows($result);
if($rows > 0){
$f_incident = $this->db->fetch_array($result);
$resol_prd_tier_id1_name = $f_incident["resol_prd_tier_id1_name"];
}

$field = "prd_tier_name as resol_prd_tier_id2_name ";
$table = "helpdesk_prd_tier";
$condition = "prd_tier_id = '{$incident["resol_prdtier2"]}'";
$result = $this->db->select($field, $table, $condition);
$rows = $this->db->num_rows($result);
if($rows > 0){
$f_incident = $this->db->fetch_array($result);
$resol_prd_tier_id2_name = $f_incident["resol_prd_tier_id2_name"];
}

$field = "prd_tier_name as resol_prd_tier_id3_name ";
$table = "helpdesk_prd_tier";
$condition = "prd_tier_id = '{$incident["resol_prdtier3"]}'";
$result = $this->db->select($field, $table, $condition);
$rows = $this->db->num_rows($result);
if($rows > 0){
$f_incident = $this->db->fetch_array($result);
$resol_prd_tier_id3_name = $f_incident["resol_prd_tier_id3_name"];
}

$mail_incident 	= $id;
$mail_user_id 	= user_session::get_user_id();
$mail_admin 	= user_session::get_Email_admin();		 //มาจากตัวแปรใน config.inc ที่เก็บใน session แล้ว
$mail_to 		= $mail_assignee["mail_assignee_arr2"];  //รับค่ามาจาก incident::mail_getmailassignee()
$mail_user_login = $user_Email; 						 //มาจากตัวแปรใน incident.class
$mail_Date 		= dateUtil::date_dmyhms2($today);
$mail_Emp 		= $incident["cus_id"];
$mail_Comp 		= $incident["cus_company"];
$mail_Tel 		= $incident["cus_phone"];
$mail_Name 		= $incident["cus_firstname"]." ".$incident["cus_lastname"];
$mail_Tel 		= $incident["cus_phone"];
$mail_Dep 		= $incident["cus_department"];
$mail_Location 	= $incident["cus_site"];
$mail_Service 	= $resol_prd_tier_id1_name."/ ".$resol_prd_tier_id2_name."/ ".$resol_prd_tier_id3_name;
$mail_Req 		= $incident["summary"];
$mail_detail            = $incident["notes"];
$mail_Pri 		= trim($incident["ddpriority_id"]); 
$mail_status 	= $incident["status_id"];
$mail_status_rea = $incident["status_res_id"];

if($mail_Pri == "1"){		$mail_Pri = "Critical";
}elseif($mail_Pri == "2"){	$mail_Pri = "High";
}elseif($mail_Pri == "3"){	$mail_Pri = "Medium";
}elseif($mail_Pri == "4"){	$mail_Pri = "Low";	}

if($mail_status_rea == "9"){ 		$mail_status_rea = "No Contact";
}elseif($mail_status_rea == "10"){	$mail_status_rea = "Compleated";
}elseif($mail_status_rea == "11"){	$mail_status_rea = "By Problem";
}elseif($mail_status_rea == "12"){	$mail_status_rea = "Cancelled";	}

//echo $mail_Service;
//exit;

						$to = $mail_to;
						//$to = 'somwang@mailserver.com';
						//$to = 'coconut_wang@icloud.com';
						//$to = 'coconut.som@gmail.com';
						$subject = "=?UTF-8?B?".base64_encode("Incident ".$fetch_email["ident_id_run_project"]." has been sent Propose Closed to you")."?=";
						$strVar = "ข้อความภาษาไทย Incident ".$fetch_email["ident_id_run_project"];
						$message = '<table width="716" border="0">
							<tr>
								<th colspan="2" align="left"><strong>เรียน: </strong></th>
								<td width="255" align="left">'.$mail_assignee["mail_assignee_arr1"].'</td>
								<th width="103" align="left"></th>
								<td width="182" align="left"></td>
							</tr>
							<tr>
								<th colspan="5" align="left">&nbsp;</th>
							</tr>
							<tr>
								<th colspan="2" align="left"><strong>Ticket No: </strong></th>
								<td width="255" align="left">'.$fetch_email["ident_id_run_project"].'</td>
								<th width="103" align="left"><strong>Date: </strong></th>
								<td width="182" align="left">'.$mail_Date.'</td>
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
								<td width="255" align="left">'.$fetch_email["cus_id"].'</td>
								<th width="103" align="left">Name:</th>
								<td width="182" align="left">'.$mail_Name.'</td>
							</tr>
							<tr>
								<th width="32" align="left">&nbsp;</th>
								<th width="122" align="left">Company:</th>
								<td width="255" align="left">'.$mail_Comp.'</td>
								<th width="103" align="left">Department:</th>
								<td width="182" align="left">'.$mail_Dep.'</td>
							</tr>
							<tr>
								<th width="32" align="left">&nbsp;</th>
								<th width="122" align="left">Phone :</th>
								<td width="255" align="left">'.$fetch_email["cus_phone"].'</td>
								<th width="103" align="left">Office:</th>
								<td width="182" align="left">'.$fetch_email["cus_office"].'</td>
							</tr>
							<tr>
								<th colspan="5" align="left">&nbsp;</th>
							</tr>
							<tr>
								<th colspan="2" align="left">Services:</th>
								<td colspan="3" align="left">'.$mail_Service.'</td>
							</tr>
							<tr>
								<th colspan="2" align="left">Summarize:</th>
								<td colspan="3" align="left">'.$mail_Req.'</td>
							</tr>
                                                        <tr>
								<th colspan="2" align="left">Detail:</th>
								<td colspan="3" align="left">'.$mail_detail.'</td>
							</tr>
							<tr>
								<th colspan="5" align="left">&nbsp;</th>
							</tr>
							<tr>
								<th colspan="2" align="left">Priority:</th>
								<td colspan="3" align="left">'.$fetch_email["priority_desc"].'</td>
							</tr>
							<tr>
								<th colspan="2" align="left">Ticket Status:</th>
								<td colspan="3" align="left">Propose Closed</td>
							</tr>
							<tr>
								<th colspan="2" align="left">Reason Status:</th>
								<td colspan="3" align="left">'.$fetch_email["status_res_desc"].'</td>
							</tr>
							<tr>
								<th colspan="5" align="left">&nbsp;</th>
							</tr>
							<tr>
								<th colspan="2" align="left">เข้าใช้งานได้ที่นี่</th>
								<td colspan="3" align="left"><a href="'.$hosting_id_pea.'helpdesk" target="_blank">Helpdesk System</a></td>
							</tr>
						</table>
						';
						
						 
						$header = "MIME-Version: 1.0\r\n" ;
						$header .= "Content-type: text/html; charset=UTF-8\r\n" ;
						//$header .= "From: Helpdesk@mailserver.com\r\n" ;
						//$header .= "From: $mail_admin\r\n"."CC: $mail_user_login";
                        $header .= "From: $mail_admin\r\n";
						 
						if( @mail( $to , $subject , $message , $header ) ){ 
							//echo 'Complete.';
						}else{
							//echo 'Incomplete.';
//							alert_message(alert_message("Error!! Sent mail new assigned ,please contact Somwang"));
                                                    alert_message("Error to sent mail new assigned ,please contact administrator ", "", ERROR_MESSAGE);
                                                    return false;
						}
?>