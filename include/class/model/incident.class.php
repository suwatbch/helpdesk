<?php
include_once "model.class.php";
include_once "sla.class.php";
include_once dirname(dirname(dirname(dirname(__FILE__))))."/incident/manage_incident/incident.getrunning.php";
#Add by Uthen.p
include_once "../../include/class/model/helpdesk_user.class.php";
#end

include_once "../../include/class/model/helpdesk_workinfo_period.class.php";

class incident extends model {

    public function getByIncidentID($incident_id){
        global $asm,$wif;
        # Incident Header
        $field = "i.*,u.first_name,u.last_name,u2.first_name as first_name2,u.email as owner_user_email,u2.last_name as last_name2
					,o1.org_name as owner_org_name,o2.org_name as owner_grp_name,o3.org_name as owner_subgrp_name
					,c.company_name as owner_company_name
					,prdt1.prd_tier_name as cas_prd_tier_id1_name,prdt2.prd_tier_name as cas_prd_tier_id2_name
					,prdt3.prd_tier_name as cas_prd_tier_id3_name
					,CONCAT(u3.first_name,' ',u3.last_name) as resolution_user
					,i.cus_company_id as cus_company_id,km.km_release,z.area_cus_name";
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
            . " LEFT JOIN helpdesk_km_incident km ON (i.id=km.incident_id)"
            . " LEFT JOIN helpdesk_cus_zone_area z ON (i.cus_area=z.area_cus)"
        ;
        $condition = " i.id = $incident_id";

        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();

        $incident = $this->db->fetch_array($result);

        //exit();

        # Assignment Tab
        $field = "*";
        $table = " helpdesk_tr_assignment";
        $condition = " incident_id = $incident_id ORDER BY assign_id ASC ";

        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);
        if ($rows > 0){
            while($row = $this->db->fetch_array($result)){
                $incident["Assignment"][] = $row;
            }
        }

        if (count($incident["Assignment"]) > 0){
            foreach ($incident["Assignment"] as $asm) {
                //$asm["assign_group_id"];
            }
        }

