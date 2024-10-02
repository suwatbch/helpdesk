<?php
    if (!defined("UNSPECIFIED"))  define("UNSPECIFIED", "unspecified");
    if (!defined("FINALIZE"))  define("FINALIZE", "finalize");
    if (!defined("FILE_PATH"))  define("FILE_PATH", dirname(dirname(__FILE__)));

    if (!defined("NOT_EXPIRE")){
        include_once FILE_PATH."/check_user_expire.php";
    }
    
    include_once FILE_PATH."/class/user_session.class.php";
    include_once FILE_PATH."/class/util/strUtil.class.php";
    include_once FILE_PATH."/exception/fp_exception.php";

    $log_id = user_session::get_log_id();
    if (strUtil::isNotEmpty($log_id) && isset($db) && get_class($db) == "db"){
        //include_once FILE_PATH."/class/model/security.class.php";
        include_once FILE_PATH."/class/model/helpdesk_security.class.php";

        $sec = new h_security($db);
        $db->begin_transaction();
        $result = $sec->updateLog($log_id);
        $db->end_transaction($result);
    }

    $error_message = "";
    $action_name = strUtil::nvl($_REQUEST["action_name"], UNSPECIFIED);

    if (!strUtil::isEmpty($action_name)){
        if (function_exists($action_name)){
            call_user_func($action_name);
        } else if ($action_name != UNSPECIFIED) {
            fp_exception::display("Action Name ($action_name) is not exists.");
        }
    }
    
    if (strUtil::isNotEmpty($error_message)) {
         echo "<script>setTimeout('alert(\"$error_message\");', 150);</script>";
    }

    if (function_exists(FINALIZE)){
        call_user_func(FINALIZE);
    }
?>