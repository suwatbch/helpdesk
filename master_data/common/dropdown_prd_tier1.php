<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier1.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["cus_comp_id"];
    $s_prd_tier_lv1_id = $_REQUEST["prd_tier_lv1_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('prd_tier_lv1_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadPrd_tier1($db, 'prd_tier_lv1_id', " name=\"prd_tier_lv1_id\" style=\"width: 100%;\"", $s_prd_tier_lv1_id, $company_id);
	}

    $db->close();
?>
