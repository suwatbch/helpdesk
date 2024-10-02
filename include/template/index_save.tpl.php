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
        <link type="text/css" rel="stylesheet" href="<?=$application_path_css?>/report.css"/>
        <link type="text/css" rel="stylesheet" href="<?=$application_path_js?>/jquery/ui/themes/smoothness/jquery-ui.css" />
        <link type="text/css" rel="stylesheet" href="<?=$application_path_css?>/alert.css"/>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/ui/jquery-ui-1.8.13.custom.min.js"></script>
        <!--<script type="text/javascript" src="<?=$application_path_js?>/jquery/meio/jquery.meio.mask.min.js"></script>-->
        <script type="text/javascript" src="<?=$application_path_include?>/config.js.php"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/function.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/common.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/form.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/alert/alert.js"></script>
        
    </head>
    <body bgcolor="#fff">
        <form name="frmMain" action="index.php" method="post">
             
            <table width="100%" height="100%" align="center" bgcolor="#FFFFFF">
                <tr>
                    <td width="100%" align="left" valign="top"  align="left">&nbsp;
                        <?php 
                        
                            include_once $_SESSION["current_action"];
                       
                        ?>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="load_flag" value="1"/>
        </form>
        
    </body>
    <div style="background-color: #C0D9EA; position:fixed; bottom:0; width: 100%; height: 50px; margin: 0px;" align="center">
        <br>
        <table width="20%">
        <tr>
            <td style="width: 50%; text-align: center;"><img id="btn_save" name="btn_save" src="<?=$application_path_images;?>/btn_save.png" title="save" style="cursor: pointer; border: none;" /></td>
            <td style="width: 50%; text-align: center;"><img id="btn_back" name="btn_back" src="<?=$application_path_images;?>/btn_back.png" title="back" style="cursor: pointer; border: none;" /></td>
        </tr>
        </table><br>
   </div>
</html>