<?php
    include_once "model.class.php";

    class Satisfacation extends model {

        public function listCombo($cus_company_id = ""){
            $sql = " SELECT satisfac_id,satisfac_desc"
                    . " FROM helpdesk_satisfaction";

			if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE cus_company_id = $cus_company_id";
            }

            $sql .= " ORDER BY satisfac_id";
			

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
