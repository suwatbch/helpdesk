<?php
    include_once "model.class.php";

    class Opr_tier1_resol extends model {

        public function listCombo($cus_company_id = ""){
            $sql = " SELECT opr_tier_id as resol_oprtier1_id, opr_tier_name as resol_oprtier1_name"
                    . " FROM helpdesk_opr_tier"
                    . " WHERE opr_tier_level = 1";

            if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " AND cus_comp_id = $cus_company_id";
            }

            $sql .= " ORDER BY opr_tier_id";		//exit;	
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
