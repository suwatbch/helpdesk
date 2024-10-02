<?php

    
    $page_name  = "<span class='styleBlue_master1'>Knowledge Management</span>";
    $master_name = "<span class='styleBlue_master2'>Incident KM</span>";
    include_once "../../include/template/top_km.tpl.php";
    include_once "../../include/class/util/strUtil.class.php";

    $_SESSION["current_action"] = strUtil::nvl($_REQUEST["action"], "km_tree_list.php");
    $_SESSION["current_km"] = $_SERVER["PHP_SELF"];
    include_once "../../include/template/index_km.tpl.php";
?>