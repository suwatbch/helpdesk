<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_org.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["cus_company_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('cus_org_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadCusOrg($db, 'cus_org_id', " name=\"cus_org_id\" style=\"width: 100%;\"", '', $company_id);
	}

    $db->close();
?>
