<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier2.class.php";

    php_header::text_html_utf8();
    global $db;

    $company_id = $_REQUEST["cus_comp_id"];
    $s_prd_tier_lv2_id = $_REQUEST["prd_tier_lv2_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('prd_tier_lv2_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadPrd_tier2_master($db, 'prd_tier_lv2_id', " name=\"prd_tier_lv2_id\" style=\"width: 100%;\"", $s_prd_tier_lv2_id, $company_id);
	}

    $db->close();
?>
