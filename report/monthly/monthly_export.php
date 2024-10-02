<?php
set_time_limit(10000);
header('Content-Type: text/html; charset=tis-620');
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=monthly_report.xls");

include_once "../../include/class/user_session.class.php";
include_once '../../include/config.inc.php';
include_once '../../include/class/util/dateUtil.class.php';
include_once "../../include/error_message.php";

$comp_id = $_GET["comp"];
$project_id = $_GET["pj"];
$start_date = $_GET["start"];
$end_date = $_GET["end"];
	
$display_inc = $_GET["show_to_customer"];
if ($display_inc == "Y"){
    $display_inc = "1";
}else{
    $display_inc = "0,1";
}


$dp_start = dateUtil::thai_date($start_date);
$dp_end = dateUtil::thai_date($end_date);


$text_head_1 = "ระบบ Helpdesk";
$text_head_2 = "โครงการจ้างพัฒนา บำรุงรักษาและแก้ไขโปรแกรมสำเร็จรูป SAP";
$text_reportname = "รายงานการให้บริการของบริษัท พอร์ทัลเน็ท จำกัด ในช่วงเวลา $dp_start ถึง $dp_end";


include_once 'monthly_report.action.php';
if ($chk_dup_data != 0) {
    echo "<script type='text/javascript'>
    alert('มีรายการในช่วงเวลาที่คุณเลือกอยู่แล้ว กรุณาเลือกวันที่ให้ถูกต้อง')
    window.close();
    </script>";
}
if($criteria["arr_criteria"]){ $arr_criteria = $criteria["arr_criteria"]; }
if($criteria["total_row"]){ $total_row_criteria = $criteria["total_row"]; }

$pea = array();

$grandtotal_pea = array();
$grandtotal_total = 0;

//echo $_SERVER["PHP_SELF"];

//additional part
$report_id = "";
$response_id = "";
$final = "";
$report_type_id = 7; // monthly report
$$additional = array();
$additional_text = array();

