<?php
    include_once "model.class.php";

    class helpdesk_opr extends model {
        
        public function list_opr_sla($cus_company_id){
            $sql = " SELECT tro.tr_opr_tier_id, CONCAT(o1.opr_tier_name,' / ',o2.opr_tier_name,'',IF (tro.opr_tier_lv3_id=0, '', CONCAT(' /', o3.opr_tier_name))) as opr_name"
                    . " FROM helpdesk_tr_opr_tier tro"
                    . " LEFT JOIN helpdesk_opr_tier o1 on(tro.opr_tier_lv1_id=o1.opr_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier o2 on(tro.opr_tier_lv2_id=o2.opr_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier o3 on(tro.opr_tier_lv3_id=o3.opr_tier_id)";

			if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE tro.cus_company_id = $cus_company_id";
            }

            $sql .= " ORDER BY o1.opr_tier_name asc";
			
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function opr_sla1($tr_opr_tier_id){
            $sql = " SELECT p1.opr_tier_name"
                    . " FROM helpdesk_tr_opr_tier trp"
                    . " LEFT JOIN helpdesk_opr_tier p1 on(trp.opr_tier_lv1_id=p1.opr_tier_id)";
            $sql .= " WHERE trp.tr_opr_tier_id = $tr_opr_tier_id";
	
            $result = $this->db->query($sql);
            $f_result = $row = $this->db->fetch_array($result);
            $opr_tier_name = $f_result["opr_tier_name"];

            return $opr_tier_name;
        }
        public function opr_sla2($tr_opr_tier_id){
            $sql = " SELECT p1.opr_tier_name"
                    . " FROM helpdesk_tr_opr_tier trp"
                    . " LEFT JOIN helpdesk_opr_tier p1 on(trp.opr_tier_lv2_id=p1.opr_tier_id)";
            $sql .= " WHERE trp.tr_opr_tier_id = $tr_opr_tier_id";
	
            $result = $this->db->query($sql);
            $f_result = $row = $this->db->fetch_array($result);
            $opr_tier_name = $f_result["opr_tier_name"];

            return $opr_tier_name;
        }
        public function opr_sla3($tr_opr_tier_id){
            $sql = " SELECT p1.opr_tier_name"
                    . " FROM helpdesk_tr_opr_tier trp"
                    . " LEFT JOIN helpdesk_opr_tier p1 on(trp.opr_tier_lv3_id=p1.opr_tier_id)";
            $sql .= " WHERE trp.tr_opr_tier_id = $tr_opr_tier_id";
	
            $result = $this->db->query($sql);
            $f_result = $row = $this->db->fetch_array($result);
            $opr_tier_name = $f_result["opr_tier_name"];

            return $opr_tier_name;
        }
        
        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "p.*,c.cus_company_name";

            # table
            $table = "helpdesk_opr_tier p"
                      . " LEFT JOIN helpdesk_cus_company c on(p.cus_comp_id=c.cus_company_id)";

            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY p.opr_tier_name asc";

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
            $field = "p.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_opr_tier p"
                        . " LEFT JOIN helpdesk_user u1 ON (p.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (p.modified_by = u2.user_id)";
            $condition = "p.opr_tier_id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_opr_tier", "status", "D", "opr_tier_id = '$objective'");
             return $this->deleteWithoutUpdate("helpdesk_opr_tier", "opr_tier_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_opr_tier", "status", "A", "opr_tier_id = '$objective'");
        }
        
        public function insert(&$objective){
            $table = "helpdesk_opr_tier";
            $field = "cus_comp_id, opr_tier_name, opr_tier_level, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["cus_comp_id"]}', '{$objective["opr_tier_name"]}', '{$objective["opr_tier_level"]}', '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["opr_tier_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_opr_tier";
            $data = "cus_comp_id = '{$objective["cus_comp_id"]}'"
                        . ", opr_tier_name = '{$objective["opr_tier_name"]}'"
                        . ", opr_tier_level = '{$objective["opr_tier_level"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            $condition = "opr_tier_id = '{$objective["opr_tier_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
