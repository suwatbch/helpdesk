<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/incident_type.class.php";

    php_header::text_html_utf8();

    $cus_company_id = $_REQUEST["cus_company_id"];
    $id = $_REQUEST["id"];
    
    if (strUtil::isEmpty($cus_company_id)){
		echo dropdown::select($id, "<option></option>", "style=\"width: 100%;\"");
    } else {
    	echo dropdown::loadIncident_type($db, $id, " name=\"$id\" style=\"width: 100%;\"", "", $cus_company_id);
	}

    $db->close();
?>
