<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";

    php_header::text_html_utf8();
    global $db;
    
    if($_REQUEST["action"]== "validate_status_inc"){
            $sql_inc = "select status_id from helpdesk_tr_incident where id = '{$_REQUEST["incident_id"]}' and status_id = 7 ";
            $result_inc = $db->query($sql_inc);
            $rows = $db->num_rows($result_inc);
            
            if ($rows > 0){
                echo "1";
                exit();
            }    
          
    }
    ?>