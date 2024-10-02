<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
	include_once "../../include/class/model/user_other.class.php";
    include_once "../../include/class/model/helpdesk_project.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective, $action_add_user_other;
		
        $action_add_user_other = 1;

		
        echo $objective = $_REQUEST["project_id"];

        if (strUtil::isNotEmpty($objective)){
            $p = new helpdesk_project($db);
			$objective = $p->getById($objective);
			$user = $p->get_project_user($objective["project_id"]);
        }

    }

    function finalize(){
        
        //global $db ,$dd_company ,$dd_org ,$dd_grp ,$dd_subgrp, $user;
        //$dd_company = dropdown::loadCompanyMaster($db, 'company_id', " name=\"company_id\" style=\"width: 100%;\"", "", $company_id);
        //$dd_org = dropdown::select('org_id', "<option></option>", "style=\"width: 100%;\"");
        //$dd_grp = dropdown::select('group_id', "<option></option>", "style=\"width: 100%;\"");
        //$dd_subgrp = dropdown::select('subgrp_id', "<option></option>", "style=\"width: 100%;\"");
        //$db->close();
		global $db, $dd_cus_company, $objective;
        $dd_cus_company = dropdown::loadCusCompany($db, "cus_comp_id","required=\"true\" name=\"cus_comp_id\" style=\"width: 100%;\"", $objective["cus_comp_id"]);
        $db->close();
    }



?>
