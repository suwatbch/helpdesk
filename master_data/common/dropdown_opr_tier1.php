<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/opr_tier1.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["cus_comp_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('opr_tier_lv1_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadOpr_tier1($db, 'opr_tier_lv1_id', " name=\"opr_tier_lv1_id\" style=\"width: 100%;\"", "", $company_id);
	}

    $db->close();
?>