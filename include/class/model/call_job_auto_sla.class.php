<?php
include_once "model.class.php";

    class call_job_auto_sla extends model {
        
        public function call_schedule($type_id){
            $sql = "select *,
                case
                when latest_run < NOW() and start_datetime < NOW() and ifnull(schedule,'') = 'H' then DATE_ADD( start_datetime, INTERVAL CEIL( TIME_TO_SEC( TIMEDIFF( NOW( ) , start_datetime ) ) /3600 ) HOUR )
                when latest_run = '0000-00-00 00:00:00' then start_datetime
                when ifnull(schedule,'') = 'H' then DATE_ADD(latest_run,INTERVAL 1 HOUR)
                when ifnull(schedule,'') = 'D' then DATE_ADD(latest_run,INTERVAL 1 DAY) 
                when ifnull(schedule,'') = 'W' then DATE_ADD(latest_run,INTERVAL 1 WEEK)
                when ifnull(schedule,'') = 'M' then DATE_ADD(latest_run,INTERVAL 1 MONTH)
                else latest_run end as next_run ,
                case
                when latest_run < NOW() and start_datetime < NOW() and ifnull(schedule,'') = 'H' then  TIME_TO_SEC( TIMEDIFF( DATE_ADD( start_datetime, INTERVAL CEIL( TIME_TO_SEC( TIMEDIFF( NOW( ) , start_datetime ) ) /3600 ) HOUR ) , NOW()))
                when latest_run = '0000-00-00 00:00:00' then  TIME_TO_SEC( TIMEDIFF( start_datetime , NOW()))
                else 3600 end as next_secs
                from helpdesk_alert_schedule where enabled = 'Y' and type_id = ".$type_id ;
            //DATE_ADD(latest_run,INTERVAL 1 HOUR) as r_hour ,DATE_ADD(latest_run,INTERVAL 1 DAY)  AS R_day , DATE_ADD(latest_run,INTERVAL 1 WEEK) aS R_week , DATE_ADD(latest_run,INTERVAL 1 MONTH) as r_month  
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "data" => $arr,
                "total_rows" => $rows
            );
            
        }
        
        public function upd_schedule($datetime,$type_id){
            $table = "helpdesk_alert_schedule";
            $data = "latest_run = '$datetime' ";
            $condition = "type_id = '$type_id' ";
                
        $result = $this->db->update($table, $data, $condition);
        return $result;
        }
       
        
    }
?>
