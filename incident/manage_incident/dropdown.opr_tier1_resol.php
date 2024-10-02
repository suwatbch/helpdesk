<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/opr_tier1_resol.class.php";

    php_header::text_html_utf8();

    $cus_company_id = $_REQUEST["cus_company_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($cus_company_id)){
		echo dropdown::select("resol_oprtier1", "<option></option>", "style=\"width: 100%;\"");
    } else {
		echo dropdown::loadOpr_tier1_resol($db, "resol_oprtier1", "required=\"true\" style=\"width: 100%;\"", $attr, $cus_company_id);
	}

    $db->close();
?>
