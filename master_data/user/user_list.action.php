<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/user.class.php";
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

        $objective = $_GET["user_id"];
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new user($db);
            $result = $p->delete($objective);

            $db->end_transaction($result);
        }

        unspecified();
    }
    function restore(){
        global $db;

        $objective = $_GET["user_id"];
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new user($db);
            $result = $p->restore_master($objective);

            $db->end_transaction($result);
        }

        unspecified();
    }

    function search(){
        global $db, $total_row, $s_user;

        $p = new user($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $users = $p->search($cratiria, $page);

        $total_row = $users["total_row"];
        $s_user = $users["data"];
    }
?>
