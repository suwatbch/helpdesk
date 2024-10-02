<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_subgrp_mas.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/model/helpdesk_grp.class.php";
    include_once "../../include/class/model/helpdesk_org.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective;

        $objective = $_REQUEST["org_id"];

        if (strUtil::isNotEmpty($objective)){
            $p = new helpdesk_subgrp_mas($db);
            $objective = $p->getById($objective);
        }
    }

    function finalize(){
        global $db, $dd_company, $dd_org, $objective, $dd_grp;
        $dd_company = dropdown::loadCompanyMaster($db, "company_id","style=\"width: 100%;\"", $objective["org_comp"]);
        $dd_org = dropdown::loadOrg_master($db,"org_id", "name=\"org_id\" style=\"width: 100%;\"", $objective["organization_id"], $objective["org_comp"]);
        $dd_grp = dropdown::loadGrp_master($db,"group_id", "required=\"true\" name=\"group_id\" style=\"width: 100%;\"", $objective["s_group_id"], $user["org_comp"]);
        $db->close();

    }

    function save(){
        global $db, $objective, $org_code;
        
        $p = new helpdesk_subgrp_mas($db);
        $org_code = $p->gen_subgrp_code($_REQUEST["company_id"],$_REQUEST["group_id"]);
        
      // echo $org_code;
       //exit();
        # get input
        $objective = array(
            "org_id" => $_REQUEST["s_org_id"]
            , "org_code" => "0".$org_code
            , "org_comp" => $_REQUEST["company_id"]
            , "org_name" => $_REQUEST["org_name"]
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
            , "s_org_comp" => $_REQUEST["s_org_comp"]
            , "s_org_grp" => $_REQUEST["s_org_grp"]
            , "group_id" => $_REQUEST["group_id"]
        );
            # save
            $db->begin_transaction();

            $p = new helpdesk_subgrp_mas($db);

            if (strUtil::isEmpty($objective["org_id"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
            }

            $db->end_transaction($result);

            if ($result){
                $objective = $p->getById($objective["org_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }

?>
