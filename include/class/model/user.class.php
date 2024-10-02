<?php
    include_once "model.class.php";

    class User extends model {

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
            $field = "us.user_id,us.user_code,us.first_name,us.last_name,c.company_name,us.user_status";

            # table
            $table = "helpdesk_user us"
                     ." LEFT JOIN helpdesk_company c on(us.company_id=c.company_id)";

            # condition
            $condition = "1=1";
            
            if($s_admin != 'Y'){
                $condition .= " AND us.admin <> 'Y' ";
            }
            $condition .= " ORDER BY user_code asc";

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
        
        public function getById($user_id){
            $field = "us.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name,ag.access_group_id";
            $table = " helpdesk_user us"
                        . " LEFT JOIN helpdesk_user u1 ON (us.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (us.modified_by = u2.user_id)"
                        . " LEFT JOIN tb_access_group_sale ag ON (us.user_id = ag.sale_id)";
            $condition = "us.user_id = '$user_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $user = $this->db->fetch_array($result);  
            return $user;
        }
        
        public function insert(&$user){
            
            $date_expire = date("Y-m-d",strtotime("+90 days"));
     
            $table = "helpdesk_user";
            $field = "user_code, employee_code, first_name, last_name, email, email2, company_id, cus_company_id, org_id, transfer_incident_permission, advance_search_permission,admin_permission,user_login,pass,user_status,edit_report_permission,
                        approve_report_permission,created_by,created_date,modified_by,modified_date,pass_expire,pass_count";
            $data = "'{$user["user_code"]}', '{$user["employee_code"]}', '{$user["first_name"]}', '{$user["last_name"]}', 
                      '{$user["email"]}', '{$user["email"]}', '{$user["company_id"]}', '{$user["cus_company_id"]}', '{$user["subgrp_id"]}', '{$user["transfer_incident_permission"]}', '{$user["advance_search_permission"]}', '{$user["admin_permission"]}', '{$user["user_login"]}',
                      '{$user["pass"]}', '1', '{$user["edit_report_permission"]}', '{$user["approve_report_permission"]}',
                      '{$user["created_by"]}', '{$user["created_date"]}', '{$user["modified_by"]}', '{$user["modified_date"]}',
                      '{$date_expire}', 'N' ";
                      

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $user["user_id"] = $this->db->insert_id();
            }
//            if($user["admin"] != "Y"){
//            /*insert tb_access_group_sale for Create Incident permission*/
//            if($user["create_incident"]== 1){
//                $access_group_id = 3;
//            }else{
//                $access_group_id = 1;
//            }
//            $table = "tb_access_group_sale";
//            $field = "access_group_id, sale_id";
//            $data = "'{$access_group_id}', '{$user["user_id"]}' ";
//            
//            $result = $this->db->insert($table, $field, $data);
//            }
            
            return $result;
        }
        
        public function update($user){
            
            
            $table = "helpdesk_user";
            $data = "user_code = '{$user["user_code"]}'"
                        . ", employee_code = '{$user["employee_code"]}'"
                        . ", first_name = '{$user["first_name"]}'"
                        . ", last_name = '{$user["last_name"]}'"
                        . ", email = '{$user["email"]}'"
                        . ", email2 = '{$user["email"]}'"
                        . ", company_id = '{$user["company_id"]}'"
						. ", cus_company_id = '{$user["cus_company_id"]}'"
                        . ", org_id = '{$user["subgrp_id"]}'"
                        . ", transfer_incident_permission = '{$user["transfer_incident_permission"]}'"
						. ", advance_search_permission = '{$user["advance_search_permission"]}'"
                        . ", admin_permission = '{$user["admin_permission"]}'"
                        . ", user_login = '{$user["user_login"]}'"
                        //. ", pass_count= '{$user["pass_count"]}'"
                        //. ", user_status = '{$user["user_status"]}'"
                        . ", edit_report_permission = '{$user["edit_report_permission"]}'"
                        . ", approve_report_permission = '{$user["approve_report_permission"]}'"
                        . ", modified_by = '{$user["modified_by"]}'"
                        . ", modified_date = '{$user["modified_date"]}'";
                        
            $condition = "user_id = '{$user["user_id"]}'";
            $result = $this->db->update($table, $data, $condition);
            
            /*update tb_access_group_sale for Create Incident permission*/
//            if($user["admin"] != "Y"){
//            if($user["create_incident"]== 1){
//                $access_group_id = 3;
//            }else{
//                $access_group_id = 1;
//            }
//            $table = "tb_access_group_sale";
//            $data = "access_group_id= '{$access_group_id}' ";
//            $condition = "sale_id = '{$user["user_id"]}'";
//            $result = $this->db->update($table, $data, $condition);
//            }
            if($user["s_pass_count"] != 'N'){
                $table = "helpdesk_user";
                $data = "pass_count= '{$user["pass_count"]}' ";
                $condition = "user_id = '{$user["user_id"]}'";
                $result = $this->db->update($table, $data, $condition);
                
            }
            
            //update pass_expire
            if($user["s_password"] != $user["ss_password"]){
                $date_expire = date("Y-m-d",strtotime("+90 days"));
                $table = "helpdesk_user";
                $data = "pass_expire= '{$date_expire}', pass= '{$user["pass"]}', pass_count = 'N' ";
                $condition = "user_id = '{$user["user_id"]}'";
                $result = $this->db->update($table, $data, $condition); 
            }
            

            return $result;
        }
        
        public function delete($objective){
            $result = $this->deleteWithUpdate("helpdesk_user", "user_status", "0", "user_id = '$objective'");
            $result =  $this->deleteWithoutUpdate("tb_access_group_sale", "sale_id = '$objective'");

            return $result;
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_user", "user_status", "1", "user_id = '$objective'");
        }
        
        
    }
?>
