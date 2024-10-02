<?php
    $page_name  = "SEARCH INCIDENT";
    include_once "../../include/template/top.tpl.php";
    include_once "../../include/class/util/strUtil.class.php";

    $id = $_GET["id"]; 

    
    $_SESSION["current_action"] = strUtil::nvl($_REQUEST["action"], "result_list.php", "resultbyID($id)");
    $_SESSION["current"] = $_SERVER["PHP_SELF"];

    include_once "../../include/template/index.tpl.php";
?>