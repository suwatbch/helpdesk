<?php
    include_once "model.class.php";

    class helpdesk_area extends model {
        
        public function cusarea($comid){
	
            /*DEL 08/07/2022	
            $sql = " SELECT area_cus , area_cus_name "
                    . " FROM helpdesk_cus_zone_area"
                    . " ORDER BY area_cus_name asc";
	    */
 	     
            /*INS 08/07/2022 */	
	    if(!empty($comid))	
            {  		
	       $sql = " SELECT za.area_cus,za.area_cus_name"
                    . " FROM helpdesk_cus_zone_area AS za"
                    . " INNER JOIN helpdesk_cus_zone AS cz ON cz.zone_id = za.zone_id"
                    . " WHERE cz.cus_company_id = $comid"
                    . " ORDER BY za.area_cus_name asc";	
	    }
            else
            {
	       $sql = " SELECT area_cus , area_cus_name "
                    . " FROM helpdesk_cus_zone_area"
                    . " ORDER BY area_cus_name asc";
            }

	    /*INS 08/07/2022 */	

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
            $field = "za.*,zc.name";
            # table
            $table = "helpdesk_cus_zone_area za"
                      . " LEFT JOIN helpdesk_cus_zone zc on(za.zone_id=zc.zone_id)";
            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY za.area_cus asc";

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
        
        public function insert(&$objective){
            $table = "helpdesk_cus_zone_area";
            $field = "zone_id, area_cus, area_cus_name, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["zone_id"]}', '{$objective["area_cus"]}', '{$objective["area_cus_name"]}', '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_cus_zone_area";
            $data = "zone_id = '{$objective["zone_id"]}'"
                        . ", area_cus = '{$objective["area_cus"]}'"
                        . ", area_cus_name = '{$objective["area_cus_name"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            $condition = "id = '{$objective["id"]}'";

            return $this->db->update($table, $data, $condition);
        }
        
        public function getById($objective){
            $field = "za.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_cus_zone_area za"
                        . " LEFT JOIN helpdesk_user u1 ON (za.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (za.modified_by = u2.user_id)";
            $condition = "za.id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_cus_zone_area", "status", "D", "id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_cus_zone_area", "id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_cus_zone_area", "status", "A", "id = '$objective'");
        }
        
    }
?>
