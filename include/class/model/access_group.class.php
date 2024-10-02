<?php
    include_once "model.class.php";

    class access_group extends model {

        function search($criteria, $page = 1){
            global $page_size;
            
            $field = " access_group_id, access_group_code, access_group_name, access_group_status";
            $table = " tb_access_group";
            $condition = "1=1"
                              . " ORDER BY access_group_code";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "total_row" => $total_row
                , "arr_access_group" => $arr
            );
        }
/*
        public function getById($access_group_id){
            $field = "g.access_group_id, g.access_group_code, g.access_group_name, g.access_group_status"
                      . ", s1.sale_full_name AS created_by, g.created_date, s2.sale_full_name AS modified_by, g.modified_date";
            $table = " tb_access_group g"
                        . " LEFT JOIN v_tb_sale s1 ON (g.created_by = s1.sale_id)"
                        . " LEFT JOIN v_tb_sale s2 ON (g.modified_by = s2.sale_id)";
            $condition = "g.access_group_id = '$access_group_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $access_group = $this->db->fetch_array($result);
            $access_group["member"] = $this->getMember($access_group_id);

            return $access_group;
        }
*/		

        public function getById($access_group_id){
            $field = "g.access_group_id, g.access_group_code, g.access_group_name, g.access_group_status"
                      . ", CONCAT(s1.first_name,' ',s1.last_name) AS created_by, g.created_date, CONCAT(s2.first_name,' ',s2.last_name) AS modified_by, g.modified_date";
            $table = " tb_access_group g"
                        . " LEFT JOIN helpdesk_user s1 ON (g.created_by = s1.user_id)"
                        . " LEFT JOIN helpdesk_user s2 ON (g.modified_by = s2.user_id)";
            $condition = "g.access_group_id = '$access_group_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            $access_group = $this->db->fetch_array($result);
            $access_group["member"] = $this->getMember($access_group_id);

            return $access_group;
        }

        public function getMember($access_group_id){
            $field = "vs.user_id, vs.employee_code,vs.first_name,vs.last_name, c.company_name";
            $table = " tb_access_group_sale gs"
                        . " INNER JOIN helpdesk_user vs ON (gs.sale_id = vs.user_id)"
                        . " LEFT JOIN helpdesk_company c ON (vs.company_id = c.company_id)";
            $condition = "vs.user_status = '1' AND gs.access_group_id = '$access_group_id'";
            $order_by = "vs.employee_code   ";

            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while ($row = $this->db->fetch_array($result)) {
                $member[] = $row;
            }

            return $member;
        }

        public function searchMember($criteria){				

            $sql = "select * from tb_access_group_sale where access_group_id = '{$criteria["access_group_id"]}'";
            $result = $this->db->query($sql);
            $rows = $this->db->fetch_array($result); 
            if ($rows > 1){
                    $s_access_group = "";
                    $s_access_group = $rows["sale_id"];
                while($row = $this->db->fetch_array($result)){
                    $s_access_group .= ",".$row["sale_id"];
                }
            }else if($rows == 1){
                    $s_access_group = $rows["sale_id"];	
            }
            
            $field = "us.user_id, us.employee_code, us.first_name, us.last_name, c.company_name";
            $table = "helpdesk_user us"
                       . " LEFT JOIN helpdesk_company c ON (us.company_id = c.company_id)";
            $condition = "us.user_status = '1'";
            $order_by= "us.employee_code";

            if (strUtil::isNotEmpty($criteria["employee_code"])) {
                $condition .= " AND us.employee_code LIKE '%{$criteria["employee_code"]}%'";
            }

            if (strUtil::isNotEmpty($criteria["first_name"])) {
                $condition .= " AND us.first_name LIKE '%{$criteria["first_name"]}%'";
            }
            
            if (strUtil::isNotEmpty($criteria["last_name"])) {
                $condition .= " AND us.last_name LIKE '%{$criteria["last_name"]}%'";
            }

            if (strUtil::isNotEmpty($s_access_group)) {
                $condition .= " AND us.user_id NOT IN ({$s_access_group})";
            }

            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows =  $this->db->num_rows($result);

            if ($rows == 0) return array();
            while ($row = $this->db->fetch_array($result)){
                $arr_member[] = $row;
            }

            return $arr_member;

        }
