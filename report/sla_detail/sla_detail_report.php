<?php
set_time_limit(3000);
include_once '../../include/config.inc.php';
include_once '../../include/template/index_report.tpl.php';
include_once "../../include/error_message.php";
include_once "../../include/function.php";
include_once "../../include/class/user_session.class.php";
include_once "../../include/class/util/strUtil.class.php";
include_once "../../include/class/util/dateUtil.class.php";
include_once "../../include/class/db/db.php";
include_once "../../include/class/model/sla_report.class.php";
include_once "../../include/class/model/report.class.php";
include_once "../../include/handler/action_handler.php";


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
    "reference_to" => ($_GET["ref2"] == "") ? $_GET["ref1"]:$_GET["ref2"] , 
    "display_inc" => ($_GET["show_to_customer"] == "Y" ? "1":"0,1")
);

function getcustomerinfo($comp_id){
        global $data,$db;
        $report = new report($db);
        $data =  $report->getCustomerInfo($comp_id);
	return $data;
}


global $sla_report ,$db, $filter, $customerinfo;

$customerinfo = getcustomerinfo($_GET["c"]); 
$sla_report = new sla_report($db);
        
$result = $sla_report->get_sla_detail($filter);
//echo print_r($criterai["data"]);
//exit();

$print = "N";


$dp_start = dateUtil::thai_date($filter["start_date"]);
$dp_end = dateUtil::thai_date($filter["end_date"]);

$text_head_1 = "ระบบ Helpdesk";
$text_head_2 = "โครงการจ้างพัฒนา บำรุงรักษาและแก้ไขโปรแกรมสำเร็จรูป SAP";
$text_reportname = "รายงาน SLA Detail ในช่วงเวลา $dp_start ถึง $dp_end";

if($result["data"]){ $arr_result = $result["data"]; }
if($result["total_rows"]){ $total_row = $result["total_rows"]; }



?>

