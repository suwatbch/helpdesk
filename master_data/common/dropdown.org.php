<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_org.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["company_id"];
    $s_org_id = $_REQUEST["s_org_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('org_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadOrg_master($db, 'org_id', " name=\"org_id\" style=\"width: 100%;\"", $s_org_id, $company_id);
	}

    $db->close();
?>
