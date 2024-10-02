<?php
    include_once "model.class.php";
    include_once dirname(dirname(__FILE__))."/util/strUtil.class.php";

    class sale_group extends model {

        public function isDuplicate($sale_group){
            $table = "tb_sale_group";

            # check duplicate employee_code
            $condition = "sale_group_name = '{$sale_group["sale_group_name"]}'";
            if (strUtil::isNotEmpty($sale_group["sale_group_id"])){
                $condition .= " AND sale_group_id <> '{$sale_group["sale_group_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){                
                return "sale_group_name";
            }

            return false;
        }

        public function listCombo(){
            $field = "g.sale_group_id, g.sale_group_name";
            $table = " tb_sale_group g";
            $condition = "g.sale_group_status = 'A'";
            $order_by = "g.sale_group_name";

            $sale_group = array();
            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }
        
            return $arr;
        }

        public function getAllSaleGroup($sale_group_id){
            $sql = "SELECT sale_group_id FROM tb_sale_group WHERE ref_sale_group_id = '$sale_group_id'";
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return $sale_group_id;

            $str = "";
            while($row = $this->db->fetch_array($result)){
                if (strUtil::isNotEmpty($str)){
                    $str .= ", ";
                }

                $ref = $this->getAllSaleGroup($row["sale_group_id"]);
                if (strUtil::isNotEmpty($ref)){
                    $str .= $ref;
                } else {
                    $str .= $row["sale_group_id"];
                }
            }

            return "$sale_group_id, $str";
        }

        function getById($sale_group_id){
            $field = "g.sale_group_id, g.sale_group_name, g.sale_group_status, g.description"
                       . ", g.ref_sale_group_id, g2.sale_group_name AS ref_sale_group_name"
                       . ", vs1.sale_full_name AS created_by, g.created_date"
                       . ", vs1.sale_full_name AS modified_by, g.modified_date";
            $table = " tb_sale_group g"
                        . " LEFT JOIN tb_sale_group g2 ON (g.ref_sale_group_id = g2.sale_group_id)"
                        . " LEFT JOIN v_tb_sale vs1 ON (g.created_by = vs1.sale_id)"
                        . " LEFT JOIN v_tb_sale vs2 ON (g.modified_by = vs2.sale_id)";
            $condition = "g.sale_group_id = '$sale_group_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);
            
            if ($rows == 0) return array();

            $sale_group = $this->db->fetch_array($result);

            return $sale_group;
        }

        public function search($criteria, $page = 1){
            global $page_size;

            $field = " g.sale_group_id, g.sale_group_name, g2.sale_group_name AS ref_sale_group_name";
            $table = " tb_sale_group g"
                        . " LEFT JOIN tb_sale_group g2 ON (g.ref_sale_group_id = g2.sale_group_id)";
            $condition = " g.sale_group_status <> 'D'"
                              . " ORDER BY g.sale_group_name";

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

        public function delete($sale_group_id){
            return $this->deleteWithUpdate("tb_sale_group", "sale_group_status", "D", "sale_group_id = '$sale_group_id'");
        }

        public function insert(&$sale_group){
            $table = "tb_sale_group";
            $field = "sale_group_name, ref_sale_group_id, description, sale_group_status"
                      . ", created_by, created_date, modified_by, modified_date";
            $data = "'{$sale_group["sale_group_name"]}', {$sale_group["ref_sale_group_id"]}, '{$sale_group["description"]}', '{$sale_group["sale_group_status"]}'"
                       . ", '{$sale_group["action_by"]}', '{$sale_group["action_date"]}', '{$sale_group["action_by"]}', '{$sale_group["action_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $sale_group["sale_group_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($sale_group){
            $table = "tb_sale_group";
            $data = "sale_group_name = '{$sale_group["sale_group_name"]}'"
                       . ", ref_sale_group_id = {$sale_group["ref_sale_group_id"]}"
                       . ", description = '{$sale_group["description"]}'"
                       . ", sale_group_status = '{$sale_group["sale_group_status"]}'"
                       . ", modified_by = '{$sale_group["action_by"]}' "
                       . ", modified_date = '{$sale_group["action_date"]}'";
            $condition = "sale_group_id = '{$sale_group["sale_group_id"]}'";

            return $this->db->update($table, $data, $condition);
        }

    }
?>
