<?php
session_start();
$workinfo_id= $_GET["workinfo_id"]; 
include_once dirname(dirname(dirname(__FILE__)))."/v.1/incident/manage_incident/incident.getrunning.php";
include_once "../include/class/db/db.php";	 
include_once "../include/class/dropdown.class.php";
include_once "../include/class/util/strUtil.class.php";
include_once "../include/class/util/dateUtil.class.php";
include_once "../include/class/user_session.class.php";
include_once "../include/class/model/helpdesk_workinfo.class.php";
    
if($workinfo_id){
		
		if (strUtil::isNotEmpty($workinfo_id)){
			global $db, $Workinfo;
			
			
            $Workinfo_list = new Workinfotype($db);
            $Workinfo = $Workinfo_list->getByWorkinfoID($workinfo_id);
			$t_incident_id = $Workinfo["incident_id"];
			//if($t_incident_id) $t_incident_id = "INC00000000000".$Workinfo["incident_id"];
			#Show Incident Running Number
			$t_incident_id = incident_getrunning($Workinfo["incident_id"],$Workinfo["ident_id_run_project"]);
			
			$t_workinfo_type_id = $Workinfo["workinfo_name"];
			$t_workinfo_summary = $Workinfo["workinfo_summary"];
			$t_workinfo_notes = $Workinfo["workinfo_notes"];
			$t_workinfo_user_id = $Workinfo["user_name"];
			$t_workinfo_date = $Workinfo["workinfo_date"];
			$t_workinfo_status_desc = $Workinfo["status_desc"];
			$t_workinfo_status_res_desc = $Workinfo["status_res_desc"];
			//$t_workinfo_attach = $Workinfo["workinfo_attach"];
			
			
			#Get Attach Files
			$sql = " SELECT attach_name,location_name"
                    . " FROM helpdesk_tr_attachment" 
                    . " WHERE workinfo_id = '$workinfo_id' AND type_attachment = '2' AND incident_id = '{$Workinfo["incident_id"]}'" 
                    . " ORDER BY attach_date";
			
			$result = $db->query($sql);
                        $rows = $db->num_rows($result);
			
			
			
        }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Work Info</title>
        <base target="_self"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link type="text/css" rel="stylesheet" href="../include/css/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="../include/css/dialog.css"/>
        <script type="text/javascript" src="../include/config.js.php"></script>
        <script type="text/javascript" src="../include/js/function.js"></script>
        <script type="text/javascript" src="../include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="../include/js/srs/common.js"></script>
        <script type="text/javascript" src="../include/js/srs/form.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var allowNone = $(window.parent.document).find("#employee_allow_none").val();
                if (allowNone != undefined && allowNone.toString() == "true"){
                    var html = $("#divbutton").html();
                    html = "<input type=\"button\" id=\"none\" value=\"None\" class=\"input-button\" style=\"margin-right: 2px;\"/>" + html;

                    $("#divbutton").html(html);
                    $("#none").click(function(){
                        window.parent.dialog_onSelected("employee", new Object());
                        window.parent.dialog_onClosed("employee");
                    });
                }

                //$("#sale_not_allow").val(arg.notAllow);

                $("#search").click(function(){
                    $.get("./employee.search.php", $("form").serialize(), function(respone){
                        $("#divdata").html(respone);
                        init_datatable();

                        $("#divdata .data-table").last().find("tr").click(function(){
                            var obj = new Object();
                            obj.employee_id = $(this).attr("value");
                            obj.employee_name = decodeXml($(this).find("td").eq(1).html());

                            window.parent.dialog_onSelected("employee", obj);
                            window.parent.dialog_onClosed("employee");
                        });
                    });
                });

                $("#reset").click(function(){
                    $("#divdata").html("");
                    $("#company_code, #company_name, #position_id").val("");
                });

                $("#close").click(function(){
                    window.parent.dialog_onSelected("employee", null);
                    window.parent.dialog_onClosed("employee");
                });
            });
        </script>
    </head>
    <body>
        <form name="frmMain" method="post" action="">
            <table width="90%" border="0" cellpadding="1" cellspacing="1" align="center">
                <tr>
                    <td width="20%">Incident ID</td>
                    <td><input type="text" style="width: 100%;" value="<?=$t_incident_id;?>" disabled/></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><input type="text" style="width: 100%;"  value="<?=$t_workinfo_status_desc;?>" disabled /></td>
                </tr>
                <tr>
                    <td>Status Reason</td>
                    <td><input type="text" style="width: 100%;"  value="<?=$t_workinfo_status_res_desc;?>" disabled /></td>
                </tr>
                <!--<tr>
                    <td>Work Info Type</td>
                    <td><input type="text" style="width: 220px" value="<?=$t_workinfo_type_id;?>" disabled /></td>
                </tr>-->
                <tr>
                    <td>Work Detail</td>
                    <td>
                        <textarea style="height: 95px; width : 100%;" disabled><?=htmlspecialchars($t_workinfo_summary)?></textarea>
                    </td>
                </tr>
                <tr>
                    <td valign="top">Internal Notes</td>
                    <td>
                        <textarea style="height: 35px; width : 100%;" disabled><?=htmlspecialchars($t_workinfo_notes)?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>User</td>
                    <td><input type="text" style="width: 100%;" value="<?=$t_workinfo_user_id;?>" disabled /></td>
                </tr>
                <tr>
                    <td>Submit Date</td>
                    <td><input type="text" style="width: 100%;" value="<?=dateUtil::date_dmyhms2($t_workinfo_date);?>" disabled /></td>
                </tr>
                
                <tr>
                    <td>Attach File</td>
                    <td><br><?php 
						while($row = mysql_fetch_row($result)) {
							$path = '<a href="../upload/temp_inc_workinfo/'.$row[1].'" target="_blank">';
							echo "$path$row[0]</a><br />\n";
						}
					?>
                    </td>
                </tr>
                
            </table>
        </form>
    </body>
</html>