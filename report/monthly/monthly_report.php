<?php
set_time_limit(10000);
include_once '../../include/config.inc.php';
include_once '../../include/template/index_report.tpl.php';
include_once '../../include/class/util/dateUtil.class.php';
include_once "../../include/error_message.php";
               				
//echo "XXXXX";

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
if($criteria["arr_criteria"]){ $arr_criteria = $criteria["arr_criteria"]; }
if($criteria["total_row"]){ $total_row_criteria = $criteria["total_row"]; }

$pea = array();
$pea_name = array();

$grandtotal_pea = array();
$grandtotal_total = 0;

//echo $_SERVER["PHP_SELF"];



//additional part
$report_id = "0";
$response_id = "";
$final = "";
$report_type_id = 7; // monthly report
$additional = array();
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


# Data to push in additional 1 tb
$ad1_pea_area_pc = array();
$ad1_max_howto = array(
    "name" => "",
    "val" => 0
);
$ad1_more_percent = FALSE;

# Data to push in additional 1 tb : BPM
$BPM_ad1_pea_area_pc = array();
$BPM_ad1_max_howto = array(
    "name" => "",
    "val" => 0
);
$BPM_ad1_more_percent = FALSE;



# Data to push in additional 2 tb
$ad2_pea_area_pc = array(
    "name"=> "",
    "val"=> 0
);
$ad2_max_inc = array();
$ad2_more_percent = FALSE;



# Data to push in additional 2 tb
$BPM_ad2_pea_area_pc = array(
    "name"=> "",
    "val"=> 0
);
$BPM_ad2_max_inc = array();
$BPM_ad2_more_percent = FALSE;

