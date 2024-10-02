<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/user_other.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $action_master;
        $action_master = 2;
        search();
    }

    function finalize(){
        global $db;
        $db->close();
    }

    function search(){
        global $db, $total_row, $s_user;

        $p = new user_other($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $users = $p->search($cratiria, $page);

        $total_row = $users["total_row"];
        $s_user = $users["data"];
    }
?>
