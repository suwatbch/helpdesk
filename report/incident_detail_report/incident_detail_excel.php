<?php
    ini_set('max_execution_time', 300);
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/report_detail.class.php";
    include_once "../../include/class/model/report.class.php";
    include_once "../../include/handler/action_handler.php";

    function getcustomerinfo($comp_id){
        global $data,$db;
        $report = new report($db);
        $data =  $report->getCustomerInfo($comp_id);
	return $data;
    }

   ?>

<?
    global $report_detail ,$db,$customerinfo;

    $customerinfo = getcustomerinfo($_GET["comp"]);
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
<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <title>Incident Detail Report</title>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript">
        function export_incident_detail(){
                var page = $("#result_page").val();
                var comp = $("#cus_company_id").val();
                var status = $("#status_id").val();
                var status_l = $("#status_id_l").val();
                var ident_type_id = $("#ident_type_id").val();
                var ident_type_id_l = $("#ident_type_id_l").val();
                var prd_tier_id3 = $("#prd_tier_id3").val();
                var prd_tier_id3_l = $("#prd_tier_id3_l").val();
                var customer_zone_id = $("#customer_zone_id").val();
                var customer_zone_id_l = $("#customer_zone_id_l").val();
                var s_owner = $("#owner").val();
                var s_resolved = $("#resolved").val();
                var d1=$("#start").val();
                var d2=$("#end").val();
                var reference_from =$("#reference_from").val();
                var reference_to =$("#reference_to").val();
                var project_id =$("#project_id").val();
                var show_to_customer = $("#show_to_customer").val();

                var url = page + '?comp=' + comp + '&start=' + d1 + '&end=' + d2 + '&c3=' + prd_tier_id3
                        + '&c3_l=' + prd_tier_id3_l + '&zone=' + customer_zone_id + '&zone_l=' + customer_zone_id_l + '&st='+status +'&st_l='+status_l
                        + '&id_t=' +ident_type_id+'&id_t_l='+ident_type_id_l+'&s_ow='+s_owner+'&s_re='
                        +s_resolved+'&ref_from='+reference_from+'&ref_to='+reference_to + '&pj=' + project_id + '&show_to_customer=' + show_to_customer;
                //alert(url);
                window.open(url, '',''); 
              }
            
        </script>
<style>
   @media {
    @page {
      size: B4 landscape;
      margin: 5px 5px 5px 5px;
      padding: 5px 5px 5px 5px;

    }
  }
    table{
      width: 100%;
      table-layout: fixed;
       word-wrap:break-word;

  }

