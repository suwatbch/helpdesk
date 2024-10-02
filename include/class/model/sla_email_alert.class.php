<?php

include_once "model.class.php";

    class sla_email extends model {
        
        public function exists($company_id,$org_id, $group_id = 0, $sub_group_id = 0){
            $sql = "SELECT 1 
                FROM helpdesk_sla_email_alert
                WHERE company_id = $company_id
                AND org_id =  '$org_id' 
                AND grp_id = $group_id 
                AND subgrp_id = $sub_group_id  ";
            
//            echo $sql;
//            exit();
            
            $result = $this->db->query($sql);
            $total_row = $this->db->num_rows($result);

            if ($total_row == 0) {
                return 0;
            }else {
                return $total_row;
            }
        }
        
        
        public function update_sla($value){
            $table = " helpdesk_sla_email_alert ";
            $data = " on_sla_l1 = '{$value["on_sla_l1"]}',
                     on_sla_l1_to = '{$value["on_sla_l1_to"]}',
                     on_sla_l1_cc = '{$value["on_sla_l1_cc"]}',
                     on_sla_l2 = '{$value["on_sla_l2"]}',
                     on_sla_l2_to = '{$value["on_sla_l2_to"]}',
                     on_sla_l2_cc = '{$value["on_sla_l2_cc"]}',
                     on_sla_l3 = '{$value["on_sla_l3"]}',
                     on_sla_l3_to = '{$value["on_sla_l3_to"]}',
                     on_sla_l3_cc = '{$value["on_sla_l3_cc"]}',
                     over_sla_l1 = '{$value["over_sla_l1"]}',
                     over_sla_l1_to = '{$value["over_sla_l1_to"]}',
                     over_sla_l1_cc = '{$value["over_sla_l1_cc"]}',
                     over_sla_l2 = '{$value["over_sla_l2"]}',
                     over_sla_l2_to = '{$value["over_sla_l2_to"]}',
                     over_sla_l2_cc = '{$value["over_sla_l2_cc"]}',
                     over_sla_l3 = '{$value["over_sla_l3"]}',
                     over_sla_l3_to = '{$value["over_sla_l3_to"]}',
                     over_sla_l3_cc = '{$value["over_sla_l3_cc"]}',
                     deduct_pending = '{$value["deduct_pending"]}',
                     modify_by = '{$value["user_id"]}',
                     modify_date = NOW() ";
            
            $condition = " 1 = 1 "
                    . " AND grp_id = {$value["group_id"]} "
                    . " AND subgrp_id = {$value["sub_group_id"]} ";
            
            if (strUtil::isNotEmpty($value["comp_id"])){
                $condition .= " and company_id = {$value["comp_id"]} ";
            }
            
            if (strUtil::isNotEmpty($value["org_id"])){
                $condition .= " and org_id = {$value["org_id"]} ";
            }
            
            $result = $this->db->update($table, $data, $condition);
            return $result;
            
        }
        
        
        
        public function insert_sla($value){
           $table = " helpdesk_sla_email_alert";
           $field = " company_id, org_id, grp_id , subgrp_id,
                    on_sla_l1, on_sla_l1_to, on_sla_l1_cc, 
                    on_sla_l2, on_sla_l2_to, on_sla_l2_cc, 
                    on_sla_l3, on_sla_l3_to, on_sla_l3_cc, 
                    over_sla_l1, over_sla_l1_to, over_sla_l1_cc, 
                    over_sla_l2, over_sla_l2_to, over_sla_l2_cc, 
                    over_sla_l3, over_sla_l3_to, over_sla_l3_cc, 
                    deduct_pending, create_by, create_date, modify_by, modify_date ";
           
           $data =  " '{$value["comp_id"]}', '{$value["org_id"]}' , '{$value["group_id"]}', '{$value["sub_group_id"]}' ,"
                    . " '{$value["on_sla_l1"]}', '{$value["on_sla_l1_to"]}', '{$value["on_sla_l1_cc"]}', "
                    . " '{$value["on_sla_l2"]}', '{$value["on_sla_l2_to"]}', '{$value["on_sla_l2_cc"]}', "
                    . " '{$value["on_sla_l3"]}', '{$value["on_sla_l3_to"]}', '{$value["on_sla_l3_cc"]}', "
                    . " '{$value["over_sla_l1"]}', '{$value["over_sla_l1_to"]}', '{$value["over_sla_l1_cc"]}', "
                    . " '{$value["over_sla_l2"]}', '{$value["over_sla_l2_to"]}', '{$value["over_sla_l2_cc"]}', "
                    . " '{$value["over_sla_l3"]}', '{$value["over_sla_l3_to"]}', '{$value["over_sla_l3_cc"]}', "
                    . " '{$value["deduct_pending"]}', '{$value["user_id"]}', NOW() , '{$value["user_id"]}', NOW() " ;
                    
           $result = $this->db->insert($table, $field, $data);       

           return $result;
           
        }
        
        
        
        public function get_sla($comp_id, $org_id, $group_id = 0, $sub_group_id = 0){
           
            $sql = "select company_id, org_id, grp_id, subgrp_id, 
                    on_sla_l1, on_sla_l1_to, on_sla_l1_cc, 
                    on_sla_l2, on_sla_l2_to, on_sla_l2_cc, 
                    on_sla_l3, on_sla_l3_to, on_sla_l3_cc, 
                    over_sla_l1, over_sla_l1_to, over_sla_l1_cc, 
                    over_sla_l2, over_sla_l2_to, over_sla_l2_cc, 
                    over_sla_l3, over_sla_l3_to, over_sla_l3_cc, 
                    deduct_pending 
                    from helpdesk_sla_email_alert 
                    where grp_id = {$group_id} 
                    AND subgrp_id = {$sub_group_id} 
                    and company_id = {$comp_id} 
                    and org_id = {$org_id} ";
            
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
               
    }
?>
