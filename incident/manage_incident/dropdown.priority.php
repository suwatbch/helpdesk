<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/priority.class.php";

    php_header::text_html_utf8();

    $impact_id = $_REQUEST["impact_id"];
	$urgency_id = $_REQUEST["urgency_id"]; 
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($impact_id) || strUtil::isEmpty($urgency_id)){
        echo dropdown::select("priority_id", "<option></option>", $attr);

    } else {
		echo dropdown::loadPriority($db, "priority_id", "required=\"true\" name=\"priority_id\" style=\"width: 200px;\" class=\"select_dis\" disabled", $attr, $impact_id,$urgency_id);

    }

    $db->close();
?>
