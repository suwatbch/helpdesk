<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/opr_tier3.class.php";

    php_header::text_html_utf8();

    $cas_opr_tier_id1 = $_REQUEST["cas_opr_tier_id1"];
    $cas_opr_tier_id2 = $_REQUEST["cas_opr_tier_id2"];
    $cus_company_id = $_REQUEST["cus_company_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($cas_opr_tier_id1) || strUtil::isEmpty($cas_opr_tier_id2 || strUtil::isEmpty($cus_company_id))){
        echo dropdown::select("cas_opr_tier_id3", "<option></option>", $attr);

    } else {
		echo dropdown::loadOpr_tier3($db, "cas_opr_tier_id3", "required=\"true\" name=\"cas_opr_tier_id3\" style=\"width: 100%;\"", $attr, $cas_opr_tier_id1, $cas_opr_tier_id2, $cus_company_id);

    }

    $db->close();
?>
