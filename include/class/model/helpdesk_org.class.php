<?php
    include_once "model.class.php";

    class helpdesk_org extends model {

        public function listCombo($assign_comp_id=""){
            /*$sql = " SELECT org_id as assign_org_id, org_name as assign_org_name"
                    . " FROM helpdesk_org"
                    . " WHERE org_comp = 2"
                    . " AND LENGTH(org_code) = 2"
                    . " ORDER BY org_name";*/
					
			$sql = " SELECT org_id as assign_org_id, org_name as assign_org_name"
                    . " FROM helpdesk_org"
                    . " WHERE LENGTH(org_code) = 2";
					
            if (strUtil::isNotEmpty($assign_comp_id)){
                $sql .= " AND org_comp = $assign_comp_id"; //exit;
            }
			
            $sql .= " ORDER BY org_name"; //exit;

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function listCombo_master($company_id=""){
            /*$sql = " SELECT org_id as assign_org_id, org_name as assign_org_name"
                    . " FROM helpdesk_org"
                    . " WHERE org_comp = 2"
                    . " AND LENGTH(org_code) = 2"
                    . " ORDER BY org_name";*/
					
			$sql = " SELECT org_id,org_name"
                    . " FROM helpdesk_org"
                    . " WHERE LENGTH(org_code) = 2";
					
            if (strUtil::isNotEmpty($company_id)){
                $sql .= " AND org_comp = $company_id"; //exit;
            }
			
            $sql .= " ORDER BY org_name"; //exit;

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function cusorg($cus_company_id=""){
            
            $field = "cus_org_id,cus_org_name";
            $table = "helpdesk_cus_org";
            $condition = "1=1";
            if(strUtil::isNotEmpty($cus_company_id)){
                $condition .= " AND cus_company_id = '{$cus_company_id}'";
            }
            
            $condition .= " ORDER BY cus_org_name";
            $result = $this->db->select($field, $table, $condition);
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
            $table = "helpdesk_cus_org cor left join helpdesk_cus_company cuc on(cor.cus_company_id=cuc.cus_company_id)";

            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY cus_org_name asc";

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
            $field = "c.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_cus_org c"
                        . " LEFT JOIN helpdesk_user u1 ON (c.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (c.modified_by = u2.user_id)";
            $condition = "c.cus_org_id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_cus_org", "status", "D", "cus_org_id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_cus_org", "cus_org_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_cus_org", "status", "A", "cus_org_id = '$objective'");
        }
        
        public function insert(&$objective){
            $table = "helpdesk_cus_org";
            $field = "cus_org_name, status, created_by, created_date, modified_by, modified_date, cus_company_id";
            $data = "'{$objective["cus_org_name"]}', '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, 
                '{$objective["modified_date"]}', '{$objective["cus_company_id"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["cus_org_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_cus_org";
            $data = "cus_org_name = '{$objective["cus_org_name"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'"
                        . ", cus_company_id = '{$objective["cus_company_id"]}'";
            $condition = "cus_org_id = '{$objective["cus_org_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
        
        
    }
?>
