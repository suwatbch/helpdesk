<?php
    include_once "model.class.php";

    class company extends model {
        
        function searchLookup($carteria) {
            $sql = " SELECT"
                     . "    company_id, company_code, company_name, short_name"
                     . " FROM tb_company"
                     . " WHERE status = 'A'"   ;

            if (strUtil::isNotEmpty($carteria["company_code"])) {
                $sql .= " AND company_code LIKE '%{$carteria["company_code"]}%'";
            }

            if (strUtil::isNotEmpty($carteria["company_name"])) {
                $sql .= " AND company_name LIKE '%{$carteria["company_name"]}%'";
            }

            $sql .= " ORDER BY company_code";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if($rows == 0) return array();

            while ($row = $this->db->fetch_array($result)){
                $arr_company[] = $row;
            }

            return $arr_company;
        }

        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "*";

            # table
            $table = "helpdesk_company";

            # condition
            $condition = "1=1 ";
//            if (strUtil::isNotEmpty($cratiria["company_name"])){
//                $condition .= " AND company_name LIKE '%{$cratiria["company_name"]}%'";
//            }

            $condition .= " ORDER BY company_name asc";

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
            $table = " helpdesk_company c"
                        . " LEFT JOIN helpdesk_user u1 ON (c.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (c.modified_by = u2.user_id)";
            $condition = "c.company_id = '$company_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $company = $this->db->fetch_array($result);

            return $company;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_company", "status_company", "D", "company_id = '$company_id'");
            return $this->deleteWithoutUpdate("helpdesk_company", "company_id = '$objective'");
        }
        
        public function restore_master($company_id){
            return $this->deleteWithUpdate("helpdesk_company", "status_company", "A", "company_id = '$company_id'");
        }
        
        public function insert(&$company){
            $table = "helpdesk_company";
            $field = "company_name, status_company, created_by, created_date, modified_by, modified_date";
            $data = "'{$company["company_name"]}', '{$company["status_company"]}', '{$company["created_by"]}', '{$company["created_date"]}', {$company["modified_by"]}, '{$company["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $company["company_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($company){
            $table = "helpdesk_company";
            $data = "company_name = '{$company["company_name"]}'"
                        . ", status_company = '{$company["status_company"]}'"
                        . ", modified_date = '{$company["modified_date"]}'"
                        . ", modified_by = '{$company["modified_by"]}'";
            $condition = "company_id = '{$company["company_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
