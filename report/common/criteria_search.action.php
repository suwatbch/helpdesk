<?php

    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php"; 
    include_once "../../include/class/model/helpdesk_workinfo.class.php";
    include_once "../../include/class/model/helpdesk_project.class.php"; 
    include_once "../../include/class/model/helpdesk_company.class.php"; 
    include_once "../../include/class/model/helpdesk_org.class.php"; 
    include_once "../../include/class/model/helpdesk_grp.class.php"; 
    include_once "../../include/class/model/helpdesk_subgrp.class.php"; 
    include_once "../../include/class/model/helpdesk_user.class.php"; 
    include_once "../../include/class/model/prd_tier3.class.php"; 
    include_once "../../include/class/model/status.class.php";
    include_once "../../include/class/model/report.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";
    
	//echo user_session::get_user_company_id();
	
     function unspecified() {
//        global $db, $incident;
		
		
    }
    
  

 function finalize(){
        global $db, $dd_company,$dd_required_assig,$dd_disable1,$asm,$dd_prd_tier3,$dd_prd_tier3_l,$dd_status,$dd_status_l,$dd_cus_zone,$dd_cus_zone_l,$dd_incident_type,$dd_incident_type_l,$dd_date_monthly,$dd_project ;
		
		if (strUtil::isNotEmpty(user_session::get_cus_company_id())){
			$dd_disable1 = "disable";
			$dd_company = dropdown::loadCusCompany($db, "cus_company_id","$dd_required_assig\ $dd_disable1\" disabled  required name=\"cus_company_id\" description=\"Customer Company\" style=\"width: 100%;\"",user_session::get_cus_company_id());
		}else{
			$dd_company = dropdown::loadCusCompany($db, "cus_company_id","$dd_required_assig\ $dd_disable1\" required name=\"cus_company_id\" description=\"Customer Company\" style=\"width: 100%;\"", "");
		}
		
//	($db, "prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"","", "", "", "",$order = "")
        $dd_prd_tier3 = dropdown::select("prd_tier_id3", "<option></option>", "style=\"width: 100%\"");//dropdown::loadPrd_tier3_report($db, "prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"");
        $dd_prd_tier3_l = dropdown::select("prd_tier_id3_l", "<option></option>", "style=\"width: 100%\"");
        
        $dd_status = dropdown::loadStatus($db, "status_id", "name=\"status_id\" style=\"width: 100%;\"");
        $dd_status_l = dropdown::loadStatus($db, "status_id_l", "name=\"status_id_l\" style=\"width: 100%;\"");
        
        $dd_cus_zone = dropdown::select("customer_zone_id", "<option></option>", "style=\"width: 100%\"");//dropdown::loadCusZone($db, "customer_zone_id", "", "", "");
        $dd_cus_zone_l = dropdown::select("customer_zone_id_l", "<option></option>", "style=\"width: 100%\"");//dropdown::loadCusZone($db, "customer_zone_id_l", "", "", "");
        
        $dd_incident_type = dropdown::select("ident_type_id", "<option></option>", "style=\"width: 100%\"");
        $dd_incident_type_l = dropdown::select("ident_type_id_l", "<option></option>", "style=\"width: 100%\"");
        
        //$dd_date_monthly = dropdown::select("date_monthly", "<option></option>", "style=\"width: 100%\"");

		if (strUtil::isNotEmpty(user_session::get_cus_company_id()) ){
			$dd_date_monthly = dropdown::loadDateMonthly($db, "date_monthly", user_session::get_cus_company_id(), "name=\"date_monthly\" style=\"width: 100%;\"","");
		}else{
			$dd_date_monthly = dropdown::select("date_monthly", "<option></option>", "style=\"width: 100%\"");
		}
	

        $dd_project = dropdown::select("project_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");  
       
       //echo user_session::get_user_id();
       //echo user_session::get_employee_code();

       if (strUtil::isNotEmpty(user_session::get_cus_company_id())){
		//$dd_project = dropdown::loadProjectPerson($db, "project_id", "required=\"true\" name=\"project_id\" style=\"width: 100%;\"", "",user_session::get_user_code());
		// $dd_project = dropdown::loadProjectPerson($db, "project_id", "required=\"true\" name=\"project_id\" style=\"width: 100%;\"", "",user_session::get_employee_code());
        	$dd_project = dropdown::loadProjectPerson($db, "project_id", "name=\"project_id\"", "",user_session::get_employee_code());
        } else {
                $dd_project = dropdown::select("project_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
        
        $db->close();
    }
    
    
?>
