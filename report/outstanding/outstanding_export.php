<?php
set_time_limit(0);
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=outstanding_report.xls");


include_once "../../include/config.inc.php";
include_once "../../include/class/util/dateUtil.class.php";
include_once "outstanding_report.action.php";

$comp_id = $_GET["comp"];
$project_id = $_GET["pj"];
$start_date = $_GET["start"];
$end_date = $_GET["end"];

$class3_fr =  $_GET["c3"];
$class3_to =  $_GET["c3_l"];
if (strUtil::isEmpty($class3_to)) { $class3_to = $class3_fr; }

$zone_fr =  $_GET["zone"];
$zone_to =  $_GET["zone_l"];

//echo "$comp_id // $start_date // $end_date // $class3_fr // $class3_to // $zone_fr // $zone_to";
//exit();

if (strUtil::isEmpty($zone_to)) { $zone_to = $zone_fr; }

$dp_start = dateUtil::thai_date($start_date);
$dp_end = dateUtil::thai_date($end_date);

$display_inc = $_GET["show_to_customer"];
if ($display_inc == "Y"){
    $display_inc = "1";
}else{
    $display_inc = "0,1";
}

$text_head_1 = "ระบบ Helpdesk";
$text_head_2 = "โครงการจ้างพัฒนา บำรุงรักษาและแก้ไขโปรแกรมสำเร็จรูป SAP";
$text_reportname = "รายงานการให้บริการของบริษัท พอร์ทัลเน็ท จำกัด ในช่วงเวลา $dp_start ถึง $dp_end";

$total_balance = 0;
$total_open = 0;
$total_total = 0;
$total_closed_cp = 0;
$total_closed_cc = 0;
$total_closed_nc = 0;
$total_closed = 0; 
$total_pc_closed = 0.0;

