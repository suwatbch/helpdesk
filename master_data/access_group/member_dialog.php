<?php
    include_once "../../include/class/db/db.php";
    //include_once "../../include/class/model/position.class.php";
    //include_once "../../include/class/dropdown.class.php";

   // $dd_position = dropdown::loadPosition($db, "position_id", "style=\"width: 327px;\"");

   // $db->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Member</title>
        <base target="_self"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="../../include/css/dialog.css"/>
        <script type="text/javascript" src="../../include/config.js.php"></script>
        <script type="text/javascript" src="../../include/js/function.js"></script>
        <script type="text/javascript" src="../../include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="../../include/js/srs/form.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
               

                $("#search").click(function(){
                    var data = "";
                    data += "employee_code=" + $("#employee_code").val();
                    data += "&first_name=" + $("#first_name").val();
                    data += "&last_name=" + $("#last_name").val();
                    data += "&access_group_id=" + $("#access_group_id").val();
                    $.get("member_dialog.search.php", data, function(respone){
                        $("#divdata").html(respone);
                        init_datatable();
                    });                    
                });

                $("#reset").click(function(){
                    $("#employee_code, #employee_name, #position_id").val("");
                    $("#divdata").html("");
                });

                $("#cancel").click(function(){
                    window.parent.close_cancel();
                });

                $("#ok").click(function(){
                    var member = new Array;
                    var i = 0;
                    $("#example tbody").find(":checked").each(function(){
                        var tr = $(this).parent().parent();
                        member[i] = tr.attr("value");
                        i++;
                    });
                    
                     window.parent.member_onselected(member);
                });

                $("#chkAll").change(function(){
                    var checked = $(this).is(":checked");
                    $("#example tbody :checkbox").each(function(){
                        $(this).attr("checked", checked);
                    });
                });

                $("#example tbody :checkbox").change(function(){
                    var checked = true;
                    $("#example tbody :checkbox").each(function(){
                        if (!$(this).is(":checked")){
                            checked = false;
                            return;
                        }
                    });

                    $("#chkAll").attr("checked", checked);                    
                });
            });
        </script>
    </head>
    <body>
        <form name="frmMain" method="post" action="">
            <br>
            <table width="100%" border="0" cellpadding="0" cellspacing="3" align="center" style="margin: 0px 0px 5px 5px;">
                <tr>
                    <td><b>Employee Code :</b></td>
                    <td><input type="text" id="employee_code" name="employee_code" style="width: 100px" value="<?=$carteria["employee_code"]?>"/></td>
                </tr>
                <tr>
                    <td><b>First Name :</b></td>
                    <td>
                        <input type="text" id="first_name" name="first_name" style="width: 100px" value="<?=$carteria["first_name"]?>"/>
                    </td>
                    <td><b>Last Name :</b></td>
                    <td>
                        <input type="text" id="last_name" name="last_name" style="width: 100px" value="<?=$carteria["last_name"]?>"/>
                    </td>
                </tr>
                <tr>
                    <td align="center" align="center" colspan="4">
                        <input type="button" id="search" value="Search" class="input-button"/>
                        <input type="button" id="reset" value="Reset" class="input-button"/>
                    </td>
                </tr>
            </table>
            <table width="590" border="0" cellpadding="0" cellspacing="1" class="data-table" style="margin-left: 5px;">
                <thead>
                    <tr style="text-align: center">
                        <td width="15px" align="center"><input type="checkbox" id="chkAll" style="border: 0px;"/></td>
                        <td width="80px">Employee Code</td>
                        <td width="100px">First Name</td>
                        <td width="100px">Last Name</td>
                        <td width="150px">Company</td>
                    </tr>
                </thead>
               
            </table>
            <div id="divdata" style="width: 100%;height: 222px; overflow: auto;"></div>
            <div id="divbutton" style="text-align: center">
                <input type="button" id="ok" value="OK" style="width: 60px; margin-right: 5px;" class="input-button"/><input type="button" id="cancel" value="Cancel" style="width: 60px;" class="input-button"/>
            </div>
            <input type="hidden" name="access_group_id" id="access_group_id" value="<?=$_REQUEST["access_group_id"]?>"/>
        </form>
    </body>
</html>