</style>
    </head>
    
    <body>
        <?
            include_once '../common/report_header.php';
        ?>
        <br>
        <img id="export_detail" name="export_detail" src="<?=$application_path_images?>/export.gif" style="cursor: pointer;" onclick="javascript:export_incident_detail();">
        <input type="hidden" id="result_page" value="incident_detail_export.php">
        <input type="hidden" id="cus_company_id" value="<?=$_GET["comp"];?>">
        <input type="hidden" id="status_id" value="<?=$_GET["st"];?>">
        <input type="hidden" id="status_id_l" value="<?=$_GET["st_l"];?>">
        <input type="hidden" id="ident_type_id" value="<?=$_GET["id_t"];?>">
        <input type="hidden" id="ident_type_id_l" value="<?=$_GET["id_t_l"];?>">
        <input type="hidden" id="prd_tier_id3" value="<?=$_GET["c3"];?>">
        <input type="hidden" id="prd_tier_id3_l" value="<?=$_GET["c3_l"];?>">
        <input type="hidden" id="customer_zone_id" value="<?=$_GET["zone"];?>">
        <input type="hidden" id="customer_zone_id_l" value="<?=$_GET["zone_l"];?>">
        <input type="hidden" id="start" value="<?=$_GET["start"];?>">
        <input type="hidden" id="end" value="<?=$_GET["end"];?>">
        <input type="hidden" id="owner" value="<?=$_GET["s_ow"];?>">
        <input type="hidden" id="resolved" value="<?=$_GET["s_re"];?>">
        <input type="hidden" id="reference_from" value="<?=$_GET["ref_from"];?>">
        <input type="hidden" id="reference_to" value="<?=$_GET["ref_to"];?>">
        <input type="hidden" id="project_id" value="<?=$_GET["pj"];?>">
        <input type="hidden" id="show_to_customer" value="<?=$_GET["show_to_customer"];?>">
        
        
            
            <table border="1" cellpadding="3" cellspacing="0">
                <tr style=" background-color:#B9BCBD">
                    <th rowspan="2" align="center" width="4%">ลำดับ</th>
                    <th align="center" width="6%">Ticket Number</th>
                    <th rowspan="2" align="center" width="4%">Reference</th>
                    <th rowspan="2" align="center" width="4%">การไฟฟ้าเขต</th>
                    <th rowspan="2" align="center" width="5%">รหัส-ชื่อ สำนักงานการไฟฟ้า</th>
                    <th rowspan="2" align="center" width="5%">ระบบงาน</th>
                    <th rowspan="2" align="center" width="5%">รหัสพนักงานผู้แจ้ง</th>
                    <th rowspan="2" align="center" width="5%">ชื่อ-นามสกุล ผู้แจ้ง</th>
                    <th rowspan="2" align="center" width="6%">ชื่อผู้รับแจ้ง</th>
                    <th rowspan="2" align="center" width="8%">ข้อสรุปปัญหา</th>
                    <th rowspan="2" align="center" width="8%">รายละเอียดของปัญหา</th>
                    <th colspan="2" align="center" width="14%">วัน - เวลา รับแจ้ง</th>
                    <th colspan="2" align="center" width="14%">วัน - เวลา ปิดปัญหา</th>
                    <th align="center" width="8%">รายละเอียดการแก้ปัญหา</th>
                    <th align="center" width="8%">(2nd tire)</th>
                    <th rowspan="2" align="center" width="5%">ชื่อผู้แก้ไข</th>
                    <th rowspan="2" align="center" width="4%">สถานะงาน</th>
                    <th rowspan="2" align="center" width="4%">เหตุผลของสถานะงาน</th>
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
                    <th align="center" >D/M/Y</th>
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
                    ?>
                <tr>
                    <td align="center" ><?=$index++;?></td>
                    <td align="center" ><?=$fetch_report["ident_id_run_project"];?></td>
                    <td><? if(strUtil::isNotEmpty($fetch_report["reference_no"])){echo $fetch_report["reference_no"];}else {echo "-";}?></td>
                    <td><?=$fetch_report["name_zone"];?></td>
                    <td><?=$fetch_report["cus_office"];?></td>
                    <td><?=$fetch_report["s_prd_tier_name"];?></td>
                    <td align="center"><?=$fetch_report["cus_id"];?></td>
                    <td><?=$fetch_report["cus_firstname"]." ".$fetch_report["cus_lastname"];?></td>
                    <td><?=$fetch_report["first_name"]." ".$fetch_report["last_name"];?></td>
                    <td><?=nl2br($fetch_report["summary"]);?></td>
                    <td><?=nl2br($fetch_report["notes"]);?></td>
                    <td align="center"><?=$s_create_date?></td>
                    <td align="center"><?=$s_time_date?></td>
                    <td align="center"><? if($fetch_report["closed_date"] == '0000-00-00 00:00:00'){ echo "-"; }else{ echo $s_closed_date;}?></td>
                    <td align="center"><? if($fetch_report["closed_date"] == '0000-00-00 00:00:00'){ echo "-"; }else{ echo $s_closed_time;}?></td>
                    <td><?=nl2br($fetch_report["s_resolution"]);?></td>
                    <td><?=nl2br($fetch_report["ss_resolution"]);?></td>
                    <td><?=$fetch_report["resolve_user"];?></td>
                    <td align="center"><?=$fetch_report["status_desc"];?></td>
                    <td align="center"><? if($fetch_report["status_res_desc"] != ""){ echo $fetch_report["status_res_desc"]; } else { echo "-" ;} ?></td>
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
</html>
