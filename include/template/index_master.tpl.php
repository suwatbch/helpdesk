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
        <link type="text/css" rel="stylesheet" href="<?=$application_path_css?>/alert.css"/>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/ui/jquery-ui-1.8.13.custom.min.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/meio/jquery.meio.mask.min.js"></script>
        <script type="text/javascript" src="<?=$application_path_include?>/config.js.php"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/function.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/common.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/form.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/alert/alert.js"></script>
        <script type="text/javascript">
            $(function(){
                $("#new").click(function(){
                    top.main.frmMain.target = "main";
                    top.main.frmMain.action =  $(this).attr("action");
                    top.main.frmMain.submit();
                });
            });
        </script>
        <script language="JavaScript">
	function chkNumber(ele)
	{
	var vchar = String.fromCharCode(event.keyCode);
	if ((vchar<'0' || vchar>'9')) return false;
	ele.onKeyPress=vchar;
	}
</script>
    </head>
    <? $action_master = $_REQUEST["action_master"]; ?>
    <body bgcolor="#fff">
        <form name="frmMain" action="index.php" method="post" enctype="multipart/form-data">
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
    <div style="background-color: #C0D9EA; position:fixed; bottom:0px; width: 100%; height: 30px; padding: 5px 0px 0px 5px;">
                        <?php
                        
                            if(strUtil::isEmpty($action_master) && $action_master != 1 && $action_add_user_other!= 1){
                        ?>
                            <img id="new" name="new" src="<?=$application_path_images;?>/btn_new.png" title="new" style="cursor: pointer; border: none;" action="<?=$_SESSION["current"]."?".NEW_ACTION."&action_master=1"?>" />
       
<!--                        <button id="new" style="border: 1px #788480 solid; width: 100px; background-color: red;" action="<?=$_SESSION["current"]."?".NEW_ACTION."&action_master=1"?>">New</button>-->
                        <? }else if($action_add_user_other== 1){
                         ?>
                        <input type="button" id="btn_add_user_other" value="Add Other Group" class="input-button"  style=" width: 130px; height: 25px;" style="cursor: pointer;"/>
                        <input type="button" id="cancel" value="Cancel" class="input-button"  style=" width: 130px; height: 25px;" style="cursor: pointer;"/>
                        <?
                        }else if($action_master == 1){ ?>
<!--                        <button id="save" style="border: 1px #788480 solid; width: 100px; background-color: red;">Save</button>-->
                        <img id="save" name="save" src="<?=$application_path_images;?>/btn_save.png" title="save" style="cursor: pointer; border: none;" />
<!--                        <button id="undo" style="border: 1px #788480 solid; width: 100px;">Undo</button>-->
                        <img id="undo" name="undo" src="<?=$application_path_images;?>/btn_undo.png" title="undo" style="cursor: pointer; border: none;" />
<!--                        <button id="cancel" style="border: 1px #788480 solid; width: 100px;">Cancel</button>-->
                        <img id="cancel" name="cancel" src="<?=$application_path_images;?>/btn_back.png" title="Back" style="cursor: pointer; border: none;" />
                        <?php
                            }
                            ?>
                        <br>
   </div> 
</html>
