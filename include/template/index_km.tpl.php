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
                        
                            if($action_master == 4){
                        ?>
                            <img id="new" name="new" src="<?=$application_path_images;?>/btn_new.png" title="new" style="cursor: pointer; border: none;" action="<?=$_SESSION["current_km"]."?".NEW_ACTION."&action_master=1"?>" />
                        <?
                        }else if($action_master == 1){ ?>                  
                        <img id="save_draft" name="save_draft" src="<?=$application_path_images;?>/btn_save_draft.png" title="save draft" style="cursor: pointer; border: none;" />
                        <img id="save_release" name="save_release" src="<?=$application_path_images;?>/save_to_release.png" title="save release" style="cursor: pointer; border: none;" />
                        <img id="undo" name="undo" src="<?=$application_path_images;?>/btn_undo.png" title="undo" style="cursor: pointer; border: none;" />
                        <img id="cancel" name="cancel" src="<?=$application_path_images;?>/btn_back.png" title="Back" style="cursor: pointer; border: none;" />
                        <?php
                        }else if($action_master == 2){ ?>
                        <img id="save_unrelease" name="save_unrelease" src="<?=$application_path_images;?>/btn_release.png" title="release" style="cursor: pointer; border: none;" />
                        <img id="save_identify" name="save_identify" src="<?=$application_path_images;?>/btn_identify.png" title="identify" style="cursor: pointer; border: none;" />
                            <? }else if($action_master == 3){ ?>
                        <img id="save_release" name="save_release" src="<?=$application_path_images;?>/btn_unrelease.png" title="unrelease" style="cursor: pointer; border: none;" /> &nbsp;&nbsp;
                        
                        <? }
                            ?>
                        <br>
   </div> 
</html>
