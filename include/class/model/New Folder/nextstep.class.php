<?php
    include_once "model.class.php";

    class nextstep extends model {

        public function getById($next_step_id){
            $field = "n.next_step_id, n.next_step_name, n.next_step_status"
                       . ", s1.sale_full_name AS created_by, n.created_date"
                       . " , s2.sale_full_name AS modified_by, n.modified_date";
            $table = " tb_next_step n"
                        . " LEFT JOIN v_tb_sale s1 ON (n.created_by = s1.sale_id)"
                        . " LEFT JOIN v_tb_sale s2 ON (n.modified_by = s2.sale_id)";
            $condition = "n.next_step_id = '$next_step_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $next_step = $this->db->fetch_array($result);

            return $next_step;
        }

        public function search($criteria, $page = 1){
            global $page_size;

            $field = "next_step_id, next_step_name, next_step_status, created_by, created_date, modified_by, modified_date";
            $table = " tb_next_step n";
            $condition = " n.next_step_status <> 'D' AND n.type <> 'SYS'"
                              . " ORDER BY n.next_step_name";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "data" => $arr
            );
        }
        
        public function listCombo(){
            $sql = " SELECT"
                    . "    CASE WHEN type = 'SYS' THEN 0 ELSE 1 END AS type"
                    . "    , next_step_id, next_step_name"
                    . " FROM tb_next_step"
                    . " WHERE next_step_status = 'A'"
                    . " ORDER BY type, next_step_name";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $next_step[] = $row ;
            }

            return $next_step;
        }

        public function isDuplicate($next_step){
            $table = "tb_next_step";

            # check duplicate next_step_name
            $condition = "next_step_status <> 'D' AND next_step_name = '{$next_step["next_step_name"]}'";
            if (strUtil::isNotEmpty($next_step["next_step_id"])){
                $condition .= " AND next_step_id <> '{$next_step["next_step_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){                
                return "next_step_name";
            }

            return false;
        }

        public function delete($next_step_id){
            return $this->deleteWithUpdate("tb_next_step", "next_step_status", "D", "next_step_id = '$next_step_id'");
        }

        public function insert(&$next_step){
            $table = "tb_next_step";
            $field = "next_step_name, next_step_status, created_by, created_date, modified_by, modified_date";
            $data = "'{$next_step["next_step_name"]}', '{$next_step["next_step_status"]}'"
                       . ", '{$next_step["action_by"]}', '{$next_step["action_date"]}', '{$next_step["action_by"]}', '{$next_step["action_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $next_step["next_step_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($next_step){
            $table = "tb_next_step";
            $data = "next_step_name = '{$next_step["next_step_name"]}'"
                        . ", next_step_status = '{$next_step["next_step_status"]}'"
                        . ", modified_by = '{$next_step["action_by"]}'"
                        . ", modified_date = '{$next_step["action_date"]}'";
            $condition = "next_step_id = '{$next_step["next_step_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
