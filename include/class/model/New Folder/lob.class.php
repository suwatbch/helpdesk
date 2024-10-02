<?php
    include_once "model.class.php";

    class lob extends model {

        public function listCombo(){
            $sql = " SELECT l.lob_id, l.lob_code, l.lob_name"
                    . " FROM tb_lob l"
                    . " WHERE status = 'A'"
                    . " ORDER BY l.lob_name";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }

        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "l.lob_id, l.lob_code, l.lob_name";

            # table
            $table = " tb_lob l";

            # condition
            $condition = " l.status <> 'D'";
            if (strUtil::isNotEmpty($cratiria["lob_name"])){
                $condition .= " AND l.lob_name LIKE '%{$cratiria["lob_name"]}%'";
            }

            $condition .= " ORDER BY l.lob_code";

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

        public function isDuplicate($lob){
            $table = "tb_lob";

            # check duplicate lob_code
            $condition = "status <> 'D' AND lob_code = '{$lob["lob_code"]}'";
            if (strUtil::isNotEmpty($lob["lob_id"])){
                $condition .= " AND lob_id <> '{$lob["lob_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "lob_code";
            }

            # check duplicate lob_name
            $condition = "status <> 'D' AND lob_name = '{$lob["lob_name"]}'";
            if (strUtil::isNotEmpty($lob["lob_id"])){
                $condition .= " AND lob_id <> '{$lob["lob_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            return false;
        }

        public function getById($lob_id){
            $sql = " SELECT"
                    . "    l.lob_id, l.lob_code, l.lob_name, l.status"
                    . "    , vs1.sale_full_name AS created_by, l.created_date"
                    . "    , vs2.sale_full_name AS modified_by, l.modified_date"
                    . " FROM tb_lob l"
                    . " LEFT JOIN v_tb_sale vs1 ON (l.created_by = vs1.sale_id)"
                    . " LEFT JOIN v_tb_sale vs2 ON (l.modified_by = vs2.sale_id)"
                    . " WHERE l.lob_id = '$lob_id'";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $lob = $this->db->fetch_array($result);

            return $lob;
        }

        public function delete($lob_id){
            return $this->deleteWithUpdate("tb_lob", "status", "D", "lob_id = '$lob_id'");
        }

        public function insert(&$lob){
            $sql = " INSERT INTO tb_lob ("
                     . "    lob_code, lob_name, status"
                     . "    , created_by, created_date, modified_by, modified_date"
                     . " ) VALUES ("
                     . "    '{$lob["lob_code"]}', '{$lob["lob_name"]}', '{$lob["status"]}'"
                     . "    , '{$lob["action_by"]}', '{$lob["action_date"]}', '{$lob["action_by"]}', '{$lob["action_date"]}'"
                     . " )";

            $result = $this->db->query($sql);

            if ($result){
                $lob["lob_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($lob){
            $sql = " UPDATE tb_lob SET"
                    . "    lob_code = '{$lob["lob_code"]}'"
                    . "    , lob_name = '{$lob["lob_name"]}'"
                    . "    , status = '{$lob["status"]}'"
                    . "    , modified_by = '{$lob["action_by"]}'"
                    . "    , modified_date = '{$lob["action_date"]}'"
                    . " WHERE lob_id = '{$lob["lob_id"]}'";

            return $this->db->query($sql);
        }
    }
?>
