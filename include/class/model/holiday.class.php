<?php
    include_once "model.class.php";

    class holiday extends model {

        public function isHoliday($date){
            // saturday, sunday;
            //$day_in_week = array("monday", "tuesday", "wednesday", "thursday", "friday", "saturday","sunday");
            $holiday = array("saturday","sunday");

            $d = getdate(strtotime($date));
            if (in_array(strtolower($d["weekday"]), $holiday)){
                return true;
            }

            // holiday
            $sql = "SELECT holiday_id FROM tb_holiday WHERE status = 'A' AND holiday_date = '$date'";
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            if ($rows > 0){
                return true;
            }
            
            return false;
        }

        public function isDuplicate($holiday){
            $table = "tb_holiday";

            # check duplicate holiday_name
            $condition = "status <> 'D' AND holiday_date = '{$holiday["holiday_date"]}'";
            if (strUtil::isNotEmpty($holiday["holiday_id"])){
                $condition .= " AND holiday_id <> '{$holiday["holiday_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "holiday_date";
            }

            return false;
        }

        public function search($cratiria, $page = 1){
            global $page_size;

            $field = "holiday_id, holiday_date, holiday_name, description, status, created_by, created_date, modified_by, modified_date";
            $table = " tb_holiday h";
            $condition = " h.status = 'A'"
                              . " ORDER BY SUBSTR(holiday_date, 1, 4) DESC, SUBSTR(holiday_date, 5, 6)";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "data" => $arr
           );
        }

        public function getById($holiday_id){
            $field = "h.holiday_id, h.holiday_date, h.holiday_name, h.description, h.status"
                       . ", vs1.sale_full_name AS created_by, h.created_date"
                       . " , vs2.sale_full_name AS modified_by, h.modified_date";
            $table = " tb_holiday h"
                        . " LEFT JOIN v_tb_sale vs1 ON (h.created_by = vs1.sale_id)"
                        . " LEFT JOIN v_tb_sale vs2 ON (h.modified_by = vs2.sale_id)";
            $condition = "h.holiday_id = '$holiday_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);
            
            if ($rows == 0) return array();

            $holiday = $this->db->fetch_array($result);
            
            return $holiday;
        }

        public function delete($holiday_id){
            return $this->deleteWithUpdate("tb_holiday", "status", "D", "holiday_id = '$holiday_id'");
        }

        public function insert(&$holiday){
            $table = "tb_holiday";
            $field = "holiday_date, holiday_name, description, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$holiday["holiday_date"]}', '{$holiday["holiday_name"]}', '{$holiday["description"]}', '{$holiday["status"]}', '{$holiday["action_by"]}', '{$holiday["action_date"]}', '{$holiday["action_by"]}', '{$holiday["action_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $holiday["holiday_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($holiday){
            $table = "tb_holiday";
            $data = "holiday_date = '{$holiday["holiday_date"]}'"
                        . ", holiday_name = '{$holiday["holiday_name"]}'"
                        . ", description = '{$holiday["description"]}'"
                        . ", status = '{$holiday["status"]}'"
                        . ", modified_by = '{$holiday["action_by"]}'"
                        . ", modified_date = '{$holiday["action_date"]}'";
            $condition = "holiday_id = '{$holiday["holiday_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>