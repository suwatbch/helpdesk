<?php
    include_once "model.class.php";

    class helpdesk_respond extends model {
        
        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "rp.*, c.cus_company_name, p1.prd_tier_name as prd_name_class1, p2.prd_tier_name as prd_name_class2,
                        p3.prd_tier_name as prd_name_class3, o1.opr_tier_name as opr_name_class1, o2.opr_tier_name as opr_name_class2,
                        o3.opr_tier_name as opr_name_class3";
            # table
            $table = "helpdesk_respond rp"
                    . " LEFT JOIN helpdesk_cus_company c on(rp.cus_comp_id=c.cus_company_id)"
                    . " LEFT JOIN helpdesk_tr_prd_tier trp on(rp.tr_prd_tier_id=trp.tr_prd_tier_id)"
                    . " LEFT JOIN helpdesk_tr_opr_tier tro on(rp.tr_opr_tier_id=tro.tr_opr_tier_id)"
                    . " LEFT JOIN helpdesk_prd_tier p1 on(trp.prd_tier_lv1_id=p1.prd_tier_id)"
                    . " LEFT JOIN helpdesk_prd_tier p2 on(trp.prd_tier_lv2_id=p2.prd_tier_id)"
                    . " LEFT JOIN helpdesk_prd_tier p3 on(trp.prd_tier_lv3_id=p3.prd_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier o1 on(tro.opr_tier_lv1_id=o1.opr_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier o2 on(tro.opr_tier_lv2_id=o2.opr_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier o3 on(tro.opr_tier_lv3_id=o3.opr_tier_id)";

            # condition
            $condition = "1=1 ";
            $condition .= " group by rp.tr_prd_tier_id,rp.tr_opr_tier_id ORDER BY c.cus_company_name asc ";

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
        
        public function search_respond_priority($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "rp.*, c.cus_company_name, p1.prd_tier_name as prd_name_class1, p2.prd_tier_name as prd_name_class2,
                        p3.prd_tier_name as prd_name_class3, o1.opr_tier_name as opr_name_class1, o2.opr_tier_name as opr_name_class2,
                        o3.opr_tier_name as opr_name_class3";
            # table
            $table = "helpdesk_respond_priority rp"
                    . " LEFT JOIN helpdesk_cus_company c on(rp.cus_comp_id=c.cus_company_id)"
                    . " LEFT JOIN helpdesk_tr_prd_tier trp on(rp.tr_prd_tier_id=trp.tr_prd_tier_id)"
                    . " LEFT JOIN helpdesk_tr_opr_tier tro on(rp.tr_opr_tier_id=tro.tr_opr_tier_id)"
                    . " LEFT JOIN helpdesk_prd_tier p1 on(trp.prd_tier_lv1_id=p1.prd_tier_id)"
                    . " LEFT JOIN helpdesk_prd_tier p2 on(trp.prd_tier_lv2_id=p2.prd_tier_id)"
                    . " LEFT JOIN helpdesk_prd_tier p3 on(trp.prd_tier_lv3_id=p3.prd_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier o1 on(tro.opr_tier_lv1_id=o1.opr_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier o2 on(tro.opr_tier_lv2_id=o2.opr_tier_id)"
                    . " LEFT JOIN helpdesk_opr_tier o3 on(tro.opr_tier_lv3_id=o3.opr_tier_id)";

            # condition
            $condition = "1=1 ";
            //$condition .= " group by rp.tr_prd_tier_id,rp.tr_opr_tier_id ORDER BY c.cus_company_name asc ";
            $condition .= " ORDER BY c.cus_company_name asc ";

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
            global $objective_re;
            
            $field = "rp.*, p1.prd_tier_name as prd_name_class1, p2.prd_tier_name as prd_name_class2,
                        p3.prd_tier_name as prd_name_class3, o1.opr_tier_name as opr_name_class1, o2.opr_tier_name as opr_name_class2,
                        o3.opr_tier_name as opr_name_class3"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_respond_priority rp"
                        . " LEFT JOIN helpdesk_tr_prd_tier trp on(rp.tr_prd_tier_id=trp.tr_prd_tier_id)"
                        . " LEFT JOIN helpdesk_tr_opr_tier tro on(rp.tr_opr_tier_id=tro.tr_opr_tier_id)"
                        . " LEFT JOIN helpdesk_prd_tier p1 on(trp.prd_tier_lv1_id=p1.prd_tier_id)"
                        . " LEFT JOIN helpdesk_prd_tier p2 on(trp.prd_tier_lv2_id=p2.prd_tier_id)"
                        . " LEFT JOIN helpdesk_prd_tier p3 on(trp.prd_tier_lv3_id=p3.prd_tier_id)"
                        . " LEFT JOIN helpdesk_opr_tier o1 on(tro.opr_tier_lv1_id=o1.opr_tier_id)"
                        . " LEFT JOIN helpdesk_opr_tier o2 on(tro.opr_tier_lv2_id=o2.opr_tier_id)"
                        . " LEFT JOIN helpdesk_opr_tier o3 on(tro.opr_tier_lv3_id=o3.opr_tier_id)"
                        . " LEFT JOIN helpdesk_user u1 ON (rp.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (rp.modified_by = u2.user_id)";
            $condition = "rp.id_respond_priority = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective_re = $this->db->fetch_array($result);
            
            $s_cus_comp_id = $objective_re["cus_comp_id"];
            $s_tr_prd_tier_id = $objective_re["tr_prd_tier_id"];
            $s_tr_opr_tier_id = $objective_re["tr_opr_tier_id"];
            
            $table = "helpdesk_respond rs";
            $field = "priority_id";
            $condition = "rs.cus_comp_id = '$s_cus_comp_id' and rs.tr_prd_tier_id = '$s_tr_prd_tier_id' and rs.tr_opr_tier_id = '$s_tr_opr_tier_id' and rs.id_respond_priority = '$objective' group by rs.priority_id";
            $result_pri = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);
            if($rows > 0){
                while($row = $this->db->fetch_array($result_pri)){
                    $objective_re["data_priority"][] = $row;
                }
            }

            return $objective_re;
        }

        public function delete($objective){
//            $field = "cus_comp_id,tr_prd_tier_id,tr_opr_tier_id";
//            $table = " helpdesk_respond rp";           
//            $condition = "id_respond = '$objective'";
//            $result = $this->db->select($field, $table, $condition);
//            $rows = $this->db->num_rows($result);
//
//            if ($rows == 0) return null;
//
//            $objective_re = $this->db->fetch_array($result);
//            
//            $s_cus_comp_id = $objective_re["cus_comp_id"];
//            $s_tr_prd_tier_id = $objective_re["tr_prd_tier_id"];
//            $s_tr_opr_tier_id = $objective_re["tr_opr_tier_id"];
//            
//            $sql_deleted = "delete from helpdesk_respond where cus_comp_id = '{$s_cus_comp_id}' 
//                and tr_prd_tier_id = '{$s_tr_prd_tier_id}' and tr_opr_tier_id = '{$s_tr_opr_tier_id}'";
//            
//            return $result_de = $this->db->query($sql_deleted);
            $sql_deleted01 = "delete from helpdesk_respond_priority where id_respond_priority = '{$objective}'";
            $result_de01 = $this->db->query($sql_deleted01);
            
            $sql_deleted = "delete from helpdesk_respond where id_respond_priority = '{$objective}'";

            return $result_de = $this->db->query($sql_deleted);
            
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_respond", "status", "A", "id_respond = '$objective'");
        }
        
        public function insert(&$objective){
            
            $table = "helpdesk_respond_priority";
            $field = "cus_comp_id, priority_id, tr_prd_tier_id, tr_opr_tier_id, created_by, created_date, modified_by, modified_date, respond_sla";
            $data = "'{$objective["cus_comp_id"]}', '{$objective["sum_priority"]}', '{$objective["tr_prd_tier_id"]}', '{$objective["tr_opr_tier_id"]}',
                '{$objective["created_by"]}', '{$objective["created_date"]}', '{$objective["modified_by"]}',
                '{$objective["modified_date"]}', '{$objective["respond_sla"]}'";

            $result = $this->db->insert($table, $field, $data);
            $objective["id_respond_priority"] = $this->db->insert_id();
            
            
            for($i=0;$i<count($objective["chk_priority"]);$i++)
{
	if(trim($objective["chk_priority"][$i]) != "")
	{
		$table = "helpdesk_respond";
            $field = "cus_comp_id, tr_prd_tier_id, tr_opr_tier_id, respond_sla, status, created_by, created_date, modified_by, modified_date, priority_id, sum_respond_sla, id_respond_priority";
            $data = "'{$objective["cus_comp_id"]}', '{$objective["tr_prd_tier_id"]}', '{$objective["tr_opr_tier_id"]}', '{$objective["respond_sla"]}',
                '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]},
                '{$objective["modified_date"]}', '{$objective["chk_priority"][$i]}', '{$objective["sum_respond_sla"]}', '{$objective["id_respond_priority"]}'";

            $result = $this->db->insert($table, $field, $data);
	}
}
            

            if ($result){
                $objective["id_respond_priority"] = $objective["id_respond_priority"];
            }

            return $result;
        }

        public function update($objective){
//            $field = "cus_comp_id,tr_prd_tier_id,tr_opr_tier_id";
//            $table = " helpdesk_respond rp";           
//            $condition = "id_respond = '{$objective["id_respond"]}'";
//            $result = $this->db->select($field, $table, $condition);
//            $rows = $this->db->num_rows($result);
//
//            if ($rows == 0) return null;
//
//            $objective_re = $this->db->fetch_array($result);
//            
//            $s_cus_comp_id = $objective_re["cus_comp_id"];
//            $s_tr_prd_tier_id = $objective_re["tr_prd_tier_id"];
//            $s_tr_opr_tier_id = $objective_re["tr_opr_tier_id"];
//            
//            $sql_deleted = "delete from helpdesk_respond where cus_comp_id = '{$s_cus_comp_id}' 
//                and tr_prd_tier_id = '{$s_tr_prd_tier_id}' and tr_opr_tier_id = '{$s_tr_opr_tier_id}'";
//
//            return $result_de = $this->db->query($sql_deleted);
            $sql_deleted01 = "delete from helpdesk_respond_priority where id_respond_priority = '{$objective["id_respond_priority"]}'";
            $result_de01 = $this->db->query($sql_deleted01);
            
            $sql_deleted = "delete from helpdesk_respond where id_respond_priority = '{$objective["id_respond_priority"]}'";

            return $result_de = $this->db->query($sql_deleted);
        }
        
        public function list_priority(){
            $table = "helpdesk_priority";
            $field = "priority_id,priority_desc";
            $order_by = "priority_id asc";
            $result = $this->db->select($field, $table, "", $order_by);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $data[] = $row;
            }
            return array(
                "data" => $data
            );
        }
        
         public function search_list_priority($priority_id){
            $table = "helpdesk_priority";
            $field = "priority_id,priority_desc";
            $condition = "priority_id in($priority_id)";
            $order_by = "priority_id asc";
            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $data[] = $row;
            }
            return array(
                "data" => $data
            );
        } 
    }
?>
