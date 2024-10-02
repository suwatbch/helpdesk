<?php
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sla_detail_report.xls");

include_once "../../include/config.inc.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
include_once "../../include/class/util/dateUtil.class.php";
include_once "../../include/class/model/sla_report.class.php";


$filter = array(
    "comp_id" => $_GET["c"],
    "start_date" => $_GET["d1"], 
    "end_date" => $_GET["d2"],
    "project" => $_GET["pj"],
    "incident_type_fr" => $_GET["t1"],
    "incident_type_to" =>  ($_GET["t2"] == "") ? $_GET["t1"]:$_GET["t2"],
    "status_fr" => $_GET["s1"],
    "status_to" => ($_GET["s2"] == "") ? $_GET["s1"]:$_GET["s2"],
    "priority_fr" => $_GET["p1"],
    "priority_to" => ($_GET["p2"] == "") ? $_GET["p1"]:$_GET["p2"],
    "resp_group" => $_GET["pg"],
    "resp_subgroup" => $_GET["psg"],
    "resv_group" => $_GET["vg"],
    "resv_subgroup" => $_GET["vsg"],
    "respond_name" => str_replace(" ", "", $_GET["rp"]) ,
    "resolved_name" => str_replace(" ", "", $_GET["rs"]) ,
    "owner_name" => str_replace(" ", "", $_GET["o"]) ,
    "reference_fr" => $_GET["ref1"],
    "reference_to" => ($_GET["ref2"] == "") ? $_GET["ref1"]:$_GET["ref2"], 
    "display_inc" => ($_GET["show_to_customer"] == "Y" ? "1":"0,1")
);

global $sla_report ,$db, $filter;
$sla_report = new sla_report($db);
        
$result = $sla_report->get_sla_detail($filter);
//echo print_r($criterai["data"]);
//exit();




$dp_start = dateUtil::thai_date($filter["start_date"]);
$dp_end = dateUtil::thai_date($filter["end_date"]);

$text_head_1 = "ระบบ Helpdesk";
$text_head_2 = "โครงการจ้างพัฒนา บำรุงรักษาและแก้ไขโปรแกรมสำเร็จรูป SAP";
$text_reportname = "รายงาน SLA Detail ในช่วงเวลา $dp_start ถึง $dp_end";

if($result["data"]){ $arr_result = $result["data"]; }
if($result["total_rows"]){ $total_row = $result["total_rows"]; }



?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/TR/REC-html40">

<HTML>

<HEAD>

<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

