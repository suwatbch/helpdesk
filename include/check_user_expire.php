<?php
	@ini_set('display_errors', '0'); 
	session_start();
    include_once dirname(__FILE__)."/config.inc.php";
    include_once dirname(__FILE__)."/class/user_session.class.php";
    include_once dirname(__FILE__)."/class/php_header.class.php";

    $log_id = trim(user_session::get_log_id());
    if($log_id != ""){
        if (isset($db) && get_class($db) == "db"){
            //include_once dirname(__FILE__)."/class/model/security.class.php";
            include_once dirname(__FILE__)."/class/model/helpdesk_security.class.php";

            $sec = new h_security($db);

            $info = $sec->getSessionInfo($log_id);

            # check idle time and current version
            if ($info["idle_time"] > $session_timeout){
                expire();
            }

            # check current version
            if ($info["version"] != $application_version){
                expire();
            }
        }
    } else {
        expire();
    }

    function expire(){
        global $application_path;

        die("<script type=\"text/javascript\">
                   alert(\"Your session has expired. Please login again.\");
                    top.location=\"$application_path/logout.php\";
                </script>"
        );
    }