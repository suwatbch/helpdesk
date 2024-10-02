<?php
    include_once "model.class.php";

    class Opr_tier2 extends model {

        public function listCombo($cas_opr_tier_id1 = "",$cus_company_id = ""){
            /*$sql = " SELECT opr_tier_id, opr_tier_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 2"
                    . " ORDER BY opr_tier_id";*/
 					
	       $sql = " SELECT opr_tier_id, opr_tier_name"  
                    . " FROM helpdesk_tr_opr_tier o1"
                    . " LEFT JOIN helpdesk_opr_tier o2 ON o1.opr_tier_lv2_id = o2.opr_tier_id"
                    . " WHERE opr_tier_lv1_id = '$cas_opr_tier_id1'";

            if (strUtil::isNotEmpty($cas_opr_tier_id1) || strUtil::isNotEmpty($cus_company_id)){
                $sql .= " AND o2.cus_comp_id = '$cus_company_id'";
            }

            $sql .= " ORDER BY opr_tier_lv2_id";		// exit;		
  	
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function listCombo_master($cus_company_id = ""){
            $sql = " SELECT opr_tier_id, opr_tier_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 2";
            
             if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " AND cus_comp_id = '$cus_company_id'";
            }

            $sql .= " ORDER BY opr_tier_name asc";	

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
