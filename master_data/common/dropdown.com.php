<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";

    php_header::text_html_utf8();

    $company_id = $_REQUEST["s_com_id"];
    
    if (strUtil::isEmpty($company_id)){
		echo dropdown::loadCompanyMaster($db,'company_id', "<option></option>", "style=\"width: 100%;\"");
    } else {
        echo dropdown::loadCompanyMaster($db, 'company_id', "style=\"width: 100%;\"", $company_id);
	}

    $db->close();
?>
