<?php
    include_once "model.class.php";

    class position extends model {

        public function listCombo(){
            $field = "p.position_id, p.position_name";
            $table = " tb_position p";
            $condition = "p.position_status = 'A'";
            $order_by = "p.position_name";

            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();
            while($position = $this->db->fetch_array($result)){
                $arr_position[] = $position;
            }

            return $arr_position;
        }

        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "position_id, position_name, position_status";

            # table
            $table = "tb_position";

            # condition
            $condition = " position_status <> 'D'";
            if (strUtil::isNotEmpty($cratiria["position_name"])){
                $condition .= " AND position_name LIKE '%{$cratiria["position_name"]}%'";
            }

            $condition .= " ORDER BY position_name";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $data[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "data" => $data
            );            
        }
        
        public function isDuplicate($position){
            $table = "tb_position";

            # check duplicate position_name
            $condition = "position_status <> 'D' AND position_name = '{$position["position_name"]}'";
            if (strUtil::isNotEmpty($position["position_id"])){
                $condition .= " AND position_id <> '{$position["position_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "position_name";
            }

            return false;
        }

        public function getById($position_id){
            $field = "p.position_id, p.position_name, p.description, p.position_status"
                       . ", vs1.sale_full_name AS created_by, p.created_date"
                       . " , vs2.sale_full_name AS modified_by, p.modified_date";
            $table = " tb_position p"
                        . " LEFT JOIN v_tb_sale vs1 ON (p.created_by = vs1.sale_id)"
                        . " LEFT JOIN v_tb_sale vs2 ON (p.modified_by = vs2.sale_id)";
            $condition = "p.position_id = '$position_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $position = $this->db->fetch_array($result);

            return $position;
        }

        public function delete($position_id){
            return $this->deleteWithUpdate("tb_position", "position_status", "D", "position_id = '$position_id'");
        }

        public function insert(&$position){
            $table = "tb_position";
            $field = "position_name, description, position_status, created_by, created_date, modified_by, modified_date";
            $data = "'{$position["position_name"]}', '{$position["description"]}', '{$position["position_status"]}', '{$position["action_by"]}', '{$position["action_date"]}', '{$position["action_by"]}', '{$position["action_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $position["position_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($position){
            $table = "tb_position";
            $data = "position_name = '{$position["position_name"]}'"
                        . ", description = '{$position["description"]}'"
                        . ", position_status = '{$position["position_status"]}'"
                        . ", modified_by = '{$position["action_by"]}'"
                        . ", modified_date = '{$position["action_date"]}'";
            $condition = "position_id = '{$position["position_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
