<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
	include_once "../../include/class/model/user_other.class.php";
    include_once "../../include/class/model/helpdesk_project.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified($project_id="") {
        global $db, $objective, $member;

        if(strUtil::isEmpty($project_id)){
			$project_id = $_REQUEST["project_id"];
        }

        if (strUtil::isNotEmpty($project_id)){
            $p = new helpdesk_project($db);
			$objective = $p->getById($project_id);
			$member = $p->get_project_member($project_id);
			//print_r($member);
        }

    }

    function finalize(){
  		global $db, $dd_cus_company, $objective;
        $dd_cus_company = dropdown::loadCusCompany($db, "cus_comp_id","required=\"true\" name=\"cus_comp_id\" style=\"width: 100%;\"", $objective["cus_comp_id"]);
        $db->close();
    }

	function save_user(){
		
        global $db;
        $s_member = $_REQUEST["sss_member"];
        $project_id = $_REQUEST["s_project_id"];
        $member = array(
             "member" => split(",", $s_member)
            , "project_id" => $project_id
            
        );
        
        //if (strUtil::isNotEmpty($member)){		
            $db->begin_transaction();
            $p = new helpdesk_project($db);
            $result = $p->save_user($member);
            $db->end_transaction($result);
        //}

        unspecified($project_id);
        
    }
	
	function delete_user(){
        global $db;

        $id = $_GET["id"];
        $project_id = $_REQUEST["s_project_id"];
        if (strUtil::isNotEmpty($id)){
            $db->begin_transaction();

            $p = new helpdesk_project($db);
            $result = $p->delete_user($id);

            $db->end_transaction($result);
        }

        unspecified($project_id);
    }

?>
