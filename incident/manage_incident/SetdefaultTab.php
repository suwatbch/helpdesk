<?php
session_start();
//include_once "../../include/class/user_session.class.php";
//echo $u_inci = user_session::get_incident_id(); //exit;
//echo "var defaultTab = 0;";

if($_SESSION["TabIndex"]){
	echo "var defaultTab = ".$_SESSION["TabIndex"].";";
}else{
	echo "var defaultTab = 0;";
}

?> 
