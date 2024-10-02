<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_area.class.php";
    include_once "../../include/class/model/helpdesk_zone.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective;

        $cus_area_id = $_REQUEST["cus_area_id"];

        if (strUtil::isNotEmpty($cus_area_id)){
            $p = new helpdesk_area($db);
            $objective = $p->getById($cus_area_id);
        }
    }

    function finalize(){
        global $db, $dd_cus_zone, $objective;
        $dd_cus_zone = dropdown::loadZone($db, "zone_id","required=\"true\" name=\"zone_id\" style=\"width: 100%;\"", $objective["zone_id"]);
        $db->close();

    }

    function save(){
        global $db, $objective;

        # get input
        $objective = array(
            "id" => $_REQUEST["cus_area_id"]
            , "area_cus" => $_REQUEST["area_cus"]
            , "area_cus_name" => $_REQUEST["area_cus_name"]
             , "zone_id" => $_REQUEST["zone_id"]
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );
            # save
            $db->begin_transaction();

            $p = new helpdesk_area($db);

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
