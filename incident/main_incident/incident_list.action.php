<?php
    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/incident_list.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        $mode = $_GET["mode"];
        search($mode);
    }

    function finalize(){
        global $db;
        $db->close();
    }

    function delete(){
        global $db;

        $activity_id = $_REQUEST["activity_id"];
        if (strUtil::isNotEmpty($activity_id)){
            $activity = new activity($db);
            
            $db->begin_transaction();
            $result = $activity->delete($activity_id);
            $db->end_transaction($result);
        }

        search(1);
    }
    
    function list_incident($mode){ //$start_date, $end_date, $status_id,,$sort,$sort2){
        global $db;
		
        $incident_list = new incident_list($db);
		
//        $cratiria = array(
//            "user_id" => user_session::get_user_id()
//            ,"user_subgrp_id" => user_session::get_user_subgrp_id() 
//            ,"user_subgrp_id_spec" => user_session::get_subgrp_id_spec_arr() 
//            , "start_date" => $start_date
//            , "end_date" => $end_date
//			, "status_id" => $status_id
//			, "status_id" => $status_id
//			, "mode" => $mode
//			, "sort" => $sort
//			, "sort2" => $sort2
//        );
        
        
        $cratiria = array(
            "user_id" => user_session::get_user_id()
            ,"user_subgrp_id" => user_session::get_user_subgrp_id() 
            ,"user_subgrp_id_spec" => user_session::get_subgrp_id_spec_arr() 
//			, "status_id" => $status_id
			, "mode" => $mode
        );
 	
        $page = strUtil::nvl($_REQUEST["page"], "1");

        return $incident_list->search($cratiria, $page);
    }
    
    function search($mode = ""){ //,$sort = "",$sort2 = ""
        global $incident_list, $mode ; //$start_date, $end_date,$status_id,,$sort,$sort2 ;
        
//        echo $mode;        exit();
		
//        $start_date = $_REQUEST["start_date"];
//        $end_date = $_REQUEST["end_date"];
//		$status_id = $_REQUEST["status_id"];
        
//        if (strUtil::isEmpty($start_date) && strUtil::isEmpty($end_date)){
//            list($start_date, $end_date) = dateUtil::getMonthRange(date("Y"), date("m"));
//        } else {
//            $start_date = dateUtil::date_ymd($start_date);
//            $end_date = dateUtil::date_ymd($end_date);
//        }
        
//        $incident_list = list_incident($start_date, $end_date,$status_id,$mode,$sort,$sort2);
        $incident_list = list_incident($mode);
    }
	
    
    function search3(){
        global $incident_list, $txt_ident_id, $txt_summary, $txt_notes,$status_id ;
 
        
        $txt_ident_id = $_REQUEST["txt_ident_id"];
        $txt_summary = $_REQUEST["txt_summary"];
		$txt_notes = $_REQUEST["txt_notes"]; 
		$status_id = $_REQUEST["status_id"]; 
		
        $cus_id = $_REQUEST["cus_id"];
        $cus_firstname = $_REQUEST["cus_firstname"];
		$cus_lastname = $_REQUEST["cus_lastname"]; 
		$cus_phone = $_REQUEST["cus_phone"]; 
		$cus_email = $_REQUEST["cus_email"]; 
		
        $created_date = $_REQUEST["created_date"];
        $assigned_date = $_REQUEST["assigned_date"];
		$working_date = $_REQUEST["working_date"]; 
		$resolved_date = $_REQUEST["resolved_date"]; 
		$closed_date = $_REQUEST["closed_date"]; 
		
        $l_created_date = $_REQUEST["l_created_date"];
        $l_assigned_date = $_REQUEST["l_assigned_date"];
		$l_working_date = $_REQUEST["l_working_date"]; 
		$l_resolved_date = $_REQUEST["l_resolved_date"]; 
		$l_closed_date = $_REQUEST["l_closed_date"]; 
		
		$cas_prd_tier_id1 = $_REQUEST["cas_prd_tier_id1"]; 
		$cas_prd_tier_id2 = $_REQUEST["cas_prd_tier_id2"]; 
		$cas_prd_tier_id3 = $_REQUEST["cas_prd_tier_id3"]; 
		
		$assign_comp_id = $_REQUEST["assign_comp_id"]; 
		$assign_org_id = $_REQUEST["assign_org_id"]; 
		$assign_group_id = $_REQUEST["assign_group_id"]; 
		$assign_subgrp_id = $_REQUEST["assign_subgrp_id"]; 
		$assign_assignee_id = $_REQUEST["assign_assignee_id"]; 
		
		$owner_user_id = $_REQUEST["owner"]; 
        
        $cratiria1 = array(
            "id" => $txt_ident_id
            ,"summary" => $txt_summary
            , "notes" => $txt_notes
            , "status_id" => $status_id
			
            , "cus_id" => $cus_id
            , "cus_firstname" => $cus_firstname
            , "cus_lastname" => $cus_lastname
            , "cus_phone" => $cus_phone
            , "cus_email" => $cus_email
			
            , "create_date" => $created_date
            , "assigned_date" => $assigned_date
            , "working_date" => $working_date
            , "resolved_date" => $resolved_date
            , "closed_date" => $closed_date
			
            , "l_create_date" => $l_created_date
            , "l_assigned_date" => $l_assigned_date
            , "l_working_date" => $l_working_date
            , "l_resolved_date" => $l_resolved_date
            , "l_closed_date" => $l_closed_date
			
            , "cas_prd_tier_id1" => $cas_prd_tier_id1
            , "cas_prd_tier_id2" => $cas_prd_tier_id2
            , "cas_prd_tier_id3" => $cas_prd_tier_id3
			
            , "assign_comp_id_last" => $assign_comp_id 
            , "assign_org_id_last" => $assign_org_id
            , "assign_grp_id_last" => $assign_group_id
            , "assign_subgrp_id_last" => $assign_subgrp_id
            , "assignee_id_last" => $assign_assignee_id
			
            , "owner_user_id" => $owner_user_id
			
        );
		
        $incident_list = list_incident3($cratiria1);
    }
    
    function list_incident3($cratiria1){
        global $db;
		
        $incident_list = new incident_list($db);
		
		$cratiria = array(
            "id" => $cratiria1["id"]
            ,"summary" => $cratiria1["summary"]
            , "notes" => $cratiria1["notes"]
            , "status_id" => $cratiria1["status_id"]
			
            , "cus_id" => $cratiria1["cus_id"]
            , "cus_firstname" => $cratiria1["cus_firstname"]
            , "cus_lastname" => $cratiria1["cus_lastname"]
            , "cus_phone" => $cratiria1["cus_phone"]
            , "cus_email" => $cratiria1["cus_email"]
			
            , "create_date" => $cratiria1["create_date"]
            , "assigned_date" => $cratiria1["assigned_date"]
            , "working_date" => $cratiria1["working_date"]
            , "resolved_date" => $cratiria1["resolved_date"]
            , "closed_date" => $cratiria1["closed_date"]
			
            , "l_create_date" => $cratiria1["l_create_date"]
            , "l_assigned_date" => $cratiria1["l_assigned_date"]
            , "l_working_date" => $cratiria1["l_working_date"]
            , "l_resolved_date" => $cratiria1["l_resolved_date"]
            , "l_closed_date" => $cratiria1["l_closed_date"]
			
            , "cas_prd_tier_id1" => $cratiria1["cas_prd_tier_id1"]
            , "cas_prd_tier_id2" => $cratiria1["cas_prd_tier_id2"]
            , "cas_prd_tier_id3" => $cratiria1["cas_prd_tier_id3"]
			
            , "assign_comp_id_last" => $cratiria1["assign_comp_id_last"]
            , "assign_org_id_last" => $cratiria1["assign_org_id_last"]
            , "assign_grp_id_last" => $cratiria1["assign_grp_id_last"]
            , "assign_subgrp_id_last" => $cratiria1["assign_subgrp_id_last"]
            , "assignee_id_last" => $cratiria1["assignee_id_last"]
			
            , "owner_user_id" => $cratiria1["owner_user_id"]
			
        );
 
        $page = strUtil::nvl($_REQUEST["page"], "1");

        return $incident_list->search_advance($cratiria, $page);
    }
?>
