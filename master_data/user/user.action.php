<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/user.class.php";
	include_once "../../include/class/model/customer.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/model/helpdesk_org.class.php";
    include_once "../../include/class/model/helpdesk_grp.class.php";
    include_once "../../include/class/model/helpdesk_subgrp.class.php";
    include_once "../../include/class/model/helpdesk_check_org.class.php";
	
	
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective, $user_org, $user, $copy;
        
        if(strUtil::isNotEmpty($_REQUEST["user_id"])){
            $objective = $_REQUEST["user_id"];
            $copy = 0;
        }else if(strUtil::isNotEmpty($_REQUEST["c_user_id"])){
            $objective = $_REQUEST["c_user_id"];
            $copy = 1;
        }
        if (strUtil::isNotEmpty($objective)){
            $p = new user($db);
            $user = $p->getById($objective);
            
            $pg = new Check_helpdesk_org($db);
            $user_org = $pg->check_org_id($user["org_id"]);
        }
    }

    function finalize(){
        
        global $db ,$dd_company ,$dd_org ,$dd_grp ,$dd_subgrp, $user, $user_org,$dd_company_cus;
        $dd_company = dropdown::loadCompanyMaster($db, "company_id","style=\"width: 100%;\"", $user["company_id"]);
        $dd_company_cus = dropdown::loadCusCompany($db, "cus_company_id","required=\"true\" name=\"cus_company_id\" style=\"width: 100%;\"", $user["cus_company_id"]);
		$dd_org = dropdown::loadOrg_master($db,"org_id", "required=\"true\" name=\"org_id\" style=\"width: 100%;\"", $user_org["s_org_user_id"], $user["company_id"]);
        $dd_grp = dropdown::loadGrp_master($db,"group_id", "required=\"true\" name=\"group_id\" style=\"width: 100%;\"", $user_org["s_grp_user_id"], $user["company_id"]);
        $dd_subgrp = dropdown::loadSubGrp_master($db,"subgrp_id", "required=\"true\" name=\"subgrp_id\" style=\"width: 100%;\"", $user["org_id"], $user["company_id"], $user["s_grp_user_id"]);
        $db->close();

    }

    function save(){
        global $db, $user, $user_org;

        # get input
        $user = array(
            "user_code" => $_REQUEST["user_code"]
            , "user_id" => $_REQUEST["user_id"]
            , "employee_code" => $_REQUEST["employee_code"]
            , "first_name" => $_REQUEST["first_name"]
            , "last_name" => $_REQUEST["last_name"]
            , "email" => $_REQUEST["email"]
            , "company_id" => $_REQUEST["company_id"]
			, "cus_company_id" => $_REQUEST["cus_company_id"]
            , "org_id" => $_REQUEST["org_id"]
            , "group_id" => $_REQUEST["group_id"]
            , "subgrp_id" => $_REQUEST["subgrp_id"]
           // , "org_id" => $_REQUEST["org_id"]."".$_REQUEST["group_id"]."".$_REQUEST["subgrp_id"]
            , "transfer_incident_permission" => $_REQUEST["transfer_incident_permission"]=='Y'?'Y':'N'
            , "admin_permission" => $_REQUEST["admin_permission"]=='Y'?'Y':'N'
			, "advance_search_permission" => $_REQUEST["advance_search_permission"]=='Y'?'Y':'N'
            , "user_login" => strtolower($_REQUEST["user_code"])
            , "pass" => strtoupper(md5($_REQUEST["pass"]))
            , "pass_count" => $_REQUEST["pass_count"]
//            , "user_status" => $_REQUEST["user_status"]
            , "edit_report_permission" => $_REQUEST["edit_report_permission"]=='Y'?'Y':'N'
            , "approve_report_permission" => $_REQUEST["approve_report_permission"]=='Y'?'Y':'N'
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
            , "create_incident" => $_REQUEST["create_incident"]
            , "admin" => $_REQUEST["s_admin"]
            , "s_password" => $_REQUEST["s_password"]
            , "ss_password" => $_REQUEST["pass"]
            , "s_pass_count" => $_REQUEST["s_pass_count"]
        );

            # save
            $pg = new Check_helpdesk_org($db);
            //$user["ss_org_id"] = $pg->check_org($user);
            
            $db->begin_transaction();

            $p = new user($db);

            if (strUtil::isEmpty($user["user_id"])){
                $result = $p->insert($user);
            } else {
                $result = $p->update($user);
            }

            $db->end_transaction($result);

            if ($result){
                $user = $p->getById($user["user_id"]);
                $user_org = $pg->check_org_id($user["org_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }


?>