<html>
    <head>
        <meta charset=utf-8 />
        <meta name="viewport" content="width=620" />
        <title>Service Level Agreement Detail Report</title>
        <link type="text/css" rel="stylesheet" href="../../include/css/report.css"/>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#export_excel").click(function(){

                            var url = 'sla_detail_export.php' 
                                + '?c=' + $("#c").val() 
                                + '&d1=' + $("#d1").val() 
                                + '&d2=' + $("#d2").val() 
                                + '&pj=' + $("#pj").val() 
                                + '&t1=' + $("#t1").val() 
                                + '&t2=' + $("#t2").val() 
                                + '&s1=' + $("#s1").val() 
                                + '&s2=' + $("#s2").val() 
                                + '&p1=' + $("#p1").val() 
                                + '&p2=' + $("#p2").val() 
                                + '&pg=' + $("#pg").val() 
                                + '&psg=' + $("#psg").val() 
                                + '&vg=' + $("#vg").val() 
                                + '&vsg=' + $("#vsg").val()
                                + '&rp=' + $("#rp").val() 
                                + '&rs=' + $("#rs").val() 
                                + '&o=' + $("#o").val() 
                                + '&ref1=' + $("#ref1").val() 
                                + '&ref2=' + $("#ref2").val() 
                                + '&show_to_customer=' + $("#show_to_customer").val();
                window.open(url, '',''); 
              });
            
        });
            
        </script>
    </head>
    <body>
        <?
            include_once '../common/export.php';
            include_once '../common/report_header.php';
        ?>
        <br>
        <input id="c" name="c" value="<?=$_GET["c"];?>" type="hidden"/>
        <input id="d1" name="d1" value="<?=$_GET["d1"];?>"  type="hidden"/>
        <input id="d2" name="d2" value="<?=$_GET["d2"];?>"  type="hidden"/>
        <input id="pj" name="pj" value="<?=$_GET["pj"];?>"  type="hidden"/>
        <input id="t1" name="t1" value="<?=$_GET["t1"];?>"  type="hidden"/>
        <input id="t2" name="t2" value="<?=$_GET["t2"];?>"  type="hidden"/>
        <input id="s1" name="s1" value="<?=$_GET["s1"];?>"  type="hidden"/>
        <input id="s2" name="s2" value="<?=$_GET["s2"];?>"  type="hidden"/>
        <input id="p1" name="p1" value="<?=$_GET["p1"];?>"  type="hidden"/>
        <input id="p2" name="p2" value="<?=$_GET["p2"];?>"  type="hidden"/>
        <input id="pg" name="pg" value="<?=$_GET["pg"];?>"  type="hidden"/>
        <input id="psg" name="psg" value="<?=$_GET["psg"];?>"  type="hidden"/>
        <input id="vg" name="vg" value="<?=$_GET["vg"];?>"  type="hidden"/>
        <input id="vsg" name="vsg" value="<?=$_GET["vsg"];?>"  type="hidden"/>
        <input id="rp" name="rp" value="<?=$_GET["rp"];?>"  type="hidden"/>
        <input id="rs" name="rs" value="<?=$_GET["rs"];?>"  type="hidden"/>
        <input id="o" name="o" value="<?=$_GET["o"];?>"  type="hidden"/>
        <input id="ref1" name="ref1" value="<?=$_GET["ref1"];?>"  type="hidden"/>
        <input id="ref2" name="ref2" value="<?=$_GET["ref2"];?>"  type="hidden"/>
        <input type="hidden" id="show_to_customer" name ="show_to_customer" value="<?=$_GET["show_to_customer"];?>" />
               
        <div name="Data">
            <table id="tb_data" style="border: 0.5px; width: 3040px" cellpadding="3" cellspacing="0" >
                <tr>
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
                <tr>
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
                    <td style="width: 80px"><?=$list["inc_id"];?></td>
                    <td style="width: 120px"><?=$list["inc_type_name"];?></td>
                    <td style="width: 70px" align="center"><?=$inc_date;?></td>
                    <td style="width: 50px"><?=$list["priority_name"];?></td>
                    <td style="width: 100px"><?=$list["owner_name"];?></td>
                    <td style="width: 100px"><?=$list["responded_by"];?></td>
                    <td style="width: 120px"><?=$list["cas_opr_name_1"];?></td>
                    <td style="width: 120px"><?=$list["cas_opr_name_2"];?></td>
                    <td style="width: 200px"><?=$list["cas_opr_name_3"];?></td>
                    <td style="width: 120px"><?=$list["cas_prd_name_1"];?></td>
                    <td style="width: 120px"><?=$list["cas_prd_name_2"];?></td>
                    <td style="width: 200px"><?=$list["cas_prd_name_3"];?></td>
                    <td style="width: 100px"><?=$list["resolved_by"];?></td>
                    <td style="width: 120px"><?=$list["res_opr_name_1"];?></td>
                    <td style="width: 120px"><?=$list["res_opr_name_2"];?></td>
                    <td style="width: 200px"><?=$list["res_opr_name_3"];?></td>
                    <td style="width: 120px"><?=$list["res_prd_name_1"];?></td>
                    <td style="width: 120px"><?=$list["res_prd_name_2"];?></td>
                    <td style="width: 200px"><?=$list["res_prd_name_3"];?></td>
                    <td style="width: 70px" align="center"><?=$assign_date;?></td>
                    <td style="width: 70px" align="center"><?=$working_date;?></td>
                    <td style="width: 50px" align="center"><?=($list["resp_holiday"] == '00:00:00') ? "" : $list["resp_holiday"];?></td>
                    <td style="width: 50px" align="center"><?=($list["actual_resp"] == '00"00"00') ? "" : $list["actual_resp"];?></td>
                    <td style="width: 70px" align="center"><?=$resolved_date;?></td>
                    <td style="width: 50px" align="center"><?=($list["resv_pending"] == '00:00:00') ? "" : $list["resv_pending"];?></td>
                    <td style="width: 50px" align="center"><?=($list["resv_holiday"] == '00:00:00') ? "" : $list["resv_holiday"];?></td>
                    <td style="width: 50px" align="center"><?=($list["actual_resv"] == '00:00:00') ? "" : $list["actual_resv"];?></td>
                    <td style="width: 50px" align="center"><?=($list["respond_sla"] == '00:00:00') ? "" : $list["respond_sla"];?></td>
                    <td style="width: 50px" align="center"><?=($list["resolve_sla"] == '00:00:00') ? "" : $list["resolve_sla"];?></td>
                    <td style="width: 50px" align="center"><?=$list["respond_sla_result"];?></td>
                    <td style="width: 50px" align="center"><?=$list["resolve_sla_resilt"];?></td>
                    
                </tr>
                          
                          
                          
                          <?  
                    }
                    
                }
                
                
                ?>
                
            </table>
        </div>
    </body>     
</html>



