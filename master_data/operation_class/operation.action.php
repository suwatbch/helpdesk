<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_opr.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective;

        $objective = $_REQUEST["opr_tier_id"];

        if (strUtil::isNotEmpty($objective)){
            $p = new helpdesk_opr($db);
            $objective = $p->getById($objective);
        }
    }

    function finalize(){
        global $db, $dd_cus_company, $objective;
        $dd_cus_company = dropdown::loadCusCompany($db, "cus_comp_id","required=\"true\" name=\"cus_comp_id\" style=\"width: 100%;\"", $objective["cus_comp_id"]);
        $db->close();

    }

    function save(){
        global $db, $objective;

        # get input
        $objective = array(
            "opr_tier_id" => $_REQUEST["opr_tier_id"]
            , "opr_tier_name" => $_REQUEST["opr_tier_name"]
            , "opr_tier_level" => $_REQUEST["opr_tier_level"]
            , "cus_comp_id" => $_REQUEST["cus_comp_id"]
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );
            # save
            $db->begin_transaction();

            $p = new helpdesk_opr($db);

            if (strUtil::isEmpty($objective["opr_tier_id"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
            }

            $db->end_transaction($result);

            if ($result){
                $objective = $p->getById($objective["opr_tier_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }

?>