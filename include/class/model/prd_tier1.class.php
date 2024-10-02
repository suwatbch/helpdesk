<?php
    include_once "model.class.php";

    class Prd_tier1 extends model {

        public function listCombo($cus_company_id = ""){

            $sql = " SELECT prd_tier_id, prd_tier_name"
                    . " FROM helpdesk_prd_tier"
                    . " WHERE prd_tier_level = 1";

            if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " AND cus_comp_id = '$cus_company_id'";
            }

            $sql .= " ORDER BY prd_tier_id";		// exit;	
	    
            //echo $sql;

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