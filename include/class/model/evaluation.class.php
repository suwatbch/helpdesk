<?php
    include_once "model.class.php";

    class incident extends model {

        public function getByIncidentID($incident_id){
			global $asm,$wif;
            # Incident Header  
			$field = "*,u.first_name,u.last_name,u2.first_name as first_name2,u.email as owner_user_email,u2.last_name as last_name2
					,o1.org_name as owner_org_name,o2.org_name as owner_grp_name,o3.org_name as owner_subgrp_name
					,c.company_name as owner_company_name
					,prdt1.prd_tier_name as cas_prd_tier_id1_name,prdt2.prd_tier_name as cas_prd_tier_id2_name
					,prdt3.prd_tier_name as cas_prd_tier_id3_name
					,CONCAT(u3.first_name,' ',u3.last_name) as resolution_user
					,i.cus_company_id as cus_company_id";
            $table = " helpdesk_tr_incident i"
					. " LEFT JOIN helpdesk_satisfaction sat ON (i.satisfac_id = sat.satisfac_id)"
					. " LEFT JOIN helpdesk_user u ON (i.owner_user_id = u.user_id)"
					. " LEFT JOIN helpdesk_user u2 ON (i.last_modify_by = u2.user_id)"
					. " LEFT JOIN helpdesk_company c ON (i.owner_comp_id = c.company_id)"
					. " LEFT JOIN helpdesk_org o1 ON (i.owner_org_id = o1.org_id)"
					. " LEFT JOIN helpdesk_org o2 ON (i.owner_grp_id = o2.org_id)"
					. " LEFT JOIN helpdesk_org o3 ON (i.owner_subgrp_id = o3.org_id)"
					. " LEFT JOIN helpdesk_prd_tier prdt1 ON (i.cas_prd_tier_id1 = prdt1.prd_tier_id)"
					. " LEFT JOIN helpdesk_prd_tier prdt2 ON (i.cas_prd_tier_id2 = prdt2.prd_tier_id)"
					. " LEFT JOIN helpdesk_prd_tier prdt3 ON (i.cas_prd_tier_id3 = prdt3.prd_tier_id)" 
					. " LEFT JOIN helpdesk_user u3 ON (i.resolution_user_id = u3.user_id)"
					;
            $condition = " id = $incident_id";
			
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();
            
            $incident = $this->db->fetch_array($result);
			
			//exit();
			
			
           return $incident;
			
        }

        public function update($incident){
			date_default_timezone_set('Asia/Bangkok');
			$today = date("Y-m-d H:i:s");
            # update helpdesk_tr_incident
			# ตรวจสอบว่ามีการประเมินให้คะแนน incident หรือไม่
			if($incident["id"] && $incident["satisfac_id"] != 0){
				# Resolv Update fields satisfac_id & satisfac_date & satisfac_desc
				$table = "helpdesk_tr_incident";
				$data = "satisfac_id = '{$incident["satisfac_id"]}'"
						. ", satisfac_date = '{$today}'"
						. ", satisfacation_desc = '{$incident["satisfacation_desc"]}'"
						;
				$condition = "id = '{$incident["id"]}'";
					
				$result = $this->db->update($table, $data, $condition);
				if (!$result) return false;
				
			}
			return $result;
		}

		
    }
?>
