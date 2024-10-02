<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_grp.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["company_id"];
    $s_grp_id = $_REQUEST["s_grp_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('group_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadGrp_master($db, 'group_id', "style=\"width: 100%;\"", $s_grp_id, $company_id);
	}

    $db->close();
?>