<?php
    include_once "model.class.php";

    class helpdesk_zone extends model {

        public function cuszone(){
            $sql = " SELECT zone_id , name"
                    . " FROM helpdesk_cus_zone"
                    . " ORDER BY name";

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
            $field = "z.*,c.cus_company_name";

            # table
            $table = "helpdesk_cus_zone z"
                      . " LEFT JOIN helpdesk_cus_company c on(z.cus_company_id=c.cus_company_id)";

            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY z.item asc";

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
            $field = "z.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_cus_zone z"
                        . " LEFT JOIN helpdesk_user u1 ON (z.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (z.modified_by = u2.user_id)";
            $condition = "z.zone_id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $company = $this->db->fetch_array($result);

            return $company;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_cus_zone", "status", "D", "zone_id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_cus_zone", "zone_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_cus_zone", "status", "A", "zone_id = '$objective'");
        }
        
        public function insert(&$objective){
            $field = "item";
            $table = "helpdesk_cus_zone";
            $condition = "1=1 order by item desc limit 0,1";
            $result = $this->db->select($field, $table, $condition);
            $f_item = $this->db->fetch_array($result);
            $s_item = $f_item["item"];
            $s_item = $s_item  + 1;
            
            $table = "helpdesk_cus_zone";
            $field = "cus_company_id, shortname, name, status, item, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["cus_company_id"]}', '{$objective["shortname"]}', '{$objective["name"]}', '{$objective["status"]}', '{$s_item}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["zone_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_cus_zone";
            $data = "cus_company_id = '{$objective["cus_company_id"]}'"
                        . ", shortname = '{$objective["shortname"]}'"
                        . ", name = '{$objective["name"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            $condition = "zone_id = '{$objective["zone_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
        
        
    }
?>
