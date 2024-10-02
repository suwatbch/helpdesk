<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_grp_mas.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        search();
    }

    function finalize(){
        global $db;
        $db->close();
    }

    function delete(){
        global $db;

        $objective = $_GET["org_id"];
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new helpdesk_grp_mas($db);
            $result = $p->delete($objective);

            $db->end_transaction($result);
        }

        unspecified();
    }
    function restore(){
        global $db;

        $objective = $_GET["org_id"];
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new helpdesk_grp_mas($db);
            $result = $p->restore_master($objective);

            $db->end_transaction($result);
        }

        unspecified();
    }

    function search(){
        global $db, $total_row, $objective;

        $p = new helpdesk_grp_mas($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $objective = $p->search($cratiria, $page);

        $total_row = $objective["total_row"];
        $objective = $objective["data"];
    }
?>