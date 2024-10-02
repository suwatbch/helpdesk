<?php
include_once "model.class.php";

class report_aging_detail extends model {
   
    
   public function getReportDetail($criterai,$prd1,$prd2,$prd3,$show_to_customer){
        global $page_size;
        
        $field = "inc.*,t.ident_type_desc,z.name as s_cus_area,CONCAT(us.first_name,' ',us.last_name) as name_owner,
            st.status_desc,str.status_res_desc,DATEDIFF('{$criterai["inc_date"]}',inc.create_date) as total_date";
        $table = "helpdesk_tr_incident inc
                  left join helpdesk_incident_type t on(inc.ident_type_id=t.ident_type_id)
                  left join helpdesk_cus_zone_area ca on(inc.cus_area=ca.area_cus)
                  left join helpdesk_user us on(inc.owner_user_id=us.user_id)
                  left join helpdesk_status st on(inc.status_id=st.status_id)
                  left join helpdesk_status_res str on(inc.status_res_id=str.status_res_id)
                  left join helpdesk_cus_zone z on(ca.zone_id=z.zone_id)
        ";
        
        $condition = " 1 = 1 and inc.status_id <> 7  ";
        
        if (strUtil::isNotEmpty($criterai["cus_company_id"])){
            $condition .= " and inc.cus_company_id =  " .$criterai["cus_company_id"] ;
        }
        if (strUtil::isNotEmpty($criterai["project_id"])){
            $condition .= " and inc.project_id =  " .$criterai["project_id"] ;
        }
//        if (strUtil::isNotEmpty($criterai["inc_date"])){
//            $condition .= " and DATE(inc.create_date) = '{$criterai["inc_date"]}' ";
//        }
        if(strUtil::isNotEmpty($criterai["customer_zone_id"]) && strUtil::isEmpty($criterai["customer_zone_id_l"])){
            $condition .= " and z.zone_id = '{$criterai["customer_zone_id"]}' ";
        }
        if(strUtil::isNotEmpty($criterai["customer_zone_id"]) && strUtil::isNotEmpty($criterai["customer_zone_id_l"])){
            $condition .= " and z.zone_id between {$criterai["customer_zone_id"]} and {$criterai["customer_zone_id_l"]}";
        }
        if(strUtil::isNotEmpty($prd1)){
           // $condition .= " and inc.cas_prd_tier_id1 = '{$prd1}'";
            $condition .= " and (case when ifnull(inc.resol_prdtier1,0) <> 0 then ifnull(inc.resol_prdtier1,0)
                               else ifnull(inc.cas_prd_tier_id1,0) end)  = '{$prd1}'";
        }
        if(strUtil::isNotEmpty($prd2)){
           // $condition .= " and inc.cas_prd_tier_id2 = '{$prd2}'";
            $condition .= " and (case when ifnull(inc.resol_prdtier2,0) <> 0 then ifnull(inc.resol_prdtier2,0)
                               else ifnull(inc.cas_prd_tier_id2,0) end)  = '{$prd2}'";
        }
        if(strUtil::isNotEmpty($prd3)){
            //$condition .= " and inc.cas_prd_tier_id3 = '{$prd3}'";
            $condition .= " and (case when ifnull(inc.resol_prdtier3,0) <> 0 then ifnull(inc.resol_prdtier3,0)
                               else ifnull(inc.cas_prd_tier_id3,0) end)  = '{$prd3}'";
        }
        if($show_to_customer == 'Y'){
            $condition .= " and t.display_report = 1";
        }
        
        $condition .= " order by DATEDIFF('{$criterai["inc_date"]}',inc.create_date) desc,inc.ident_id_run_project asc";
       
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
    public function get_aging(){
        $field = "*";
        $table = "helpdesk_vlookup ";
        $condition = "1=1 order by value asc";
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);
        if ($rows == 0){
            return 0;
        }
        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row_aging" => $rows
            , "arr_aging" => $arr_criteria
            
       );
    }
    
    public function get_product_class($criterai){
        $field = "prd2.prd_tier_name as prd_name3, prd3.prd_tier_name as prd_name1, prd4.prd_tier_name as prd_name2, prd2.prd_tier_id as prd_id3, prd3.prd_tier_id as prd_id1, prd4.prd_tier_id as prd_id2";
        $table = "helpdesk_tr_prd_tier prd1
                  left join helpdesk_prd_tier prd2 on(prd1.prd_tier_lv3_id = prd2.prd_tier_id)
                  left join helpdesk_prd_tier prd3 on(prd1.prd_tier_lv1_id = prd3.prd_tier_id)
                  left join helpdesk_prd_tier prd4 on(prd1.prd_tier_lv2_id = prd4.prd_tier_id)";
        $condition = "prd1.cus_company_id = '{$criterai["cus_company_id"]}'";
        if(strUtil::isNotEmpty($criterai["prd_tier_id3"]) && strUtil::isEmpty($criterai["prd_tier_id3_l"])){
            $condition .= " and prd2.prd_tier_name = '{$criterai["prd_tier_id3"]}' and prd2.prd_tier_level ='3'";
        }
        if(strUtil::isNotEmpty($criterai["prd_tier_id3"]) && strUtil::isNotEmpty($criterai["prd_tier_id3_l"])){
            $condition .= " and prd2.prd_tier_name between '{$criterai["prd_tier_id3"]}' and '{$criterai["prd_tier_id3_l"]}' and prd2.prd_tier_level ='3'";
        }
        $condition .= "order by prd3.prd_tier_name asc,prd2.prd_tier_name asc,prd4.prd_tier_name asc";
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);
        if ($rows == 0){
            return 0;
        }
        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row_product_class" => $rows
            , "arr_product_class" => $arr_criteria
       );
    }
      
    
}

?>
