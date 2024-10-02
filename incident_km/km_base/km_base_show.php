<?php
session_start();
include_once "../../include/class/db/db.php";	 
include_once "../../include/class/user_session.class.php";
include_once "../../include/class/model/helpdesk_identify_km.class.php";
include_once "../../include/handler/action_handler.php";
global $objective_km;
if($_REQUEST["km_id"]!=""){
    $p = new helpdesk_identify_km($db);
    $objective_km = $p->getByID("",$_REQUEST["km_id"]);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Work Info</title>
        <base target="_self"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="../../include/css/dialog.css"/>
    </head>
    <body>
        <? if($_REQUEST["action"]== "km_process"){?>
            <div style=" height: 330px; width: 100%; overflow-y: auto;">
        <?}else{?>
            <div style=" height: 350px; width: 100%; overflow-y: auto;">
        <? } ?>
            <table width="90%" border="0" cellpadding="1" cellspacing="1" align="center">
                <tr>
                    <td width="25%"><b>KM ID</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["km_no"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Incident ID</b></td>
                    <td><input type="text" style="width: 100%;" value="<? if($objective_km["ident_id_run_project"]!= ""){ echo $objective_km["ident_id_run_project"]; }else{ echo "-";}?>" readonly class="disabled"/></td>
                </tr> 
                <tr>
                    <td><b>Summarize</b></td>
                    <td><textarea style="height: 60px; width : 100%;" readonly class="disabled"><?=htmlspecialchars($objective_km["summary"])?></textarea></td>
                </tr>
                <tr>
                    <td><b>Detail</b></td>
                    <td><textarea style="height: 80px; width : 100%;" readonly class="disabled"><?=htmlspecialchars($objective_km["notes"])?></textarea></td>
                </tr>
                <tr>
                    <td><b>Customer Company</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["cus_company_name"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Incident type</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["ident_type_desc"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Project</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["project_name"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Product Class 1</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["prd_name1"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Product Class 2</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["prd_name2"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Product Class 3</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["prd_name3"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td width="20%"><b>Operational Class 1</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["opr_name1"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Operational Class 2</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["opr_name2"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Operational Class 2</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["opr_name3"]?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Resolution</b></td>
                    <td>
                        <textarea style="height: 60px; width : 100%;" readonly class="disabled"><?=htmlspecialchars($objective_km["resolution"])?></textarea>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><b>Key Words</b></td>
                    <td>
                        <textarea style="height: 35px; width : 100%;" readonly class="disabled"><?=$objective_km["km_keyword"]?></textarea>
                    </td>
                </tr>
                <tr>
                    <td><b>Resloved</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["resloved_name"]." ,".date('d/m/Y H:i:s', strtotime($objective_km["resolved_date"]))?>" readonly class="disabled" /></td>
                    
                </tr>
                <tr>
                    <td><b>Created</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["created_name"]." ,".date('d/m/Y H:i:s', strtotime($objective_km["create_date"]))?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Modified</b></td>
                    <td><input type="text" style="width: 100%;" value="<?=$objective_km["modified_name"]." ,".date('d/m/Y H:i:s', strtotime($objective_km["modified_date"]))?>" readonly class="disabled"/></td>
                </tr>
                <tr>
                    <td><b>Attach File</b></td>
                    <td><?php
                    if (count($objective_km["file_resolution"]) > 0){
                    foreach ($objective_km["file_resolution"] as $fetch_file) {
                        $path = '<a href="../temp_identify/'.$fetch_file["location_name"].'" target="_blank">';
                        echo $path.$fetch_file["attach_name"]."</a><br />\n";
                    }
                    }
					?>
                    </td>
                </tr>
                
            </table>
        </div>
    </body>
</html>