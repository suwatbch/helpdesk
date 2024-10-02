<?php
include_once "model.class.php";

class sla_report extends model {
    
    
    public function get_sla_detail($val){
        $sql = " SELECT
            i.ident_id_run_project as inc_id, i.ident_type_id as inc_type_id , inc_type.ident_type_desc as inc_type_name,
            i.create_date as inc_date, i.priority_id, pri.priority_desc as priority_name,
            i.owner_user_id as owner_id, CONCAT( own.first_name,  ' ', own.last_name ) as owner_name,
            IFNULL(CONCAT( rsp.first_name,  ' ', rsp.last_name ),'') as responded_by,
            i.cas_opr_tier_id1 as cas_opr_id_1 ,c_opr1.opr_tier_name as cas_opr_name_1,
            i.cas_opr_tier_id2 as cas_opr_id_2 ,c_opr2.opr_tier_name as cas_opr_name_2,
            i.cas_opr_tier_id3 as cas_opr_id_3 ,c_opr3.opr_tier_name as cas_opr_name_3,
            i.cas_prd_tier_id1 as cas_prd_id_1 ,c_prd1.prd_tier_name as cas_prd_name_1,
            i.cas_prd_tier_id2 as cas_prd_id_2 ,c_prd2.prd_tier_name as cas_prd_name_2,
            i.cas_prd_tier_id3 as cas_prd_id_3 ,c_prd3.prd_tier_name as cas_prd_name_3,
            IFNULL(CONCAT( rsv.first_name,  ' ', rsv.last_name ),'') as resolved_by,
            i.resol_oprtier1 as res_opr_id_1, r_opr1.opr_tier_name as res_opr_name_1,
            i.resol_oprtier2 as res_opr_id_2, r_opr2.opr_tier_name as res_opr_name_2,
            i.resol_oprtier3 as res_opr_id_3, r_opr3.opr_tier_name as res_opr_name_3,
            i.resol_prdtier1 as res_prd_id_1, r_prd1.prd_tier_name as res_prd_name_1,
            i.resol_prdtier2 as res_prd_id_2, r_prd2.prd_tier_name as res_prd_name_2,
            i.resol_prdtier3 as res_prd_id_3, r_prd3.prd_tier_name as res_prd_name_3,
            i.assigned_date , i.working_date , 
            SEC_TO_TIME(i.responded_holiday) as resp_holiday, 
            SEC_TO_TIME(i.responded_days - i.responded_holiday) as actual_resp,
            i.resolved_date, SEC_TO_TIME(i.resolved_pending) as resv_pending, SEC_TO_TIME(i.resolved_holiday) as resv_holiday, 
            SEC_TO_TIME(i.resolved_days - i.resolved_pending - i.resolved_holiday) as actual_resv,
            c_map_opr.tr_opr_tier_id as resp_opr_id,c_map_prd.tr_prd_tier_id as resp_prd_id,
            r_map_opr.tr_opr_tier_id as resv_opr_id,r_map_prd.tr_prd_tier_id as resv_prd_id,
            SEC_TO_TIME(sla_resp.sum_respond_sla) as respond_sla , SEC_TO_TIME(sla_resv.sum_resolve_sla) as resolve_sla,
            Case 
            when sla_resp.sum_respond_sla is NULL then 'N/A'
            when sla_resp.sum_respond_sla - (i.responded_days - i.responded_holiday) >= 0 then 'Meet'
            else 'Miss' end as respond_sla_result,
            Case 
            when sla_resv.sum_resolve_sla is NULL then 'N/A'
            when sla_resv.sum_resolve_sla - (i.resolved_days - i.resolved_pending - i.resolved_holiday) >= 0 then 'Meet'
            else 'Miss' end as resolve_sla_resilt
            FROM helpdesk_tr_incident i
            Left Join helpdesk_incident_type inc_type on inc_type.ident_type_id = i.ident_type_id
            Left Join helpdesk_priority pri on pri.priority_id = i.priority_id
            Left Join helpdesk_user own on own.user_id = i.owner_user_id 
            Left Join helpdesk_user rsp on rsp.user_id = i.responded_by 
            Left Join helpdesk_user rsv on rsv.user_id = i.resolved_by 
            Left Join helpdesk_opr_tier c_opr1 on c_opr1.opr_tier_id = i.cas_opr_tier_id1
            Left Join helpdesk_opr_tier c_opr2 on c_opr2.opr_tier_id = i.cas_opr_tier_id2
            Left Join helpdesk_opr_tier c_opr3 on c_opr3.opr_tier_id = i.cas_opr_tier_id3
            Left Join helpdesk_prd_tier c_prd1 on c_prd1.prd_tier_id = i.cas_prd_tier_id1
            Left Join helpdesk_prd_tier c_prd2 on c_prd2.prd_tier_id = i.cas_prd_tier_id2
            Left Join helpdesk_prd_tier c_prd3 on c_prd3.prd_tier_id = i.cas_prd_tier_id3
            Left Join helpdesk_opr_tier r_opr1 on r_opr1.opr_tier_id = i.resol_oprtier1
            Left Join helpdesk_opr_tier r_opr2 on r_opr2.opr_tier_id = i.resol_oprtier2
            Left Join helpdesk_opr_tier r_opr3 on r_opr3.opr_tier_id = i.resol_oprtier3
            Left Join helpdesk_prd_tier r_prd1 on r_prd1.prd_tier_id = i.resol_prdtier1
            Left Join helpdesk_prd_tier r_prd2 on r_prd2.prd_tier_id = i.resol_prdtier2
            Left Join helpdesk_prd_tier r_prd3 on r_prd3.prd_tier_id = i.resol_prdtier3
            Left Join helpdesk_tr_opr_tier c_map_opr on (c_map_opr.opr_tier_lv1_id = i.cas_opr_tier_id1 
                                                        and c_map_opr.opr_tier_lv2_id = i.cas_opr_tier_id2 
                                                        and c_map_opr.opr_tier_lv3_id = i.cas_opr_tier_id3)
            Left Join helpdesk_tr_prd_tier c_map_prd on (c_map_prd.prd_tier_lv1_id = i.cas_prd_tier_id1
                                                        and c_map_prd.prd_tier_lv2_id = i.cas_prd_tier_id2
                                                        and c_map_prd.prd_tier_lv3_id = i.cas_prd_tier_id3)										
            Left Join helpdesk_respond sla_resp on (sla_resp.tr_prd_tier_id = c_map_prd.tr_prd_tier_id	
                                                        and sla_resp.tr_opr_tier_id = c_map_opr.tr_opr_tier_id
                                                        and sla_resp.cus_comp_id = i.cus_company_id
                                                        and sla_resp.priority_id = i.priority_id)										
            Left Join helpdesk_tr_opr_tier r_map_opr on (r_map_opr.opr_tier_lv1_id = i.resol_oprtier1
                                                        and r_map_opr.opr_tier_lv2_id = i.resol_oprtier2 
                                                        and r_map_opr.opr_tier_lv3_id = i.resol_oprtier3)	
            Left Join helpdesk_tr_prd_tier r_map_prd on (r_map_prd.prd_tier_lv1_id = i.resol_prdtier1
                                                        and r_map_prd.prd_tier_lv2_id = i.resol_prdtier2
                                                        and r_map_prd.prd_tier_lv3_id = i.resol_prdtier3)												
            Left Join helpdesk_resolve sla_resv on (sla_resv.tr_prd_tier_id = r_map_prd.tr_prd_tier_id	
                                                        and sla_resv.tr_opr_tier_id = r_map_opr.tr_opr_tier_id
                                                        and sla_resv.cus_comp_id = i.cus_company_id
                                                        and sla_resv.priority_id = i.priority_id)  
           where 1 = 1 ";
        
        
        if (strUtil::isNotEmpty($val["comp_id"])){
            $sql .= " and i.cus_company_id = {$val["comp_id"]}";
        }
        
        if (strUtil::isNotEmpty($val["start_date"]) && strUtil::isNotEmpty($val["end_date"])){
            $sql .= " and DATE(i.create_date) between '{$val["start_date"]}'  and '{$val["end_date"]}' " ;
        }
        
        if (strUtil::isNotEmpty($val["project"])){
            $sql .= " and i.project_id = {$val["project"]} ";
        }
        
        if (strUtil::isNotEmpty($val["incident_type_fr"]) && strUtil::isNotEmpty($val["incident_type_to"])){
            $sql .= " and i.ident_type_id between {$val["incident_type_fr"]} and {$val["incident_type_to"]} ";
        }
        
        if (strUtil::isNotEmpty($val["display_inc"])){
            $sql .= " and i.ident_type_id in (SELECT  ident_type_id  FROM  helpdesk_incident_type WHERE display_report in ({$val["display_inc"]})) ";
        }
        
        if (strUtil::isNotEmpty($val["status_fr"]) && strUtil::isNotEmpty($val["status_to"])){
            $sql .= " and i.status_id between {$val["status_fr"]} and {$val["status_to"]} ";
        }
        
        if (strUtil::isNotEmpty($val["priority_fr"]) && strUtil::isNotEmpty($val["priority_to"])){
            $sql .= " and i.priority_id between {$val["priority_fr"]} and {$val["priority_to"]} ";
        }
        
        if (strUtil::isNotEmpty($val["resp_group"])){
            $sql .= " and i.responded_by_grp_id = {$val["resp_group"]} ";
        }
        
        if (strUtil::isNotEmpty($val["resp_subgroup"])){
            $sql .= " and i.responded_by_subgrp_id = {$val["resp_subgroup"]} ";
        }
        
        if (strUtil::isNotEmpty($val["resv_group"])){
            $sql .= " and i.resolved_by_grp_id = {$val["resv_group"]} ";
        }
        
        if (strUtil::isNotEmpty($val["resv_subgroup"])){
            $sql .= " and i.resolved_by_subgrp_id = {$val["resv_subgroup"]} ";
        }
        
        if (strUtil::isNotEmpty($val["respond_name"])){
            $sql .= " and  REPLACE(CONCAT(ifnull(rsp.first_name,'' ),ifnull(rsp.last_name,'')), ' ', '') like '%{$val["respond_name"]}%' ";
        }
        
        if (strUtil::isNotEmpty($val["resolved_name"])){
            $sql .= " and  REPLACE(CONCAT(ifnull(rsv.first_name,'' ),ifnull(rsv.last_name,'')), ' ', '') like '%{$val["resolved_name"]}%' ";
        }
        
        if (strUtil::isNotEmpty($val["owner_name"])){
            $sql .= " and  REPLACE(CONCAT(ifnull(own.first_name,'' ),ifnull(own.last_name,'')), ' ', '') like '%{$val["owner_name"]}%' ";
        }
        
        if (strUtil::isNotEmpty($val["reference_fr"]) && strUtil::isNotEmpty($val["reference_to"])){
            $sql .= " and i.reference_no between {$val["reference_fr"]} and {$val["reference_to"]} ";
        }
        
        
        $sql .= " order by i.ident_id_run_project";
        
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
    
    
    
    public function summary_getmain_data($val){
        $sql_start = "select distinct f.ident_type_id as type_id, ident.ident_type_desc as type_name,
            f.group_id , grp.org_code,grp.org_name as group_name,
            f.subgroup_id ,subgrp.org_code, subgrp.org_name as subgroup_name,
            f.user_id , CONCAT( u.first_name,  ' ', u.last_name ) as user_name,
            f.priority_id, p.priority_desc as priority_name
            from (";
        
        
        $sql_respond = "select distinct ident_type_id, responded_by as user_id ,  responded_by_grp_id as group_id , responded_by_subgrp_id as subgroup_id,priority_id
			from helpdesk_tr_incident
			where responded_by <> 0 ";
        
        $sql_resolve = "select distinct ident_type_id, resolved_by as user_id ,  resolved_by_grp_id as group_id , resolved_by_subgrp_id as subgroup_id,priority_id
			from helpdesk_tr_incident
			where resolved_by <> 0  ";
        
        
        if (strUtil::isNotEmpty($val["comp_id"])){
            $sql_respond .= " and cus_company_id = {$val["comp_id"]}";
            $sql_resolve .= " and cus_company_id = {$val["comp_id"]}";
        }
        
        if (strUtil::isNotEmpty($val["start_date"]) && strUtil::isNotEmpty($val["end_date"])){
            $sql_respond .= " and DATE(create_date) between '{$val["start_date"]}'  and '{$val["end_date"]}' " ;
            $sql_resolve .= " and DATE(create_date) between '{$val["start_date"]}'  and '{$val["end_date"]}' " ;
        }
        
        if (strUtil::isNotEmpty($val["project"])){
            $sql_respond .= " and project_id = {$val["project"]} ";
            $sql_resolve .= " and project_id = {$val["project"]} ";
        }
        
        if (strUtil::isNotEmpty($val["incident_type_fr"]) && strUtil::isNotEmpty($val["incident_type_to"])){
            $sql_respond .= " and ident_type_id between {$val["incident_type_fr"]} and {$val["incident_type_to"]} ";
            $sql_resolve .= " and ident_type_id between {$val["incident_type_fr"]} and {$val["incident_type_to"]} ";
        }
        
        if (strUtil::isNotEmpty($val["display_inc"])){
            $sql_respond .= " and ident_type_id in (SELECT  ident_type_id  FROM  helpdesk_incident_type WHERE display_report in ({$val["display_inc"]})) ";
            $sql_resolve .= " and ident_type_id in (SELECT  ident_type_id  FROM  helpdesk_incident_type WHERE display_report in ({$val["display_inc"]})) ";
        }
        
        if (strUtil::isNotEmpty($val["status_fr"]) && strUtil::isNotEmpty($val["status_to"])){
            $sql_respond .= " and status_id between {$val["status_fr"]} and {$val["status_to"]} ";
            $sql_resolve .= " and status_id between {$val["status_fr"]} and {$val["status_to"]} ";
        }
        
        if (strUtil::isNotEmpty($val["priority_fr"]) && strUtil::isNotEmpty($val["priority_to"])){
            $sql_respond .= " and priority_id between {$val["priority_fr"]} and {$val["priority_to"]} ";
            $sql_resolve .= " and priority_id between {$val["priority_fr"]} and {$val["priority_to"]} ";
        }
        
        if (strUtil::isNotEmpty($val["resp_group"])){
            $sql_respond .= " and responded_by_grp_id = {$val["resp_group"]} ";
            $sql_resolve .= " and resolved_by_grp_id = {$val["resv_group"]} ";
        }
        
        if (strUtil::isNotEmpty($val["resp_subgroup"])){
            $sql_respond .= " and responded_by_subgrp_id = {$val["resp_subgroup"]} ";
            $sql_resolve .= " and resolved_by_subgrp_id = {$val["resv_subgroup"]} ";
        }
        
        if (strUtil::isNotEmpty($val["reference_fr"]) && strUtil::isNotEmpty($val["reference_to"])){
            $sql_respond .= " and reference_no between {$val["reference_fr"]} and {$val["reference_to"]} ";
            $sql_resolve .= " and reference_no between {$val["reference_fr"]} and {$val["reference_to"]} ";
        }
        
        
        
        $sql_end = " )f
                inner join helpdesk_incident_type ident on ident.ident_type_id  = f.ident_type_id 
                inner join helpdesk_priority p on p.priority_id = f.priority_id
                inner join helpdesk_org grp on grp.org_id = f.group_id
                inner join helpdesk_org subgrp on subgrp.org_id = f.subgroup_id
                inner join helpdesk_user u on u.user_id = f.user_id 
                where 1 = 1 ";
        
        if (strUtil::isNotEmpty($val["respond_name"])){
            $sql_end .= " and REPLACE(CONCAT( u.first_name,  ' ', u.last_name ), ' ', '') like '%{$val["respond_name"]}%' ";
        }
        
        $sql_end .= " order by  f.ident_type_id,grp.org_code,subgrp.org_code,CONCAT( u.first_name,  ' ', u.last_name ),f.priority_id ";
        
        $sql = $sql_start.$sql_respond. " union all " .$sql_resolve.$sql_end;
        

        
        
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
    
    public function summary_count_respond($inc_type_id,$user_id,$group_id,$sub_group_id,$priority_id,$val,$mode){
        $sql = "select distinct i.ident_id_run_project			
            FROM helpdesk_tr_incident i
            left join helpdesk_user u on u.user_id = i.responded_by
            Left Join helpdesk_tr_opr_tier c_map_opr on (c_map_opr.opr_tier_lv1_id = i.cas_opr_tier_id1 
                                                        and c_map_opr.opr_tier_lv2_id = i.cas_opr_tier_id2 
                                                        and c_map_opr.opr_tier_lv3_id = i.cas_opr_tier_id3)
            Left Join helpdesk_tr_prd_tier c_map_prd on (c_map_prd.prd_tier_lv1_id = i.cas_prd_tier_id1
                                                        and c_map_prd.prd_tier_lv2_id = i.cas_prd_tier_id2
                                                        and c_map_prd.prd_tier_lv3_id = i.cas_prd_tier_id3)										
            Left Join helpdesk_respond sla_resp on (sla_resp.tr_prd_tier_id = c_map_prd.tr_prd_tier_id	
                                                        and sla_resp.tr_opr_tier_id = c_map_opr.tr_opr_tier_id
                                                        and sla_resp.cus_comp_id = i.cus_company_id
                                                        and sla_resp.priority_id = i.priority_id)
            where 1 = 1 ";
        
        if (strUtil::isNotEmpty($inc_type_id)){
            $sql.= " and i.ident_type_id = $inc_type_id ";
        }
        
        if (strUtil::isNotEmpty($user_id)){
            $sql.= " and ifnull(i.responded_by,0) = $user_id ";
        }
        
        if (strUtil::isNotEmpty($group_id)){
            $sql .= " and i.responded_by_grp_id = $group_id ";
        }
        
        if (strUtil::isNotEmpty($sub_group_id)){
            $sql .= " and i.responded_by_subgrp_id = $sub_group_id ";
        }
        
        if (strUtil::isNotEmpty($priority_id)){
             $sql .= " and i.priority_id = $priority_id ";
        }
                
        if (strUtil::isNotEmpty($val["comp_id"])){
            $sql .= " and i.cus_company_id = {$val["comp_id"]}";
        }
        
        if (strUtil::isNotEmpty($val["start_date"]) && strUtil::isNotEmpty($val["end_date"])){
            $sql .= " and DATE(i.create_date) between '{$val["start_date"]}'  and '{$val["end_date"]}' " ;
        }
        
        if (strUtil::isNotEmpty($val["project"])){
            $sql .= " and i.project_id = {$val["project"]} ";
        }
        
                
        if (strUtil::isNotEmpty($val["status_fr"]) && strUtil::isNotEmpty($val["status_to"])){
            $sql .= " and i.status_id between {$val["status_fr"]} and {$val["status_to"]} ";
        }
        
               
        if (strUtil::isNotEmpty($val["reference_fr"]) && strUtil::isNotEmpty($val["reference_to"])){
            $sql .= " and i.reference_no between {$val["reference_fr"]} and {$val["reference_to"]} ";
        }
        
        if (strtolower($mode) == 'n'){//not set sla master >> N/A
            $sql .= " and sla_resp.sum_respond_sla is NULL ";
        }else if (strtolower($mode) == 'c'){//cancel
            $sql .= " and (ifnull(i.status_res_id,0) = 8) or (ifnull(i.status_res_id,0) = 12) or (ifnull(i.status_res_id,0) = 16) ";
        }else if(strtolower($mode) == 't'){//meet
            $sql .= " and sla_resp.sum_respond_sla - (i.responded_days - i.responded_holiday) >= 0 ";
        }else if(strtolower($mode) == 's'){//miss
            $sql .= " and sla_resp.sum_respond_sla - (i.responded_days - i.responded_holiday) < 0 ";
        }
        
        $result = $this->db->query($sql);
        $rows = $this->db->num_rows($result);

        return $rows;

    }
    
    
    public function summary_count_resolve($inc_type_id,$user_id,$group_id,$sub_group_id,$priority_id,$val,$mode){
        $sql = "select distinct i.ident_id_run_project			
            FROM helpdesk_tr_incident i
            left join helpdesk_user u on u.user_id = i.resolved_by
            Left Join helpdesk_tr_opr_tier r_map_opr on (r_map_opr.opr_tier_lv1_id = i.resol_oprtier1
                                                        and r_map_opr.opr_tier_lv2_id = i.resol_oprtier2 
                                                        and r_map_opr.opr_tier_lv3_id = i.resol_oprtier3)	
            Left Join helpdesk_tr_prd_tier r_map_prd on (r_map_prd.prd_tier_lv1_id = i.resol_prdtier1
                                                        and r_map_prd.prd_tier_lv2_id = i.resol_prdtier2
                                                        and r_map_prd.prd_tier_lv3_id = i.resol_prdtier3)												
            Left Join helpdesk_resolve sla_resv on (sla_resv.tr_prd_tier_id = r_map_prd.tr_prd_tier_id	
                                                    and sla_resv.tr_opr_tier_id = r_map_opr.tr_opr_tier_id
                                                    and sla_resv.cus_comp_id = i.cus_company_id
                                                    and sla_resv.priority_id = i.priority_id)
            where 1 = 1 ";
        
        if (strUtil::isNotEmpty($inc_type_id)){
            $sql.= " and i.ident_type_id = $inc_type_id ";
        }
        
        if (strUtil::isNotEmpty($user_id)){
            $sql.= " and ifnull(i.resolved_by,0) = $user_id ";
        }
        
        if (strUtil::isNotEmpty($group_id)){
            $sql .= " and i.resolved_by_grp_id = $group_id ";
        }
        
        if (strUtil::isNotEmpty($sub_group_id)){
            $sql .= " and i.resolved_by_subgrp_id = $sub_group_id ";
        }
        
        if (strUtil::isNotEmpty($priority_id)){
             $sql .= " and i.priority_id = $priority_id ";
        }
                
        if (strUtil::isNotEmpty($val["comp_id"])){
            $sql .= " and i.cus_company_id = {$val["comp_id"]}";
        }
        
        if (strUtil::isNotEmpty($val["start_date"]) && strUtil::isNotEmpty($val["end_date"])){
            $sql .= " and DATE(i.create_date) between '{$val["start_date"]}'  and '{$val["end_date"]}' " ;
        }
        
        if (strUtil::isNotEmpty($val["project"])){
            $sql .= " and i.project_id = {$val["project"]} ";
        }
        
                
        if (strUtil::isNotEmpty($val["status_fr"]) && strUtil::isNotEmpty($val["status_to"])){
            $sql .= " and i.status_id between {$val["status_fr"]} and {$val["status_to"]} ";
        }
        
               
        if (strUtil::isNotEmpty($val["reference_fr"]) && strUtil::isNotEmpty($val["reference_to"])){
            $sql .= " and i.reference_no between {$val["reference_fr"]} and {$val["reference_to"]} ";
        }
        
        if (strtolower($mode) == 'n'){//not set sla master >> N/A
            $sql .= " and sla_resv.sum_resolve_sla is NULL ";
        }else if (strtolower($mode) == 'c'){//cancel
            $sql .= " and (ifnull(i.status_res_id,0) = 8) or (ifnull(i.status_res_id,0) = 12) or (ifnull(i.status_res_id,0) = 16) ";
        }else if(strtolower($mode) == 't'){//meet
            $sql .= " and sla_resv.sum_resolve_sla - (i.resolved_days - i.resolved_pending - i.resolved_holiday) >= 0 ";
        }else if(strtolower($mode) == 's'){//miss
            $sql .= " and sla_resv.sum_resolve_sla - (i.resolved_days - i.resolved_pending - i.resolved_holiday) < 0 ";
        }
        
        $result = $this->db->query($sql);
        $rows = $this->db->num_rows($result);

        return $rows;

    }
    
    
    
}

?>
