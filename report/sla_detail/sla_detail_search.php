<?php
include_once "../../include/config.inc.php";

?>

<link type="text/css" rel="stylesheet" href="<?=$application_path_include?>/css/cctstyles.css"/> 
<div width="100%">
    <table id="tb_adv_left" width="90%">
        
        
        <tr>
            <td width="100%" align="left" margin="5px"><span class="styleGray">รายงาน Service Level Agreement Detail</span><br><br>
                <input id="result_page" name="result_page" type="hidden" value="sla_detail_report.php" />
            </td>
        </tr>
        </table><br>

    <?
    include_once '../common/sla_criteria_search.php';
    ?>
</div>
