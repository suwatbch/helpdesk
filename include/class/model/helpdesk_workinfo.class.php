<?php
    include_once "model.class.php";

    class Workinfotype extends model {

        public function listCombo(){
            $sql = " SELECT workinfo_id, workinfo_name"
                    . " FROM helpdesk_work_type"
                    . " ORDER BY workinfo_id";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
		
		public function getByWorkinfoID($workinfo_id){
			//. " INNER JOIN helpdesk_tr_incident i ON w.incident_id = i.ident_id_run_project_id" 
            $sql = " SELECT *,CONCAT(first_name,' ',last_name) as user_name"
                    . " FROM helpdesk_tr_workinfo w" 
                    . " INNER JOIN helpdesk_tr_incident i ON w.incident_id = i.id" 
                    //. " INNER JOIN helpdesk_work_type wt ON w.workinfo_type_id = wt.workinfo_id" 
                    . " INNER JOIN helpdesk_user u ON w.workinfo_user_id = u.user_id" 
                    . " INNER JOIN helpdesk_status s ON w.workinfo_status_id = s.status_id" 
                    . " LEFT JOIN helpdesk_status_res sr ON w.workinfo_status_res_id = sr.status_res_id" 
                    . " WHERE w.workinfo_id = $workinfo_id" 
                    . " ORDER BY w.workinfo_id";
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result); //exit;

            if ($rows == 0) return null;

			$Workinfo = $this->db->fetch_array($result);

			//exit;
            return $Workinfo;
        }
    }
?>
