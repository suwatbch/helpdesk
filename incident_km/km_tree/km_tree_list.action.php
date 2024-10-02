<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_identify_km.class.php"; 
    include_once "../../include/handler/action_handler.php";

    function unspecified(){
        $prd_tier_id1 = $_REQUEST["prd_tier_id1"];
        $prd_tier_id2 = $_REQUEST["prd_tier_id2"];
        $prd_tier_id3 = $_REQUEST["prd_tier_id3"];
        $s_mode = $_REQUEST["s_mode"];
        if(($prd_tier_id1 == "" || $prd_tier_id2 == "" || $prd_tier_id3 == "") && $s_mode != "search" ){
            list_production();
        }else{
            search_release();
        }
    }
    function list_production(){
        global $objective_list,$db;
        $prd_tier_id1 = $_REQUEST["prd_tier_id1"];
        $prd_tier_id2 = $_REQUEST["prd_tier_id2"];
        $prd_tier_id3 = $_REQUEST["prd_tier_id3"];
        
        $p = new helpdesk_identify_km($db);
        $f_objective = $p->list_production($prd_tier_id1,$prd_tier_id2,$prd_tier_id3);
        $objective_list = $f_objective["data_list"];
    } 
    
    function search_release(){
        global $db, $total_row, $objective_km;
        $cratiria = array(
            "cus_comp_id" => $_REQUEST["cus_company_id"]
            ,"prd_tier_id1" => $_REQUEST["prd_tier_id1"]
            ,"prd_tier_id2" => $_REQUEST["prd_tier_id2"]
            ,"prd_tier_id3" => $_REQUEST["prd_tier_id3"]
            ,"s_mode" => $_REQUEST["s_mode"]
            ,"search_key_words" => $_REQUEST["search_key_words"]
        );
        $p = new helpdesk_identify_km($db);
        $f_objective = $p->search_release($cratiria);

        $total_row = $f_objective["total_row"];
        $objective_km = $f_objective["data_km"];
    }
    
    
?>
