<?php
    include_once "model.class.php";

    class customer extends model {

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
        
         public function search($criteria = null, $page = 1){
            global $page_size;

            # field
            $field = "c.cus_id,c.code_cus,c.firstname_cus,c.lastname_cus,c.status_customer,cp.cus_company_name";

            # table
            $table = "helpdesk_customer c"
                     ." LEFT JOIN helpdesk_cus_company cp on(c.cus_company_id=cp.cus_company_id)"
                     ." LEFT JOIN helpdesk_cus_org org on(c.org_cus=org.cus_org_id)";
                    // ." LEFT JOIN helpdesk_cus_zone_area ar on(c.area_cus=ar.area_cus)";

            # condition
            $condition = "1=1 ";
            if (strUtil::isNotEmpty($criteria["search_customer"])){
                $condition .= " AND (c.code_cus LIKE '%{$criteria["search_customer"]}%' or c.firstname_cus LIKE '%{$criteria["search_customer"]}%' 
                    or c.lastname_cus LIKE '%{$criteria["search_customer"]}%' or cp.cus_company_name LIKE '%{$criteria["search_customer"]}%' )";
            }

            $condition .= " ORDER BY c.cus_id desc";

            $total_row = $this->db->count_rows($table, $condition);
            //$result = $this->db->select($field, $table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
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
        
        public function getById($customer_id){
           $field = "c.*"
                . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
           $table = "helpdesk_customer c"
                . " LEFT JOIN helpdesk_user u1 ON (c.created_by = u1.user_id)"
                . " LEFT JOIN helpdesk_user u2 ON (c.modified_by = u2.user_id)";
            $condition = "c.cus_id = '$customer_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $customer = $this->db->fetch_array($result);
             
            return $customer;
        }
        
        public function insert(&$customer){
            
            $table = "helpdesk_customer";
            $field = "code_cus, firstname_cus, lastname_cus, phone_cus, ipaddress_cus, email_cus, cus_company_id, org_cus, area_cus, office_cus, dep_cus, site_cus, status_customer,
                        created_by, created_date, modified_by, modified_date";
            $data = "'{$customer["code_cus"]}', '{$customer["firstname_cus"]}', '{$customer["lastname_cus"]}', '{$customer["phone_cus"]}', 
                      '{$customer["ipaddress_cus"]}', '{$customer["email_cus"]}', '{$customer["cus_company_id"]}', '{$customer["org_cus"]}', '{$customer["area_cus"]}', '{$customer["office_cus"]}', '{$customer["dep_cus"]}',
                      '{$customer["site_cus"]}', 'A', '{$customer["created_by"]}', '{$customer["created_date"]}', '{$customer["modified_by"]}', '{$customer["modified_date"]}' ";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $customer["cus_id"] = $this->db->insert_id();
            }
            
            return $result;
        }
        
        public function update($customer){
            
            
            $table = "helpdesk_customer";
            $data = "code_cus = '{$customer["code_cus"]}'"
                        . ", firstname_cus = '{$customer["firstname_cus"]}'"
                        . ", lastname_cus = '{$customer["lastname_cus"]}'"
                        . ", phone_cus = '{$customer["phone_cus"]}'"
                        . ", ipaddress_cus = '{$customer["ipaddress_cus"]}'"
                        . ", email_cus = '{$customer["email_cus"]}'"
                        . ", cus_company_id = '{$customer["cus_company_id"]}'"
                        . ", org_cus = '{$customer["org_cus"]}'"
                        . ", area_cus = '{$customer["area_cus"]}'"
                        . ", office_cus = '{$customer["office_cus"]}'"
                        . ", dep_cus = '{$customer["dep_cus"]}'"
                        . ", site_cus = '{$customer["site_cus"]}'"
                       // . ", status_customer = '{$customer["status_customer"]}'"
                        . ", modified_by = '{$customer["modified_by"]}'"
                        . ", modified_date = '{$customer["modified_date"]}'";
                        
            $condition = "cus_id = '{$customer["cus_id"]}'";
            $result = $this->db->update($table, $data, $condition);
            
            return $result;
        }
        
        public function delete($objective){
            return $this->deleteWithUpdate("helpdesk_customer", "status_customer", "I", "cus_id = '$objective'");
//            return $this->deleteWithoutUpdate("helpdesk_customer", "cus_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_customer", "status_customer", "A", "cus_id = '$objective'");
        }
        
    }
?>
