<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Project</title>
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
                $("#search").click(function(){
                    $.get("./project.search.php", $("form").serialize(), function(respone){
                        $("#divdata").html(respone);
                        init_datatable();

                        $("#divdata .data-table").find("tr").click(function(){
                            var obj = new Object();
                            obj.project_id = $(this).attr("value");
                            obj.project_name = decodeXml($(this).find("td").last().html());

                            window.parent.dialog_onSelected("project", obj);
                            window.parent.dialog_onClosed("project");
                        });
                    });
                });

                $("#reset").click(function(){
                    $("#divdata").html("");
                    $("#project_code, #project_name").val("");
                });

                $("#close").click(function(){
                    window.parent.dialog_onSelected("project", null);
                    window.parent.dialog_onClosed("project");
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
                    <td>Project Code</td>
                    <td><input type="text" id="project_code" name="project_code" style="width: 150px" value="<?=$_REQUEST["project_code"]?>"/></td>
                </tr>
                <tr>
                    <td>Project Name</td>
                    <td>
                        <input type="text" id="project_name" name="project_name" style="width: 330px" value="<?=$_REQUEST["project_name"]?>"/>
                        <input type="button" id="search" value="Search" class="input-button"/>
                        <input type="button" id="reset" value="Reset" class="input-button"/>
                    </td>
                </tr>
            </table>
            <table width="628px" border="0" cellpadding="0" cellspacing="1" class="data-table" style="margin-left: 5px;">
                <thead>
                    <tr style="text-align: center">
                        <td width="170px">Project Code</td>
                        <td width="458px">Project Name</td>
                    </tr>
                </thead>
            </table>
            <div id="divdata" style="height: 255px; overflow: auto;"></div>
            <div id="divbutton"><input type="button" id="close" value="Close" class="input-button"/></div>
            <input type="hidden" id="sale_group_id" name="sale_group_id" id="sale_group_id" value="<?=$_REQUEST["sale_group_id"]?>"/>
            <input type="hidden" id="customer_id" name="customer_id" id="customer_id" value="<?=$_REQUEST["customer_id"]?>"/>
        </form>
    </body>
</html>