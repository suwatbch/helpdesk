<?php
    include_once '../../include/config.inc.php';
    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/report_detail.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
       
        
        global $report_detail ,$db;
        $report_detail = new report_detal($db);
    
        
    }
    
    