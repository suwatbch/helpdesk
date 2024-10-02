<?php
    include_once "model.class.php";

    class helpdesk_org_mas extends model {
        
        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "orgm.*,c.company_name,c.company_id";

            # table
            $table = "helpdesk_org orgm"
                      . " LEFT JOIN helpdesk_company c on(orgm.org_comp=c.company_id)";

            # condition
            $condition = "LENGTH(orgm.org_code) = 2";

            $condition .= " ORDER BY orgm.org_name asc";

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
            $field = "orgm.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_org orgm"
                        . " LEFT JOIN helpdesk_user u1 ON (orgm.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (orgm.modified_by = u2.user_id)";
            $condition = "orgm.org_id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_org", "status", "D", "org_id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_org", "org_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_org", "status", "A", "org_id = '$objective'");
        }
        
        public function insert(&$objective){
            $table = "helpdesk_org";
            $field = "org_comp, org_name, org_code, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["org_comp"]}', '{$objective["org_name"]}', '{$objective["org_code"]}', '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["org_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_org";
            $data = "org_comp = '{$objective["org_comp"]}'"
                        . ", org_name = '{$objective["org_name"]}'"
                        . ", org_code = '{$objective["org_code"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            $condition = "org_id = '{$objective["org_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
        
        
    }
?>
