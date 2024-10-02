<?php
    include_once "model.class.php";

    class incident_type extends model {

        public function listCombo($cus_company_id){
            
            /*$sql = " SELECT ident_type_id, ident_type_desc"
                    . " FROM helpdesk_incident_type"
                    . " ORDER BY ident_type_id";*/
			
            $sql = " SELECT ident_type_id, ident_type_desc"
                    . " FROM helpdesk_incident_type";
					
            if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE cus_comp_id = $cus_company_id";
            }

            $sql .= " ORDER BY ident_type_id";
			
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function listCombo_display($cus_company_id,$display_inc){
            
            /*$sql = " SELECT ident_type_id, ident_type_desc"
                    . " FROM helpdesk_incident_type"
                    . " ORDER BY ident_type_id";*/
			
            $sql = " SELECT ident_type_id, ident_type_desc"
                    . " FROM helpdesk_incident_type"
                    . " where display_report in ($display_inc)";
					
            if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " and cus_comp_id = $cus_company_id";
            }

            $sql .= " ORDER BY ident_type_id";
			
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
            $field = "t.*,c.cus_company_name";

            # table
            $table = "helpdesk_incident_type t"
                      . " LEFT JOIN helpdesk_cus_company c on(t.cus_comp_id=c.cus_company_id)";

            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY t.ident_type_desc asc";

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
            $field = "inc.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_incident_type inc"
                        . " LEFT JOIN helpdesk_user u1 ON (inc.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (inc.modified_by = u2.user_id)";
            $condition = "inc.ident_type_id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_incident_type", "status", "D", "ident_type_id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_incident_type", "ident_type_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_incident_type", "status", "A", "ident_type_id = '$objective'");
        }
        
        public function insert(&$objective){
            $table = "helpdesk_incident_type";
            $field = "cus_comp_id, ident_type_desc, status, created_by, created_date, modified_by, modified_date, display_report";
            $data = "'{$objective["cus_comp_id"]}', '{$objective["ident_type_desc"]}', '{$objective["status"]}', '{$objective["created_by"]}',
                '{$objective["created_date"]}', '{$objective["modified_by"]}', '{$objective["modified_date"]}', '{$objective["display_report"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["ident_type_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_incident_type";
            $data = "cus_comp_id = '{$objective["cus_comp_id"]}'"
                        . ", ident_type_desc = '{$objective["ident_type_desc"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'"
                        . ", display_report = '{$objective["display_report"]}'";
            $condition = "ident_type_id = '{$objective["ident_type_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
