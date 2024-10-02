<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_aging.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective;

        $objective = $_REQUEST["id"];

        if (strUtil::isNotEmpty($objective)){
            $p = new aging_report($db);
            $objective = $p->getById($objective);
        }
    }

    function finalize(){
        global $db;
        $db->close();

    }

    function save(){
        global $db, $objective;

        # get input
        $objective = array(
            "id" => $_REQUEST["id"]
            , "value" => $_REQUEST["value"]
            , "shortname" => ">= ".$_REQUEST["value"]
            , "name" => "มากกว่าหรือเท่ากับ".$_REQUEST["value"]
            , "type" => "report_aging"
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );
            # save
            $db->begin_transaction();

            $p = new aging_report($db);

            if (strUtil::isEmpty($objective["id"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
            }

            $db->end_transaction($result);

            if ($result){
                $objective = $p->getById($objective["id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }

?>
