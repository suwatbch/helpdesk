<?php
    include_once "model.class.php";
    include_once dirname(dirname(__FILE__))."/util/strUtil.class.php";

    class amphur extends model {

        public function listCombo($prv_id = ""){
            $sql = " SELECT a.amp_id, a.amp_name_th AS amp_name"
                    . " FROM tb_amphur a"
                    . " WHERE status = 'A'";

            if (strUtil::isNotEmpty($prv_id)){
                $sql .= " AND a.prv_id = '$prv_id'";
            }

            $sql .= " ORDER BY amp_name";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }

        public function lst($prv_id = ""){
            $sql = " SELECT"
                    . "    a.amp_id, a.amp_code, a.amp_name_th, a.amp_name_en, a.post_code, a.status"
                    . " FROM tb_amphur a"
                    . " WHERE a.status <> 'D'";

            if (strUtil::isNotEmpty($prv_id)){
                $sql .= " AND a.prv_id = '$prv_id'";
            }

            $sql .= " ORDER BY a.amp_code";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $data[] = $row;
            }


            return $data;
        }

        public function isDuplicate($amphur){
            $table = "tb_amphur";

            # check duplicate amp_code
            $condition = "status <> 'D' AND amp_code = '{$amphur["amp_code"]}'";
            if (strUtil::isNotEmpty($amphur["amp_id"])){
                $condition .= " AND amp_id <> '{$amphur["amp_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "amp_code";
            }

            # check duplicate amp_name_th
            $condition = "status <> 'D' AND amp_name_th = '{$amphur["amp_name_th"]}'";
            if (strUtil::isNotEmpty($amphur["amp_id"])){
                $condition .= " AND amp_id <> '{$amphur["amp_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            # check duplicate amp_name_en
            $condition = "status <> 'D' AND amp_name_en = '{$amphur["amp_name_en"]}'";
            if (strUtil::isNotEmpty($amphur["amp_id"])){
                $condition .= " AND amp_id <> '{$amphur["amp_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            return false;
        }

        public function getById($amp_id){
            $sql = " SELECT"
                    . "    a.amp_id_id, a.amp_code, a.amp_name_th, a.amp_name_en, a.prv_id, a.status"
                    . "    , vs1.sale_full_name AS created_by, a.created_date"
                    . "    , vs2.sale_full_name AS modified_by, a.modified_date"
                    . " FROM tb_amphur a"
                    . " LEFT JOIN v_tb_sale vs1 ON (a.created_by = vs1.sale_id)"
                    . " LEFT JOIN v_tb_sale vs2 ON (a.modified_by = vs2.sale_id)"
                    . " WHERE a.amp_id = '$amp_id'";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $amphur = $this->db->fetch_array($result);

            return $amphur;
        }

        public function delete($amp_id){
            return $this->deleteWithUpdate("tb_amphur", "status", "D", "amp_id = '$amp_id'");
        }

        public function insert(&$amphur){
            $sql = " INSERT INTO tb_amphur ("
                     . "    amp_code, amp_name_th, amp_name_en, prv_id, status"
                     . "    , created_by, created_date, modified_by, modified_date"
                     . " ) VALUES ("
                     . "    '{$amphur["amp_code"]}', '{$amphur["amp_name_th"]}', '{$amphur["amp_name_en"]}', '{$amphur["prv_id"]}', '{$amphur["status"]}'"
                     . "    , '{$amphur["action_by"]}', '{$amphur["action_date"]}', '{$amphur["action_by"]}', '{$amphur["action_date"]}'"
                     . " )";

            $result = $this->db->query($sql);

            if ($result){
                $amphur["amp_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($amphur){
            $sql = " UPDATE tb_amphur SET"
                    . "    amp_code = '{$amphur["amp_code"]}'"
                    . "    , amp_name_th = '{$amphur["amp_name_th"]}'"
                    . "    , amp_name_en = '{$amphur["amp_name_en"]}'"
                    . "    , prv_id = '{$amphur["prv_id"]}'"
                    . "    , status = '{$amphur["status"]}'"
                    . "    , modified_by = '{$amphur["action_by"]}'"
                    . "    , modified_date = '{$amphur["action_date"]}'"
                    . " WHERE amp_id = '{$amphur["amp_id"]}'";

            return $this->db->query($sql);
        }
    }
?>
