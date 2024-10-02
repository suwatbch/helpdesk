<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier2.class.php";

    php_header::text_html_utf8();

    $cas_prd_tier_id1 = $_REQUEST["cas_prd_tier_id1"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($cas_prd_tier_id1)){
        echo dropdown::select("cas_prd_tier_id2", "required=\"true\" <option></option>", $attr);

    } else {
		echo dropdown::loadPrd_tier2($db, "cas_prd_tier_id2", "required=\"true\" name=\"cas_prd_tier_id2\" style=\"width: 100%;\"", $attr, $cas_prd_tier_id1);

    }

    $db->close();
?>
