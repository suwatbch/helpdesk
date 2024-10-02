<?php
include_once "../../include/error_message.php";
include_once "../../include/function.php";
include_once "../../include/class/user_session.class.php";
include_once '../../include/class/util/strUtil.class.php';
include_once "../../include/class/util/dateUtil.class.php";
include_once "../../include/class/db/db.php";
include_once "../../include/class/model/working_calendar.class.php";
include_once "../../include/handler/action_handler.php";


$year = $_POST["year"];
$cus_company_id = $_POST["cus_comp_id"];
$arr_working = $_POST["standard_working"];
$arr_holiday = $_POST["holiday"];
$arr_spe_working = $_POST["special_working"];

//echo $year;
//print_r($arr_working);
//echo $year."\n".$cus_company_id."\n"; //.print_r($arr_working)."\n\n".print_r($arr_holiday)."\n\n".print_r($arr_spe_working);
//echo print_r($arr_working);
if (strUtil::isNotEmpty($cus_company_id) && strUtil::isNotEmpty($year)){
    global $result1,$result2,$result3,$db,$working_calendar;
    $working_calendar = new working_calendar($db);
    $user_id = user_session::get_user_id();
    
    /*=============== Standard Working ==============*/
//    echo "standard";
    $standard = array(
        "year"=> $year,
        "cus_comp_id"=> $cus_company_id,
        "sun"=>$arr_working[0],
        "mon"=>$arr_working[1],
        "tue"=>$arr_working[2],
        "wed"=>$arr_working[3],
        "thu"=>$arr_working[4],
        "fri"=>$arr_working[5],
        "sat"=>$arr_working[6],
        "flag_work" => $arr_working[7],//flag_work
        "time1_fr" =>$arr_working[8],
        "time1_to" =>$arr_working[9],
        "time2_fr" =>$arr_working[10],
        "time2_to" =>$arr_working[11],
        "time3_fr" =>$arr_working[12],
        "time3_to" =>$arr_working[13],
        "deduct_pending" =>$arr_working[14], 
        "user_id" => $user_id
    );
//    echo print_r($standard);
    $exists_std = check_exists_standard_work($year,$cus_company_id);
    if ($exists_std != 0){
       $result1 = $working_calendar->update_StandardWork($standard);
   }else {
       $result1 = $working_calendar->insert_StandardWork($standard);
   }
   
   
   /*=============== Holiday ==============*/
   //delete holiday
   $result2 = $working_calendar->delete_Holiday($year,$cus_company_id);
   if ($arr_holiday){
       foreach ($arr_holiday as $value) {
           $result2 = $working_calendar->insert_Holiday($year, $cus_company_id, $value, $user_id);
       }
   }
   
   
   
   /*=============== Special Working ==============*/
   $result3 = $working_calendar->delete_SpecialWorking($year,$cus_company_id);
   if ($arr_spe_working){
       for($index=1; $index < count($arr_spe_working); $index++){// 0 : table's header
           $special = array(
               "cus_comp_id" => $cus_company_id,
               "year" => $year,
               "date" => $arr_spe_working[$index][0],
               "time1_fr" => $arr_spe_working[$index][1],
               "time1_to" => $arr_spe_working[$index][2],
               "time2_fr" => $arr_spe_working[$index][3],
               "time2_to" => $arr_spe_working[$index][4],
               "time3_fr" => $arr_spe_working[$index][5],
               "time3_to" => $arr_spe_working[$index][6],
               "user_id" => $user_id
           );
           
           $result3 = $working_calendar->insert_SpecialWorking($special);
       }
   }
   
   if ($result1 && $result2 && $result3){
       echo "S";
   }else{
       echo "E";
   }
//   echo $result;
}

function check_exists_standard_work($year,$cus_company_id){
//    existsStandardWork
   global $db, $working_calendar ;
       
//   $working_calendar = new working_calendar($db);
   return $working_calendar->existsStandardWork($year,$cus_company_id);
}







   
?>
