<?php
    include_once "model.class.php";

    class Org extends model {

        public function listCombo(){
            $sql = " SELECT org_id, org_name"
                    . " FROM helpdesk_org"
                    . " WHERE LENGTH(org_code) = 2"
                    . " AND org_comp = 2"
                    . " ORDER BY org_name";
			
			/*$sql = " SELECT org_id as assign_org_id, org_name as assign_org_name"
                    . " FROM helpdesk_org"
                    . " WHERE LENGTH(org_code) = 2";
					
            if (strUtil::isNotEmpty($assign_comp_id)){
                $sql .= " WHERE org_comp = 2";
            }
			
            echo $sql .= " ORDER BY org_name";*/

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
