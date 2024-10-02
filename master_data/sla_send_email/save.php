<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

include_once "../../include/error_message.php";
include_once "../../include/function.php";
include_once "../../include/class/user_session.class.php";
include_once '../../include/class/util/strUtil.class.php';
include_once "../../include/class/util/dateUtil.class.php";
include_once "../../include/class/db/db.php";
include_once "../../include/class/model/sla_send_email.class.php";
//include_once "../../include/handler/action_handler.php";

$type_id = $_POST["type_id"];
$start_date = $_POST["startdate"];
$schedule = $_POST["schedule"];
$enabled = $_POST["enabled"];
$user_id = $_POST["user_id"];
$latest_run = $_POST["latest_run"];

if (strUtil::isNotEmpty($type_id)){
    global  $db, $send_email;
    
    $send_email = new send_email($db);
    
    $exists = check_exists($type_id);
    
    $arr = array(
        "type_id" => $type_id,
        "start_datetime" => $start_date,
        "schedule" => $schedule,
        "enabled" => $enabled,
        "user_id" => $user_id,
        "latest_run" => $latest_run
    );
    
    if ($exists != 0){
       $result = $send_email->update_schedule($arr);
   }else {
       $result = $send_email->insert_schedule($arr);
   }
    echo $result;
    
}


function check_exists($type_id){
    global  $db, $send_email;
    return $send_email->exists($type_id);
    
}


?>
