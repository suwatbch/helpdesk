<?php

    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/incident.class.php";
    include_once "../../include/class/model/status.class.php";
    include_once "../../include/class/model/status_res.class.php";
//    include_once "../../include/class/model/impact.class.php"; 
    include_once "../../include/class/model/priority.class.php"; 
    include_once "../../include/class/model/urgency.class.php";  
    include_once "../../include/class/model/incident_type.class.php"; 
    include_once "../../include/class/model/helpdesk_project.class.php"; 
    include_once "../../include/class/model/opr_tier1.class.php";  
    include_once "../../include/class/model/opr_tier2.class.php"; 
    include_once "../../include/class/model/opr_tier3.class.php";
    include_once "../../include/class/model/prd_tier1.class.php";  
    include_once "../../include/class/model/prd_tier2.class.php";   
    include_once "../../include/class/model/prd_tier3.class.php";  
    include_once "../../include/class/model/opr_tier1_resol.class.php"; 
    include_once "../../include/class/model/opr_tier2_resol.class.php";  
    include_once "../../include/class/model/opr_tier3_resol.class.php";  
    include_once "../../include/class/model/prd_tier1_resol.class.php"; 
    include_once "../../include/class/model/prd_tier2_resol.class.php";  
    include_once "../../include/class/model/prd_tier3_resol.class.php"; 
    include_once "../../include/class/model/helpdesk_workinfo.class.php"; 
    include_once "../../include/class/model/helpdesk_company.class.php"; 
    include_once "../../include/class/model/helpdesk_org.class.php"; 
    include_once "../../include/class/model/helpdesk_grp.class.php"; 
    include_once "../../include/class/model/helpdesk_subgrp.class.php"; 
    include_once "../../include/class/model/helpdesk_user.class.php"; 
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $incident;
		
		$incident_id = $_REQUEST["txt_id"];
        if (strUtil::isNotEmpty($incident_id)){
            $p = new incident($db);
            $incident = $p->getByIncidentID($incident_id);
        }
    }
	
	
	function display() {
        global $db, $incident;
		
		$incident_id = $_REQUEST["incident_id"];
        if (strUtil::isNotEmpty($incident_id)){
            $p = new incident($db);
            $incident = $p->getByIncidentID($incident_id);
			
        }
    }

    function finalize(){
        global $db, $incident,$asm, $wif, $dd_status,$dd_Status_res,$dd_impact,$dd_priority,$dd_urgency
				,$dd_incident_type,$dd_project,$dd_opr_tier1,$dd_opr_tier2,$dd_opr_tier3
				,$dd_prd_tier1,$dd_prd_tier2,$dd_prd_tier3
				,$dd_company,$dd_org,$dd_grp,$dd_subgrp,$dd_assign_assignee
				,$dd_opr_tier1_resol,$dd_opr_tier2_resol,$dd_opr_tier3_resol
				,$dd_prd_tier1_resol,$dd_prd_tier2_resol,$dd_prd_tier3_resol
				,$dd_workinfotype,$tabShoworhide,$dd_required
				,$dd_required_assig,$dd_required_work,$dd_required_resol;
		
		
		#Cassification Tab ==============================
		$dd_opr_tier1 = dropdown::loadOpr_tier1($db, "cas_opr_tier_id1", "required=\"true\" name=\"cas_opr_tier_id1\" style=\"width: 100%;\"", $incident["cas_opr_tier_id1"]);
		//$dd_opr_tier2 = dropdown::loadOpr_tier2($db, "cas_opr_tier_id2", "required=\"true\" name=\"cas_opr_tier_id2\" style=\"width: 200px;\"", $incident["cas_opr_tier_id2"]);
        if (strUtil::isNotEmpty($incident["cas_opr_tier_id1"])){
        	$dd_opr_tier2 = dropdown::loadOpr_tier2($db, "cas_opr_tier_id2", "required=\"true\" name=\"cas_opr_tier_id2\" style=\"width: 100%;\"", $incident["cas_opr_tier_id2"], $incident["cas_opr_tier_id1"]);
        } else {
            $dd_opr_tier2 = dropdown::select("cas_opr_tier_id2", "required=\"true\"<option></option>", "style=\"width: 100%\"");
        }
		//$dd_opr_tier3 = dropdown::loadOpr_tier3($db, "cas_opr_tier_id3", "name=\"cas_opr_tier_id3\" style=\"width: 200px;\"", $incident["cas_opr_tier_id3"]);
		if (strUtil::isNotEmpty($incident["cas_opr_tier_id1"]) && strUtil::isNotEmpty($incident["cas_opr_tier_id2"])){
        	$dd_opr_tier3 = dropdown::loadOpr_tier3($db, "cas_opr_tier_id3", "name=\"cas_opr_tier_id3\" style=\"width: 100%;\"", $incident["cas_opr_tier_id3"], $incident["cas_opr_tier_id1"], $incident["cas_opr_tier_id2"]);
        } else {
            $dd_opr_tier3 = dropdown::select("cas_opr_tier_id3", "<option></option>", "style=\"width: 100%\"");
        }
		
		$dd_prd_tier1 = dropdown::loadPrd_tier1($db, "cas_prd_tier_id1", " name=\"cas_prd_tier_id1\" style=\"width: 100%;\"", $incident["cas_prd_tier_id1"]);
		//$dd_prd_tier2 = dropdown::loadPrd_tier2($db, "cas_prd_tier_id2", "required=\"true\" name=\"cas_prd_tier_id2\" style=\"width: 200px;\"", $incident["cas_prd_tier_id2"]);
        if (strUtil::isNotEmpty($incident["cas_prd_tier_id1"])){
        	$dd_prd_tier2 = dropdown::loadPrd_tier2($db, "cas_prd_tier_id2", " name=\"cas_prd_tier_id2\" style=\"width: 100%;\"", $incident["cas_prd_tier_id2"], $incident["cas_prd_tier_id1"]);
        } else {
            $dd_prd_tier2 = dropdown::select("cas_prd_tier_id2", "<option></option>", "style=\"width: 100%\"");
        }
		//$dd_prd_tier3 = dropdown::loadPrd_tier3($db, "cas_prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 200px;\"", $incident["cas_prd_tier_id3"]);
		if (strUtil::isNotEmpty($incident["cas_prd_tier_id1"]) && strUtil::isNotEmpty($incident["cas_prd_tier_id2"])){
        	$dd_prd_tier3 = dropdown::loadPrd_tier3($db, "cas_prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"", $incident["cas_prd_tier_id3"], $incident["cas_prd_tier_id1"], $incident["cas_prd_tier_id2"]);
        } else {
            $dd_prd_tier3 = dropdown::select("cas_prd_tier_id3", "<option></option>", "style=\"width: 100%\"");
        }
		
		
		

		#Assignment Tab ========================================
		//$dd_company = dropdown::loadCompany($db, "assign_comp_id", "required=\"true\" name=\"assign_comp_id\" style=\"width: 200px;\"", $incident["assign_comp_id"]);
		//if(strUtil::isNotEmpty(user_session::get_cus_company_id())){
		//	$dd_company = dropdown::loadCompany($db, "assign_comp_id","$dd_required_assig\ $dd_disable1\" name=\"assign_comp_id\" description=\"Tab Assignment: Company\" style=\"width: 100%;\"", user_session::get_user_company_id());
		//}else{
			$dd_company = dropdown::loadCompany($db, "assign_comp_id","$dd_required_assig\ $dd_disable1\" name=\"assign_comp_id\" description=\"Tab Assignment: Company\" style=\"width: 100%;\"", user_session::get_user_company_id());
		//}
		
		
		
		//$dd_org = dropdown::loadOrg($db, "assign_org_id", "$dd_required_assig\" name=\"assign_org_id\" description=\"Tab Assignment: Organize\" style=\"width: 200px;\"", $asm["assign_org_id"]);
		if (strUtil::isNotEmpty($asm["assign_comp_id"])){
        	$dd_org = dropdown::loadOrg($db, "assign_comp_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_org_id\" description=\"Tab Assignment: Organize\" style=\"width: 100%;\"", $asm["assign_org_id"], $asm["assign_comp_id"]);
        } else {
            $dd_org = dropdown::select("assign_org_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%\"");
        }
		
		//$dd_grp = dropdown::loadGrp($db, "assign_group_id", "$dd_required_assig\" name=\"assign_group_id\" description=\"Tab Assignment: Group\" style=\"width: 200px;\"", $asm["assign_group_id"]);
		if (strUtil::isNotEmpty($asm["assign_org_id"])){
        	$dd_grp = dropdown::loadGrp($db, "assign_group_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_group_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $asm["assign_group_id"], $asm["assign_comp_id"], $asm["assign_org_id"]);
        } else {
            $dd_grp = dropdown::select("assign_group_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%\"");
        }
		//$dd_subgrp = dropdown::loadSubGrp($db, "assign_subgrp_id", "$dd_required_assig\" name=\"assign_subgrp_id\" description=\"Tab Assignment: Sub Group\" style=\"width: 100%;\"", $asm["assign_subgrp_id"]);
		if (strUtil::isNotEmpty($asm["assign_group_id"])){
        	$dd_subgrp = dropdown::loadSubGrp($db, "assign_subgrp_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_subgrp_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $asm["assign_subgrp_id"], $asm["assign_comp_id"], $asm["assign_group_id"]);
        } else {
            $dd_subgrp = dropdown::select("assign_subgrp_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%\"");
        }
		//$dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id", "$dd_required_assig\" name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 200px;\"", $asm["assign_assignee_id"]);
		if (strUtil::isNotEmpty($asm["assign_subgrp_id"])){
        	$dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id",  " name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 100%;\"", $asm["assign_assignee_id"], $asm["assign_comp_id"], $asm["assign_subgrp_id"]);
        } else {
            $dd_assign_assignee = dropdown::select("assign_assignee_id", "<option></option>", "style=\"width: 100%\"");
        }

		$db->close();
    }

// function save(){
//		
//        global $db, $incident ,$assignment;
//		
//		//echo "<br>2-status".$_REQUEST["status_id"];
//        # get input  txt_ident_id
//		//echo $_REQUEST["incident_id"."55".$_REQUEST["assigned_date"]] ; //exit;
//		//echo $_REQUEST["file_0"];		 exit;
//		//echo $_REQUEST["ddassign_comp_id"]; //exit;
//        $incident = array(
//            "id" => $_REQUEST["incident_id"]
//            , "ident_id" => $_REQUEST["txt_ident_id"]
//            , "summary" => $_REQUEST["txt_summary"]
//            , "notes" => $_REQUEST["txt_notes"]
//            , "status_id" => $_REQUEST["status_id"]
//            , "status_res_id" => $_REQUEST["status_res_id"]
//            , "impact_id" => $_REQUEST["impact_id"]
//            , "urgency_id" => $_REQUEST["urgency_id"]
//            , "priority_id" => $_REQUEST["priority_id"] 
//            , "assigned_date" => $_REQUEST["assigned_date"] 
//			
//            , "ddpriority_id" => $_REQUEST["ddpriority_id"]
//			#Customer Tab
//            , "cus_id" => $_REQUEST["cus_id"]
//            , "cus_firstname" => $_REQUEST["cus_firstname"]
//            , "cus_lastname" => $_REQUEST["cus_lastname"]
//            , "cus_phone" => $_REQUEST["cus_phone"]
//            , "cus_ipaddress" => $_REQUEST["cus_ipaddress"]
//            , "cus_email" => $_REQUEST["cus_email"]
//            , "cus_company" => $_REQUEST["cus_company"]
//            , "cus_organize" => $_REQUEST["cus_organize"]
//            , "cus_area" => $_REQUEST["cus_area"]
//            , "cus_office" => $_REQUEST["cus_office"]
//            , "cus_department" => $_REQUEST["cus_department"]
//            , "cus_site" => $_REQUEST["cus_site"]
//            , "keyuser_name" => $_REQUEST["keyuser_name"]
//			#Contact Tab
//            , "con_firstname" => $_REQUEST["con_firstname"]
//            , "con_lastname" => $_REQUEST["con_lastname"]
//            , "con_phone" => $_REQUEST["con_phone"]
//            , "con_ipaddr" => $_REQUEST["con_ipaddr"]
//            , "con_email" => $_REQUEST["con_email"]
//            , "con_place" => $_REQUEST["con_place"]
//			#Cassification Tab
//            , "ident_type_id" => $_REQUEST["ident_type_id"]
//            , "project_id" => $_REQUEST["project_id"]
//            , "cas_opr_tier_id1" => $_REQUEST["cas_opr_tier_id1"]
//            , "cas_opr_tier_id2" => $_REQUEST["cas_opr_tier_id2"]
//            , "cas_opr_tier_id3" => $_REQUEST["cas_opr_tier_id3"]
//            , "cas_prd_tier_id1" => $_REQUEST["cas_prd_tier_id1"]
//            , "cas_prd_tier_id2" => $_REQUEST["cas_prd_tier_id2"]
//            , "cas_prd_tier_id3" => $_REQUEST["cas_prd_tier_id3"]
//			#Assignment Tab
//            //, "assign_comp_id" => $_REQUEST["assign_comp_id"]
//            //, "assign_org_id" => $_REQUEST["assign_org_id"]
//            //, "assign_group_id" => $_REQUEST["assign_group_id"]
//            //, "assign_subgrp_id" => $_REQUEST["assign_subgrp_id"]  
//            , "assign_assignee_id" => $_REQUEST["assign_assignee_id"] 
//			
//            , "assign_comp_id" => $_REQUEST["ddassign_comp_id"]
//            , "assign_org_id" => $_REQUEST["ddassign_org_id"] 
//            , "assign_group_id" => $_REQUEST["ddassign_group_id"] 
//            , "assign_subgrp_id" => $_REQUEST["ddassign_subgrp_id"]   
//			
//            , "owner_comp_id" => $_REQUEST["h_owner_comp_id"]
//            , "owner_org_id" => $_REQUEST["h_owner_org_id"] 
//            , "owner_grp_id" => $_REQUEST["h_owner_grp_id"] 
//            , "owner_subgrp_id" => $_REQUEST["h_owner_subgrp_id"]  
//            , "owner_user_id" => $_REQUEST["h_owner_user_id"]       
//			
//			#Work Info Tab
//            , "workinfo_type_id" => $_REQUEST["workinfo_type_id"]
//            , "workinfo_summary" => $_REQUEST["workinfo_summary"]
//            , "workinfo_notes" => $_REQUEST["workinfo_notes"]
//			#Resolution Tab 
//			, "resolution" => $_REQUEST["resolution"]
//            , "satisfac_id" => $_REQUEST["satisfac_id"]
//            , "resol_oprtier1" => $_REQUEST["resol_oprtier1"]
//            , "resol_oprtier2" => $_REQUEST["resol_oprtier2"]
//            , "resol_oprtier3" => $_REQUEST["resol_oprtier3"]
//            , "resol_prdtier1" => $_REQUEST["resol_prdtier1"]
//            , "resol_prdtier2" => $_REQUEST["resol_prdtier2"]
//            , "resol_prdtier3" => $_REQUEST["resol_prdtier3"]
//			#Date/System Tab
//            //, "action_date" => dateUtil::current_date_time()
//            //, "create_date" => dateUtil::current_date_time()
//            //, "owner_date" => dateUtil::current_date_time()
//            //, "last_modify_date" => dateUtil::current_date_time()
//        );
//		
//		//echo "1-".$_REQUEST["assign_org_id"]; 
//		//echo $incident["assign_org_id"]; //exit();
//		
//		
//        # validate
//        if (validate($incident)){
//            # save
//            $db->begin_transaction();
//
//            $p = new incident($db);
//			
//            if (strUtil::isEmpty($incident["id"])){
//                $result = $p->insert($incident);
//            } else {
//                $result = $p->update($incident);
//            }
//
//            $db->end_transaction($result);
//
//            if ($result){
//                $incident = $p->getByIncidentID($incident["id"]);
//                //alert_message(MESSAGE_SAVE_COMPLETE, "window.location = \'index.php?incident_list.php\'");
//                alert_message(MESSAGE_SAVE_COMPLETE, "page_submit(\'index.php?action=incident.php\' , \'display\')");
//            }
//        }
//    }

?>
