<?php
    include_once "model.class.php";
    include_once "sale_group.class.php";

    class project extends model {

        public function getById($project_id){
            $field = "p.project_id, p.customer_id, c.customer_name, p.project_code, p.project_name"
                      . ", p.project_size, p.project_status, p.description, p.sale_group_id"
                      . ", s1.sale_full_name AS created_by, p.created_date"
                      . " , s2.sale_full_name AS modified_by, p.modified_date";
            $table = " tb_project p"
                        . " INNER JOIN tb_customer c ON (p.customer_id = c.customer_id)"
                        . " LEFT JOIN v_tb_sale s1 ON (p.created_by = s1.sale_id)"
                        . " LEFT JOIN v_tb_sale s2 ON (p.modified_by = s2.sale_id)";
            $condition = "p.project_id = '$project_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $project = $this->db->fetch_array($result);

            return $project;
        }

        public function search($criteria, $page = 1){
            global $page_size;

            $field = " p.project_id, p.customer_id, c.customer_name, p.project_code, p.project_name"
                      . " , p.project_size, p.project_status, g.sale_group_name"
                      . " , p.created_by, p.created_date, p.modified_by, p.modified_date";
            $table = " tb_project p"
                        . " INNER JOIN tb_customer c ON (p.customer_id = c.customer_id)"
                        . " LEFT JOIN tb_sale_group g ON (p.sale_group_id = g.sale_group_id)";
            $condition = " p.project_status <> 'D' AND p.type <> 'SYS'";

            if (strUtil::isNotEmpty($criteria["project_code"])){
                $condition .= " AND p.project_code LIKE '%{$criteria["project_code"]}%'";
            }

            if (strUtil::isNotEmpty($criteria["project_name"])){
                $condition .= " AND p.project_name LIKE '%{$criteria["project_name"]}%'";
            }

            if (strUtil::isNotEmpty($criteria["customer_id"])){
                $condition .= " AND p.customer_id = '{$criteria["customer_id"]}'";
            }

            if (strUtil::isNotEmpty($criteria["project_size"])){
                $condition .= " AND p.project_size = '{$criteria["project_size"]}'";
            }

            if (strUtil::isNotEmpty($criteria["sale_group_id_search"])){
                $condition .= " AND p.sale_group_id = '{$criteria["sale_group_id_search"]}'";
            }

            if (strUtil::isNotEmpty($criteria["sale_group_id"])){
                $sale_group = new sale_group($this->db);
                $all = $sale_group->getAllSaleGroup($criteria["sale_group_id"]);

                $condition .= " AND (p.sale_group_id IN ($all) OR p.sale_group_id IS NULL)";
            }

            $condition .= " ORDER BY p.project_code, p.project_name";

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

        function searchLookup($criteria) {
            $sql = " SELECT 0 AS type, project_id, project_code, project_name FROM tb_project WHERE type = 'SYS' AND project_status = 'A'"
                    . " UNION"
                    . " SELECT 1 AS type, project_id, project_code, project_name FROM tb_project WHERE type = 'USR' AND project_status = 'A'";

            if (strUtil::isNotEmpty($criteria["project_code"])) {
                $sql .= " AND project_code LIKE '%{$criteria["project_code"]}%'";
            }

            if (strUtil::isNotEmpty($criteria["project_name"])) {
                $sql .= " AND project_name LIKE '%{$criteria["project_name"]}%'";
            }

            if (strUtil::isNotEmpty($criteria["sale_group_id"])){
                $sale_group = new sale_group($this->db);
                $all = $sale_group->getAllSaleGroup($criteria["sale_group_id"]);

                $sql .= " AND (sale_group_id IN ($all) OR sale_group_id IS NULL)";
            }

            if (strUtil::isNotEmpty($criteria["customer_id"])){
                $sql .= " AND (customer_id = '{$criteria["customer_id"]}' OR customer_id = 0)";
            }
            
            $sql .= " ORDER BY type, project_code, project_name";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while ($row = $this->db->fetch_array($result)){
                $arr_project[] = $row;
            }

            return $arr_project;
        }

        public function insert(&$project){
            $table = "tb_project";
            $field = "customer_id, project_code, project_name, project_size, project_status, description, sale_group_id"
                      . ", created_by, created_date, modified_by, modified_date";
            $data = "'{$project["customer_id"]}', '{$project["project_code"]}', '{$project["project_name"]}', '{$project["project_size"]}', '{$project["project_status"]}', '{$project["description"]}', {$project["sale_group_id"]}"
                       . ", '{$project["action_by"]}', '{$project["action_date"]}', '{$project["action_by"]}', '{$project["action_date"]}'";

            $result = $this->db->insert($table, $field, $data);
            if ($result){
                $project["project_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($project){
            $table = "tb_project";
            $data = "customer_id = '{$project["customer_id"]}'"
                       . ", project_code = '{$project["project_code"]}'"
                       . ", project_name = '{$project["project_name"]}'"
                       . ", project_size = '{$project["project_size"]}'"
                       . ", project_status = '{$project["project_status"]}'"
                       . ", description = '{$project["description"]}'"
                       . ", sale_group_id = {$project["sale_group_id"]}"
                       . ", modified_by = '{$project["action_by"]}'"
                       . ", modified_date = '{$project["action_date"]}'";
            $condition = "project_id = '{$project["project_id"]}'";

            return $this->db->update($table, $data, $condition);
        }


        public function isDuplicate($project){
            $table = "tb_project";

            # check duplicate project_code
    //        $condition = "project_status <> 'D' AND project_code = '{$project["project_code"]}'";
    //        if (strUtil::isNotEmpty($project["project_id"])){
    //            $condition .= " AND project_id <> '{$project["project_id"]}'";
    //        }
    //
    //        $rows = $db->count_rows($table, $condition);
    //
    //        if ($rows > 0){
    //            return "project_code";
    //        }

            # check duplicate project_name
            $condition = "project_status <> 'D' AND project_name = '{$project["project_name"]}'";
            if (strUtil::isNotEmpty($project["project_id"])){
                $condition .= " AND project_id <> '{$project["project_id"]}'";
            }

            $rows = $this->db->count_rows($table, $condition);

            if ($rows > 0){
                return "project_name";
            }

            return false;
        }

        public function delete($project_id){
            return $this->deleteWithUpdate("tb_project", "project_status", "D", "project_id = '$project_id'");
        }
    }
?>