$temp_percent  = array(
    "name"=> "",
    "val"=> 0
);
        

     
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <meta name="viewport" content="width=620" />
        <title>Incident Monthly Report</title>
        <link type="text/css" rel="stylesheet" href="../../include/css/report.css"/>
        <style type="text/css" media="print">
            #savearea{
                display: none;
            }
            
            #hr{
                display: none;
            }
        </style>
        <script type="text/javascript">
         $(document).ready(function () {    
             
            
            $("#send").click(function() {
                

                var employee_id = $("#employee_id").val();
                if (employee_id == "0" || employee_id == "") {
                    jAlert('warning', 'กรุณาเลือกพนักงานที่ต้องการก่อนการบันทึก!', 'Helpdesk System : Messages');
                    return false;
                };
//                
                var head = new Array();
                var detail = new Array();
//                
                head[0] = "save";
                head[1] = $("#report_type_id").val() ;
                head[2] = $("#comp_id").val();
                head[3] = $("#start_date").val();
                head[4] = $("#end_date").val();
                head[5] = $("#employee_id").val();
                head[6] = $("#report_id").val();
                head[7] = "N"; //approve report (no edit anymore)
                head[8] = $("#project_id").val();
//                
                detail[1] = $("#txt_detail1").val();
                detail[2] = $("#txt_detail2").val();
                detail[3] = $("#txt_detail3").val();
                detail[4] = $("#txt_detail4").val();
                detail[5] = $("#txt_detail5").val();
                detail[6] = $("#txt_detail6").val();
                detail[7] = $("#txt_detail7").val();
                detail[8] = $("#txt_detail8").val();
                detail[9] = $("#txt_detail9").val();
                detail[10] = $("#txt_detail10").val();
                detail[11] = $("#txt_detail11").val();
                detail[12] = $("#txt_detail12").val();
                detail[13] = $("#txt_detail13").val();
                detail[14] = $("#txt_detail14").val();
                detail[15] = $("#txt_detail15").val();
                detail[16] = $("#txt_detail16").val();
                detail[17] = $("#txt_detail17").val();
                detail[18] = $("#txt_detail18").val();
                
                // BPM
                detail[19] = $("#txt_detail1_BPM").val();
                detail[20] = $("#txt_detail2_BPM").val();
                detail[21] = $("#txt_detail3_BPM").val();
                detail[22] = $("#txt_detail4_BPM").val();
                detail[23] = $("#txt_detail5_BPM").val();
                detail[24] = $("#txt_detail6_BPM").val();
                detail[25] = $("#txt_detail7_BPM").val();
                detail[26] = $("#txt_detail8_BPM").val();
                detail[27] = $("#txt_detail9_BPM").val();
                detail[28] = $("#txt_detail10_BPM").val();
                detail[29] = $("#txt_detail11_BPM").val();
                detail[30] = $("#txt_detail12_BPM").val();
                detail[31] = $("#txt_detail13_BPM").val();
                detail[32] = $("#txt_detail14_BPM").val();
                detail[33] = $("#txt_detail15_BPM").val();
                detail[34] = $("#txt_detail16_BPM").val();
                detail[35] = $("#txt_detail17_BPM").val();
                detail[36] = $("#txt_detail18_BPM").val();
                
 
                
            $.ajax({
                type: "POST",
                url: "../common/additional.action.php",
                data : {detail:detail,header:head} ,  /*data : {t1:tb1,t2:tb2,t3:tb3,header:head} ,      */   
                beforeSend:function(){
                    // this is where we append a loading image
                    $('#ajax-panel').html('<img src="../../images/loading_small.gif" alt="Loading..." />');
                },
                success: function(response){
//                    $("#message").html(response);
                    if (response == ""){
                        $("#message").html('บันทึกรายการไม่สมบูรณ์!');
                    }else {
                        $("#report_id").val(response);
                        $("#message").html("บันทึกรายการเรียบร้อยแล้ว");
                        
                        var emp = $("#employee_id").val();
                        var us = $("#user_id").val();
                        
                        if (emp != us){
                            $("span#employee").hide();
                            $("#send").hide();
                            $("#final").hide();
                        }
                        
                    }
                    $('#ajax-panel').empty();
                 
                },
                error:function(){
                 $("#message").html('บันทึกรายการไม่สมบูรณ์!');
                 $('#ajax-panel').empty();  
                }
            });
        });
        
        
        
        
        $("#final").click(function() {
//alert('final');
                var head = new Array();
                var detail = new Array();
                
                head[0] = "save";
                head[1] = $("#report_type_id").val() ;
                head[2] = $("#comp_id").val();
                head[3] = $("#start_date").val();
                head[4] = $("#end_date").val();
                head[5] = $("#response_id").val(); //approve report : response = own user_id
                head[6] = $("#report_id").val();
                head[7] = "Y"; //approve report (no edit anymore)
                head[8] = $("#project_id").val();
                
                detail[1] = $("#txt_detail1").val();
                detail[2] = $("#txt_detail2").val();
                detail[3] = $("#txt_detail3").val();
                detail[4] = $("#txt_detail4").val();
                detail[5] = $("#txt_detail5").val();
                detail[6] = $("#txt_detail6").val();
                detail[7] = $("#txt_detail7").val();
                detail[8] = $("#txt_detail8").val();
                detail[9] = $("#txt_detail9").val();
                detail[10] = $("#txt_detail10").val();
                detail[11] = $("#txt_detail11").val();
                detail[12] = $("#txt_detail12").val();
                detail[13] = $("#txt_detail13").val();
                detail[14] = $("#txt_detail14").val();
                detail[15] = $("#txt_detail15").val();
                detail[16] = $("#txt_detail16").val();
                detail[17] = $("#txt_detail17").val();
                detail[18] = $("#txt_detail18").val();
                
                 // BPM
                detail[19] = $("#txt_detail1_BPM").val();
                detail[20] = $("#txt_detail2_BPM").val();
                detail[21] = $("#txt_detail3_BPM").val();
                detail[22] = $("#txt_detail4_BPM").val();
                detail[23] = $("#txt_detail5_BPM").val();
                detail[24] = $("#txt_detail6_BPM").val();
                detail[25] = $("#txt_detail7_BPM").val();
                detail[26] = $("#txt_detail8_BPM").val();
                detail[27] = $("#txt_detail9_BPM").val();
                detail[28] = $("#txt_detail10_BPM").val();
                detail[29] = $("#txt_detail11_BPM").val();
                detail[30] = $("#txt_detail12_BPM").val();
                detail[31] = $("#txt_detail13_BPM").val();
                detail[32] = $("#txt_detail14_BPM").val();
                detail[33] = $("#txt_detail15_BPM").val();
                detail[34] = $("#txt_detail16_BPM").val();
                detail[35] = $("#txt_detail17_BPM").val();
                detail[36] = $("#txt_detail18_BPM").val();
 
            $.ajax({
                type: "POST",
                url: "../common/additional.action.php",
                data : {detail:detail,header:head} ,         
                beforeSend:function(){
                    // this is where we append a loading image
                    $('#ajax-panel').html('<img src="../../images/loading_small.gif" alt="Loading..." />');
                },
                success: function(respone){
                    if (respone == ""){
                        $("#message").html('บันทึกรายการไม่สมบูรณ์!');
                    }else {
                        $("#message").html("บันทึกรายการเรียบร้อยแล้ว");
                        
                        $("span#employee").hide();
                        $("#send").hide();
                        $("#final").hide();
                    }
                    $('#ajax-panel').empty();
                 
                },
                error:function(){
                 $("#message").html('บันทึกรายการไม่สมบูรณ์!');
                 $('#ajax-panel').empty();  
                }
            });
        });
        
        
        
        
//        $("a[name=1_addRow]").click(function() {
//            appendTR("tb_additional_1");
//            return false;
// 	});
//        
//        
//        $("a[name=2_addRow]").click(function() {
//            appendTR("tb_additional_2");
//            return false;
// 	});
//        
//        
//        $("a[name=3_addRow]").click(function() {
//            appendTR("tb_additional_3");
//            return false;
// 	});
//        
//        
//        $("table.tb_additional a.nonborder").live("click", function() {
//		$(this).parents("tr").remove();
//				
//	});
        
        $("#export_excel").click(function(){
                var url = 'monthly_export.php' 
                    + '?comp=' + $("#comp_id").val() 
                    + '&start=' + $("#start_date").val() 
                    + '&end=' + $("#end_date").val() 
                    + '&pj=' + $("#project_id").val() 
                    + '&show_to_customer=' + $("#show_to_customer").val();
                window.open(url, '',''); 
         });
        
       
        
});


 function gettable(name){
    var tb = new Array();
    var tb_name = "table#" + name + " tr";
    var n = 0;
    
    $(tb_name).each(function() {
        
            var $this = $(this);
            tb[n] = new Array();
            tb[n][0] = $this.find('#number').val();
            tb[n][1] = $this.find('#text1').val();
            tb[n][2] = $this.find('#text2').val();
            tb[n][3] = $this.find('#text3').val();
            tb[n][4] = $this.find('#text4').val();
            tb[n][5] = $this.find('#remark').val();
                    
            n = n+1;

           });
    return tb;
 }
 


    function appendTR(name){
        var tb_name = "table#" + name + " tr:last";//# + name + " tr";
        var str_append = "<tr>";
        str_append += "<td align='center'><a id='trash' name='trash' class='nonborder' ><img src='<?=$application_path_images;?>/trash.png' /></a></td>";
        str_append += "<td><input type='text' name='number' id='number' style='text-align: center;' value='' /></td>";
        str_append += "<td><input type='text' name='text1' id='text1' value='' /></td>";
        str_append += "<td><input type='text' name='text2' id='text2' style='text-align: center;' value='' /></td>";
        str_append += "<td><input type='text' name='text3' id='text3' value='' /></td>";
        str_append += "<td><input type='text' name='text4' id='text4' style='text-align: center;' value='' /></td>";
        str_append += "<td><input type='text' name='remark' id='remark' value='' /></td>";
        str_append += "</tr>";
//        $(tb_name).append(str_append);
        $(tb_name).after(str_append);
        return false;

    }



        
        </script>
    </head>
    <body>
        
        <?
            include_once '../common/export.php';
            include_once '../common/report_header.php';
        ?>
        <br>
        
        <input type="hidden" id="comp_id" name="comp_id" value="<?= $_GET["comp"];?>" />
        <input type="hidden" id="project_id" name="project_id" value="<?= $_GET["pj"];?>" />
        <input type="hidden" id="start_date" name="start_date" value="<?= $_GET["start"];?>" />
        <input type="hidden" id="end_date" name="end_date" value="<?= $_GET["end"];?>" />
        <input type="hidden" id="report_type_id" name="report_type_id" value="7" />
        <input type="hidden" id="show_to_customer" name ="show_to_customer" value="<?=$_GET["show_to_customer"];?>" />
        
        
        <div name="Data">
            <table id="tb_data">
                <tr height="200px">
                    <th align="center" width="20%">Module</th>
                    <th align="center" width="10%">Quantity & Percentage</th>
                    
            <?
                if (count($arr_criteria) > 0){ 
                    $i = 0;
                    foreach ($arr_criteria as $list) {
                        $pea[$i] = $list["zone_id"];
                        $pea_name[$i] = $list["name"]; 
                        $grandtotal_pea[$i] = 0;
                ?>
                    <th align="center" width="5%"><div class="rotate" ><?=$list["name"];?></div></th>
                <?
                    $i++;
                    }
                }
            ?>
                    <th align="center"><span class="rotate" style="color:#cc0000;">Grand Total: #Ticket/%Ticket</span></th>
                </tr>
                
                <?
                    $incident_type = getincidenttype($comp_id,$display_inc);
                    
                    foreach ($incident_type as $list) {
                        
                        $incident_type_id = $list["ident_type_id"];
                        $total_bytype = 0;
                        
                        ?>
                <tr>
                    <td colspan="2" id="datahead"><?=$list["ident_type_desc"];?></td>
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
                    
                    <td id="datahead" align="right"><?= $count_byzone[$index];?></td>
                    
                    <?
                        }//end count incident type by zone
                    ?>
                    <td id="datahead" align="right"><span class="total"><?=$total_bytype;?></span></td>
                </tr>
                    <?
                        //get resolved product class3 master
                        $class3 = getclass3($comp_id);
                        if (count($class3) > 0){ 
                            
                            foreach ($class3 as $list){
                                #clear module percent temp
                                $temp_percent  = array(
                                    "name"=> "",
                                    "val"=> 0
                                );
                                
                                $class3_id = $list["prd_tier_id"];
                                $class3_name = $list["prd_tier_name"];
                                $class2_id = $list["lv2"];
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
                    <td align="left" id="datasub-count"><?=$class3_name;?></td>
                    <td align="left" id="datasub-count">จำนวน Ticket</td>
                                <?  // write count zone
                                    for ($index = 0; $index < count($count_class3); $index++) {
                                    ?>
                    <td align="right" id="datasub-count"><?=($count_class3[$index] == 0) ? "":$count_class3[$index];?></td>
                                    <?
                                    
                                    }
                                    
                                    ?>
                    <td align="right" id="datasub-count"><span class="total"><?=$total_count_class3;?></span></td>
                </tr> <!-- end จำนวน Ticket -->  
                
                <!--  ============ % เทียบตาม Module ===================== --> 
                <tr>
                    <td align="left" id="datasub">&nbsp;</td>
                    <td align="left" id="datasub">% เทียบตาม Module</td>
                                <?  // write count zone
                                    for ($index = 0; $index < count($count_class3); $index++) {
                                        $percentage = 0.0;
                                        if ($count_class3[$index] != 0){
                                           $percentage =  ($count_class3[$index]/$total_count_class3)*100;
                                        }
                                        
                                        if (($percentage >= $temp_percent["val"]) && $incident_type_id == 2 ){
                                            $temp_percent  = array(
                                                "name"=> $pea_name[$index],
                                                "val"=> round($percentage,2)
                                            );
//                                            $temp_percent["val"] = round($percentage,2);
//                                            $temp_percent["name"] = $pea_name[$index];
                                                    
                                        }
                                    ?>
                    <td align="right" id="datasub"><?=(round($percentage,2) == 0) ? "" : round($percentage,2)."%"; ?></td>
                                    <?
                                    
                                    
                                    } 
                                    $total_percentage = round(($total_count_class3/$total_bytype)*100,2);
                                    
//                                    $total_percentage_temp = round(($total_count_class3/$total_bytype)*100,2) ;
                                    // fill to auto additional
                                    if ($class2_id != "4"){ // no BPM
                                        if ($incident_type_id == 1 && ($total_percentage >= $ad1_max_howto["val"]) ){// How to
                                                unset($ad1_pea_area_pc);
                                                $ad1_more_percent = TRUE;
                                                $ad1_max_howto = array(
                                                    "name" => $class3_name,
                                                    "val" => $total_percentage
                                                );

                                        } elseif ($incident_type_id == 2 && ($total_percentage >= $ad2_max_inc["val"])){//Incident
                                                $ad2_more_percent = TRUE;
                                                $ad2_max_inc = array(
                                                    "name" => $class3_name,
                                                    "val" => $total_percentage
                                                );

                                                $ad2_pea_area_pc["val"] = $temp_percent["val"];
                                                $ad2_pea_area_pc["name"] = $temp_percent["name"];

                                        }else {

                                                $ad1_more_percent = FALSE;
                                                $ad2_more_percent = FALSE;
                                        }    
                                    }else{// only BPM (level2_id = 4)
                                        if ($incident_type_id == 1 && ($total_percentage >= $BPM_ad1_max_howto["val"]) ){// How to
                                            unset($BPM_ad1_pea_area_pc);
                                            $BPM_ad1_more_percent = TRUE;
                                            $BPM_ad1_max_howto = array(
                                                "name" => $class3_name,
                                                "val" => $total_percentage
                                            );
                                            
                                        } elseif ($incident_type_id == 2 && ($total_percentage >= $BPM_ad2_max_inc["val"])){//Incident
                                                $BPM_ad2_more_percent = TRUE;
                                                $BPM_ad2_max_inc = array(
                                                    "name" => $class3_name,
                                                    "val" => $total_percentage
                                                );

                                                $BPM_ad2_pea_area_pc["val"] = $temp_percent["val"];
                                                $BPM_ad2_pea_area_pc["name"] = $temp_percent["name"];

                                        }else {

                                                $BPM_ad1_more_percent = FALSE;
                                                $BPM_ad2_more_percent = FALSE;
                                        }   
                                    }
                                    
                                    
                                    
                                    
                                    ?>
                    <td rowspan="2" align="right" id="datasub"><span class="totalpercent"><?= $total_percentage. "%";?></span></td>
                </tr> <!-- end เทียบตาม Module -->  
                
                <!--  ============ % เทียบตามเขต กฟภ. ===================== --> 
                <tr>
                    <td align="left" id="datasub">&nbsp;</td>
                    <td align="left" id="datasub">% เทียบตามเขต.</td>
                                <?  // write count zone
                                    for ($index = 0; $index < count($count_class3); $index++) {
                                        $percentage = 0.0;
                                        if ($count_class3[$index] != 0){
                                            if ($count_byzone[$index] == 0){
                                                $percentage = 0;
                                            }else {
                                                $percentage =  ($count_class3[$index]/$count_byzone[$index])*100;
                                            }
                                            
                                            // fill to auto additional
                                            if ($class2_id != "4"){
                                                if ($incident_type_id == 1 && $ad1_more_percent == TRUE && $percentage != 0){// How to

                                                    $ad1_pea_area_pc[$index]["name"] = $pea_name[$index];
                                                    $ad1_pea_area_pc[$index]["val"] = round($percentage,2);
                                                }    
                                            }else{
                                                if ($incident_type_id == 1 && $BPM_ad1_more_percent == TRUE && $percentage != 0){// How to

                                                    $BPM_ad1_pea_area_pc[$index]["name"] = $pea_name[$index];
                                                    $BPM_ad1_pea_area_pc[$index]["val"] = round($percentage,2);
                                                }                                                   
                                            }
                                            
                                            
//                                            if ($incident_type_id == 2 && $ad2_more_percent == TRUE && $percentage != 0 && $ad2_pea_area_pc["val"] <= $percentage){// How to
//                                                $ad2_pea_area_pc["val"] = round($percentage,2);
//                                                $ad2_pea_area_pc["name"] = $pea_name[$index];
//                                            }
                                           
                                        }
                                    ?>
                    <td align="right" id="datasub"><?=(round($percentage,2) == 0) ? "" : round($percentage,2)."%"; ?></td>
                                    <?
                                        
                                    }
                                    
//                                    $total_percentage = ($total_count_class3/$total_bytype)*100;
                                    ?>
                   </tr> <!-- end เทียบตามเขต กฟภ. -->  
                
                
                                        <?
                                }//end check has data to write
                            }//end loop master class3
                        }//end if master class3
                     
                    }// end loop incident_type master
                
                ?>
                   
                   <tr>
                       <td align="left" class="totalAll" colspan="2" >Grand Total</td>
                       <?
                        foreach ($grandtotal_pea as $value) {
                            ?>
                        <td class="totalAll" align="right"><?=$value;?></td>
                             <?
                        }
                    ?>
                     <td class="totalAll" align="right"><?=$grandtotal_total;?></td>
                   </tr>
                
                
                
            </table>
        </div>
        <br> <br>
        
        

        
        
    <!--<link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>-->    
<!--    <div id="dialog-customer" title="Customer">
        <iframe id="ifr_cus_id" frameborder="0" scrolling="no" width="100%" height="100%" src="" style="background-color: white; alignment-adjust: central;"></iframe>
    </div>       -->
        
        
    </body>
</html>
<style>
   @media {
    @page {
      size: B4 landscape;
      margin: 5px 5px 5px 5px;
      padding: 5px 5px 5px 5px;
    }
  }

</style>
