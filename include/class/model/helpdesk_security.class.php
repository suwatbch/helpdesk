<?php
    include_once "model.class.php";
    include_once dirname(dirname(__FILE__))."/encryption.class.php";
    include_once dirname(dirname(__FILE__))."/util/dateUtil.class.php";
    include_once dirname(dirname(__FILE__))."/util/strUtil.class.php";

    class h_security extends model {

        public function h_login($h_employee_code = "", $h_username = "", $h_password = "", $h_comcode= "", $h_pass_expire="", $h_new_pass=""){
            global $application_version;
            
            $ipaddress 		= $_SERVER["REMOTE_ADDR"];
            $computer_name 	= gethostbyaddr($_SERVER["REMOTE_ADDR"]);
            $user_agent 	= $_SERVER["HTTP_USER_AGENT"];
            $current_date 	= dateUtil::current_date_time();
            $sale_id = "NULL";
            $user_id = "NULL";
			
            # check browse
            if ($this->isBrowserAllow($user_agent) == false){
                $error_type = "B";
            } else {
                # login
                /*$sql = " SELECT sale_id, employee_code, sale_first_name, sale_last_name, user_login, pass, sale_group_id, sale_status"
                         . " FROM tb_sale"
                         . " WHERE 1 = 1";*/
						 
                $sql = " SELECT user_id,user_code, employee_code, first_name, last_name, email, user_login, pass, u.org_id, user_status,sale_group_id,u.company_id
						,company_name,org_code,admin,transfer_incident_permission,admin_permission, edit_report_permission, approve_report_permission,cus_company_id,advance_search_permission
						,LEFT(org_code,2) as my_orgcode
						,LEFT(org_code,4) as my_grpcode"
                         . " FROM helpdesk_user u"
						 . " LEFT JOIN helpdesk_company c ON u.company_id = c.company_id"
						 . " LEFT JOIN helpdesk_org o ON u.org_id = o.org_id"
                         . " WHERE user_status = 1";
				//exit;
                if (strUtil::isNotEmpty($h_employee_code)) {
                    $sql .= " AND employee_code = '$h_employee_code'";
                }

                if (strUtil::isNotEmpty($h_username)) {
                    $sql .= " AND lower(user_login) = '$h_username'";
                }

				//Comment By Seksan 20/06/2559
                /*if (strUtil::isNotEmpty($h_comcode)) {
                    $sql .= " AND u.company_id = '$h_comcode'";
                }*/
				
                //echo $sql; //exit;
                $result = $this->db->query($sql);
                $rows = $this->db->num_rows($result);
				
			
                # verify
                if($rows == 0){
                    # employee_code not found
                    $error_type = "F";
                
                    
                } else {
                    $row = $this->db->fetch_array($result);
                    $user_id = $row["user_id"];
					$h_comcode = $row["company_id"];
					
					
                    if ($row["user_status"]  != 1){
                        # user is not active
                        $error_type = "A";

                    } else if (strUtil::isNotEmpty($h_password)){
                        # check password
                        $h_employee_code = $h_password;
                        $h_password = encryption::has_password($h_username, $h_password);
                        
                        if (trim($row["pass"]) != trim($h_password)){
                            $error_type = "P";
                        } else {
                            # check version
                            //$sql = "SELECT value FROM tb_config WHERE con_code = 'C001'";
                            // $error_type = "V";
                        }
                    }
                    
                    //update pass_count when has logined
                           $u_pass_count = "update helpdesk_user set pass_count = '0' where user_id = '{$user_id}'";
                           $result_pass_count = $this->db->query($u_pass_count);
                
                            // update pass_expire 
                        if(strUtil::isNotEmpty($h_pass_expire) && $h_pass_expire == 1 && strUtil::isNotEmpty($h_new_pass)){
                            $date_expire = date("Y-m-d",strtotime("+90 days"));
                            $new_pass = strtoupper(md5($h_new_pass));
                            
                            $u_pass_expire = "update helpdesk_user set pass_expire = '{$date_expire}' where user_id = '{$user_id}'";
                            $result_pass_expire = $this->db->query($u_pass_expire);
                            
                            $u_pass = "update helpdesk_user set pass = '{$new_pass}' where user_id = '{$user_id}'";
                            $result_u_pass= $this->db->query($u_pass);
                        }
                }    
            }
			
			# Get Org /Get Grp
			if(strUtil::isNotEmpty($h_comcode) && strUtil::isNotEmpty($row["org_code"])){
				//$Orgname = $h_comcode;
				# Get Org
				$Orgcode = substr($row["org_code"],0,2);
				$sql = " SELECT org_id,org_name"
                         . " FROM helpdesk_org"
                         . " WHERE org_comp = '$h_comcode' AND org_code = '$Orgcode'";

                $result2 = $this->db->query($sql);
				
                $rows2 = $this->db->num_rows($result2);
				if($rows2>0){
						$row_org = $this->db->fetch_array($result2);
				}
					 
				# Get Grp
				$Orgcode = substr($row["org_code"],0,4);
				$sql = " SELECT org_id as grp_id,org_name as grp_name"
                         . " FROM helpdesk_org"
                         . " WHERE org_comp = '$h_comcode' AND org_code = '$Orgcode'";
				
                $result2 = $this->db->query($sql);
                $rows2 = $this->db->num_rows($result2);
				if($rows2>0){
						$row_grp = $this->db->fetch_array($result2);
				}
					 
				# Get SubGrp
				$Orgcode = substr($row["org_code"],0,8);
				$sql = " SELECT org_id as subgrp_id,org_name as subgrp_name"
                         . " FROM helpdesk_org"
                         . " WHERE org_comp = '$h_comcode' AND org_code = '$Orgcode'";
				
                $result2 = $this->db->query($sql);
                $rows2 = $this->db->num_rows($result2);
				if($rows2>0){
						$row_subgrp = $this->db->fetch_array($result2);
				}
			}
			
			# Get Special Organize
			if(strUtil::isNotEmpty($h_comcode) && strUtil::isNotEmpty($user_id)){
				$sql = " SELECT org_id"
                       . " FROM helpdesk_tr_user_specorg"
                       . " WHERE company_id = '$h_comcode' AND user_id = '$user_id'";
				
                $result = $this->db->query($sql);
                $rows	= $this->db->num_rows($result);
				while($r[]=$this->db->fetch_array($result));
				
				if (count($r) > 0){
					foreach ($r as $rs) {
						$arr_orgspec[] = $rs["org_id"]; 
					}
				}
				//print_r($arr_orgspec); exit;
				
			
			}
			
            #delete log at > 90 days(3 months)
            $date = date("YmdHis", strtotime("$current_date -90 day"));
            $sql = "DELETE FROM tb_login_log WHERE login_date < '$date'";
            $result = $this->db->query($sql);
			
			
            # insert log
            $sql = " INSERT INTO tb_login_log("
                    . " sale_id, login_date, logout_date, employee_code, user_login, ip_address, computer_name, user_agent"
                    . " , error_type, time_stamp, active_page, version"
                    . " ) VALUES ("
                    . " $user_id, '$current_date', NULL, '$h_employee_code', '$h_username', '$ipaddress', '$computer_name'"
                    . " , '$user_agent', '$error_type', '$current_date', NULL, '$application_version'"
                    . " )";
			
            $result = $this->db->query($sql);
            $log_id = $this->db->insert_id();
			
			//echo $row["sale_group_id"]; exit;
            return array(
                "log_id" => $log_id
                , "sale_id" => $row["user_id"]
                , "employee_code" => $row["employee_code"]
                , "sale_name" => $row["first_name"]." ".$row["last_name"]
                , "user_email" => $row["email"]
                , "user_login" => $row["user_login"]
                , "sale_group_id" => $row["sale_group_id"]
                , "error_type" => $error_type
				, "user_company_id" => $row["company_id"]
				, "user_company_name" => $row["company_name"]
				, "user_id" => $row["user_id"]
				, "user_code" => $row["user_code"]
				, "user_my_orgcode" => $row["my_orgcode"]
				, "user_my_grpcode" => $row["my_grpcode"]
				, "user_org_id" => $row_org["org_id"]
				, "user_org_name" => $row_org["org_name"]
				, "user_grp_id" => $row_grp["grp_id"]
				, "user_grp_name" => $row_grp["grp_name"]
				, "user_subgrp_id" => $row_subgrp["subgrp_id"]
				, "user_subgrp_name" => $row_subgrp["subgrp_name"]
				, "user_admin" => $row["admin"]
				, "user_transfer_incident_permission" => $row["transfer_incident_permission"]
				, "user_admin_permission" => $row["admin_permission"]
				, "user_subgrp_id_spec" => $arr_orgspec
				, "user_edit_rpt" =>  $row["edit_report_permission"]
                , "user_appv_rpt" =>  $row["approve_report_permission"]
				, "user_advs_per" => $row["advance_search_permission"]
				, "first_name" => $row["first_name"]
                , "last_name" => $row["last_name"]
				, "cus_company_id" => $row["cus_company_id"]
            );
        }
		
        public function logout($log_id){
            $sql = " UPDATE tb_login_log SET"
                    . " logout_date = '". dateUtil::current_date_time()."'"
                    . " WHERE log_id = '$log_id'";
            return $this->db->query($sql);
        }

        public function updateLog($log_id){
            $sql = " UPDATE tb_login_log SET"
                     . " time_stamp = '".dateUtil::current_date_time()."'"
                     . " , active_page = '{$_SERVER["REQUEST_URI"]}'"
                     . " WHERE log_id = '$log_id'";
            return $this->db->query($sql);
        }

        public function getSessionInfo($log_id){
            $sql = "SELECT time_stamp, version FROM tb_login_log WHERE logout_date Is NULL AND log_id = '$log_id'";
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;
            
            $row = $this->db->fetch_array($result);
            $current_date = dateUtil::current_date_time();
            $time_stamp = $row["time_stamp"];

            $info["idle_time"] = dateUtil::dateDiff($current_date, $time_stamp, dateUtil::DIFF_IN_MINUTES);
            $info["version"] =$row["version"];

            return $info;
        }
/*
        public function listUserSession(){
            $sql = " SELECT"
                    . "    log_id, login_date"
                    . "    , sale_id, employee_code, sale_name"
                    . "    , ip_address, computer_name, user_agent, active_page"
                    . "    , time_stamp"
                    . " FROM"
                    . " (SELECT"
                    . "     l.log_id, l.login_date"
                    . "     , vs.sale_id, vs.employee_code, vs.sale_full_name AS sale_name"
                    . "     , l.ip_address, l.computer_name"
                    . "     , l.user_agent, l.active_page, l.time_stamp"
                    . "     , TIMEDIFF(STR_TO_DATE('".date("YmdHis")."', '%Y%m%d%H%i%s'), STR_TO_DATE(time_stamp, '%Y%m%d%H%i%s')) AS time_idle"
                    . "  FROM tb_login_log l"
                    . "  LEFT JOIN v_tb_sale vs ON (l.sale_id = vs.sale_id)"
                    . "  WHERE l.logout_date IS NULL"
                    . "  AND l.error_type = ''"
                    . " ) t"
                    . " WHERE (HOUR(time_idle) = 0 AND MINUTE(time_idle) < 30)"
                    . " ORDER BY login_date DESC";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return $arr;
        }
*/
        public function isBrowserAllow($user_agent){
            $arr_allow = array("MSIE", "Firefox", "Safari", "Chrome", "Opera");
            foreach ($arr_allow as $browser) {
                if ((int)strpos(" ".$user_agent, $browser) > 0){
                    return true;
                }
            }

            return false;
        }
    }
?>