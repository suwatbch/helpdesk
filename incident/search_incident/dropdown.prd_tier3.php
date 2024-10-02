<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier3.class.php";

    php_header::text_html_utf8();

    $cas_prd_tier_id1 = $_REQUEST["cas_prd_tier_id1"];
    $cas_prd_tier_id2 = $_REQUEST["cas_prd_tier_id2"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($cas_prd_tier_id1)){
        echo dropdown::select("cas_prd_tier_id3", "<option></option>", $attr);

    } else {
		echo dropdown::loadPrd_tier3($db, "cas_prd_tier_id3", " name=\"cas_prd_tier_id3\" style=\"width: 100%;\"", $attr, $cas_prd_tier_id1, $cas_prd_tier_id2);

    }

    $db->close();
?>
