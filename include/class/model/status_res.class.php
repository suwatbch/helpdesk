<?php
    include_once "model.class.php";

    class status_res extends model {

        public function listCombo($status_id = ""){
			/*
            $sql = " SELECT status_res_id, status_res_desc"
                    . " FROM helpdesk_status_res"
                    . " ORDER BY status_res_id";
			*/
			
            $sql = " SELECT status_res_id, status_res_desc"
                    . " FROM helpdesk_status_res";

//            if (strUtil::isNotEmpty($status_id)){
//                $sql .= " WHERE status_id = '$status_id'";
//            }
            if($status_id == '5' || $status_id == '6' || $status_id == '7'){
                
                $sql .= " WHERE status_res_id = '5' or status_res_id = '6' or status_res_id = '8'";
            }else{
                $sql .= " WHERE status_id = '$status_id'";
            }
//            else if($status_id == '5'){
//                $sql .= " WHERE status_res_id = '5' or status_res_id = '6' or status_res_id = '8'";
//            }
//            else if($status_id == '6'){
//                $sql .= " WHERE status_res_id = '9' or status_res_id = '10' or status_res_id = '12'";
//            }
//             else if($status_id == '7'){
//                $sql .= " WHERE status_res_id = '13' or status_res_id = '14' or status_res_id = '16'";
//            }

            $sql .= " ORDER BY status_res_id";
			
			
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
