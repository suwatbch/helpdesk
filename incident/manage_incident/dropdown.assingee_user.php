<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_user.class.php";

    php_header::text_html_utf8();

    $assign_comp_id = $_REQUEST["assign_comp_id"];
    $assign_subgrp_id = $_REQUEST["assign_subgrp_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($assign_comp_id) || strUtil::isEmpty($assign_subgrp_id)){
        echo dropdown::select("assign_assignee_id", "<option></option>", $attr);
		//echo dropdown::loadStatus_res($db, "status_res_id", "name=\"Status_res\" style=\"width: 200px;\"", $incident["status_res_id"]);

    } else {
		echo dropdown::loadAssign_assignee_id($db, "assign_assignee_id",  "$dd_required_assig\ name=\"assign_assignee_id\" style=\"width: 200px;\"", $attr, $assign_comp_id, $assign_subgrp_id);

    }

    $db->close();
?>
