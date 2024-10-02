<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier2_resol.class.php";

    php_header::text_html_utf8();

    $resol_prdtier1 = $_REQUEST["resol_prdtier1"];
    $cus_company_id = $_REQUEST["cus_company_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($resol_prdtier1) || strUtil::isEmpty($cus_company_id)){
        echo dropdown::select("resol_prdtier2", "<option></option>", $attr);

    } else {
		echo dropdown::loadPrd_tier2_resol($db, "resol_prdtier2", "$dd_required_resol\" name=\"resol_prdtier2\" style=\"width: 100%;\"", $attr, $resol_prdtier1, $cus_company_id);

    }

    $db->close();
?>
