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
        if ($_GET["ses"] == 1){
            list_incident_adv($_SESSION["advance_search"]);
        }else{
            $id = $_GET["id"];
            resultbyID($id);
        }
    }

    function finalize(){
        global $db;
        $db->close();
    }
    
    function resultbyID($id){
         global $incident_list,$db;
         $inc = new incident_list($db);
         $incident_list = $inc->searchbyID($id);
    }
    
    function search_adv(){
        global $incident_list, $txt_ident_id, $txt_summary, $txt_notes,$status_id ;
 
//        echo "summ : ".$_REQUEST["txt_summary"];
//        exit();
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
		
		$owner_user = $_REQUEST["owner"];
                $resolve_user = $_REQUEST["resolve"];
                $limit = $_REQUEST["txtRecords"];
                
                $reference_fr = $_REQUEST["txt_ref"];
                $reference_to = $_REQUEST["l_txt_ref"];
                if ($reference_fr != "" && $reference_to == ""){
                    $reference_to = $reference_fr;
                }
                
               
        
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
			
            , "owner_user_id" => $owner_user
            , "resolve_user" => $resolve_user
            , "limit" => $limit
            , "reference_from" => $reference_fr
            , "reference_to" => $reference_to
			
        );
		
        $incident_list = list_incident_adv($cratiria1);
    }
    
    function list_incident_adv($cratiria1){
        global $incident_list,$db;

        $inc = new incident_list($db);
		
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
			
            , "owner_user_id" => str_replace(" ", "", $cratiria1["owner_user_id"]) 
            , "resolve_user" => str_replace(" ", "", $cratiria1["resolve_user"]) 
            , "limit" => $cratiria1["limit"]
            , "reference_from" => $cratiria1["reference_from"]
            , "reference_to" => $cratiria1["reference_to"]
			
        );
 
                
        $_SESSION["advance_search"] = $cratiria;
                
        $page = strUtil::nvl($_REQUEST["page"], "1");

        $incident_list = $inc->search_advance($cratiria, $page);
        
        //print_r($incident_list);
        return $incident_list;
    }
    
?>
