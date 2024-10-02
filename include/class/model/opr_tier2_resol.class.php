<?php
    include_once "model.class.php";

    class Opr_tier2_resol extends model {

        public function listCombo($resol_oprtier1 = "",$cus_company_id = ""){
            /*$sql = " SELECT opr_tier_id as resol_oprtier2_id, opr_tier_name as resol_oprtier2_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 2"
                    . " ORDER BY opr_tier_id";*/
					
			$sql = " SELECT opr_tier_id as resol_oprtier2_id, opr_tier_name as resol_oprtier2_name"  
                    . " FROM helpdesk_tr_opr_tier o1"
                    . " LEFT JOIN helpdesk_opr_tier o2 ON o1.opr_tier_lv2_id = o2.opr_tier_id";

            if (strUtil::isNotEmpty($resol_oprtier1) && strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE opr_tier_lv1_id = '$resol_oprtier1'";
                $sql .= " AND cus_comp_id = $cus_company_id";
            }

            $sql .= " ORDER BY opr_tier_lv2_id";		//exit;	

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
