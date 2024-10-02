<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
     include_once "../../include/class/model/report.class.php";
    
    php_header::text_html_utf8();

    $comp_id = $_GET["comp_id"];
//    $project_id = $_GET["project_id"];
    $id = $_GET["id"];
    
    if (strUtil::isNotEmpty($comp_id) ){
        echo dropdown::loadDateMonthly($db, "date_monthly", $comp_id, "name=\"date_monthly\" style=\"width: 100%;\"","");
    }else{
        echo dropdown::select($id, "<option></option>", "style=\"width: 100%\"");
    }
    
    

?>
