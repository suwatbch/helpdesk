<?php

    define("NEW_ACTION", "action=product.php");
    
    $page_name  = "<span class='styleBlue_master1'>Master Configuration</span>";
    $master_name = "<span class='styleBlue_master2'>Product Class </span><span class='styleBlue_master3'>Master</span>";
    include_once "../../include/template/top_master.tpl.php";
    include_once "../../include/class/util/strUtil.class.php";

    $_SESSION["current_action"] = strUtil::nvl($_REQUEST["action"], "product_list.php");
    $_SESSION["current"] = $_SERVER["PHP_SELF"];
    include_once "../../include/template/index_master.tpl.php";
?>