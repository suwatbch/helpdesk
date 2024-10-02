<?php
include_once "../../include/config.inc.php";
//    include_once 'aging_search.action.php';
$report = 1;
$show_to_customer = 'Y';
?>

<link type="text/css" rel="stylesheet" href="<?=$application_path_include?>/css/cctstyles.css"/> 
<script type="text/javascript">
   $(document).ready(function () {   
    
	$("#cus_company_id").change(function(){
            
           var report = $("#hd_report").val();
           var cus_company_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "dropdown.date_monthly.php",
                data: "comp_id=" + cus_company_id + "&id=date_monthly"/*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone){
                    $("#date_monthly").replaceWith(respone);
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown.project.php",
                data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
                success: function(response){
                    //$("#project_id").replaceWith(response);    
					document.getElementById("project_id").innerHTML = response;
                }
            });
            
            
         
            
        });
        
        
//        $("#project_id").change(function(){
//        alert('aa');
//        });
        
 });        
        
        
        

    
</script>    
<div width="100%">
    <table id="tb_adv_left" width="90%">
        <tr>
            <td width="100%" align="left" margin="5px"><span class="styleGray">รายงานสรุปประเภท Helpdesk ตามเขตการไฟฟ้า</span><br><br>
                <input id="result_page" name="result_page" type="hidden" value="monthly_report.php" />
            </td>
        </tr>
        </table><br>
       
            
    
    <?
   include '../common/criteria_search.php';
    ?>

    
    
</div>
