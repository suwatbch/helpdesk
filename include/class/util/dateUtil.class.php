<?php
    class dateUtil {
        const DIFF_IN_YEAR = "Y";
        const DIFF_IN_MONTH = "M";
        const DIFF_IN_DAYS = "D";
        const DIFF_IN_HOURS  = "H";
        const DIFF_IN_MINUTES = "I";
        const DIFF_IN_SECONDS = "S";
           
        

        
        public static function time_hms($time){
            if(trim($time) == ""){
                return "";
            }

            $h = substr($time, 0, 2);
            $m = substr($time, 2, 2);
            $s = substr($time, 4, 2);

            return "$h:$m:$s";
        }

        public static function date_dmy($date){
            if(trim($date) == ""){
                return "";
            }

            $d = substr($date, 6, 2);
            $m = substr($date, 4, 2);
            $y = substr($date, 0, 4);

            return "$d-$m-$y";
        }

        public static function date_ymd($date){
            if(trim($date) == ""){
                return "";
            }

            $d = substr($date, 0, 2);
            $m = substr($date, 3, 2);
            $y = substr($date, 6, 4);

            return "$y$m$d";
        }
        
        public static function date_ymdhms($date){
            if(trim($date) == ""){
                return "";
            }

            return date("YmdHis", strtotime($date));
        }

        public static function date_dmyhms($date){
            if(trim($date)==""){
                return "";
            }

            $d = substr($date, 6, 2);
            $m = substr($date, 4, 2);
            $y = substr($date, 0, 4);
            $h = str_pad(substr($date, 8, 2), 2, "0", STR_PAD_LEFT);
            $i = str_pad(substr($date, 10, 2), 2, "0", STR_PAD_LEFT);
            $s = str_pad(substr($date, 12, 2), 2, "0", STR_PAD_LEFT);

            return "$d-$m-$y $h:$i:$s";
        }

        public static function date_dmyhms2($date){
            if(trim($date)=="" || trim($date)=="0000-00-00 00:00:00"){
                return "";
            }

            $d = substr($date, 8, 2);
            $m = substr($date, 5, 2);
            $y = substr($date, 0, 4);
            $h = str_pad(substr($date, 11, 2), 2, "0", STR_PAD_LEFT);
            $i = str_pad(substr($date, 14, 2), 2, "0", STR_PAD_LEFT);
            $s = str_pad(substr($date, 17, 2), 2, "0", STR_PAD_LEFT);

            return "$d/$m/$y $h:$i:$s";
        }

        public static function date_ymd2($date){
            if(trim($date)=="" || trim($date)=="00-00-0000"){
                return "";
            }

            $d = substr($date, 0, 2);
            $m = substr($date, 3, 2);
            $y = substr($date, 6, 4);

            return "$y-$m-$d";
        }

        public static function date_ymd3($date){
            $y = substr($date, 0, 4);
            $m = substr($date, 4, 2);
            $d = substr($date, 6, 2);

            return "$y-$m-$d";
        }

        public static function date_time($txt_date,$txt_time) {
            return self::date_dmy($txt_date)." ".self::time_hms($txt_time);
        }

        public static function current_date_time(){
            return date("Ymd").date("His");
        }

        public static function current_date(){
            return date("Ymd");
        }

        public static function getFirstDayFromWeek($year, $week) {
            $first_day = strtotime($year."-01-01");
            $is_monday = date("w", $first_day) == 1;
            $is_weekone = strftime("%V", $first_day) == 1;
            if($is_weekone){
                $week_one_start = $is_monday ? strtotime("last monday", $first_day) : $first_day;
            } else {
                $week_one_start = strtotime("next monday", $first_day);
            }

            return $week_one_start + (3600 * 24 * 7 *($week-1));
        }
        
        public static function getWeekRange($year, $week) {
            $start_date = dateUtil::getFirstDayFromWeek($year, $week);
            $end_date = strtotime(date("Ymd", $start_date)." +6 day");

            return array($start_date, $end_date);
        }

        public static function getMonthRange($year, $month) {
            $start_date = mktime(0, 0, 0, $month, 1, $year);
            $end_date = mktime(23, 59, 0, $month, date('t', $start_date), $year);

            $start_date = date("Ymd", $start_date);
            $end_date = date("Ymd", $end_date);

            return array($start_date, $end_date);
        }

        public static function dateDiff($d1, $d2, $diffin= self::DIFF_IN_DAYS){
            switch ($diffin) {
                case self::DIFF_IN_YEAR : // year
                    $divide = 31536000;
                    break;

                case self::DIFF_IN_MONTH : // month
                    $divide = 2628000;
                    break;

                case self::DIFF_IN_DAYS : // day
                    $divide = 60 * 60 * 24;
                    break;

                case self::DIFF_IN_HOURS : // hours
                    $divide = 60 * 60;
                    break;

                case self::DIFF_IN_MINUTES : // minutes
                    $divide = 60;
                    break;

                case self::DIFF_IN_SECONDS : // seconds
                    $divide = 1;
                    break;

                default:
                    $divide = 60 * 60 * 24;
                    break;
            }

            return round(abs(strtotime($d1) - strtotime($d2)) / $divide);
        }
		
		public static function date_diff2($start, $end="NOW")	{
				if(trim($start)=="0000-00-00 00:00:00" || trim($end)=="0000-00-00 00:00:00"){
					return "";
				}
				
				$sdate = strtotime($start);
				$edate = strtotime($end);
		
				$time = $edate - $sdate;
				if($time>=0 && $time<=59) {
						// Seconds
						$timeshift = $time.' seconds ';
		
				} elseif($time>=60 && $time<=3599) {
						// Minutes + Seconds
						$pmin = ($edate - $sdate) / 60;
						$premin = explode('.', $pmin);
						
						$presec = $pmin-$premin[0];
						$sec = $presec*60;
						
						$timeshift = $premin[0].' min '.round($sec,0).' sec ';
		
				} elseif($time>=3600 && $time<=86399) {
						// Hours + Minutes
						$phour = ($edate - $sdate) / 3600;
						$prehour = explode('.',$phour);
						
						$premin = $phour-$prehour[0];
						$min = explode('.',$premin*60);
						
						$presec = '0.'.$min[1];
						$sec = $presec*60;
		
						$timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';
		
				} elseif($time>=86400) {
						// Days + Hours + Minutes
						$pday = ($edate - $sdate) / 86400;
						$preday = explode('.',$pday);
		
						$phour = $pday-$preday[0];
						$prehour = explode('.',$phour*24); 
		
						$premin = ($phour*24)-$prehour[0];
						$min = explode('.',$premin*60);
						
						$presec = '0.'.$min[1];
						$sec = $presec*60;
						
						$timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';
		
				}
				return $timeshift;
				// EXAMPLE:
				//$start_date = 2010-03-15 13:00:00
				//$end_date = 2010-03-17 09:36:15
				//echo date_diff2($start_date, $end_date);
		}

        public static function sec_to_time_desc($time)	{

            // if(trim($start)=="0000-00-00 00:00:00" || trim($end)=="0000-00-00 00:00:00"){
            //     return "";
            // }
            
            // $sdate = strtotime($start);
            // $edate = strtotime($end);
    
            // $time = $edate - $sdate;
            // $time = $timeSec;
            if($time>=0 && $time<=59) {
                    // Seconds
                    $timeshift = $time.' seconds ';
    
            } elseif($time>=60 && $time<=3599) {
                    // Minutes + Seconds
                    $pmin = ($time) / 60;
                    $premin = explode('.', $pmin);
                    
                    $presec = $pmin-$premin[0];
                    $sec = $presec*60;
                    
                    $timeshift = $premin[0].' min '.round($sec,0).' sec ';
    
            } elseif($time>=3600 && $time<=86399) {

                  
                    // Hours + Minutes
                    $phour = ($time) / 3600;
                    $prehour = explode('.',$phour);
                    
                    $premin = $phour-$prehour[0];
                    $min = explode('.',$premin*60);
                    
                    $presec = '0.'.$min[1];
                    $sec = $presec*60;
    
                    $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

            } elseif($time>=86400) {
                    // Days + Hours + Minutes
                    $pday = ($time) / 86400;
                    $preday = explode('.',$pday);
    
                    $phour = $pday-$preday[0];
                    $prehour = explode('.',$phour*24); 
    
                    $premin = ($phour*24)-$prehour[0];
                    $min = explode('.',$premin*60);
                    
                    $presec = '0.'.$min[1];
                    $sec = $presec*60;
                    
                    $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';
    
            }
            return $timeshift;
            // EXAMPLE:
            //$start_date = 2010-03-15 13:00:00
            //$end_date = 2010-03-17 09:36:15
            //echo date_diff2($start_date, $end_date);
    }

    public static function sec_to_time_byworking_sec($time,$working_sec)	{

        // if(trim($start)=="0000-00-00 00:00:00" || trim($end)=="0000-00-00 00:00:00"){
        //     return "";
        // }
        
        // $sdate = strtotime($start);
        // $edate = strtotime($end);

        // $time = $edate - $sdate;
        // $time = $timeSec;
        if($time>=0 && $time<=59) {
                // Seconds
                $timeshift = $time.' seconds ';

        } elseif($time>=60 && $time<=3599) {
                // Minutes + Seconds
                $pmin = ($time) / 60;
                $premin = explode('.', $pmin);
                
                $presec = $pmin-$premin[0];
                $sec = $presec*60;
                
                $timeshift = $premin[0].' min '.round($sec,0).' sec ';

        } elseif($time>=3600 && $time<$working_sec) {

              
                // Hours + Minutes
                $phour = ($time) / 3600;
                $prehour = explode('.',$phour);
                
                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);
                
                $presec = '0.'.$min[1];
                $sec = $presec*60;

                $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        } elseif($time>=$working_sec) {
                // Days + Hours + Minutes

                // Hour per day 
                $hour_per_day = ($working_sec / 60) / 60 ;
                $pday = ($time) / $working_sec;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];

                $prehour = explode('.',$phour*$hour_per_day ); 

                $premin = ($phour*$hour_per_day)-$prehour[0];
                $min = explode('.',$premin*60);
                
                $presec = '0.'.$min[1];
                $sec = $presec*60;
                
                $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        }
        return $timeshift;
        // EXAMPLE:
        //$start_date = 2010-03-15 13:00:00
        //$end_date = 2010-03-17 09:36:15
        //echo date_diff2($start_date, $end_date);
}
		
		
		public static function date_diff3($start, $end="NOW")	{
				if(trim($start)=="0000-00-00 00:00:00" || trim($end)=="0000-00-00 00:00:00"){
					return 0;
				}
				
				$sdate = strtotime($start);
				$edate = strtotime($end);
		
				$time = $edate - $sdate;
				return $time;
				// EXAMPLE:
				//$start_date = 2010-03-15 13:00:00
				//$end_date = 2010-03-17 09:36:15
				//echo date_diff3($start_date, $end_date);
		}
		
		public static function get_today_datetime_1(){
			date_default_timezone_set('Asia/Bangkok');
			$today = date("Y-m-d H:i:s");
			return $today;
		}
                
                public static function thai_date($date_yyyymmdd){  
//                    global $thai_day_arr,$thai_month_arr;  
//                    $thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");  
                    $thai_month_arr=array(  
                        "0"=>"",  
                        "1"=>"มกราคม",  
                        "2"=>"กุมภาพันธ์",  
                        "3"=>"มีนาคม",  
                        "4"=>"เมษายน",  
                        "5"=>"พฤษภาคม",  
                        "6"=>"มิถุนายน",   
                        "7"=>"กรกฎาคม",  
                        "8"=>"สิงหาคม",  
                        "9"=>"กันยายน",  
                        "10"=>"ตุลาคม",  
                        "11"=>"พฤศจิกายน",  
                        "12"=>"ธันวาคม"                    
                    );  
        
                    $y = substr($date_yyyymmdd,0,4);
                    $m = substr($date_yyyymmdd,4,2);
                    $d = substr($date_yyyymmdd,6,2);
                    
                    $y = (int)$y + 543; //convert to พ.ศ.
                    $m = (int)$m;
                    $d = (int)$d;
                    
                    $thai_date_return.= "วันที่ $d ".$thai_month_arr["$m"]. " พ.ศ. $y";   
                    return $thai_date_return;  
                }  
                
                
                public static function thai_date_ddmmyyyy($date){  // dd-mm-YYYY
                    $thai_month_arr=array(  
                        "0"=>"",  
                        "1"=>"มกราคม",  
                        "2"=>"กุมภาพันธ์",  
                        "3"=>"มีนาคม",  
                        "4"=>"เมษายน",  
                        "5"=>"พฤษภาคม",  
                        "6"=>"มิถุนายน",   
                        "7"=>"กรกฎาคม",  
                        "8"=>"สิงหาคม",  
                        "9"=>"กันยายน",  
                        "10"=>"ตุลาคม",  
                        "11"=>"พฤศจิกายน",  
                        "12"=>"ธันวาคม"                    
                    );  
        
                    $y = substr($date,6,4);
                    $m = substr($date,3,2);
                    $d = substr($date,0,2);
                    
                    $y = (int)$y + 543; //convert to พ.ศ.
                    $m = (int)$m;
                    $d = (int)$d;
                    
                    $thai_date_return.= "วันที่ $d ".$thai_month_arr["$m"]. " พ.ศ. $y";   
                    return $thai_date_return;  
                }
                
                
                function TimeDiff($strTime1,$strTime2){
                    return (strtotime($strTime2) - strtotime($strTime1)); // seconds | (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); 
                }
                
                function date_diff($strDate1,$strDate2)
                 {
                        return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
                 }
                 
                 function time2seconds($time='00:00:00')
                {
                    list($hours, $mins, $secs) = explode(':', $time);
                    return ($hours * 3600 ) + ($mins * 60 ) + $secs;
                }
                
                public static function seconds2time($init){
                    
                    $hours = floor($init / 3600);
                    
                    $minutes = floor(($init / 60) % 60);
                    if (strlen($minutes) == 1) {$minutes = '0'.$minutes;}
                    $seconds = $init % 60;
                    if (strlen($seconds) == 1) {$seconds = '0'.$seconds;}

                    return "$hours:$minutes:$seconds";
                }

    }

?>