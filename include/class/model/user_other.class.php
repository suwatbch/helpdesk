<?php
    include_once "model.class.php";

    class user_other extends model {

        public function listCombo(){
            $sql = " SELECT user_id, CONCAT( first_name,  '  ', last_name ) AS  'first_name'"
                    . " FROM helpdesk_user"
                    . " ORDER BY first_name";

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
            $s_admin = user_session::get_user_admin();

            # field
            $field = "us.user_id,us.user_code,us.employee_code,us.first_name,us.last_name,c.company_name";

            # table
            $table = "helpdesk_user us"
                     ." LEFT JOIN helpdesk_company c on(us.company_id=c.company_id)";

            # condition
            $condition = "us.user_status = '1' ";
            if($s_admin != 'Y'){
                $condition .= " AND us.admin <> 'Y' ";
            }

            $condition .= "ORDER BY user_code asc";

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
            $table = "helpdesk_tr_user_specorg";
            # check duplicate user code
            $condition = "company_id = '{$objective["company_id"]}' AND org_id = '{$objective["org_id"]}' AND user_id = '{$objective["user_id"]}' ";

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "user specorg";
            }
            
            return false;
        }
        
        public function getById($user_id){
            $field = "us.user_id,us.user_code,us.employee_code,us.first_name,us.last_name,us.org_id,c.company_name, orgm.org_name as subgroup_name, org.org_name as organization_name, grp.org_name as group_name";

            # table
            $table = "helpdesk_user us"
                     ." LEFT JOIN helpdesk_company c on(us.company_id=c.company_id)"
                     ." LEFT JOIN helpdesk_org orgm on(us.org_id=orgm.org_id)"
                     ." LEFT JOIN (SELECT org_id,org_code,org_name,org_comp FROM helpdesk_org WHERE LENGTH(org_code) = 2 ) org on (SUBSTRING(orgm.org_code, 1, 2)=org.org_code)"
                     ." LEFT JOIN (SELECT org_id,org_code,org_name,org_comp FROM helpdesk_org WHERE LENGTH(org_code) = 4 ) grp on (SUBSTRING(orgm.org_code, 1, 4)=grp.org_code)";
            $condition = "us.user_id = '$user_id' AND orgm.org_comp=org.org_comp AND orgm.org_comp=grp.org_comp ";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $user = $this->db->fetch_array($result);

            return $user;
        }
        
        public function insert(&$objective){
            
            $table = "helpdesk_tr_user_specorg";
            $field = "user_id, company_id, org_id, status,created_by,created_date,modified_by,modified_date";
            $data = "'{$objective["user_id"]}', '{$objective["company_id"]}', '{$objective["org_id"]}', '{$objective["status"]}', 
                        '{$objective["created_by"]}', '{$objective["created_date"]}', '{$objective["modified_by"]}', '{$objective["modified_date"]}' ";

            $result = $this->db->insert($table, $field, $data);
            
            return $result;
        }
        
        public function update($user){
            
            
            $table = "helpdesk_tr_user_specorg";
            $data = "user_id = '{$user["user_id"]}'"
                        . ", company_id = '{$user["company_id"]}'"
                        . ", org_id = '{$user["org_id"]}'"
                        . ", status = '{$user["status"]}'"
                        . ", modified_by = '{$user["modified_by"]}'"
                        . ", modified_date = '{$user["modified_date"]}'";
                        
            $condition = "specorg_id = '{$user["specorg_id"]}'";
            $result = $this->db->update($table, $data, $condition);
            
            return $result;
        }
        
        public function get_uer_other($objective){
            $sql = " SELECT uo.*, c.company_name, orgm.org_name as subgroup_name, org.org_name as organization_name, grp.org_name as group_name ,orgm.org_id as s_subgrp_id, org.org_id as s_org_id, grp.org_id as s_grp_id"
                    . " FROM helpdesk_tr_user_specorg uo"
                    . " LEFT JOIN helpdesk_company c on(uo.company_id=c.company_id)"
                    . " LEFT JOIN helpdesk_org orgm on(uo.org_id=orgm.org_id)"
                    ." LEFT JOIN (SELECT org_id,org_code,org_name,org_comp FROM helpdesk_org WHERE LENGTH(org_code) = 2 ) org on (SUBSTRING(orgm.org_code, 1, 2)=org.org_code)"
                    ." LEFT JOIN (SELECT org_id,org_code,org_name,org_comp FROM helpdesk_org WHERE LENGTH(org_code) = 4 ) grp on (SUBSTRING(orgm.org_code, 1, 4)=grp.org_code)"
                    . " WHERE uo.user_id = '$objective' AND orgm.org_comp=org.org_comp AND orgm.org_comp=grp.org_comp ORDER BY c.company_name asc";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_cus_zone", "status", "D", "zone_id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_tr_user_specorg", "specorg_id = '$objective'");
        }
        
        
    }
?>
