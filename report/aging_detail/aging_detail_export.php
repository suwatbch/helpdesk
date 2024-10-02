<?php

//    header("Pragma: no-cache");
//    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//    header("Content-type: application/vnd.ms-excel");
//    header("Content-Disposition: attachment; filename=incident_detail_report.xls");
    
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=aging_detail_report.xls");
    
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/report_aging_detail.class.php";
    
    global $report_detail ,$db;
    $criterai =array(
              "cus_company_id" => $_GET["comp"]
            , "customer_zone_id" => $_GET["zone"]
            , "customer_zone_id_l" => $_GET["zone_l"]
            , "prd_tier_id3" => $_GET["c3"]
            , "prd_tier_id3_l" => $_GET["c3_l"]
            , "project_id" => $_GET["pj"]
            , "inc_date" => $_GET["start"]
        );
    $report_detail = new report_aging_detail($db); 
    $s_product_class = $report_detail->get_product_class($criterai);
    $s_arr_product_class = $s_product_class["arr_product_class"];
    $s_total_rows_product_class = $s_product_class["total_row_product_class"];


$comp_id = $_GET["comp"];
$start_date = $_GET["start"];

$dp_start = dateUtil::thai_date($start_date);


$text_head_1 = "ระบบ Helpdesk";
$text_head_2 = "โครงการจ้างพัฒนา บำรุงรักษาและแก้ไขโปรแกรมสำเร็จรูป SAP";
$text_reportname = "รายงานรายละเอียด Incident ตามอายุ ของวันที่ $dp_start";

?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"

xmlns:x="urn:schemas-microsoft-com:office:excel"

xmlns="http://www.w3.org/TR/REC-html40">

<HTML>

<HEAD>

<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

</HEAD>
    <body>
         <?
                        if($s_total_rows_product_class > 0){
                        foreach ($s_arr_product_class as $arr_product){
            $s_report_inc = $report_detail->getReportDetail($criterai,$arr_product["prd_id1"],$arr_product["prd_id2"],$arr_product["prd_id3"],$_GET["show_to_customer"]);
            $s_arr_inc = $s_report_inc["arr_criteria"];
            $s_total_rows_inc = $s_report_inc["total_row"];
            
            if($s_total_rows_inc > 0){
                    ?>
             <table border="1" cellpadding="3" cellspacing="0">
               
                <tr style=" background-color:  #00BBFF">

                    <th align="center" colspan="3">Product Classification</th>
                </tr>
                <tr style=" background-color:#00BBFF">
                    <th colspan="1" align="center">Product Class 1 : <?=$arr_product["prd_name1"]?> </th>
                    <th align="center" >Product Class 2 : <?=$arr_product["prd_name2"];?></th>
                    <th align="center">Product Class 3 : <?=$arr_product["prd_name3"];?></th>
                    
                </tr>
              
            </table>
            <table border="1" cellpadding="3" cellspacing="0" width="100%">
               
                <tr style=" background-color:#B9BCBD">
                    <th align="center" width="3%">ลำดับ</th>
                    <th align="center" width="7%">Incident Age</th>
                    <th align="center" width="7%" >Incident No</th>
                    <th align="center" width="7%">Incident Type</th>
                    <th allign="center" width="7%">Incident Date</th>
                    <th allign="center" width="8%">Reference No</th>
                    <th allign="center" width="7%">Customer Area</th>
                    <th allign="center" width="8%">Customer Name</th>
                    <th allign="center" width="7%">Owner</th>
                    <th allign="center">Summarize</th>
                    <th allign="center">Detail</th>
                    <th allign="center">Resolution</th>
                    <th allign="center" width="5%">Status</th>
                    <th allign="center" width="5%">Status Reason</th>
                    
                </tr>
               <? 
               $index = 1;
               foreach ($s_arr_inc as $arr_inc){ 
                    $s_total_aging = $report_detail->get_aging();
                    $arr_aging = $s_total_aging["arr_aging"];
                    foreach ($arr_aging as $ss_aging){
                        if($arr_inc["total_date"] >= $ss_aging["value"] ){
                            $total_aging = $ss_aging["value"];
                        }
                    }
                   ?>
                <tr>
                    <td><?=$index++;?></td>
                    <td align="center"><?= '>='.$total_aging?></td>
                    <td><?=$arr_inc["ident_id_run_project"];?></td>
                    <td><?=$arr_inc["ident_type_desc"];?></td>
                    <td><?=$arr_inc["create_date"];?></td>
                    <td><?=$arr_inc["reference_no"];?></td>
                    <td><?=$arr_inc["s_cus_area"];?></td>
                    <td><?=$arr_inc["cus_firstname"]." ".$arr_inc["cus_lastname"];?></td>
                    <td><?=$arr_inc["name_owner"];?></td>
                    <td><?=$arr_inc["summary"];?></td>
                    <td><?=$arr_inc["notes"];?></td>
                    <td><?=$arr_inc["resolution"];?></td>
                    <td><?=$arr_inc["status_desc"];?></td>
                    <td><?=$arr_inc["status_res_desc"];?></td>
                </tr>
             <?   } ?>
               
              
            </table>
        <br>

         <? 
                        
            }

                        }
                        
                        }
        ?>
                
    </body>
</HTML >
