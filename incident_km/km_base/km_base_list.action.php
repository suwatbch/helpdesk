<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_identify_km.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified(){
    global $action_master;
        $action_master = 3;
        search_release_base();
    }

    function search_release_base(){
        global $db, $total_row, $objective, $objective_km, $f_objective;
        $cratiria = array(
            "cus_comp_id" => $_REQUEST["cus_company_id"]
            ,"text_summary" => $_REQUEST["text_summary"]
            ,"ident_type_id" => $_REQUEST["ident_type_id"]
            ,"project_id" => $_REQUEST["project_id"]
            ,"cas_prd_tier_id1" => $_REQUEST["cas_prd_tier_id1"]
            ,"cas_prd_tier_id2" => $_REQUEST["cas_prd_tier_id2"]
            ,"cas_prd_tier_id3" => $_REQUEST["cas_prd_tier_id3"]
            ,"cas_opr_tier_id1" => $_REQUEST["cas_opr_tier_id1"]
            ,"cas_opr_tier_id2" => $_REQUEST["cas_opr_tier_id2"]
            ,"cas_opr_tier_id3" => $_REQUEST["cas_opr_tier_id3"]
            ,"txt_notes" => $_REQUEST["txt_notes"]
        );
        
        $p = new helpdesk_identify_km($db);

        $page = strUtil::nvl($_REQUEST["page"], "1");
        $f_objective = $p->search_release_base($cratiria);
        $objective_km = $f_objective["data_km"];
    }

?>
