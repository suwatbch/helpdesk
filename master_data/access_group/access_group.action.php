<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/access_group.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified($access_group_id="") {
        global $db, $access_group, $action_master;
        $action_master = 1;
        if(strUtil::isEmpty($access_group_id)){
        $access_group_id = $_REQUEST["access_group_id"];
        }

        if (strUtil::isNotEmpty($access_group_id)){
            $ag = new access_group($db);
            $access_group = $ag->getById($access_group_id);
        }
    }
    
    function finalize(){
        global $db;
        $db->close();
    }

    function save(){
        global $db, $access_group;

        # get input
        $access_group = array(
            "access_group_id" => $_REQUEST["access_group_id"]
            , "access_group_code" => $_REQUEST["access_group_code"]
            , "access_group_name" => $_REQUEST["access_group_name"]
            , "access_group_status" => $_REQUEST["access_group_status"]
            , "permission" => split(",", $_REQUEST["permission"])
           // , "member" => split(",", $_REQUEST["member"])
            , "created_by" => $_REQUEST["created_by"]
            , "created_date" => dateUtil::date_ymdhms($_REQUEST["created_date"])
            , "modified_by" => $_REQUEST["modified_by"]
            , "modified_date" => dateUtil::date_ymdhms($_REQUEST["modified_date"])
            , "action_by" => user_session::get_sale_id()
            , "action_date" => dateUtil::current_date_time()
        );

        # validate
            $ag = new access_group($db);

            # save
            $db->begin_transaction();

            if (strUtil::isEmpty($access_group["access_group_id"])){
                $result = $ag->insert($access_group);
            } else {
                $result = $ag->update($access_group);
            }

            $db->end_transaction($result);

            if ($result){
                $access_group = $ag->getById($access_group["access_group_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }
    
     function delete_user(){
        global $db;

        $user_id = $_GET["user_id"];
        $access_group_id = $_GET["access_group_id"];
        if (strUtil::isNotEmpty($user_id) && strUtil::isNotEmpty($access_group_id)){
            $db->begin_transaction();

            $p = new access_group($db);
            $result = $p->delete_user($access_group_id,$user_id);

            $db->end_transaction($result);
        }

        unspecified($access_group_id);
    }
    
    function save_user(){
        global $db;
        $s_member = $_REQUEST["sss_member"];
        $access_group_id = $_REQUEST["s_access_group_id"];
        $member = array(
             "member" => split(",", $s_member)
            , "access_group_id" => $access_group_id
            
        );
        
        //if (strUtil::isNotEmpty($member)){		
			
            $db->begin_transaction();

            $p = new access_group($db);
			
            $result = $p->save_user($member);

            $db->end_transaction($result);
        //}

        unspecified($access_group_id);
        
    }

?>
