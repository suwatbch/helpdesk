<?php
include_once "model.class.php";

    class working_calendar extends model {

        public function getYear(){
            $sql = " select YEAR(CURDATE()) as year
                    union 
                    select YEAR(CURDATE()) - 1 as year
                    union
                    select YEAR(CURDATE()) +1 as year
                    order by year desc";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        
        public function update_StandardWork($value){
            $table = " helpdesk_std_working_calendar";
            $data = " sunday = '{$value["sun"]}' , "
                    ." monday =  '{$value["mon"]}' ,"
                    ." tuesday =  '{$value["tue"]}' ,"
                    ." wednesday =  '{$value["wed"]}' ,"
                    ." thursday =  '{$value["thu"]}' ,"
                    ." friday =  '{$value["fri"]}' ,"
                    ." saturday =  '{$value["sat"]}' ,"
                    ." working_time_from_1 = '{$value["time1_fr"]}',"
                    ." working_time_to_1 = '{$value["time1_to"]}',"
                    ." working_time_from_2 = '{$value["time2_fr"]}',"
                    ." working_time_to_2 = '{$value["time2_to"]}',"
                    ." working_time_from_3 = '{$value["time3_fr"]}',"
                    ." working_time_to_3 = '{$value["time3_to"]}',"
                    ." sla_cal_workdaytime = '{$value["flag_work"]}',"
                    ." modify_date = NOW() , modify_by = '{$value["user_id"]}' ,"
                    ." deduct_pending = '{$value["deduct_pending"]}'";
            
            $condition = " 1=1 " ;
            
            if (strUtil::isNotEmpty($value["cus_comp_id"])){
                $condition .= " and cus_comp_id = {$value["cus_comp_id"]} ";
            }
            
            if (strUtil::isNotEmpty($value["year"])){
                $condition .= " and working_year = {$value["year"]} ";
            }
            
            
            $result = $this->db->update($table, $data, $condition);
            return $result;
            
        }
        
        public function insert_StandardWork($value){
           $table = " helpdesk_std_working_calendar";
           $field = " cus_comp_id, working_year,"
                    . " sunday, monday, tuesday, wednesday,"
                    . " thursday, friday, saturday, "
                    . " working_time_from_1, working_time_to_1,"
                    . " working_time_from_2, working_time_to_2, "
                    . " working_time_from_3, working_time_to_3,"
                    . " sla_cal_workdaytime,"
                    . " create_date, create_by, modify_date, modify_by,deduct_pending ";
           
           $data =  " '{$value["cus_comp_id"]}', '{$value["year"]}' ,"
                    . " '{$value["sun"]}', '{$value["mon"]}', '{$value["tue"]}', '{$value["wed"]}',"
                    . " '{$value["thu"]}', '{$value["fri"]}', '{$value["sat"]}', "
                    . " '{$value["time1_fr"]}', '{$value["time1_to"]}',"
                    . " '{$value["time2_fr"]}', '{$value["time2_to"]}',"
                    . " '{$value["time3_fr"]}', '{$value["time3_to"]}',"
                    . " '{$value["flag_work"]}',"
                    . " NOW(), {$value["user_id"]}, NOW(), {$value["user_id"]}, '{$value["deduct_pending"]}' ";
//           echo $table."  ";
//           echo $field . " ";
//           echo $data . " ";
//           exit();

    //       exit();
           $result = $this->db->insert($table, $field, $data);

//            if ($result){
//                $value["id"] = $this->db->insert_id();
//            }

           return $result;
           
        }

        
        public function existsStandardWork($year,$comp_id){
            $sql = "SELECT 1 
                FROM helpdesk_std_working_calendar
                WHERE cus_comp_id = $comp_id
                AND working_year =  '$year' ";

            $result = $this->db->query($sql);
            $total_row = $this->db->num_rows($result);

            if ($total_row == 0) {
                return 0;
            }else {
                return $total_row;
            }
        }
        

        public function delete_Holiday($year, $comp_id){
            $table = " helpdesk_spec_holiday_calendar";
            $condition = " spec_year = '$year' and cus_comp_id = $comp_id ";
            
            $result = $this->db->delete($table,$condition);
            
            return $result;
            
        }
        
        public function insert_Holiday($year, $comp_id,$date,$user_id){
            $table = " helpdesk_spec_holiday_calendar"; 
            $field = " cus_comp_id, spec_year, spec_date, "
                    . " create_by, create_date, modify_by, modify_date";
            $data = " $comp_id, '$year', '$date', "
                    . " $user_id, NOW(), $user_id, NOW() ";
            
            $result = $this->db->insert($table, $field, $data);
            return $result;
        }
        
        
        
        public function delete_SpecialWorking($year, $comp_id){
            $table = " helpdesk_spec_working_day";
            $condition = " spec_year = '$year' and cus_comp_id = $comp_id ";
            
            $result = $this->db->delete($table,$condition);
            
            return $result;
            
        }
        
        
        public function insert_SpecialWorking($value){
            $table = " helpdesk_spec_working_day"; 
            $field = " cus_comp_id, spec_year, spec_date, 
                    working_time_from_1, working_time_to_1, 
                    working_time_from_2, working_time_to_2, 
                    working_time_from_3, working_time_to_3, 
                    create_by, create_date, modify_by, modify_date";
            $data = " {$value["cus_comp_id"]}, '{$value["year"]}', '{$value["date"]}', 
                    '{$value["time1_fr"]}', '{$value["time1_to"]}', 
                    '{$value["time2_fr"]}', '{$value["time2_to"]}', 
                    '{$value["time3_fr"]}', '{$value["time3_to"]}', 
                    '{$value["user_id"]}', NOW(), '{$value["user_id"]}', NOW() ";
            
            $result = $this->db->insert($table, $field, $data);
            return $result;
        }
        
        
        
        public function get_StandardWork($year,$cus_comp_id){
		$sql = "select sunday, monday, tuesday, wednesday, thursday, friday, saturday, sla_cal_workdaytime as flag_working,
                    TIME_FORMAT(working_time_from_1, '%H:%i') as time1_from , TIME_FORMAT(working_time_to_1, '%H:%i')  as time1_to , 
                    TIME_FORMAT(working_time_from_2, '%H:%i') as time2_from , TIME_FORMAT(working_time_to_2, '%H:%i')  as time2_to , 
                    TIME_FORMAT(working_time_from_3, '%H:%i') as time3_from , TIME_FORMAT(working_time_to_3, '%H:%i')  as time3_to ,
                    deduct_pending
                    from 
                    helpdesk_std_working_calendar 
                    where cus_comp_id = '$cus_comp_id' and working_year = '$year' limit 1";
                
             $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
                
        }
        
        
        public function get_Holiday($year,$cus_comp_id){
		$sql = "select spec_date, DATE_FORMAT(spec_date,'%d-%m-%Y') as display_date,DATE_FORMAT(spec_date,'%Y%m%d') as value_date  "
                    . " from helpdesk_spec_holiday_calendar "
                    . " where cus_comp_id = '$cus_comp_id' and spec_year = '$year' order by spec_date";
//             echo $sql;
//             exit();
                
             $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
                
        }
        
        
        public function get_SpecialWork($year,$cus_comp_id){
		$sql = "select spec_date, DATE_FORMAT(NOW(),'%d-%m-%Y') as display_date ,  "
                    . "  TIME_FORMAT(working_time_from_1, '%H:%i') as time1_from , TIME_FORMAT(working_time_to_1, '%H:%i')  as time1_to , "
                    . "  TIME_FORMAT(working_time_from_2, '%H:%i') as time2_from , TIME_FORMAT(working_time_to_2, '%H:%i')  as time2_to , "
                    . "  TIME_FORMAT(working_time_from_3, '%H:%i') as time3_from , TIME_FORMAT(working_time_to_3, '%H:%i')  as time3_to  "
                    . " from helpdesk_spec_working_day "
                    . " where cus_comp_id = '$cus_comp_id' and spec_year = '$year' order by spec_date";
                
//                echo $sql;
//                exit();
             $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
                
        }
        
        //
    
}
?>
