<?php
//include_once "../../include/template/index_report.tpl.php";
include_once "../../include/config.inc.php";
//    include_once 'aging_search.action.php';
$report = 4;

?>

<link type="text/css" rel="stylesheet" href="<?=$application_path_include?>/css/cctstyles.css"/>
<script type="text/javascript">
   $(document).ready(function () {   
    
	$("#cus_company_id").change(function(){
            
           var report = $("#hd_report").val();
           var cus_company_id = $(this).val();
//           alert(cus_company_id);

            $.ajax({
                type: "GET",
                url: "../common/dropdown.project.php",
                data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
                success: function(response){
                    $("#project_id").replaceWith(response);    
                }
            });
            

            $.ajax({
                type: "GET",
                url: "../common/dropdown.customer_zone.php",
                data: "comp_id=" + cus_company_id + "&id=customer_zone_id"/*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone){
//                    alert(respone);
                    $("#customer_zone_id").replaceWith(respone);
//                    $("#customer_zone_id_l").replaceWith(respone);
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown.customer_zone.php",
                data: "comp_id=" + cus_company_id + "&id=customer_zone_id_l" /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone){
//                    alert(respone);
                    $("#customer_zone_id_l").replaceWith(respone);
//                    $("#customer_zone_id_l").replaceWith(respone);
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown.prd_tier3.php",
                data: "comp_id=" + cus_company_id + "&id=prd_tier_id3" /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone){
//                    alert(respone);
                    $("#prd_tier_id3").replaceWith(respone);
//                    $("#customer_zone_id_l").replaceWith(respone);
                }
            }); 
            
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown.prd_tier3.php",
                data: "comp_id=" + cus_company_id + "&id=prd_tier_id3_l" /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone){
//                    alert(respone);
                    $("#prd_tier_id3_l").replaceWith(respone);
//                    $("#customer_zone_id_l").replaceWith(respone);
                }
            }); 
            
         
         $.ajax({
                type: "GET",
                url: "../common/dropdown.incident_type.php",
                data: "cus_company_id=" + cus_company_id + "&id=ident_type_id" ,
                success: function(respone){
                    //alert(respone);
                    $("#ident_type_id").replaceWith(respone);
                }
            }); 
            
        $.ajax({
                type: "GET",
                url: "../common/dropdown.incident_type.php",
                data: "cus_company_id=" + cus_company_id + "&id=ident_type_id_l" ,
                success: function(respone){
                    //alert(respone);
                    $("#ident_type_id_l").replaceWith(respone);
                }
            });
            
        });
    
 });   
    
</script> 
<div width="100%">
    <table id="tb_adv_left" width="90%">
        <tr>
            <td width="100%" align="left" margin="5px"><span class="styleGray">รายงานรายละเอียดปัญหา Helpdesk</span><br><br>
            <input id="result_page" name="result_page" type="hidden" value="incident_detail_excel.php" />
            </td>
        </tr>
        </table><br>
    
    <?
//    $report = 3;
    include '../common/criteria_search.php';
    ?>

    
    
</div>
