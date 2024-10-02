<?php
    include_once "model.class.php";

    class objective extends model {

        public function search($criteria, $page = 1){
            global $page_size;

            $field = " objective_id, objective_name, objective_status, created_by, created_date, modified_by, modified_date";
            $table = " tb_objective o";
            $condition = " o.objective_status <> 'D' AND o.type <> 'SYS'"
                              . " ORDER BY o.objective_name";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "arr_objective" => $arr);
        }

        public  function getById($objective_id){
            $field = "o.objective_id, o.objective_name, o.objective_status"
                       . ", vs1.sale_full_name AS created_by, o.created_date"
                       . " , vs2.sale_full_name AS modified_by, o.modified_date";
            $table = " tb_objective o"
                        . " LEFT JOIN v_tb_sale vs1 ON (o.created_by = vs1.sale_id)"
                        . " LEFT JOIN v_tb_sale vs2 ON (o.modified_by = vs2.sale_id)";
            $condition = "o.objective_id = '$objective_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $objective = $this->db->fetch_array($result);
            
            return $objective;
        }

        public function listCombo(){
            $sql = " SELECT"
                    . "    CASE WHEN type = 'SYS' THEN 0 ELSE 1 END AS type"
                    . "    , objective_id, objective_name"
                    . " FROM tb_objective"
                    . " WHERE objective_status = 'A'"
                    . " ORDER BY type, objective_name";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();
            
            while($row = $this->db->fetch_array($result)){
                $objective[] = $row ;
            }
            
            return $objective;
        }

        public function isDuplicate($objective){
            $table = "tb_objective";

            # check duplicate objective_name
            $condition = "objective_status <> 'D' AND objective_name = '{$objective["objective_name"]}'";
            if (strUtil::isNotEmpty($objective["objective_id"])){
                $condition .= " AND objective_id <> '{$objective["objective_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "objective_name";
            }

            return false;
        }

        public function delete($objective_id){
            return $this->deleteWithUpdate("tb_objective", "objective_status", "D", "objective_id = '$objective_id'");
        }

        public function insert(&$objective){
            $table = "tb_objective";
            $field = "objective_name, objective_status, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["objective_name"]}', '{$objective["objective_status"]}'"
                       . ", '{$objective["action_by"]}', '{$objective["action_date"]}', '{$objective["action_by"]}', '{$objective["action_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["objective_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "tb_objective";
            $data = "objective_name = '{$objective["objective_name"]}'"
                        . ", objective_status = '{$objective["objective_status"]}'"
                        . ", modified_by = '{$objective["action_by"]}'"
                        . ", modified_date = '{$objective["action_date"]}'";
            $condition = "objective_id = '{$objective["objective_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
    }
?>
