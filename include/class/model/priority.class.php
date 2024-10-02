<?php
    include_once "model.class.php";

    class priority extends model {

        public function listCombo(){
            $sql = " SELECT priority_id, priority_desc"
                    . " FROM helpdesk_priority"
                    . " ORDER BY priority_id";
		
            
			/*$sql = " SELECT priority2_id as priority_id, CONCAT(priority_id,'-',priority_desc) as priority_desc"  
                    . " FROM helpdesk_tr_priority p1"
                    . " LEFT JOIN helpdesk_priority p2 ON p1.priority2_id = p2.priority_id";

            if (strUtil::isNotEmpty($impact_id) && strUtil::isNotEmpty($urgency_id)){
                $sql .= " WHERE impact_id = '$impact_id' AND urgency_id = '$urgency_id'";
            }

            $sql .= " ORDER BY tr_priorityid";*/
			
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "*";

            # table
            $table = "helpdesk_priority";

            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY priority_desc asc";

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
            $field = "p.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_priority p"
                        . " LEFT JOIN helpdesk_user u1 ON (p.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (p.modified_by = u2.user_id)";
            $condition = "p.priority_id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_priority", "status", "D", "priority_id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_priority", "priority_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_priority", "status", "A", "priority_id = '$objective'");
        }
        
        public function insert(&$objective){
            $table = "helpdesk_priority";
            $field = "priority_desc, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["priority_desc"]}', '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["priority_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_priority";
            $data = "priority_desc = '{$objective["priority_desc"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            $condition = "priority_id = '{$objective["priority_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
