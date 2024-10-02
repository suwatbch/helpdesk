<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/status_res.class.php";

    php_header::text_html_utf8();

    $status_id = $_REQUEST["status_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($status_id)){
        echo dropdown::select("status_res_id", "<option></option>", $attr);
		//echo dropdown::loadStatus_res($db, "status_res_id", "name=\"Status_res\" style=\"width: 200px;\"", $incident["status_res_id"]);

    } else {
		echo dropdown::loadStatus_res($db, "status_res_id", " name=\"Status_res\" style=\"width: 100%;\"", $attr, $status_id);

    }

    $db->close();
?>
