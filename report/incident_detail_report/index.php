<?php
//    include_once "incident_summary.php";

    $page_name  = "INCIDENT Detail Report";
    include_once "../../include/template/top.tpl.php";
    include_once "../../include/class/util/strUtil.class.php";

//    $mode = $_GET["mode"]; 
//
//    if($_POST["mode"]) $mode = $_POST["mode"];

    $_SESSION["current_action"] = strUtil::nvl($_REQUEST["action"], "incident_detail_report.php");
    $_SESSION["current"] = $_SERVER["PHP_SELF"];

    include_once "../../include/template/index.tpl.php";
?>