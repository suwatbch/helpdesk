<?php
    include_once "model.class.php";
    include_once dirname(dirname(__FILE__))."/util/strUtil.class.php";

    class country extends model {

        public function listCombo($con_id = ""){
            $sql = " SELECT cn.con_name_th AS con_name, ct.cou_id, ct.cou_name_th AS cou_name"
                    . " FROM tb_country ct"
                    . " INNER JOIN tb_continent cn ON (ct.con_id = cn.con_id)"
                    . " WHERE ct.status = 'A'";

            if (strUtil::isNotEmpty($con_id)){
                $sql .= " AND ct.con_id = '$con_id'";
            }

            $sql .= " ORDER BY cn.con_code, ct.cou_name_th";

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
            $field = "ct.cou_id, ct.cou_code, ct.cou_name_th, ct.cou_name_en, cn.con_name_th AS con_name";

            # table
            $table = " tb_country ct"
                       . " INNER JOIN tb_continent cn ON (ct.con_id = cn.con_id)" ;

            # condition
            $condition = " ct.status <> 'D'";
            if (strUtil::isNotEmpty($cratiria["cou_name"])){
                $condition .= " AND (ct.cou_name_th LIKE '%{$cratiria["con_name"]}%' OR ct.cou_name_en LIKE '%{$cratiria["con_name"]}%')";
            }

            $condition .= " ORDER BY ct.cou_code";

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

        public function isDuplicate($country){
            $table = "tb_country";

            # check duplicate con_code
            $condition = "status <> 'D' AND con_code = '{$country["con_code"]}'";
            if (strUtil::isNotEmpty($country["con_id"])){
                $condition .= " AND con_id <> '{$country["con_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "con_code";
            }

            # check duplicate con_name_th
            $condition = "status <> 'D' AND con_name_th = '{$country["con_name_th"]}'";
            if (strUtil::isNotEmpty($country["con_id"])){
                $condition .= " AND con_id <> '{$country["con_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "con_name_th";
            }

            # check duplicate con_name_en
            $condition = "status <> 'D' AND con_name_en = '{$country["con_name_en"]}'";
            if (strUtil::isNotEmpty($country["con_id"])){
                $condition .= " AND con_id <> '{$country["con_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "con_name_en";
            }

            return false;
        }

        public function getById($cou_id){
            $sql = " SELECT"
                    . "    c.cou_id, c.cou_code, c.cou_name_th, c.cou_name_en, c.con_id, c.status"
                    . "    , vs1.sale_full_name AS created_by, c.created_date"
                    . "    , vs2.sale_full_name AS modified_by, c.modified_date"
                    . " FROM tb_country c"
                    . " LEFT JOIN v_tb_sale vs1 ON (c.created_by = vs1.sale_id)"
                    . " LEFT JOIN v_tb_sale vs2 ON (c.modified_by = vs2.sale_id)"
                    . " WHERE c.cou_id = '$cou_id'";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $country = $this->db->fetch_array($result);

            return $country;
        }

        public function delete($cou_id){
            return $this->deleteWithUpdate("tb_country", "status", "D", "cou_id = '$cou_id'");
        }

        public function insert(&$country){
            $sql = " INSERT INTO tb_country ("
                     . "    cou_code, cou_name_th, cou_name_en, con_id, status"
                     . "    , created_by, created_date, modified_by, modified_date"
                     . " ) VALUES ("
                     . "    '{$country["cou_code"]}', '{$country["cou_name_th"]}', '{$country["cou_name_en"]}', {$country["con_id"]}, '{$country["status"]}'"
                     . "    , '{$country["action_by"]}', '{$country["action_date"]}', '{$country["action_by"]}', '{$country["action_date"]}'"
                     . " )";

            $result = $this->db->query($sql);

            if ($result){
                $country["cou_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($country){
            $sql = " UPDATE tb_country SET"
                    . "    cou_code = '{$country["cou_code"]}'"
                    . "    , cou_name_th = '{$country["cou_name_th"]}'"
                    . "    , cou_name_en = '{$country["cou_name_en"]}'"
                    . "    , con_id = '{$country["con_id"]}'"
                    . "    , status = '{$country["status"]}'"
                    . "    , modified_by = '{$country["action_by"]}'"
                    . "    , modified_date = '{$country["action_date"]}'"
                    . " WHERE cou_id = '{$country["cou_id"]}'";

            return $this->db->query($sql);
        }
    }
?>
