<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_project.class.php";

    php_header::text_html_utf8();

    $cus_company_id = $_REQUEST["cus_company_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($cus_company_id)){
		echo dropdown::select("project_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
    } else {
		echo dropdown::loadProject($db, "project_id", "required=\"true\" name=\"project_id\" style=\"width: 100%;\"", $attr, $cus_company_id);
	}

    $db->close();
?>