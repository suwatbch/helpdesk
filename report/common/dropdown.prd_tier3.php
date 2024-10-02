<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/prd_tier3.class.php"; 
     include_once "../../include/class/model/status.class.php";
     include_once "../../include/class/model/report.class.php";
    
    php_header::text_html_utf8();

    $comp_id = $_GET["comp_id"];
    $id = $_GET["id"];
    
    if (strUtil::isNotEmpty($comp_id)){
        echo dropdown::loadPrd_tier3_report($db, $id, "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"","","","",$comp_id);
        
    }else{
        echo dropdown::select($id, "<option></option>", "style=\"width: 100%\"");
    }
    
    

?>
