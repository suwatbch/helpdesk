<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_prd.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["company_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('tr_prd_tier_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadPrdSla($db, 'tr_prd_tier_id', " name=\"tr_prd_tier_id\" style=\"width: 100%;\"", "", $company_id);
	}

    $db->close();
?>
