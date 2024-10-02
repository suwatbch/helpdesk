<?php
include_once "model.class.php";

class report_detal extends model {
   
    
   public function getReportDetail($criterai){
        global $page_size;
        
       $class3_fr =  $criterai["prd_tier_id3"];
       $class3_to = $criterai["prd_tier_id3_l"];
             
        if (strUtil::isNotEmpty($class3_fr) && strUtil::isNotEmpty($class3_to)){
            $tb_class3 = " (SELECT prd_tier_name,prd_tier_id
                            FROM `helpdesk_prd_tier`
                            WHERE `prd_tier_level` = 3
                            AND `prd_tier_name`
                            BETWEEN '$class3_fr'
                            AND '$class3_to' order by prd_tier_name) ";
        }
        else if (strUtil::isNotEmpty($class3_fr) && strUtil::isEmpty($class3_to)){
             $tb_class3 = " (SELECT prd_tier_name,prd_tier_id
                            FROM `helpdesk_prd_tier`
                            WHERE `prd_tier_level` = 3
                            AND `prd_tier_name` = '$class3_fr' order by prd_tier_name) ";
        }else{
            $tb_class3 = "helpdesk_prd_tier";
        }
        
        if($criterai["show_to_customer"] == 'Y'){
            $display_inc = '1';
        }else {
            $display_inc = '0,1';
        }
        
                $field = "inc.ident_id_run_project,inc.cus_office,inc.cus_firstname,inc.cus_lastname,inc.cus_id,us.first_name,us.last_name
                  ,inc.summary,inc.notes,inc.create_date,inc.closed_date,st.status_desc,r.status_res_desc,IF (inc.resolution_user_id=inc.owner_user_id, inc.resolution, '') as s_resolution,IF (inc.resolution_user_id<>inc.owner_user_id, inc.resolution, '') as ss_resolution
                  ,zo.name as name_zone,CONCAT(u4.first_name,' ',u4.last_name) as resolve_user,inc.reference_no,c3.prd_tier_name as s_prd_tier_name
                  ,inc.resolved_days,inc.resolved_pending,inc.tot_actual_working_sec,inc.tot_actual_pending_sec,inc.tot_pending_res_wait_info
                  ,inc.tot_pending_res_wait_sap,inc.tot_pending_res_wait_dev,inc.tot_pending_res_wait_test,pi.priority_desc as priority_desc,inc.priority_id as priority_id";
         
                $table =" ( select *,
                          case when ifnull(resol_prdtier1,0) <> 0 then ifnull(resol_prdtier1,0)
                               else ifnull(cas_prd_tier_id1,0) end as  prd_tier_id1 ,
                          case when ifnull(resol_prdtier2,0) <> 0 then ifnull(resol_prdtier2,0)
                               else ifnull(cas_prd_tier_id2,0) end as  prd_tier_id2 ,     
                          case when ifnull(resol_prdtier3,0) <> 0 then ifnull(resol_prdtier3,0)
                               else ifnull(cas_prd_tier_id3,0) end as  prd_tier_id3
                         from helpdesk_tr_incident
                         where ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ) inc
                  inner Join  $tb_class3 c3 on (c3.prd_tier_id = inc.prd_tier_id3)
                  left join helpdesk_user us on(inc.owner_user_id=us.user_id)
                  left join helpdesk_status st on(inc.status_id=st.status_id)
                  left join helpdesk_status_res r on(inc.status_res_id=r.status_res_id)
                  left join helpdesk_cus_zone_area z on(inc.cus_area=z.area_cus)
                  left join helpdesk_cus_zone zo on(z.zone_id=zo.zone_id)
                  left join helpdesk_user us_re on(inc.resolution_user_id=us_re.user_id)
                  left JOIN helpdesk_user u4 ON (inc.resolution_user_id=u4.user_id)
                  left JOIN helpdesk_project pj ON (inc.project_id=pj.project_id)
                  left JOIN helpdesk_priority pi ON (inc.priority_id=pi.priority_id)"
                  
                  
                ;
        $condition = " 1 = 1";
        
        if (strUtil::isNotEmpty($criterai["cus_company_id"])){
            $condition .= " and inc.cus_company_id =  " .$criterai["cus_company_id"] ;
        }
        if (strUtil::isNotEmpty($criterai["start"]) && strUtil::isNotEmpty($criterai["end"])){
            $condition .= " and DATE(inc.create_date) between  '{$criterai["start"]}' and '{$criterai["end"]}' ";
        }
        if(strUtil::isNotEmpty($criterai["ident_type_id"]) && strUtil::isEmpty($criterai["ident_type_id_l"])){
            $condition .= " and inc.ident_type_id = '{$criterai["ident_type_id"]}' ";
        }
        if(strUtil::isNotEmpty($criterai["ident_type_id"]) && strUtil::isNotEmpty($criterai["ident_type_id_l"])){
            $condition .= " and inc.ident_type_id between {$criterai["ident_type_id"]} and {$criterai["ident_type_id_l"]}";
        }
        if(strUtil::isNotEmpty($criterai["status_id"]) && strUtil::isEmpty($criterai["status_id_l"])){
            $condition .= " and inc.status_id = '{$criterai["status_id"]}' ";
        }
        if(strUtil::isNotEmpty($criterai["status_id"]) && strUtil::isNotEmpty($criterai["status_id_l"])){
            $condition .= " and inc.status_id between '{$criterai["status_id"]}' and '{$criterai["status_id_l"]}'";
        }
        if(strUtil::isNotEmpty($criterai["customer_zone_id"]) && strUtil::isEmpty($criterai["customer_zone_id_l"])){
            $condition .= " and z.zone_id = '{$criterai["customer_zone_id"]}' ";
        }
        if(strUtil::isNotEmpty($criterai["customer_zone_id"]) && strUtil::isNotEmpty($criterai["customer_zone_id_l"])){
            $condition .= " and z.zone_id between '{$criterai["customer_zone_id"]}' and '{$criterai["customer_zone_id_l"]}'";
        }
        if(strUtil::isNotEmpty($criterai["owner"])){
            $condition .= " and  CONCAT(REPLACE(us.first_name,' ','' ),REPLACE(us.last_name,' ','' )) like '%{$criterai["owner"]}%' ";
        }
        if(strUtil::isNotEmpty($criterai["resolved"])){
            $condition .= " and  CONCAT(REPLACE(us_re.first_name,' ','' ),REPLACE(us_re.last_name,' ','' )) like '%{$criterai["resolved"]}%' ";
        }
        if(strUtil::isNotEmpty($criterai["reference_from"]) && strUtil::isNotEmpty($criterai["reference_to"])){
            $condition .= " and inc.reference_no between '{$criterai["reference_from"]}' and '{$criterai["reference_to"]}'  ";
        }  
        if (strUtil::isNotEmpty($criterai["project_id"])){
            $condition .= " and inc.project_id =  " .$criterai["project_id"] ;
        }
		$condition .= " order by inc.ident_id_run_project_id asc";
		
        $total_row = $this->db->count_rows($table, $condition);
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0){
            return 0;
        }
        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row" => $total_row
            , "arr_criteria" => $arr_criteria
       );
        
    }
    
    
    
}

?>
