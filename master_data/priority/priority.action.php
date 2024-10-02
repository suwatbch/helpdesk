<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/priority.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective;

        $objective = $_REQUEST["priority_id"];

        if (strUtil::isNotEmpty($objective)){
            $p = new priority($db);
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
            "priority_id" => $_REQUEST["priority_id"]
            , "priority_desc" => $_REQUEST["priority_desc"]
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );
            # save
            $db->begin_transaction();

            $p = new priority($db);

            if (strUtil::isEmpty($objective["priority_id"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
            }

            $db->end_transaction($result);

            if ($result){
                $objective = $p->getById($objective["priority_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }
?>
