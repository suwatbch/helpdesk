<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_opr.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["company_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('tr_opr_tier_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadOprSla($db, 'tr_opr_tier_id', " name=\"tr_opr_tier_id\" style=\"width: 100%;\"", "", $company_id);
	}

    $db->close();
?>
