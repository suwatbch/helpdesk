<?php
$page = $_SERVER['PHP_SELF'];

    include_once dirname(dirname(dirname(__FILE__)))."/include/config.inc.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/db/db.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/util/strUtil.class.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/util/dateUtil.class.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/model/sla.class.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/model/call_job_auto_sla.class.php";
    include_once dirname(dirname(dirname(__FILE__)))."/include/class/mail.class.php";
    
    
    
    global $db,$call_job_auto_sla,$type_id,$arr_job,$strFileName,$objFopen,$strwritetext,$now,$next_run,$next_secs;
    $now = date("Y-m-d H:i");
    $strFileName = dirname(dirname(dirname(dirname(__FILE__))))."\LOG_auto_sla_alert.txt";
    $objFopen = fopen($strFileName, 'a');

    $type_id = 14;
//    echo $db;
//    exit();
    $call_job_auto_sla = new call_job_auto_sla($db);
    
    $arr_job = $call_job_auto_sla->call_schedule($type_id);
    
    if ($arr_job["total_rows"] > 0) {
        $active_job = $arr_job["data"];
        foreach ($active_job as $value) {
           $next_run = $value["next_run"];
           $next_run = substr($next_run, 0,16);

           $next_secs = $value["next_secs"];

        }

        if ($now == $next_run){
            require 'sla_send_email.php';
            $result = $call_job_auto_sla->upd_schedule($now, $type_id);
            $strwritetext = $now." ---> run job success.\r\n";
            fwrite($objFopen, $strwritetext);            
        }
        
    }else {
        $strwritetext = $now." ---> schedule task not set.\r\n";
        fwrite($objFopen, $strwritetext);
    }
          
if ($next_secs == 0 || $next_secs == "" || $next_secs < 0){
    $next_secs = 3600;
}
$sec = $next_secs;
?>
<html>
    <head>
    <meta charset="UTF-8" http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <style type="text/css">
        body{
            font-family: Vernada,sans-serif;
            font-size: 11.5pt;
        }
    </style>
    </head>
    <body>
        <label style="color: white;">now: <?=$now;?> | next run: <?=$next_run;?></label>
        <label style="color: red; font-weight: bold; font-size: 20pt;"><br>ห้ามปิดหน้าต่างนี้ เนื่องจากระบบ Helpdesk กำลังทำงาน!!!!</label>
        <br>
        <br>
        <label style="color: #0489B1; font-weight: bold;">refresh page every <?=$sec;?> seconds </label><br>
        <label style="color: #0489B1;"><br><?=$strwritetext;?></label>
        
    </body>
</html>

