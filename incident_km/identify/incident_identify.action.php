<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
   include_once "../../include/class/model/helpdesk_identify_km.class.php";
   include_once "../../include/class/model/incident_type.class.php";
   include_once "../../include/class/model/helpdesk_project.class.php";
    include_once "../../include/class/model/opr_tier1.class.php";  
    include_once "../../include/class/model/opr_tier2.class.php"; 
    include_once "../../include/class/model/opr_tier3.class.php";
    include_once "../../include/class/model/prd_tier1.class.php";  
    include_once "../../include/class/model/prd_tier2.class.php";   
    include_once "../../include/class/model/prd_tier3.class.php";  
    
    include_once "../../include/class/model/helpdesk_company.class.php";
	
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $identify_km;
        
        $incident_id = $_REQUEST["incident_id"];
        $km_id = $_REQUEST["km_id"];	
        if (strUtil::isNotEmpty($incident_id) || strUtil::isNotEmpty($km_id)){
            $p = new helpdesk_identify_km($db);
            $identify_km = $p->getByID($incident_id,$km_id);
        }
    }
	
    function finalize(){
        global $db, $identify_km
				,$dd_incident_type,$dd_project,$dd_opr_tier1,$dd_opr_tier2,$dd_opr_tier3
				,$dd_prd_tier1,$dd_prd_tier2,$dd_prd_tier3,$dd_company_cus;
	 $dd_company_cus = dropdown::loadCusCompany($db, "cus_company_id", "required=\"true\" name=\"cus_company_id\" style=\"width: 100%;\"", $identify_km["cus_company_id"]);	
		//$dd_incident_type = dropdown::loadIncident_type($db, "ident_type_id", "required=\"true\" name=\"ident_type_id\" style=\"width: 100%;\"", $identify_km["ident_type_id"]);
		if (strUtil::isNotEmpty($identify_km["cus_company_id"])){
			$dd_incident_type = dropdown::loadIncident_type($db, "ident_type_id", "required=\"true\" name=\"ident_type_id\" style=\"width: 100%;\"", $identify_km["ident_type_id"],  $identify_km["cus_company_id"]);
        } else {
            $dd_incident_type = dropdown::select("ident_type_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_project = dropdown::loadProject($db, "project_id", "required=\"true\" name=\"project_id\" style=\"width: 100%;\"", $identify_km["project_id"]);
		if (strUtil::isNotEmpty($identify_km["cus_company_id"])){
			$dd_project = dropdown::loadProject($db, "project_id", "required=\"true\" name=\"project_id\" style=\"width: 100%;\"", $identify_km["project_id"],  $identify_km["cus_company_id"]);
        } else {
            $dd_project = dropdown::select("project_id", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_opr_tier1 = dropdown::loadOpr_tier1($db, "cas_opr_tier_id1", "required=\"true\" name=\"cas_opr_tier_id1\" style=\"width: 100%;\"", $identify_km["cas_opr_tier_id1"]);
		if (strUtil::isNotEmpty($identify_km["cus_company_id"])){
						//echo " cus_company ไม่ว่าง";
			$dd_opr_tier1 = dropdown::loadOpr_tier1($db, "cas_opr_tier_id1", "required=\"true\" name=\"cas_opr_tier_id1\" style=\"width: 100%;\"", $identify_km["resol_oprtier1"],  $identify_km["cus_company_id"]);
        } else {
            			//echo " cus_company ว่าง";
			$dd_opr_tier1 = dropdown::select("cas_opr_tier_id1", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_opr_tier2 = dropdown::loadOpr_tier2($db, "cas_opr_tier_id2", "required=\"true\" name=\"cas_opr_tier_id2\" style=\"width: 100%;\"", $identify_km["cas_opr_tier_id2"]);
        if (strUtil::isNotEmpty($identify_km["resol_oprtier1"]) && strUtil::isNotEmpty($identify_km["cus_company_id"])){
			$dd_opr_tier2 = dropdown::loadOpr_tier2($db, "cas_opr_tier_id2", "required=\"true\" name=\"cas_opr_tier_id2\" style=\"width: 100%;\"", $identify_km["resol_oprtier2"], $identify_km["resol_oprtier1"],$identify_km["cus_company_id"]);
        } else {
			$dd_opr_tier2 = dropdown::select("cas_opr_tier_id2", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_opr_tier3 = dropdown::loadOpr_tier3($db, "cas_opr_tier_id3", "name=\"cas_opr_tier_id3\" style=\"width: 100%;\"", $identify_km["cas_opr_tier_id3"]);
		if (strUtil::isNotEmpty($identify_km["resol_oprtier1"]) && strUtil::isNotEmpty($identify_km["resol_oprtier2"]) && strUtil::isNotEmpty($identify_km["cus_company_id"])){
//                    $ex_cas_opr_class3 = new Opr_tier3($db);
//                    $ex_cas_opr_class3 = $ex_cas_opr_class3->countCombo($identify_km["cas_opr_tier_id1"],$identify_km["cas_opr_tier_id2"],$identify_km["cus_company_id"]);
                    
                    
                    $dd_opr_tier3 = dropdown::loadOpr_tier3($db, "cas_opr_tier_id3", "name=\"cas_opr_tier_id3\" style=\"width: 100%;\"", $identify_km["resol_oprtier3"], $identify_km["resol_oprtier1"], $identify_km["resol_oprtier2"],$identify_km["cus_company_id"]);
        } else {
            $dd_opr_tier3 = dropdown::select("cas_opr_tier_id3", "<option></option>", "style=\"width: 100%;\"");
//            $ex_cas_opr_class3 = "0";
        }
		
		//$dd_prd_tier1 = dropdown::loadPrd_tier1($db, "cas_prd_tier_id1", "required=\"true\" name=\"cas_prd_tier_id1\" style=\"width: 100%;\"", $identify_km["cas_prd_tier_id1"]);
		if (strUtil::isNotEmpty($identify_km["cus_company_id"])){
			$dd_prd_tier1 = dropdown::loadPrd_tier1($db, "cas_prd_tier_id1", "required=\"true\" name=\"cas_prd_tier_id1\" style=\"width: 100%;\"", $identify_km["resol_prdtier1"], $identify_km["cus_company_id"]);
        } else {
            $dd_prd_tier1 = dropdown::select("cas_prd_tier_id1", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_prd_tier2 = dropdown::loadPrd_tier2($db, "cas_prd_tier_id2", "required=\"true\" name=\"cas_prd_tier_id2\" style=\"width: 100%;\"", $identify_km["cas_prd_tier_id2"]);
        if (strUtil::isNotEmpty($identify_km["resol_prdtier1"]) && strUtil::isNotEmpty($identify_km["cus_company_id"])){
        	$dd_prd_tier2 = dropdown::loadPrd_tier2($db, "cas_prd_tier_id2", "required=\"true\" name=\"cas_prd_tier_id2\" style=\"width: 100%;\"", $identify_km["resol_prdtier2"], $identify_km["resol_prdtier1"], $identify_km["cus_company_id"]);
        } else {
            $dd_prd_tier2 = dropdown::select("cas_prd_tier_id2", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
		//$dd_prd_tier3 = dropdown::loadPrd_tier3($db, "cas_prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"", $identify_km["cas_prd_tier_id3"]);
		if (strUtil::isNotEmpty($identify_km["resol_prdtier1"]) && strUtil::isNotEmpty($identify_km["resol_prdtier2"]) && strUtil::isNotEmpty($identify_km["cus_company_id"])){
        	$dd_prd_tier3 = dropdown::loadPrd_tier3($db, "cas_prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"", $identify_km["resol_prdtier3"], $identify_km["resol_prdtier1"], $identify_km["resol_prdtier2"], $identify_km["cus_company_id"]);
        } else {
            $dd_prd_tier3 = dropdown::select("cas_prd_tier_id3", "<option></option>", "style=\"width: 100%;\"");
        }
		$db->close();
    }
	
    function save(){	
        global $db, $identify_km ,$assignment;
        
        $identify = array(
            "summary" => $_REQUEST["summary"]
            , "detail" => $_REQUEST["detail"]
            , "incident_type_id" => $_REQUEST["ident_type_id"]
            , "project_id" => $_REQUEST["project_id"]
            , "cus_comp_id" => $_REQUEST["cus_company_id"]
            , "opr_tier_id1" => $_REQUEST["cas_opr_tier_id1"]
            , "opr_tier_id2" => $_REQUEST["cas_opr_tier_id2"]
            , "opr_tier_id3" => $_REQUEST["cas_opr_tier_id3"]
            , "prd_tier_id1" => $_REQUEST["cas_prd_tier_id1"]
            , "prd_tier_id2" => $_REQUEST["cas_prd_tier_id2"] 
            , "prd_tier_id3" => $_REQUEST["cas_prd_tier_id3"] 		
            , "resolution" => $_REQUEST["resolution"]
            , "resolution_user_id" => user_session::get_user_id()
            , "resolved_date" => date("Y-m-d H:i:s")
            , "create_by" => user_session::get_user_id()
            , "create_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
            , "km_keywords" => $_REQUEST["km_keywords"]
            , "uploadfile_identify" => $_FILES["uploadfile_identify"]
            , "km_release" => $_REQUEST["km_release"]
            , "km_id" => $_REQUEST["s_km_id"]
            , "incident_id" => $_REQUEST["s_incident_id"]
            , "getfile_name" => split(",",$_REQUEST["getfile_name"])
            , "km_no" => $_REQUEST["km_no"]
			
			
        );
		
            # save
            $db->begin_transaction();

            $p = new helpdesk_identify_km($db);
            if (strUtil::isEmpty($identify["km_id"]) || strUtil::isNotEmpty($identify["incident_id"])){
                $result = $p->insert($identify);
            } else {
                $result = $p->update($identify);
            }
            $db->end_transaction($result);

            if ($result){
               $identify_km = $p->getByID("",$identify["km_id"]);
               alert_message_simple("Save Completed !! ", "back_master();");
                //alert_message(MESSAGE_SAVE_COMPLETE, "page_submit(\'index.php?action=incident.php&mode=".$_GET['mode']."\' , \'display\')",SUCCESS_MESSAGE);
            }
    }

?>
