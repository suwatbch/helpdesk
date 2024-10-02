<?php
    include_once "model.class.php";

    class helpdesk_grp extends model {

        public function listCombo($assign_comp_id = "", $assign_org_id=""){
            /*$sql = " SELECT org_id as assign_group_id, org_name as assign_group_name"
                    . " FROM helpdesk_org"
                    . " WHERE org_comp = 2"
                    . " AND LENGTH(org_code) = 4"
                    . " ORDER BY org_name";
					*/
			$sql = " SELECT org_id as assign_group_id, org_name as assign_group_name"
                    . " FROM helpdesk_org"
                    . " WHERE LENGTH(org_code) = 4";
					
            if (strUtil::isNotEmpty($assign_comp_id) && strUtil::isNotEmpty($assign_org_id)){
                $sql .= " AND org_comp = $assign_comp_id"; //exit;
            }
			
            $sql .= " ORDER BY org_name"; //exit;

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function listCombo_master($company_id = ""){
            /*$sql = " SELECT org_id as assign_group_id, org_name as assign_group_name"
                    . " FROM helpdesk_org"
                    . " WHERE org_comp = 2"
                    . " AND LENGTH(org_code) = 4"
                    . " ORDER BY org_name";
					*/
			$sql = " SELECT org_id, org_name"
                    . " FROM helpdesk_org"
                    . " WHERE LENGTH(org_code) = 4";
					
            if (strUtil::isNotEmpty($company_id)){
                $sql .= " AND org_comp = $company_id"; //exit;
            }
			
            $sql .= " ORDER BY org_name"; //exit;

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