$additional = getadditional($comp_id,$start_date,$end_date,$report_type_id,$project_id);
if ($additional){
    $additional_text = $additional["data"];
    
    foreach ($additional["data"] as $value) {
        $report_id = $value["id"];
        $response_id = $value["response_id"];
        $final = $value["final"];
        $additional_text = array(
            "text1" => $value["text1"],
            "text2" => $value["text2"],
            "text3" => $value["text3"],
            "text4" => $value["text4"],
            "text5" => $value["text5"],
            "text6" => $value["text6"],
            "text7" => $value["text7"],
            "text8" => $value["text8"],
            "text9" => $value["text9"],
            "text10" => $value["text10"],
            "text11" => $value["text11"],
            "text12" => $value["text12"],
            "text13" => $value["text13"],
            "text14" => $value["text14"],
            "text15" => $value["text15"],
            "text16" => $value["text16"],
            "text17" => $value["text17"],
            "text18" => $value["text18"],
            "BPM_text1" => $value["BPM_text1"],
            "BPM_text2" => $value["BPM_text2"],
            "BPM_text3" => $value["BPM_text3"],
            "BPM_text4" => $value["BPM_text4"],
            "BPM_text5" => $value["BPM_text5"],
            "BPM_text6" => $value["BPM_text6"],
            "BPM_text7" => $value["BPM_text7"],
            "BPM_text8" => $value["BPM_text8"],
            "BPM_text9" => $value["BPM_text9"],
            "BPM_text10" => $value["BPM_text10"],
            "BPM_text11" => $value["BPM_text11"],
            "BPM_text12" => $value["BPM_text12"],
            "BPM_text13" => $value["BPM_text13"],
            "BPM_text14" => $value["BPM_text14"],
            "BPM_text15" => $value["BPM_text15"],
            "BPM_text16" => $value["BPM_text16"],
            "BPM_text17" => $value["BPM_text17"],
            "BPM_text18" => $value["BPM_text18"]
        );
    }
}
$total_percentage = 0;

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
			<? include_once '../common/report_header_export.php'; ?>
			<!--
            <table style="color: black; font-weight: bold; font-size: 20px; ">
				<tr><td colspan="<?=$total_row_criteria+3;?>"  style="width: 100%; border-bottom:  #cc0000 solid 5px; " align="center">ชื่อลูกค้า : <?=user_session::get_user_company_name()?></td></tr>
				<tr><td colspan="<?=$total_row_criteria+3;?>"  style="width: 100%; border-bottom:  #cc0000 solid 5px; " align="center">ชื่อโครงการ : <?=$project_name?></td></tr>
                <tr><td colspan="<?=$total_row_criteria+3;?>"  style="width: 100%; border-bottom:  #cc0000 solid 5px; " align="center"><?=$text_reportname;?></td></tr>
            </table>
			-->
        </div><br>
        
            <table border="1px">
                <tr style=" background-color:#B9BCBD">
                    <th align="center" width="20%">Module</th>
                    <th align="center" width="10%">Quantity & Percentage</th>
                    
            <?
                if (count($arr_criteria) > 0){ 
                    $i = 0;
                    foreach ($arr_criteria as $list) {
                        $pea[$i] = $list["zone_id"];
                        $grandtotal_pea[$i] = 0;
                ?>
                    <th align="center" width="5%"><div class="rotate" ><?=$list["name"];?></div></th>
                <?
                    $i++;
                    }
                }
            ?>
                    <th align="center" width="5%"><span style="color: #cc0000;">Grand Total: #Ticket/%Ticket</span></th>
                </tr>
                
                <?
                    $incident_type = getincidenttype($comp_id,$display_inc);
                    foreach ($incident_type as $list) {
                        
                        $incident_type_id = $list["ident_type_id"];
                        $total_bytype = 0;
                        
                        ?>
                <tr style=" background-color:#B9BCBD">
                    <td colspan="2" style="background-color: #F3E2A9; font-weight: bold; color: #178AEB;" ><?=$list["ident_type_desc"];?></td>
                    <?
                            // count incident by type,zone
                            $count_byzone = array();
                        for ($index = 0; $index < count($pea); $index++) {
                            $zone_id = $pea[$index];
                            $count_byzone[$index] = countIncident_typezone($comp_id,$incident_type_id,$start_date,$end_date,$zone_id,$project_id,$display_inc);
                            $total_bytype += $count_byzone[$index];
                            
                            
                            //Grand Total
                            $grandtotal_pea[$index] += $count_byzone[$index];
                            $grandtotal_total += $count_byzone[$index];
                            
                                
                    ?>
                    
                    <td style="background-color: #F3E2A9; font-weight: bold; color: #178AEB;"  align="right"><?= $count_byzone[$index];?></td>
                    
                    <?
                        }//end count incident type by zone
                    ?>
                    <td style="background-color: #F3E2A9; font-weight: bold; color: #178AEB;" align="right"><span style="color: #cc0000;"><?=$total_bytype;?></span></td>
                </tr>
                    <?
                        //get resolved product class3 master
                        $class3 = getclass3($comp_id);
                        if (count($class3) > 0){ 
                            foreach ($class3 as $list){
                                $class3_id = $list["prd_tier_id"];
                                $class3_name = $list["prd_tier_name"];
                                $count_class3 = array();
                                $total_count_class3 = 0;
                                
                                //loop to count incident class3 by zone
                                for ($index = 0; $index < count($pea); $index++) {
                                    $zone_id = $pea[$index];
                                    $count_class3[$index] = countIncident_typezoneclass3($comp_id,$incident_type_id,$class3_id,$start_date,$end_date,$zone_id,$project_id,$display_inc);
                                    $total_count_class3 += $count_class3[$index];

                                }
                                
                                // if has data : write <tr>
                                if ($total_count_class3 != 0){
                                ?>
                <!--  ============ จำนวน Ticket ===================== --> 
                <tr>
                    <td align="left" style="background-color: #E6E0F8;"><?=$class3_name;?></td>
                    <td align="left" style="background-color: #E6E0F8;">จำนวน Ticket</td>
                                <?  // write count zone
                                    for ($index = 0; $index < count($count_class3); $index++) {
                                    ?>
                    <td align="right" style="background-color: #E6E0F8;"><?=($count_class3[$index] == 0) ? "":$count_class3[$index];?></td>
                                    <?
                                    
                                    }
                                    
                                    ?>
                    <td align="right" style="background-color: #E6E0F8;"><span style="color: #cc0000;"><?=$total_count_class3;?></span></td>
                </tr> <!-- end จำนวน Ticket -->  
                
                <!--  ============ % เทียบตาม Module ===================== --> 
                <tr>
                    <td align="left" >&nbsp;</td>
                    <td align="left" >% เทียบตาม Module</td>
                                <?  // write count zone
                                    for ($index = 0; $index < count($count_class3); $index++) {
                                        $percentage = 0.0;
                                        if ($count_class3[$index] != 0){
                                           $percentage =  ($count_class3[$index]/$total_count_class3)*100;
                                        }
                                    ?>
                    <td align="right" ><?=(round($percentage,2) == 0) ? "" : round($percentage,2)."%"; ?></td>
                                    <?
                                    
                                    }
                                    
                                    $total_percentage = ($total_count_class3/$total_bytype)*100;
                                    ?>
                    <td rowspan="2" align="right" ><span style="color: #FF4000;"><?=  round($total_percentage,2). "%";?></span></td>
                </tr> <!-- end เทียบตาม Module -->  
                
                <!--  ============ % เทียบตามเขต กฟภ. ===================== --> 
                <tr>
                    <td align="left" >&nbsp;</td>
                    <td align="left">% เทียบตามเขต.</td>
                                <?  // write count zone
                                    for ($index = 0; $index < count($count_class3); $index++) {
                                        $percentage = 0.0;
                                        if ($count_class3[$index] != 0){
                                            if ($count_byzone[$index] == 0){
                                                $percentage = 0;
                                            }else {
                                                $percentage =  ($count_class3[$index]/$count_byzone[$index])*100;
                                            }
                                           
                                        }
                                    ?>
                    <td align="right" ><?=(round($percentage,2) == 0) ? "" : round($percentage,2)."%"; ?></td>
                                    <?
                                    
                                    }
                                    
//                                    $total_percentage = ($total_count_class3/$total_bytype)*100;
                                    ?>
                   </tr> <!-- end เทียบตาม Module -->  
                
                
                                        <?
                                }//end check has data to write
                            }//end loop master class3
                        }//end if master class3
                     
                    }// end loop incident_type master
                
                ?>
                   
                   <tr style=" background-color:#ebddc4; font-weight: bold; color: red;">
                       <td align="left" colspan="2" >Grand Total</td>
                       <?
                        foreach ($grandtotal_pea as $value) {
                            ?>
                        <td align="right"><?=$value;?></td>
                             <?
                        }
                    ?>
                     <td align="right"><?=$grandtotal_total;?></td>
                   </tr>
                
                
                
            </table>

        <br> <br>
        <input type="hidden" id="comp_id" name="comp_id" value="<?= $_GET["comp"];?>" />
        <input type="hidden" id="start_date" name="start_date" value="<?= $_GET["start"];?>" />
        <input type="hidden" id="end_date" name="end_date" value="<?= $_GET["end"];?>" />
        <input type="hidden" id="report_type_id" name="report_type_id" value="7" />
        
      
        
    </body>
</html>
