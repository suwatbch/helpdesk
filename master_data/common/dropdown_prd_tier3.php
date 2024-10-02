<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier3.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["cus_comp_id"];
    $prd_tier_lv3_id = $_REQUEST["prd_tier_lv3_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('prd_tier_lv3_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadPrd_tier3_master($db, 'prd_tier_lv3_id', " name=\"prd_tier_lv3_id\" style=\"width: 100%;\"", $prd_tier_lv3_id, $company_id);
	}

    $db->close();
?>
