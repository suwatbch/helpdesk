<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier1.class.php";

    php_header::text_html_utf8();

    $cus_company_id = $_REQUEST["cus_company_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($cus_company_id)){
		echo dropdown::select("prd_tier_id1", "required=\"true\"<option></option>", "style=\"width: 200px\"");
    } else {
		echo dropdown::loadPrd_tier1($db, "prd_tier_id1", "style=\"width: 200px;\"", $attr, $cus_company_id);
	}

    $db->close();
?>
