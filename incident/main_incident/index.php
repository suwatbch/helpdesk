<?php
//    include_once "incident_summary.php";
session_start();
//    define("PAGE_NAME", "INCIDENT CONTROL");

if ($_GET["mode"]) {
    if ($_GET["mode"] == 1){
        $page_name  = "MY INCIDENT";
    }elseif ($_GET["mode"] == 2){
        $page_name  = strtoupper("MY GROUP");
    }elseif ($_GET["mode"] == 3){
        $page_name  = "My GROUP(UNASSIGNED)";
    }elseif ($_GET["mode"] == 4){
        $page_name  = strtoupper("All Group(unassigned)");
    }
}else{
    $page_name  = "ALL GROUP";
	//$_GET["mode"] == 1;
}
//    $page_name  = "INCIDENT CONTROL";
    include_once "../../include/template/top.tpl.php";

    include_once "../../include/class/util/strUtil.class.php";
    
	//if ($_GET["mode"]==""){	$mode = 1; }else{ $mode = $_GET["mode"]; }
		
    if($_GET["mode"]) $mode = $_GET["mode"];
    //echo $mode;	
    $_SESSION["current_action"] = strUtil::nvl($_REQUEST["action"], "incident_list.php", "search($mode)");
    $_SESSION["current"] = $_SERVER["PHP_SELF"];

    include_once "../../include/template/index.tpl.php";
?>