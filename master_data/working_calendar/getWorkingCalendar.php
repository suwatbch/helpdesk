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
$cus_comp_id = $_POST["cus_comp_id"];

$arr_all_calendar = array();

if (strUtil::isNotEmpty($cus_comp_id) && strUtil::isNotEmpty($year)){
    global $db,$working_calendar;
    $working_calendar = new working_calendar($db);
    
    /*=============== Standard Working ==============*/
    $standard = getStandardWork($year, $cus_comp_id);
    
     /*=============== Holiday ==============*/
    $holiday = getHoliday($year, $cus_comp_id);
    
    /*=============== Special Working ==============*/
    $special = getSpecialWork($year, $cus_comp_id);
    
    if (count($standard) > 0){
        $arr_all_calendar[0] = $standard;
        
        if (count($holiday) > 0){
            $arr_all_calendar[1] = $holiday;
        }
        
        if (count($special) > 0){
            $arr_all_calendar[2] = $special;
        }
    }
    
   
    
    
    
    
    
    echo json_encode($arr_all_calendar);
}



function getStandardWork($year, $cus_comp_id){
    global $db,$working_calendar;
    
    return $working_calendar->get_StandardWork($year, $cus_comp_id);
}


function getHoliday($year, $cus_comp_id){
    global $db,$working_calendar;
    
    return $working_calendar->get_Holiday($year, $cus_comp_id);
}

function getSpecialWork($year, $cus_comp_id){
    global $db,$working_calendar;
    
    return $working_calendar->get_SpecialWork($year, $cus_comp_id);
}



?>
