<?php

include_once "model.class.php";

    class send_email extends model {
        
        public function getEmailType_id(){
            $sql = "select id from helpdesk_vlookup where type = 'alert_sla'";
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            
            if ($rows == 0) return "";
            
            while($row = $this->db->fetch_array($result)){
                $id = $row["id"];
            }
            
            return $id;
            
        }
        
        public  function getSchedule($type_id){
            $sql = "select * from helpdesk_alert_schedule where type_id = ".$type_id ;
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "data" => $arr,
                "total_rows" => $rows
            );
        }
        
        
        public function exists($type_id = 0){
            $sql = "SELECT 1 
                FROM helpdesk_alert_schedule
                WHERE type_id = $type_id ";

            $result = $this->db->query($sql);
            $total_row = $this->db->num_rows($result);

            if ($total_row == 0) {
                return 0;
            }else {
                return $total_row;
            }
        }
        
        
        public function update_schedule($arr){
            $table = "helpdesk_alert_schedule";
            $data = "start_datetime = '{$arr["start_datetime"]}',
                    schedule = '{$arr["schedule"]}' , 
                    enabled = '{$arr["enabled"]}' , 
                    modified_by = '{$arr["user_id"]}',
                    modified_date = NOW() ,
                    latest_run = '{$arr["latest_run"]}' ";
             $condition = " type_id = '{$arr["type_id"]}'";
            
            $result = $this->db->update($table, $data, $condition);
            return $result;
        }
        
        
        public function insert_schedule($arr){
            $table = "helpdesk_alert_schedule";
            $field = "start_datetime, schedule, enabled, type_id, 
                    created_by, created_date, modified_by, modified_date, latest_run";
            $data = "'{$arr["start_datetime"]}','{$arr["schedule"]}','{$arr["enabled"]}','{$arr["type_id"]}',
                    '{$arr["user_id"]}', NOW(),'{$arr["user_id"]}', NOW(),'{$arr["latest_run"]}'";
           
//            echo "Insert into $table ($field) values($data)";
//            exit();
            $result = $this->db->insert($table, $field, $data);       
            return $result;
        }

        
        /*=========================== FOR EMAIL ALERT ===============================*/
        /*===========================================================================*/
        
        function getEmailList(){
            $sql = "SELECT company_id, org_id, grp_id, subgrp_id, 
            on_sla_l1, on_sla_l1_to, on_sla_l1_cc, 
            on_sla_l2, on_sla_l2_to, on_sla_l2_cc, 
            on_sla_l3, on_sla_l3_to, on_sla_l3_cc, 
            over_sla_l1, over_sla_l1_to, over_sla_l1_cc, 
            over_sla_l2, over_sla_l2_to, over_sla_l2_cc, 
            over_sla_l3, over_sla_l3_to, over_sla_l3_cc 
            FROM helpdesk_sla_email_alert ";

            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
//            echo $rows;
            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "data" => $arr,
                "total_rows" => $rows
            );
        }
        
        
        
        function getMaster_SLA($type){
            
            if ($type == 2) {// assign
            
                $sql = "SELECT re.id_respond, re.cus_comp_id, re.priority_id, re.tr_prd_tier_id, re.tr_opr_tier_id, re.sum_respond_sla as secs_sla, 
                        prd.prd_tier_lv1_id as prd_class1_id ,p1.prd_tier_name as prd_class1_name, 
                        prd.prd_tier_lv2_id as prd_class2_id, p2.prd_tier_name as prd_class2_name, 
                        prd.prd_tier_lv3_id as prd_class3_id, ifnull(p3.prd_tier_name,'') as prd_class3_name,
                        opr.opr_tier_lv1_id as opr_class1_id,o1.opr_tier_name as opr_class1_name,
                        opr.opr_tier_lv2_id as opr_class2_id,o2.opr_tier_name as opr_class2_name,
                        opr.opr_tier_lv3_id as opr_class3_id, ifnull(o3.opr_tier_name,'') as opr_class3_name
                        FROM helpdesk_respond re
                        INNER JOIN helpdesk_tr_prd_tier prd ON ( re.tr_prd_tier_id = prd.tr_prd_tier_id ) 
                        INNER JOIN helpdesk_tr_opr_tier opr ON ( re.tr_opr_tier_id = opr.tr_opr_tier_id ) 
                        Left JOIN helpdesk_prd_tier p1 ON p1.prd_tier_id = prd.prd_tier_lv1_id
                        Left JOIN helpdesk_prd_tier p2 ON p2.prd_tier_id = prd.prd_tier_lv2_id
                        Left JOIN helpdesk_prd_tier p3 ON p3.prd_tier_id = prd.prd_tier_lv3_id
                        Left JOIN helpdesk_opr_tier o1 ON o1.opr_tier_id = opr.opr_tier_lv1_id
                        Left JOIN helpdesk_opr_tier o2 ON o2.opr_tier_id = opr.opr_tier_lv2_id
                        Left JOIN helpdesk_opr_tier o3 ON o3.opr_tier_id = opr.opr_tier_lv3_id
                        where TRIM(ifnull(re.status,'')) = ''
                        order by re.priority_id,prd.prd_tier_lv1_id,prd.prd_tier_lv2_id,prd.prd_tier_lv3_id,opr.opr_tier_lv1_id,opr.opr_tier_lv2_id,opr.opr_tier_lv3_id ";

            }else if ($type == 3){//working
            
                $sql = "SELECT re.id_resolve,re.cus_comp_id, re.priority_id, re.tr_prd_tier_id, re.tr_opr_tier_id, re.sum_resolve_sla as secs_sla, 
                        prd.prd_tier_lv1_id as prd_class1_id ,p1.prd_tier_name as prd_class1_name, 
                        prd.prd_tier_lv2_id as prd_class2_id, p2.prd_tier_name as prd_class2_name, 
                        prd.prd_tier_lv3_id as prd_class3_id, ifnull(p3.prd_tier_name,'') as prd_class3_name,
                        opr.opr_tier_lv1_id as opr_class1_id,o1.opr_tier_name as opr_class1_name,
                        opr.opr_tier_lv2_id as opr_class2_id,o2.opr_tier_name as opr_class2_name,
                        opr.opr_tier_lv3_id as opr_class3_id,ifnull(o3.opr_tier_name,'') as opr_class3_name
                        FROM helpdesk_resolve re
                        INNER JOIN helpdesk_tr_prd_tier prd ON ( re.tr_prd_tier_id = prd.tr_prd_tier_id ) 
                        INNER JOIN helpdesk_tr_opr_tier opr ON ( re.tr_opr_tier_id = opr.tr_opr_tier_id ) 
                        Left JOIN helpdesk_prd_tier p1 ON p1.prd_tier_id = prd.prd_tier_lv1_id
                        Left JOIN helpdesk_prd_tier p2 ON p2.prd_tier_id = prd.prd_tier_lv2_id
                        Left JOIN helpdesk_prd_tier p3 ON p3.prd_tier_id = prd.prd_tier_lv3_id
                        Left JOIN helpdesk_opr_tier o1 ON o1.opr_tier_id = opr.opr_tier_lv1_id
                        Left JOIN helpdesk_opr_tier o2 ON o2.opr_tier_id = opr.opr_tier_lv2_id
                        Left JOIN helpdesk_opr_tier o3 ON o3.opr_tier_id = opr.opr_tier_lv3_id
                        where TRIM(ifnull(re.status,'')) = ''
                        order by re.priority_id,prd.prd_tier_lv1_id,prd.prd_tier_lv2_id,prd.prd_tier_lv3_id,opr.opr_tier_lv1_id,opr.opr_tier_lv2_id,opr.opr_tier_lv3_id";
            }
            
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "data" => $arr,
                "total_rows" => $rows
            );
        }
        
        
        
         function getIncident($filter){
            $sql = "select * from helpdesk_tr_incident  
                    where status_id = {$filter["status_id"]} 
                    and priority_id = {$filter["priority_id"]} 
                    and cus_company_id = {$filter["cus_company_id"]} 
                    and cas_opr_tier_id1 = {$filter["opr_class1_id"]} 
                    and cas_opr_tier_id2 = {$filter["opr_class2_id"]} 
                    and cas_opr_tier_id3 = {$filter["opr_class3_id"]} 
                    and cas_prd_tier_id1 = {$filter["prd_class1_id"]} 
                    and cas_prd_tier_id2 = {$filter["prd_class2_id"]} 
                    and cas_prd_tier_id3 = {$filter["prd_class3_id"]} 
                    and assign_org_id_last = {$filter["org_id"]} 
                    and assign_comp_id_last = {$filter["comp_id"]} ";
            
            if ($filter["group_id"] <> '0'){
                $sql .= " and assign_grp_id_last = {$filter["group_id"]}";
            }
            
            if ($filter["subgroup_id"] <> '0'){
                $sql .= "  and assign_subgrp_id_last = {$filter["subgroup_id"]} ";
            }
             
            $sql .= " order by ident_id_run_project";
            
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            
            if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $arr[] = $row;
            }

            return array(
                "data" => $arr,
                "total_rows" => $rows
            );
            
        }
        
        
        function get_first_working ($id){
            $sql = "select workinfo_date from helpdesk_tr_workinfo where incident_id = {$id} order by workinfo_date desc limit 0,1";
            
            $result = $this->db->query($sql);
            $rows = $this->db->num_rows($result);
            
            if ($rows == 0) return null;
            
            while($row = $this->db->fetch_array($result)){
                $date = $row["workinfo_date"];
            }
            
            return $date;
        
    }
    
    function getUser($user_id){
        $sql = "select user_id , user_code , employee_code , first_name, last_name,concat(first_name, ' ', last_name) as fullname
            from helpdesk_user where user_id = " . $user_id;

        $result = $this->db->query($sql);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return "";

        while($row = $this->db->fetch_array($result)){
            $name = "[{$row["employee_code"]}] ".$row["fullname"];
        }

        return $name;
    }
    
    
    function updateSent($val){        
        $table = "helpdesk_tr_incident";
        $data = "alert_date = '{$val["alert_date"]}' ,
                alert_status_sla = '{$val["alert_status_sla"]}' ,
                alert_sla_days = '{$val["alert_sla_days"]}',
                alert_status_id = '{$val["alert_status_id"]}',
                alert_percent_sla = '{$val["alert_percent_sla"]}' ";
        $condition = "id = '{$val["id"]}'";
                
        $result = $this->db->update($table, $data, $condition);
        return $result;
    }
        
    }
?>
