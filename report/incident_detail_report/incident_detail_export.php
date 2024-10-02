<?php

//    header("Pragma: no-cache");
//    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//    header("Content-type: application/vnd.ms-excel");
//    header("Content-Disposition: attachment; filename=incident_detail_report.xls");
    
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=incident_detail_report.xls");
    
  
    include_once '../../include/config.inc.php';
    //include_once "../../include/error_message.php";
   // include_once "../../include/function.php";
    //include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/report_detail.class.php";
    //include_once "../../include/handler/action_handler.php";
    
    global $report_detail ,$db;
    $c_owner = ereg_replace('[[:space:]]+', '', trim($_GET['s_ow']));
    $c_resolved= ereg_replace('[[:space:]]+', '', trim($_GET['s_re']));
    $criterai =array(
              "cus_company_id" => $_GET["comp"]
            , "start" => $_GET["start"]
            , "end" => $_GET["end"]
            , "ident_type_id" => $_GET["id_t"]
            , "ident_type_id_l" => $_GET["id_t_l"]
            , "status_id" => $_GET["st"]
            , "status_id_l" => $_GET["st_l"]
            , "customer_zone_id" => $_GET["zone"]
            , "customer_zone_id_l" => $_GET["zone_l"]
            , "prd_tier_id3" => $_GET["c3"]
            , "prd_tier_id3_l" => $_GET["c3_l"]
            , "owner"  => $c_owner
            , "resolved"  => $c_resolved
            , "reference_from" => $_GET["ref_from"]
            , "reference_to" => $_GET["ref_to"]
            , "project_id" => $_GET["pj"]
             , "show_to_customer" =>$_GET["show_to_customer"]
        );
    $report_detail = new report_detal($db);
    $s_report_detail = $report_detail->getReportDetail($criterai);
    
    $s_report = $s_report_detail["arr_criteria"];
    $s_total_rows = $s_report_detail["total_row"];
    


$comp_id = $_GET["comp"];
$start_date = $_GET["start"];
$end_date = $_GET["end"];

$dp_start = dateUtil::thai_date($start_date);
$dp_end = dateUtil::thai_date($end_date);


$text_head_1 = "ระบบ Helpdesk";
$text_head_2 = "โครงการจ้างพัฒนา บำรุงรักษาและแก้ไขโปรแกรมสำเร็จรูป SAP";
$text_reportname = "รายงานรายละเอียดปัญหา ในช่วงเวลา $dp_start ถึง $dp_end";
                        

?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/TR/REC-html40">

<HTML>

<HEAD>

<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

