<?php
header('Content-Type: text/html; charset=tis-620');
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=aging_report.xls");
    
include_once '../../include/config.inc.php';
include_once '../../include/class/util/dateUtil.class.php';
include_once 'aging_report.action.php';

if($criteria["arr_criteria"]){ $arr_criteria = $criteria["arr_criteria"]; }
if($criteria["total_row"]){ $total_row_criteria = $criteria["total_row"]; }

//echo $total_row;
//exit();
    
    
$comp_id = $_GET["comp"];
$project_id = $_GET["pj"]; 
$start_date = $_GET["start"];
//$end_date = $_GET["end"];

$dp_start = dateUtil::thai_date($start_date);
//$dp_end = dateUtil::thai_date($end_date);

$class3_fr =  $_GET["c3"];
$class3_to =  $_GET["c3_l"];
if (strUtil::isEmpty($class3_to)) { $class3_to = $class3_fr; }

$display_inc = $_GET["show_to_customer"];
if ($display_inc == "Y"){
    $display_inc = "1";
}else{
    $display_inc = "0,1";
}


$text_head_1 = "ระบบ Helpdesk";
$text_head_2 = "โครงการจ้างพัฒนา บำรุงรักษาและแก้ไขโปรแกรมสำเร็จรูป SAP";
$text_reportname = "รายงานการให้บริการของบริษัท พอร์ทัลเน็ท จำกัด ตามอายุ Incident ณ $dp_start ";


// total all var[ for sum all val.]
$total_all_total = 0;
$total_all_count = array();

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
                <tr><td colspan="<?=$total_row_criteria+5;?>"  style="width: 100%; border-bottom:  #cc0000 solid 5px; " align="center"><?=$text_reportname;?></td></tr>
            </table>
        </div><br>


        <!--<div name="Data">-->
            <table border="1px">
                <tr >
                    <th style=" background-color:#B9BCBD" rowspan="2" align="center">Incident Type</th>
                    <th style=" background-color:#B9BCBD" colspan="3" align="center">Resolution Product Categories</th>
                    <th style=" background-color:#B9BCBD" colspan="<?=$total_row_criteria;?>" align="center">Incident Age (days)</th>
                    <th style=" background-color:#B9BCBD" rowspan="2" align="center"><span class="total"><b>Total</b></span></th>
                </tr>
                <tr >
                    <th style=" background-color:#B9BCBD" align="center">Class 1</th>
                    <th style=" background-color:#B9BCBD" align="center">Class 2</th>
                    <th style=" background-color:#B9BCBD" align="center">Class 3</th>
                    <?
                    if (count($arr_criteria) > 0){ 
                        foreach ($arr_criteria as $list) {
//                            $dp_text = $list["shortname"]
                            
                            ?>
                                <th style=" background-color:#B9BCBD" align="center"><?=$list["shortname"];?></th>
                            <?

                        }
                    }
                    
                    ?>
                </tr>
                
                <?
                $arr_class = getclass_data($comp_id, $start_date,$class3_fr, $class3_to,$project_id ,$display_inc);
                if($arr_class["data"]){ 
                    
                    $data_class = $arr_class["data"]; 
                    foreach ($data_class as $list) {
                        $count_incident_total = 0;
                        //get id to count incident
                        $inc_type_id = $list["inc_type_id"];
                        $class1_id = $list["class1_id"];
                        $class2_id = $list["class2_id"];
                        $class3_id = $list["class3_id"];
                 ?>
                <tr>
                    <td align="left" width="10%"><?=$list["inc_type_name"];?></td>
                    <td align="left" width="15%"><?=$list["class1_name"];?></td>
                    <td align="left" width="15%"><?=$list["class2_name"];?></td>
                    <td align="left" width="15%"><?=$list["class3_name"];?></td>         
                <?
                    
                      for ($crit = 0; $crit <  $total_row_criteria ; $crit++) {
    //                     $ar_next = $crit + 1;
                         
                         $score_from = $arr_criteria[$crit]["value"];
                         if ($crit == $total_row_criteria){
                              $score_to = 0;
                         }else {
                              $score_to =  $arr_criteria[$crit+1]["value"];
                         }

                         $count_incident = countincident($comp_id,$start_date,$inc_type_id,$class1_id,$class2_id,$class3_id,$score_from,$score_to ,$project_id,$display_inc);
                         $count_incident_total += $count_incident;
                         $total_all_count[$crit] += $count_incident;
                         
//                         echo $total_all_count[0];
                         
                         
                     ?>
                    <td align="center"  width="5%"><?=($count_incident == 0) ? "": $count_incident;?></td>      
                            
                            
                <?
                
                    }// end count incident
                    
                    $total_all_total += $count_incident_total;
                    
                    ?>
                    <td align="center" style="color: #cc0000;"  width="5%"><?=$count_incident_total;?></td>       
                        
                        <?
                }// end loop through  $data_class
            }
                ?>
                
                    
                <!--=============== Total Row ================= -->
                <tr>
                    <td colspan="4" align="left"  style="background-color: #ebddc4;color: red; font-weight: bold;">Total</td>
                    <?
                        foreach ($total_all_count as $value) {
                            ?>
                     <td align="center" style="background-color: #ebddc4;color: red; font-weight: bold;"><?=$value;?></td>
                             <?
                        }
                    ?>
                     <td align="center" style="background-color: #ebddc4;color: red; font-weight: bold;"><?=$total_all_total;?></td>
                </tr>
            </table>
            
        <!--</div>-->


    </body>
</html>
