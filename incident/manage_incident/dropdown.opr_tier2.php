<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/opr_tier2.class.php";

    php_header::text_html_utf8();

    $cas_opr_tier_id1 = $_REQUEST["cas_opr_tier_id1"];
    $cus_company_id = $_REQUEST["cus_company_id"];
    $attr = stripslashes($_REQUEST["attr"]);
	
    if (strUtil::isEmpty($cas_opr_tier_id1)){
        echo dropdown::select("cas_opr_tier_id2", "<option></option>", "style=\"width: 100%;\"");

    } else {
		echo dropdown::loadOpr_tier2($db, "cas_opr_tier_id2", "required=\"true\" name=\"cas_opr_tier_id2\" style=\"width: 100%;\"", $attr, $cas_opr_tier_id1, $cus_company_id);

    }

    $db->close();
?>
