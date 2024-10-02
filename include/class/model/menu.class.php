<?php
    include_once "model.class.php";

    class menu extends model {

        public function listCombo(){
            $field = "m.menu_id, m.menu_name";
            $table = " tb_menu m";
            $condition = "m.status = 'A'";
            $order_by = "m.menu_code";

            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();
            while($menu = $this->db->fetch_array($result)){
                $arr_menu[] = $menu;
            }

            return $arr_menu;
        }

        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "m.menu_id, m.menu_code, m.menu_name, m.status, m2.menu_name AS parent_menu_name";

            # table
            $table = " tb_menu m"
                        . " LEFT JOIN tb_menu m2 ON (m.ref_menu_id = m2.menu_id)";

            # condition
           //$condition = " m.status <> 'D'";
            $condition = "1=1";
            if (strUtil::isNotEmpty($cratiria["menu_name"])){
                $condition .= " AND m.menu_name LIKE '%{$cratiria["menu_name"]}%'";
            }

            if (strUtil::isNotEmpty($cratiria["ref_menu_id"])){
                $condition .= " AND m.ref_menu_id = '{$cratiria["ref_menu_id"]}'";
            }

            $condition .= " ORDER BY m.menu_code";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select($field, $table, $condition);
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

        public function listByTree($sale_id, $ref_menu_id = null){
            $sql = " SELECT DISTINCT"
                    . "    m.menu_id, m.ref_menu_id, m.menu_code, m.menu_name, m.href, m.icon"
                    . " FROM tb_access_group g"
                    . " INNER JOIN tb_access_group_sale gs ON (g.access_group_id = gs.access_group_id)"
                    . " INNER JOIN tb_access_group_permission p ON(g.access_group_id = p.access_group_id)"
                    . " INNER JOIN tb_menu m ON (p.menu_id = m.menu_id)"
                    . " WHERE g.access_group_status = 'A'"
                    . " AND m.status = 'A'"
                    . " AND gs.sale_id = '$sale_id'"
                    . " AND m.menu_code not like '03%' and m.menu_code not like '14%' and m.menu_code <> '13'" //filter create incident
                    . " AND m.ref_menu_id";

            if ($ref_menu_id == null){
                $sql .= " IS NULL";
            } else {
                $sql .= " = '$ref_menu_id'";
            }

            $sql .= " ORDER BY m.menu_code";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $row["child_menu"] = $this->listByTree($sale_id, $row["menu_id"]);
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function checkCreateInc($sale_id){
            $sql = " SELECT gs.sale_id, m.menu_code, m.menu_name, m.href  
                    FROM tb_access_group g
                    INNER JOIN tb_access_group_sale gs ON ( g.access_group_id = gs.access_group_id ) 
                    INNER JOIN tb_access_group_permission p ON ( g.access_group_id = p.access_group_id ) 
                    INNER JOIN tb_menu m ON ( p.menu_id = m.menu_id ) 
                    WHERE g.access_group_status =  'A'
                    AND m.status =  'A' 
                    AND gs.sale_id =  '$sale_id' 
                    AND LOWER( IFNULL( m.menu_name,  '' ) ) =  'create incident'";

//            echo $sql; exit();
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

//            if ($rows == 0) return 0;
//            return 1;
            
            
           if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }

/*
        public function getById($menu_id){
            $field = "m.menu_id, m.menu_code, m.menu_name, m.ref_menu_id, m.href, m.icon, m.status"
                       . ", vs1.sale_full_name AS created_by, m.created_date"
                       . " , vs2.sale_full_name AS modified_by, m.modified_date";
            $table = " tb_menu m"
                        . " LEFT JOIN v_tb_sale vs1 ON (m.created_by = vs1.sale_id)"
                        . " LEFT JOIN v_tb_sale vs2 ON (m.modified_by = vs2.sale_id)";
            $condition = "m.menu_id = '$menu_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $menu = $this->db->fetch_array($result);

            return $menu;
        }
*/		
        public function getById($menu_id){
            $field = "m.menu_id, m.menu_code, m.menu_name, m.ref_menu_id, m.href, m.icon, m.status"
                       . ", CONCAT(vs1.first_name,' ',vs1.last_name) AS created_by, m.created_date"
                       . " , CONCAT(vs2.first_name,' ',vs2.last_name) AS modified_by, m.modified_date";
            $table = " tb_menu m"
                        . " LEFT JOIN helpdesk_user vs1 ON (m.created_by = vs1.user_id)"
                        . " LEFT JOIN helpdesk_user vs2 ON (m.modified_by = vs2.user_id)";
            $condition = "m.menu_id = '$menu_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $menu = $this->db->fetch_array($result);

            return $menu;
        }

        public function delete($menu_id){
            return $this->deleteWithUpdate("tb_menu", "status", "D", "menu_id = '$menu_id'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("tb_menu", "status", "A", "menu_id = '$objective'");
        }

        public function insert(&$menu){
            $table = "tb_menu";
            $field = "menu_code, menu_name, ref_menu_id, href, icon, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$menu["menu_code"]}', '{$menu["menu_name"]}', {$menu["ref_menu_id"]}, '{$menu["href"]}', '{$menu["icon"]}', '{$menu["status"]}', '{$menu["action_by"]}', '{$menu["action_date"]}', '{$menu["action_by"]}', '{$menu["action_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $menu["menu_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($menu){
            $table = "tb_menu";
            $data = "menu_code = '{$menu["menu_code"]}'"
                        . ", menu_name = '{$menu["menu_name"]}'"
                        . ", ref_menu_id = {$menu["ref_menu_id"]}"
                        . ", href = '{$menu["href"]}'"
                        . ", icon = '{$menu["icon"]}'"
                        . ", status = '{$menu["status"]}'"
                        . ", modified_by = '{$menu["action_by"]}'"
                        . ", modified_date = '{$menu["action_date"]}'";
            $condition = "menu_id = '{$menu["menu_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
        
        public function listByTree_km($sale_id, $ref_menu_id = null){
            $sql = " SELECT DISTINCT"
                    . "    m.menu_id, m.ref_menu_id, m.menu_code, m.menu_name, m.href, m.icon"
                    . " FROM tb_access_group g"
                    . " INNER JOIN tb_access_group_sale gs ON (g.access_group_id = gs.access_group_id)"
                    . " INNER JOIN tb_access_group_permission p ON(g.access_group_id = p.access_group_id)"
                    . " INNER JOIN tb_menu m ON (p.menu_id = m.menu_id)"
                    . " WHERE g.access_group_status = 'A'"
                    . " AND m.status = 'A'"
                    . " AND gs.sale_id = '$sale_id'"
                    . " AND (m.menu_code like '14%' OR m.menu_code like '13%') " //filter create incident
                    . " AND m.ref_menu_id";

            //if ($ref_menu_id == null){
               // $sql .= " IS NULL or m.menu_code = '13' ";
           // } else {
               // $sql .= " = '$ref_menu_id'";
           // }
                
                if ($ref_menu_id == null){
                $sql .= " IS NULL";
            } else {
                $sql .= " = '$ref_menu_id'";
            }

            $sql .= " ORDER BY m.menu_code";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $row["child_menu"] = $this->listByTree_km($sale_id, $row["menu_id"]);
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function checkCreateKm($sale_id){
            $sql = " SELECT gs.sale_id, m.menu_code, m.menu_name, m.href  
                    FROM tb_access_group g
                    INNER JOIN tb_access_group_sale gs ON ( g.access_group_id = gs.access_group_id ) 
                    INNER JOIN tb_access_group_permission p ON ( g.access_group_id = p.access_group_id ) 
                    INNER JOIN tb_menu m ON ( p.menu_id = m.menu_id ) 
                    WHERE g.access_group_status =  'A'
                    AND m.status =  'A' 
                    AND gs.sale_id =  '$sale_id' 
                    AND (LOWER( IFNULL( m.menu_name,  '' ) ) =  'incident km' or LOWER( IFNULL( m.menu_name,  '' ) ) =  'incident km tool' )";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            
           if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
    }
?>
