<?php

    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/change_log.class.php";
    include_once "../../include/handler/action_handler.php";
    
    
    function unspecified() {
        search();
    }   
    
    function search(){
        global $db, $obj_chage_log, $objective, $objectives, $total_row;

        $obj_chage_log = new change_log($db);
        $cratiria = array("user_id" => user_session::get_sale_id());

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $objective = $obj_chage_log->search($cratiria, $page);

        $total_row = $objective["total_row"];
        $objectives =  $objective["data"];
    }
    
?>
