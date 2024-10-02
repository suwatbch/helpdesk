<?php

include_once "../../include/error_message.php";
include_once "../../include/function.php";
include_once "../../include/class/user_session.class.php";
include_once '../../include/class/util/strUtil.class.php';
include_once "../../include/class/util/dateUtil.class.php";
include_once "../../include/class/db/db.php";
include_once "../../include/class/model/sla_email_alert.class.php";
include_once "../../include/handler/action_handler.php";

$head = $_POST["head"];

$comp_id = $head[0];
$org_id = $head[1];
$group_id = ($head[2] == "") ? 0:$head[2] ;
$sub_group_id = ($head[3] == "") ? 0:$head[3] ;
$arr_all = array();

if (strUtil::isNotEmpty($comp_id) && strUtil::isNotEmpty($org_id)){
    global $sla_email , $db, $result;
    
    $sla_email = new sla_email($db);
    $result = $sla_email->get_sla($comp_id, $org_id, $group_id, $sub_group_id);
  
//    $arr_all[0] = $result;
    
    echo json_encode($result);
}
?>
