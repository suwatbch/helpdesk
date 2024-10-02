<?php
@ini_set('display_errors', '0');
//include_once "../db/db.php"; 
include_once "model.class.php";
include '../util/dateUtil.class.php';
//include_once 'C:/appserv/www/helpdesk/v.1/include/class/util/dateUtil.class.php';

class sla extends model {
    
    public static function cal_sla_days($start, $end, $comp_id, $pending = 'N',$incident_id = 0){
        global $sla,$db ;
        $sla = new sla($db);
        $l =0;
        
        $year = substr($start, 0,4);
        $arr_check = $sla->get_standardtime($year, $comp_id);
        
        
        $start_ymd = new DateTime($start);
        $start_ymd = date_format($start_ymd, "Ymd");
        
        $end_ymd = new DateTime($end);
        $end_ymd = date_format($end_ymd, "Ymd");
        
        if (count($arr_check) > 0){
            foreach ($arr_check as $value) {
                //loop master data for 1 time
                if ($l == 0){
                    $sla_days = 0;
                    $holiday_days = 0;
                    $pending_days = 0;
                    
                    // simple Variables
                    $work_time = $value["working_time_sec"];
                    $gap_time[0] = $value["gap_time_sec_1"];
                    $gap_time[1] = $value["gap_time_sec_2"];

                    //get start time
                    if ($value["working_time_from_1"] != "00:00:00"){
                        $start_time = $value["working_time_from_1"];
                    }
                    //get end time
                    if ($value["working_time_to_3"] != "00:00:00"){
                        $end_time = $value["working_time_to_3"];
                    }elseif ($value["working_time_to_2"] != "00:00:00") {
                        $end_time = $value["working_time_to_2"];
                    }elseif ($value["working_time_to_1"] != "00:00:00") {
                        $end_time = $value["working_time_to_1"];
                    }
                    
                    
                    //--------------------------------------------------------------------------------------------------------------
                    //================================================= START CALCULATE ============================================
                    //--------------------------------------------------------------------------------------------------------------

                        
                    // cal with Holiday and working time
                    if ($value["sla_cal_workdaytime"] == "Y"){
                        
                        // duration between start and end
                        $date_diff = dateUtil::date_diff(substr($start,0,10), substr($end,0,10)); 
                        
                        if ($date_diff != 0){
                            //----------------------- startdate <> enddate --------------------
                            for($i=0 ; $i <= $date_diff ; $i++){
                                if ($i == $date_diff){
                                    $date = date("Y-m-d H:i:s", strtotime($end));
                                }else{
                                    $date = date("Y-m-d H:i:s", strtotime("$start +$i day"));
                                }
                                $date = new DateTime($date);

                                //prepare date,time to calculate
                                $tmp_date_ymd = date_format($date, "Ymd");
                                $tmp_date_full = date_format($date, "Y-m-d");
                                $tmp_time = date_format($date, "H:i:s");
                                $timediff = 0;


                                //------------------------------------------- special working ----------------------------------------------------
                                $spe = $sla->chk_spe_workingday($tmp_date_ymd, $comp_id);
                                if (count($spe) > 0){
                                    $n = 0;
                                    foreach ($spe as $val) {
                                        //set to loop 1 time
                                        if ($n == 0){

                                            //get start time
                                            if ($val["working_time_from_1"] != "00:00:00"){
                                                $start_time_w = $val["working_time_from_1"];
                                            }

                                            //get end time
                                            if ($val["working_time_to_3"] != "00:00:00"){
                                                $end_time_w = $val["working_time_to_3"];
                                            }elseif ($val["working_time_to_2"] != "00:00:00") {
                                                $end_time_w = $val["working_time_to_2"];
                                            }elseif ($val["working_time_to_1"] != "00:00:00") {
                                                $end_time_w = $val["working_time_to_1"];
                                            }

                                            // if day = startdate , enddate : คำนวณตามเวลาของ start และ end
                                            if ($i==0){
                                                if (dateUtil::time2seconds($tmp_time) <= dateUtil::time2seconds($end_time_w)){
                                                    $timediff = dateUtil::TimeDiff($tmp_time,$end_time_w);
                                                }
                                                //deduct gap duration
                                                if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($val["working_time_to_2"])) &&  $val["gap_time_sec_2"] != 0){
                                                    $timediff = $timediff - $gap_time[1];
                                                }else if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($val["working_time_from_3"])) &&  $val["gap_time_sec_2"] != 0){
                                                    //time in gap
                                                    $tmp = split(":",$tmp_time);
                                                    $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                }

                                                //deduct gap duration
                                                if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($val["working_time_to_1"])) &&  $val["gap_time_sec_1"] != 0){
                                                    $timediff = $timediff - $gap_time[0];
                                                }else if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($val["working_time_from_2"])) &&  $val["gap_time_sec_1"] != 0){
                                                    //time in gap
                                                    $tmp = split(":",$tmp_time);
                                                    $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                }
                                            }else if ($i == $date_diff){
                                                if (dateUtil::time2seconds($start_time_w) <= dateUtil::time2seconds($tmp_time)){
                                                    $timediff = dateUtil::TimeDiff($start_time_w,$tmp_time);
                                                }

                                                //deduct gap duration
                                                if ((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($val["working_time_from_3"])) &&  $val["gap_time_sec_2"] != 0){
                                                    $timediff = $timediff - $gap_time[1];
                                                }else if((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($val["working_time_to_2"])) &&  $val["gap_time_sec_2"] != 0){
                                                    //time in gap
                                                    $tmp = split(":",$tmp_time);
                                                    $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                }

                                                //deduct gap duration
                                                if ((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($val["working_time_from_2"])) &&  $val["gap_time_sec_1"] != 0){
                                                    $timediff = $timediff - $gap_time[0];
                                                }else if((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($val["working_time_to_1"])) &&  $val["gap_time_sec_1"] != 0){
                                                    //time in gap
                                                    $tmp = split(":",$tmp_time);
                                                    $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                }

                                            }else { //other : คำนวณแบบเต็มเวลา
                                                $timediff = $val["working_time_sec"];
                                            }

                                            $sla_days += $timediff;

                                        }// end loop 1 time
                                        $n++;
                                    }// end loop special working
                                }else {

                                    // day is not special working day
                                    if ($i== 0){
                                        if (dateUtil::time2seconds($tmp_time) <= dateUtil::time2seconds($end_time)){
                                            $timediff = dateUtil::TimeDiff($tmp_time,$end_time);
                                        }

                                        //deduct gap duration
                                        if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($value["working_time_to_2"])) &&  $gap_time[1] != 0){
                                            $timediff = $timediff - $gap_time[1];
                                        }else if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($value["working_time_from_3"])) &&  $gap_time[1] != 0){
                                            //time in gap
                                            $tmp = split(":",$tmp_time);
                                            $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                        }

                                        //deduct gap duration
                                        if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($value["working_time_to_1"])) &&  $gap_time[0] != 0){
                                            $timediff = $timediff - $gap_time[0];
                                        }else if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($value["working_time_from_2"])) &&  $gap_time[0] != 0){
                                            //time in gap
                                            $tmp = split(":",$tmp_time);
                                            $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                        }
                                    }else if ($i == $date_diff){
                                        if (dateUtil::time2seconds($start_time) <= dateUtil::time2seconds($tmp_time)){
                                            $timediff = dateUtil::TimeDiff($start_time,$tmp_time);
                                        }

                                        //deduct gap duration
                                        if ((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($value["working_time_from_3"])) &&  $gap_time[1] != 0){
                                            $timediff = $timediff - $gap_time[1];
                                        }else if((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($value["working_time_to_2"])) &&  $gap_time[1] != 0){
                                            //time in gap
                                            $tmp = split(":",$tmp_time);
                                            $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                        }

                                        //deduct gap duration
                                        if ((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($value["working_time_from_2"])) &&  $gap_time[0] != 0){
                                            $timediff = $timediff - $gap_time[0];
                                        }else if((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($value["working_time_to_1"])) &&  $gap_time[0] != 0){
                                            //time in gap
                                            $tmp = split(":",$tmp_time);
                                            $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                        }
                                    }else{
                                        $timediff = $work_time;
                                    }







                                    //--------------------------------------------- HOLIDAY -----------------------------------------------
                                    $holiday = $sla->chk_holiday($tmp_date_ymd,$comp_id);
                                    if ($holiday != 0){//day is not Holiday : 
                                        $holiday_days += $timediff;
                                        $sla_days += $timediff;

                                    }else{

                                        //-------------------------------------- Standard working day --------------------------------------
                                        //if it's not holiday
                                        $tmp_date_name = strtolower(date('l', strtotime($tmp_date_full)));
                                        if ($value[$tmp_date_name] == 'Y'){// it is weekday
                                            $sla_days += $timediff;
                                        }



                                    }
                                }
                            }
                            
                        }else {
                            // startdate = enddate
                            $tmp_arr = $sla->cal_sla_samedate($start, $end, $comp_id, "Y", "N");
                            if (count($tmp_arr) > 0){
                                $sla_days = $tmp_arr["sla_days"];
                                $holiday_days = $tmp_arr["holiday"];
                                $pending_days = $tmp_arr["pending"];
                            }
                            
                            
                        }
                            


                       
                    }else{// not calculate with Holiday/weekday/work time
                        $sla_days =  dateUtil::date_diff3($start, $end);
                        $holiday_days = 0;
                        $pending_days = 0;
                    }
                    
                
                    //**********************************************************************************************
                    // --------------------------------------------- PENDING --------------------------------------
                    // check deduct pending from database
                    if ($pending == "Y" && $value["deduct_pending"] == 'Y' && $incident_id != 0 && $date_diff != 0){
                       $arr_pending = $sla->get_pendinglist($incident_id, $start_ymd, $end_ymd);
                       $tmp_work = "";
                       $timediff = 0;
                       
                        if (count($arr_pending) > 0){
                           foreach ($arr_pending as $pend) {
                               $flag_cal = "N"; //flag calculate pending duration
                               $tmp_pending = $pend["workinfo_date"];
                               
                               // check double pending? 
                               //ถ้าเป็น pending ติดๆกัน โดยไม่มี working มาแทรก ให้คิดเฉพาะ pending แรกเท่านั้น
                               //เลยทำการเช็คว่า มี working อันใกล้สุด record เดียวกันหรือเปล่า
                               $arr_tmp = $sla->get_working_latest($pend["workinfo_id"], $incident_id);
                               $lw = 0;
                               foreach ($arr_tmp as $w) {
                                    if ($lw == 0){
                                        if ($tmp_work != $w["workinfo_date"]){
                                            $flag_cal = "Y";
                                            $tmp_work = $w["workinfo_date"];
                                        }
                                    }
                                    $lw++;
                                }
                                
                                
                                //********* CALCULATE LOGIC FOR PENDING STATUS ********
                                // คำนวณ pending duration 
                                //special working   : คำนวณ
                                //วันทำงาน           : คำนวณ
                                //Holiday           : ไม่คำนวณ
                                //วันหยุดทำงาน        : ไม่คำนวณ
                                //******************************************************
                                if ($flag_cal == 'Y'){
                                    if ($value["sla_cal_workdaytime"] == "Y"){
                                        
                                        $date_diff = dateUtil::date_diff(substr($tmp_pending,0,10), substr($tmp_work,0,10));
                                        if ($date_diff != 0){
                                            //------------------ startdate <> enddate ----------------
                                            for ($i=0; $i<= $date_diff ; $i++){
                                                if ($i == $date_diff){
                                                    $pd_date = date("Y-m-d H:i:s", strtotime($tmp_work));
                                                }else{
                                                    $pd_date = date("Y-m-d H:i:s", strtotime("$tmp_pending +$i day"));
                                                }
                                                $pd_date = new DateTime($pd_date);

                                                //prepare date,time to calculate
                                                $tmp_date_ymd = date_format($pd_date, "Ymd");
                                                $tmp_date_full = date_format($pd_date, "Y-m-d");
                                                $tmp_time = date_format($pd_date, "H:i:s");
                                                $timediff = 0;

                                                //------------------------------------------- special working ----------------------------------------------------
                                                $spe = $sla->chk_spe_workingday($tmp_date_ymd, $comp_id);
                                                if (count($spe) > 0){
                                                    $n = 0;
                                                    foreach ($spe as $val) {
                                                        //set to loop 1 time
                                                        if ($n == 0){

                                                            //get start time
                                                            if ($val["working_time_from_1"] != "00:00:00"){
                                                                $start_time_w = $val["working_time_from_1"];
                                                            }

                                                            //get end time
                                                            if ($val["working_time_to_3"] != "00:00:00"){
                                                                $end_time_w = $val["working_time_to_3"];
                                                            }elseif ($val["working_time_to_2"] != "00:00:00") {
                                                                $end_time_w = $val["working_time_to_2"];
                                                            }elseif ($val["working_time_to_1"] != "00:00:00") {
                                                                $end_time_w = $val["working_time_to_1"];
                                                            }

                                                            // if day = startdate , enddate : คำนวณตามเวลาของ start และ end
                                                            if ($i==0){
                                                                if (dateUtil::time2seconds($tmp_time) <= dateUtil::time2seconds($end_time_w)){
                                                                    $timediff = dateUtil::TimeDiff($tmp_time,$end_time_w);
                                                                }
                                                                //deduct gap duration
                                                                if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($val["working_time_to_2"])) &&  $val["gap_time_sec_2"] != 0){
                                                                    $timediff = $timediff - $gap_time[1];
                                                                }else if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($val["working_time_from_3"])) &&  $val["gap_time_sec_2"] != 0){
                                                                    //time in gap
                                                                    $tmp = split(":",$tmp_time);
                                                                    $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                                }

                                                                //deduct gap duration
                                                                if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($val["working_time_to_1"])) &&  $val["gap_time_sec_1"] != 0){
                                                                    $timediff = $timediff - $gap_time[0];
                                                                }else if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($val["working_time_from_2"])) &&  $val["gap_time_sec_1"] != 0){
                                                                    //time in gap
                                                                    $tmp = split(":",$tmp_time);
                                                                    $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                                }
                                                            }else if ($i == $date_diff){
                                                                if (dateUtil::time2seconds($start_time_w) <= dateUtil::time2seconds($tmp_time)){
                                                                    $timediff = dateUtil::TimeDiff($start_time_w,$tmp_time);
                                                                }

                                                                //deduct gap duration
                                                                if ((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($val["working_time_from_3"])) &&  $val["gap_time_sec_2"] != 0){
                                                                    $timediff = $timediff - $gap_time[1];
                                                                }else if((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($val["working_time_to_2"])) &&  $val["gap_time_sec_2"] != 0){
                                                                    //time in gap
                                                                    $tmp = split(":",$tmp_time);
                                                                    $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                                }

                                                                //deduct gap duration
                                                                if ((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($val["working_time_from_2"])) &&  $val["gap_time_sec_1"] != 0){
                                                                    $timediff = $timediff - $gap_time[0];
                                                                }else if((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($val["working_time_to_1"])) &&  $val["gap_time_sec_1"] != 0){
                                                                    //time in gap
                                                                    $tmp = split(":",$tmp_time);
                                                                    $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                                }

                                                            }else { //other : คำนวณแบบเต็มเวลา
                                                                $timediff = $val["working_time_sec"];
                                                            }

                                                            $pending_days += $timediff;

                                                        }// end loop 1 time
                                                        $n++;
                                                    }// end loop special working
                                                }else {

                                                    // day is not special working day
                                                    if ($i== 0){
                                                        if (dateUtil::time2seconds($tmp_time) <= dateUtil::time2seconds($end_time)){
                                                            $timediff = dateUtil::TimeDiff($tmp_time,$end_time);
                                                        }

                                                        //deduct gap duration
                                                        if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($value["working_time_to_2"])) &&  $gap_time[1] != 0){
                                                            $timediff = $timediff - $gap_time[1];
                                                        }else if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($value["working_time_from_3"])) &&  $gap_time[1] != 0){
                                                            //time in gap
                                                            $tmp = split(":",$tmp_time);
                                                            $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                        }

                                                        //deduct gap duration
                                                        if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($value["working_time_to_1"])) &&  $gap_time[0] != 0){
                                                            $timediff = $timediff - $gap_time[0];
                                                        }else if ((dateUtil::time2seconds($tmp_time) < dateUtil::time2seconds($value["working_time_from_2"])) &&  $gap_time[0] != 0){
                                                            //time in gap
                                                            $tmp = split(":",$tmp_time);
                                                            $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                        }
                                                    }else if ($i == $date_diff){
                                                        if (dateUtil::time2seconds($start_time) <= dateUtil::time2seconds($tmp_time)){
                                                            $timediff = dateUtil::TimeDiff($start_time,$tmp_time);
                                                        }

                                                        //deduct gap duration
                                                        if ((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($value["working_time_from_3"])) &&  $gap_time[1] != 0){
                                                            $timediff = $timediff - $gap_time[1];
                                                        }else if((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($value["working_time_to_2"])) &&  $gap_time[1] != 0){
                                                            //time in gap
                                                            $tmp = split(":",$tmp_time);
                                                            $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                        }

                                                        //deduct gap duration
                                                        if ((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($value["working_time_from_2"])) &&  $gap_time[0] != 0){
                                                            $timediff = $timediff - $gap_time[0];
                                                        }else if((dateUtil::time2seconds($tmp_time) > dateUtil::time2seconds($value["working_time_to_1"])) &&  $gap_time[0] != 0){
                                                            //time in gap
                                                            $tmp = split(":",$tmp_time);
                                                            $timediff = $timediff - ($tmp[1]*60) - $tmp[2];//timediff - minutes - secs
                                                        }
                                                    }else{
                                                        $timediff = $work_time;
                                                    }

                                                        //-------------------------------------- Standard working day --------------------------------------
                                                        $tmp_date_name = strtolower(date('l', strtotime($tmp_date_full)));
                                                        if ($value[$tmp_date_name] == 'Y'){// it is weekday
                                                            $pending_days += $timediff;
                                                        }
                                                }


                                            }
                                        }
                                            
                                        
                                    }else{
                                        // deduct pending & not cal with holiday/work time
                                        $pending_days +=  dateUtil::date_diff3($tmp_pending, $tmp_work);
                                    }
                                }
                           }
                       }
                    }elseif ($date_diff == 0) {
                         // --------- startdate = enddate
                        $tmp_arr = $sla->cal_sla_samedate($start, $end, $comp_id, "Y", "Y", $incident_id);
                        if (count($tmp_arr) > 0){
                            $sla_days = $tmp_arr["sla_days"];
                            $holiday_days = $tmp_arr["holiday"];
                            $pending_days = $tmp_arr["pending"];
                        }
                        
                    }
                        
                //--------------------------------------------------------------------------------------------------------------
                //================================================= END CALCULATE ============================================
                //--------------------------------------------------------------------------------------------------------------
        
                        
                    
                }
                    $l++; 
            }
        }else{ // no master data
            $sla_days =  dateUtil::date_diff3($start, $end);
            $holiday_days = 0;
            $pending_days = 0;
        }
        
        
        $arr = array(
            "sla_days" => $sla_days,
            "holiday" => $holiday_days,
            "pending" => $pending_days
        ) ;
        return $arr;        
