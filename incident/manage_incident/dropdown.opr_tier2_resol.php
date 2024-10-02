<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/opr_tier2_resol.class.php";

    php_header::text_html_utf8();

    $resol_oprtier1 = $_REQUEST["resol_oprtier1"];
    $cus_company_id = $_REQUEST["cus_company_id"];
    $attr = stripslashes($_REQUEST["attr"]);
    
    if (strUtil::isEmpty($resol_oprtier1)){
        echo dropdown::select("resol_oprtier2", "<option></option>", $attr);

    } else {
		echo dropdown::loadOpr_tier2_resol($db, "resol_oprtier2", "$dd_required_resol\" name=\"resol_oprtier2\" style=\"width: 200px;\"", $attr, $resol_oprtier1, $cus_company_id);

    }

    $db->close();
?>
