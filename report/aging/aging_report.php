<?php
include_once '../../include/config.inc.php';
include_once '../../include/template/index_report.tpl.php';
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


<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <meta name="viewport" content="width=620" />
        <title>Incident Aging Report</title>
        <link type="text/css" rel="stylesheet" href="../../include/css/report.css"/>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#export_excel").click(function(){
//                alert('aa');
                var url = 'aging_export.php' 
                    + '?comp=' + <?=$_GET["comp"];?> 
                    + '&start=' + <?=$_GET["start"];?> 
                    + '&c3=' + $("#c3").val() 
                    + '&c3_l=' +  $("#c3_l").val()
                    + '&pj=' + $("#pj").val()
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
        <input type="hidden" id="c3" name ="c3" value="<?=$_GET["c3"];?>" />
        <input type="hidden" id="c3_l" name ="c3_l" value="<?=$_GET["c3_l"];?>" />
        <input type="hidden" id="pj" name ="pj" value="<?=$_GET["pj"];?>" />
        <input type="hidden" id="show_to_customer" name ="show_to_customer" value="<?=$_GET["show_to_customer"];?>" />
        <div name="Data">
            <table id="tb_data">
                <tr>
                    <th rowspan="2" align="center">Incident Type</th>
                    <th colspan="3" align="center">Resolution Product Categories</th>
                    <th colspan="<?=$total_row_criteria;?>" align="center">Incident Age (days)</th>
                    <th rowspan="2" align="center"><span class="total"><b>Total</b></span></th>
                </tr>
                <tr>
                    <th align="center">Class 1</th>
                    <th align="center">Class 2</th>
                    <th align="center">Class 3</th>
                    <?
                    if (count($arr_criteria) > 0){ 
                        foreach ($arr_criteria as $list) {
//                            $dp_text = $list["shortname"]
                            
                            ?>
                                <th align="center"><?=$list["shortname"];?></th>
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
                    <td align="center" class="total"  width="5%"><?=$count_incident_total;?></td>       
                        
                        <?
                }// end loop through  $data_class
            }
                ?>
                
                    
                <!--=============== Total Row ================= -->
                <tr>
                    <td colspan="4" align="left" class="totalAll">Total</td>
                    <?
                        foreach ($total_all_count as $value) {
                            ?>
                     <td align="center" class="totalAll"><?=$value;?></td>
                             <?
                        }
                    ?>
                     <td align="center" class="totalAll"><?=$total_all_total;?></td>
                </tr>
                 <!--========================================== -->
<!--                <tr class="nonborder">
                    <td width="10%" class="nonborder"></td>
                    <td width="15%" class="nonborder"></td>
                    <td width="20%" class="nonborder"></td>
                    <td width="20%" class="nonborder"></td>
                    <td width="5%" class="nonborder"></td>
                    <td width="5%" class="nonborder"></td>
                    <td width="5%" class="nonborder"></td>
                    <td width="5%" class="nonborder"></td>
                    <td width="5%" class="nonborder"></td>
                    <td width="5%" class="nonborder"></td>
                    <td width="5%" class="nonborder"></td>
                    
                </tr>-->
            </table>
            
        </div>


    </body>
</html>
