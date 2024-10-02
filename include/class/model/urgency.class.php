<?php
    include_once "model.class.php";

    class Urgency extends model {

        public function listCombo(){
            $sql = " SELECT urgency_id, urgency_desc"
                    . " FROM helpdesk_urgency"
                    . " ORDER BY urgency_id";

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
