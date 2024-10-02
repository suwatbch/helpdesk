<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_identify_km.class.php";
    include_once "../../include/class/model/prd_tier1.class.php";  
    include_once "../../include/class/model/prd_tier2.class.php";   
    include_once "../../include/class/model/prd_tier3.class.php";  
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified(){
    global $action_master;
        $action_master = 3;
        search_release();
    }

    function finalize(){
        global $db,$dd_prd_tier1,$dd_prd_tier2,$dd_prd_tier3,$dd_company_cus;
	$dd_company_cus = dropdown::loadCusCompany($db, "cus_company_id","required=\"true\" name=\"cus_company_id\" style=\"width: 50%;\"", $_REQUEST["cus_company_id"]);	
	
	if (strUtil::isNotEmpty($_REQUEST["cus_company_id"])){
			$dd_prd_tier1 = dropdown::loadPrd_tier1($db, "cas_prd_tier_id1", "required=\"true\" name=\"cas_prd_tier_id1\" style=\"width: 100%;\"", $_REQUEST["cas_prd_tier_id1"], $_REQUEST["cus_company_id"]);
        } else {
            $dd_prd_tier1 = dropdown::select("cas_prd_tier_id1", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
        if (strUtil::isNotEmpty($_REQUEST["cas_prd_tier_id1"]) && strUtil::isNotEmpty($_REQUEST["cus_company_id"])){
        	$dd_prd_tier2 = dropdown::loadPrd_tier2($db, "cas_prd_tier_id2", "required=\"true\" name=\"cas_prd_tier_id2\" style=\"width: 100%;\"", $_REQUEST["cas_prd_tier_id2"], $_REQUEST["cas_prd_tier_id1"], $_REQUEST["cus_company_id"]);
        } else {
            $dd_prd_tier2 = dropdown::select("cas_prd_tier_id2", "required=\"true\"<option></option>", "style=\"width: 100%;\"");
        }
        if (strUtil::isNotEmpty($_REQUEST["cas_prd_tier_id1"]) && strUtil::isNotEmpty($_REQUEST["cas_prd_tier_id2"]) && strUtil::isNotEmpty($_REQUEST["cus_company_id"])){
        	$dd_prd_tier3 = dropdown::loadPrd_tier3($db, "cas_prd_tier_id3", "name=\"cas_prd_tier_id3\" style=\"width: 100%;\"", $_REQUEST["cas_prd_tier_id3"], $_REQUEST["cas_prd_tier_id1"], $_REQUEST["cas_prd_tier_id2"], $_REQUEST["cus_company_id"]);
        } else {
            $dd_prd_tier3 = dropdown::select("cas_prd_tier_id3", "<option></option>", "style=\"width: 100%;\"");
        }
		//$db->close();
    }

    function delete(){
        global $db;

        $objective = $_GET["cus_area_id"];
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new helpdesk_area($db);
            $result = $p->delete($objective);

            $db->end_transaction($result);
        }

        unspecified();
    }
    function restore(){
        global $db;

        $objective = $_GET["cus_area_id"];
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new helpdesk_area($db);
            $result = $p->restore_master($objective);

            $db->end_transaction($result);
        }

        unspecified();
    }
    
    function search_release($cus_comp_id="",$prd_tier_id1="",$prd_tier_id2="",$prd_tier_id3=""){
        global $db, $total_row, $objective, $objective_km, $f_objective;
        $cratiria = array(
            "cus_comp_id" => $_REQUEST["cus_company_id"]
            ,"prd_tier_id1" => $_REQUEST["cas_prd_tier_id1"]
            ,"prd_tier_id2" => $_REQUEST["cas_prd_tier_id2"]
            ,"prd_tier_id3" => $_REQUEST["cas_prd_tier_id3"]
        );
        $p = new helpdesk_identify_km($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $f_objective = $p->search_release($cratiria, $page);

        $total_row = $f_objective["total_row"];
        $objective_km = $f_objective["data_km"];
    }
    
    function save(){
        global $db, $release;
        $release = array(
         "km_id" => split(",",$_REQUEST["select_unrelease"])
		
        );
		
            # save
            $db->begin_transaction();

            $p = new helpdesk_identify_km($db);
            if (strUtil::isNotEmpty($release["km_id"])){
                $result = $p->update_release($release);
            } 
            $db->end_transaction($result);

            if ($result){    
                    unspecified();
            }
    }
    
?>
