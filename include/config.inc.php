<?php
    require_once "class/util/urlUtil.class.php";

    define("DIRECTORY_SEPARATOR", "\\");
    define("SERVER_PROD", 1);
    date_default_timezone_set('Asia/Bangkok');
   	//$ip_hosting = "172.21.246.49";
   	//$ip_hosting = "172.30.241.80";   //Server PEA
   	$ip_hosting = "services.portalnet.co.th";
    // $ip_hosting = "service.swmaxnet.com";
   	// $source_dir = "helpdesk";
	
	// $web_url 	= (SERVER_PROD == "1") ? "https://".$ip_hosting."/v.1/login.php":" ";
    // $web_url 	= (SERVER_PROD == "1") ? "https://".$ip_hosting."/login.php":" ";
    $web_url = (SERVER_PROD == "1") ? "http://localhost/helpdesk/login.php":" ";

    # System Path
    //$application_path 			= urlUtil::getWebDir(dirname(dirname((__FILE__))));
	// $application_path 			= "https://services.portalnet.co.th/";
    // $application_path 			= "https://service.swmaxnet.com/";
    $application_path 			= "http://localhost/helpdesk/";
    $application_path_images 	= "$application_path/images";
    $application_path_include 	= "$application_path/include";
    $application_path_js 		= "$application_path_include/js";
    $application_path_css 		= "$application_path_include/css";
    $application_path_js_images = "$application_path_js/images";


/*---Site PEA*/
   //$db_host 				= "localhost";
    //$db_user 				= "root";
    //$db_password 			= "123456";
    //$db_schemata 			= "helpdeskv2";

	
	$db_host 				= "localhost";
	$db_user 				= "root";
	$db_password 			= "";
	$db_schemata 			= "helpdesk";

    // $db_host 				= "115.178.63.11";
	// $db_user 				= "swmaxnet_helpdesk";
	// $db_password 			= "3of7USpBpD%FCw";
	// $db_schemata 			= "swmaxnet_db-helpdesk_v2";

	// $db_host 				= "localhost";
    // 	$db_user 				= "rootadmin";
    // 	$db_password 			= "&0rM5g19m";
    // 	$db_schemata 			= "db-helpdesk_v2";


    # System Name
    $application_name 		= "Helpdesk System";
    $application_version 	= "1.0";

    # จำนวน Record ที่แสดงในแต่ละ Page
    $page_size 				= 30;

    # Session
    //$session_timeout = 30;
    $session_timeout 		= 60;
	
    # Incidetn Running By project_code ใส่ค่าว่างคือไม่กำหนดให้รันตามโปรเจค
    $IncidentRunProject 	= "Y";

    # Incidetn Running Digit
    $IncidentRunDigit 		= 6;
    
    #Incident tops records
    $IncidentgetTops = 10;

    # Set Prefix Incidetn

    # Set Email Admin
    #$Email_admin 			= "Helpdesk_System@Portalnet.co.th";
    // $Email_admin 			= "ptn_support@portalnet.co.th";
	$Email_admin            = "PTN Helpdesk";
    
    #$hosting_id_pea = "http://172.30.241.80/";
    // $hosting_id_pea = "https://services.portalnet.co.th/";
    // $hosting_id_pea = "https://service.swmaxnet.com/";
    $hosting_id_pea = "http://localhost/helpdesk/";
?>