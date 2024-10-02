<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_identify_km.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
         global $action_master;
        $action_master = 4;
        search();
    }

    function finalize(){
        global $db;
       // $db->close();
    }

    function delete(){
        global $db;

        $s_km_id = $_GET["km_id"];
        $s_inc_id = $_GET["incident_id"];
        $p = new helpdesk_identify_km($db);
         
        if (strUtil::isNotEmpty($s_inc_id)){
            $db->begin_transaction();
            $result = $p->delete_incident_km($s_inc_id);  
        }else if (strUtil::isNotEmpty($s_km_id)){
            $db->begin_transaction();
            $result = $p->delete_km($s_km_id);  
        }
        $db->end_transaction($result);
        unspecified();
    }
    function restore(){
        global $db;

        $objective = $_GET["cus_area_id"];
        if (strUtil::isNotEmpty($objective)){
            $db->begin_transaction();

            $p = new helpdesk_area($db);
            $result = $p->restore_master($objective);

            $db->end_transaction($result);
        }

        unspecified();
    }

    function search(){
        global $db, $total_row, $objective, $objective_km, $f_objective;

        $p = new helpdesk_identify_km($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $f_objective = $p->search($cratiria, $page);

        $total_row = $f_objective["total_row"];
        $objective = $f_objective["data"];
        $objective_km = $f_objective["data_km"];
    }
 
?>