        # Work Info Tab
        $field = "w.workinfo_id,w.incident_id,workinfo_name,workinfo_summary,workinfo_notes,first_name,last_name,workinfo_date,status_desc,w.workinfo_attach";
        $table = " helpdesk_tr_workinfo w"
            . " LEFT JOIN helpdesk_user u ON (w.workinfo_user_id = u.user_id)"
            . " LEFT JOIN helpdesk_work_type wt ON (w.workinfo_type_id = wt.workinfo_id)"
            . " LEFT JOIN helpdesk_status s ON (w.workinfo_status_id = s.status_id)";
        $condition = " incident_id = $incident_id ORDER BY w.workinfo_id Desc ";

        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);
        if ($rows > 0){
            while($row = $this->db->fetch_array($result)){
                $incident["Workinfo"][] = $row;
            }
        }

        if (count($incident["Workinfo"]) > 0){
            foreach ($incident["Workinfo"] as $wif) {
                //echo $wif["workinfo_name"];
            }
        }

        #Get Attach Files Cassification
        $table = " helpdesk_tr_attachment a inner join helpdesk_user u on(a.attach_user_id = u.user_id)";
        $field = " attach_name,first_name,last_name,attach_date,location_name,attach_id";
        $condition = " incident_id = $incident_id AND type_attachment = 1 AND workinfo_id = 0"
            . " ORDER BY attach_date";
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);
        if ($rows > 0){
            while($row = $this->db->fetch_array($result)){
                $incident["file_cassification"][] = $row;
            }
        }

        #Get Attach Files Resolution
        $table = " helpdesk_tr_attachment a inner join helpdesk_user u on(a.attach_user_id = u.user_id)";
        $field = " attach_name,first_name,last_name,attach_date,location_name,attach_id";
        $condition = " incident_id = $incident_id AND type_attachment = 3 AND workinfo_id = 0"
            . " ORDER BY attach_date";
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);
        if ($rows > 0){
            while($row = $this->db->fetch_array($result)){
                $incident["file_resolution"][] = $row;
            }
        }


        # Control SAVE&Close button ตรวจสอบว่ามีสิทธิ์จัดการกับ incident หรือไม่
        $IncidentInSubGrpID 	= $asm["assign_subgrp_id"];
        $IncidentStatusID 		= $incident["status_id"];
        $IncidentOwner_user_ID 	= $incident["owner_user_id"];
        $IncidentAssigneeID 	= $asm["assign_assignee_id"];
        $UserInSubGrpID 		= user_session::get_user_subgrp_id();
        $UserInSubGrpID_spec_arr= user_session::get_subgrp_id_spec_arr();
        $UserAdmin 				= user_session::get_user_admin();
        $User_tra_inc_per 		= user_session::get_user_tra_inc_per();
        $User_admin_permission 	= user_session::get_user_admin_permission();
        $User_id 				= user_session::get_user_id();


        #Admin Sys ดูว่าเป็นเแอดมินระบบหรือไม่
        if($UserAdmin == "Y"){
            $incident["permission_saveIncident"] = "";
            #incident Closed ดู inci อยู่ในสถานะ Closed หรือไม่่
        }elseif($IncidentStatusID == 7){
            $incident["permission_saveIncident"] = "none";
            #Create incident First Time เป็นการสร้างครั้งแรกด้วยเจ้าของเอง
        }elseif($IncidentStatusID == 1 && $IncidentOwner_user_ID == $User_id){
            #Alow to Transfer incident
            if($User_tra_inc_per == "Y"){
                $incident["permission_saveIncident"] = "";
                $incident["per_ddAssign1"] = "";
                $incident["per_ddAssign2"] = "Y";   		//เป็น Y กรณีเปิดครั้งแรกและผู้ใช้มีสิทธิ์ Transfer
                #Not Alow to Transfer incident
            }else{
                $incident["permission_saveIncident"] = "";
                $incident["per_ddAssign1"] = "class=\"select_dis\" disabled=\"true";
                $incident["per_ddAssign2"] = "Y";   		//เป็น Y กรณีเปิดครั้งแรกและผู้ใช้ไม่มีสิทธิ์ Transfer
            }
            #Create incident First Time เป็นการสร้างครั้งแรก แ่ต่ไม่ได้เป็นเจ้าของเอง
        }elseif($IncidentStatusID == 1 && $IncidentOwner_user_ID != $User_id){

            #Alow to Admin Permission incident
            if($User_admin_permission == "Y"){
                $incident["permission_saveIncident"] = "";   //แสดงปุ่มบันทึก
                $incident["per_ddAssign1"] = "";
                $incident["per_ddAssign2"] = "Y";   		//เป็น Y กรณีเปิดครั้งแรกและผู้ใช้ไม่มีสิทธิ์ Transfer
                #Not Alow to Transfer incident
            }else{
                $incident["permission_saveIncident"] = "none";   //ไม่แสดงปุ่มบันทึก
                $incident["per_ddAssign1"] = "class=\"select_dis\" disabled=\"true";
                $incident["per_ddAssign2"] = "Y";   //เป็น Y กรณีเปิดครั้งแรกและผู้ใช้ไม่มีสิทธิ์ Transfer
            }
            #Subgroup อยู่ในกลุ่มของตัวเอง
        }elseif($IncidentInSubGrpID == $UserInSubGrpID){
            $incident["permission_saveIncident"] = "";
            #Alow to Transfer incident
            if($User_tra_inc_per == "Y"){
                $incident["per_ddAssign1"] = "";
                #Not Alow to Transfer incident
            }else{
                $incident["per_ddAssign1"] = "class=\"select_dis\" disabled=\"true";
            }
            #Not Subgroup1 ไม่ได้อยู่ในกลุ่มของตัวเอง แต่อยู่ใน Specisl Org
        }elseif($IncidentInSubGrpID != $UserInSubGrpID && in_array($IncidentInSubGrpID,$UserInSubGrpID_spec_arr)){
            $incident["permission_saveIncident"] = "";
            #Alow to Transfer incident
            if($User_tra_inc_per == "Y"){
                $incident["per_ddAssign1"] = "";
                #Not Alow to Transfer incident
            }else{
                $incident["per_ddAssign1"] = "class=\"select_dis\" disabled=\"true";
            }
            #Not Subgroup2 ไม่ได้อยู่ในกลุ่มของตัวเอง แต่ได้รับสิทธิ์เป็น admin_permisstion
        }elseif($IncidentInSubGrpID != $UserInSubGrpID && $User_admin_permission == "Y"){
            $incident["permission_saveIncident"] = "";
            #Alow to Transfer incident
            if($User_tra_inc_per == "Y"){
                $incident["per_ddAssign1"] = "";
                #Not Alow to Transfer incident
            }else{
                //$incident["per_ddAssign1"] = "class=\"select_dis\" disabled=\"true";
                $incident["per_ddAssign1"] = "disabled=\"true";
            }
        }else{
            $incident["permission_saveIncident"] = "none";
            $incident["per_ddAssign1"] = "class=\"select_dis\" disabled=\"true";
        }


        return $incident;

    }


    public function search($criteria, $page = 1){
        global $page_size;

        $field = "c.customer_id, c.customer_code, c.customer_name, c.telephone";
        $table = " tb_customer c";
        $condition = " c.customer_status <> 'D' AND c.type <> 'SYS'";

        if (strUtil::isNotEmpty($criteria["customer_code"])){
            $condition .= " AND c.customer_code LIKE '%{$criteria["customer_code"]}%'";
        }

        if (strUtil::isNotEmpty($criteria["customer_name"])){
            $condition .= " AND c.customer_name LIKE '%{$criteria["customer_name"]}%'";
        }

        if (strUtil::isNotEmpty($criteria["customer_group_id"])){
            $condition .= " AND c.customer_group_id = '{$criteria["customer_group_id"]}'";
        }

        $condition .= " ORDER BY c.customer_code, c.customer_name";

        $total_row = $this->db->count_rows($table, $condition);
        $result = $this->db->select_data_page($field, $table, $condition, $page, $page_size);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();

        while($row = $this->db->fetch_array($result)){
            $arr_customer[] = $row;
        }

        return array(
            "total_row" => $total_row
        , "arr_customer" => $arr_customer
        );
    }


    public function isDuplicate($customer){
        $table = "helpdesk_customer";
        $condition = "code_cus = '{$customer["cus_id"]}'";
        $rows = $this->db->count_rows($table, $condition);

        if ($rows < 1){
            return "customer id";
        }

        return false;
    }


    public function delete($customer_id){
        return $this->deleteWithUpdate("tb_customer", "customer_status", "D", "customer_id = '$customer_id'");
    }


    public function insert(&$incident){
        date_default_timezone_set('Asia/Bangkok');
        $today = date("Y-m-d H:i:s");
        $owner_comp_id 		= user_session::get_user_company_id();
        $owner_org_id 		= user_session::get_user_org_id();

        $owner_grp_id 		= user_session::get_user_grp_id();
        $owner_subgrp_id 	= user_session::get_user_subgrp_id();

        $owner_user_id 		= user_session::get_user_id();
        $last_modify_by 	= user_session::get_user_id();

        #Get Config Incident Running Number
        /*$IncidentRun = incident::GetConfig();
        $IncidentRunProject = $IncidentRun["IncidentRunProject"];
        $IncidentRunDigit = $IncidentRun["IncidentRunDigit"];
        $IncidentPrefix = $IncidentRun["IncidentPrefix"];*/
        $IncidentRunProject = user_session::get_user_IncidentRunProject($IncidentRunProject);
        $IncidentRunDigit 	= user_session::get_user_IncidentRunDigit($IncidentRunDigit);
        $IncidentPrefix 	= user_session::get_user_IncidentPrefix($IncidentPrefix);


        #get running number by Project Code
        if($IncidentRunProject == "Y"){ # Incidetn Running By project_code กำหนดไว้ที่ config.inc
			//echo $incident["project_id"];
            $getIdentRunningByProject = incident::getIdentRunningByProject($incident["project_id"]);
			//print_r($getIdentRunningByProject);
			$identrun_id = $getIdentRunningByProject["ident_id_run_project"]+1;
            $IdentRunningByProject_code = $getIdentRunningByProject["project_code"];
            $IncidentRunProject.$IncidentPrefix;
            $IdentRunningByProject_id = sprintf("%0".$IncidentRunDigit."d",$identrun_id); //sprintf("%05d",$std_id)
            $identrun = $IdentRunningByProject_code."-".$IdentRunningByProject_id;
			//exit;
        }
		
        # insert helpdesk_tr_incident
        $table = "helpdesk_tr_incident";
        $field = "ident_id_run_project_id,ident_id_run_project,summary, notes, status_id, status_res_id, impact_id, urgency_id, priority_id
					 , cus_id, cus_firstname, cus_lastname, cus_phone, cus_ipaddress, cus_email
					 , cus_company, cus_organize, cus_area, cus_office, cus_department, cus_site
					 , keyuser_name
					 , con_firstname, con_lastname, con_phone, con_ipaddr, con_email, con_place
					 , ident_type_id, project_id, cas_opr_tier_id1, cas_opr_tier_id2, cas_opr_tier_id3, cas_prd_tier_id1
					 , cas_prd_tier_id2, cas_prd_tier_id3
					 , owner_date,create_date,last_modify_date
					 , owner_comp_id,owner_org_id,owner_user_id,last_modify_by
					 , owner_grp_id,owner_subgrp_id, cus_company_id, reference_no
                                         , assign_subgrp_id_last, assign_org_id_last, assign_comp_id_last, assign_grp_id_last
					 ";
        $data = "'{$identrun_id}','{$identrun}'
					,'{$incident["summary"]}', '{$incident["notes"]}'
					, '{$incident["status_id"]}', '{$incident["status_res_id"]}'
					, '{$incident["impact_id"]}', '{$incident["urgency_id"]}'
					, '{$incident["priority_id"]}'

					, '{$incident["cus_id"]}', '{$incident["cus_firstname"]}'
					, '{$incident["cus_lastname"]}', '{$incident["cus_phone"]}'
					, '{$incident["cus_ipaddress"]}', '{$incident["cus_email"]}'
					, '{$incident["cus_company"]}', '{$incident["cus_organize"]}'
					, '{$incident["cus_area"]}', '{$incident["cus_office"]}'
					, '{$incident["cus_department"]}', '{$incident["cus_site"]}'
					, '{$incident["keyuser_name"]}'

					, '{$incident["con_firstname"]}', '{$incident["con_lastname"]}'
					, '{$incident["con_phone"]}', '{$incident["con_ipaddr"]}'
					, '{$incident["con_email"]}', '{$incident["con_place"]}'

					, '{$incident["ident_type_id"]}', '{$incident["project_id"]}'
					, '{$incident["cas_opr_tier_id1"]}', '{$incident["cas_opr_tier_id2"]}'
					, '{$incident["cas_opr_tier_id3"]}', '{$incident["cas_prd_tier_id1"]}'
					, '{$incident["cas_prd_tier_id2"]}', '{$incident["cas_prd_tier_id3"]}'

					, '{$today}', '{$today}', '{$today}'
					, '{$owner_comp_id}','{$owner_org_id}','{$owner_user_id}','{$last_modify_by}'
					, '{$owner_grp_id}','{$owner_subgrp_id}', '{$incident["cus_company_id"]}', '{$incident["reference_no"]}'
                                        , '{$owner_subgrp_id}','{$owner_org_id}','{$owner_comp_id}','{$owner_grp_id}'
					";
        
		//echo $data;
		//exit;
        $result = $this->db->insert($table, $field, $data);
        if(!$result) return false;
				
        $incident["id"] = $this->db->insert_id();
        include "upload_cass.php";
//			#Updete Attach Files/Cassification
//					$user_upfile		= user_session::get_user_id();

//					$Array_attachs_cass 	= array();
//					$Array_attach_cass 	= $incident["working_Array_attach_cass"][0];
//					$Array_attachs_cass 	= explode(",", $Array_attach_cass);
//					if(sizeof($Array_attachs_cass) > 0 && $Array_attachs_cass[0]){
//						for($i=0; $i<sizeof($Array_attachs_cass); $i++){
//							$table 		= "helpdesk_tr_attachment";
//							$data 		= "incident_id = '{$incident_cass}'";
//                            $condition  = "incident_id = 0  AND type_attachment = '1' AND workinfo_id = '0' AND attach_user_id = '$user_upfile'";
//							$result = $this->db->update($table, $data, $condition);
//							if (!$result) return false;
//						}
//					}
        #Insert Assigned
        //$incident_cass 	= $this->db->insert_id();
        if($incident["s_km_id"] != "" && $incident["s_km_id"] != 0){
            $filed_assignee = ",assign_assignee_id";
            $field_data_assignee = ",".user_session::get_user_id();
        }
        $table = "helpdesk_tr_assignment";
        $field = "incident_id, assign_status_id, assign_status_res_id, assign_comp_id
							,assign_org_id,assign_group_id,assign_subgrp_id,entry_date".$filed_assignee."";
        $data = "'{$incident["id"]}', '{$incident["status_id"]}'
							, '{$incident["status_res_id"]}', '{$owner_comp_id}'
							, '{$owner_org_id}', '{$owner_grp_id}'
							, '{$owner_subgrp_id}'
							, '{$today}'".$field_data_assignee."";
        $result = $this->db->insert($table, $field, $data);
        if(!$result) return false;
        #Update Contact to Detail Customer
        if($incident["con_phone"]!=""){
            $table = "helpdesk_customer";
            $data = "phone_cus = '{$incident["con_phone"]}'";
            $condition = "code_cus = '{$incident["cus_id"]}'";
            $result_in = $this->db->update($table, $data, $condition);

            $table = "helpdesk_tr_incident";
            $data = "cus_phone = '{$incident["con_phone"]}'";
            $condition = "id = '{$incident["id"]}'";
            $result_in_cus = $this->db->update($table, $data, $condition);


            if (!$result) return false;

        }
        if($incident["con_ipaddr"]!=""){
            $table = "helpdesk_customer";
            $data = "ipaddress_cus = '{$incident["con_ipaddr"]}'";
            $condition = "code_cus = '{$incident["cus_id"]}'";
            $result_in = $this->db->update($table, $data, $condition);

            $table = "helpdesk_tr_incident";
            $data = "cus_ipaddress = '{$incident["con_ipaddr"]}'";
            $condition = "id = '{$incident["id"]}'";
            $result_in_cus = $this->db->update($table, $data, $condition);

            if (!$result) return false;
        }
        if($incident["con_email"]!=""){
            $table = "helpdesk_customer";
            $data = "email_cus = '{$incident["con_email"]}'";
            $condition = "code_cus = '{$incident["cus_id"]}'";
            $result_in = $this->db->update($table, $data, $condition);

            $table = "helpdesk_tr_incident";
            $data = "cus_email = '{$incident["con_email"]}'";
            $condition = "id = '{$incident["id"]}'";
            $result_in_cus = $this->db->update($table, $data, $condition);

            if (!$result) return false;

        }

        /*
        # insert tb_customer_contact_person
        $result = $this->insertContactPerson($customer["customer_id"], $customer["contact_person"]);
        if(!$result) return false;

        # insert tb_customer_gallery
        $result = $this->insertGallery($customer["customer_id"], $customer["gallery"]);
        */
        /////////////////////////////////////////km ref//////////////////////////////////
        if($incident["s_km_id"] != "" && $incident["s_km_id"] != 0){
            $user_ass_id_last = user_session::get_user_id();

            /////////////////////////update ranking//////////////
            $sql_ranking = "update helpdesk_km_incident set ranking = helpdesk_km_incident.ranking+1 where km_id = '{$incident["s_km_id"]}'";
            $result = $this->db->query($sql_ranking);

            ///////////////////////////////////////////////////////
            $table = "helpdesk_tr_incident";
            $data = "assigned_date = '{$today}',assigned_date_last = '{$today}',
                                        assignee_id_last = '{$user_ass_id_last}',working_date = '{$today}',
                                        km_reference = '{$incident["s_km_id"]}'";
            $condition = "id = '{$incident["id"]}'";
            $result = $this->db->update($table, $data, $condition);
            # Workinfo
            if($incident["status_id"] == 3 && $incident["workinfo_summary"] != ""){
                if((count($incident["uploadfile_working"]["name"])-1) > 0){
                    $cnt_attachs 	= 1;
                }else{
                    $cnt_attachs 	= 0;
                }
                $last_user_id 		= user_session::get_user_id();
                $table 	= "helpdesk_tr_workinfo";
                $field 	= "incident_id, workinfo_status_id, workinfo_status_res_id
							,workinfo_type_id,workinfo_summary,workinfo_notes,workinfo_user_id,workinfo_date,workinfo_attach";
                $data 	= "'{$incident["id"]}', '{$incident["status_id"]}'
							, '{$incident["status_res_id"]}'
							, '{$incident["workinfo_type_id"]}', '{$incident["workinfo_summary"]}'
							, '{$incident["workinfo_notes"]}', '{$last_user_id}'
							, '{$today}', '{$cnt_attachs}'
							";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;
                //exit();

                #Updete Attach Files/Work Info

                $last_workid 	= $this->db->insert_id();
                include "upload_workinfo.php";

                #Update working_date Date to tr_incident
                #check responded_days

                $time = sla::cal_sla_days($incident["assigned_date"], $today, $incident["cus_company_id"]);
                $set_responded_by = ", responded_by = '{$last_modify_by}'
                                                                    , responded_by_grp_id = '{$incident["assign_group_id"]}'
                                                                    , responded_by_subgrp_id = '{$incident["assign_subgrp_id"]}' ";
                $set_responded_days = ", responded_days = '{$time["sla_days"]}'";
                $set_responded_holiday = ", responded_holiday = '{$time["holiday"]}'";
                $set_working_date = ", working_date = '{$today}'";

                $table = "helpdesk_tr_incident";
                $data = "status_id = '{$incident["status_id"]}'"
                    .$set_responded_by.$set_responded_days.$set_responded_holiday.$set_working_date;
                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                if (!$result) return false;
            }

            # Pending
            elseif($incident["status_id"] == 4 && $incident["status_res_id"] != "" && $incident["workinfo_summary"] != ""){
                if((count($incident["uploadfile_working"]["name"])-1) > 0){
                    $cnt_attachs 	= 1;
                }else{
                    $cnt_attachs 	= 0;
                }

                #Insert workinfo
                $last_user_id = user_session::get_user_id();
                $table = "helpdesk_tr_workinfo";
                $field = "incident_id, workinfo_status_id, workinfo_status_res_id
							,workinfo_type_id,workinfo_summary,workinfo_notes,workinfo_user_id,workinfo_date,workinfo_attach";
                $data = "'{$incident["id"]}', '{$incident["status_id"]}'
							, '{$incident["status_res_id"]}'
							, '{$incident["workinfo_type_id"]}', '{$incident["workinfo_summary"]}'
							, '{$incident["workinfo_notes"]}', '{$last_user_id}'
							, '{$today}', '{$cnt_attachs}'
							";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;
                $last_workid 	= $this->db->insert_id();
                include "upload_workinfo.php";

                #Update working_date Date to tr_incident
                #check responded_days
                $time = dateUtil::date_diff3($incident["assigned_date"], $today);
                $set_responded_days = ", responded_days = '{$time}'";
                $set_working_date = ", working_date = '{$today}'";
                $table = "helpdesk_tr_incident";
                $data = "status_id = '{$incident["status_id"]}'"
                    . ", status_res_id = '{$incident["status_res_id"]}'".$set_responded_days.$set_working_date;
                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                if (!$result) return false;
            }
            # Resolv
            elseif($incident["status_id"] == 5 && $incident["resolution"] != "" && $incident["status_res_id"] != ""
                && $incident["resol_oprtier1"] != "" && $incident["resol_oprtier2"] != "" && $incident["resol_prdtier1"] != "" && $incident["resol_prdtier2"] != ""){
                $time = sla::cal_sla_days($incident["working_date"], $today, $incident["cus_company_id"],"Y",$incident["id"]);
                $set_resolved_by = ", resolved_by = '{$last_modify_by}'
                                                                    , resolved_by_grp_id = '{$incident["assign_group_id"]}'
                                                                    , resolved_by_subgrp_id = '{$incident["assign_subgrp_id"]}' ";
                $set_resolved_days = ", resolved_days = '{$time["sla_days"]}'";
                $set_resolved_holiday = ", resolved_holiday = '{$time["holiday"]}'";
                $set_resolved_pending = ", resolved_pending = '{$time["pending"]}'";
                $set_resolved_date = ", resolved_date = '{$today}'";
                #Update Resolv
                $resolution_user_id = user_session::get_user_id();
                $table = "helpdesk_tr_incident";
                $data = "resolution = '{$incident["resolution"]}'"
                    . ", resolution_user_id = '{$resolution_user_id}'"
                    . ", satisfac_id = '{$incident["satisfac_id"]}'"
                    . ", resol_oprtier1 = '{$incident["resol_oprtier1"]}'"
                    . ", resol_oprtier2 = '{$incident["resol_oprtier2"]}'"
                    . ", resol_oprtier3 = '{$incident["resol_oprtier3"]}'"
                    . ", resol_prdtier1 = '{$incident["resol_prdtier1"]}'"
                    . ", resol_prdtier2 = '{$incident["resol_prdtier2"]}'"
                    . ", resol_prdtier3 = '{$incident["resol_prdtier3"]}'"
                    . ", status_id = '{$incident["status_id"]}'"
                    . ", status_res_id = '{$incident["status_res_id"]}'"
                    . ", km_entrant = '{$incident["km_entrant"]}'"
                    . ", inc_km_keyword = '{$incident["km_keyword"]}'"
                    .$set_resolved_by.$set_resolved_days.$set_resolved_holiday.$set_resolved_pending.$set_resolved_date
                ;

                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                if (!$result) return false;


                //////////////////////copy file&insert attach//////////////////////
                if($incident["getfile_name_resolution"] != ""){

                    $attach_date = date("Y-m-d H:i:s");
                    $attach_user_id = user_session::get_user_id();
                    foreach ($incident["getfile_name_resolution"] as $file){

                        $parth1 = "../../upload/temp_inc_reslove/";
                        $parth2 = "../../incident_km/temp_identify/";
                        $attach_name = explode("|",$file);
                        $attach_ext = explode(".",$attach_name[0]);
                        $random_string = incident::RandomStr_insert_file_km();
                        if(copy($parth2.$attach_name[0],$parth1.$attach_ext[0].$random_string.".".$attach_ext[1])){
                            $conv_location_name = $attach_ext[0].$random_string.".".$attach_ext[1];
                            $table = "helpdesk_tr_attachment";
                            $field = "attach_name,location_name,attach_ext,attach_date,attach_user_id,type_attachment,incident_id";
                            $data = "'{$attach_name[1]}','{$conv_location_name}',
                                                        '{$attach_ext[1]}','{$attach_date}',
                                                        '{$attach_user_id}','3','{$incident["id"]}'";
                            $result = $this->db->insert($table, $field, $data);
                        }
                    }
                }

                ///upload file resolution////
                include "upload_reslove.php";
            }

        }//end if km ref
        #//////////////////////////////////////////////////////////////////////////////////////////////////////////////
        # Add by Uthen.p 19-04-2016 for send e-mail to PTN support team.

                $mail_assignee = incident::searchPtnSupportGroupEmail();
                $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                    . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                    . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                $condition_email= " inc.id ='{$incident["id"]}'";

                $result_email = $this->db->select($field_email, $table_email, $condition_email);
                //print_r($result_email);
                $rows_email= $this->db->num_rows($result_email);
                //print_r($rows_email);
                $fetch_email = $this->db->fetch_array($result_email);
               // print_r($fetch_email);
                //exit;
                include_once "incident_mail.class.php";

        #//////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //return $result;
        return  array("result" => $result, "identrun" => $identrun);
    }


    public function update($incident){
        date_default_timezone_set('Asia/Bangkok');
        $today 			= date("Y-m-d H:i:s");
        $last_modify_by = user_session::get_user_id();
        $user_Email 	= user_session::get_user_Email();
        $user_upfile		= user_session::get_user_id();
	
        # update helpdesk_tr_incident
        $table = "helpdesk_tr_incident";
        $data = "summary = '{$incident["summary"]}'"
            . ", notes = '{$incident["notes"]}'"
            . ", impact_id = '{$incident["impact_id"]}'"
            . ", urgency_id = '{$incident["urgency_id"]}'"
            . ", priority_id = '{$incident["priority_id"]}'"
            . ", reference_no = '{$incident["reference_no"]}'"
            . ", status_res_id = '{$incident["status_res_id"]}'"
            /*
            #Customer Tab
            . ", cus_id = '{$incident["cus_id"]}'"
            . ", cus_firstname = '{$incident["cus_firstname"]}'"
            . ", cus_lastname = '{$incident["cus_lastname"]}'"
            . ", cus_phone = '{$incident["cus_phone"]}'"
            . ", cus_ipaddress = '{$incident["cus_ipaddress"]}'"
            . ", cus_email = '{$incident["cus_email"]}'"
            . ", cus_company = '{$incident["cus_company"]}'"
            . ", cus_organize = '{$incident["cus_organize"]}'"
            . ", cus_area = '{$incident["cus_area"]}'"
            . ", cus_office = '{$incident["cus_office"]}'"
            . ", cus_department = '{$incident["cus_department"]}'"
            . ", cus_site = '{$incident["cus_site"]}'"
            . ", keyuser_name = '{$incident["keyuser_name"]}'"
            #Contact Tab*/

            . ", con_firstname = '{$incident["con_firstname"]}'"
            . ", con_lastname = '{$incident["con_lastname"]}'"
            . ", con_phone = '{$incident["con_phone"]}'"
            . ", con_ipaddr = '{$incident["con_ipaddr"]}'"
            . ", con_email = '{$incident["con_email"]}'"
            . ", con_place = '{$incident["con_place"]}'"

            #Cassification Tab
            /*
            . ", ident_type_id = '{$incident["ident_type_id"]}'"
            . ", project_id = '{$incident["project_id"]}'"
            . ", cas_opr_tier_id1 = '{$incident["cas_opr_tier_id1"]}'"
            . ", cas_opr_tier_id2 = '{$incident["cas_opr_tier_id2"]}'"
            . ", cas_opr_tier_id3 = '{$incident["cas_opr_tier_id3"]}'"
            . ", cas_prd_tier_id1 = '{$incident["cas_prd_tier_id1"]}'"
            . ", cas_prd_tier_id2 = '{$incident["cas_prd_tier_id2"]}'"
            . ", cas_prd_tier_id3 = '{$incident["cas_prd_tier_id3"]}'"
            */
            #DateTime Tab
            . ", last_modify_date = '{$today}'"
            . ", last_modify_by = '{$last_modify_by}'"
        ;
		
        $condition 	= "id = '{$incident["id"]}'";
        $result 	= $this->db->update($table, $data, $condition);
        if (!$result) return false;
				
        #if ตรวจสอบว่าค่า statusid != ""
        if($incident["status_id"]){	//if ตรวจสอบว่าค่า statusid != ""
						
            ///////กรณีที่มี history working แล้วไม่สามารถเปลี่ยน cassification ได้
            $field_work = "incident_id";
            $table_work = " helpdesk_tr_workinfo";
            $condition_work = " incident_id ='{$incident["id"]}'";
            $result_work = $this->db->select($field_work, $table_work, $condition_work);
            $rows_work = $this->db->num_rows($result_work);
			
            if($rows_work < 1){
                include "upload_cass.php";
                $table_in = "helpdesk_tr_incident";
                $data_in = "ident_type_id = '{$incident["ident_type_id"]}'"
                    . ", project_id = '{$incident["project_id"]}'"
                    . ", cas_opr_tier_id1 = '{$incident["cas_opr_tier_id1"]}'"
                    . ", cas_opr_tier_id2 = '{$incident["cas_opr_tier_id2"]}'"
                    . ", cas_opr_tier_id3 = '{$incident["cas_opr_tier_id3"]}'"
                    . ", cas_prd_tier_id1 = '{$incident["cas_prd_tier_id1"]}'"
                    . ", cas_prd_tier_id2 = '{$incident["cas_prd_tier_id2"]}'"
                    . ", cas_prd_tier_id3 = '{$incident["cas_prd_tier_id3"]}'";
                $condition_in = "id = '{$incident["id"]}'";
                $result_in = $this->db->update($table_in, $data_in, $condition_in);
                if (!$result_in) return false;

            }

            # Assignment
            if($incident["status_id"] == 2 && $incident["assign_comp_id"] != "" && $incident["assign_org_id"] != "" && $incident["assign_group_id"] != "" && $incident["assign_subgrp_id"] != ""){
                date_default_timezone_set('Asia/Bangkok');

                //echo '<script type="text/javascript">
                //    alert("incident.class.php line:702->Assign event: ");
                //</script>';
                $today = date("Y-m-d H:i:s");
                #Insert Assigned
                $table = "helpdesk_tr_assignment";
                $field = "incident_id, assign_status_id, assign_status_res_id, assign_comp_id
							,assign_org_id,assign_group_id,assign_subgrp_id,assign_assignee_id,entry_date";
                $data = "'{$incident["id"]}', '{$incident["status_id"]}'
							, '{$incident["status_res_id"]}', '{$incident["assign_comp_id"]}'
							, '{$incident["assign_org_id"]}', '{$incident["assign_group_id"]}'
							, '{$incident["assign_subgrp_id"]}', '{$incident["assign_assignee_id"]}'
							, '{$today}'
							";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;

                #Update Assigned Date to tr_incident
                $incident["assigned_date"]; //exit;
                if($incident["assigned_date"] == "0000-00-00 00:00:00"){
                    $set_assigned_date = ", assigned_date = '{$today}'";  //exit;
                }else{	$set_assigned_date = "";	}

                $table = "helpdesk_tr_incident";
                $data = "assignee_id_last = '{$incident["assign_assignee_id"]}'"
                    . ", assign_comp_id_last = '{$incident["assign_comp_id"]}'"
                    . ", assign_org_id_last = '{$incident["assign_org_id"]}'"
                    . ", assign_grp_id_last = '{$incident["assign_group_id"]}'"
                    . ", assign_subgrp_id_last = '{$incident["assign_subgrp_id"]}'"
                    . ", status_id = '{$incident["status_id"]}'"
                    . ", assigned_date_last = '{$today}'".$set_assigned_date;
                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                if (!$result) return false;
                #//////////////////////////////////////////////////////////////////////////////////////////////////
                #Uthen.p my_assign
                $mail_assignee = incident::mail_getmailassignee($incident["assign_assignee_id"],$incident["assign_subgrp_id"]);

                $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                    . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                    . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                $condition_email= " inc.id ='{$incident["id"]}'";

                $result_email = $this->db->select($field_email, $table_email, $condition_email);
                $rows_email= $this->db->num_rows($result_email);
                $fetch_email = $this->db->fetch_array($result_email);

                include "incident_mail.class.php";
                #//////////////////////////////////////////////////////////////////////////////////////////////////

                $mail_assignee = incident::getCustomerEmail($incident["id"],"assigned","Assigned");
                $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                    . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                    . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                $condition_email= " inc.id ='{$incident["id"]}'";

                $result_email = $this->db->select($field_email, $table_email, $condition_email);
                $rows_email= $this->db->num_rows($result_email);
                $fetch_email = $this->db->fetch_array($result_email);
                include "incident_mail.class.php";
                #//////////////////////////////////////////////////////////////////////////////////////////////////

                #Send mail ส่งเฉพาะกรณีที่ assign ให้คนอื่น
                $last_user_id = user_session::get_user_id();

                //if($incident["id"] && $incident["assign_assignee_id"] != $last_user_id){
                if( ($incident["id"] && $incident["assign_assignee_id"] != $last_user_id)
                    && (($incident["assign_comp_id"] != $incident["ss_assign_comp_id"])
                        || ($incident["assign_org_id"] != $incident["ss_assign_org_id"])
                        || ($incident["assign_group_id"] != $incident["ss_assign_group_id"])
                        || ($incident["assign_subgrp_id"] != $incident["ss_assign_subgrp_id"]) || ($incident["id"] && $incident["assign_assignee_id"] != $incident["ss_assign_assignee_id"]))  ){
                    #Get Config Incident Running Number
                    $id = incident_getrunning($incident["id"],$incident["ident_id"]);
                    #Get email alert my_assigned
                    /*
                    $mail_assignee = incident::mail_getmailassignee($incident["assign_assignee_id"],$incident["assign_subgrp_id"]);

                    $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                    $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                        . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                        . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                    $condition_email= " inc.id ='{$incident["id"]}'";

                    $result_email = $this->db->select($field_email, $table_email, $condition_email);
                    $rows_email= $this->db->num_rows($result_email);
                    $fetch_email = $this->db->fetch_array($result_email);

                    include "incident_mail.class.php";
                    #//////////////////////////////////////////////////////////////////////////////////////////////////

                    $mail_assignee = incident::getCustomerEmail($incident["id"],"assigned","Assigned");
                    $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                    $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                        . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                        . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                    $condition_email= " inc.id ='{$incident["id"]}'";

                    $result_email = $this->db->select($field_email, $table_email, $condition_email);
                    $rows_email= $this->db->num_rows($result_email);
                    $fetch_email = $this->db->fetch_array($result_email);
                    include "incident_mail.class.php";
                    #//////////////////////////////////////////////////////////////////////////////////////////////////
                    */
                }

            }


            # Workinfo
            elseif($incident["status_id"] == 3 && $incident["workinfo_summary"] != ""){
                //echo '<script type="text/javascript">
                //   alert("incident.class.php line:767->update my_working status");
                //</script>';
                #Count Attach Files/Work Info
                // $counst = count($incident["uploadfile_working"]["name"])-1;
                if((count($incident["uploadfile_working"]["name"])-1) > 0){
                    $cnt_attachs 	= 1;
                }else{
                    $cnt_attachs 	= 0;
                }
//					$Array_attachs 		= array();
//					$Array_attach 		= $incident["working_Array_attach"][0]; 
//					$Array_attachs 		= explode(",", $Array_attach);
//					if(sizeof($Array_attachs) > 0 && $Array_attachs[0]){  //ต้องมีเอกสารแนบมากกว่า 1
//						$cnt_attachs 	= 1; 
//						$Array_attachs 	= array();
//					}else{ 
//						$cnt_attachs 	= 0;  
//						//$Array_attachs = array();
//					}
                //exit;
                #Insert workinfo
                $last_user_id 		= user_session::get_user_id();
                $table 	= "helpdesk_tr_workinfo";
                $field 	= "incident_id, workinfo_status_id, workinfo_status_res_id
							,workinfo_type_id,workinfo_summary,workinfo_notes,workinfo_user_id,workinfo_date,workinfo_attach";
                $data 	= "'{$incident["id"]}', '{$incident["status_id"]}'
							, '{$incident["status_res_id"]}'
							, '{$incident["workinfo_type_id"]}', '{$incident["workinfo_summary"]}'
							, '{$incident["workinfo_notes"]}', '{$last_user_id}'
							, '{$today}', '{$cnt_attachs}'
							";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;
                //exit();

                #Updete Attach Files/Work Info

                $last_workid 	= $this->db->insert_id();
                include "upload_workinfo.php";
//					$Array_attachs 	= array();
//					$Array_attach 	= $incident["working_Array_attach"][0]; 
//					$Array_attachs 	= explode(",", $Array_attach);
//					if(sizeof($Array_attachs) > 0 && $Array_attachs[0]){
//						for($i=0; $i<sizeof($Array_attachs); $i++){
//							$f_name = $Array_attachs[$i];
//							
//							$table 		= "helpdesk_tr_attachment";
//							$data 		= "workinfo_id = '{$last_workid}'";
//                            $condition  = "incident_id = '{$incident["id"]}'  AND type_attachment = '2' AND workinfo_id = '0' AND attach_user_id = '$user_upfile'";							
//							$result = $this->db->update($table, $data, $condition);
//							if (!$result) return false;
//						}
//					}
                //exit;

                #Update working_date Date to tr_incident
                #check responded_days
                if($incident["working_date"] == "0000-00-00 00:00:00"){
                    $time = sla::cal_sla_days($incident["assigned_date"], $today, $incident["cus_company_id"]);
//						$time = dateUtil::date_diff3($incident["assigned_date"], $today);
                    $set_responded_by = ", responded_by = '{$last_modify_by}'
                                                                    , responded_by_grp_id = '{$incident["assign_group_id"]}'
                                                                    , responded_by_subgrp_id = '{$incident["assign_subgrp_id"]}' ";
                    $set_responded_days = ", responded_days = '{$time["sla_days"]}'";
                    $set_responded_holiday = ", responded_holiday = '{$time["holiday"]}'";
                    $set_working_date = ", working_date = '{$today}'"; 	}
                else{	$set_responded_by = ""; $set_responded_days = ""; $set_responded_holiday=""; 	}

                $table = "helpdesk_tr_incident";
                $data = "status_id = '{$incident["status_id"]}'"
                    .$set_responded_by.$set_responded_days.$set_responded_holiday.$set_working_date;
                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                #/// Add by Uthen 26-04-2016
                #//////////////////////////////////////////////////////////////////////////////////////////////////

                $mail_assignee = incident::getCustomerEmail($incident["id"],"working","Working");
                $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                    . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                    . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                $condition_email= " inc.id ='{$incident["id"]}'";

                $result_email = $this->db->select($field_email, $table_email, $condition_email);
                $rows_email= $this->db->num_rows($result_email);
                $fetch_email = $this->db->fetch_array($result_email);
                include "incident_mail.class.php";
                #//////////////////////////////////////////////////////////////////////////////////////////////////


                if (!$result) return false;
            }

            # Pending
            elseif($incident["status_id"] == 4 && $incident["status_res_id"] != "" && $incident["workinfo_summary"] != ""){

                //echo '<script type="text/javascript">
                //   alert("incident.class.php line:847->update my_pending status");
                //</script>';

                #Count Attach Files/Pending
//					$Array_attachs 		= array();
//					$Array_attach 		= $incident["working_Array_attach"][0]; 
//					$Array_attachs 		= explode(",", $Array_attach);
                if((count($incident["uploadfile_working"]["name"])-1) > 0){
                    //if(sizeof($Array_attachs) > 0 && $Array_attachs[0]){  //ต้องมีเอกสารแนบมากกว่า 1
                    $cnt_attachs 	= 1;
                    //$Array_attachs 	= array();
                }else{
                    $cnt_attachs 	= 0;
                    //$Array_attachs = array();
                }

                #Insert workinfo
                $last_user_id = user_session::get_user_id();
                $table = "helpdesk_tr_workinfo";
                $field = "incident_id, workinfo_status_id, workinfo_status_res_id
							,workinfo_type_id,workinfo_summary,workinfo_notes,workinfo_user_id,workinfo_date,workinfo_attach";
                $data = "'{$incident["id"]}', '{$incident["status_id"]}'
							, '{$incident["status_res_id"]}'
							, '{$incident["workinfo_type_id"]}', '{$incident["workinfo_summary"]}'
							, '{$incident["workinfo_notes"]}', '{$last_user_id}'
							, '{$today}', '{$cnt_attachs}'
							";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;
                //exit();

                #Updete Attach Files/Pending
                $last_workid 	= $this->db->insert_id();
                include "upload_workinfo.php";
//					$Array_attachs 	= array();
//					$Array_attach 	= $incident["working_Array_attach"][0]; 
//					$Array_attachs 	= explode(",", $Array_attach);
//					if(sizeof($Array_attachs) > 0 && $Array_attachs[0]){
//						for($i=0; $i<sizeof($Array_attachs); $i++){
//							$f_name = $Array_attachs[$i];
//							
//							$table 		= "helpdesk_tr_attachment";
//							$data 		= "workinfo_id = '{$last_workid}'";
//							$condition  = "incident_id = '{$incident["id"]}' AND type_attachment = '2' AND workinfo_id = '0' AND attach_user_id = '$user_upfile'";	
//							$result = $this->db->update($table, $data, $condition);
//							if (!$result) return false;
//						}
//					}

                #Update working_date Date to tr_incident
                #check responded_days
                if($incident["working_date"] == "0000-00-00 00:00:00"){
                    $time = dateUtil::date_diff3($incident["assigned_date"], $today);
                    $set_responded_days = ", responded_days = '{$time}'";
                    $set_working_date = ", working_date = '{$today}'"; 	}
                else{	$set_responded_days = "";	}
                $table = "helpdesk_tr_incident";
                $data = "status_id = '{$incident["status_id"]}'"
                    . ", status_res_id = '{$incident["status_res_id"]}'".$set_responded_days.$set_working_date;
                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                #//////////////////////////////////////////////////////////////////////////////////////////////////

                $mail_assignee = incident::getCustomerEmail($incident["id"],"pending","Pending");
                $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                    . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                    . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                $condition_email= " inc.id ='{$incident["id"]}'";

                $result_email = $this->db->select($field_email, $table_email, $condition_email);
                $rows_email= $this->db->num_rows($result_email);
                $fetch_email = $this->db->fetch_array($result_email);
                include "incident_mail.class.php";
                #//////////////////////////////////////////////////////////////////////////////////////////////////
                if (!$result) return false;
            }

            # Resolv
            elseif($incident["status_id"] == 5 && $incident["resolution"] != "" && $incident["status_res_id"] != ""
                && $incident["resol_oprtier1"] != "" && $incident["resol_oprtier2"] != "" && $incident["resol_prdtier1"] != "" && $incident["resol_prdtier2"] != ""){
                //echo '<script type="text/javascript">

                //alert("incident.class.php line:847->update my_resolved status");
                //</script>';
                #check resolved_days
                //if($incident["resolved_date"] == "0000-00-00 00:00:00"){
                //$time = dateUtil::date_diff3($incident["working_date"], $today);

		        // Calculate Actual (20230118)
                $field = " * ";
                $table = " helpdesk_tr_workinfo ";
                $condition = " incident_id = ".$incident["id"]." ORDER BY workinfo_id  ";
                $w_info = array();

                $result = $this->db->select($field, $table, $condition);
                $rows = $this->db->num_rows($result);
                if ($rows > 0){
                    while($row = $this->db->fetch_array($result)){
                        $w_info[] = $row;
                    }
                }
        
                $objCalActual = new workinfo_period($this->db);
                $actual_time =  $objCalActual->actual_working_hour($incident,$w_info,$incident["assigned_date"],$today); 
                // $objCalActual->split_workinfo_to_workdate($incident);

                $time = sla::cal_sla_days($incident["working_date"], $today, $incident["cus_company_id"],"Y",$incident["id"]);
                $set_resolved_by = ", resolved_by = '{$last_modify_by}'
                                                                    , resolved_by_grp_id = '{$incident["assign_group_id"]}'
                                                                    , resolved_by_subgrp_id = '{$incident["assign_subgrp_id"]}' ";
                $set_resolved_days = ", resolved_days = '{$time["sla_days"]}'";
                $set_resolved_holiday = ", resolved_holiday = '{$time["holiday"]}'";
                $set_resolved_pending = ", resolved_pending = '{$time["pending"]}'";
                $set_resolved_date = ", resolved_date = '{$today}'";	//}
                //else{
//              $set_resolved_by = "";
//              $set_resolved_days = "";
//              $set_resolved_holiday = "";
//              $set_resolved_pending = ""; 
//                                                }

                // Actual (20230118)
                $set_actual_working_sec = ", tot_actual_working_sec = '{$actual_time["tot_actual_working_sec"]}'";
                $set_actual_pending_sec = ", tot_actual_pending_sec = '{$actual_time["tot_actual_pending_sec"]}'";

                $set_tot_pending_res_wait_info = ", tot_pending_res_wait_info = '{$actual_time["tot_pending_res_wait_info"]}'";
                $set_tot_pending_res_wait_sap = ", tot_pending_res_wait_sap = '{$actual_time["tot_pending_res_wait_sap"]}'";
                $set_tot_pending_res_wait_dev = ", tot_pending_res_wait_dev = '{$actual_time["tot_pending_res_wait_dev"]}'";
                $set_tot_pending_res_wait_test = ", tot_pending_res_wait_test = '{$actual_time["tot_pending_res_wait_test"]}'";

                $message = "wrong answer + value : ".$set_tot_pending_res_wait_test;
                echo "<script type='text/javascript'>alert('$message');</script>";

                
                #Update Resolv
                if($incident["km_release"]==""){
                    $update_km_entrant = ", km_entrant = '{$incident["km_entrant"]}', inc_km_keyword = '{$incident["km_keyword"]}'";
                }
                $resolution_user_id = user_session::get_user_id();
                $table = "helpdesk_tr_incident";
                $data = "resolution = '{$incident["resolution"]}'"
                    . ", resolution_user_id = '{$resolution_user_id}'"
                    . ", satisfac_id = '{$incident["satisfac_id"]}'"
                    . ", resol_oprtier1 = '{$incident["resol_oprtier1"]}'"
                    . ", resol_oprtier2 = '{$incident["resol_oprtier2"]}'"
                    . ", resol_oprtier3 = '{$incident["resol_oprtier3"]}'"
                    . ", resol_prdtier1 = '{$incident["resol_prdtier1"]}'"
                    . ", resol_prdtier2 = '{$incident["resol_prdtier2"]}'"
                    . ", resol_prdtier3 = '{$incident["resol_prdtier3"]}'"
                    . ", status_id = '{$incident["status_id"]}'"
                    . ", status_res_id = '{$incident["status_res_id"]}'"
                    . $update_km_entrant.$set_resolved_by.$set_resolved_days.$set_resolved_holiday
                    .$set_resolved_pending.$set_resolved_date.$set_actual_working_sec.$set_actual_pending_sec
                    .$set_tot_pending_res_wait_info.$set_tot_pending_res_wait_sap.$set_tot_pending_res_wait_dev
                    .$set_tot_pending_res_wait_test
                ;

            

                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                if (!$result) return false;

                ///upload file resolution////
                #//////////////////////////////////////////////////////////////////////////////////////////////////

                $mail_assignee = incident::getCustomerEmail($incident["id"],"resolved","Resolved");
                $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                    . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                    . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                $condition_email= " inc.id ='{$incident["id"]}'";

                $result_email = $this->db->select($field_email, $table_email, $condition_email);
                $rows_email= $this->db->num_rows($result_email);
                $fetch_email = $this->db->fetch_array($result_email);
                include "incident_mail.class.php";
                #//////////////////////////////////////////////////////////////////////////////////////////////////
                include "upload_reslove.php";
            }


            # Porpose Close
            elseif($incident["status_id"] == 6 && $incident["status_res_id"] != ""){
                //echo '<script type="text/javascript">

                //    alert("incident.class.php line:971->update my_purpose_closed status");
                //</script>';
                /*
                $table = "helpdesk_tr_incident";
                $data = "propose_closed_date = '{$today}'"
                    . ", status_id = '{$incident["status_id"]}'"
                    . ", status_res_id = '{$incident["status_res_id"]}'"
                    ;

                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                if (!$result) return false;
                */
                date_default_timezone_set('Asia/Bangkok');
                $today = date("Y-m-d H:i:s");
                #Insert Assigned
                $table = "helpdesk_tr_assignment";
                $field = "incident_id, assign_status_id, assign_status_res_id, assign_comp_id
							,assign_org_id,assign_group_id,assign_subgrp_id,assign_assignee_id,entry_date";
                $data = "'{$incident["id"]}', '{$incident["status_id"]}'
							, '{$incident["status_res_id"]}', '{$incident["owner_comp_id"]}'
							, '{$incident["owner_org_id"]}', '{$incident["owner_grp_id"]}'
							, '{$incident["owner_subgrp_id"]}', '{$incident["owner_user_id"]}'
							, '{$today}'
							";
                $result = $this->db->insert($table, $field, $data);
                if(!$result) return false;

                /*if($incident["propose_closed_date"] == "0000-00-00 00:00:00"){
                    $set_propose_closed_date = ", propose_closed_date = '{$today}'";	}*/

                $table = "helpdesk_tr_incident";
                $data = "assignee_id_last = '{$incident["owner_user_id"]}'"
                    . ", assign_comp_id_last = '{$incident["owner_comp_id"]}'"
                    . ", assign_org_id_last = '{$incident["owner_org_id"]}'"
                    . ", assign_grp_id_last = '{$incident["owner_grp_id"]}'"
                    . ", assign_subgrp_id_last = '{$incident["owner_subgrp_id"]}'"
                    . ", assigned_date_last = '{$today}'"
                    . ", propose_closed_date = '{$today}'"
                    . ", status_id = '{$incident["status_id"]}'"
                    . ", status_res_id = '{$incident["status_res_id"]}'";

                $condition = "id = '{$incident["id"]}'";

                $result = $this->db->update($table, $data, $condition);
                if (!$result) return false;

                #Send mail Evaluation กรณีปิด incedent
                //if($incident["id"] && $incident["owner_user_email"]){
                if($incident["id"]){

                    #Get Config Incident Running Number
                    //$id = incident_getrunning($incident["id"],$incident["ident_id"]);
                    $id = incident_getrunning($incident["id"],$incident["ident_id_run_project_id"]);

                    #Get email alert
                    $mail_assignee = incident::mail_getmailassignee($incident["owner_user_id"],$incident["owner_subgrp_id"]);

                    $field_email = "inc.id,inc.cus_id,inc.cus_office,inc.cus_phone,inc.ident_id_run_project,p.priority_desc,r.status_res_desc,s.status_desc";
                    $table_email = " helpdesk_tr_incident inc left join helpdesk_priority p on(inc.priority_id=p.priority_id)"
                        . " left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id) "
                        . " left join helpdesk_status s on(inc.status_id=s.status_id)";
                    $condition_email= " inc.id ='{$incident["id"]}'";

                    $result_email = $this->db->select($field_email, $table_email, $condition_email);
                    $rows_email= $this->db->num_rows($result_email);
                    $fetch_email = $this->db->fetch_array($result_email);

                    include_once "incident_mail_propose.class.php";
                }

            }

            # Close
            elseif($incident["status_id"] == 7 && $incident["status_res_id"] != ""){
                $User_id = user_session::get_user_id();
                if($User_id == $incident["assign_assignee_id"]){  //คนที่จะ Closed ได้ต้องมี AssigneeID ตรงกับ UserLogin เท่านั้น
                    #check incident_age
                    if($incident["closed_date"] == "0000-00-00 00:00:00"){
                        $time = dateUtil::date_diff3($incident["create_date"], $today);
                        $set_incident_age = ", incident_age = '{$time}'";
                        //$set_closed_date = ", closed_date = '{$today}'";
                    }
                    else{	$set_incident_age = "";	}

                    $table = "helpdesk_tr_incident";
                    $data = "closed_date = '{$today}'"
                        . ", status_id = '{$incident["status_id"]}'"
                        . ", status_res_id = '{$incident["status_res_id"]}'".$set_incident_age
                        //. ", satisfac_id = '5'".$set_incident_age
                    ;

                    $condition = "id = '{$incident["id"]}'";

                    $result = $this->db->update($table, $data, $condition);
                    //echo '<script type="text/javascript">

                    //    alert("incident.class.php line:1069->update my_purpose_closed status");
                    //</script>';
                    if (!$result) return false;
                }
                #Send mail Evaluation กรณีปิด incedent
                //if($incident["id"] && $incident["owner_user_email"]){
                /*
                if($incident["id"]){
                   include_once "incident_mail_evaluation.class.php";
                }
                */
            }
            #Update Contact to Detail Customer
            if($incident["con_phone"]!=""){
                $table = "helpdesk_customer";
                $data = "phone_cus = '{$incident["con_phone"]}'";
                $condition = "code_cus = '{$incident["cus_id"]}'";
                $result_in = $this->db->update($table, $data, $condition);

                $table = "helpdesk_tr_incident";
                $data = "cus_phone = '{$incident["con_phone"]}'";
                $condition = "id = '{$incident["id"]}'";
                $result_in_cus = $this->db->update($table, $data, $condition);

                if (!$result) return false;

            }
            if($incident["con_ipaddr"]!=""){
                $table = "helpdesk_customer";
                $data = "ipaddress_cus = '{$incident["con_ipaddr"]}'";
                $condition = "code_cus = '{$incident["cus_id"]}'";
                $result_in = $this->db->update($table, $data, $condition);

                $table = "helpdesk_tr_incident";
                $data = "cus_ipaddress = '{$incident["con_ipaddr"]}'";
                $condition = "id = '{$incident["id"]}'";
                $result_in_cus = $this->db->update($table, $data, $condition);

                if (!$result) return false;
            }
            if($incident["con_email"]!=""){
                $table = "helpdesk_customer";
                $data = "email_cus = '{$incident["con_email"]}'";
                $condition = "code_cus = '{$incident["cus_id"]}'";
                $result_in = $this->db->update($table, $data, $condition);

                $table = "helpdesk_tr_incident";
                $data = "cus_email = '{$incident["con_email"]}'";
                $condition = "id = '{$incident["id"]}'";
                $result_in_cus = $this->db->update($table, $data, $condition);

                if (!$result) return false;

            }
			
            //return $result;
            return  array("result" => $result);
        }
		
		//echo '<script type="text/javascript">
        //    alert("XXXXXX");
        //  </script>';
		
    }// end if ตรวจสอบว่าค่า statusid != ""

    public function getIdentRunningByProject($project_id){
        global $asm,$wif;
        # Incident Header
        $field = "ident_id_run_project,project_code";
        $table = " helpdesk_project";
        $condition = " project_id = $project_id";
        
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();

        $IdentRunningByProjectID = $this->db->fetch_array($result);
        $incRunID = $IdentRunningByProjectID["ident_id_run_project"]+1;
        #Update field ident_id_run_project
        if($incRunID){
            $table = "helpdesk_project";
            $data = "ident_id_run_project = '{$incRunID}'"; //exit;
            $condition = " project_id = $project_id";

            $result = $this->db->update($table, $data, $condition);
            if (!$result) return false;
        }

        return $IdentRunningByProjectID;
    }
    /*
    public function GetConfig() {
        global $IncidentRun,$IncidentRunProject,$IncidentRunDigit,$IncidentPrefix;
        #ดึงค่าตัวแปรมา่จาก Config.inc.php
        $IncidentRun = array(
        "IncidentRunProject" => $IncidentRunProject
        , "IncidentRunDigit" => $IncidentRunDigit
        , "IncidentPrefix" => $IncidentPrefix
        );
        return $IncidentRun;

    }
    */

    public function mail_getmailassignee($assign_assignee_id,$assign_subgrp_id){
        #กรณี Assignee
        if($assign_assignee_id != "" && $assign_subgrp_id != ""){
            $field = "CONCAT('คุณ',first_name,' ',last_name) as mail_assignee_arr1,email as mail_assignee_arr2";
            $table = " helpdesk_user";
            $condition = " user_id = $assign_assignee_id";

            #กรณี Assignee Team
        }else{
            //$field = "CONCAT('ทีม',' ',o.org_name) as mail_assignee_arr1,u.email as mail_assignee_arr2";
            $field = "u.email as mail_assignee_arr2";
            $table = " helpdesk_org o"
                . " INNER JOIN helpdesk_user u ON (o.org_id = u.org_id)
                                            LEFT JOIN helpdesk_tr_user_specorg uo ON (u.user_id = uo.user_id)";
            $condition = " u.org_id = '$assign_subgrp_id' or uo.org_id = '$assign_subgrp_id'";
        }

        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();
        //print_r($arr_mail_assignee); //exit;
        //$arr_mail_assignee = $this->db->fetch_array($result);

        if ($rows > 0){
            #ส่งอีเมล์เป็นรายบุคคล
            if($assign_assignee_id != "" && $assign_subgrp_id != ""){
                $arr_mail_assignee = $this->db->fetch_array($result);
                $mail_assignee2 = $arr_mail_assignee["mail_assignee_arr1"];
                $mail_assignee = $arr_mail_assignee["mail_assignee_arr2"];
                $mail_subject_person = "you";

            }
            #ส่งอีเมล์เป็นทีม
            else{
                $arr_mail_assignee = $this->db->fetch_array($result);
                if($arr_mail_assignee["mail_assignee_arr2"] != '-'){
                    $mail_assignee1 = $arr_mail_assignee["mail_assignee_arr2"];
                }
                $mail_assignee = $mail_assignee1;
                while($row = $this->db->fetch_array($result)){
                    if($row["mail_assignee_arr2"] != '-'){
                        $mail_assignee .= ",".$row["mail_assignee_arr2"];
                    }
                }
                //$mail_assignee = substr($mail_assignee,1,strlen($mail_assignee));
                $mail_subject_person = "Your Subgroup";
                $sql_name_subgroup = "select org_name from helpdesk_org where org_id = '$assign_subgrp_id'";
                $result_sql = $this->db->query($sql_name_subgroup);
                $fetch_sql = $this->db->fetch_array($result_sql);
                $mail_assignee2 = 'ทีม '.$fetch_sql["org_name"];

            }
        }

        $mail_assignee_arr = array(
            "mail_assignee_arr1" => $mail_assignee2
            , "mail_assignee_arr2" => $mail_assignee
            , "mail_assignee_arr3" => $mail_subject_person
            , "mail_assignee_arr4" => "assigned."
            , "mail_assignee_arr5" => "Assigned"
        );

        return $mail_assignee_arr;

    }
    //////////////km ref//////////////////////////
    public function getByKmID($km_id){
        global $s_km;
        $field = "km.km_id as s_km_id, km.detail as notes, km.incident_type_id as ident_type_id, km.project_id_km as project_id, km.summary_km as summary, km.cus_comp_id as cus_company_id ,
                    km.opr_tier_id1 as cas_opr_tier_id1,km.opr_tier_id2 as cas_opr_tier_id2, km.opr_tier_id3 as cas_opr_tier_id3,
                    km.prd_tier_id1 as cas_prd_tier_id1, km.prd_tier_id2 as cas_prd_tier_id2, km.prd_tier_id3 as cas_prd_tier_id3,
                    km.opr_tier_id1 as resol_oprtier1, km.opr_tier_id2 as resol_oprtier2, km.opr_tier_id3 as resol_oprtier3,
                    km.prd_tier_id1 as resol_prdtier1, km.prd_tier_id2 as resol_prdtier2, km.prd_tier_id3 as resol_prdtier3,
                    km.resolution_km as resolution";
        $table = "helpdesk_km_incident km"
        ;
        $condition = " km_id = $km_id";

        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();

        $s_km = $this->db->fetch_array($result);
        $s_km["status_id"] = 5;

        #Get Attach Files identify
        $table = " helpdesk_tr_attachment a inner join helpdesk_user u on(a.attach_user_id = u.user_id)";
        $field = " attach_name,first_name,last_name,attach_date,location_name,attach_id,km_id";
        $condition = " km_id = $km_id AND type_attachment = 4"
            . " ORDER BY attach_date";
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);
        if ($rows > 0){
            while($row = $this->db->fetch_array($result)){
                $s_km["file_resolution"][] = $row;
            }
        }
        return $s_km;

    }

    public function RandomStr_insert_file_km($length = 4) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    #//////////////////Status change log by Uthen.P 08-April-2016//////////////////////////
    public function insertStatusChangeLog(&$statusPriorityArray){
        date_default_timezone_set('Asia/Bangkok');
        $today = date("Y-m-d H:i:s");
        $owner_comp_id 		= user_session::get_user_company_id();
        $owner_org_id 		= user_session::get_user_org_id();

        $owner_grp_id 		= user_session::get_user_grp_id();
        $owner_subgrp_id 	= user_session::get_user_subgrp_id();

        $owner_user_id 		= user_session::get_user_id();
        $last_modify_by 	= user_session::get_user_id();

        # insert helpdesk_status_change_log
        $table = "helpdesk_status_change_log";
        $field = "incident_id
			 ,status_before
			 ,status_after
			 ,status_change
			 ,priority_before
			 ,priority_after
			 ,priority_change
			 ,changed_by
			 ,created_date
			 ,modified_by
			 ,modified_date
			 ,active";
        $data = "'{$statusPriorityArray["incident_id"]}'
			 ,'{$statusPriorityArray["statusBefore"]}'
			 ,'{$statusPriorityArray["statusAfter"]}'
			 ,'{$statusPriorityArray["statusChange"]}'
			 ,'{$statusPriorityArray["priorityBefore"]}'
			 ,'{$statusPriorityArray["priorityAfter"]}'
			 ,'{$statusPriorityArray["priorityChange"]}'
			 ,'{$owner_user_id}'
			 ,'{$today}'
			 ,'{$owner_user_id}'
			 ,'{$today}'
			 ,'1'";
        // echo $data;
        $resultStatus = $this->db->insert($table, $field, $data);
        /*
        if(!$statusResult)
        {
            return $statusResult = getStatusChangeLog($statusPriorityArray["incident_id"]);
        }
        else
        {
            return false;
        }
        */
    }

    public function getStatusChangeLog($incident_id)
    {
        $field = "log_id";
        $table = "helpdesk_status_change_log";
        $condition = " incident_id = $incident_id limit 1 ";
        $order = " created_date desc";

        $result = $this->db->select($field, $table, $condition,$order);
        $rows = $this->db->num_rows($result);

        return $result["log_id"];
    }

    public function getCustomerEmail($incidentId,$eventStatus,$reasonStatus)
    {
        //echo '<script type="text/javascript">
        //                var cusIdx = "'.$incidentId.'";
        //                alert("incident.class.php Line:1359->getCustomerEmail: "+cusIdx);
        //</script>';
        if($incidentId != "")
        {
            $field = "cus_id";
            $table = " helpdesk_tr_incident";
            $condition = " id = '$incidentId'";
            $resultCusId = $this->db->select($field, $table, $condition);
            $rowsId = $this->db->num_rows($resultCusId);
            $customers = $this->db->fetch_array($resultCusId);
            $customerId = $customers["cus_id"];
        }
        //echo '<script type="text/javascript">
        //                var cusId = "'.$customerId.'";
        //                alert("incident.class.php Line:1359->customer Id: "+cusId);
        //</script>';
        if($customerId != ""){
            $field = "CONCAT('คุณ ',firstname_cus,' ',lastname_cus) as mail_assignee_arr1,email_cus as mail_assignee_arr2";
            $table = " helpdesk_customer";
            $condition = " code_cus = '{$customerId}'";
        }

        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();

        if ($rows > 0){
            #ส่งอีเมล์เป็นรายบุคคล
            if($customerId != "" ){
                $arr_mail_assignee = $this->db->fetch_array($result);
                $mail_assignee2 = $arr_mail_assignee["mail_assignee_arr1"];
                $mail_assignee = $arr_mail_assignee["mail_assignee_arr2"];
                $mail_subject_person = "you";

            }
        }

        $mail_assignee_arr = array(
            "mail_assignee_arr1" => $mail_assignee2
        , "mail_assignee_arr2" => $mail_assignee
        , "mail_assignee_arr3" => $mail_subject_person
        , "mail_assignee_arr4" => $eventStatus."."
        , "mail_assignee_arr5" => $reasonStatus
        );
        #echo "getCustomer Info";
        #print_r($mail_assignee_arr);
        #exit;
        return $mail_assignee_arr;
    }

    public function searchPtnSupportGroupEmail()
    {
        $field = "email as mail_assignee_arr2";
        $table = " helpdesk_user";
        $condition = " org_id = '38' and user_status = '1'";
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();
        //print_r($arr_mail_assignee); //exit;
        //$arr_mail_assignee = $this->db->fetch_array($result);

        if ($rows > 0)
        {
            $arr_mail_assignee = $this->db->fetch_array($result);
            if($arr_mail_assignee["mail_assignee_arr2"] != '-'){
                $mail_assignee1 = $arr_mail_assignee["mail_assignee_arr2"];
            }
            $mail_assignee = $mail_assignee1;
            while($row = $this->db->fetch_array($result)){
                if($row["mail_assignee_arr2"] != '-'){
                    $mail_assignee .= ",".$row["mail_assignee_arr2"];
                }
            }
            //$mail_assignee = substr($mail_assignee,1,strlen($mail_assignee));
            $mail_subject_person = "";
            $mail_assignee2 = 'ทีม PTN Support';

        }

        $mail_assignee_arr = array(
            "mail_assignee_arr1" => $mail_assignee2
            ,"mail_assignee_arr2" => $mail_assignee
            ,"mail_assignee_arr3" => $mail_subject_person
            ,"mail_assignee_arr4" => "created."
            ,"mail_assignee_arr5" => "Created"
        );

        return $mail_assignee_arr;
    }

    #///////////////////////////////////////////////////////////////////////////////////////


}
?>