$total_outst_new = 0;
$total_outst_assign = 0;
$total_outst_working = 0;
$total_outst_pending = 0;
$total_outst_resolved = 0;
$total_outst_proposeclosed = 0;
$total_outst = 0; 
$total_pc_outst = 0.0;
                        

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
                <tr><td colspan="19"  style="width: 100%; border-bottom:  #cc0000 solid 5px; " align="center"><?=$text_reportname;?></td></tr>
            </table>
        </div><br>

            <table border="1px" cellpadding="3" cellspacing="0" >
                <tr style=" background-color:#B9BCBD">
                    <th colspan="3" align="center">Resolution Product Categories</th>
                    <th rowspan="2" align="center">Balance Forward</th>
                    <th rowspan="2" align="center">Open</th>
                    <th rowspan="2" align="center">Total</th> <!-- forward + open -->
                    <th colspan="3" align="center">Closed</th>
                    <th rowspan="2" align="center">Total Closed</th> <!-- closed -->
                    <th rowspan="2" align="center">Percentage Closed</th> <!-- % close -->
                    <th colspan="6" align="center">Outstanding</th>
                    <th rowspan="2" align="center">Total Outstanding</th> <!-- closed -->
                    <th rowspan="2" align="center">Percentage Outstanding</th> <!-- % close -->
                </tr>
                <tr style=" background-color:#B9BCBD">
                    <th align="center">Class1</th>
                    <th align="center">Class2</th>
                    <th align="center">Class3</th>
                    <!-- closed -->
                    <th align="center">Completed</th> 
                    <th align="center">Cancelled</th>
                    <th align="center">No Contact</th>
                    <!-- outstanding -->
                    <th align="center">New</th> 
                    <th align="center">Assign</th>
                    <th align="center">Working</th>
                    <th align="center">Pending</th> 
                    <th align="center">Resolve</th>
                    <th align="center">Propose Close</th>
                </tr>
                
                
                <?
                
                $arr_class = getClassdata($comp_id,$class3_fr, $class3_to,$project_id,$display_inc);
                if($arr_class["data"]){ $class = $arr_class["data"]; }
                if($arr_class["total_row"]){ $total_row_class = $arr_class["total_row"]; }
                
                if ($class){
                    
                    foreach ($class as $list) {
                        $class1_id = $list["class1_id"];
                        $class2_id = $list["class2_id"];
                        $class3_id = $list["class3_id"];

//                        echo $class1_id . " / " . $class2_id . " / " . $class3_id;
//                        exit();

                        $balance = balanceforward($comp_id,$start_date,$class1_id,$class2_id,$class3_id,$zone_fr,$zone_to,$project_id,$display_inc);
                        $open = open($comp_id,$start_date,$end_date,$class1_id,$class2_id,$class3_id,$zone_fr,$zone_to,$project_id,$display_inc);
                        $total = $balance + $open;
                        
                        $closed_cp = closed_complete($comp_id, $start_date,$end_date,$class1_id,$class2_id,$class3_id,$zone_fr,$zone_to,$project_id,$display_inc);
                        $closed_cc = closed_cancel($comp_id, $start_date,$end_date,$class1_id,$class2_id,$class3_id,$zone_fr,$zone_to,$project_id,$display_inc);
                        $closed_nc = closed_nocontact($comp_id, $start_date,$end_date,$class1_id,$class2_id,$class3_id,$zone_fr,$zone_to,$project_id,$display_inc);
                        $closed = $closed_cp + $closed_cc + $closed_nc;
                        if ($total == 0){
                            $pc_closed = 0;
                        }else {
                            $pc_closed = round(($closed/$total)*100,2);
                        }
                        
                        
                        $outst_all = outstanding_all($comp_id,$end_date,$class1_id,$class2_id,$class3_id,$zone_fr,$zone_to,$project_id,$display_inc);
                        
                        $outst_new = 0;
                        $outst_assign = 0;
                        $outst_working = 0;
                        $outst_pending = 0;
                        $outst_resolved = 0;
                        $outst_proposeclosed = 0;
                        $outst = 0;
                        
                        if($outst_all["data"]){ 
                            $outst_list = $outst_all["data"]; 
                            foreach ($outst_list as $sub_list) {
                                if ($sub_list["status"] == 'N'){
                                   $outst_new += 1; 
                                }else if ($sub_list["status"] == 'A'){
                                   $outst_assign += 1; 
                                }else if ($sub_list["status"] == 'W'){
                                   $outst_working += 1; 
                                }else if ($sub_list["status"] == 'P'){
                                   $outst_pending += 1; 
                                }else if ($sub_list["status"] == 'R'){
                                   $outst_resolved += 1; 
                                }else if ($sub_list["status"] == 'PP'){
                                   $outst_proposeclosed += 1; 
                                }
                                $outst += 1;
                            }
                        }
                        
                        if ($total == 0){
                            $pc_outst = 0;
                        }else {
                            $pc_outst = round(($outst/$total)*100,2);
                        }
                        
                        if ($balance != 0 ||  $open != 0 || 
                                $closed_cp != 0 || $closed_cc != 0 || $closed_nc != 0 ||
                                $outst_new != 0 || $outst_assign != 0 || $outst_working != 0 || 
                                $outst_pending != 0 || $outst_resolved != 0 || $outst_proposeclosed != 0 ){
                            
                        ?>
                           <tr>
                                <td align="left" width="10%"><?=$list["class1_name"];?></td>
                                <td align="left" width="10%"><?=$list["class2_name"];?></td>
                                <td align="left" width="15%"><?=$list["class3_name"];?></td>
                                <td align="center" width="5%"><?=($balance == 0) ? "" : $balance;?></td>
                                <td align="center" width="5%"><?=($open == 0) ? "" : $open;?></td>
                                <td align="center" width="5%"><?=($total == 0) ? "" : $total;?></td> <!-- balance + open -->
                                <td align="center" width="5%"><?=($closed_cp == 0) ? "" : $closed_cp;?></td>
                                <td align="center" width="5%"><?=($closed_cc == 0) ? "" : $closed_cc;?></td>
                                <td align="center" width="5%"><?=($closed_nc == 0) ? "" : $closed_nc;?></td>
                                <td align="center" width="5%"><?=($closed == 0) ? "" : $closed;?></td> <!-- total closed -->
                                <td align="center" width="5%"><?=($pc_closed == 0) ? "" : $pc_closed."%";?></td> <!-- pc closed -->
                                <td align="center" width="5%"><?=($outst_new == 0) ? "" : $outst_new;?></td>
                                <td align="center" width="5%"><?=($outst_assign == 0) ? "" : $outst_assign;?></td>
                                <td align="center" width="5%"><?=($outst_working == 0) ? "" : $outst_working;?></td>
                                <td align="center" width="5%"><?=($outst_pending == 0) ? "" : $outst_pending;?></td>
                                <td align="center" width="5%"><?=($outst_resolved ==0) ? "" : $outst_resolved;?></td>
                                <td align="center" width="5%"><?=($outst_proposeclosed == 0) ? "" : $outst_proposeclosed?></td>
                                <td align="center" width="5%"><?=($outst == 0) ? "" : $outst;?></td> <!-- total out -->
                                <td align="center" width="5%"><?=($pc_outst == 0) ? "" : $pc_outst."%";?></td> <!-- pc out -->
                           </tr>     
                        <?
                            
                        $total_balance += $balance;
                        $total_open += $open;
                        $total_total += $total;
                        
                        $total_closed_cp += $closed_cp;
                        $total_closed_cc += $closed_cc;
                        $total_closed_nc += $closed_nc;
                        $total_closed += $closed;
                        $total_pc_closed += $pc_closed;

                        $total_outst_new += $outst_new;
                        $total_outst_assign += $outst_assign;
                        $total_outst_working += $outst_working;
                        $total_outst_pending += $outst_pending;
                        $total_outst_resolved += $outst_resolved;
                        $total_outst_proposeclosed  += $outst_proposeclosed;
                        $total_outst += $outst;
                        $total_pc_outst += $pc_outst;
                            
                        } 
                        
                    }
                    
                }
                
                if ($total_total == 0){
                    $total_pc_closed = 0;
                    $total_pc_outst = 0;
                }else {
                    $total_pc_closed = round(($total_closed/$total_total)*100,2);
                    $total_pc_outst = round(($total_outst/$total_total)*100,2);
                }
                
                
                ?>
                <tr style=" background-color:#ebddc4; font-weight: bold; color: red;">
                    <td align="left" colspan="3" class="totalAll">Total</td>
                    <td align="center" class="totalAll"><?=$total_balance;?></td>
                    <td align="center" class="totalAll"><?=$total_open;;?></td>
                    <td align="center" class="totalAll"><?=$total_total;;?></td> <!-- forward + open -->
                    <td align="center" class="totalAll"><?=$total_closed_cp;?></td>
                    <td align="center" class="totalAll"><?=$total_closed_cc;?></td>
                    <td align="center" class="totalAll"><?=$total_closed_nc;?></td>
                    <td align="center" class="totalAll"><?=$total_closed;?></td> <!-- closed -->
                    <td align="center" class="totalAll"><?=$total_pc_closed."%";?></td> <!-- pc closed -->
                    <td align="center" class="totalAll"><?=$total_outst_new;?></td>
                    <td align="center" class="totalAll"><?=$total_outst_assign;?></td>
                    <td align="center" class="totalAll"><?=$total_outst_working;?></td>
                    <td align="center" class="totalAll"><?=$total_outst_pending;?></td>
                    <td align="center" class="totalAll"><?=$total_outst_resolved;?></td>
                    <td align="center" class="totalAll"><?=$total_outst_proposeclosed;?></td>
                    <td align="center" class="totalAll"><?=$total_outst;?></td> <!-- out -->
                    <td align="center" class="totalAll"><?=$total_pc_outst."%";?></td> <!-- pc out -->
                    
                </tr>
                
            </table>
