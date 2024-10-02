<?php
    include_once "model.class.php";

    class customer_company extends model {

        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "*";

            # table
            $table = "helpdesk_cus_company";

            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY cus_company_name asc";

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

        public function getById($company_id){
            $field = "c.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_cus_company c"
                        . " LEFT JOIN helpdesk_user u1 ON (c.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (c.modified_by = u2.user_id)";
            $condition = "c.cus_company_id = '$company_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $company = $this->db->fetch_array($result);

            return $company;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_cus_company", "status", "D", "cus_company_id = '$company_id'");
            return $this->deleteWithoutUpdate("helpdesk_cus_company", "cus_company_id = '$objective'");
        }
        
        public function restore_master($company_id){
            return $this->deleteWithUpdate("helpdesk_cus_company", "status", "A", "cus_company_id = '$company_id'");
        }
        
        public function insert(&$company){
            $table = "helpdesk_cus_company";
            $field = "cus_company_name, cus_company_logo, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$company["cus_company_name"]}', '{$company["cus_company_logo"]}', '{$company["status"]}', '{$company["created_by"]}', '{$company["created_date"]}', {$company["modified_by"]}, '{$company["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $company["cus_company_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($company){
            $table = "helpdesk_cus_company";
            $data = "cus_company_name = '{$company["cus_company_name"]}'"
						. ", cus_company_logo = '{$company["cus_company_logo"]}'"
                        . ", status = '{$company["status"]}'"
                        . ", modified_date = '{$company["modified_date"]}'"
                        . ", modified_by = '{$company["modified_by"]}'";
            $condition = "cus_company_id = '{$company["cus_company_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
