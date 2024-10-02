<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_subgrp.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["company_id"];
    $group_id = $_REQUEST["group_id"];
    $s_subgrp_id = $_REQUEST["s_subgrp_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::select('subgrp_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadSubGrp_master($db, 'subgrp_id', " name=\"subgrp_id\" style=\"width: 100%;\"", $s_subgrp_id, $company_id, $group_id);
	}

    $db->close();
?>
