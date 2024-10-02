<?php
    include_once '../../include/config.inc.php';
	include_once "../../include/class/model/helpdesk_project.class.php";
	
	$Project = new helpdesk_project($db);
	$projectinfo = $Project->getById($_GET["pj"]);
	$text_head_2 = 	$projectinfo["project_name"];
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 if($customerinfo["cus_company_logo"]==""){ $logo = "nologo.png"; } else { $logo = $customerinfo["cus_company_logo"]; }
?>
<link type="text/css" rel="stylesheet" href="../../include/css/report.css"/>
<div name="Head">
            <table id="tb_PEA">
                <tr>
                    <th align="center">
                        <img src="<?=$application_path_images?>/<?=$logo?>" class="nonborder" width="88" height="86"/>
                    </th>
                    <td align="left">
                        <span id="big"><?=$text_head_1;?></span><br>
                        <span id="small"><?=$text_head_2;?></span>
                    </td>
                </tr>
                
            </table><br>
            <table id="tb_ReportName">
                <tr><td align="center"><?=$text_reportname;?></td></tr>
            </table>
</div>
