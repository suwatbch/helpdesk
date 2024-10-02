<?php
    session_start(); 
    include_once '../../include/config.inc.php';
	include_once "../../include/class/model/helpdesk_project.class.php";
	include_once "../../include/class/model/customer_company.class.php";
	include_once "../../include/class/user_session.class.php";
	
	$Project = new helpdesk_project($db);
	$projectinfo = $Project->getById($_GET["pj"]);
	$text_head_2 = 	$projectinfo["project_name"];
	
	$p = new customer_company($db);
    $company = $p->getById($_GET["comp"]);
	$text_head_1 = 	$company["cus_company_name"];
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 if($customerinfo["cus_company_logo"]==""){ $logo = "nologo.png"; } else { $logo = $customerinfo["cus_company_logo"]; }
?>
<div name="Head">
            <table id="tb_PEA" style="color: black; font-weight: bold; font-size: 16px;>
                <tr>
                    <td align="left" colspan="4">
					<br>
                        บริษัท : <?=$text_head_1;?><br>
			โครงการ : <?=$text_head_2;?><br>
			<?=$text_reportname;?>
                    </td>
                </tr>
            </table>
</div>
