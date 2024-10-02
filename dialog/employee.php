<?php
    include_once "../include/class/db/db.php";
    
    
//    include_once "../include/class/dropdown.class.php";
//    include_once "../include/class/model/position.class.php";
    
//    $dd_position = dropdown::loadPosition($db, "position_id", "style=\"width: 332px;\"", $_REQUEST["position_id"]);
//    $db->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Employee</title>
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
//                var allowNone = $(window.parent.document).find("#employee_allow_none").val();
//                if (allowNone != undefined && allowNone.toString() == "true"){
//                    var html = $("#divbutton").html();
//                    html = "<input type=\"button\" id=\"none\" value=\"None\" class=\"input-button\" style=\"margin-right: 2px;\"/>" + html;
//
//                    $("#divbutton").html(html);
//                    $("#none").click(function(){
//                        window.parent.dialog_onSelected("employee", new Object());
//                        window.parent.dialog_onClosed("employee");
//                    });
//                }

                //$("#sale_not_allow").val(arg.notAllow);

                $("#search").click(function(){
                    $.get("./employee.search.php", $("form").serialize(), function(respone){
                        $("#divdata").html(respone);
                        init_datatable();

                        $("#divdata .data-table").last().find("tr").click(function(){
                            var obj = new Object();
                            obj.employee_id = $(this).attr("value");
                            obj.employee_name = decodeXml($(this).find("td").eq(1).html());  
                            
//                            alert(obj.employee_name);

                            window.parent.dialog_onSelected("employee", obj);
                            window.parent.dialog_onClosed("employee");
                        });
                    });
                });

                $("#reset").click(function(){
                    $("#divdata").html("");
                    $("#employee_code, #employee_name").val("");
                });

                $("#close").click(function(){
//                    alert('close');
                    window.parent.dialog_onSelected("employee", null);
                    window.parent.dialog_onClosed("employee");
                });
            });
        </script>
    </head>
    <body>
        <form name="frmMain" method="post" action="">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="margin: 0px 0px 5px 5px;">
                <tr style="height: 10px">
                    <td width="20%"></td>
                    <td width="80%"></td>
                </tr>
                <tr>
                    <td>Employee Code</td>
                    <td><input type="text" id="employee_code" name="employee_code" style="width: 100px" value="<?=$_REQUEST["employee_code"]?>"/></td>
                </tr>
                <tr>
                    <td>Employee Name</td>
                    <td>
                        <input type="text" id="employee_name" name="employee_name" style="width: 330px" value="<?=$_REQUEST["employee_name"]?>"/>
                        <input type="button" id="search" value="Search" class="input-button"/>
                        <input type="button" id="reset" value="Reset" class="input-button"/>
                    </td>
                </tr>
<!--                <tr>
                    <td>Position</td>
                    <td>
                        
                        <input type="button" id="search" value="Search" class="input-button"/>
                        <input type="button" id="reset" value="Reset" class="input-button"/>
                    </td>
                </tr>-->
            </table>
            <table width="578px" border="0" cellpadding="0" cellspacing="1" class="data-table" style="margin-left: 5px;">
                <thead>
                    <tr style="text-align: center">
                        <td width="200px">Employee Code</td>
                        <td width="378px">Employee Name</td>
                        <!--<td width="190px">Position</td>-->
                    </tr>
                </thead>
            </table>
            <div id="divdata" style="height: 270px; overflow-y: auto;"></div>
            <!--<div id="divbutton"><input type="button" id="close" value="Close" class="input-button"/></div>-->
            <input type="hidden" name="monthly_per" id="monthly_per" value="<?=$_REQUEST["monthly_per"]?>"/>
        </form>
    </body>
</html>