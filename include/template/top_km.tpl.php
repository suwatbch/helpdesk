<?php
    include_once dirname(dirname(__FILE__))."/config.inc.php";
    include_once dirname(dirname(__FILE__))."/check_user_expire.php";
    include_once dirname(dirname(__FILE__))."/class/util/strUtil.class.php";
    include_once dirname(dirname(__FILE__))."/class/model/incident_summary.class.php";
    include_once dirname(dirname(__FILE__))."/class/db/db.php";
      
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <title></title>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
        <script type="text/javascript" src="../../include/js/function.js"></script>
    </head>
    <body style="background-color:white; height: 35px">
        <form style="background-color:white; height: 35px" >
            <!--<div  height="100px">&nbsp;</div>-->
            <div width="100%" align="left" style="background-color:white; height: 35px">
                
                <table id="tb_adv_left" width="98%" >
                    <tr>
                        <td width="100%" style="border-bottom: #B40431 solid medium;">
                            <? echo $page_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <? echo $master_name; ?>
                        </td>
                    </tr>
                </table>
                
            </div>
        </form>
    </body>
</html>