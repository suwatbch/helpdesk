<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/customer_company.class.php";
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

        $cus_company_id = $_GET["cus_company_id"];
        if (strUtil::isNotEmpty($cus_company_id)){
            $db->begin_transaction();

            $p = new customer_company($db);
            $result = $p->delete($cus_company_id);

            $db->end_transaction($result);
        }

        unspecified();
    }
    function restore(){
        global $db;

        $cus_company_id = $_GET["cus_company_id"];
        if (strUtil::isNotEmpty($cus_company_id)){
            $db->begin_transaction();

            $p = new customer_company($db);
            $result = $p->restore_master($cus_company_id);

            $db->end_transaction($result);
        }

        unspecified();
    }

    function search(){
        global $db, $total_row, $companys;

        $p = new customer_company($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $companys = $p->search($cratiria, $page);

        $total_row = $companys["total_row"];
        $companys = $companys["data"];
    }
?>
