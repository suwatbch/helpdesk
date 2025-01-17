<?php
    include_once "model.class.php";

    class Opr_tier3_resol extends model {

        public function listCombo($resol_oprtier1="",$resol_oprtier2="",$cus_company_id = ""){
            /*$sql = " SELECT opr_tier_id as resol_oprtier3_id, opr_tier_name as resol_oprtier3_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 3"
                    . " ORDER BY opr_tier_id";*/
		
			$sql = " SELECT opr_tier_id as resol_oprtier3_id, opr_tier_name as resol_oprtier3_name"
                    . " FROM helpdesk_tr_opr_tier o1"
                    . " LEFT JOIN helpdesk_opr_tier o2 ON o1.opr_tier_lv3_id = o2.opr_tier_id";

            if (strUtil::isNotEmpty($resol_oprtier1) && strUtil::isNotEmpty($resol_oprtier2) && strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE opr_tier_lv1_id = '$resol_oprtier1' AND opr_tier_lv2_id = '$resol_oprtier2'";
                $sql .= " AND cus_comp_id = $cus_company_id";
            }

            $sql .= " ORDER BY opr_tier_lv3_id";		// exit;	

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function countCombo($resol_oprtier1="",$resol_oprtier2="",$cus_company_id = ""){
            /*$sql = " SELECT opr_tier_id as resol_oprtier3_id, opr_tier_name as resol_oprtier3_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 3"
                    . " ORDER BY opr_tier_id";*/
		
			$sql = " SELECT opr_tier_id as resol_oprtier3_id, opr_tier_name as resol_oprtier3_name"
                    . " FROM helpdesk_tr_opr_tier o1"
                    . " LEFT JOIN helpdesk_opr_tier o2 ON o1.opr_tier_lv3_id = o2.opr_tier_id";

            if (strUtil::isNotEmpty($resol_oprtier1) && strUtil::isNotEmpty($resol_oprtier2) && strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE opr_tier_lv1_id = '$resol_oprtier1' AND opr_tier_lv2_id = '$resol_oprtier2'";
                $sql .= " AND cus_comp_id = $cus_company_id";
            }

            $sql .= " ORDER BY opr_tier_lv3_id";		// exit;	

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return 0;

//            while($row = $this->db->fetch_array($result)){
//                $arr[] = $row;
//            }

            return $rows;
        }
    }
?>
