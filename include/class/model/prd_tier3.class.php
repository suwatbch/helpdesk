<?php
    include_once "model.class.php";

    class Prd_tier3 extends model {

        public function listCombo($cas_prd_tier_id1 = "",$cas_prd_tier_id2 = "",$cus_company_id = ""){
            /*$sql = " SELECT prd_tier_id, prd_tier_name"
                    . " FROM helpdesk_prd_tier"
                    . " WHERE prd_tier_level = 3"
                    . " ORDER BY prd_tier_id";*/
            $sql = " ";
                    if ($nonclass == "Y"){
                        $sql .= " select 0 as prd_tier_id , '' as prd_tier_name UNION ";
                    }
			$sql .= " SELECT DISTINCT prd_tier_id, prd_tier_name"  
                    . " FROM helpdesk_tr_prd_tier p1"
                    . " LEFT JOIN helpdesk_prd_tier p2 ON p1.prd_tier_lv3_id = p2.prd_tier_id";

            if (strUtil::isNotEmpty($cas_prd_tier_id1) && strUtil::isNotEmpty($cas_prd_tier_id2) && strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE prd_tier_lv1_id = '$cas_prd_tier_id1' AND prd_tier_lv2_id = '$cas_prd_tier_id2'";
            }

           
            $sql .= " ORDER BY prd_tier_lv3_id";
            
           		//exit;	
			
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        
        public function listnonClass3($cas_prd_tier_id1 = "",$cas_prd_tier_id2 = "",$cus_company_id = "",$nonclass = ""){
            /*$sql = " SELECT prd_tier_id, prd_tier_name"
                    . " FROM helpdesk_prd_tier"
                    . " WHERE prd_tier_level = 3"
                    . " ORDER BY prd_tier_id";*/
            $sql = " ";
                    if ($nonclass == "Y"){
                        $sql .= " select 0 as prd_tier_id , '' as prd_tier_name UNION ";
                    }
			$sql .= " SELECT DISTINCT prd_tier_id, prd_tier_name"  
                    . " FROM helpdesk_tr_prd_tier p1"
                    . " LEFT JOIN helpdesk_prd_tier p2 ON p1.prd_tier_lv3_id = p2.prd_tier_id";

            if (strUtil::isNotEmpty($cas_prd_tier_id1) && strUtil::isNotEmpty($cas_prd_tier_id2) && strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE prd_tier_lv1_id = '$cas_prd_tier_id1' AND prd_tier_lv2_id = '$cas_prd_tier_id2'";
            }

           
            $sql .= " ORDER BY prd_tier_name";
            
           		//exit;	
			
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function listCombo_report($cas_prd_tier_id1 = "",$cas_prd_tier_id2 = "",$cus_company_id = ""){
            /*$sql = " SELECT prd_tier_id, prd_tier_name"
                    . " FROM helpdesk_prd_tier"
                    . " WHERE prd_tier_level = 3"
                    . " ORDER BY prd_tier_id";*/

			$sql = " SELECT DISTINCT prd_tier_id, prd_tier_name"  
                    . " FROM helpdesk_tr_prd_tier p1"
                    . " LEFT JOIN helpdesk_prd_tier p2 ON p1.prd_tier_lv3_id = p2.prd_tier_id";

            if (strUtil::isNotEmpty($cas_prd_tier_id1) && strUtil::isNotEmpty($cas_prd_tier_id2) && strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE prd_tier_lv1_id = '$cas_prd_tier_id1' AND prd_tier_lv2_id = '$cas_prd_tier_id2'";
            }

           
            $sql .= " ORDER BY prd_tier_name";
            
           		//exit;	
			
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function listCombo_master($cus_company_id = ""){
            $sql = " SELECT prd_tier_id, prd_tier_name"
                    . " FROM helpdesk_prd_tier"
                    . " WHERE prd_tier_level = 3";

            if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " AND cus_comp_id = '$cus_company_id'";
            }

            $sql .= " ORDER BY prd_tier_name asc";		// exit;	
			
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        
        public function listnonClass3_BPM($cas_prd_tier_id1 = "",$cas_prd_tier_id2 = "",$cus_company_id = "",$nonclass = ""){
            /*$sql = " SELECT prd_tier_id, prd_tier_name"
                    . " FROM helpdesk_prd_tier"
                    . " WHERE prd_tier_level = 3"
                    . " ORDER BY prd_tier_id";*/
            $sql = " ";
                    if ($nonclass == "Y"){
                        $sql .= " select 0 as prd_tier_id , '' as prd_tier_name, 0 as lv2 UNION ";
                    }
			$sql .= " SELECT DISTINCT prd_tier_id, prd_tier_name , p1.prd_tier_lv2_id as lv2"  
                    . " FROM helpdesk_tr_prd_tier p1"
                    . " LEFT JOIN helpdesk_prd_tier p2 ON p1.prd_tier_lv3_id = p2.prd_tier_id " ;

            if (strUtil::isNotEmpty($cas_prd_tier_id1) && strUtil::isNotEmpty($cas_prd_tier_id2) && strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE prd_tier_lv1_id = '$cas_prd_tier_id1' AND prd_tier_lv2_id = '$cas_prd_tier_id2'";
            }

           
            $sql .= " ORDER BY prd_tier_name";
            
           		//exit;	
			
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
