<?php
    include_once "model.class.php";

    class helpdesk_user extends model {

        public function listCombo($assign_comp_id="", $assign_subgrp_id=""){
            /*$sql = " SELECT user_id as assign_assignee_id, first_name as assign_assignee_name"
                    . " FROM helpdesk_user"
                    . " ORDER BY user_id";*/
			
			$sql = " SELECT DISTINCT us.user_id as assign_assignee_id, CONCAT(us.first_name,' ',us.last_name) as assign_assignee_name"
                    . " FROM helpdesk_user us left join helpdesk_tr_user_specorg up on (us.user_id=up.user_id) Where us.user_status = 1";
					
            if (strUtil::isNotEmpty($assign_comp_id) && strUtil::isNotEmpty($assign_subgrp_id)){
                $sql .= " AND (us.company_id = $assign_comp_id AND us.org_id = $assign_subgrp_id) or (up.company_id = $assign_comp_id AND up.org_id = $assign_subgrp_id)"; //exit;
            }
			
			//$sql .= " ORDER BY us.user_id"; //exit;
            $sql .= " ORDER BY us.user_id"; //exit;

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function getById($user_id){
            $field = "s.sale_id, s.manager_id, vs1.sale_full_name AS manager_name"
                       . ", s.employee_code, s.sale_group_id, g.sale_group_name, s.title, s.sale_first_name, s.sale_last_name, s.user_login, s.pass"
                       . ", s.position_id, p.position_name, s.company_id, c.company_name, s.department"
                       . ", s.sale_status, s.address, s.amp_id, a.amp_name_th AS amp_name, s.prv_id, pv.prv_name_th AS prv_name, s.post_code, s.telephone"
                       . ", s.mobile, s.email, s.email_notify, s.daily_report, s.weekly_report"
                       . ", vs2.sale_full_name AS created_by, s.created_date"
                       . ", vs3.sale_full_name AS modified_by, s.modified_date";
            $table = " tb_sale s"
                        . " LEFT JOIN v_tb_sale vs1 ON (s.manager_id = vs1.sale_id)"
                        . " INNER JOIN tb_position p ON (s.position_id = p.position_id)"
                        . " LEFT JOIN tb_company c ON (s.company_id = c.company_id)"
                        . " LEFT JOIN tb_amphur a ON (s.amp_id = a.amp_id)"
                        . " LEFT JOIN tb_province pv ON (s.prv_id = pv.prv_id)"
                        . " LEFT JOIN tb_sale_group g ON (s.sale_group_id = g.sale_group_id)"
                        . " LEFT JOIN v_tb_sale vs2 ON (s.created_by = vs2.sale_id)"
                        . " LEFT JOIN v_tb_sale vs3 ON (s.modified_by = vs3.sale_id)";
            $condition = "s.sale_id = '$sale_id'";
            
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);
            
            if ($rows == 0) return null;

            $sale = $this->db->fetch_array($result);

            return $sale;
        }
		
		public function searchuser($cratiria){
            			
            $field = " * , CONCAT(first_name, ' ' , last_name) as user_full_name   ";
            $table = " helpdesk_user ";
            $condition = " ( ifnull(edit_report_permission,'') = 'Y' or ifnull(approve_report_permission,'') = 'Y' ) ";
			
//            if (strUtil::isNotEmpty($cratiria["monthly"])){
//                $condition .= " AND ifnull(edit_report_permission,'') = '{$cratiria["monthly"]}'";  
//		}
                
            if (strUtil::isNotEmpty($cratiria["employee_code"])){
                $condition .= " AND ifnull(employee_code,'') like '%{$cratiria["employee_code"]}%'";  
		}
                
                
            if (strUtil::isNotEmpty($cratiria["employee_name"])){
                    $condition .= " AND (ifnull(first_name,'') like '%{$cratiria["employee_name"]}%'";  
                    $condition .= " or ifnull(last_name,'') like '%{$cratiria["employee_name"]}%'  )";  
		}
                
                $condition .= " ORDER BY employee_code , first_name,last_name  ";


            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $activity = array(
                "total_row" => $total_row
                , "data" => $arr
               
            );
        }



		public function searchUser_grp($assign_comp_id="", $assign_subgrp_id=""){
            
            $sql = "SELECT * 
                    FROM ( SELECT user_id AS assign_assignee_id, CONCAT( first_name,  ' ', last_name ) AS assign_assignee_name, email, first_name, last_name, u.org_id, LEFT( org_code, 2 ) AS my_orgcode, LEFT( org_code, 4 ) AS my_grpcode, IFNULL( o.org_code,  '' ) AS my_subgrp_code
                            FROM helpdesk_user u
                            LEFT JOIN helpdesk_company c ON u.company_id = c.company_id
                            LEFT JOIN helpdesk_org o ON u.org_id = o.org_id
                            WHERE user_status = 1 ";
            
            if (strUtil::isNotEmpty($assign_comp_id)){
                $sql .= " AND u.company_id = $assign_comp_id ";
            }
            
            $sql.=" )u";
            
            if (strUtil::isNotEmpty($assign_subgrp_id)){
                $sql .= " INNER JOIN ( SELECT * 
                            FROM helpdesk_org
                            WHERE org_id = $assign_subgrp_id )org 
                        ON ( org.org_code = u.my_orgcode ) 
                        OR ( org.org_code = u.my_grpcode )
                        OR ( org.org_code = u.my_subgrp_code ) ";
            }

            $sql .= " ORDER BY first_name,last_name "; //exit;
//            echo ($sql);
//            exit();
            

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
		
        
        public function searchUser_byEmail($email){
            $sql = " select CONCAT( first_name,  ' ', last_name ) AS fullname from helpdesk_user
                    where LOWER(TRIM(email)) = LOWER(TRIM('{$email}')) ";
            
//            echo   $sql;
//            exit();
                    
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }

        #///////////////////////////////////////////////////////////////
        #Add by Uthen.p 19-04-2016 for list an e-mail PTN support group.
        public function searchPtnSupportGroupEmail()
        {
            $sql = " SELECT email "
                . " FROM helpdesk_user Where org_id='38' and user_status = '1'";
            $sql .= " ORDER BY us.user_id";
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $emailList[] = $row;
            }

            return $emailList;
        }

        #///////////////////////////////////////////////////////////////

    }
?>
