<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_org.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective;

        $cus_org_id = $_REQUEST["cus_org_id"];

        if (strUtil::isNotEmpty($cus_org_id)){
            $p = new helpdesk_org($db);
            $objective = $p->getById($cus_org_id);
        }
    }

    function finalize(){
        global $db, $dd_company_cus, $objective;
        $dd_company_cus = dropdown::loadCusCompany($db, "cus_company_id","required=\"true\" name=\"cus_company_id\" style=\"width: 100%;\"", $objective["cus_company_id"]);
        $db->close();

    }

    function save(){
        global $db, $objective;

        # get input
        $objective = array(
            "cus_org_id" => $_REQUEST["cus_org_id"]
            , "cus_org_name" => $_REQUEST["cus_org_name"]
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
            , "cus_company_id" => $_REQUEST["cus_company_id"]
        );
            # save
            $db->begin_transaction();

            $p = new helpdesk_org($db);

            if (strUtil::isEmpty($objective["cus_org_id"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
            }

            $db->end_transaction($result);

            if ($result){
                $objective = $p->getById($objective["cus_org_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }

?>
