<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/customer.class.php";
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

        $cus_id = $_GET["cus_id"];
        if (strUtil::isNotEmpty($cus_id)){
            $db->begin_transaction();

            $p = new customer($db);
            $result = $p->delete($cus_id);

            $db->end_transaction($result);
        }

        unspecified();
    }
    function restore(){
        global $db;

        $cus_id = $_GET["cus_id"];
        if (strUtil::isNotEmpty($cus_id)){
            $db->begin_transaction();

            $p = new customer($db);
            $result = $p->restore_master($cus_id);

            $db->end_transaction($result);
        }

        unspecified();
    }

    function search(){
        global $db, $total_row, $s_customer, $criteria, $page;
        
        $criteria = array(
            "search_customer" => trim($_REQUEST["search_customer"])
        );
        $p = new customer($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $customers = $p->search($criteria, $page);

        $total_row = $customers["total_row"];
        $s_customer = $customers["data"];
    }
?>
