<?php
//session_start();
    include_once dirname(dirname(__FILE__))."/config.inc.php";
    include_once dirname(dirname(__FILE__))."/class/util/strUtil.class.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="<?=$application_path_css?>/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="<?=$application_path_js?>/jquery/ui/themes/redmond/jquery-ui-1.8.13.custom.css" />
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/ui/jquery-ui-1.8.13.custom.min.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/meio/jquery.meio.mask.min.js"></script>
        <script type="text/javascript" src="<?=$application_path_include?>/config.js.php"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/function.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/common.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/form.js"></script>
         <script type="text/javascript">
//            $(function(){
//                if (parent.tbar == undefined){
//                    top.location = "<?=$application_path?>/home.php"
//                    return;
//                }
//                
//                <?php
//                    if ($_POST["load_flag"] != "1"){
//                        echo "loadmenu('$application_path/include/template/top.tpl.php?title=".PAGE_NAME."', '$application_path/include/template/bottom.tpl.php?newaction=".NEW_ACTION."');\n";
//                    }
                ?>//
//            });
        </script>
    </head>
    <body bgcolor="#fff">
        <form name="frmMain" action="index.php" method="post">
            <table width="100%" height="100%" align="center" bgcolor="#FFFFFF">
                <tr>
                    <td width="100%" align="left" valign="top"  align="left">
                        <?php include $_SESSION["current_action"];?>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="load_flag" value="1"/>
        </form>
    </body>
</html>