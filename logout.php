<?php
    include_once "include/config.inc.php";
    include_once "include/class/user_session.class.php";
    include_once "include/class/php_header.class.php";
    include_once "include/class/util/strUtil.class.php";
    //include_once "include/class/model/security.class.php";
    include_once "include/class/model/helpdesk_security.class.php";
    include_once "include/class/db/db.php";

    # logout
    $log_id = user_session::get_log_id();
    if (strUtil::isNotEmpty($log_id)){
        //$sec = new security($db);
        $sec = new h_security($db);
        $db->begin_transaction();
        $result = $sec->logout($log_id);
        $db->end_transaction($result);
    }
    $db->close();   

    # session destroy
    @session_destroy();

    if (SERVER_PROD == 0){
        php_header::redirect("main.php");
    } else {
        $script = "<script type=\"text/javascript\">\n";

        $user_agent = $_SERVER["HTTP_USER_AGENT"];

        $ie_pos = strpos($user_agent, "MSIE");
        if ($ie_pos > 0){
            $ie_version = substr($user_agent, $ie_pos + 5, 1);
            if ($ie_version > 6){
                $script .= "   window.open(\"\", \"_self\", \"\");\n";
            } else {
                $script .= "   window.opener = null;\n";
            }
        } else {
            $script .= "   window.opener = \"\";\n";
        }
         
        $script .=  "    window.location = 'login.php';\n";
//        $script .=  "    window.close();\n";
        $script .= "</script>";

        echo $script;
    }
?>