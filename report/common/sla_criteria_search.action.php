<?php

    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php"; 
    include_once "../../include/class/model/helpdesk_workinfo.class.php"; 
    include_once "../../include/class/model/helpdesk_company.class.php"; 
    include_once "../../include/class/model/helpdesk_org.class.php"; 
    include_once "../../include/class/model/helpdesk_grp.class.php"; 
    include_once "../../include/class/model/helpdesk_subgrp.class.php"; 
    include_once "../../include/class/model/helpdesk_user.class.php";
    include_once "../../include/class/model/priority.class.php"; 
     include_once "../../include/class/model/prd_tier3.class.php"; 
     include_once "../../include/class/model/status.class.php";
     include_once "../../include/class/model/report.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";
    
     function unspecified() {

		
		
    }
    
    
 function finalize(){
        global $db, $dd_company,$dd_required_assig,$dd_disable1,$dd_status,$dd_status_l,
                $dd_cus_zone,$dd_cus_zone_l,$dd_incident_type,$dd_incident_type_l,$dd_date_monthly,$dd_priority,$dd_priority_l,
                $dd_project ,$dd_prd_tier1,$dd_prd_tier2,$dd_prd_tier3,$dd_grp_rsp, $dd_subgrp_rsp,$dd_grp_rsv,$dd_subgrp_rsv  ;
		
	$dd_company = dropdown::loadCusCompany($db, "cus_company_id","$dd_required_assig\ $dd_disable1\" required name=\"cus_company_id\" description=\"Customer Company\" style=\"width: 100%;\"", "");
//	($db, "prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"","", "", "", "",$order = "")
        
        $dd_status = dropdown::loadStatus($db, "status_id", "name=\"status_id\" style=\"width: 100%;\"");
        $dd_status_l = dropdown::loadStatus($db, "status_id_l", "name=\"status_id_l\" style=\"width: 100%;\"");
        
        $dd_priority = dropdown::loadPriority($db, "priority_id", "name=\"priority_id\" style=\"width: 100%;\" ");
        $dd_priority_l = dropdown::loadPriority($db, "priority_id_l", "name=\"priority_id\" style=\"width: 100%;\" ");

        $dd_cus_zone = dropdown::select("customer_zone_id", "<option></option>", "style=\"width: 100%\"");//dropdown::loadCusZone($db, "customer_zone_id", "", "", "");
        $dd_cus_zone_l = dropdown::select("customer_zone_id_l", "<option></option>", "style=\"width: 100%\"");//dropdown::loadCusZone($db, "customer_zone_id_l", "", "", "");
        
        $dd_incident_type = dropdown::select("ident_type_id", "<option></option>", "style=\"width: 100%\"");
        $dd_incident_type_l = dropdown::select("ident_type_id_l", "<option></option>", "style=\"width: 100%\"");
        
        $dd_date_monthly = dropdown::select("date_monthly", "<option></option>", "style=\"width: 100%\"");
        
        
        $dd_project = dropdown::select("project_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");        
        $dd_prd_tier1 = dropdown::select("prd_tier_id1", "<option></option>", "style=\"width: 100%;\"");
        $dd_prd_tier2 = dropdown::select("prd_tier_id2", "<option></option>", "style=\"width: 100%;\"");
        $dd_prd_tier3 = dropdown::select("prd_tier_id3", "<option></option>", "style=\"width: 100%;\"");
        $dd_grp_rsp = dropdown::loadGrp_master($db,"rsp_group_id",  "style=\"width: 100%;\"","",  user_session::get_user_company_id());
        $dd_subgrp_rsp = dropdown::select("rsp_subgrp_id", "<option></option>", "style=\"width: 100%;\"");
        
        $dd_grp_rsv = dropdown::loadGrp_master($db,"rsv_group_id",  "style=\"width: 100%;\"","",  user_session::get_user_company_id());
        $dd_subgrp_rsv = dropdown::select("rsv_subgrp_id", "<option></option>", "style=\"width: 100%;\"");
        
        $db->close();
    }
    
    
?>
