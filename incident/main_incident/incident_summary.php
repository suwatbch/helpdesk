<?php
    include_once "../../include/config.inc.php";
    include_once "../../include/check_user_expire.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/incident_summary.class.php";
    include_once "../../include/class/db/db.php";
    
    
    $summary = new incident_summary($db);
    
    $overdue = 0;
    $open = 0;
    $today = 0;
    $pending = $summary->getPendingInc(user_session::get_user_id())
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <title></title>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
        <script type="text/javascript" src="../../include/js/function.js"></script>
       
    </head>
    <body>
        <form action="" target="main" method="post">
            <div width="100%" align="center">
                
                <table width="90%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="25%">
                            <div class="styleGrayBig" style="cursor: pointer;" align="center" 
                                 onmouseover="style.textDecoration = 'underline'"
                                 onmouseout="style.textDecoration = 'none'"><img src="../../images/overdue.png" /><br>Incident Overdue(<?= $overdue?>)</div>
                        </td>
                        <td width="25%">
                            <div class="styleGrayBig" style="cursor: pointer;" align="center" 
                                 onmouseover="style.textDecoration = 'underline'"
                                 onmouseout="style.textDecoration = 'none'"><img src="../../images/Warning.png" /><br>Incident Due Today(<?= $today?>)</div>
                        </td>
                        <td width="25%">
                            <div class="styleGrayBig" style="cursor: pointer;" align="center" 
                                 onmouseover="style.textDecoration = 'underline'"
                                 onmouseout="style.textDecoration = 'none'"><img src="../../images/open.png" /><br>Open Incident(<?= $open?>)</div>
                        </td>
                        <td width="25%">
                            <div class="styleGrayBig" style="cursor: pointer;" align="center" 
                                 onmouseover="style.textDecoration = 'underline'"
                                 onmouseout="style.textDecoration = 'none'"><img src="../../images/pending.png" /><br>Pending Incident(<?=$pending ?>)</div>
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