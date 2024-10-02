<?php
    include_once "model.class.php";

    class helpdesk_subgrp_mas extends model {
        
        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "orgm.*, orgm.org_name as subgroup_master, org.org_name as organization_master, grp.org_name as group_master ,c.company_name";
            # table
            $table = "helpdesk_org orgm"
                      . " LEFT JOIN helpdesk_company c on(orgm.org_comp=c.company_id)"
                      . " LEFT JOIN (SELECT org_code,org_comp,org_name FROM helpdesk_org WHERE LENGTH(org_code) = 2 ) org on (SUBSTRING(orgm.org_code, 1, 2)=org.org_code)"
                      . " LEFT JOIN (SELECT org_code,org_comp,org_name FROM helpdesk_org WHERE LENGTH(org_code) = 4 ) grp on (SUBSTRING(orgm.org_code, 1, 4)=grp.org_code)";

            # condition
            $condition = "LENGTH(orgm.org_code) = 6 AND org.org_comp=orgm.org_comp AND grp.org_comp=orgm.org_comp";

            $condition .= " ORDER BY c.company_name asc";

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
        
         public function isDuplicate($objective){
            $table = "helpdesk_grp_mas";
            $condition = "grp_name = '{$objective["grp_name"]}' AND company_id = '{$objective["company_id"]}' ";
            if (strUtil::isNotEmpty($objective["grp_id"])){
                $condition .= " AND grp_id <> '{$objective["grp_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "group master";
            }
           
            return false;
        }

        public function getById($objective){
            
            # field
            $field = "orgm.*, org.org_id as organization_id ,grp.org_id as s_group_id"
                      . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                      . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            # table
            $table = "helpdesk_org orgm"
                      . " LEFT JOIN (SELECT org_id,org_code,org_comp,org_name FROM helpdesk_org WHERE LENGTH(org_code) = 2 ) org on (SUBSTRING(orgm.org_code, 1, 2)=org.org_code)"
                      . " LEFT JOIN (SELECT org_id,org_code,org_comp,org_name FROM helpdesk_org WHERE LENGTH(org_code) = 4 ) grp on (SUBSTRING(orgm.org_code, 1, 4)=grp.org_code)"
                      . " LEFT JOIN helpdesk_user u1 ON (orgm.created_by = u1.user_id)"
                      . " LEFT JOIN helpdesk_user u2 ON (orgm.modified_by = u2.user_id)";  
                    

            # condition
            $condition = " orgm.org_id = '$objective' AND LENGTH(orgm.org_code) = 6 AND org.org_comp=orgm.org_comp AND grp.org_comp=orgm.org_comp ";


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
            $field = "org_code, org_name, org_comp, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["org_code"]}', '{$objective["org_name"]}', '{$objective["org_comp"]}', '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["org_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_org";
            
            if(($objective["s_org_comp"] != $objective["org_comp"]) || $objective["s_org_grp"] != $objective["group_id"]){
                $data = "org_code = '{$objective["org_code"]}'"
                        . ", org_name = '{$objective["org_name"]}'"
                        . ", org_comp = '{$objective["org_comp"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            }else{
                $data = "org_name = '{$objective["org_name"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            }
            $condition = "org_id = '{$objective["org_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
        
        public function gen_subgrp_code($objective,$objective2){
            $field = "orgm.org_code, grp.org_code as grp_code_d";
            $table = " helpdesk_org orgm"
                    . " LEFT JOIN (SELECT org_id,org_code,org_comp,org_name FROM helpdesk_org WHERE LENGTH(org_code) = 4 ) grp on (SUBSTRING(orgm.org_code, 1, 4)=grp.org_code)";
            
            $condition = "orgm.org_comp = '$objective' AND LENGTH(orgm.org_code) = 6 AND grp.org_id = '$objective2' order by orgm.org_code desc limit 0,1";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            $objective = $this->db->fetch_array($result);

            
            if($rows < 1){
               // $objective = "10101";
                //group_id
            $sql = "select org_code as s_group_id from helpdesk_org where LENGTH(org_code) = 4 AND org_id ='{$objective2}' ";
            $s_sql= $this->db->query($sql);
            $f_sql = $this->db->fetch_array($s_sql);
                $objective = (int)$f_sql["s_group_id"];
                $objective = $objective."01";
            }else{
                $objective = (int)$objective["org_code"]+1;
            }
            
            return $objective;
        }
        
        
    }
?>
