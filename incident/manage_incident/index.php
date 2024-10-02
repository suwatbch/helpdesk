<?php 
session_start();
    define("PAGE_NAME", "Create Incident");
	define("NEW_ACTION", "action=incident.php");

    include_once "../../include/class/util/strUtil.class.php";
	/*if($_GET["mode"]){
	echo $mode	=$_GET["mode"];
	echo $id	=$_GET["id"];
	}*/
  
   $_SESSION["current_action"] = strUtil::nvl($_REQUEST["action"], "incident.php");
   $_SESSION["current"] = $_SERVER["PHP_SELF"];

    include_once "../../include/template/index.tpl.php";
?>