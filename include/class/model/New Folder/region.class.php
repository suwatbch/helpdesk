<?php
    include_once "model.class.php";
    include_once dirname(dirname(__FILE__))."/util/strUtil.class.php";

    class region extends model {

        public function listCombo(){
            $sql = " SELECT"
                    . "    reg_id, reg_name_th AS reg_name"
                    . " FROM tb_region"
                    . " WHERE status = 'A'"
                    . " ORDER BY reg_name";

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
            $field = "r.reg_id, r.reg_code, r.reg_name_th, r.reg_name_en";

            # table
            $table = " tb_region r";

            # condition
            $condition = " r.status <> 'D'";
            if (strUtil::isNotEmpty($cratiria["reg_name"])){
                $condition .= " AND (r.reg_name_th LIKE '%{$cratiria["reg_name"]}%' OR r.reg_name_en LIKE '%{$cratiria["reg_name"]}%')";
            }

            $condition .= " ORDER BY r.reg_code";

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

        public function isDuplicate($region){
            $table = "tb_region";

            # check duplicate reg_code
            $condition = "status <> 'D' AND reg_code = '{$region["reg_code"]}'";
            if (strUtil::isNotEmpty($region["reg_id"])){
                $condition .= " AND reg_id <> '{$region["reg_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "reg_code";
            }

            # check duplicate reg_name_th
            $condition = "status <> 'D' AND reg_name_th = '{$region["reg_name_th"]}'";
            if (strUtil::isNotEmpty($region["reg_id"])){
                $condition .= " AND reg_id <> '{$region["reg_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "reg_name_th";
            }

            # check duplicate reg_name_en
            $condition = "status <> 'D' AND reg_name_en = '{$region["reg_name_en"]}'";
            if (strUtil::isNotEmpty($region["reg_id"])){
                $condition .= " AND reg_id <> '{$region["reg_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "reg_name_en";
            }

            return false;
        }

        public function getById($reg_id){
            $sql = " SELECT"
                    . "    r.reg_id, r.reg_code, r.reg_name_th, r.reg_name_en, r.status"
                    . "    , vs1.sale_full_name AS created_by, r.created_date"
                    . "    , vs2.sale_full_name AS modified_by, r.modified_date"
                    . " FROM tb_region r"
                    . " LEFT JOIN v_tb_sale vs1 ON (r.created_by = vs1.sale_id)"
                    . " LEFT JOIN v_tb_sale vs2 ON (r.modified_by = vs2.sale_id)"
                    . " WHERE r.reg_id = '$reg_id'";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $region = $this->db->fetch_array($result);

            return $region;
        }

        public function delete($reg_id){
            return $this->deleteWithUpdate("tb_region", "status", "D", "reg_id = '$reg_id'");
        }

        public function insert(&$region){
            $sql = " INSERT INTO tb_region ("
                     . "    reg_code, reg_name_th, reg_name_en, status"
                     . "    , created_by, created_date, modified_by, modified_date"
                     . " ) VALUES ("
                     . "    '{$region["reg_code"]}', '{$region["reg_name_th"]}', '{$region["reg_name_en"]}', '{$region["status"]}'"
                     . "    , '{$region["action_by"]}', '{$region["action_date"]}', '{$region["action_by"]}', '{$region["action_date"]}'"
                     . " )";

            $result = $this->db->query($sql);

            if ($result){
                $region["reg_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($region){
            $sql = " UPDATE tb_region SET"
                    . "    reg_code = '{$region["reg_code"]}'"
                    . "    , reg_name_th = '{$region["reg_name_th"]}'"
                    . "    , reg_name_en = '{$region["reg_name_en"]}'"
                    . "    , status = '{$region["status"]}'"
                    . "    , modified_by = '{$region["action_by"]}'"
                    . "    , modified_date = '{$region["action_date"]}'"
                    . " WHERE reg_id = '{$region["reg_id"]}'";

            return $this->db->query($sql);
        }
    }
?>
