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
      
        echo dropdown::loadCusZone($db, $id, $comp_id, "", "", "");
    
    }else{
        echo dropdown::select($id, "<option></option>", "style=\"width: 100%\"");
    }
    

?>
