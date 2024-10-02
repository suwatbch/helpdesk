<?php

    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php"; 
    include_once "../../include/class/model/helpdesk_company.class.php"; 
    include_once "../../include/class/model/working_calendar.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";
    
    
    function unspecified() {


    }
    
    
     function finalize(){
        global $db, $dd_company, $dd_grp, $dd_org, $dd_subgrp;
	
        $dd_company = dropdown::loadCompany($db, "assign_comp_id","$dd_required_assig\ $dd_disable1\" name=\"assign_comp_id\" description=\"Company\" style=\"width: 100%;\"", $asm["assign_comp_id"]);
	$dd_org = dropdown::select("assign_org_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%\"");
        $dd_grp = dropdown::select("assign_group_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%\"");
        $dd_subgrp = dropdown::select("assign_subgrp_id", "$dd_required_assig\"<option></option>", "style=\"width: 100%\"");
        
        
        
        $db->close();
    }
?>
