<?php
    include_once "model.class.php";

    class Opr_tier3 extends model {

        public function listCombo($cas_opr_tier_id1 = "",$cas_opr_tier_id2 = "", $cus_company_id = ""){
            /*$sql = " SELECT opr_tier_id, opr_tier_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 3"
                    . " ORDER BY opr_tier_id";*/
		
			$sql = " SELECT opr_tier_id, opr_tier_name"  
                    . " FROM helpdesk_tr_opr_tier o1"
                    . " LEFT JOIN helpdesk_opr_tier o2 ON o1.opr_tier_lv3_id = o2.opr_tier_id";

            if (strUtil::isNotEmpty($cas_opr_tier_id1) || strUtil::isNotEmpty($cas_opr_tier_id2) || strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE opr_tier_lv1_id = '$cas_opr_tier_id1' AND opr_tier_lv2_id = '$cas_opr_tier_id2'";
				$sql .= " AND cus_comp_id = '$cus_company_id'";
            }

            $sql .= " ORDER BY opr_tier_lv3_id";		//exit;	


            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        
        
        public function countCombo($cas_opr_tier_id1 = "",$cas_opr_tier_id2 = "", $cus_company_id = ""){
            /*$sql = " SELECT opr_tier_id, opr_tier_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 3"
                    . " ORDER BY opr_tier_id";*/
		
			$sql = " SELECT opr_tier_id, opr_tier_name"  
                    . " FROM helpdesk_tr_opr_tier o1"
                    . " LEFT JOIN helpdesk_opr_tier o2 ON o1.opr_tier_lv3_id = o2.opr_tier_id";

            if (strUtil::isNotEmpty($cas_opr_tier_id1) || strUtil::isNotEmpty($cas_opr_tier_id2) || strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE opr_tier_lv1_id = '$cas_opr_tier_id1' AND opr_tier_lv2_id = '$cas_opr_tier_id2'";
				$sql .= " AND cus_comp_id = '$cus_company_id'";
            }

            $sql .= " ORDER BY opr_tier_lv3_id";		//exit;	


            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return 0;

//            while($row = $this->db->fetch_array($result)){
//                $arr[] = $row;
//            }

            return $rows;
        }
        
        public function listCombo_master($cus_company_id=""){
            $sql = " SELECT opr_tier_id, opr_tier_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 3";
            
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
