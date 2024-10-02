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
$arr_on = $_POST["on"];
$arr_over = $_POST["over"];


$comp_id = $head[0];
$org_id = $head[1];
$group_id = ($head[2] == "") ? 0:$head[2] ;
$sub_group_id = ($head[3] == "") ? 0:$head[3] ;
$deduct_pending = $head[4];

//echo "c:$comp_id , org:$org_id, g:$group_id, sg:$sub_group_id, flag:$deduct_pending ";
//echo print_r($arr_over);

if (strUtil::isNotEmpty($comp_id) && strUtil::isNotEmpty($org_id) ){
    global $sla_email , $db;
    
    $arr_all = array(
        "comp_id" => $comp_id,
        "org_id" => $org_id,
        "group_id" => $group_id,
        "sub_group_id" => $sub_group_id,
        "deduct_pending" =>$deduct_pending,
        "on_sla_l1" => ($arr_on[0][0] == "") ? 0 : $arr_on[0][0],
        "on_sla_l1_to" => str_replace(" ", "", $arr_on[0][1]),
        "on_sla_l1_cc" => str_replace(" ", "", $arr_on[0][2]),
        "on_sla_l2" => ($arr_on[1][0] == "") ? 0 : $arr_on[1][0],
        "on_sla_l2_to" => str_replace(" ", "", $arr_on[1][1]),
        "on_sla_l2_cc" => str_replace(" ", "", $arr_on[1][2]),
        "on_sla_l3" => ($arr_on[2][0] == "") ? 0 : $arr_on[2][0],
        "on_sla_l3_to" => str_replace(" ", "", $arr_on[2][1]),
        "on_sla_l3_cc" => str_replace(" ", "", $arr_on[2][2]),
        "over_sla_l1" => ($arr_over[0][0] == "") ? 0 : $arr_over[0][0],
        "over_sla_l1_to" => str_replace(" ", "", $arr_over[0][1]),
        "over_sla_l1_cc" => str_replace(" ", "", $arr_over[0][2]),
        "over_sla_l2" => ($arr_over[1][0] == "") ? 0 : $arr_over[1][0],
        "over_sla_l2_to" => str_replace(" ", "", $arr_over[1][1]),
        "over_sla_l2_cc" => str_replace(" ", "", $arr_over[1][2]),
        "over_sla_l3" => ($arr_over[2][0] == "") ? 0 : $arr_over[2][0],
        "over_sla_l3_to" => str_replace(" ", "", $arr_over[2][1]),
        "over_sla_l3_cc" => str_replace(" ", "", $arr_over[2][2]),
        "user_id" => user_session::get_user_id()
    );
   
    $sla_email = new sla_email($db);
    
    $exists = check_exists($comp_id,$org_id,$group_id, $sub_group_id);
//    echo $exists;
//    exit();
    
    if ($exists != 0){
       $result = $sla_email->update_sla($arr_all);
   }else {
       $result = $sla_email->insert_sla($arr_all);
   }
    echo $result;
    
//   if ($result){
//       echo "S";
//   }else{
//       echo "E";
//   }
    
}


function check_exists($company_id,$org_id,$group_id, $sub_group_id){
   global $db, $sla_email ;
   
   return $sla_email->exists($company_id,$org_id,$group_id, $sub_group_id);
}



?>
