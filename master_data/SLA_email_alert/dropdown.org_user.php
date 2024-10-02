<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_org.class.php";

    php_header::text_html_utf8();

    $assign_comp_id = $_REQUEST["assign_comp_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($assign_comp_id)){
        echo dropdown::select("assign_org_id", "<option></option>", $attr);
		//echo dropdown::loadStatus_res($db, "status_res_id", "name=\"Status_res\" style=\"width: 200px;\"", $incident["status_res_id"]);

    } else {
		echo dropdown::loadOrg($db, "assign_org_id",  "$dd_required_assig\ name=\"assign_org_id\" style=\"width: 100%;\"", $attr, $assign_comp_id);

    }

    $db->close();
?>
