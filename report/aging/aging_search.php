<?php
include_once "../../include/config.inc.php";
//    include_once 'aging_search.action.php';
$report = 2;
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
                //data: "cus_company_id=" + cus_company_id,
                data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
                success: function(response){
                    $("#project_id").replaceWith(response);   
					//$("#project_id").attr("style","width:100%;required:true;");
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
         
            
        });
    
 });   
    
</script>  
<div width="100%">
    <table id="tb_adv_left" width="90%">
        
        
        <tr>
            <td width="100%" align="left" margin="5px"><span class="styleGray">รายงานสรุปปัญหา Helpdesk ตามอายุเอกสาร </span><br><br>
                <input id="result_page" name="result_page" type="hidden" value="aging_report.php" />
            </td>
        </tr>
        </table><br>
    
    <?
//    $report = 2;
    include '../common/criteria_search.php';
    ?>

    
    
</div>
