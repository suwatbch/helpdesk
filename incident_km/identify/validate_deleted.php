<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";

    php_header::text_html_utf8();
    global $db;
    
    if($_REQUEST["action"]== "deleted_km"){
            $table = "helpdesk_tr_incident";
            $condition = "km_reference = '{$_REQUEST["km_id"]}' ";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }
   $db->close();
?>