//        
////          $arr = array(
////            "sla_days" => 555,
////            "holiday" => 55,
////            "pending" => 5
////        ) ;  

        
    }
    
    
    
    
    
    
    
    public function chk_holiday($date,$comp_id){//YYYYMMDD
        $sql = "SELECT 1 
            FROM helpdesk_spec_holiday_calendar
            WHERE DATE( spec_date ) =  '$date' and cus_comp_id = '$comp_id'";
        
        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0; //seconds : 24 Hrs.
        }else {
            return $total_row;
        }
    }
    
    
    public function chk_spe_workingday($date,$comp_id){
        $sql = "select spec_year , spec_date 
            ,working_time_from_1,working_time_to_1 , TIMEDIFF(working_time_to_1,working_time_from_1) as time1
            ,working_time_from_2,working_time_to_2 , TIMEDIFF(working_time_to_2,working_time_from_2) as time2
            ,working_time_from_3,working_time_to_3 , TIMEDIFF(working_time_to_3,working_time_from_3) as time3
            ,ADDTIME( ADDTIME( TIMEDIFF( working_time_to_1, working_time_from_1 ) , TIMEDIFF( working_time_to_2, working_time_from_2 ) ) 
                      , TIMEDIFF( working_time_to_3, working_time_from_3 ) ) AS working_time
            ,TIME_TO_SEC( ADDTIME( ADDTIME( TIMEDIFF( working_time_to_1, working_time_from_1 ) , TIMEDIFF( working_time_to_2, working_time_from_2 ) ) 
                      , TIMEDIFF( working_time_to_3, working_time_from_3 ) ) ) as working_time_sec
            ,case when working_time_to_1 <> '00:00:00' and working_time_from_2 <> '00:00:00' then TIMEDIFF(working_time_from_2,working_time_to_1)
                  else '00:00:00' end as gap_time_1
            ,case when working_time_to_2 <> '00:00:00' and working_time_from_3 <> '00:00:00' then TIMEDIFF(working_time_from_3,working_time_to_2)
                  else '00:00:00' end as gap_time_2  
            ,case when working_time_to_1 <> '00:00:00' and working_time_from_2 <> '00:00:00' then TIME_TO_SEC(TIMEDIFF(working_time_from_2,working_time_to_1))
                  else '0' end as gap_time_sec_1
            ,case when working_time_to_2 <> '00:00:00' and working_time_from_3 <> '00:00:00' then TIME_TO_SEC(TIMEDIFF(working_time_from_3,working_time_to_2))
                  else '0' end as gap_time_sec_2  
            ,case when working_time_from_2 = '00:00:00' then '00:00:00'
                  when working_time_from_3 = '00:00:00' then TIMEDIFF(working_time_from_2,working_time_to_1)
                  else ADDTIME(TIMEDIFF(working_time_from_2,working_time_to_1),TIMEDIFF(working_time_from_3,working_time_to_2)) end as gap_time
            ,case when working_time_from_2 = '00:00:00' then '0'
                  when working_time_from_3 = '00:00:00' then TIME_TO_SEC(TIMEDIFF(working_time_from_2,working_time_to_1))
                  else TIME_TO_SEC(ADDTIME(TIMEDIFF(working_time_from_2,working_time_to_1),TIMEDIFF(working_time_from_3,working_time_to_2))) end as gap_time_sec
            from helpdesk_spec_working_day where DATE(spec_date) = '$date' and cus_comp_id = '$comp_id' ";
        
        $result = $this->db->query($sql);
        $rows = $this->db->num_rows($result);
        
        if ($rows == 0) return null;

        while($row = $this->db->fetch_array($result)){
            $arr[] = $row;
        }

        return $arr;
    }
    
    
    public function get_standardtime($year, $comp_id){
        $sql = "select working_year , sla_cal_workdaytime, deduct_pending ,sunday,monday,tuesday,wednesday,thursday,friday,saturday
            ,working_time_from_1,working_time_to_1 , TIMEDIFF(working_time_to_1,working_time_from_1) as time1
            ,working_time_from_2,working_time_to_2 , TIMEDIFF(working_time_to_2,working_time_from_2) as time2
            ,working_time_from_3,working_time_to_3 , TIMEDIFF(working_time_to_3,working_time_from_3) as time3
            ,ADDTIME( ADDTIME( TIMEDIFF( working_time_to_1, working_time_from_1 ) , TIMEDIFF( working_time_to_2, working_time_from_2 ) ) 
                      , TIMEDIFF( working_time_to_3, working_time_from_3 ) ) AS working_time
            ,TIME_TO_SEC( ADDTIME( ADDTIME( TIMEDIFF( working_time_to_1, working_time_from_1 ) , TIMEDIFF( working_time_to_2, working_time_from_2 ) ) 
                      , TIMEDIFF( working_time_to_3, working_time_from_3 ) ) ) as working_time_sec
            ,case when working_time_to_1 <> '00:00:00' and working_time_from_2 <> '00:00:00' then TIMEDIFF(working_time_from_2,working_time_to_1)
                  else '00:00:00' end as gap_time_1
            ,case when working_time_to_2 <> '00:00:00' and working_time_from_3 <> '00:00:00' then TIMEDIFF(working_time_from_3,working_time_to_2)
                  else '00:00:00' end as gap_time_2  
            ,case when working_time_to_1 <> '00:00:00' and working_time_from_2 <> '00:00:00' then TIME_TO_SEC(TIMEDIFF(working_time_from_2,working_time_to_1))
                  else '0' end as gap_time_sec_1
            ,case when working_time_to_2 <> '00:00:00' and working_time_from_3 <> '00:00:00' then TIME_TO_SEC(TIMEDIFF(working_time_from_3,working_time_to_2))
                  else '0' end as gap_time_sec_2  
            ,case when working_time_from_2 = '00:00:00' then '00:00:00'
                  when working_time_from_3 = '00:00:00' then TIMEDIFF(working_time_from_2,working_time_to_1)
                  else ADDTIME(TIMEDIFF(working_time_from_2,working_time_to_1),TIMEDIFF(working_time_from_3,working_time_to_2)) end as gap_time
            ,case when working_time_from_2 = '00:00:00' then '0'
                  when working_time_from_3 = '00:00:00' then TIME_TO_SEC(TIMEDIFF(working_time_from_2,working_time_to_1))
                  else TIME_TO_SEC(ADDTIME(TIMEDIFF(working_time_from_2,working_time_to_1),TIMEDIFF(working_time_from_3,working_time_to_2))) end as gap_time_sec
            from helpdesk_std_working_calendar where working_year = '$year' and cus_comp_id = '$comp_id' ";
        
        $result = $this->db->query($sql);
        $rows = $this->db->num_rows($result);
        
        if ($rows == 0) return null;

        while($row = $this->db->fetch_array($result)){
            $arr[] = $row;
        }

        return $arr;
        
//        return $sql;
        
        
    }
    
    
    public function get_pendinglist($id,$start,$end){
        $sql = "SELECT * FROM helpdesk_tr_workinfo 
                WHERE incident_id = $id
                and workinfo_status_id = 4
                and DATE(workinfo_date) between '$start' and '$end'
                order by workinfo_date ";
        
        $result = $this->db->query($sql);
        $rows = $this->db->num_rows($result);
        
        if ($rows == 0) return null;

        while($row = $this->db->fetch_array($result)){
            $arr[] = $row;
        }

        return $arr;
        
    }
    
    public function get_working_latest($id,$incident_id){
        $sql = "SELECT * FROM helpdesk_tr_workinfo 
                WHERE incident_id = $incident_id
                and workinfo_status_id = 3
                and workinfo_id > $id
                order by workinfo_date LIMIT 1";
        
        $result = $this->db->query($sql);
        $rows = $this->db->num_rows($result);
        
        if ($rows == 0) return null;

        while($row = $this->db->fetch_array($result)){
            $arr[] = $row;
        }

        return $arr;
    }
    
    
    public function cal_sla_samedate($start,$end,$comp_id,$flag_time = "N",$flag_pending = 'N',$incident_id = 0){//$date : YYYY-mm-dd
         global $sla,$db ;
        $sla = new sla($db);
        $l =0;
        
        $year = substr($start, 0,4);
        $arr_check = $sla->get_standardtime($year, $comp_id);
        
        $sec_end=0; $sec_start = 0;
        $sla_days = 0;
        $holiday_days = 0;
        $pending_days = 0;
                    
                    
        
        if (count($arr_check) > 0){
            foreach ($arr_check as $value) {
                //loop master data for 1 time
                if ($l == 0){
                    
                    //get start time
                    if ($value["working_time_from_1"] != "00:00:00"){
                        $start_time_m = $value["working_time_from_1"];
                    }
                    //get end time
                    if ($value["working_time_to_3"] != "00:00:00"){
                        $end_time_m = $value["working_time_to_3"];
                    }elseif ($value["working_time_to_2"] != "00:00:00") {
                        $end_time_m = $value["working_time_to_2"];
                    }elseif ($value["working_time_to_1"] != "00:00:00") {
                        $end_time_m = $value["working_time_to_1"];
                    }
                    
                    $tmp_start = new DateTime($start);
                    $start_date = date_format($tmp_start, "Ymd");
                    $start_time = date_format($tmp_start, "H:i:s");

                    $tmp_end  = new DateTime($end);
                    $end_date = date_format($tmp_end, "Ymd");
                    $end_time = date_format($tmp_end, "H:i:s");
                    
                    $tmp_date_full = date_format($tmp_end, "Y-m-d");
            
                    $gap_time[0] = $value["gap_time_sec_1"];
                    $gap_time[1] = $value["gap_time_sec_2"];

                    if ($flag_time == 'Y'){

                        /********************************** Special Working date **********************************/
                        $spe = $sla->chk_spe_workingday($start_date, $comp_id);
                        if (count($spe) > 0){
                            $sec_start = dateUtil::time2seconds($start_time);
                            $sec_end = dateUtil::time2seconds($end_time); 
                            $sec_gap = 0;
                            
                            foreach ($spe as $val) {
                                
                                $gap_time[0] = $val["gap_time_sec_1"];
                                $gap_time[1] = $val["gap_time_sec_2"];
                    
                                //get start time
                                if ($val["working_time_from_1"] != "00:00:00"){
                                    $start_time_w = $val["working_time_from_1"];
                                }

                                //get end time
                                if ($val["working_time_to_3"] != "00:00:00"){
                                    $end_time_w = $val["working_time_to_3"];
                                }elseif ($val["working_time_to_2"] != "00:00:00") {
                                    $end_time_w = $val["working_time_to_2"];
                                }elseif ($val["working_time_to_1"] != "00:00:00") {
                                    $end_time_w = $val["working_time_to_1"];
                                }

                            }

                            // cal with below cases
                            //               START------------------------END                 //standard
                            //          s---------------e
                            //                      s-----------------e
                            //                              s-----------------------e
                            //         s-----------------------------------------e
                            if ($sec_start <= dateUtil::time2seconds($start_time_w)){
                                $sec_start = dateUtil::time2seconds($start_time_w);
                            }

                            if ($sec_end >= dateUtil::time2seconds($end_time_w)){
                                $sec_end = dateUtil::time2seconds($end_time_w);
                            }
                            
                            
                            // starttime in gap >> reset to start+end point
                            if ($sec_start > dateUtil::time2seconds($val["working_time_to_1"]) && 
                                    $sec_start < dateUtil::time2seconds($val["working_time_from_2"])){
                                $sec_start = dateUtil::time2seconds($val["working_time_from_2"]);
                            }
                            
                            if ($sec_start > dateUtil::time2seconds($val["working_time_to_2"]) && 
                                    $sec_start < dateUtil::time2seconds($val["working_time_from_3"])){
                                $sec_start = dateUtil::time2seconds($val["working_time_from_3"]);
                            }
                            
                            
                            // endtime in gap >> reset to start+end point
                            if ($sec_end > dateUtil::time2seconds($val["working_time_to_1"]) && 
                                    $sec_end < dateUtil::time2seconds($val["working_time_from_2"])){
                                $sec_end = dateUtil::time2seconds($val["working_time_to_1"]);
                            }
                            
                            if ($sec_end > dateUtil::time2seconds($val["working_time_to_2"]) && 
                                    $sec_end < dateUtil::time2seconds($val["working_time_from_3"])){
                                $sec_end = dateUtil::time2seconds($val["working_time_to_2"]);
                            }
                            
                            // deduct gap duration
                            if ($sec_start <= dateUtil::time2seconds($val["working_time_to_1"])){
                                if ($sec_end >= dateUtil::time2seconds($val["working_time_from_2"])){
                                    $sec_gap += $gap_time[0];                                        
                                }
                                
                                if ($sec_end >= dateUtil::time2seconds($val["working_time_from_3"])){
                                    $sec_gap += $gap_time[1] ;                                        
                                }
                                
                            }else if ($sec_start <= dateUtil::time2seconds($val["working_time_to_2"])){
                                if ($sec_end >= dateUtil::time2seconds($val["working_time_from_3"])){
                                    $sec_gap += $gap_time[1] ;                                        
                                }
                            }
                            
                            $sla_days += ($sec_end - $sec_start - $sec_gap);
                        }else{
                            $sec_gap = 0;
                            $sec_start = dateUtil::time2seconds($start_time);
                            $sec_end = dateUtil::time2seconds($end_time); 
                            
                            if ($sec_start <= dateUtil::time2seconds($start_time_m)){
                                $sec_start = dateUtil::time2seconds($start_time_m);
                            }

                            if ($sec_end >= dateUtil::time2seconds($end_time_m)){
                                $sec_end = dateUtil::time2seconds($end_time_m);
                            }
                            
                            
                            
                            // starttime in gap >> reset to start+end point
                            if ($sec_start > dateUtil::time2seconds($value["working_time_to_1"]) && 
                                    $sec_start < dateUtil::time2seconds($value["working_time_from_2"])){
                                $sec_start = dateUtil::time2seconds($value["working_time_from_2"]);
                            }
                            
                            if ($sec_start > dateUtil::time2seconds($value["working_time_to_2"]) && 
                                    $sec_start < dateUtil::time2seconds($value["working_time_from_3"])){
                                $sec_start = dateUtil::time2seconds($value["working_time_from_3"]);
                            }
                            
                            
                            // endtime in gap >> reset to start+end point
                            if ($sec_end > dateUtil::time2seconds($value["working_time_to_1"]) && 
                                    $sec_end < dateUtil::time2seconds($value["working_time_from_2"])){
                                $sec_end = dateUtil::time2seconds($value["working_time_to_1"]);
                            }
                            
                            if ($sec_end > dateUtil::time2seconds($value["working_time_to_2"]) && 
                                    $sec_end < dateUtil::time2seconds($value["working_time_from_3"])){
                                $sec_end = dateUtil::time2seconds($value["working_time_to_2"]);
                            }
                            
                            // deduct gap duration
                            if ($sec_start <= dateUtil::time2seconds($value["working_time_to_1"])){
                                if ($sec_end >= dateUtil::time2seconds($value["working_time_from_2"])){
                                    $sec_gap += $gap_time[0];                                        
                                }
                                
                                if ($sec_end >= dateUtil::time2seconds($value["working_time_from_3"])){
                                    $sec_gap += $gap_time[1] ;                                        
                                }
                                
                            }else if ($sec_start <= dateUtil::time2seconds($value["working_time_to_2"])){
                                if ($sec_end >= dateUtil::time2seconds($value["working_time_from_3"])){
                                    $sec_gap += $gap_time[1] ;                                        
                                }
                            }
                            
                            
                            


                            //--------------------------------------------- HOLIDAY -----------------------------------------------
                            $holiday = $sla->chk_holiday($start_date,$comp_id);
                            if ($holiday != 0){//day is Holiday : 
                                $holiday_days += ($sec_end - $sec_start - $sec_gap);
                                $sla_days += ($sec_end - $sec_start - $sec_gap);

                            }else{

                                //-------------------------------------- Standard working day --------------------------------------
                                //if it's not holiday
                                $tmp_date_name = strtolower(date('l', strtotime($tmp_date_full)));
                                if ($value[$tmp_date_name] == 'Y'){// it is weekday
                                    $sla_days += ($sec_end - $sec_start - $sec_gap);
                                }
                            }
                        }


                    }


                    if ($flag_pending == 'Y'){
                        $arr_pending = $sla->get_pendinglist($incident_id, substr($start,0,10), substr($end,0,10));
                        $tmp_work = "";
                        if (count($arr_pending) > 0){
                           foreach ($arr_pending as $pend) {
                               $flag_cal = "N"; //flag calculate pending duration
                               $tmp_pending = $pend["workinfo_date"];
                               
                               // check double pending? 
                               //ถ้าเป็น pending ติดๆกัน โดยไม่มี working มาแทรก ให้คิดเฉพาะ pending แรกเท่านั้น
                               //เลยทำการเช็คว่า มี working อันใกล้สุด record เดียวกันหรือเปล่า
                               $arr_tmp = $sla->get_working_latest($pend["workinfo_id"], $incident_id);
                               $lw = 0;
                               foreach ($arr_tmp as $w) {
                                    if ($lw == 0){
                                        if ($tmp_work != $w["workinfo_date"]){
                                            $flag_cal = "Y";
                                            $tmp_work = $w["workinfo_date"];
                                        }
                                    }
                                    $lw++;
                                }
                                
                                
                                $sec_start = new DateTime($tmp_pending);
                                $sec_start = date_format($sec_start, "H:i:s");
                                $sec_start = dateUtil::time2seconds($sec_start);
                                
                                
                                $sec_end = new DateTime($tmp_work);
                                $sec_end = date_format($sec_end, "H:i:s");
                                $sec_end = dateUtil::time2seconds($sec_end);
                                
                                //********* CALCULATE LOGIC FOR PENDING STATUS ********
                                // คำนวณ pending duration 
                                //special working   : คำนวณ
                                //วันทำงาน           : คำนวณ
                                //Holiday           : ไม่คำนวณ
                                //วันหยุดทำงาน        : ไม่คำนวณ
                                //******************************************************
                                if ($flag_cal == 'Y'){
                                    /********************************** Special Working date **********************************/
                                    $spe = $sla->chk_spe_workingday($tmp_pending, $comp_id);
                                    if (count($spe) > 0){
                                        
                                        $sec_start = dateUtil::time2seconds($start_time);
                                        $sec_end = dateUtil::time2seconds($end_time); 
                                        $sec_gap = 0;

                                        foreach ($spe as $val) {

                                            $gap_time[0] = $val["gap_time_sec_1"];
                                            $gap_time[1] = $val["gap_time_sec_2"];
                                            //get start time
                                            if ($val["working_time_from_1"] != "00:00:00"){
                                                $start_time_w = $val["working_time_from_1"];
                                            }

                                            //get end time
                                            if ($val["working_time_to_3"] != "00:00:00"){
                                                $end_time_w = $val["working_time_to_3"];
                                            }elseif ($val["working_time_to_2"] != "00:00:00") {
                                                $end_time_w = $val["working_time_to_2"];
                                            }elseif ($val["working_time_to_1"] != "00:00:00") {
                                                $end_time_w = $val["working_time_to_1"];
                                            }

                                        }

                                        // cal with below cases
                                        //               START------------------------END                 //standard
                                        //          s---------------e
                                        //                      s-----------------e
                                        //                              s-----------------------e
                                        //         s-----------------------------------------e
                                        if ($sec_start <= dateUtil::time2seconds($start_time_w)){
                                            $sec_start = dateUtil::time2seconds($start_time_w);
                                        }

                                        if ($sec_end >= dateUtil::time2seconds($end_time_w)){
                                            $sec_end = dateUtil::time2seconds($end_time_w);
                                        }

                                        // starttime in gap >> reset to start+end point
                                        if ($sec_start > dateUtil::time2seconds($val["working_time_to_1"]) && 
                                                $sec_start < dateUtil::time2seconds($val["working_time_from_2"])){
                                            $sec_start = dateUtil::time2seconds($val["working_time_from_2"]);
                                        }

                                        if ($sec_start > dateUtil::time2seconds($val["working_time_to_2"]) && 
                                                $sec_start < dateUtil::time2seconds($val["working_time_from_3"])){
                                            $sec_start = dateUtil::time2seconds($val["working_time_from_3"]);
                                        }


                                        // endtime in gap >> reset to start+end point
                                        if ($sec_end > dateUtil::time2seconds($val["working_time_to_1"]) && 
                                                $sec_end < dateUtil::time2seconds($val["working_time_from_2"])){
                                            $sec_end = dateUtil::time2seconds($val["working_time_to_1"]);
                                        }

                                        if ($sec_end > dateUtil::time2seconds($val["working_time_to_2"]) && 
                                                $sec_end < dateUtil::time2seconds($val["working_time_from_3"])){
                                            $sec_end = dateUtil::time2seconds($val["working_time_to_2"]);
                                        }

                                        // deduct gap duration
                                        if ($sec_start <= dateUtil::time2seconds($val["working_time_to_1"])){
                                            if ($sec_end >= dateUtil::time2seconds($val["working_time_from_2"])){
                                                $sec_gap += $gap_time[0];                                        
                                            }

                                            if ($sec_end >= dateUtil::time2seconds($val["working_time_from_3"])){
                                                $sec_gap += $gap_time[1] ;                                        
                                            }

                                        }else if ($sec_start <= dateUtil::time2seconds($val["working_time_to_2"])){
                                            if ($sec_end >= dateUtil::time2seconds($val["working_time_from_3"])){
                                                $sec_gap += $gap_time[1] ;                                        
                                            }
                                        }
                                        
                                        $pending_days += ($sec_end - $sec_start - $sec_gap);
                                        
                                    }else{

//                                      
                                        $sec_gap = 0;
                                        $sec_start = dateUtil::time2seconds($start_time);
                                        $sec_end = dateUtil::time2seconds($end_time); 

                                        if ($sec_start <= dateUtil::time2seconds($start_time_m)){
                                            $sec_start = dateUtil::time2seconds($start_time_m);
                                        }

                                        if ($sec_end >= dateUtil::time2seconds($end_time_m)){
                                            $sec_end = dateUtil::time2seconds($end_time_m);
                                        }



                                        // starttime in gap >> reset to start+end point
                                        if ($sec_start > dateUtil::time2seconds($value["working_time_to_1"]) && 
                                                $sec_start < dateUtil::time2seconds($value["working_time_from_2"])){
                                            $sec_start = dateUtil::time2seconds($value["working_time_from_2"]);
                                        }

                                        if ($sec_start > dateUtil::time2seconds($value["working_time_to_2"]) && 
                                                $sec_start < dateUtil::time2seconds($value["working_time_from_3"])){
                                            $sec_start = dateUtil::time2seconds($value["working_time_from_3"]);
                                        }


                                        // endtime in gap >> reset to start+end point
                                        if ($sec_end > dateUtil::time2seconds($value["working_time_to_1"]) && 
                                                $sec_end < dateUtil::time2seconds($value["working_time_from_2"])){
                                            $sec_end = dateUtil::time2seconds($value["working_time_to_1"]);
                                        }

                                        if ($sec_end > dateUtil::time2seconds($value["working_time_to_2"]) && 
                                                $sec_end < dateUtil::time2seconds($value["working_time_from_3"])){
                                            $sec_end = dateUtil::time2seconds($value["working_time_to_2"]);
                                        }

                                        // deduct gap duration
                                        if ($sec_start <= dateUtil::time2seconds($value["working_time_to_1"])){
                                            if ($sec_end >= dateUtil::time2seconds($value["working_time_from_2"])){
                                                $sec_gap += $gap_time[0];                                        
                                            }

                                            if ($sec_end >= dateUtil::time2seconds($value["working_time_from_3"])){
                                                $sec_gap += $gap_time[1] ;                                        
                                            }

                                        }else if ($sec_start <= dateUtil::time2seconds($value["working_time_to_2"])){
                                            if ($sec_end >= dateUtil::time2seconds($value["working_time_from_3"])){
                                                $sec_gap += $gap_time[1] ;                                        
                                            }
                                        }


                                        //------------------- Standard working day --------------------------------------
                                        $tmp_date_name = strtolower(date('l', strtotime($tmp_date_full)));
                                        if ($value[$tmp_date_name] == 'Y'){// it is weekday
                                            $pending_days += ($sec_end - $sec_start);
                                        }

                                    }
                                }
                            }
                        }
                    }
                }
                $l++;
            }
        }
        
            
        $arr = array(
            "sla_days" => $sla_days,
            "holiday" => $holiday_days,
            "pending" => $pending_days
        ) ;
        return $arr;    
        
        
    }
    
   
    
   
    
}

?>
