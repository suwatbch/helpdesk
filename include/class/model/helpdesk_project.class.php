<?php
    include_once "model.class.php";

    class helpdesk_project extends model {

        public function listCombo($cus_company_id){
            
			$sql = " SELECT project_id, project_name FROM helpdesk_project";

			if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE cus_comp_id = $cus_company_id";
            }
            $sql .= " ORDER BY project_id";
				
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
		

		public function listComboPerson($customer_id){
                    
                   //$customer_id = user_session::get_cus_company_id();
                   //echo $customer_id;
		   
                   $sql = " SELECT p.project_id, p.project_name FROM helpdesk_project p INNER JOIN helpdesk_project_member pm ON pm.project_id=p.project_id AND pm.customer_id='".$customer_id."'";

			if (strUtil::isNotEmpty($cus_company_id)){
                $sql .= " WHERE cus_comp_id = $cus_company_id";
            }
            $sql .= " ORDER BY project_id";
			
			
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
            $field = "p.*,c.cus_company_name";

            # table
            $table = "helpdesk_project p"
                      . " LEFT JOIN helpdesk_cus_company c on(p.cus_comp_id=c.cus_company_id)";

            # condition
            $condition = "1=1 ";

            $condition .= " ORDER BY p.project_code asc";

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
 
        public function getById($objective){
            $field = "p.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_project p"
                        . " LEFT JOIN helpdesk_user u1 ON (p.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (p.modified_by = u2.user_id)";
            $condition = "p.project_id = '$objective'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_project", "status", "D", "project_id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_project", "project_id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_project", "status", "A", "project_id = '$objective'");
            
        }
        
        public function insert(&$objective){
            $table = "helpdesk_project";
            $field = "cus_comp_id, project_code, project_name, status, created_by, created_date, modified_by, modified_date";
            $data = "'{$objective["cus_comp_id"]}', '{$objective["project_code"]}', '{$objective["project_name"]}', '{$objective["status"]}', '{$objective["created_by"]}', '{$objective["created_date"]}', {$objective["modified_by"]}, '{$objective["modified_date"]}'";

            $result = $this->db->insert($table, $field, $data);

            if ($result){
                $objective["project_id"] = $this->db->insert_id();
            }

            return $result;
        }

        public function update($objective){
            $table = "helpdesk_project";
            $data = "cus_comp_id = '{$objective["cus_comp_id"]}'"
                        . ", project_code = '{$objective["project_code"]}'"
                        . ", project_name = '{$objective["project_name"]}'"
                        . ", status = '{$objective["status"]}'"
                        . ", modified_date = '{$objective["modified_date"]}'"
                        . ", modified_by = '{$objective["modified_by"]}'";
            $condition = "project_id = '{$objective["project_id"]}'";

            return $this->db->update($table, $data, $condition);
        }
		
		public function get_project_member($objective){
            $sql = " SELECT pm.*,cu.*,c.cus_company_name"
                    . " FROM helpdesk_project_member pm"
                    . " LEFT JOIN helpdesk_project p on(pm.project_id=p.project_id)"
                    . " LEFT JOIN helpdesk_customer cu on(pm.customer_id=cu.code_cus)"
					. " LEFT JOIN helpdesk_cus_company c on(c.cus_company_id=cu.cus_company_id)"
                    //. " LEFT JOIN (SELECT org_id,org_code,org_name,org_comp FROM helpdesk_org WHERE LENGTH(org_code) = 2 ) org on (SUBSTRING(orgm.org_code, 1, 2)=org.org_code)"
                    //. " LEFT JOIN (SELECT org_id,org_code,org_name,org_comp FROM helpdesk_org WHERE LENGTH(org_code) = 4 ) grp on (SUBSTRING(orgm.org_code, 1, 4)=grp.org_code)"
                    . " WHERE pm.project_id = '$objective' AND pm.status<>'0' ORDER BY pm.customer_id asc";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
		
		public function save_user($member_project){
		
            $result = $this->insertMember($member_project["project_id"], $member_project["member"]);
            return $result;
		}
	
		public function insertMember($project_id, $member){
				
				$table = "helpdesk_project_member";
				$field = "project_id, customer_id, status";

				//print_r($member);
				
				foreach ($member as $m) {
					$m = trim($m);
					if (strUtil::isEmpty($m)) continue;
					$data = "'$project_id', '$m', '1'";
					$result = $this->db->insert($table, $field, $data);
					if(!$result) return false;
				}

				return true;
		}
		
		public function delete_user($objective1){
            return $this->deleteWithoutUpdate("helpdesk_project_member", "id = '$objective1'");
        }
		
		public function searchMember($criteria){				

            $sql = "select * from helpdesk_project_member where project_id = '{$criteria["project_id"]}'";
            $result = $this->db->query($sql);
            $rows = $this->db->fetch_array($result); 
            if ($rows > 1){
                    $s_customer_id = "";
                    $s_customer_id = "'".$rows["customer_id"]."'";;
                while($row = $this->db->fetch_array($result)){
                    $s_customer_id .= ",'".$row["customer_id"]."'";
                }
            }else if($rows == 1){
                    $s_customer_id = $rows["customer_id"];	
            }
		
            $field = "hc.cus_id, hc.code_cus, hc.firstname_cus, hc.lastname_cus, c.cus_company_name";
            $table = "helpdesk_customer hc"
                       . " LEFT JOIN helpdesk_cus_company c ON (hc.cus_company_id = c.cus_company_id)";
            $condition = "hc.status_customer <> 'D'";
            $order_by= "hc.code_cus";

            if (strUtil::isNotEmpty($criteria["code_cus"])) {
                $condition .= " AND hc.code_cus LIKE '%{$criteria["code_cus"]}%'";
            }

            if (strUtil::isNotEmpty($criteria["first_name"])) {
                $condition .= " AND hc.firstname_cus LIKE '%{$criteria["first_name"]}%'";
            }
            
            if (strUtil::isNotEmpty($criteria["last_name"])) {
                $condition .= " AND hc.lastname_cus LIKE '%{$criteria["last_name"]}%'";
            }

            if (strUtil::isNotEmpty($criteria["cus_comp_id"])) {
                $condition .= " AND hc.cus_company_id = ({$criteria["cus_comp_id"]})";
            }
			
			if (strUtil::isNotEmpty($s_customer_id)) {
                $condition .= " AND hc.code_cus NOT IN ({$s_customer_id})";
            }

			//echo $s_customer_id;
			
            $result = $this->db->select($field, $table, $condition, $order_by);
            $rows =  $this->db->num_rows($result);

            if ($rows == 0) return array();
            while ($row = $this->db->fetch_array($result)){
                $arr_member[] = $row;
            }

            return $arr_member;

        }
    }
?>
