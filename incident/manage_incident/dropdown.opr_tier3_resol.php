<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/opr_tier3_resol.class.php";

    php_header::text_html_utf8();

    $resol_oprtier1 = $_REQUEST["resol_oprtier1"];
    $resol_oprtier2 = $_REQUEST["resol_oprtier2"];
    $cus_company_id = $_REQUEST["cus_company_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($resol_oprtier1) || strUtil::isEmpty($resol_oprtier2) || strUtil::isEmpty($cus_company_id)){
        echo dropdown::select("resol_oprtier3", "<option></option>", $attr);

    } else {
		echo dropdown::loadOpr_tier3_resol($db, "resol_oprtier3", "$dd_required_resol\" name=\"resol_oprtier3\" style=\"width: 100%;\"", $attr, $resol_oprtier1, $resol_oprtier2, $cus_company_id);

    }

    $db->close();
?>
