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
        global $db, $dd_company,$dd_year;
	
        $dd_year = dropdown::loadYear($db, "dd_year"," required name=\"dd_year\" description=\"Year\" style=\"width: 80%;\"","");
	$dd_company = dropdown::loadCusCompany($db, "cus_company_id","$dd_required_assig\ $dd_disable1\" required name=\"cus_company_id\" description=\"Customer Company\" style=\"width: 100%;\"", "");
        $db->close();
    }
?>
