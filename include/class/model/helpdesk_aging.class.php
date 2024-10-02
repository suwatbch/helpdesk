<?php
    include_once "model.class.php";

    class aging_report extends model {
        
        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "*";

            # table
            $table = "helpdesk_vlookup";

            # condition
            $condition = "type='report_aging'";
            $condition .= " ORDER BY item asc";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $data[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "data" => $data
            );
        }

        public function getById($objective){
            $field = "v.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_vlookup v"
                        . " LEFT JOIN helpdesk_user u1 ON (v.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (v.modified_by = u2.user_id)";
            $condition = "v.id = '$objective' AND type= 'report_aging' ";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_vlookup", "status", "D", "id = '$objective'");
             return $this->deleteWithoutUpdate("helpdesk_vlookup", "id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_vlookup", "status", "A", "id = '$objective'");
        }
        
        public function insert(&$objective){
            $field = "item";
            $table = "helpdesk_vlookup";
            $condition = "1=1 order by item desc limit 0,1";
            $result = $this->db->select($field, $table, $condition);
            $f_item = $this->db->fetch_array($result);
            $s_item = $f_item["item"];
            $s_item = $s_item  + 1;
            
            $table = "helpdesk_vlookup";
            $field = "shortname, name, value, type, status, item, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["shortname"]}', '{$objective["name"]}', '{$objective["value"]}', '{$objective["type"]}', '{$objective["status"]}', '{$s_item}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_vlookup";
            $data = "shortname = '{$objective["shortname"]}'"
                        . ", name = '{$objective["name"]}'"
                        . ", value = '{$objective["value"]}'"
                        . ", type = '{$objective["type"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            $condition = "id = '{$objective["id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
