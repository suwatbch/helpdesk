<?php
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=sla_summary_report.xls");


include_once '../../include/config.inc.php';
include_once "../../include/class/util/strUtil.class.php";
include_once "../../include/class/util/dateUtil.class.php";
include_once "../../include/class/db/db.php";
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
        
$main_data = $sla_report->summary_getmain_data($filter);
//$result = $sla_report->get_sla_detail($filter);
//echo print_r($criterai["data"]);
//exit();

//$print = "N";


$dp_start = dateUtil::thai_date($filter["start_date"]);
$dp_end = dateUtil::thai_date($filter["end_date"]);

$text_head_1 = "ระบบ Helpdesk";
$text_head_2 = "โครงการจ้างพัฒนา บำรุงรักษาและแก้ไขโปรแกรมสำเร็จรูป SAP";
$text_reportname = "รายงาน SLA Summary ในช่วงเวลา $dp_start ถึง $dp_end";

if($main_data["data"]){ $arr_result = $main_data["data"]; }
if($main_data["total_rows"]){ $total_row = $main_data["total_rows"]; }



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
                <tr><td colspan="17"  style="width: 100%; border-bottom:  #cc0000 solid 5px; " align="center"><?=$text_reportname;?></td></tr>
            </table>
        </div><br>
        <div name="Data">
            <table border="1px" cellpadding="3" cellspacing="0" >
                <tr>
                    <th rowspan="2" align="center" style="background-color: #81BEF7">Incident Type</th>
                    <th colspan="2" align="center" style="background-color: #81BEF7">Team</th>
                    <th rowspan="2" align="center" style="background-color: #81BEF7">Responsibility Person</th>
                    <th rowspan="2" align="center" style="background-color: #81BEF7">Priority</th>
                    <!-- responded SLA -->
                    <th colspan="6" align="center" style="background-color: #FAAC58">Respond SLA</th>
                    <th colspan="6" align="center" style="background-color: #86B404">Resolve SLA</th>
                </tr>
                <tr>
                    <th align="center" style="background-color: #81BEF7">Group</th>
                    <th align="center" style="background-color: #81BEF7">Sub Group</th>
                    <!-- responded SLA -->
                    <th align="center" style="background-color: #FAAC58">N/A</th>
                    <th align="center" style="background-color: #FAAC58">Cancel</th>
                    <th align="center" style="background-color: #FAAC58">Meet</th>
                    <th align="center" style="background-color: #FAAC58">Miss</th>
                    <th align="center" style="background-color: #FAAC58">Total</th>
                    <th align="center" style="background-color: #FAAC58">% SLA</th>
                    <!-- resolve SLA -->
                    <th align="center" style="background-color: #86B404">N/A</th>
                    <th align="center" style="background-color: #86B404">Cancel</th>
                    <th align="center" style="background-color: #86B404">Meet</th>
                    <th align="center" style="background-color: #86B404">Miss</th>
                    <th align="center" style="background-color: #86B404">Total</th>
                    <th align="center" style="background-color: #86B404">% SLA</th>
                </tr>
                <?
                if (count($total_row) > 0){ 
                    /*---- respond var -----*/
                    $rsp_na = 0;
                    $rsp_cancel = 0;
                    $rsp_miss = 0;
                    $rsp_meet = 0;
                    $rsp_total = 0;
                    /*---- resolve var -----*/
                    $rsv_na = 0;
                    $rsv_cancel = 0;
                    $rsv_miss = 0;
                    $rsv_meet = 0;
                    $rsv_total = 0;
                    
                    
                    $inc_type_name = "";
                    $group_name = "";
                    $sub_group_name = "";
                    $user_name = "";
                    foreach ($arr_result as $list) {
                        $inc_type_id = $list["type_id"];
                        $user_id = $list["user_id"];
                        $group_id = $list["group_id"];
                        $sub_group_id = $list["subgroup_id"];
                        $priority_id = $list["priority_id"];
                      ?>
                <tr>
                    <td style="width: 12%"><?=($inc_type_name == $list["type_name"]) ? "&nbsp;" : $list["type_name"];?></td>
                    <td style="width: 12%"><?=($group_name == $list["group_name"]) ? "&nbsp;" : $list["group_name"];?></td>
                    <td style="width: 10%"><?=($sub_group_name == $list["subgroup_name"]) ? "&nbsp;" : $list["subgroup_name"];?></td>
                    <td style="width: 11%"><?=($user_name == $list["user_name"]) ? "&nbsp;" : $list["user_name"];?></td>
                    <td style="width: 6%" align="center"><?=$list["priority_name"];?></td>
                     <?
                    //**************** Respond ***************
                    $total = 0;
                    //N/A
                    $count = $sla_report->summary_count_respond($inc_type_id, $user_id, $group_id, $sub_group_id, $priority_id, $filter,"n");
                    $total += $count;
                    $rsp_na += $count;
                    ?>
                    <td style="width: 4%" align="right"><?=($count == 0) ? "" : $count;?></td>
                    <?
                    //cancel
                    $count = $sla_report->summary_count_respond($inc_type_id, $user_id, $group_id, $sub_group_id, $priority_id, $filter,"c");
                    $total += $count;
                    $rsp_cancel += $count;
                    ?>
                    <td style="width: 4%" align="right"><?=($count == 0) ? "" : $count;?></td>
                    <?
                    //meet
                    $count = $sla_report->summary_count_respond($inc_type_id, $user_id, $group_id, $sub_group_id, $priority_id, $filter,"t");
                    $total += $count;
                    $rsp_meet += $count;
                    
                    $meet = $count;
                    ?>
                    <td style="width: 4%" align="right"><?=($count == 0) ? "" : $count;?></td>
                    <?
                    //miss
                    $count = $sla_report->summary_count_respond($inc_type_id, $user_id, $group_id, $sub_group_id, $priority_id, $filter,"s");
                    $total += $count;
                    $rsp_miss += $count;
                    
                    $rsp_total += $total;
                    
                    
                    $total_dp = ($total == 0) ? "" : round(($meet/$total)*100,2);
                    ?>
                    <td style="width: 4%" align="right"><?=($count == 0) ? "" : $count;?></td>
                    <td style="width: 4%" align="right"><?=($total == 0) ? "" : $total;?></td>
                    <td style="width: 5%" align="right"><?=($total_dp == 0) ? "" : $total_dp."%";?></td>
                    
                    
                    <?
                    //**************** Resolve ***************
                    $total = 0;
                    //N/A
                    $count = $sla_report->summary_count_resolve($inc_type_id, $user_id, $group_id, $sub_group_id, $priority_id, $filter,"n");
                    $total += $count;
                    $rsv_na += $count;
                    ?>
                    <td style="width: 4%" align="right"><?=($count == 0) ? "" : $count;?></td>
                    <?
                    //cancel
                    $count = $sla_report->summary_count_resolve($inc_type_id, $user_id, $group_id, $sub_group_id, $priority_id, $filter,"c");
                    $total += $count;
                    $rsv_cancel += $count;
                    ?>
                    <td style="width: 4%" align="right"><?=($count == 0) ? "" : $count;?></td>
                    <?
                    //meet
                    $count = $sla_report->summary_count_resolve($inc_type_id, $user_id, $group_id, $sub_group_id, $priority_id, $filter,"t");
                    $total += $count;
                    $rsv_meet += $count;
                    
                    $meet = $count;
                    ?>
                    <td style="width: 4%" align="right"><?=($count == 0) ? "" : $count;?></td>
                    <?
                    //miss
                    $count = $sla_report->summary_count_resolve($inc_type_id, $user_id, $group_id, $sub_group_id, $priority_id, $filter,"s");
                    $total += $count;
                    $rsv_miss += $count;
                    
                    $rsv_total += $total;
                    
                    $total_dp = ($total == 0) ? "" : round(($meet/$total)*100,2);
                    ?>
                    <td style="width: 4%" align="right"><?=($count == 0) ? "" : $count;?></td>
                    <td style="width: 4%" align="right"><?=($total == 0) ? "" : $total;?></td>
                    <td style="width: 5%" align="right"><?=($total_dp == 0) ? "" : $total_dp."%";?></td>
                </tr>
                      <? 
                          
                          $inc_type_name = $list["type_name"];
                          $group_name = $list["group_name"];
                          $sub_group_name = $list["subgroup_name"];
                          $user_name = $list["user_name"];
                          
                    }
                ?>
                <tr style="background-color: #ebddc4; color: red; font-weight: bold; font-size: 13px;">
                    <td colspan="5">Total Result</td>
                    <td align="right"><?=$rsp_na;?></td>
                    <td align="right"><?=$rsp_cancel;?></td>
                    <td align="right"><?=$rsp_meet;?></td>
                    <td align="right"><?=$rsp_miss;?></td>
                    <td align="right"><?=$rsp_total;?></td>
                    <td align="right"><?=($rsp_total == 0) ? "0%" : round(($rsp_meet/$rsp_total)*100,2)."%";?></td>
                    <td align="right"><?=$rsv_na;?></td>
                    <td align="right"><?=$rsv_cancel;?></td>
                    <td align="right"><?=$rsv_meet;?></td>
                    <td align="right"><?=$rsv_miss;?></td>
                    <td align="right"><?=$rsv_total;?></td>
                    <td align="right"><?=($rsv_total == 0) ? "0%" : round(($rsv_meet/$rsv_total)*100,2)."%";?></td>
                </tr>
                
               <?    
                    
                }else {
                    ?>
                <tr>
                    <td colspan="17" align="center"><b>No incident to display</b></td>
                </tr>     
                        
                    <?
                }
                ?>
                
                
            </table>
        </div>
    </body>     
</html>



