<?php
    include_once dirname(dirname(dirname(__FILE__))).'/include/config.inc.php';
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/util/strUtil.class.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/util/dateUtil.class.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/db/db.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/model/sla.class.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/model/sla_send_email.class.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/mail.class.php";
    
    global $db,$send_email,$flagTest;  
    $send_email = new send_email($db);
    
    $flagTest = "";
    
    
    run_sla(2);
    run_sla(3);
    
    
    function run_sla($type){
        global $db,$send_email,$flagTest;  // ,$send_email
        
        // get email list to send email
        $result = $send_email->getEmailList();
        $today = date("Y-m-d H:i:s");
        if ($type == 2){
            $status_text = "Assign";
            $header_text = "Assigned";
            $sla_text = "Respond";
        }else if ($type == 3){
            $status_text = "Working";
            $header_text = "Working";
            $sla_text = "Resolved";
        }
        
        if ($result){
            $result_data = $result["data"];
            foreach ($result_data as $emaillist) {
                $arr_on_lv1 = array();
                $arr_on_lv2 = array();
                $arr_on_lv3 = array();
                $arr_over_lv1 = array();
                $arr_over_lv2 = array();
                $arr_over_lv3 = array();            
                
                // get master data : resolve sla , respond_sla 
                $master_sla = $send_email->getMaster_SLA($type);
                if ($master_sla){
                    
                    $master_sla_data = $master_sla["data"];
                    
                    $comp_id = $emaillist["company_id"];
                    $org_id = $emaillist["org_id"];
                    $grp_id = $emaillist["grp_id"];
                    $subgrp_id = $emaillist["subgrp_id"];
                    $on_lv1 = $emaillist["on_sla_l1"];
                    $on_lv2 = $emaillist["on_sla_l2"];
                    $on_lv3 = $emaillist["on_sla_l3"];
                    $over_lv1 = $emaillist["over_sla_l1"];
                    $over_lv2 = $emaillist["over_sla_l2"];
                    $over_lv3 = $emaillist["over_sla_l3"];
                    
                    $on_lv1_to = $emaillist["on_sla_l1_to"];
                    $on_lv1_cc = $emaillist["on_sla_l1_cc"];
                    
                    $on_lv2_to = $emaillist["on_sla_l2_to"];
                    $on_lv2_cc = $emaillist["on_sla_l2_cc"];
                    
                    $on_lv3_to = $emaillist["on_sla_l3_to"];
                    $on_lv3_cc = $emaillist["on_sla_l3_cc"];
                    
                    $over_lv1_to = $emaillist["over_sla_l1_to"];
                    $over_lv1_cc = $emaillist["over_sla_l1_cc"];
                    
                    $over_lv2_to = $emaillist["over_sla_l2_to"];
                    $over_lv2_cc = $emaillist["over_sla_l2_cc"];
                    
                    $over_lv3_to = $emaillist["over_sla_l3_to"];
                    $over_lv3_cc = $emaillist["over_sla_l3_cc"];
                    
                    foreach ($master_sla_data as $mas_sla) {
                        
                        $prd_class_name_display = $mas_sla["prd_class1_name"]."/".$mas_sla["prd_class2_name"]."/".$mas_sla["prd_class3_name"];
                        
                        $master_std_sla = $mas_sla["secs_sla"];
                        
                        $filter = array(
                            "status_id" => $type   , 
                            "priority_id" =>  $mas_sla["priority_id"] , 
                            "cus_company_id" => $mas_sla["cus_comp_id"]  , 
                            "opr_class1_id" => $mas_sla["opr_class1_id"] , 
                            "opr_class2_id" => $mas_sla["opr_class2_id"] , 
                            "opr_class3_id" => $mas_sla["opr_class3_id"], 
                            "prd_class1_id" => $mas_sla["prd_class1_id"] , 
                            "prd_class2_id" => $mas_sla["prd_class2_id"] , 
                            "prd_class3_id" => $mas_sla["prd_class3_id"] , 
                            "org_id" => $org_id  , 
                            "comp_id" => $comp_id  , 
                            "group_id" => $grp_id  , 
                            "subgroup_id" => $subgrp_id
                        );
                        
                        //get incident from filter
                        $incident = $send_email->getIncident($filter);
                        if ($incident){
                            $incident_data = $incident["data"];
                            foreach ($incident_data as $inc) {
                                $inc_alert_status = $inc["alert_status_sla"];
                                $assignee = $send_email->getUser($inc["assignee_id_last"]);
                                
                                $inc_first_working_date = $send_email->get_first_working($inc["id"]);
                                if ($inc["alert_status_id"] == $type && $inc["alert_date"] <> "0000-00-00 00:00:00"){
                                    //ถ้าเป็น status เดิม ให้คิด sla ต่อจากครั้งที่แล้ว
                                    //$start_date = $inc["alert_date"];
                                    $sla_duration = sla::cal_sla_days($inc["alert_date"], $today, $inc["cus_company_id"], ($type == 2) ? 'N':'Y', $inc["id"]);
                                    $sla_days = $inc["alert_sla_days"] + ($sla_duration["sla_days"]-$sla_duration["holiday"]-$sla_duration["pending"]);
                                    
                                    
                                }else{
                                    // คนละ status กับครั้งที่แล้ว ให้คิดใหม่ตาม original logic 
                                    if ($type == 2){
                                        $start_date = $inc["assigned_date"];
                                    }elseif ($type == 3) {
                                        $start_date = $inc_first_working_date;
                                    }
                                    
                                    $sla_duration = sla::cal_sla_days($start_date, $today, $inc["cus_company_id"], ($type == 2) ? 'N':'Y', $inc["id"]);
                                    $sla_days = $sla_duration["sla_days"]-$sla_duration["holiday"]-$sla_duration["pending"];
                                }
                                                             
                                
                                //=================== over sla
                                if ($sla_days > $master_std_sla){
                                    
                                    $diff_secs = $sla_days - $master_std_sla;
                                    $diff_pc = round(($diff_secs/$master_std_sla)*100);
                                    
                                    if (intval($diff_pc) >= intval($over_lv1) && intval($over_lv1) <> 0 
                                            && $inc_alert_status <> "respond_over_1" && $inc_alert_status <> "resolve_over_1" ){
                                        
                                        if ($over_lv2 == 0 && $over_lv3 == 0){
                                            $arr_over_lv1[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_over_1" : "resolve_over_1",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                            );
                                        }else if ($diff_pc < $over_lv2 && $over_lv2 <> 0){
                                            $arr_over_lv1[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_over_1" : "resolve_over_1",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                            );
                                        }
                                        
                                    }
                                    
                                    
                                    if ($diff_pc >= $over_lv2 && $over_lv2 <> 0
                                            && $inc_alert_status <> "respond_over_2" && $inc_alert_status <> "resolve_over_2" ){
                                        
                                        if ($over_lv3 == 0){
                                            $arr_over_lv2[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_over_2" : "resolve_over_2",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                            );
                                            
                                        }else if ($diff_pc < $over_lv3){
                                            $arr_over_lv2[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_over_2" : "resolve_over_2",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                            );                                            
                                        }
                                        
                                    }
                                    
                                    
                                    if (intval($diff_pc) >= intval($over_lv3) && intval($over_lv3) <> 0
                                            && $inc_alert_status <> "respond_over_3" && $inc_alert_status <> "resolve_over_3" ){
                                        $arr_over_lv3[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_over_3" : "resolve_over_3",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                        );
                                        
                                    }
                                    
                                    
                                }else if ($sla_days <= $master_std_sla){
                                    //=================== on sla
                                    $diff_secs = $master_std_sla - $sla_days;
                                    $diff_pc = round(($diff_secs/$master_std_sla)*100);
                                    // example : lv1 = 70% , lv2 = 50% , lv3 = 30%  OF REMAINING
                                    
                                    if ($diff_pc <= $on_lv1 && $on_lv1 != 0
                                            && $inc_alert_status <> "respond_on_1" && $inc_alert_status <> "resolve_on_1" ){

                                        if ($on_lv2 == 0 && $on_lv3 == 0){
                                            $arr_on_lv1[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_on_1" : "resolve_on_1",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                            );
                                            
                                        }else if ($diff_pc > $on_lv2 && $on_lv2 <> 0){
                                            $arr_on_lv1[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_on_1" : "resolve_on_1",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                            );
                                        }
                                        
                                        
                                        
                                    }
                                    
                                    if ($diff_pc <= $on_lv2 && $on_lv2 != 0
                                            && $inc_alert_status <> "respond_on_2" && $inc_alert_status <> "resolve_on_2" ){
                                        
                                        if ($on_lv2 == 0){
                                            $arr_on_lv2[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_on_2" : "resolve_on_2",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                            );
                                            
                                        }else if ($diff_pc > $on_lv2){
                                            $arr_on_lv2[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_on_2" : "resolve_on_2",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                            );
                                            
                                        }
                                            
                                    }
                                    
                                    if ($diff_pc <= $on_lv3 && $on_lv3 != 0
                                            && $inc_alert_status <> "respond_on_3" && $inc_alert_status <> "resolve_on_3" ){
                                        $arr_on_lv3[] = array(
                                            "id"=> $inc["id"],
                                            "incident" => $inc["ident_id_run_project"],
                                            "detail" => $inc["summary"],
                                            "status" => $status_text ,
                                            "assignee" => $assignee,
                                            "start_datetime" => ($type == 2) ? $inc["assigned_date"]:$inc_first_working_date,
                                            "actual_hrs" => dateUtil::seconds2time( $sla_days),
                                            "standard_hrs" => dateUtil::seconds2time( $master_std_sla),
                                            "class" => $prd_class_name_display,
                                            "alert_date" => $today,
                                            "alert_status_sla" => ($type == 2) ? "respond_on_3" : "resolve_on_3",
                                            "alert_sla_days" => $sla_days,
                                            "alert_status_id" => $type,
                                            "alert_percent_sla" => $diff_pc
                                        );
                                    }
                                }
                            }// end loop get incident
                        }
                    }// end loop master class sla
                }
                
                /*
                 * SEND EMAIL HERE!!!! + STAMP ALL VALUE TO INCIDENT
                 */
               
                $html = "<!DOCTYPE html>
                        <html>
                        <head>
                            <meta charset=utf-8 />
                            <style type='text/css'>
                                body{
                                    font-size: 12px;
                                    font-family: Arial, Helvetica, Sans-Serif;
                                }
                                table tr th,td {
                                    font-size: 12px;
                                }
                                .red{
                                    color: red;
                                    font-weight: bold;
                                }
                                .blue{
                                    color: #0431B4;
                                    font-weight: bold;
                                }
                            </style>
                        </head>
                        <body>";
                
                $head = "<table  border='1px'>"
                       . "<tr style='background-color:#AED4E1'>"
                       . "     <th style='width:5%;' align='center'>Item</th>"
                       . "     <th style='width:9%;' align='center'>Incident</th>"
                       . "     <th style='width:20%;' align='center'>Detail</th>"
                       . "     <th style='width:8%;' align='center'>Status</th>"
                       . "     <th style='width:15%;' align='center'>Assignee</th>"
                       . "     <th style='width:8%;' align='center'>$header_text Date-Time</th>"
                       . "     <th style='width:10%;' align='center'>SLA man-hours</th>"
                       . "     <th style='width:10%;' align='center'>Actual man-hours</th>"
                       . "     <th style='width:15%;' align='center'>Product Class</th>"
                       . "</tr>";
               
                $foot = "</table><br><br>
                        <span>ด้วยความเคารพอย่างสูง</span><br>
                        <span>Samart Helpdesk System</span></body></html>";
                
                if($arr_on_lv1){
                    $body_on_1 = "";
                    $i = 1;
                    foreach ($arr_on_lv1 as $value) {
                        $body_on_1 .= "<tr>
                                    <td align='center'>{$i}</td>
                                    <td>{$value["incident"]}</td>
                                    <td>{$value["detail"]}</td>
                                    <td>{$value["status"]}</td>
                                    <td>{$value["assignee"]}</td>
                                    <td>{$value["start_datetime"]}</td>
                                    <td>{$value["standard_hrs"]}</td>
                                    <td>{$value["actual_hrs"]}</td>
                                    <td>{$value["class"]}</td>
                                    </tr>";
                         $i++;
                    }
                    
                    if ($body_on_1 <> ""){
                        $body = "<span>เนื่องจากมี Incident ที่เหลือเวลาอีก <span class='red'>{$on_lv1}%</span> ก่อนถึงกำหนดเวลา
                            <span class='blue'>$sla_text SLA</span> ที่กำหนดไว้ ซึ่งมีรายละเอียดของแต่ละ Incident ดังต่อไปนี้</span><br><br>";
                        
                        
                        $subject = $flagTest."Remaining $on_lv1% for ".  strtolower($sla_text) ." SLA time";
                        $to = $on_lv1_to;
                        $cc = $on_lv1_cc;
                        
                        $body = $html.$body.$head.$body_on_1.$foot;
//                        echo echoBody($subject, $to, $cc, $body);
                        
                        if ($to != "" || $cc != ""){
                            $mail = mail::send($to, $cc,"", $subject, $body);
                            if ($mail){
                                foreach ($arr_on_lv1 as $value) {
                                    $send_email->updateSent($value);
                                }
                            }                            
                        }

                    }
                }
                
                if($arr_on_lv2){
                    $body_on_2 = "";
                    $i = 1;
                    foreach ($arr_on_lv2 as $value) {
                        $body_on_2 .= "<tr>
                                    <td align='center'>{$i}</td>
                                    <td>{$value["incident"]}</td>
                                    <td>{$value["detail"]}</td>
                                    <td>{$value["status"]}</td>
                                    <td>{$value["assignee"]}</td>
                                    <td>{$value["start_datetime"]}</td>
                                    <td>{$value["standard_hrs"]}</td>
                                    <td>{$value["actual_hrs"]}</td>
                                    <td>{$value["class"]}</td>
                                    </tr>";
                         $i++;
                    }
                    
                    
                    if ($body_on_2 <> ""){
                        $body = "<span>เนื่องจากมี Incident ที่เหลือเวลาอีก <span class='red'>{$on_lv2}%</span> ก่อนถึงกำหนดเวลา
                            <span class='blue'>$sla_text SLA</span> ที่กำหนดไว้ ซึ่งมีรายละเอียดของแต่ละ Incident ดังต่อไปนี้</span><br><br>";
                        
                        $subject = $flagTest."Remaining $on_lv2% for ".  strtolower($sla_text) ." SLA time";
                        $to = $on_lv2_to;
                        $cc = $on_lv2_cc;
                        
                        $body = $html.$body.$head.$body_on_2.$foot;
//                        echo echoBody($subject, $to, $cc, $body);
                        
                        if ($to != "" || $cc != ""){
                            $mail = mail::send($to, $cc,"", $subject, $body);
                            if ($mail){
                                foreach ($arr_on_lv2 as $value) {
                                    $send_email->updateSent($value);
                                }
                            }                            
                        }

                    }
                    
                }
                
                if($arr_on_lv3){
                    $body_on_3 = "";
                    $i = 1;
                    foreach ($arr_on_lv3 as $value) {
                        $body_on_3 .= "<tr>
                                    <td align='center'>{$i}</td>
                                    <td>{$value["incident"]}</td>
                                    <td>{$value["detail"]}</td>
                                    <td>{$value["status"]}</td>
                                    <td>{$value["assignee"]}</td>
                                    <td>{$value["start_datetime"]}</td>
                                    <td>{$value["standard_hrs"]}</td>
                                    <td>{$value["actual_hrs"]}</td>
                                    <td>{$value["class"]}</td>
                                    </tr>";
                         $i++;
                    }
                    
                    
                    if ($body_on_3 <> ""){
                        $body = "<span>เนื่องจากมี Incident ที่เหลือเวลาอีก <span class='red'>{$on_lv3}%</span> ก่อนถึงกำหนดเวลา
                            <span class='blue'>$sla_text SLA</span> ที่กำหนดไว้ ซึ่งมีรายละเอียดของแต่ละ Incident ดังต่อไปนี้</span><br><br>";
                        
                        $subject = $flagTest."Remaining $on_lv3% for ".  strtolower($sla_text) ." SLA time";
                        $to = $on_lv3_to;
                        $cc = $on_lv3_cc;
                        
                        $body = $html.$body.$head.$body_on_3.$foot;
//                        echo echoBody($subject, $to, $cc, $body);
                        
                        if ($to != "" || $cc != ""){
                            $mail = mail::send($to, $cc,"", $subject, $body);
                            if ($mail){
                                foreach ($arr_on_lv3 as $value) {
                                    $send_email->updateSent($value);
                                }
                            }                            
                        }

                    }
                    
                }
                
                
                if($arr_over_lv1){
                    $body_over_1 = "";
                    $i = 1;
                    foreach ($arr_over_lv1 as $value) {
                        $body_over_1 .= "<tr>
                                    <td align='center'>{$i}</td>
                                    <td>{$value["incident"]}</td>
                                    <td>{$value["detail"]}</td>
                                    <td>{$value["status"]}</td>
                                    <td>{$value["assignee"]}</td>
                                    <td>{$value["start_datetime"]}</td>
                                    <td>{$value["standard_hrs"]}</td>
                                    <td>{$value["actual_hrs"]}</td>
                                    <td>{$value["class"]}</td>
                                    </tr>";
                         $i++;
                    }
                    
                    
                    if ($body_over_1 <> ""){
                        $body = "<span>เนื่องจากมี Incident ที่มีเวลาเกินกว่า <span class='red'>{$over_lv1}%</span> ของเวลา
                            <span class='blue'>$sla_text SLA</span> ที่กำหนดไว้ ซึ่งมีรายละเอียดของแต่ละ Incident ดังต่อไปนี้</span><br><br>";
                                                
                        $subject = $flagTest."Over $over_lv1% for keep ".  strtolower($sla_text) ." SLA time";
                        $to = $over_lv1_to;
                        $cc = $over_lv1_cc;
                        
                        $body = $html.$body.$head.$body_over_1.$foot;
//                        echo echoBody($subject, $to, $cc, $body);
                        
                        if ($to != "" || $cc != ""){
                            $mail = mail::send($to, $cc,"", $subject, $body);
                            if ($mail){
                                foreach ($arr_over_lv1 as $value) {
                                    $send_email->updateSent($value);
                                }
                            }                            
                        }

                    }
                    
                }
                
                if($arr_over_lv2){
                    $body_over_2 = "";
                    $i = 1;
                    foreach ($arr_over_lv2 as $value) {
                        $body_over_2 .= "<tr>
                                    <td align='center'>{$i}</td>
                                    <td>{$value["incident"]}</td>
                                    <td>{$value["detail"]}</td>
                                    <td>{$value["status"]}</td>
                                    <td>{$value["assignee"]}</td>
                                    <td>{$value["start_datetime"]}</td>
                                    <td>{$value["standard_hrs"]}</td>
                                    <td>{$value["actual_hrs"]}</td>
                                    <td>{$value["class"]}</td>
                                    </tr>";
                         $i++;
                    }
                    
                    if ($body_over_2 <> ""){
                        $body = "<span>เนื่องจากมี Incident ที่มีเวลาเกินกว่า <span class='red'>{$over_lv2}%</span> ของเวลา
                            <span class='blue'>$sla_text SLA</span> ที่กำหนดไว้ ซึ่งมีรายละเอียดของแต่ละ Incident ดังต่อไปนี้</span><br><br>";
                        
                        $subject = $flagTest."Over $over_lv2% for keep ".  strtolower($sla_text) ." SLA time";
                        $to = $over_lv2_to;
                        $cc = $over_lv2_cc;
                        
                        $body = $html.$body.$head.$body_over_2.$foot;
//                        echo echoBody($subject, $to, $cc, $body);
                        
                        if ($to != "" || $cc != ""){
                             $mail = mail::send($to, $cc,"", $subject, $body);
                            if ($mail){
                                foreach ($arr_over_lv2 as $value) {
                                    $send_email->updateSent($value);
                                }
                            }                           
                            
                        }

                    }
                    
                }
                
                if($arr_over_lv3){
                    $body_over_3 = "";
                    $i = 1;
                    foreach ($arr_over_lv3 as $value) {
                        $body_over_3 .= "<tr>
                                    <td align='center'>{$i}</td>
                                    <td>{$value["incident"]}</td>
                                    <td>{$value["detail"]}</td>
                                    <td>{$value["status"]}</td>
                                    <td>{$value["assignee"]}</td>
                                    <td>{$value["start_datetime"]}</td>
                                    <td>{$value["standard_hrs"]}</td>
                                    <td>{$value["actual_hrs"]}</td>
                                    <td>{$value["class"]}</td>
                                    </tr>";
                         $i++;
                    }
                    
                    if ($body_over_3 <> ""){
                        $body = "<span>เนื่องจากมี Incident ที่มีเวลาเกินกว่า <span class='red'>{$over_lv3}%</span> ของเวลา
                            <span class='blue'>$sla_text SLA</span> ที่กำหนดไว้ ซึ่งมีรายละเอียดของแต่ละ Incident ดังต่อไปนี้</span><br><br>";
                        
                        $subject = $flagTest."Over $over_lv3% for keep ".  strtolower($sla_text) ." SLA time";
                        $to = $over_lv3_to;
                        $cc = $over_lv3_cc;
                        
                        $body = $html.$body.$head.$body_over_3.$foot;
//                        echo echoBody($subject, $to, $cc, $body);

                        if ($to != "" || $cc != ""){
                            
                            $mail = mail::send($to, $cc,"", $subject, $body);
                            if ($mail){
                                foreach ($arr_over_lv3 as $value) {
                                    $send_email->updateSent($value);
                                }
                            }                            
                        }

                        
                    }
                    
                }
                
                
           } // end loop email list[to,cc,group,subgroup]
//           print_r($arr_on_lv1)."<br>";
//           print_r($arr_on_lv2)."<br>";
//           print_r($arr_on_lv3)."<br>";
//           
//           print_r($arr_over_lv1)."<br>";
//           print_r($arr_over_lv2)."<br>";
//           print_r($arr_over_lv3)."<br>";
        }

    }
    
    
    function echoBody($subject,$to,$cc,$body){
        return "<br><br>Subject : $subject"."<br>To: $to"."<br>CC: $cc"."<br>".$body."<br>";
    }
    
    
    
    
       
?>
