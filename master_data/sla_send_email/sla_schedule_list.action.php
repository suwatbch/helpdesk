<?php
    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/sla_send_email.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db,$send_email,$type_id,$arr_schedule;
        
        $send_email = new send_email($db);
        $type_id = $send_email->getEmailType_id();
        
        $arr_schedule = getSaveData($type_id);        
    }

    function finalize(){
        global $db;
        $db->close();
    }
    
    function getSaveData($type_id){
        global $db,$send_email;
        
        return $send_email->getSchedule($type_id);
        
    }
    
    
    
?>
