<?php
    include_once "model.class.php";

    class change_log extends model {
        public function search($cratiria = null){
            $field = "*";
            $table = "helpdesk_tr_incident";
            $condition = "1=1 and status_id = '7' ";
            $condition .= " ORDER BY ident_id_run_project asc limit 0,10";
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $data[] = $row;
            }

            return array(
                "total_row" => $rows
                , "data" => $data
            );
        }
      
    }
?>
