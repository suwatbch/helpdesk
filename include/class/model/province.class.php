<?php
    include_once "model.class.php";
    include_once dirname(__FILE__)."/amphur.class.php";
    include_once dirname(dirname(__FILE__))."/util/strUtil.class.php";

    class province extends model {

        public function listCombo($reg_id = ""){
            $sql = " SELECT r.reg_name_th AS reg_name, p.prv_id, p.prv_name_th AS prv_name"
                    . " FROM tb_province p"
                    . " INNER JOIN tb_region r ON (p.reg_id = r.reg_id)"
                    . " WHERE p.status = 'A'";

            if (strUtil::isNotEmpty($reg_id)){
                $sql .= " AND p.reg_id = '$reg_id'";
            }

            $sql .= " ORDER BY r.reg_code, p.prv_name_th";

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
            $field = "p.prv_id, p.prv_code, p.prv_name_th, p.prv_name_en, r.reg_name_th AS reg_name";

            # table
            $table = " tb_province p"
                       . " INNER JOIN tb_region r ON (p.reg_id = r.reg_id)";

            # condition
            $condition = " p.status <> 'D'";
            if (strUtil::isNotEmpty($cratiria["prv_name"])){
                $condition .= " AND (p.prv_name_th LIKE '%{$cratiria["prv_name"]}%' OR p.prv_name_en LIKE '%{$cratiria["prv_name"]}%')";
            }

            $condition .= " ORDER BY p.prv_code";

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

        public function isDuplicate($province){
            $table = "tb_province";

            # check duplicate prv_code
            $condition = "status <> 'D' AND prv_code = '{$province["prv_code"]}'";
            if (strUtil::isNotEmpty($province["prv_id"])){
                $condition .= " AND prv_id <> '{$province["prv_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "prv_code";
            }

            # check duplicate prv_name_th
            $condition = "status <> 'D' AND prv_name_th = '{$province["prv_name_th"]}'";
            if (strUtil::isNotEmpty($province["prv_id"])){
                $condition .= " AND prv_id <> '{$province["prv_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            # check duplicate prv_name_en
            $condition = "status <> 'D' AND prv_name_en = '{$province["prv_name_en"]}'";
            if (strUtil::isNotEmpty($province["prv_id"])){
                $condition .= " AND prv_id <> '{$province["prv_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            return false;
        }

        public function getById($prv_id){
            $sql = " SELECT"
                    . "    p.prv_id, p.prv_code, p.prv_name_th, p.prv_name_en, p.reg_id, p.status"
                    . "    , vs1.sale_full_name AS created_by, p.created_date"
                    . "    , vs2.sale_full_name AS modified_by, p.modified_date"
                    . " FROM tb_province p"
                    . " LEFT JOIN v_tb_sale vs1 ON (p.created_by = vs1.sale_id)"
                    . " LEFT JOIN v_tb_sale vs2 ON (p.modified_by = vs2.sale_id)"
                    . " WHERE p.prv_id = '$prv_id'";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $prv = $this->db->fetch_array($result);

            return $prv;
        }

        public function delete($prv_id){
            return $this->deleteWithUpdate("tb_province", "status", "D", "prv_id = '$prv_id'");
        }

        public function insert(&$province){
            $sql = " INSERT INTO tb_province ("
                     . "    prv_code, prv_name_th, prv_name_en, reg_id, status"
                     . "    , created_by, created_date, modified_by, modified_date"
                     . " ) VALUES ("
                     . "    '{$province["prv_code"]}', '{$province["prv_name_th"]}', '{$province["prv_name_en"]}', '{$province["reg_id"]}', '{$province["status"]}'"
                     . "    , '{$province["action_by"]}', '{$province["action_date"]}', '{$province["action_by"]}', '{$province["action_date"]}'"
                     . " )";

            $result = $this->db->query($sql);

            if ($result){
                $province["prv_id"] = $this->db->insert_id();
            }

            if (count($province["amphur"]) > 0){
                $amp = new amphur($this->db);
                foreach ($province["amphur"] as $amphur) {
                    $amphur["prv_id"] = $province["prv_id"];
                    $result = $amp->insert($amphur);
                    if (!$result) break;
                }
            }

            return $result;
        }

        public function update($province){
            $sql = " UPDATE tb_province SET"
                    . "    prv_code = '{$province["prv_code"]}'"
                    . "    , prv_name_th = '{$province["prv_name_th"]}'"
                    . "    , prv_name_en = '{$province["prv_name_en"]}'"
                    . "    , reg_id = '{$province["reg_id"]}'"
                    . "    , status = '{$province["status"]}'"
                    . "    , modified_by = '{$province["action_by"]}'"
                    . "    , modified_date = '{$province["action_date"]}'"
                    . " WHERE prv_id = '{$province["prv_id"]}'";

            $result = $this->db->query($sql);

            if ($result){
                if (count($province["amphur"]) > 0){
                    $amp = new amphur($this->db);
                    foreach ($province["amphur"] as $amphur) {
                        if (strUtil::isEmpty($amphur["amp_id"])){
                            $result = $amp->insert($amphur);
                        } else if ($amphur["flag"] == "D"){
                            $result = $amp->delete($amphur["amp_id"]);
                        } else {
                            $result = $amp->update($amphur);
                        }
                        if (!$result) break;
                    }
                }
            }

            return $result;
        }
    }
?>
