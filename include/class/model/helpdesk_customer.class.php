<?php
	session_start();
    include_once "model.class.php";
	//include_once "../include/class/user_session.class.php";
	//echo user_session::get_cus_company_id();
	
    class helpdesk_customer extends model {

        public function getByCustomerCode($cusid){
			
			//echo user_session::get_cus_company_id();
			$field = "c.code_cus,c.firstname_cus,c.lastname_cus,c.phone_cus,c.ipaddress_cus,
			c.email_cus,c.cus_company_id,com.cus_company_name,org.cus_org_name,c.area_cus,c.office_cus,c.dep_cus,
			c.site_cus,CONCAT(c2.firstname_cus,' ',c2.lastname_cus) as keyuser,c.cus_id as customer_id,cz.area_cus_name";    
            $table = " helpdesk_customer c"
					. " LEFT JOIN helpdesk_cus_company com ON (c.cus_company_id = com.cus_company_id)"
					. " LEFT JOIN helpdesk_cus_org org ON (c.org_cus = org.cus_org_id)"
					. " LEFT JOIN helpdesk_customer c2 ON (c.keyuser_id_cus = c2.cus_id)"
					. " LEFT JOIN helpdesk_cus_zone_area cz ON (c.area_cus = cz.area_cus)";

			if(strUtil::isNotEmpty(user_session::get_cus_company_id())){
				$condition = " c.code_cus = '$cusid' AND c.status_customer<>'I' AND c.cus_company_id = '".user_session::get_cus_company_id()."'";
			}else{
				$condition = " c.code_cus = '$cusid' AND c.status_customer<>'I'";
			}		
            //echo $condition;
			
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();
            
            $customer = $this->db->fetch_array($result);
            //exit();
            return $customer;
        }
		
        public function getByCustomerID($cusid){
			
            # Customer By ID
			$field = "*";
            $table = " helpdesk_customer c"
					;
            $condition = " cus_id = $cusid";
			
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();
            
            $customer = $this->db->fetch_array($result);
			//exit();
            return $customer;
			
        }
        
		
		
         public function getByCustomer($criteria){
			
			//echo $cus_com_id = user_session::get_cus_company_id();	
			
            $field = "c.code_cus,c.firstname_cus,c.lastname_cus,c.phone_cus,c.ipaddress_cus,c.cus_id,
			c.email_cus,c.cus_company_id,com.cus_company_name,org.cus_org_name,c.area_cus,c.office_cus,c.dep_cus,
			c.site_cus,CONCAT(c2.firstname_cus,' ',c2.lastname_cus) as keyuser,cz.area_cus_name";    
            $table = " helpdesk_customer c"
					. " LEFT JOIN helpdesk_cus_company com ON (c.cus_company_id = com.cus_company_id)"
					. " LEFT JOIN helpdesk_cus_org org ON (c.org_cus = org.cus_org_id)"
					. " LEFT JOIN helpdesk_customer c2 ON (c.keyuser_id_cus = c2.cus_id)"
                    . " LEFT JOIN helpdesk_cus_zone_area cz ON (c.area_cus = cz.area_cus)";
			
			if(strUtil::isNotEmpty(user_session::get_cus_company_id())){
				$condition = " 1 = 1 AND c.status_customer<>'I' AND c.cus_company_id = '".user_session::get_cus_company_id()."'";
			}else{
				$condition = " 1 = 1 AND c.status_customer<>'I'";
			}
			
				
				
            if(strUtil::isNotEmpty($criteria["code_cus"])){
                $condition .= " AND c.code_cus LIKE '%{$criteria["code_cus"]}%'";
            }
            if(strUtil::isNotEmpty($criteria["first_name"])){
                $condition .= " AND c.firstname_cus LIKE '%{$criteria["first_name"]}%'";
            }
            if(strUtil::isNotEmpty($criteria["last_name"])){
                $condition .= " AND c.lastname_cus LIKE '%{$criteria["last_name"]}%'";
            }
            if(strUtil::isNotEmpty($criteria["area_cus"])){
                $condition .= " AND c.area_cus = '{$criteria["area_cus"]}'";
            }
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();
            
            while($row = $this->db->fetch_array($result)){
                $arr_customer[] = $row;
            }

            return array(
                "total_row" => $rows
                , "arr_customer" => $arr_customer
            );
         }
    }
?>