/*
        public function searchMember($criteria){
            $field = "s.sale_id, s.employee_code, s.sale_full_name, p.position_name";
            $table = "v_tb_sale s"
                       . " LEFT JOIN tb_position p ON (s.position_id = p.position_id)";
            $condition = "s.sale_status = 'A'";
            $order_by= "s.employee_code";

            if (strUtil::isNotEmpty($criteria["employee_code"])) {
                $condition .= " AND employee_code LIKE '%{$criteria["employee_code"]}%'";
            }

            if (strUtil::isNotEmpty($criteria["employee_name"])) {
                $condition .= " AND (sale_first_name LIKE '%{$criteria["employee_name"]}%' OR sale_last_name LIKE '%{$criteria["employee_name"]}%')";
            }

            if (strUtil::isNotEmpty($criteria["position_id"])) {
                $condition .= " AND s.position_id = '{$criteria["position_id"]}'";
            }

            if (strUtil::isNotEmpty($criteria["member"])) {
                $condition .= " AND s.sale_id NOT IN ({$criteria["member"]})";
            }

            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows =  $this->db->num_rows($result);

            if ($rows == 0) return array();
            while ($row = $this->db->fetch_array($result)){
                $arr_member[] = $row;
            }

            return $arr_member;

        }

*/
        public function getPermission($access_group_id){
            $field = "m.menu_id, m.ref_menu_id, m.menu_code, m.menu_name";
            $table = " tb_menu m";

            if (strUtil::isNotEmpty($access_group_id)){
                $field .= ", CASE WHEN t.menu_id IS NULL THEN 0 ELSE 1 END AS has_perm";
                $table .= " LEFT JOIN (SELECT p.menu_id"
                             . "                    FROM tb_access_group_permission p"
                            . "                     WHERE p.access_group_id = '$access_group_id'"
                            . ") t ON (m.menu_id = t.menu_id)";
            }

            $condition = "m.status = 'A'";
            $order_by = "m.menu_code";

            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while ($row = $this->db->fetch_array($result)) {
                $permission[] = $row;
            }

            return $permission;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("tb_access_group", "access_group_status", "D", "access_group_id = '$access_group_id'");
              
            return $this->deleteWithoutUpdate("tb_access_group", "access_group_id = '$objective'");
        }
        
        public function delete_user($objective1,$objective2){
//            return $this->deleteWithUpdate("tb_access_group", "access_group_status", "D", "access_group_id = '$access_group_id'");
              
            return $this->deleteWithoutUpdate("tb_access_group_sale", "access_group_id = '$objective1' and sale_id= '$objective2' ");
        }

        public function insert(&$access_group){
            $table = "tb_access_group";
            $field = "access_group_code, access_group_name, access_group_status"
                      . ", created_by, created_date, modified_by, modified_date";
            $data = "'{$access_group["access_group_code"]}', '{$access_group["access_group_name"]}', '{$access_group["access_group_status"]}'"
                       . ", '{$access_group["action_by"]}', '{$access_group["action_date"]}', '{$access_group["action_by"]}', '{$access_group["action_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $access_group["access_group_id"] = $this->db->insert_id();
                $result = $this->insertPermission($access_group["access_group_id"], $access_group["permission"]);

                if ($result){
                    //print_r($access_group["member"]);
                   // $result = $this->insertMember($access_group["access_group_id"], $access_group["member"]);
                }
            }

            return $result;
        }
        
        public function save_user($access_group){
		
            $result = $this->insertMember($access_group["access_group_id"], $access_group["member"]);
            return $result;
        }

        public function update($access_group){
            $table = "tb_access_group";
            $data = "access_group_code = '{$access_group["access_group_code"]}'"
                        . ", access_group_name = '{$access_group["access_group_name"]}'"
                        . ", access_group_status = '{$access_group["access_group_status"]}'"
                        . ", modified_by = '{$access_group["action_by"]}'"
                        . ", modified_date = '{$access_group["action_date"]}'";
            $condition = "access_group_id = '{$access_group["access_group_id"]}'";

            $result = $this->db->update($table, $data, $condition);
			
            if ($result){
                $this->db->delete("tb_access_group_permission", "access_group_id = '{$access_group["access_group_id"]}'");
                $result = $this->insertPermission($access_group["access_group_id"], $access_group["permission"]);

                if ($result){
					//print_r($access_group["member"]);
                   // $this->db->delete("tb_access_group_sale", "access_group_id = '{$access_group["access_group_id"]}'");
                   // $result = $this->insertMember($access_group["access_group_id"], $access_group["member"]);
                }
            }

            return $result;
        }

        function insertPermission($access_group_id, $menu){
			#add by Uthen
				#echo '<script type="text/javascript">
                #            alert("insertPermisson executed Line 267 ");
    			#		</script>';
			#end add

            $table = "tb_access_group_permission";
            $field = "access_group_id, menu_id";

            foreach ($menu as $m) {
                if (strUtil::isEmpty($m)) continue;
                $data = "'$access_group_id', '$m'";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;
            }

            return true;
        }

        public function insertMember($access_group_id, $member){
			
            $table = "tb_access_group_sale";
            $field = "access_group_id, sale_id";

            foreach ($member as $m) {
               // echo $m = trim($m); exit;
                $m = trim($m);
                if (strUtil::isEmpty($m)) continue;
                $data = "'$access_group_id', '$m'";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;
            }

            return true;
        }
    }
?>
