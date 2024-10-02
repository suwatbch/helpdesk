<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/company.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $company;

        $company_id = $_REQUEST["company_id"];

        if (strUtil::isNotEmpty($company_id)){
            $p = new company($db);
            $company = $p->getById($company_id);
        }
    }

    function finalize(){
        global $db;
        $db->close();
    }

    function save(){
        global $db, $company;

        # get input
        $company = array(
            "company_id" => $_REQUEST["company_id"]
            , "company_name" => $_REQUEST["company_name"]
            , "status_company" => $_REQUEST["status_company"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );

            # save
            $db->begin_transaction();

            $p = new company($db);

            if (strUtil::isEmpty($company["company_id"])){
                $result = $p->insert($company);
            } else {
                $result = $p->update($company);
            }

            $db->end_transaction($result);

            if ($result){
                $company = $p->getById($company["company_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }
?>
