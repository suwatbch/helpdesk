<?php
    include_once "model.class.php";

    class helpdesk_opr_com extends model {
        
        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "p.*, c.cus_company_name, op1.opr_tier_name as opr_name1, op2.opr_tier_name as opr_name2, op3.opr_tier_name as opr_name3";

            # table
            $table = "helpdesk_tr_opr_tier p"
                    . " LEFT JOIN helpdesk_cus_company c on(p.cus_company_id=c.cus_company_id)"
                    . " LEFT JOIN helpdesk_opr_tier op1 on(p.opr_tier_lv1_id=op1.opr_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier op2 on(p.opr_tier_lv2_id=op2.opr_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier op3 on(p.opr_tier_lv3_id=op3.opr_tier_id)";

            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY c.cus_company_name asc";

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
            $table = " helpdesk_tr_opr_tier p"
                        . " LEFT JOIN helpdesk_user u1 ON (p.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (p.modified_by = u2.user_id)";
            $condition = "p.tr_opr_tier_id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_tr_opr_tier", "status", "D", "tr_opr_tier_id = '$objective'");
             return $this->deleteWithoutUpdate("helpdesk_tr_opr_tier", "tr_opr_tier_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_tr_opr_tier", "status", "A", "tr_opr_tier_id = '$objective'");
        }
        
        public function insert(&$objective){
            $table = "helpdesk_tr_opr_tier";
            $field = "cus_company_id, opr_tier_lv1_id, opr_tier_lv2_id, opr_tier_lv3_id, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["cus_comp_id"]}', '{$objective["opr_tier_lv1_id"]}', '{$objective["opr_tier_lv2_id"]}', '{$objective["opr_tier_lv3_id"]}', '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["tr_opr_tier_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_tr_opr_tier";
            $data = "cus_company_id = '{$objective["cus_comp_id"]}'"
                        . ", opr_tier_lv1_id = '{$objective["opr_tier_lv1_id"]}'"
                        . ", opr_tier_lv2_id = '{$objective["opr_tier_lv2_id"]}'"
                        . ", opr_tier_lv3_id = '{$objective["opr_tier_lv3_id"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            $condition = "tr_opr_tier_id = '{$objective["tr_opr_tier_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
