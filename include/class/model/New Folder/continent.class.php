<?php
    include_once "model.class.php";

    class continent extends model {
        public function listCombo(){
            $sql = " SELECT con_id, con_name_th AS con_name"
                    . " FROM tb_continent"
                    . " WHERE status = 'A'"
                    . " ORDER BY con_code, con_name";

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
            $field = "con_id, con_code, con_name_th, con_name_en, con_abbr";

            # table
            $table = "tb_continent";

            # condition
            $condition = " status <> 'D'";
            if (strUtil::isNotEmpty($cratiria["con_name"])){
                $condition .= " AND (con_name_th LIKE '%{$cratiria["con_name"]}%' OR con_name_en LIKE '%{$cratiria["con_name"]}%')";
            }

            $condition .= " ORDER BY con_code";

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

        public function isDuplicate($continent){
            $table = "tb_continent";

            # check duplicate con_code
            $condition = "status <> 'D' AND con_code = '{$continent["con_code"]}'";
            if (strUtil::isNotEmpty($continent["con_id"])){
                $condition .= " AND con_id <> '{$continent["con_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "con_code";
            }

            # check duplicate con_name_th
            $condition = "status <> 'D' AND con_name_th = '{$continent["con_name_th"]}'";
            if (strUtil::isNotEmpty($continent["con_id"])){
                $condition .= " AND con_id <> '{$continent["con_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "con_name_th";
            }

            # check duplicate con_name_en
            $condition = "status <> 'D' AND con_name_en = '{$continent["con_name_en"]}'";
            if (strUtil::isNotEmpty($continent["con_id"])){
                $condition .= " AND con_id <> '{$continent["con_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "con_name_en";
            }

            return false;
        }

        public function getById($con_id){
            $sql = " SELECT"
                    . "    c.con_id, c.con_code, c.con_name_th, c.con_name_en, c.con_abbr, c.status"
                    . "    , vs1.sale_full_name AS created_by, c.created_date"
                    . "    , vs2.sale_full_name AS modified_by, c.modified_date"
                    . " FROM tb_continent c"
                    . " LEFT JOIN v_tb_sale vs1 ON (c.created_by = vs1.sale_id)"
                    . " LEFT JOIN v_tb_sale vs2 ON (c.modified_by = vs2.sale_id)"
                    . " WHERE c.con_id = '$con_id'";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $continent = $this->db->fetch_array($result);

            return $continent;
        }

        public function delete($con_id){
            return $this->deleteWithUpdate("tb_continent", "status", "D", "con_id = '$con_id'");
        }
        
        public function insert(&$continent){
            $sql = " INSERT INTO tb_continent ("
                     . "    con_code, con_name_th, con_name_en, con_abbr, status"
                     . "    , created_by, created_date, modified_by, modified_date"
                     . " ) VALUES ("
                     . "    '{$continent["con_code"]}', '{$continent["con_name_th"]}', '{$continent["con_name_en"]}', '{$continent["con_abbr"]}', '{$continent["status"]}'"
                     . "    , '{$continent["action_by"]}', '{$continent["action_date"]}', '{$continent["action_by"]}', '{$continent["action_date"]}'"
                     . " )";

            $result = $this->db->query($sql);

            if ($result){
                $continent["con_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($continent){
            $sql = " UPDATE tb_continent SET"
                    . "    con_code = '{$continent["con_code"]}'"
                    . "    , con_name_th = '{$continent["con_name_th"]}'"
                    . "    , con_name_en = '{$continent["con_name_en"]}'"
                    . "    , con_abbr = '{$continent["con_abbr"]}'"
                    . "    , status = '{$continent["status"]}'"
                    . "    , modified_by = '{$continent["action_by"]}'"
                    . "    , modified_date = '{$continent["action_date"]}'"
                    . " WHERE con_id = '{$continent["con_id"]}'";

            return $this->db->query($sql);
        }
    }
?>
