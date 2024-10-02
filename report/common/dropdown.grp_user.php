<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_grp.class.php";

    php_header::text_html_utf8();

    $assign_comp_id = $_REQUEST["assign_comp_id"];
    $assign_org_id = $_REQUEST["assign_org_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    $name = $_REQUEST["name"];
    
    if ($name == ""){
        $name = "assign_group_id";
    }
    
    if (strUtil::isEmpty($assign_comp_id) && strUtil::isEmpty($assign_org_id)){
        echo dropdown::select("$name", "<option></option>", $attr);
		//echo dropdown::loadStatus_res($db, "status_res_id", "name=\"Status_res\" style=\"width: 200px;\"", $incident["status_res_id"]);

    } else {
		echo dropdown::loadGrp_master($db, "$name",  "$dd_required_assig\ name=\"$name\" style=\"width: 100%;\"", $attr, $assign_comp_id, $assign_org_id);

    }

    $db->close();
?>