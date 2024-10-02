<?php
    $output = array();

    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/access_group.class.php";
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

        $access_group_id = $_GET["access_group_id"];
        if (strUtil::isNotEmpty($access_group_id)){

            $db->begin_transaction();

            $ag = new access_group($db);
            $result = $ag->delete($access_group_id);

            $db->end_transaction($result);
        }

        search();
    }

    function search(){
        global $db, $output;

        $page = strUtil::nvl($_REQUEST["page"], "1");

        $ag = new access_group($db);
        $output = $ag->search($criteria, $page);
    }
?>
