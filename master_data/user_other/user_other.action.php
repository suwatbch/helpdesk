<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/user_other.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/model/helpdesk_org.class.php";
    include_once "../../include/class/model/helpdesk_grp.class.php";
    include_once "../../include/class/model/helpdesk_subgrp.class.php";
    include_once "../../include/class/model/helpdesk_check_org.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified($user_id = "") {
        global $db, $user, $user_other, $action_add_user_other;
        
        $action_add_user_other = 1;
        
        if($user_id==""){
        $user_id = $_REQUEST["user_id"];
        }
        if (strUtil::isNotEmpty($user_id)){
            $p = new user_other($db);
            $user = $p->getById($user_id);
            
            $user_other = $p->get_uer_other($user_id);
        }
    }

    function finalize(){
        
        global $db ,$dd_company ,$dd_org ,$dd_grp ,$dd_subgrp, $user;
        $dd_company = dropdown::loadCompanyMaster($db, 'company_id', " name=\"company_id\" style=\"width: 100%;\"", "", $company_id);
        $dd_org = dropdown::select('org_id', "<option></option>", "style=\"width: 100%;\"");
        $dd_grp = dropdown::select('group_id', "<option></option>", "style=\"width: 100%;\"");
        $dd_subgrp = dropdown::select('subgrp_id', "<option></option>", "style=\"width: 100%;\"");
        $db->close();

    }

    function save(){
        global $db, $objective;
        # get input
        $objective = array(
            "user_id" => $_REQUEST["user_id"]
            , "specorg_id" => $_REQUEST["specorg_id"]
            , "company_id" => $_REQUEST["company_dialog"]
            , "org_id" => $_REQUEST["subgrp_dialog"]
            , "status" => 'A'
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );

            # save
            $db->begin_transaction();

            $p = new user_other($db);

            if (strUtil::isEmpty($objective["specorg_id"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
            }

            $db->end_transaction($result);

            unspecified($objective["user_id"]);
    }
    function delete(){
        global $db;

        $objective = $_GET["specorg_id"];
        $user_id = $_GET["user_id"];
        
//        echo "sdfsf";
//        echo $objective."<br>";
//        echo $user_id;
//        exit();
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new user_other($db);
            $result = $p->delete($objective);

            $db->end_transaction($result);
        }

        unspecified($user_id);
    }

?>
