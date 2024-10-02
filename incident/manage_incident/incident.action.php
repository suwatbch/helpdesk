<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/incident.class.php";
    include_once "../../include/class/model/status.class.php";
    include_once "../../include/class/model/status_res.class.php";
    include_once "../../include/class/model/impact.class.php"; 
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

    //global $incidenttmp;
    $test = "";

    function unspecified() {
        global $db, $incident,$test, $mode ,$s_mode, $asm ,$tmpStatusIdBefore,$tmpPriorityIdBefore;
        
        $incident_id = $_REQUEST["txt_id"];
        $km_id = $_REQUEST["km_id"];
                
        if(strUtil::isNotEmpty($_REQUEST["incident_id"])){
            $incident_id = $_REQUEST["incident_id"];  
        }
		
		if(strUtil::isNotEmpty($_SESSION["incident_id"])){
				//$incident_id = $_SESSION["incident_id"];
		}

        //$incident_id = 39;
        if (strUtil::isNotEmpty($incident_id)){
            $p = new incident($db);
            $incident = $p->getByIncidentID($incident_id);
            $tmpPriorityIdBefore = $incident["priority_id"];
            $tmpStatusIdBefore = $incident["status_id"];
        }
        //////////////////km ref/////////////////////////////
        if(strUtil::isNotEmpty($km_id)){
            $p = new incident($db);
            $incident = $p->getByKmID($km_id);
            $asm["assign_comp_id"] = user_session::get_user_company_id();
            $asm["assign_org_id"] = user_session::get_user_org_id();
            $asm["assign_group_id"] = user_session::get_user_grp_id();
            $asm["assign_subgrp_id"] = user_session::get_user_subgrp_id();
            $asm["assign_assignee_id"] = user_session::get_user_id();  
            $incident["con_firstname"] = $_REQUEST["con_firstname"];
            $incident["con_lastname"] = $_REQUEST["con_lastname"];
            $incident["con_phone"] = $_REQUEST["con_phone"];
            $incident["con_ipaddr"] = $_REQUEST["con_ipaddr"];
            $incident["con_email"] = $_REQUEST["con_email"];
            $incident["con_place"] = $_REQUEST["con_place"];
        }
        
		if($incident["status_id"]==1)
		{
			$asm["assign_comp_id"] = user_session::get_user_company_id();
            $asm["assign_org_id"] = user_session::get_user_org_id();
            $asm["assign_group_id"] = user_session::get_user_grp_id();
            $asm["assign_subgrp_id"] = user_session::get_user_subgrp_id();
            $asm["assign_assignee_id"] = user_session::get_user_id(); 
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
				,$dd_required_assig,$dd_required_work,$dd_required_resol,$ex_opr_class3,$ex_cas_opr_class3;
		
        //$cn = new status($db);
		#Header ========================================
        //$dd_status = dropdown::loadStatus($db, "status_id", "required=\"true\" name=\"Status\" style=\"width: 100%;\"", $incident["status_id"]);
        $dd_disable1 = $incident["per_ddAssign1"];
		$dd_disable2 = $incident["per_ddAssign2"];
		
		if (strUtil::isEmpty($incident["status_id"]) || $incident["status_id"] == 1){
			$dd_status = dropdown::loadStatus($db, "status_id", "required=\"true\" $dd_disable1\" name=\"Status\" style=\"width: 100%;\"", $incident["status_id"]);
        } else if(strUtil::isNotEmpty($incident["status_id"]) && $incident[s_km_id]== "") {
			$dd_status = dropdown::loadStatus2($db, "status_id", "required=\"true\" $dd_disable1\" name=\"Status\" style=\"width: 100%;\"", $incident["status_id"]);
		}else if(strUtil::isNotEmpty($incident["status_id"]) && $incident[s_km_id]!= "") {
			$dd_status = dropdown::loadStatus3($db, "status_id", "required=\"true\" $dd_disable1\" name=\"Status\" style=\"width: 100%;\"", $incident["status_id"]);
		}
		//$dd_Status_res = dropdown::loadStatus_res($db, "status_res_id", "name=\"Status_res\" style=\"width: 100%;\"", $incident["status_res_id"]);
        if (strUtil::isNotEmpty($incident["status_id"])){
        	$dd_Status_res = dropdown::loadStatus_res($db, "status_res_id", " name=\"Status_res\" style=\"width: 100%;\"", $incident["status_res_id"], $incident["status_id"]);
        } else {
            $dd_Status_res = dropdown::select("status_res_id", "<option></option>", "style=\"width: 100%;\"");
        }
        $dd_impact = dropdown::loadImpact($db, "impact_id", "required=\"true\" name=\"Impact\" style=\"width: 100%;\"", $incident["impact_id"]);
		$dd_urgency = dropdown::loadUrgency($db, "urgency_id", "required=\"true\" name=\"urgency_desc\" style=\"width: 100%;\"", $incident["urgency_id"]);
		$dd_priority = dropdown::loadPriority($db, "priority_id", "required=\"true\" name=\"priority_id\" style=\"width: 100%;\" ", $incident["priority_id"]);
//        if (strUtil::isNotEmpty($incident["impact_id"]) && strUtil::isNotEmpty($incident["urgency_id"])){
//        	$dd_priority = dropdown::loadPriority($db, "priority_id", "required=\"true\" name=\"priority_id\" style=\"width: 100%;\" class=\"select_dis\" disabled", $incident["priority_id"], $incident["impact_id"], $incident["urgency_id"]);
//        } else {
//            $dd_priority = dropdown::select("priority_id", "<option></option>", "style=\"width: 100%;\"  class=\"select_dis\" disabled");
//        }
		
		
		#Cassification Tab ==============================
		//$dd_incident_type = dropdown::loadIncident_type($db, "ident_type_id", "required=\"true\" name=\"ident_type_id\" style=\"width: 100%;\"", $incident["ident_type_id"]);
		if (strUtil::isNotEmpty($incident["cus_company_id"])){
			$dd_incident_type = dropdown::loadIncident_type($db, "ident_type_id", "required=\"true\" name=\"ident_type_id\" style=\"width: 100%;\"", $incident["ident_type_id"],  $incident["cus_company_id"]);
        } else {
            $dd_incident_type = dropdown::select("ident_type_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		
		//$dd_project = dropdown::loadProject($db, "project_id", "required=\"true\" name=\"project_id\" style=\"width: 100%;\"", $incident["project_id"]);	
        ///if (strUtil::isNotEmpty($incident["cus_company_id"])){
		///	$dd_project = dropdown::loadProject($db, "project_id", "required=\"true\" name=\"project_id\" style=\"width: 100%;\"", $incident["project_id"],  $incident["cus_company_id"]);
        ///} else {
        ///    $dd_project = dropdown::select("project_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        ///}
		//echo  $incident["project_id"];
		
		//echo '<script type="text/javascript">
        //            alert("'.$incident["cus_id"].'");
        //      </script>';	
		//$incident["cus_id"] = '10';
		
		if (strUtil::isNotEmpty($incident["cus_company_id"])){
			$dd_project = dropdown::loadProjectPerson($db, "project_id", "required=\"true\" name=\"project_id\" style=\"width: 100%;\"", $incident["project_id"],$incident["cus_id"]);
        } else {
            $dd_project = dropdown::select("project_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }


		//$dd_opr_tier1 = dropdown::loadOpr_tier1($db, "cas_opr_tier_id1", "required=\"true\" name=\"cas_opr_tier_id1\" style=\"width: 100%;\"", $incident["cas_opr_tier_id1"]);
		if (strUtil::isNotEmpty($incident["cus_company_id"])){
						//echo " cus_company ไม่ว่าง";
			$dd_opr_tier1 = dropdown::loadOpr_tier1($db, "cas_opr_tier_id1", "required=\"true\" name=\"cas_opr_tier_id1\" style=\"width: 100%;\"", $incident["cas_opr_tier_id1"],  $incident["cus_company_id"]);
        } else {
            			//echo " cus_company ว่าง";
			$dd_opr_tier1 = dropdown::select("cas_opr_tier_id1", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_opr_tier2 = dropdown::loadOpr_tier2($db, "cas_opr_tier_id2", "required=\"true\" name=\"cas_opr_tier_id2\" style=\"width: 100%;\"", $incident["cas_opr_tier_id2"]);
        if (strUtil::isNotEmpty($incident["cas_opr_tier_id1"]) && strUtil::isNotEmpty($incident["cus_company_id"])){
			$dd_opr_tier2 = dropdown::loadOpr_tier2($db, "cas_opr_tier_id2", "required=\"true\" name=\"cas_opr_tier_id2\" style=\"width: 100%;\"", $incident["cas_opr_tier_id2"], $incident["cas_opr_tier_id1"],$incident["cus_company_id"]);
        } else {
			$dd_opr_tier2 = dropdown::select("cas_opr_tier_id2", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_opr_tier3 = dropdown::loadOpr_tier3($db, "cas_opr_tier_id3", "name=\"cas_opr_tier_id3\" style=\"width: 100%;\"", $incident["cas_opr_tier_id3"]);
		if (strUtil::isNotEmpty($incident["cas_opr_tier_id1"]) && strUtil::isNotEmpty($incident["cas_opr_tier_id2"]) && strUtil::isNotEmpty($incident["cus_company_id"])){
//                    $ex_cas_opr_class3 = new Opr_tier3($db);
//                    $ex_cas_opr_class3 = $ex_cas_opr_class3->countCombo($incident["cas_opr_tier_id1"],$incident["cas_opr_tier_id2"],$incident["cus_company_id"]);
                    
                    
                    $dd_opr_tier3 = dropdown::loadOpr_tier3($db, "cas_opr_tier_id3", "name=\"cas_opr_tier_id3\" style=\"width: 100%;\"", $incident["cas_opr_tier_id3"], $incident["cas_opr_tier_id1"], $incident["cas_opr_tier_id2"],$incident["cus_company_id"]);
        } else {
            $dd_opr_tier3 = dropdown::select("cas_opr_tier_id3", "<option></option>", "style=\"width: 100%;\"");
//            $ex_cas_opr_class3 = "0";
        }
		
		//$dd_prd_tier1 = dropdown::loadPrd_tier1($db, "cas_prd_tier_id1", "required=\"true\" name=\"cas_prd_tier_id1\" style=\"width: 100%;\"", $incident["cas_prd_tier_id1"]);
		if (strUtil::isNotEmpty($incident["cus_company_id"])){
			$dd_prd_tier1 = dropdown::loadPrd_tier1($db, "cas_prd_tier_id1", "required=\"true\" name=\"cas_prd_tier_id1\" style=\"width: 100%;\"", $incident["cas_prd_tier_id1"], $incident["cus_company_id"]);
        } else {
            $dd_prd_tier1 = dropdown::select("cas_prd_tier_id1", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_prd_tier2 = dropdown::loadPrd_tier2($db, "cas_prd_tier_id2", "required=\"true\" name=\"cas_prd_tier_id2\" style=\"width: 100%;\"", $incident["cas_prd_tier_id2"]);
        if (strUtil::isNotEmpty($incident["cas_prd_tier_id1"]) && strUtil::isNotEmpty($incident["cus_company_id"])){
        	$dd_prd_tier2 = dropdown::loadPrd_tier2($db, "cas_prd_tier_id2", "required=\"true\" name=\"cas_prd_tier_id2\" style=\"width: 100%;\"", $incident["cas_prd_tier_id2"], $incident["cas_prd_tier_id1"], $incident["cus_company_id"]);
        } else {
            $dd_prd_tier2 = dropdown::select("cas_prd_tier_id2", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_prd_tier3 = dropdown::loadPrd_tier3($db, "cas_prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"", $incident["cas_prd_tier_id3"]);
		if (strUtil::isNotEmpty($incident["cas_opr_tier_id1"]) && strUtil::isNotEmpty($incident["cas_opr_tier_id2"]) && strUtil::isNotEmpty($incident["cus_company_id"])){
        	$dd_prd_tier3 = dropdown::loadPrd_tier3($db, "cas_prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"", $incident["cas_prd_tier_id3"], $incident["cas_prd_tier_id1"], $incident["cas_prd_tier_id2"], $incident["cus_company_id"]);
        } else {
            $dd_prd_tier3 = dropdown::select("cas_prd_tier_id3", "<option></option>", "style=\"width: 100%;\"");
        }
		
			
		
		#Check Allow Tab Dropdown Object Required Field ========================================
		if(!$incident["id"] && !$incident["s_km_id"]){ $tabShoworhide = 'tabbertabhide'; }else{ $tabShoworhide = 'tabbertab'; }
		//$dd_required = 'required=\"true'; 
		//$dd_required2 = 'required=\"true'; 
		//echo $incident["id"];
		//echo "<br>1-status".$_REQUEST["status_id"];
		if(!$incident["id"]){ 
			$dd_required_assig = ""; 
			$dd_required_work = ""; 
			$dd_required_resol = ""; 
		}else{ 
			//echo $_REQUEST["status_id"];
			#Assigned
			if($_REQUEST["status_id"] == 2){ 
				$dd_required_assig = "required=\"true";  //exit;
				$dd_required_work = "";
				$dd_required_resol = ""; }
			#Working Pending	
			if($_REQUEST["status_id"] == 3 || $_REQUEST["status_id"] == 4){  
				//$dd_required_assig = "required=\"true"; 
				//$dd_required_work = "required=\"true"; 
				$dd_required_resol = "";  	}
			#Resolved Propose Closed Closed
			if($_REQUEST["status_id"] == 5 || $_REQUEST["status_id"] == 6 || $_REQUEST["status_id"] == 7){  
				$dd_required_assig = "required=\"true";  
				$dd_required_resol = "required=\"true";   		}
		}  //exit();

		#Assignment Tab ========================================
		$dd_disable1 = $incident["per_ddAssign1"];
		$dd_disable2 = $incident["per_ddAssign2"];
		if($dd_disable2 == "Y"){
			$login_comp_id = user_session::get_user_company_id();
			$login_org_id = user_session::get_user_org_id();
			$login_group_id = user_session::get_user_grp_id();
			$login_subgrp_id = user_session::get_user_subgrp_id();
		}
		//$dd_company = dropdown::loadCompany($db, "assign_comp_id", "required=\"true\" name=\"assign_comp_id\" style=\"width: 100%;\"", $incident["assign_comp_id"]);
		$dd_company = dropdown::loadCompany($db, "assign_comp_id","$dd_required_assig\ $dd_disable1\" name=\"assign_comp_id\" description=\"Tab Assignment: Company\" style=\"width: 100%;\"", $asm["assign_comp_id"]);
		if($dd_disable2 == "Y"){ //กรณีเป็นการ create incident ครั้งแรกและคนเปิดไม่มีสิทธิ์ transfer incedent 
			$dd_company = dropdown::loadCompany($db, "assign_comp_id","$dd_required_assig\ $dd_disable1\" name=\"assign_comp_id\" description=\"Tab Assignment: Company\" style=\"width: 100%;\"", $login_comp_id);
		}
		//$dd_org = dropdown::loadOrg($db, "assign_org_id", "$dd_required_assig\" name=\"assign_org_id\" description=\"Tab Assignment: Organize\" style=\"width: 100%;\"", $asm["assign_org_id"]);
		if (strUtil::isNotEmpty($asm["assign_comp_id"])){
        	$dd_org = dropdown::loadOrg($db, "assign_org_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_org_id\" description=\"Tab Assignment: Organize\" style=\"width: 100%;\"", $asm["assign_org_id"], $asm["assign_comp_id"]);
        } else {
            $dd_org = dropdown::select("assign_org_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%;\"");
			if($dd_disable2 == "Y"){ //กรณีเป็นการ create incident ครั้งแรกและคนเปิดไม่มีสิทธิ์ transfer incedent 
        		$dd_org = dropdown::loadOrg($db, "assign_org_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_org_id\" description=\"Tab Assignment: Organize\" style=\"width: 100%;\"", $login_org_id, $login_comp_id);
			}
        }
		
		//$dd_grp = dropdown::loadGrp($db, "assign_group_id", "$dd_required_assig\" name=\"assign_group_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $asm["assign_group_id"]);
		if (strUtil::isNotEmpty($asm["assign_org_id"])){
                    
        	$dd_grp = dropdown::loadGrp($db, "assign_group_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_group_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $asm["assign_group_id"], $asm["assign_comp_id"], $asm["assign_org_id"]);
        } else {
            $dd_grp = dropdown::select("assign_group_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%;\"");
			if($dd_disable2 == "Y"){ //กรณีเป็นการ create incident ครั้งแรกและคนเปิดไม่มีสิทธิ์ transfer incedent 
        		$dd_grp = dropdown::loadGrp($db, "assign_group_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_group_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $login_group_id, $login_comp_id, $login_org_id);
			}
		}
		//$dd_subgrp = dropdown::loadSubGrp($db, "assign_subgrp_id", "$dd_required_assig\" name=\"assign_subgrp_id\" description=\"Tab Assignment: Sub Group\" style=\"width: 100%;\"", $asm["assign_subgrp_id"]);
		if (strUtil::isNotEmpty($asm["assign_group_id"])){
        	$dd_subgrp = dropdown::loadSubGrp($db, "assign_subgrp_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_subgrp_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $asm["assign_subgrp_id"], $asm["assign_comp_id"], $asm["assign_group_id"]);
        } else {
            $dd_subgrp = dropdown::select("assign_subgrp_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%;\"");
			if($dd_disable2 == "Y"){ //กรณีเป็นการ create incident ครั้งแรกและคนเปิดไม่มีสิทธิ์ transfer incedent 
        		$dd_subgrp = dropdown::loadSubGrp($db, "assign_subgrp_id",  "$dd_required_assig\ $dd_disable1\" name=\"assign_subgrp_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $login_subgrp_id, $login_comp_id, $login_group_id);
			}
		}
		//$dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id", "$dd_required_assig\" name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 100%;\"", $asm["assign_assignee_id"]);
		if (strUtil::isNotEmpty($asm["assign_subgrp_id"])){
        	//$dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id",  " name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 100%;\"", $asm["assign_assignee_id"], $asm["assign_comp_id"], $asm["assign_subgrp_id"]);
                
                $user_permission = user_session::get_user_admin_permission();
                $user_subgrp = user_session::get_user_subgrp_id();
				$cus_company_id = user_session::get_cus_company_id();
                   // echo user_session::get_user_subgrp_id()."<br>";
                   // echo "assign_subgrp_id" .$incident["assign_subgrp_id_last"];
                    if((($incident["assign_subgrp_id_last"] != $user_subgrp) && $user_subgrp != "" && $user_permission != 'Y') || $cus_company_id !="" ){
                        $dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id", "$dd_required_assig\ $dd_disable1\" name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 100%;\"", $asm["assign_assignee_id"], $asm["assign_comp_id"], $asm["assign_subgrp_id"]);
                    }else{
                        $dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id",  " name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 100%;\"", $asm["assign_assignee_id"], $asm["assign_comp_id"], $asm["assign_subgrp_id"]);
                    }
        } else {
            $dd_assign_assignee = dropdown::select("assign_assignee_id", "<option></option>", "style=\"width: 100%;\"");
			if($dd_disable2 == "Y"){ //กรณีเป็นการ create incident ครั้งแรกและคนเปิดไม่มีสิทธิ์ transfer incedent 
        		$dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id",  " name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 100%;\"", "", $login_comp_id, $login_subgrp_id);
			}
		}
                
//                if(strUtil::isNotEmpty($asm["assign_assignee_id"])){
//                    $user_permission = user_session::get_user_admin_permission();
//                    echo $incident["sale_group_id"]."<br>";
//                    echo $am["assign_subgrp_id"];
//                    if(($incident["sale_group_id"] != $am["assign_subgrp_id"]) && $am["assign_subgrp_id"] != "" && $user_permission != 'Y'  ){
//                        echo "fsdsf";
//                        $dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id", "$dd_required_assig\ $dd_disable1\" name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 100%;\"", $asm["assign_assignee_id"], $asm["assign_comp_id"], $asm["assign_subgrp_id"]);
//                    }
//                }
                
		#Work Info Tab
		if(!$incident["workinfo_type_id"]) $default_op = 4; else $default_op = $incident["workinfo_type_id"];
		$dd_workinfotype = dropdown::loadWorkinfotype($db, "workinfo_type_id", "$dd_required_work\" name=\"workinfo_type_id\" style=\"width: 220px;\"", $default_op);
		
		#Resolution Tab  ========================================
		//$dd_opr_tier1_resol = dropdown::loadOpr_tier1_resol($db, "resol_oprtier1", "$dd_required_resol\" name=\"resol_oprtier1\" style=\"width: 100%;\"", $incident["resol_oprtier1"]);
		if (strUtil::isNotEmpty($incident["cus_company_id"])){
        	$dd_opr_tier1_resol = dropdown::loadOpr_tier1_resol($db, "resol_oprtier1", "$dd_required_resol\" name=\"resol_oprtier1\" style=\"width: 100%;\"", $incident["resol_oprtier1"], $incident["cus_company_id"]);
        } else {
            $dd_opr_tier1_resol = dropdown::select("resol_oprtier1", "<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_opr_tier2_resol = dropdown::loadOpr_tier2_resol($db, "resol_oprtier2", "$dd_required_resol\" name=\"resol_oprtier2\" style=\"width: 100%;\"", $incident["resol_oprtier2"]);
		if (strUtil::isNotEmpty($incident["resol_oprtier1"]) && strUtil::isNotEmpty($incident["cus_company_id"])){
        	$dd_opr_tier2_resol = dropdown::loadOpr_tier2_resol($db, "resol_oprtier2", "$dd_required_resol\" name=\"resol_oprtier2\" style=\"width: 100%;\"", $incident["resol_oprtier2"], $incident["resol_oprtier1"], $incident["cus_company_id"]);
        } else {
            $dd_opr_tier2_resol = dropdown::select("resol_oprtier2", "<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_opr_tier3_resol = dropdown::loadOpr_tier3_resol($db, "resol_oprtier3", "\" name=\"resol_oprtier3\" style=\"width: 100%;\"", $incident["resol_oprtier3"]);
		if (strUtil::isNotEmpty($incident["resol_oprtier1"]) && strUtil::isNotEmpty($incident["resol_oprtier2"]) && strUtil::isNotEmpty($incident["cus_company_id"])){
                    $ex_opr_class3 = new Opr_tier3_resol($db);
                    $ex_opr_class3 = $ex_opr_class3->countCombo($incident["resol_oprtier1"],$incident["resol_oprtier2"],$incident["cus_company_id"]);
                    
                    $dd_opr_tier3_resol = dropdown::loadOpr_tier3_resol($db, "resol_oprtier3", " name=\"resol_oprtier3\" style=\"width: 100%;\"", $incident["resol_oprtier3"], $incident["resol_oprtier1"], $incident["resol_oprtier2"], $incident["cus_company_id"]);
        } else {
            $ex_opr_class3 = 0;
            $dd_opr_tier3_resol = dropdown::select("resol_oprtier3", "<option></option>", "style=\"width: 100%;\"");
            
        }
		//$dd_prd_tier1_resol = dropdown::loadPrd_tier1_resol($db, "resol_prdtier1", "$dd_required_resol\" name=\"resol_prdtier1\" style=\"width: 100%;\"", $incident["resol_prdtier1"]);
		if (strUtil::isNotEmpty($incident["cus_company_id"])){
        	$dd_prd_tier1_resol = dropdown::loadPrd_tier1_resol($db, "resol_prdtier1", "$dd_required_resol\" name=\"resol_prdtier1\" style=\"width: 100%;\"", $incident["resol_prdtier1"], $incident["cus_company_id"]);
        } else {
            $dd_prd_tier1_resol = dropdown::select("resol_prdtier1", "<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_prd_tier2_resol = dropdown::loadPrd_tier2_resol($db, "resol_prdtier2", "$dd_required_resol\" name=\"resol_prdtier2\" style=\"width: 100%;\"", $incident["resol_prdtier2"]);
		if (strUtil::isNotEmpty($incident["resol_prdtier1"]) && strUtil::isNotEmpty($incident["cus_company_id"])){
        	$dd_prd_tier2_resol = dropdown::loadPrd_tier2_resol($db, "resol_prdtier2", "$dd_required_resol\" name=\"resol_prdtier2\" style=\"width: 100%;\"", $incident["resol_prdtier2"], $incident["resol_prdtier1"], $incident["cus_company_id"]);
        } else {
            $dd_prd_tier2_resol = dropdown::select("resol_prdtier2", "<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_prd_tier3_resol = dropdown::loadPrd_tier3_resol($db, "resol_prdtier3", "\" name=\"resol_prdtier3\" style=\"width: 100%;\"", $incident["resol_prdtier3"]);
		if (strUtil::isNotEmpty($incident["resol_prdtier1"]) && strUtil::isNotEmpty($incident["resol_prdtier2"]) && strUtil::isNotEmpty($incident["cus_company_id"])){
        	$dd_prd_tier3_resol = dropdown::loadPrd_tier3_resol($db, "resol_prdtier3", " name=\"resol_prdtier3\" style=\"width: 100%;\"", $incident["resol_prdtier3"], $incident["resol_prdtier1"], $incident["resol_prdtier2"], $incident["cus_company_id"]);
        } else {
            $dd_prd_tier3_resol = dropdown::select("resol_prdtier3", "<option></option>", "style=\"width: 100%;\"");
        }
	////////////////////////km ref///////////////////////////////////
        if($_REQUEST["km_id"]!=""){
            $dd_company = dropdown::loadCompany($db, "assign_comp_id","required=\"true\" class=\"select_dis\" disabled=\"true\" name=\"assign_comp_id\" description=\"Tab Assignment: Company\" style=\"width: 100%;\"", $asm["assign_comp_id"]);
            $dd_org = dropdown::loadOrg($db, "assign_org_id","required=\"true\" class=\"select_dis\" disabled=\"true\" name=\"assign_org_id\" description=\"Tab Assignment: Organize\" style=\"width: 100%;\"", $asm["assign_org_id"], $asm["assign_comp_id"]);
            $dd_grp = dropdown::loadGrp($db, "assign_group_id",  "required=\"true\" class=\"select_dis\" disabled=\"true\" name=\"assign_group_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $asm["assign_group_id"], $asm["assign_comp_id"], $asm["assign_org_id"]);
            $dd_subgrp = dropdown::loadSubGrp($db, "assign_subgrp_id",  "required=\"true\" class=\"select_dis\" disabled=\"true\" name=\"assign_subgrp_id\" description=\"Tab Assignment: Group\" style=\"width: 100%;\"", $asm["assign_subgrp_id"], $asm["assign_comp_id"], $asm["assign_group_id"]);
            $dd_assign_assignee = dropdown::loadAssign_assignee_id($db, "assign_assignee_id", "required=\"true\" class=\"select_dis\" disabled=\"true\" name=\"assign_assignee_id\" description=\"Tab Assignment: Assignee\" style=\"width: 100%;\"", $asm["assign_assignee_id"], $asm["assign_comp_id"], $asm["assign_subgrp_id"]);
        }

		


		//$db->close();
    }
	
    function save(){
   //echo "ค่าของ opr_trer1=".$_REQUEST["cas_opr_tier_id1"]. "<br>";
   // echo "ค่าของ opr_trer2=".$_REQUEST["cas_opr_tier_id2"]."<br>";
        global $db, $incident ,$assignment,$tmpPriorityIdBefore ;


		//-----------------
		//count($_REQUEST["userfile"]);
		//$rr = $_REQUEST["userfile"];  
		//print_r ($rr); 
                
		//$Array_attach = $_REQUEST["hd_file_name"];  
		//print_r ($Array_attach); 
		//echo "XX=".$_REQUEST["cus_id"];
		//exit;
		//-----------------
		
        $incident = array(
			"id" => $_REQUEST["incident_id"]
            , "ident_id" => $_REQUEST["txt_ident_id"]
            , "ss_ident_id_run_project" => $_REQUEST["ss_ident_id_run_project"]
            , "summary" => str_replace("'","''",$_REQUEST["txt_summary"])
            , "notes" => str_replace("'","''",$_REQUEST["txt_notes"])
            , "status_id" => $_REQUEST["status_id"]
            , "status_res_id" => $_REQUEST["status_res_id"]
            , "impact_id" => $_REQUEST["impact_id"]
            , "urgency_id" => $_REQUEST["urgency_id"]
            , "priority_id" => $_REQUEST["priority_id"] 
            , "assigned_date" => $_REQUEST["assigned_date"] 		
            , "ddpriority_id" => $_REQUEST["ddpriority_id"]
            , "reference_no" => $_REQUEST["reference_no"]
			#Customer Tab
            , "cus_id" => $_REQUEST["cus_id"]
            , "cus_firstname" => $_REQUEST["cus_firstname"]
            , "cus_lastname" => $_REQUEST["cus_lastname"]
            , "cus_phone" => $_REQUEST["cus_phone"]
            , "cus_ipaddress" => $_REQUEST["cus_ipaddress"]
            , "cus_email" => $_REQUEST["cus_email"]
            , "cus_company_id" => $_REQUEST["cus_company_id"]  
            , "cus_company" => $_REQUEST["cus_company"]
            , "cus_organize" => $_REQUEST["cus_organize"]
            , "cus_area" => $_REQUEST["cus_area"]
            , "cus_office" => $_REQUEST["cus_office"]
            , "cus_department" => $_REQUEST["cus_department"]
            , "cus_site" => $_REQUEST["cus_site"]
            , "keyuser_name" => $_REQUEST["keyuser_name"]
			#Contact Tab
            , "con_firstname" => $_REQUEST["con_firstname"]
            , "con_lastname" => $_REQUEST["con_lastname"]
            , "con_phone" => $_REQUEST["con_phone"]
            , "con_ipaddr" => $_REQUEST["con_ipaddr"]
            , "con_email" => $_REQUEST["con_email"]
            , "con_place" => $_REQUEST["con_place"]
			#Cassification Tab
            , "ident_type_id" => $_REQUEST["ident_type_id"]
            , "project_id" => $_REQUEST["project_id"]
            , "cas_opr_tier_id1" => $_REQUEST["cas_opr_tier_1"]
            , "cas_opr_tier_id2" => $_REQUEST["cas_opr_tier_id2"]
            , "cas_opr_tier_id3" => $_REQUEST["cas_opr_tier_id3"]
            , "cas_prd_tier_id1" => $_REQUEST["cas_prd_tier_id1"]
            , "cas_prd_tier_id2" => $_REQUEST["cas_prd_tier_id2"]
            , "cas_prd_tier_id3" => $_REQUEST["cas_prd_tier_id3"]
			
            , "h_cas_prd_tier_id1" => $_REQUEST["h_cas_prd_tier_id1"]
            , "h_cas_prd_tier_id2" => $_REQUEST["h_cas_prd_tier_id2"]
            , "h_cas_prd_tier_id3" => $_REQUEST["h_cas_prd_tier_id3"]
            , "uploadfile_cass" => $_FILES["uploadfile_cass"]
            , "working_Array_attach_cass" => $_REQUEST["hd_file_name_cass"]
			#Assignment Tab
            //, "assign_comp_id" => $_REQUEST["assign_comp_id"]
            //, "assign_org_id" => $_REQUEST["assign_org_id"]
            //, "assign_group_id" => $_REQUEST["assign_group_id"]
            //, "assign_subgrp_id" => $_REQUEST["assign_subgrp_id"]  
            , "assign_assignee_id" => $_REQUEST["assign_assignee_id"] 
			
            , "assign_comp_id" => $_REQUEST["ddassign_comp_id"]
            , "assign_org_id" => $_REQUEST["ddassign_org_id"] 
            , "assign_group_id" => $_REQUEST["ddassign_group_id"] 
            , "assign_subgrp_id" => $_REQUEST["ddassign_subgrp_id"]   
			
            , "owner_comp_id" => $_REQUEST["h_owner_comp_id"]
            , "owner_org_id" => $_REQUEST["h_owner_org_id"] 
            , "owner_grp_id" => $_REQUEST["h_owner_grp_id"] 
            , "owner_subgrp_id" => $_REQUEST["h_owner_subgrp_id"]  
            , "owner_user_id" => $_REQUEST["h_owner_user_id"]     
            , "assigned_date" => $_REQUEST["h_assigned_date"]         
            , "owner_user_email" => $_REQUEST["h_owner_user_email"] 
			
			#Work Info Tab
            , "workinfo_type_id" => $_REQUEST["workinfo_type_id"]
            , "workinfo_summary" => $_REQUEST["workinfo_summary"]
            , "workinfo_notes" => $_REQUEST["workinfo_notes"]
            , "working_date" => $_REQUEST["h_working_date"]
            , "working_Array_attach" => $_REQUEST["hd_file_name"]
            , "uploadfile_working" => $_FILES["uploadfile_working"]
			
			#Resolution Tab 
			, "resolution" => $_REQUEST["resolution"]
            , "satisfac_id" => $_REQUEST["satisfac_id"]
            , "resol_oprtier1" => $_REQUEST["resol_oprtier1"]
            , "resol_oprtier2" => $_REQUEST["resol_oprtier2"]
            , "resol_oprtier3" => $_REQUEST["resol_oprtier3"]
            , "resol_prdtier1" => $_REQUEST["resol_prdtier1"]
            , "resol_prdtier2" => $_REQUEST["resol_prdtier2"]
            , "resol_prdtier3" => $_REQUEST["resol_prdtier3"]
            , "resolved_date" => $_REQUEST["h_resolved_date"]
            , "uploadfile_reslove" => $_FILES["uploadfile_reslove"]
            , "km_entrant" => $_REQUEST["km_entrant"]
            , "km_keyword" => $_REQUEST["km_keyword"]
            , "km_release" => $_REQUEST["km_release"]
			
			#Date/System Tab
            //, "action_date" => dateUtil::current_date_time()
            //, "create_date" => dateUtil::current_date_time()
            //, "owner_date" => dateUtil::current_date_time()
            //, "last_modify_date" => dateUtil::current_date_time()
            , "propose_closed_date" => $_REQUEST["h_propose_closed_date"]
            , "closed_date" => $_REQUEST["h_closed_date"] 
            
            ////////////km ref///////////////
            , "s_km_id" => $_REQUEST["s_km_id"]
            , "getfile_name_resolution" => split(",",$_REQUEST["getfile_name_resolution"])
			
        );

        ;

		//echo "1-".$_REQUEST["assign_org_id"]; 
		//echo $incident["assign_org_id"]; //exit();
		
		
        # validate
        //if (validate($incident)){
            # save
            $db->begin_transaction();

            $p = new incident($db);

            $statusChange = "N";
            $priorityChange = "N";

            if($_REQUEST["hdStatusIdBefore"] != $_REQUEST["status_id"] )
            #if($_SESSION["tmpStatusBefore"] != $_REQUEST["status_id"] )
            {
                $statusChange = "Y";
            }
            if($_REQUEST["hdPriorityIdBefore"] != $_REQUEST["priority_id"])
            #if($_SESSION["tmpPriorityBefore"] != $_REQUEST["priority_id"])
            {
                $priorityChange = "Y";
            }
            if (strUtil::isEmpty($incident["id"])){

                $result = $p->insert($incident);

                #////////////////////////////////////////////////////////////////////////////
                # Insert before save data into status_change_log table #Uthen.P 08-April-2016
                $statusPriorityInsert = array(
                    "incident_id" => $result["identrun"]
                ,"statusBefore" => 0
                ,"statusAfter" => $_REQUEST["status_id"]
                ,"priorityBefore" => 0
                ,"priorityAfter" => $_REQUEST["priority_id"]
                ,"userId" => user_session::get_user_id()
                ,"statusChange" => $statusChange
                ,"priorityChange" => $priorityChange
                );
                $updateLogResult = $p->insertStatusChangeLog($statusPriorityInsert);
                #////////////////////////////////////////////////////////////////////////////

            } else {
                
				//echo '<script type="text/javascript">
                //        alert("incident.action.php Line:518->Updating");
                //    </script>';
				
                #////////////////////////////////////////////////////////////////////////////
                # Update before data into status_change_log table #Uthen.P 08-April-2016
                $statusPriorityUpdate = array(

                "incident_id" => $_REQUEST["ss_ident_id_run_project"]
                ,"statusBefore" => $_REQUEST["hdStatusIdBefore"]
                ,"statusAfter" => $_REQUEST["status_id"]
                ,"priorityBefore" => $_REQUEST["hdPriorityIdBefore"]
                ,"priorityAfter" => $_REQUEST["priority_id"]
                ,"userId" => user_session::get_user_id()
                ,"statusChange" => $statusChange
                ,"priorityChange" => $priorityChange
                );
                $updateLogResult = $p->insertStatusChangeLog($statusPriorityUpdate);
                #////////////////////////////////////////////////////////////////////////////

                $result = $p->update($incident);
				
				//echo '<script type="text/javascript">
                //        alert("incident.action.php Line:518->Updating");
                //    </script>';
				
            }
				
            $db->end_transaction($result);

            if ($result["result"]){
								
                $incident = $p->getByIncidentID($incident["id"]);
                if($incident["status_id"]== 6){

//            $_SESSION["current"] = "incident/main_incident/index.php?mode=". $_GET["mode"];
//            echo "<script> 
//                    setTimeout(jAlert(\"success\", \"Save Complete !!!\", \"Helpdesk System : Messages\");,500000);
////                    setInterval(function() { jAlert(\"success\", \"Save Complete !!!\", \"Helpdesk System : Messages\") }, 2000);
//                    top.location.href= '../../home.php';
//                </script>";
                alert_message_simple("Save complete and sent incident to owner ", "back_inc();");
                }else{
                    #alert_message_simple("XXXXX", "YYYY");
                    alert_message(MESSAGE_SAVE_COMPLETE, "page_submit(\'index.php?action=incident.php&mode=".$_GET['mode']."\' , \'display\')",SUCCESS_MESSAGE);
                }
            }
       // }
    }

    function validate($objective){
      global  $db;

        $p = new incident($db);

       $result = $p->isDuplicate($objective);

       if ($result == "customer id"){
           alert_message_simple("Customer ID Incorrect", "");
           return false;
       }
       
       return true;
    }
    ///////////////km ref////////////////////
    function get_new_incident(){
        global $incident;
        $incident["cus_company_id"] = $_GET["cus_company_id"];
        $incident["summary"] = $_REQUEST["txt_summary"];
        $incident["notes"] = $_REQUEST["txt_notes"];
        $incident["priority_id"] = $_REQUEST["priority_id"];
        $incident["reference_no"] = $_REQUEST["reference_no"];
        $incident["con_firstname"] = $_REQUEST["con_firstname"];
        $incident["con_lastname"] = $_REQUEST["con_lastname"];
        $incident["con_phone"] = $_REQUEST["con_phone"];
        $incident["con_ipaddr"] = $_REQUEST["con_ipaddr"];
        $incident["con_email"] = $_REQUEST["con_email"];
        $incident["con_place"] = $_REQUEST["con_place"];
        
    }
?>
