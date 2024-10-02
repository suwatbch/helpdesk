<?php
include_once "../../include/config.inc.php";
//    include_once 'sla_detail_search.action.php';
//$report = 2;
?>

<link type="text/css" rel="stylesheet" href="<?=$application_path_include?>/css/cctstyles.css"/> 
<div width="100%">
    <table id="tb_adv_left" width="90%">
        
        
        <tr>
            <td width="100%" align="left" margin="5px"><span class="styleGray">รายงาน Service Level Agreement Summary</span><br><br>
                <input id="result_page" name="result_page" type="hidden" value="sla_summary_report.php" />
            </td>
        </tr>
        </table><br>

    <?
    $sla = "s"; //summary
    include_once '../common/sla_criteria_search.php';
    ?>
    

    
    
</div>