</HEAD>
    <body>
        <div name="Head">
            <table style="color: black; font-weight: bold; font-size: 20px; ">
                <tr><td colspan="31"  style="width: 100%; border-bottom:  #cc0000 solid 5px; " align="center"><?=$text_reportname;?></td></tr>
            </table>
        </div><br>

            <div name="Data">
            <table border="1px" cellpadding="3" cellspacing="0" >
                <tr style=" background-color:#B9BCBD">
                    <th rowspan="2" align="center">Incident ID</th>
                    <th rowspan="2" align="center">Incident Type</th>
                    <th rowspan="2" align="center">Incident Date</th>
                    <th rowspan="2" align="center">Priority</th>
                    <th rowspan="2" align="center">Owner</th>
                    <th rowspan="2" align="center">Responded By</th>
                    <th colspan="3" align="center">Operation Classification</th>
                    <th colspan="3" align="center">Product Classification</th>
                    <th rowspan="2" align="center">Resolved By</th>
                    <th colspan="3" align="center">Operation Resolved Class</th>
                    <th colspan="3" align="center">Product Resolved Class</th>
                    <th rowspan="2" align="center">Assigned Date/Time</th>
                    <th rowspan="2" align="center">Working Date/Time</th>
                    <th rowspan="2" align="center">Respond-Special Holiday(HR)</th>
                    <th rowspan="2" align="center">Actual Respond Time (HR)</th>
                    <th rowspan="2" align="center">Resolved Date/Time</th>
                    <th rowspan="2" align="center">Pending Time(HR)</th>
                    <th rowspan="2" align="center">Resolved-Special Holiday(HR)</th>
                    <th rowspan="2" align="center">Actual Resolved Time(HR)</th>
                    <th rowspan="2" align="center">Responded SLA(HR)</th>
                    <th rowspan="2" align="center">Resolved SLA(HR)</th>
                    <th rowspan="2" align="center">Responded SLA Result</th>
                    <th rowspan="2" align="center">Resolved SLA Result</th>
                </tr>
                <tr style=" background-color:#B9BCBD">
                    <th align="center">Class 1</th>
                    <th align="center">Class 2</th>
                    <th align="center">Class 3</th>
                    <th align="center">Class 1</th>
                    <th align="center">Class 2</th>
                    <th align="center">Class 3</th>
                    <th align="center">Class 1</th>
                    <th align="center">Class 2</th>
                    <th align="center">Class 3</th>
                    <th align="center">Class 1</th>
                    <th align="center">Class 2</th>
                    <th align="center">Class 3</th>
                </tr>
                <?
                if (count($total_row) > 0){ 
                    foreach ($arr_result as $list) {
                        if($list["inc_date"] == "0000-00-00 00:00:00"){
                            $inc_date = "";
                        }else {
                            $inc_date = new DateTime($list["inc_date"]);
                            $inc_date = date_format($inc_date, "d-m-Y H:i:s");
                        }
                        
                        if($list["assigned_date"] == "0000-00-00 00:00:00"){
                            $assign_date = "";
                            $list["respond_sla_result"] = "N/A";
                            $list["resolve_sla_resilt"] = "N/A";
                        }else{
                            
                            $assign_date = new DateTime($list["assigned_date"]);
                            $assign_date = date_format($assign_date, "d-m-Y H:i:s");
                        }
                        
                        
                        if($list["working_date"] == "0000-00-00 00:00:00"){
                            $working_date = "";
                            $list["respond_sla_result"] = "N/A";
                            $list["resolve_sla_resilt"] = "N/A";
                        }else{
                            $working_date = new DateTime($list["working_date"]);
                            $working_date = date_format($working_date, "d-m-Y H:i:s");
                        }
                        
                        
                        if($list["resolved_date"] == "0000-00-00 00:00:00"){
                            $resolved_date = "";
                            $list["resolve_sla_resilt"] = "N/A";
                        }else{
                            $resolved_date = new DateTime($list["resolved_date"]);
                            $resolved_date = date_format($resolved_date, "d-m-Y H:i:s");
                        }
                        
                        
                        
                        
                      ?>
                          
                <tr>
                    <td><?=$list["inc_id"];?></td>
                    <td><?=$list["inc_type_name"];?></td>
                    <td align="center"><?=$inc_date;?></td>
                    <td><?=$list["priority_name"];?></td>
                    <td><?=$list["owner_name"];?></td>
                    <td><?=$list["responded_by"];?></td>
                    <td><?=$list["cas_opr_name_1"];?></td>
                    <td><?=$list["cas_opr_name_2"];?></td>
                    <td><?=$list["cas_opr_name_3"];?></td>
                    <td><?=$list["cas_prd_name_1"];?></td>
                    <td><?=$list["cas_prd_name_2"];?></td>
                    <td><?=$list["cas_prd_name_3"];?></td>
                    <td><?=$list["resolved_by"];?></td>
                    <td><?=$list["res_opr_name_1"];?></td>
                    <td><?=$list["res_opr_name_2"];?></td>
                    <td><?=$list["res_opr_name_3"];?></td>
                    <td><?=$list["res_prd_name_1"];?></td>
                    <td><?=$list["res_prd_name_2"];?></td>
                    <td><?=$list["res_prd_name_3"];?></td>
                    <td align="center"><?=$assign_date;?></td>
                    <td align="center"><?=$working_date;?></td>
                    <td align="center"><?=($list["resp_holiday"] == '00:00:00') ? "" : $list["resp_holiday"];?></td>
                    <td align="center"><?=($list["actual_resp"] == '00"00"00') ? "" : $list["actual_resp"];?></td>
                    <td align="center"><?=$resolved_date;?></td>
                    <td align="center"><?=($list["resv_pending"] == '00:00:00') ? "" : $list["resv_pending"];?></td>
                    <td align="center"><?=($list["resv_holiday"] == '00:00:00') ? "" : $list["resv_holiday"];?></td>
                    <td align="center"><?=($list["actual_resv"] == '00:00:00') ? "" : $list["actual_resv"];?></td>
                    <td align="center"><?=($list["respond_sla"] == '00:00:00') ? "" : $list["respond_sla"];?></td>
                    <td align="center"><?=($list["resolve_sla"] == '00:00:00') ? "" : $list["resolve_sla"];?></td>
                    <td align="center"><?=$list["respond_sla_result"];?></td>
                    <td align="center"><?=$list["resolve_sla_resilt"];?></td>
                    
                </tr>
                          
                          
                          
                          
                          <?  
                    }
                    
                }else {
                    ?>
                <tr>
                    <td colspan="31" align="center"><b>No incident to display</b></td>
                </tr>     
                        
                    <?
                }
                ?>
                
            </table>
        </div>
    </body>     
</html>



