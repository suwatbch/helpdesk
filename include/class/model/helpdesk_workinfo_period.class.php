<?php
    include_once "model.class.php";
    include '../util/dateUtil.class.php';

    class workinfo_period extends model  {

        private $workinfo_list_param;
        private $main_start_date;
        private $main_end_date;
        private $incident_param; 

        private $main_workdays_array = array() ;  // เก็บข้อมูล วันที่ ที่ปฏิบัติงาน

        public $tot_pending_res_1 ; 
        public $tot_pending_res_2 ; 
        public $tot_pending_res_17 ; 
        public $tot_pending_res_18 ; 

        public  function actual_working_hour($incident, $work_infos,$start, $end){

            try{

                $this->workinfo_list_param = $work_infos;
                $this->main_start_date = $start; 
                $this->main_end_date = $end; 
                $this->incident_param = $incident;

                $this->tot_pending_res_1 = 0 ; 
                $this->tot_pending_res_2 = 0 ; 
                $this->tot_pending_res_17 = 0 ; 
                $this->tot_pending_res_18 = 0 ; 

                $total_working_sec = 0 ;
                $total_actual_pending_sec = 0 ;

                $start_date =  DateTime::createFromFormat('Y-m-d H:i:s', $this->main_start_date);
                $end_date =  DateTime::createFromFormat('Y-m-d H:i:s', $this->main_end_date);

                // 1. Cal start to end. 
                $total_working_sec = $end_date->getTimestamp() - $start_date->getTimestamp(); 

                // 2. Loop calculate working hour of pending status. 
                // Deduct pending time.
                try{
                    $rCount = count($this->workinfo_list_param);
                    $icount = 0 ;
                    foreach($this->workinfo_list_param as $work_info){
                    
                        if($work_info["workinfo_status_id"] == 4){
                            // Get work date of next
                            if($icount + 1 != $rCount){
                                $end_of_period = $this->workinfo_list_param[$icount + 1]["workinfo_date"];
                            }else{
                                $end_of_period = $this->main_end_date;
                            }

                            $start_date =  DateTime::createFromFormat('Y-m-d H:i:s', $work_info["workinfo_date"]);
                            $end_date =  DateTime::createFromFormat('Y-m-d H:i:s', $end_of_period);
                            $pending_diff = $end_date->getTimestamp() - $start_date->getTimestamp(); 
                            $total_actual_pending_sec += $pending_diff;

                           // Pending dev add to working
                           // Sum by reason. 
                           $res_id =   $work_info["workinfo_status_res_id"];  
                           switch ($res_id) {
                            case 1:
                                $this->tot_pending_res_1 += $pending_diff;
                              break;
                            case 2:
                                $this->tot_pending_res_2 += $pending_diff;
                              break;
                            case 17: // Pending dev. 
                                $this->tot_pending_res_17 += $pending_diff;
                              break;
                            case 18:
                                $this->tot_pending_res_18 += $pending_diff;
                                break;
                          }

                        }
                        $icount +=1;
                    }


                }catch(Exception $e){
                }
          

            }catch(Exception $e){
            }

            $arr = array(
                "tot_actual_pending_sec" => $total_actual_pending_sec,
                "tot_actual_working_sec" => ($total_working_sec +  $this->tot_pending_res_17) - $total_actual_pending_sec,
                "tot_pending_res_wait_info" => $this->tot_pending_res_1,
                "tot_pending_res_wait_sap" => $this->tot_pending_res_2,
                "tot_pending_res_wait_dev" => $this->tot_pending_res_17,
                "tot_pending_res_wait_test" => $this->tot_pending_res_18,
            );

            return $arr; 
        }

        public function calculate_sla_workdays($comp_id){
            self::split_workinfo_to_workdate(); 
        }

        function  split_workinfo_to_workdate($incident){

            $today 	= date("Y-m-d H:i:s");
            $this->incident_param = $incident;
            $this->main_start_date = $incident["assigned_date"];
            $this->main_end_date = $today;

            $date_diff = dateUtil::date_diff(substr($this->main_start_date,0,10), substr($this->main_end_date,0,10))  ; 
            // Get standard work.
            $std_time =  $this->get_standardtime(); 
            
            $start_date=date_create(substr($this->main_start_date,0,10));
            date_add($start_date,date_interval_create_from_date_string("1 days"));

            // Create daily work.
            for($i=0 ; $i <= $date_diff ; $i++){ 
                  
                $start_date=date_create(substr($this->main_start_date,0,10));
                date_add($start_date,date_interval_create_from_date_string($i." days"));

                $workday = new workday($start_date,$std_time);  // construct workday. create properties
                $this->main_workdays_array[] = $workday; 
            }

            // Summary เฉพาะ is_workday. 
            $total_workday = 0 ; 
            foreach($this->main_workdays_array as $work_day ){
                if($work_day->is_workday){
                    $total_workday++; 
                }
            }


            // Check assigned_date to working_date 
            $this->calculate_sla_by_workday($incident["assigned_date"], $incident["working_date"]);

            // self::display_dailywork( );
        } 

        function calculate_sla_by_workday($start_date, $to_date){

            foreach( $this->main_workdays_array as $workday){
                // ตรวจสอบว่าเวลา Start date - to date อยู่ในช่วงของวันทำงานนั้นๆ หรือไม่ 
                if($workday->is_workday){
                   $workday->calculate_working_time($start_date, $to_date);
                }
            }
        }


        function display_dailywork(){
            try {
                // display daily works.
                foreach($this->main_workdays_array as $witem ){
                    // $message = "item create daily work. : ".$witem->workdate->format('Y-m-d H:i:s');
                    // echo "<script type='text/javascript'>alert('$message');</script>"; 

                    // $message = "Day of week 2 : ".$witem->weekday;
                    // echo "<script type='text/javascript'>alert('$message');</script>"; 
                }
            }catch (Exception $e) {
                // echo 'Caught exception: ',  $e->getMessage(), "\n";
            //     $message = "Error : ....".$e->getMessage();
            //     echo "<script type='text/javascript'>alert('$message');</script>"; 
             }

        }

        public function get_standardtime(){
          
            

            $year = substr($this->main_start_date, 0,4);
            $comp_id  =  $this->incident_param["cus_company_id"];

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

            // Process for get standard working time of day. (หาเวลาทำงาน เช้าบ่าย)  
            if(count($arr) > 0){
    
                $r = 0 ; 
                foreach( $arr as $row ){
                    if($r == 0 ){
                        $std_workday = new stdworkday($row);
                    }
                    $r++;  // run ครั้งเดียวเพื่อ get setting. 
                }
            }

            return $std_workday;
        }
    }

     class workday{
        
        public $workdate; 
        public $start_time_1; 
        public $to_time_1; 

        public $start_time_2; 
        public $to_time_2; 

        public $desc; 
        public $isworkday;  
        public $weekday;
        public $std_work_day_param; 
        public $is_workday; // เป็นวันทำงานหรือไม่ เพื่อนำไปคำนวณเวลา SLA. 

        public function __construct($wdate,$std_work_day){

            $this->workdate = $wdate;
            $this->std_work_day_param = $std_work_day;

            $this->is_workday = false; // Set default.

            // $message = "class workday  __construct date_only :   ".$wdate->format('Y-m-d');
            // echo "<script type='text/javascript'>alert('$message');</script>"; 

            // Create start time 1 
            $this->start_time_1 =  strtotime($wdate->format('Y-m-d')." ".$std_work_day->working_time_from_1);

            // Create end time 1 
            $this->to_time_1 = strtotime($wdate->format('Y-m-d')." ".$std_work_day->working_time_to_1);

            // Create start time 2 
            $this->start_time_2 = strtotime($wdate->format('Y-m-d')." ".$std_work_day->working_time_from_2);

            // Create end time2 
            $this->to_time_2 = strtotime($wdate->format('Y-m-d')." ".$std_work_day->working_time_to_2);

            // $message = "Moning  :   ".date('d/M/Y h:i:s',$this->start_time_1)." to ".date('d/M/Y h:i:s',$this->to_time_1) ;
            // echo "<script type='text/javascript'>alert('$message');</script>"; 

            // $message = "Afternoon  ".date('d/M/Y h:i:s',$this->start_time_2)." to ".date('d/M/Y h:i:s',$this->to_time_2) ;
            // echo "<script type='text/javascript'>alert('$message');</script>"; 

            $date_input = getDate($this->start_time_1); 
            $this->weekday =  $date_input["weekday"];

            // $message = "weekday :  ".$this->weekday ;
            // echo "<script type='text/javascript'>alert('$message');</script>"; 

            switch (strtolower($this->weekday)) {
                case "sunday":
                    if($std_work_day->sunday == 'Y'){
                        $this->is_workday = true; 
                    }
                    break;

                case "monday":
                    if($std_work_day->monday == 'Y'){
                        $this->is_workday = true; 
                    }
                    break;

                case "tuesday":
                    if($std_work_day->tuesday == "Y"){
                        $this->is_workday = true; 
                    }
                    break;

                case "wednesday":
                    if($std_work_day->wednesday == "Y"){
                        $this->is_workday = true; 
                    }
                    break;

                case "thursday":
                    if($std_work_day->thursday == "Y"){
                        $this->is_workday = true; 
                    }
                    break;   

                case "friday":
                    if($std_work_day->friday == "Y"){
                        $this->is_workday = true; 
                    }
                    break;  

                case "saturday":
                    if($std_work_day->saturday == "Y"){
                        $this->is_workday = true; 
                    }
                    break;  
            }

            // $message = "Week day of : ".date('d/M/Y h:i:s',$this->start_time_2)." day :  ".$this->weekday." is work day : ".$this->is_workday ;
            // echo "<script type='text/javascript'>alert('$message');</script>"; 



            
        }

        // public function get_workdate(){
        //     return $workdate;
        // }

        function calculate_working_time($start_time,$to_time){ 
            $_start_time = strtotime($start_time);
            $_to_time = strtotime($to_time);

            // $message = "is_overlap start_time :  ".$start_time ;
            // echo "<script type='text/javascript'>alert('$message');</script>";

            $is_morning_intersec = false; 
            $is_afternoon_intersec = false; 

            // morning 
            // this->>start_time_1 <<<  [ $_start_time  ]     <<<<$this->to_time_1
            if( $_start_time >=  $this->start_time_1 && $_start_time <= $this->to_time_1 ){
                    $is_morning_intersec = true; 
            }

            // $_start_time<<<   [$this->start_time_1]    <<<<$_to_time
            if( !$is_morning_intersec && ($this->start_time_1 >=  $_start_time && $this->start_time_1 <= $_to_time)
            ){
                    $is_morning_intersec = true; 
            }

            // after noon 
            // $this->start_time_2 <<<  [ $_start_time  ]     <<<<$this->to_time_2
            if($_start_time >=  $this->start_time_2 && $_start_time <= $this->to_time_2 ){
                $is_morning_intersec = true; 
            }

            // $_start_time<<<   [$this->start_time_2]    <<<<$_to_time
            if( !$is_afternoon_intersec && ($this->start_time_2 >=  $_start_time && $this->start_time_2 <= $_to_time)
            ){
                    $is_morning_intersec = true; 
            }

            if($is_morning_intersec || $is_afternoon_intersec) 
            {
                $message = "overlap time  on workday : ". $this->workdate->format('Y-m-d')." Start work time :  ".date('Y-m-d H:i:s',$this->start_time_1)." to work time : ".date('Y-m-d H:i:s',$this->to_time_2) ." param start time".$start_time;
                echo "<script type='text/javascript'>alert('$message');</script>";

                // Calculate time morning.
                $this->calculate_working_morning($_start_time,$_to_time);

                // Calculate time afternoon. 


            }else{
                $message = "not overlap " ;
                echo "<script type='text/javascript'>alert('$message');</script>";
            }


            return ($is_morning_intersec || $is_afternoon_intersec);
        }

        function calculate_working_morning($start_time,$to_time){
            $get_started = false; 

            // Get start time.
            // this->>start_time_1 <<<  [ $_start_time  ]     <<<<$this->to_time_1
            if( $_start_time >=  $this->start_time_1 && $_start_time <= $this->to_time_1 ){
                $abs_start_time = $_start_time;
            }

            // $_start_time<<<   [$this->start_time_1]    <<<<$_to_time
            if( !$get_started && ($this->start_time_1 >=  $_start_time && $this->start_time_1 <= $_to_time)
            ){
                $abs_start_time = $_start_time;
            }

            // Get end time.

            


        }

    }

    class stdworkday{

        public $working_time_from_1; 
        public $working_time_to_1; 
        public $working_time_from_2; 
        public $working_time_to_2; 
        public $sunday;
        public $monday; 
        public $tuesday; 
        public $wednesday;
        public $thursday;
        public $friday;
        public $saturday;

        public function __construct($std_master){ 

            $this->working_time_from_1 = $std_master["working_time_from_1"];
            $this->working_time_to_1 = $std_master["working_time_to_1"];
            $this->working_time_from_2 = $std_master["working_time_from_2"];
            $this->working_time_to_2 = $std_master["working_time_to_2"];

            $this->sunday = $std_master["sunday"];
            $this->monday = $std_master["monday"];
            $this->tuesday = $std_master["tuesday"];
            $this->wednesday = $std_master["wednesday"];
            $this->thursday = $std_master["thursday"];
            $this->friday = $std_master["friday"];
            $this->saturday = $std_master["saturday"];

        }

    }
?>