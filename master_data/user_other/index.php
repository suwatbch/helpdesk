<?php

    define("NEW_ACTION", "action=user_other.php");
    
    $page_name  = "<span class='styleBlue_master1'>Master Configuration</span>";
    $master_name = "<span class='styleBlue_master2'>User Other </span><span class='styleBlue_master3'>Master</span>";
    include_once "../../include/template/top_master.tpl.php";
    include_once "../../include/class/util/strUtil.class.php";

    $_SESSION["current_action"] = strUtil::nvl($_REQUEST["action"], "user_other_list.php");
    $_SESSION["current"] = $_SERVER["PHP_SELF"];
    include_once "../../include/template/index_master.tpl.php";
?>