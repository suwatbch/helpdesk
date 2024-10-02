<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_org_mas.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective;

        $objective = $_REQUEST["org_id"];

        if (strUtil::isNotEmpty($objective)){
            $p = new helpdesk_org_mas($db);
            $objective = $p->getById($objective);
        }
    }

    function finalize(){
        global $db, $dd_company, $objective;
        $dd_company = dropdown::loadCompanyMaster($db, "company_id","style=\"width: 100%;\"", $objective["org_comp"]);
        $db->close();

    }

    function save(){
        global $db, $objective;

        # get input
        $objective = array(
            "org_id" => $_REQUEST["org_id"]
            , "org_comp" => $_REQUEST["company_id"]
            , "org_name" => $_REQUEST["org_name"]
            , "org_code" => "01"
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );

            # save
            $db->begin_transaction();

            $p = new helpdesk_org_mas($db);

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
