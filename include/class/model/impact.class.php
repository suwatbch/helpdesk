<?php
    include_once "model.class.php";

    class Impact extends model {

        public function listCombo(){
            $sql = " SELECT impact_id, impact_desc"
                    . " FROM helpdesk_impact"
                    . " ORDER BY impact_id";

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
