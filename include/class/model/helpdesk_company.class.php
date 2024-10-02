<?php
    include_once "model.class.php";

    class helpdesk_company extends model {

        public function listCombo(){
			
			if(strUtil::isNotEmpty(user_session::get_cus_company_id())){
				$sql = " SELECT company_id as assign_comp_id, company_name as assign_comp_name"
                    . " FROM helpdesk_company"
					. " WHERE company_id = '".user_session::get_user_company_id()."'"
                    . " ORDER BY company_name";
			}else{
				$sql = " SELECT company_id as assign_comp_id, company_name as assign_comp_name"
                    . " FROM helpdesk_company"
                    . " ORDER BY company_name";
			}
			
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
        
        public function listCombo_master(){
            $sql = " SELECT company_id,company_name"
                    . " FROM helpdesk_company"
                    . " ORDER BY company_name";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
		
	public function cuscompany(){
            $sql = " SELECT cus_company_id , cus_company_name "
                    . " FROM helpdesk_cus_company"
                    . " ORDER BY cus_company_name";

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
