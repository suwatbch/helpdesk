<?php
    include_once dirname(dirname(__FILE__))."/config.inc.php";
    include_once dirname(dirname(__FILE__))."/check_user_expire.php";
    include_once dirname(dirname(__FILE__))."/class/util/strUtil.class.php";
    include_once dirname(dirname(__FILE__))."/class/model/incident_summary.class.php";
    include_once dirname(dirname(__FILE__))."/class/db/db.php";
    
    
//    $summary = new incident_summary($db);
//    
//    $overdue = 0;
//    $open = 0;
//    $today = 0;
//    $pending = $summary->getPendingInc(user_session::get_user_id())
//    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <title></title>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
        <script type="text/javascript" src="../../include/js/function.js"></script>
        <style type="text/css">
/*            .title-bar{
                height: 29px;
                text-align: left;
                background: url(<?=$application_path?>/images/title_bar.png)
            }

            span.title{
                color: #FFFFFF;
                font-weight: bold;
                font-size: 12px;
            }*/

           
        </style>
    </head>
    <body style="background-color:white; height: 35px">
        <form style="background-color:white; height: 35px" >
            <!--<div  height="100px">&nbsp;</div>-->
            <div width="100%" align="left" style="background-color:white; height: 35px">
                
                <table id="tb_adv_left" width="98%" >
                    <tr>
                        <td width="100%" style="border-bottom: #B40431 solid medium;">
                            <span class="styleBlue"><?=$page_name;?></span>
                        </td>
                    </tr>
                </table>
                
            </div>
        </form>
    </body>
</html>





<!--<td class="title-bar">
                        <table width="100%">
                            <tr>
                                <td width="28%" align="left" valign="middle">
                                    &nbsp;&nbsp;
                                    <img src="../../images/arrow-circle-double.png" style="cursor: pointer" alt="Refresh" onclick="window.open('<?=$_SESSION["current"]?>?action=<?=$_SESSION["current_action"]?>', 'main');" align="absmiddle"/>
                                    <span class="title"><//$_REQUEST["title"]?></span>
                                </td>
                                <td align="right" valign="middle" style="padding-right: 5px;">&nbsp;
                                    
                                </td>
                            </tr>
                        </table>
                    </td>-->