<?php
session_start();
    include_once "include/class/util/strUtil.class.php";
    include_once "include/class/user_session.class.php";
    include_once "include/class/php_header.class.php";
	include_once "include/class/model/helpdesk_security.class.php"; 
    include_once "include/config.inc.php";
    include_once "include/class/db/db.php";
    
    
	include_once "include/class/model/helpdesk_user.class.php"; 
//    include_once "include/config.inc.php";
    
    # request
    //$employee_code = user_session::get_employee_code();
    //$username = $_REQUEST["username"];
    //$password = $_REQUEST["password"];
	
    $h_employee_code = user_session::get_employee_code(); 
    $h_username = strtolower($_REQUEST["username"]); 
    $h_password = $_REQUEST["password"];
    $h_comcode	= $_REQUEST["comcode"];
    $h_pass_expire = $_REQUEST["pass_expire"];
    $h_new_pass = $_REQUEST["new_password"];
	
    /*if (strUtil::isEmpty($employee_code) && strUtil::isEmpty($username)){
        php_header::redirect("index.php");
        exit();
    }*/
	
	//Comment By Seksan 20/06/2559
	/*if (strUtil::isEmpty($h_employee_code) && strUtil::isEmpty($h_username) && strUtil::isEmpty($h_comcode)){
        php_header::redirect("index.php");
        exit();
    }*/
	
	if (strUtil::isEmpty($h_employee_code) && strUtil::isEmpty($h_username)){
        php_header::redirect("index.php");
        exit();
    }

    $db->begin_transaction();
    
    /*
	$sec = new security($db);
    $result = $sec->login($employee_code, $username, $password);*/
    
    $sec = new h_security($db);
    $result = $sec->h_login($h_employee_code, $h_username, $h_password, $h_comcode, $h_pass_expire, $h_new_pass);
    //$result = $sec->login($h_employee_code, $h_username, $h_password, $h_comcode);

	//print_r($result);
	//exit;
	
    $db->end_transaction($result);
	
     switch ($result["error_type"]) {
        case "F":
            $error_type = "F";
            $description = (strUtil::isNotEmpty($username)) ? "User Name" : "Employee Code ";
            $message = "No Username in PTN Helpdesk System!!!";
            $url = "login.php";
            break;

        case "A":
            $error_type = "A";
            $description = "";
            $message = "Employee not active !!!";
            $url = "login.php";
            break;

        case "P":
            $error_type = "P";
            $description = "";
            $message = "Password incorrect !!!";
            $url = "login.php";
            break;

        case "B":
            $error_type = "B";
            $message = "<b>System Recommended :</b> Internet Explorer, Firefox , Safari, Chrome and Opera. Please contact Helpline (Tel 8654).";
            $url = "login.php";
            break;

        default:
            $error_type = "";
            $message = "";
            $url = "home.php";
            break;
    }
	
    
    # user account infomation
    user_session::set_log_id($result["log_id"]);
    user_session::set_sale_id($result["sale_id"]);
    user_session::set_employee_code($result["employee_code"]);
    user_session::set_user_name($result["sale_name"]);
    user_session::set_user_Email($result["user_email"]);
    user_session::set_user_login($result["user_login"]);
    user_session::set_sale_group_id($result["sale_group_id"]);
    user_session::set_sale_group_name($result["sale_group_name"]); 
	     
//    echo $result["user_id"]; 
//    echo "<br>";
//    echo $url;
//    exit();
    user_session::set_user_id($result["user_id"]);  
    user_session::set_user_code($result["user_code"]);   
    user_session::set_user_company_id($result["user_company_id"]); 
    user_session::set_user_company_name($result["user_company_name"]);  
    user_session::set_user_my_orgcode($result["user_my_orgcode"]); 
    user_session::set_user_my_grpcode($result["user_my_grpcode"]); 
	
	user_session::set_cus_company_id($result["cus_company_id"]);
	//echo user_session::get_cus_company_id();
	//exit;
	
    user_session::set_user_org_id($result["user_org_id"]); 
    user_session::set_user_org_name($result["user_org_name"]); 
    user_session::set_user_grp_id($result["user_grp_id"]); 
    user_session::set_user_grp_name($result["user_grp_name"]); 
    user_session::set_user_subgrp_id($result["user_subgrp_id"]); 
    user_session::set_user_subgrp_name($result["user_subgrp_name"]); 
	
    user_session::set_user_admin($result["user_admin"]); 
    user_session::set_user_tra_inc_per($result["user_transfer_incident_permission"]); 
    user_session::set_user_admin_permission($result["user_admin_permission"]);

    user_session::set_edit_rpt_per($result["user_edit_rpt"]);
    user_session::set_appv_rpt_per($result["user_appv_rpt"]);
	user_session::set_advs_per($result["user_advs_per"]);
    
	//echo "XX".user_session::get_advs_per();
	//exit;
	
    user_session::set_user_IncidentRunProject($IncidentRunProject); 
    user_session::set_user_IncidentRunDigit($IncidentRunDigit); 
    user_session::set_user_IncidentPrefix($IncidentPrefix); 

    user_session::set_Email_admin($Email_admin); 
    user_session::set_subgrp_id_spec_arr($result["user_subgrp_id_spec"]); 
    user_session::set_first_name($result["first_name"]);
    user_session::set_last_name($result["last_name"]);
	
	
//    echo "user : " . user_session::get_user_id();
//    exit();
    # close db
    $db->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title><?=$application_name?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="Refresh" content="<?=(strUtil::isNotEmpty($message)) ? "1" : "1"?>; url=<?=$url?>">
        <link type="text/css" rel="stylesheet" href="include/css/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="include/js/jquery/ui/themes/redmond/jquery-ui-1.8.13.custom.css"/>
        <script type="text/javascript" src="include/js/jquery/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="include/js/jquery/ui/jquery-ui-1.8.13.custom.min.js"></script>
    </head>
    <body>
        <center>
            <!--<img src="images/star_logo_500.png" alt="">-->
        <?php
            if (strUtil::isNotEmpty($message)){
        ?>
            <div class="ui-widget" style="width: 70%">
                <div class="ui-state-error ui-corner-all" style="padding: 0 .7em; text-align: left">
                    <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><b><?=$message?></b></p>
                </div>
            </div>
        </center>
        <?php
            }
        ?>
    </body>
</html>