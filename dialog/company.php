<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Company</title>
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
                var allowNone = $(window.parent.document).find("#company_allow_none").val();
                if (allowNone != undefined && allowNone.toString() == "true"){
                    var html = $("#divbutton").html();
                    html = "<input type=\"button\" id=\"none\" value=\"None\" class=\"input-button\" style=\"margin-right: 2px;\"/>" + html;

                    $("#divbutton").html(html);
                    $("#allowNone").val(1);
                    $("#none").click(function(){
                        window.parent.dialog_onSelected("company", new Object());
                        window.parent.dialog_onClosed("company");
                    });
                }

                $("#search").click(function(){
                    $.get("./company.search.php", $("form").serialize(), function(respone){
                        $("#divdata").html(respone);
                        init_datatable();

                        $(".data-table").last().find("tr").click(function(){
                            var obj = new Object();
                            obj.company_id = $(this).attr("value");
                            obj.company_name = decodeXml($(this).find("td").eq(1).html())

                            window.parent.dialog_onSelected("company", obj);
                            window.parent.dialog_onClosed("company");
                        });
                    });
                });

                $("#reset").click(function(){
                    $("#divdata").html("");
                    $("#company_code, #company_name").val("");
                });

                $("#close").click(function(){
                    window.parent.dialog_onSelected("company", null);
                    window.parent.dialog_onClosed("company");
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
                    <td>Company Code</td>
                    <td><input type="text" id="company_code" name="company_code" style="width: 100px" value="<?=$_REQUEST["company_code"]?>"/></td>
                </tr>
                <tr>
                    <td>Company Name</td>
                    <td>
                        <input type="text" id="company_name" name="company_name" style="width: 330px" value="<?=$_REQUEST["company_name"]?>"/>
                        <input type="button" id="search" value="Search" class="input-button"/>
                        <input type="button" id="reset" value="Reset" class="input-button"/>
                    </td>
                </tr>
            </table>
            <table width="578px" border="0" cellpadding="0" cellspacing="1" class="data-table" style="margin-left: 5px;">
                <thead>
                    <tr style="text-align: center">
                        <td width="110px">Company Code</td>
                        <td width="468px">Company Name</td>
                    </tr>
                </thead>
            </table>
            <div id="divdata" style="height: 255px; overflow: auto;"></div>
            <div id="divbutton"><input type="button" id="close" value="Close" class="input-button"/></div>
        </form>
    </body>
</html>