<?php
    include_once dirname(dirname(__FILE__))."/config.inc.php";
    include_once dirname(dirname(__FILE__))."/class/util/strUtil.class.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <title></title>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet"  href="../../include/css/cctstyles.css"/>
        <style type="text/css">
            body{
                background-color: #C4C4C4;
            }

            button{
                width: 80px;
                height: 30px
            }

            .copyright{
                padding-top: 3px;
                text-align: right;
                vertical-align: bottom;
                color: #788480;
                padding-right: 5px;
                font-size: 10px;
            }
        </style>
        <script type="text/javascript" src="../../include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="../../include/js/function.js"></script>
        <script type="text/javascript" src="../../include/config.js.php"></script>
        <script type="text/javascript" src="../../include/js/srs/form.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#new").click(function(){
                    top.main.frmMain.target = "main";
                    top.main.frmMain.action =  $(this).attr("action");
                    top.main.frmMain.submit();
                });
            });
        </script>
    </head>
    <body>
        <form name="frmMain" method="post" action="" target="">
            <table width="100%" align="left">
                <tr>
                    <td></td>
                </tr>
                <tr style="height: 30px;">
                    <td width="200px" align="left">
                        &nbsp;
                        <?php
                            if($_REQUEST["newaction"] != "NEW_ACTION" && strUtil::isNotEmpty($_REQUEST["newaction"])){
                        ?>
                        <button id="new" class="input-button input-button-new" style="border: 1px #788480 solid;" action="<?=$_SESSION["current"]."?".$_REQUEST["newaction"]?>">New</button>
                        <?php
                            }
                        ?>
                        
                    </td>
                    <td class="copyright">
                        Copyright &copy; 2013 Corporate IT - Samart Corporation PCL. All rights reserved.
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>