</HEAD>
    <body>
        <table border="1" cellpadding="3" cellspacing="0">
            <tr><td>
                    <span><b><?=$text_reportname;?></b></span>
                </td></tr>
            <tr><td>&nbsp;</td></tr>
        </table>
            
             <table border="1" cellpadding="3" cellspacing="0">
                <tr style=" background-color:#B9BCBD">
                    <th rowspan="2" align="center">ลำดับที่</th>
                    <th align="center">Ticket Number</th>
                    <th rowspan="2" align="center" width="4%">Reference</th>
                    <th rowspan="2" align="center">การไฟฟ้าเขต</th>
                    <th rowspan="2" align="center">รหัส-ชื่อ สำนักงานการไฟฟ้า</th>
                    <th rowspan="2" align="center">ระบบงาน</th>
                    <th rowspan="2" align="center">รหัสพนักงานผู้แจ้ง</th>
                    <th rowspan="2" align="center">ชื่อ-นามสกุล ผู้แจ้ง</th>
                    <th rowspan="2" align="center">ชื่อผู้รับแจ้ง</th>
                    <th rowspan="2" align="center" width="20%">ข้อสรุปปัญหา</th>
                    <th rowspan="2" align="center" width="20%">รายละเอียดของปัญหา</th>
                    <th colspan="2" align="center">วัน - เวลา รับแจ้ง</th>
                    <th colspan="2" align="center">วัน - เวลา ปิดปัญหา</th>
                    <th align="center" width="20%">รายละเอียดการแก้ปัญหา</th>
                    <th align="center" width="20%">(2nd tire)</th>
                    <th rowspan="2" align="center" width="5%">ชื่อผู้แก้ไข</th>
                    <th rowspan="2" align="center">สถานะงาน</th>
                    <th rowspan="2" align="center">เหตุผลของสถานะงาน</th>
                    <th rowspan="2" align="center" width="6%">Actual working</th>
                    <th rowspan="2" align="center" width="6%">Actual pending</th>
                    <th rowspan="2" align="center" width="6%">Pending wait info</th>
                    <th rowspan="2" align="center" width="6%">Pending wait SAP</th>
                    <th rowspan="2" align="center" width="6%">Pending wait DEV</th>
                    <th rowspan="2" align="center" width="6%">Pending wait testing</th>
                    <th rowspan="2" align="center" width="6%">Priority</th>

                </tr>
                <tr style=" background-color:#B9BCBD">
                    <th colspan="1" align="center">หมายเลขอ้างอิง</th>
                    <th align="center">D/M/Y</th>
                    <th align="center">hh:mm</th>
                    <th align="center">D/M/Y</th>
                    <th align="center">hh:mm</th>
                    <th align="center">(กรณีสามารถปิดปัญหาได้เอง)</th>
                    <th align="center">(ผู้ทำการแก้ไข)</th>
                    
                </tr>
                <? 
                if($s_total_rows > 0){
                $index = 1;
                foreach ($s_report as $fetch_report){
                    $year_c_date = substr($fetch_report["create_date"], 0, -15); 
                    $cover_date = (int)$year_c_date + 543;
                    $s_create_date = substr($fetch_report["create_date"], 8, -9)."/".substr($fetch_report["create_date"], 5, -12)."/".$cover_date;
                    $s_time_date =  substr($fetch_report["create_date"], 11, -6).":".substr($fetch_report["create_date"], 14, -3).":".substr($fetch_report["create_date"],17);
                    
                    //close date
                    $year_closed_date = substr($fetch_report["closed_date"], 0, -15); 
                    $cover_closed_date = (int)$year_closed_date + 543;
                    $s_closed_date = substr($fetch_report["closed_date"], 8, -9)."/".substr($fetch_report["closed_date"], 5, -12)."/".$cover_closed_date;
                    $s_closed_time =  substr($fetch_report["closed_date"], 11, -6).":".substr($fetch_report["closed_date"], 14, -3).":".substr($fetch_report["closed_date"],17);
                    
                    $bad=array("\n","\r");
                    
                    ?>
                <tr>
                    <td align="center" ><?=$index++;?></td>
                    <td align="center" ><?=$fetch_report["ident_id_run_project"];?></td>
                    <td><? if(strUtil::isNotEmpty($fetch_report["reference_no"])){echo $fetch_report["reference_no"];}else {echo "";}?></td>
                    <td><?=$fetch_report["name_zone"];?></td>
                    <td><?=$fetch_report["cus_office"];?></td>
                    <td><?=$fetch_report["s_prd_tier_name"];?></td>
                    <td align="center"><?=$fetch_report["cus_id"];?></td>
                    <td><?=$fetch_report["cus_firstname"]." ".$fetch_report["cus_lastname"];?></td>
                    <td><?=$fetch_report["first_name"]." ".$fetch_report["last_name"];?></td>
                    <td><?=str_replace($bad,'',$fetch_report["summary"]);?></td>
                    <td><?=str_replace($bad,'',$fetch_report["notes"]);?></td>
                    <td align="center"><?=$s_create_date?></td>
                    <td align="center"><?=$s_time_date?></td>
                    <td align="center"><? if($fetch_report["closed_date"] == '0000-00-00 00:00:00'){ echo ""; }else{ echo $s_closed_date;}?></td>
                    <td align="center"><? if($fetch_report["closed_date"] == '0000-00-00 00:00:00'){ echo ""; }else{ echo $s_closed_time;}?></td>
                    <td><?=str_replace($bad,'',$fetch_report["s_resolution"]);?></td>
                    <td><?=str_replace($bad,'',$fetch_report["ss_resolution"]);?></td>
                    <td><?=$fetch_report["resolve_user"];?></td>
                    <td align="center"><?=$fetch_report["status_desc"];?></td>
                    <td align="center"><? if($fetch_report["status_res_desc"] != ""){ echo $fetch_report["status_res_desc"]; } else { echo "" ;} ?></td>
                    <td align="center"><?=dateUtil::sec_to_time_desc($fetch_report["tot_actual_working_sec"]);?></td>
                    <td align="center"><?=dateUtil::sec_to_time_desc($fetch_report["tot_actual_pending_sec"]);?></td>
                    <td align="center"><?=dateUtil::sec_to_time_desc($fetch_report["tot_pending_res_wait_info"]);?></td>
                    <td align="center"><?=dateUtil::sec_to_time_desc($fetch_report["tot_pending_res_wait_sap"]);?></td>
                    <td align="center"><?=dateUtil::sec_to_time_desc($fetch_report["tot_pending_res_wait_dev"]);?></td>
                    <td align="center"><?=dateUtil::sec_to_time_desc($fetch_report["tot_pending_res_wait_test"]);?></td>
                    <td><?=$fetch_report["priority_desc"];?></td>
                    
                </tr>
                <? }
                }else{ echo "<tr><td colspan=17><b>No Data Incident</b><td></tr>"; }?>
            </table>

    </body>
</HTML >
