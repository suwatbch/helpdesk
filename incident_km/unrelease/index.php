<?php

    define("NEW_ACTION", "action=incident_identify.php");
    
    $page_name  = "<span class='styleBlue_master1'>Incident KM Tools</span>";
    $master_name = "<span class='styleBlue_master2'>Release</span>";
    include_once "../../include/template/top_km.tpl.php";
    include_once "../../include/class/util/strUtil.class.php";

    $_SESSION["current_action"] = strUtil::nvl($_REQUEST["action"], "unrelease_list.php");
    $_SESSION["current_km"] = $_SERVER["PHP_SELF"];
    include_once "../../include/template/index_km.tpl.php";
?>