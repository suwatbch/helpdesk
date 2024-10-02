<?php
include_once "model.class.php";
//include_once "../util/dateUtil.class.php";
//include_once '../db/mysql.class.php';

class report extends model {

    public function getsearchdate_monthly($cus_comp_id){

        $sql = "SELECT DISTINCT DATE_FORMAT( startdate,  '%d-%m-%Y' ) AS startdate, DATE_FORMAT( enddate,  '%d-%m-%Y' ) AS enddate, 
            CONCAT( DATE_FORMAT( startdate,  '%d-%m-%Y' ) ,  ',', DATE_FORMAT( enddate,  '%d-%m-%Y' ) ) AS fulldate, 
            displaydate, startdate AS startdate_asc
            FROM (  SELECT DISTINCT DATE( startdate ) AS startdate, DATE( enddate ) AS enddate,  '' AS displaydate
                    FROM helpdesk_th_report
                    WHERE IFNULL( del, 0 ) <>1 and ifnull(cus_company_id,0) = $cus_comp_id 
                    UNION SELECT CONCAT( YEAR( ADDDATE( NOW( ) , INTERVAL -2
                    MONTH ) ) ,  '-', LPAD( MONTH( ADDDATE( NOW( ) , INTERVAL -2
                    MONTH ) ) , 2, 0 ) ,  '-22' ) AS startdate, CONCAT( YEAR( ADDDATE( NOW( ) , INTERVAL -1
                    MONTH ) ) ,  '-', LPAD( MONTH( ADDDATE( NOW( ) , INTERVAL -1
                    MONTH ) ) , 2, 0 ) ,  '-21' ) AS enddate,  '' AS displaydate
                    UNION SELECT CONCAT( YEAR( ADDDATE( NOW( ) , INTERVAL -1
                    MONTH ) ) ,  '-', LPAD( MONTH( ADDDATE( NOW( ) , INTERVAL -1
                    MONTH ) ) , 2, 0 ) ,  '-22' ) AS startdate, CONCAT( YEAR( NOW( ) ) ,  '-', LPAD( MONTH( NOW( ) ) , 2, 0 ) ,  '-21' ) AS enddate,  '' AS displaydate
                    UNION SELECT CONCAT( YEAR( NOW( ) ) ,  '-', LPAD( MONTH( NOW( ) ) , 2, 0 ) ,  '-22' ) AS startdate, CONCAT( YEAR( ADDDATE( NOW( ) , INTERVAL 1
                    MONTH ) ) ,  '-', LPAD( MONTH( ADDDATE( NOW( ) , INTERVAL 1
                    MONTH ) ) , 2, 0 ) ,  '-21' ) AS enddate,  '' AS displaydate
                    )c
            ORDER BY startdate_asc";

        $result = $this->db->query($sql);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return null;

        while($row = $this->db->fetch_array($result)){
//            $date_text[] = split($row["fulldate"],",");
//            $dp_date = $this->thai_date_ddmmyyyy($date_text[0]) . " - " . $this->thai_date_ddmmyyyy($date_text[1]);
//            $arr[]["val"] = $row["fulldate"];
//            $arr[]["name"] = $row["fulldate"];
            $arr[] = $row;
        }

        return $arr;

    }

    public function thai_date_ddmmyyyy($date){  // dd-mm-YYYY
        $thai_month_arr=array(
            "0"=>"",
            "1"=>"มกราคม",
            "2"=>"กุมภาพันธ์",
            "3"=>"มีนาคม",
            "4"=>"เมษายน",
            "5"=>"พฤษภาคม",
            "6"=>"มิถุนายน",
            "7"=>"กรกฎาคม",
            "8"=>"สิงหาคม",
            "9"=>"กันยายน",
            "10"=>"ตุลาคม",
            "11"=>"พฤศจิกายน",
            "12"=>"ธันวาคม"
        );

        $y = substr($date,6,4);
        $m = substr($date,3,2);
        $d = substr($date,0,2);

        $y = (int)$y + 543; //convert to พ.ศ.
        $m = (int)$m;
        $d = (int)$d;

        $thai_date_return.= "วันที่ $d ".$thai_month_arr["$m"]. " พ.ศ. $y";
        return $thai_date_return;
    }



    public function getCriteria($type){
        global $page_size;

        $field = "*";
        $table = " helpdesk_vlookup";
        if ($type){
            $condition = " type = '$type' ";
        }

        $condition .= " order by type,item ";

        $total_row = $this->db->count_rows($table, $condition);
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();

        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row" => $total_row
        , "arr_criteria" => $arr_criteria
        );
    }



    public function aging_getProdClassCurrent($comp_id, $start_date,$class3_fr, $class3_to,$project_id , $display_inc){

        if (strUtil::isNotEmpty($class3_fr) && strUtil::isNotEmpty($class3_to)){
            $tb_class3 = " (SELECT *
                            FROM `helpdesk_prd_tier`
                            WHERE `prd_tier_level` = 3
                            AND `prd_tier_name`
                            BETWEEN '$class3_fr'
                            AND '$class3_to' ) ";
        }else{
            $tb_class3 = " helpdesk_prd_tier ";

        }


        if (strUtil::isNotEmpty($class3_fr) && strUtil::isNotEmpty($class3_to)){
            $tb_class3 = "Inner Join (SELECT *
                            FROM `helpdesk_prd_tier`
                            WHERE `prd_tier_level` = 3
                            AND `prd_tier_name`
                            BETWEEN '$class3_fr'
                            AND '$class3_to' ) ";
        }else{
            $tb_class3 = "Left Join helpdesk_prd_tier ";

        }
        $sql = "select  distinct  IFNULL(i.ident_type_id,0) as inc_type_id ,  IFNULL(t.ident_type_desc,0) as inc_type_name,  
                IFNULL(`prd_tier_id1`,0) as class1_id, IFNULL(c1.prd_tier_name,'') as class1_name, 
                IFNULL( `prd_tier_id2`,0) as class2_id,IFNULL( c2.prd_tier_name,'') as class2_name, 
                IFNULL( `prd_tier_id3`,0) as class3_id,IFNULL( c3.prd_tier_name,'') as class3_name
                from    ( select * , 
                          case when ifnull(resol_prdtier1,0) <> 0 then ifnull(resol_prdtier1,0)
                               else ifnull(cas_prd_tier_id1,0) end as  prd_tier_id1 ,
                          case when ifnull(resol_prdtier2,0) <> 0 then ifnull(resol_prdtier2,0)
                               else ifnull(cas_prd_tier_id2,0) end as  prd_tier_id2 ,     
                          case when ifnull(resol_prdtier3,0) <> 0 then ifnull(resol_prdtier3,0)
                               else ifnull(cas_prd_tier_id3,0) end as  prd_tier_id3
                         from helpdesk_tr_incident
                         where ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc))) i 
                inner Join  helpdesk_incident_type t on i. ident_type_id = t. ident_type_id
                Left Join  helpdesk_prd_tier c1 on c1.prd_tier_id = i.prd_tier_id1
                Left Join  helpdesk_prd_tier c2 on c2.prd_tier_id = i.prd_tier_id2
                $tb_class3 c3 on c3.prd_tier_id = i.prd_tier_id3
                where i.cus_company_id = $comp_id and ifnull(i.project_id,'0') = '$project_id' 
                    and ifnull(i.status_id,0) <> 7 and DATE(i.create_date) <= '$start_date'
                    
                order by   t.ident_type_desc, c1.prd_tier_name,c2.prd_tier_name, c3.prd_tier_name ";

//        $sql = "select distinct  IFNULL(i.ident_type_id,0) as inc_type_id ,  IFNULL(t.ident_type_desc,0) as inc_type_name,
//                IFNULL(`prd_tier_id1`,0) as class1_id, IFNULL(c1.prd_tier_name,'') as class1_name, 
//                IFNULL( `prd_tier_id2`,0) as class2_id,IFNULL( c2.prd_tier_name,'') as class2_name, 
//                IFNULL( `prd_tier_id3`,0) as class3_id,IFNULL( c3.prd_tier_name,'') as class3_name
//                from    ( select * , 
//                          case when ifnull(resol_prdtier1,0) <> 0 then ifnull(resol_prdtier1,0)
//                               else ifnull(cas_prd_tier_id1,0) end as  prd_tier_id1 ,
//                          case when ifnull(resol_prdtier2,0) <> 0 then ifnull(resol_prdtier2,0)
//                               else ifnull(cas_prd_tier_id2,0) end as  prd_tier_id2 ,     
//                          case when ifnull(resol_prdtier3,0) <> 0 then ifnull(resol_prdtier3,0)
//                               else ifnull(cas_prd_tier_id3,0) end as  prd_tier_id3
//                         from helpdesk_tr_incident
//                         where cus_company_id = $comp_id
//                         and status_id <> 7
//                         and DATE(create_date) <= '$start_date') i 
//                inner Join  helpdesk_incident_type t on i. ident_type_id = t. ident_type_id
//                Left Join  helpdesk_prd_tier c1 on c1.prd_tier_id = i.prd_tier_id1
//                Left Join  helpdesk_prd_tier c2 on c2.prd_tier_id = i.prd_tier_id2
//                Left Join  $tb_class3 c3 on c3.prd_tier_id = i.prd_tier_id3
//                and IFNULL( c3.prd_tier_name,'') <> '' and IFNULL( `prd_tier_id3`,0)
//                order by   t.ident_type_desc, c1.prd_tier_name, c2.prd_tier_name , c2.prd_tier_name.";


        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) return array();

        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row" => $total_row
        , "data" => $arr_criteria
        );
    }



    public function aging_countIncident_byage($criterai){
        global $page_size;

        $field = " id ";
        $table = " helpdesk_tr_incident i ";

        $condition = " status_id <> 7 ";

        if (strUtil::isNotEmpty($criterai["company_id"])){
            $condition .= " and cus_company_id =  " .$criterai["company_id"] ;
        }

        if (strUtil::isNotEmpty($criterai["project_id"])){
            $condition .= " and project_id = " .$criterai["project_id"] ;
        }

        if (strUtil::isNotEmpty($criterai["start_date"]) ){
            $condition .= " and DATE(create_date) <=  '" .$criterai["start_date"]. "' " ;
//            $condition .= " and '" .$criterai["end_date"]. "' " ;
        }

        if (strUtil::isNotEmpty($criterai["inc_type_id"])){
            $condition .= " and ident_type_id  =  " .$criterai["inc_type_id"] ;
        }

        if  (strUtil::isNotEmpty($criterai["display_inc"])){
            $condition .= " and ident_type_id  in  (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ({$criterai["display_inc"]}) ) " ;
        }


        if (strUtil::isNotEmpty($criterai["class1_id"])){
            $condition .= " and (case when ifnull(resol_prdtier1,0) <> 0 then ifnull(resol_prdtier1,0)
                               else ifnull(cas_prd_tier_id1,0) end)  =  " .$criterai["class1_id"] ;
        }

        if (strUtil::isNotEmpty($criterai["class2_id"])){
            $condition .= " and (case when ifnull(resol_prdtier2,0) <> 0 then ifnull(resol_prdtier2,0)
                               else ifnull(cas_prd_tier_id2,0) end)  =  " .$criterai["class2_id"] ;
        }

        if (strUtil::isNotEmpty($criterai["class3_id"])){
            $condition .= " and (case when ifnull(resol_prdtier3,0) <> 0 then ifnull(resol_prdtier3,0)
                               else ifnull(cas_prd_tier_id3,0) end)  =  " .$criterai["class3_id"] ;
        }

        //status = closed   datediff(closed_date,created_date)
        //non closed datediff(today,created_date)
        if (strUtil::isNotEmpty($criterai["value_min"])){
            $condition .= " and datediff(NOW(), create_date)  >=  " .$criterai["value_min"] ;
        }

        if (strUtil::isNotEmpty($criterai["value_max"])){
            $condition .= " and datediff(NOW(), create_date)  < " .$criterai["value_max"] ;
//            $condition .= " and (case IFNULL(status_id,0)
//                                    when 7 then  datediff(closed_date, create_date)
//                                    else datediff(NOW(), create_date) end )  <  " .$criterai["value_max"] ;
        }


        $total_row = $this->db->count_rows($table, $condition);
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0){
            return 0;
        }else{
            return $total_row;
        };

//        while($row = $this->db->fetch_array($result)){
//            $arr_criteria[] = $row;
//        }
//
//        return array(
//            "total_row" => $total_row
//            , "arr_criteria" => $arr_criteria
//        );

    }



    public function out_getProdClassCurrent($comp_id,$class3_fr, $class3_to,$project_id,$display_inc){


        if (strUtil::isNotEmpty($class3_fr) && strUtil::isNotEmpty($class3_to)){
            $tb_class3 = " (SELECT *
                            FROM `helpdesk_prd_tier`
                            WHERE `prd_tier_level` = 3
                            AND `prd_tier_name`
                            BETWEEN '$class3_fr'
                            AND '$class3_to' ) ";
        }else{
            $tb_class3 = " helpdesk_prd_tier ";

        }
        $sql = "select  distinct
                IFNULL(`prd_tier_id1`,0) as class1_id, IFNULL(c1.prd_tier_name,'') as class1_name, 
                IFNULL( `prd_tier_id2`,0) as class2_id,IFNULL( c2.prd_tier_name,'') as class2_name, 
                IFNULL( `prd_tier_id3`,0) as class3_id,IFNULL( c3.prd_tier_name,'') as class3_name
                from    ( select * , 
                          case when ifnull(resol_prdtier1,0) <> 0 then ifnull(resol_prdtier1,0)
                               else ifnull(cas_prd_tier_id1,0) end as  prd_tier_id1 ,
                          case when ifnull(resol_prdtier2,0) <> 0 then ifnull(resol_prdtier2,0)
                               else ifnull(cas_prd_tier_id2,0) end as  prd_tier_id2 ,     
                          case when ifnull(resol_prdtier3,0) <> 0 then ifnull(resol_prdtier3,0)
                               else ifnull(cas_prd_tier_id3,0) end as  prd_tier_id3
                         from helpdesk_tr_incident
                         where ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ) i 
                
                inner Join  helpdesk_prd_tier c1 on c1.prd_tier_id = i.prd_tier_id1
                inner Join  helpdesk_prd_tier c2 on c2.prd_tier_id = i.prd_tier_id2
                inner Join  $tb_class3 c3 on c3.prd_tier_id = i.prd_tier_id3
                where i.cus_company_id = $comp_id and i.project_id = '$project_id' 
                order by   c1.prd_tier_name,c2.prd_tier_name, c3.prd_tier_name";


        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) return array();

        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row" => $total_row
        , "data" => $arr_criteria
        );
    }


    public function out_balanceforward($comp_id,$date,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){

        // Incident ที่เปิดก่อนวันที่ X 
        // และปิดตั้งแต่วันที่ X เป็นต้นไป

        $sql = "select distinct i.id
            from helpdesk_tr_incident i
            Left Join `helpdesk_cus_zone_area` `zarea` on `zarea`.`area_cus` = `i`.`cus_area`
            Left Join `helpdesk_cus_zone` `z` on `z`.`zone_id` = `zarea`.`zone_id`
            where DATE(i.create_date) < '$date'
            and ( DATE(i.closed_date) >= '$date' or DATE(i.closed_date) = '0000-00-00')
            and i.cus_company_id = $comp_id and i.project_id = '$project_id' 
            and (case when ifnull(i.resol_prdtier1,0) <> 0 then ifnull(i.resol_prdtier1,0)
                               else ifnull(i.cas_prd_tier_id1,0) end) = $class1
            and (case when ifnull(i.resol_prdtier2,0) <> 0 then ifnull(i.resol_prdtier2,0)
                               else ifnull(i.cas_prd_tier_id2,0) end) = $class2
            and (case when ifnull(i.resol_prdtier3,0) <> 0 then ifnull(i.resol_prdtier3,0)
                               else ifnull(i.cas_prd_tier_id3,0) end) = $class3 
            and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ";

        if (strUtil::isNotEmpty($zone_fr) && strUtil::isNotEmpty($zone_to)){
            $sql .= " AND ifnull(`z`.`item`,0) between $zone_fr and $zone_to ";
        }


        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }

    }

    public function out_open($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
        $sql = "select distinct i.id
            from helpdesk_tr_incident i
            Left Join `helpdesk_cus_zone_area` `zarea` on `zarea`.`area_cus` = `i`.`cus_area`
            Left Join `helpdesk_cus_zone` `z` on `z`.`zone_id` = `zarea`.`zone_id`
            where DATE(i.create_date) between '$sdate' and '$edate'  
            and i.cus_company_id = $comp_id and i.project_id = '$project_id'
            and (case when ifnull(i.resol_prdtier1,0) <> 0 then ifnull(i.resol_prdtier1,0)
                               else ifnull(i.cas_prd_tier_id1,0) end) = $class1
            and (case when ifnull(i.resol_prdtier2,0) <> 0 then ifnull(i.resol_prdtier2,0)
                               else ifnull(i.cas_prd_tier_id2,0) end) = $class2
            and (case when ifnull(i.resol_prdtier3,0) <> 0 then ifnull(i.resol_prdtier3,0)
                               else ifnull(i.cas_prd_tier_id3,0) end) = $class3 
            and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ";

        if (strUtil::isNotEmpty($zone_fr) && strUtil::isNotEmpty($zone_to)){
            $sql .= " AND ifnull(item,0) between $zone_fr and $zone_to ";
        }

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }

    }

    public function out_closed_complete($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
        $sql = "select distinct i.id
            from helpdesk_tr_incident i
            Left Join `helpdesk_cus_zone_area` `zarea` on `zarea`.`area_cus` = `i`.`cus_area`
            Left Join `helpdesk_cus_zone` `z` on `z`.`zone_id` = `zarea`.`zone_id`
            where DATE(i.closed_date) between '$sdate' and '$edate'
            and i.cus_company_id = $comp_id and i.project_id = '$project_id'
            and (case when ifnull(i.resol_prdtier1,0) <> 0 then ifnull(i.resol_prdtier1,0)
                               else ifnull(i.cas_prd_tier_id1,0) end) = $class1
            and (case when ifnull(i.resol_prdtier2,0) <> 0 then ifnull(i.resol_prdtier2,0)
                               else ifnull(i.cas_prd_tier_id2,0) end) = $class2
            and (case when ifnull(i.resol_prdtier3,0) <> 0 then ifnull(i.resol_prdtier3,0)
                               else ifnull(i.cas_prd_tier_id3,0) end) = $class3
            and status_res_id in (6,10,14) 
            and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ";

        if (strUtil::isNotEmpty($zone_fr) && strUtil::isNotEmpty($zone_to)){
            $sql .= " AND ifnull(item,0) between $zone_fr and $zone_to ";
        }

//        echo $sql;
//        exit();

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }
    }


    public function out_closed_cancel($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
        $sql = "select distinct i.id
            from helpdesk_tr_incident i
            Left Join `helpdesk_cus_zone_area` `zarea` on `zarea`.`area_cus` = `i`.`cus_area`
            Left Join `helpdesk_cus_zone` `z` on `z`.`zone_id` = `zarea`.`zone_id`
            where DATE(i.closed_date) between '$sdate' and '$edate'  
            and i.cus_company_id = $comp_id and i.project_id = '$project_id'
            and (case when ifnull(i.resol_prdtier1,0) <> 0 then ifnull(i.resol_prdtier1,0)
                               else ifnull(i.cas_prd_tier_id1,0) end) = $class1
            and (case when ifnull(i.resol_prdtier2,0) <> 0 then ifnull(i.resol_prdtier2,0)
                               else ifnull(i.cas_prd_tier_id2,0) end) = $class2
            and (case when ifnull(i.resol_prdtier3,0) <> 0 then ifnull(i.resol_prdtier3,0)
                               else ifnull(i.cas_prd_tier_id3,0) end) = $class3
            and status_res_id in ( 8,12,16) 
            and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ";

        if (strUtil::isNotEmpty($zone_fr) && strUtil::isNotEmpty($zone_to)){
            $sql .= " AND ifnull(item,0) between $zone_fr and $zone_to ";
        }

//        echo $sql;
//        exit();

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }
    }


    public function out_closed_nocontact($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
        $sql = "select distinct i.id
            from helpdesk_tr_incident i
            Left Join `helpdesk_cus_zone_area` `zarea` on `zarea`.`area_cus` = `i`.`cus_area`
            Left Join `helpdesk_cus_zone` `z` on `z`.`zone_id` = `zarea`.`zone_id`
            where DATE(i.closed_date) between '$sdate' and '$edate'  
            and i.cus_company_id = $comp_id and i.project_id = '$project_id'
            and (case when ifnull(i.resol_prdtier1,0) <> 0 then ifnull(i.resol_prdtier1,0)
                               else ifnull(i.cas_prd_tier_id1,0) end) = $class1
            and (case when ifnull(i.resol_prdtier2,0) <> 0 then ifnull(i.resol_prdtier2,0)
                               else ifnull(i.cas_prd_tier_id2,0) end) = $class2
            and (case when ifnull(i.resol_prdtier3,0) <> 0 then ifnull(i.resol_prdtier3,0)
                               else ifnull(i.cas_prd_tier_id3,0) end) = $class3
            and status_res_id in (5,9,13) 
            and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ";

        if (strUtil::isNotEmpty($zone_fr) && strUtil::isNotEmpty($zone_to)){
            $sql .= " AND ifnull(item,0) between $zone_fr and $zone_to ";
        }

//        echo $sql;
//        exit();

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }
    }

    public function out_outst_status($comp_id,$sdate,$edate,$class1,$class2,$class3,$status,$zone_fr,$zone_to,$project_id,$display_inc){
        /*and status_id = $status*/
        /* $status :   N:new , A:assign , W:working , P:pending , R:resolved , PP: propose closed*/
        $sql = " . select distinct i.id
            from helpdesk_tr_incident i
            Left Join `helpdesk_cus_zone_area` `zarea` on `zarea`.`area_cus` = `i`.`cus_area`
            Left Join `helpdesk_cus_zone` `z` on `z`.`zone_id` = `zarea`.`zone_id`
            where DATE(i.create_date) <= '$edate' and DATE(i.closed_date) > '$edate'
            and i.cus_company_id = $comp_id and i.project_id = '$project_id' 
            and (case when ifnull(i.resol_prdtier1,0) <> 0 then ifnull(i.resol_prdtier1,0)
                               else ifnull(i.cas_prd_tier_id1,0) end) = $class1
            and (case when ifnull(i.resol_prdtier2,0) <> 0 then ifnull(i.resol_prdtier2,0)
                               else ifnull(i.cas_prd_tier_id2,0) end) = $class2
            and (case when ifnull(i.resol_prdtier3,0) <> 0 then ifnull(i.resol_prdtier3,0)
                               else ifnull(i.cas_prd_tier_id3,0) end) = $class3
            and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) 
            and (case
                when DATE(i.assigned_date) <= '$edate' then 'A'
                when DATE(i.propose_closed_date) <= '$edate' then 'PP' 
                when DATE(i.resolved_date) <= '$edate' then 'R' 
                when DATE(i.working_date) <= '$edate' then 'W'
                Else 'N' END) = '$status'  ";

        if (strUtil::isNotEmpty($zone_fr) && strUtil::isNotEmpty($zone_to)){
            $sql .= " AND ifnull(item,0) between $zone_fr and $zone_to ";
        }

        echo $sql;
//        exit();

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }
    }


    public function getcustomerzone($comp_id){
        global $page_size;
//        SELECT * FROM `helpdesk_cus_zone`
//        where ifnull(del,0) <> 1
//        and cus_company_id  = 1
//        order by item

        $field = "* , CONCAT( item,  '-', name ) AS display_name";
        $table = " helpdesk_cus_zone";
        $condition = " ifnull(del,0) <> 1  ";

        if (strUtil::isNotEmpty($comp_id)){
            $condition .= " and cus_company_id = $comp_id ";
        }

        $condition .= " order by item ";

        $total_row = $this->db->count_rows($table, $condition);
        $result = $this->db->select($field, $table, $condition);
        $rows = $this->db->num_rows($result);

        if ($rows == 0) return array();

        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row" => $total_row
        , "arr_criteria" => $arr_criteria
        );
    }

    public function countincident_bytype_zone($comp_id, $inctype_id, $sdate, $edate,$zone_id, $project_id,$display_inc){
        $sql = "SELECT distinct i.id 
            FROM helpdesk_tr_incident i
            INNER JOIN helpdesk_cus_zone_area z ON z.area_cus = i.cus_area
            WHERE cus_company_id = $comp_id 
            AND ident_type_id = $inctype_id
            AND DATE(create_date) BETWEEN  '$sdate' AND  '$edate'
            AND z.zone_id = $zone_id 
            AND i.project_id = '$project_id'
            and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ";

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }
    }


    public function countincident_bytype_zone_class3($comp_id, $inctype_id, $class3_id, $sdate, $edate,$zone_id,$project_id,$display_inc){
        $sql = "SELECT distinct i.id 
            FROM helpdesk_tr_incident i
            INNER JOIN helpdesk_cus_zone_area z ON z.area_cus = i.cus_area
            WHERE cus_company_id = $comp_id 
            AND ident_type_id = $inctype_id
            AND DATE(create_date) BETWEEN  '$sdate' AND  '$edate'
            AND z.zone_id = $zone_id 
            AND (CASE WHEN IFNULL( resol_prdtier3, 0 ) <>0 THEN IFNULL( resol_prdtier3, 0 ) 
                    ELSE IFNULL( cas_prd_tier_id3, 0 ) 
                    END) = $class3_id 
            AND i.project_id = '$project_id' 
            and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) ";

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }
    }




    public function chkexists_report($id){
        $sql = " select 1 from helpdesk_th_report where id = $id";

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }
    }

    public function insert_rpt_header(&$value){

        $report_type_id = (strUtil::isEmpty($value["report_type_id"])) ? "" : $value["report_type_id"];
        $cus_company_id = (strUtil::isEmpty($value["cus_company_id"])) ? "" : $value["cus_company_id"];
        $startdate = (strUtil::isEmpty($value["start_date"])) ? "" : $value["start_date"];
        $enddate = (strUtil::isEmpty($value["end_date"])) ? "" : $value["end_date"];
        $response_id = (strUtil::isEmpty($value["response_id"])) ? "" : $value["response_id"];
        $user_id = (strUtil::isEmpty($value["user_id"])) ? "" : $value["user_id"];
        $final = (strUtil::isEmpty($value["final"])) ? "" : $value["final"];
        $project = (strUtil::isEmpty($value["project_id"])) ? "0" : $value["project_id"];

        $table = " helpdesk_th_report";
        $field = " del,final , report_type_id, cus_company_id, startdate, enddate"
            . ", response_id, response_date, created_date, created_by, modify_date, modify_by"
            . ", text1, text2, text3, text4, text5, text6"
            . ", text7, text8, text9, text10, text11, text12"
            . ", text13, text14, text15, text16, text17, text18 , project_id "
            . ", BPM_text1, BPM_text2, BPM_text3, BPM_text4, BPM_text5, BPM_text6"
            . ", BPM_text7, BPM_text8, BPM_text9, BPM_text10, BPM_text11, BPM_text12"
            . ", BPM_text13, BPM_text14, BPM_text15, BPM_text16, BPM_text17, BPM_text18 ";
        $data = " 0, '$final' ,$report_type_id, $cus_company_id , '$startdate','$enddate',"
            . " $response_id, NOW(), NOW(), $user_id, NOW(), $user_id"
            . " , '{$value["text1"]}', '{$value["text2"]}', '{$value["text3"]}', '{$value["text4"]}', '{$value["text5"]}', '{$value["text6"]}'"
            . " , '{$value["text7"]}', '{$value["text8"]}', '{$value["text9"]}', '{$value["text10"]}', '{$value["text11"]}', '{$value["text12"]}'"
            . " , '{$value["text13"]}', '{$value["text14"]}', '{$value["text15"]}', '{$value["text16"]}', '{$value["text17"]}', '{$value["text18"]}' "
            . " , '$project'"
            . " , '{$value["BPM_text1"]}', '{$value["BPM_text2"]}', '{$value["BPM_text3"]}', '{$value["BPM_text4"]}', '{$value["BPM_text5"]}', '{$value["BPM_text6"]}'"
            . " , '{$value["BPM_text7"]}', '{$value["BPM_text8"]}', '{$value["BPM_text9"]}', '{$value["BPM_text10"]}', '{$value["BPM_text11"]}', '{$value["BPM_text12"]}'"
            . " , '{$value["BPM_text13"]}', '{$value["BPM_text14"]}', '{$value["BPM_text15"]}', '{$value["BPM_text16"]}', '{$value["BPM_text17"]}', '{$value["BPM_text18"]}' " ;
//       echo $table."  ";
//       echo $field . " ";
//       echo $data . " ";
//       exit();

//       exit();
        $result = $this->db->insert($table, $field, $data);

        if ($result){
            $value["id"] = $this->db->insert_id();
        }

        return $result;



    }

    public function update_rpt_header($value){
        $id = (strUtil::isEmpty($value["id"])) ? 0 : $value["id"];
        if ($id != 0) {
            $response_id = (strUtil::isEmpty($value["response_id"])) ? "" : $value["response_id"];
            $user_id = (strUtil::isEmpty($value["user_id"])) ? "" : $value["user_id"];
            $final = (strUtil::isEmpty($value["final"])) ? "" : $value["final"];

            $table = " helpdesk_th_report";

            $data = " response_id = $response_id , response_date = NOW() ,modify_date = NOW(), modify_by = $user_id, "
                . " final = '$final' ,"
                . " text1 = '". $value["text1"] ."' ,"
                . " text2 = '". $value["text2"] ."' ,"
                . " text3 = '". $value["text3"] ."' ,"
                . " text4 = '". $value["text4"] ."' ,"
                . " text5 = '". $value["text5"] ."' ,"
                . " text6 = '". $value["text6"] ."' ,"
                . " text7 = '". $value["text7"] ."' ,"
                . " text8 = '". $value["text8"] ."' ,"
                . " text9 = '". $value["text9"] ."' ,"
                . " text10 = '". $value["text10"] ."' ,"
                . " text11 = '". $value["text11"] ."' ,"
                . " text12 = '". $value["text12"] ."' ,"
                . " text13 = '". $value["text13"] ."' ,"
                . " text14 = '". $value["text14"] ."' ,"
                . " text15 = '". $value["text15"] ."' ,"
                . " text16 = '". $value["text16"] ."' ,"
                . " text17 = '". $value["text17"] ."' ,"
                . " text18 = '". $value["text18"] ."' ,"
                . " BPM_text1 = '". $value["BPM_text1"] ."' ,"
                . " BPM_text2 = '". $value["BPM_text2"] ."' ,"
                . " BPM_text3 = '". $value["BPM_text3"] ."' ,"
                . " BPM_text4 = '". $value["BPM_text4"] ."' ,"
                . " BPM_text5 = '". $value["BPM_text5"] ."' ,"
                . " BPM_text6 = '". $value["BPM_text6"] ."' ,"
                . " BPM_text7 = '". $value["BPM_text7"] ."' ,"
                . " BPM_text8 = '". $value["BPM_text8"] ."' ,"
                . " BPM_text9 = '". $value["BPM_text9"] ."' ,"
                . " BPM_text10 = '". $value["BPM_text10"] ."' ,"
                . " BPM_text11 = '". $value["BPM_text11"] ."' ,"
                . " BPM_text12 = '". $value["BPM_text12"] ."' ,"
                . " BPM_text13 = '". $value["BPM_text13"] ."' ,"
                . " BPM_text14 = '". $value["BPM_text14"] ."' ,"
                . " BPM_text15 = '". $value["BPM_text15"] ."' ,"
                . " BPM_text16 = '". $value["BPM_text16"] ."' ,"
                . " BPM_text17 = '". $value["BPM_text17"] ."' ,"
                . " BPM_text18 = '". $value["BPM_text18"] ."'  ";


            $condition = " id = $id ";

            $result = $this->db->update($table, $data, $condition);
            return $result;
        }
    }

    public function get_rptaddt_header($comp_id,$start_date,$end_date,$report_type_id,$project_id){
        $sql = "SELECT hd.* , CONCAT( u.first_name,  ' ', u.last_name ) AS response_full_name
            FROM helpdesk_th_report hd
            INNER JOIN helpdesk_user u ON u.user_id = hd.response_id
            WHERE u.cus_company_id = $comp_id
            AND startdate =  '$start_date'
            AND enddate =  '$end_date'
            AND hd.report_type_id = $report_type_id
            AND ifnull(project_id,0) = $project_id
            AND IFNULL( hd.del, 0 ) <>1
            ORDER BY id DESC 
            LIMIT 1 ";

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) return array();

        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row" => $total_row
        , "data" => $arr_criteria
        );

    }

    public function get_rptaddt_detail($report_id){

        $sql = "SELECT * 
            FROM  `helpdesk_td_report` 
            WHERE th_report_id = $report_id
            ORDER BY table_item, item ";

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) return array();

        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row" => $total_row
        , "data" => $arr_criteria
        );

    }

    public function chk_rpt_dup($comp_id, $start, $end){
        $sql = "select * from helpdesk_th_report
            where cus_company_id = $comp_id
            and ( (startdate < '$start' and enddate > '$start' )
                or (startdate < '$end' and enddate > '$end' ))";

        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) {
            return 0;
        }else {
            return $total_row;
        }


    }


    public function out_outst_all($comp_id,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
        /*and status_id = $status*/
        /* $status :   N:new , A:assign , W:working , P:pending , R:resolved , PP: propose closed*/
        $sql = " select i.id,p.pending_date,
            case 
            when i.propose_closed_date <> '0000-00-00 00:00:00'
                 and i.propose_closed_date >= IFNULL(p.pending_date,'0000-00-00 00:00:00')
                 and i.propose_closed_date >= IFNULL(wk.working_date,'0000-00-00 00:00:00') 
                 and i.propose_closed_date >= IFNULL(i.assigned_date,'0000-00-00 00:00:00') then 'PP'
            
            when IFNULL(p.pending_date,'0000-00-00 00:00:00') <> '0000-00-00 00:00:00'
                 and IFNULL(p.pending_date,'0000-00-00 00:00:00') > IFNULL(i.propose_closed_date,'0000-00-00 00:00:00')
                 and IFNULL(p.pending_date,'0000-00-00 00:00:00') >= IFNULL(wk.working_date,'0000-00-00 00:00:00') 
                 and IFNULL(p.pending_date,'0000-00-00 00:00:00') >= IFNULL(i.assigned_date,'0000-00-00 00:00:00') then 'P'
                 
            when i.resolved_date <> '0000-00-00 00:00:00' 
                 and i.resolved_date > IFNULL(i.propose_closed_date,'0000-00-00 00:00:00')
                 and i.resolved_date > IFNULL(p.pending_date,'0000-00-00 00:00:00') 
                 and i.resolved_date >= IFNULL(wk.working_date,'0000-00-00 00:00:00') 
                 and i.resolved_date >= IFNULL(i.assigned_date,'0000-00-00 00:00:00') then 'R'
                 
            when wk.working_date <> '0000-00-00 00:00:00' 
                 and wk.working_date > IFNULL(i.propose_closed_date,'0000-00-00 00:00:00')
                 and wk.working_date > IFNULL(i.resolved_date,'0000-00-00 00:00:00') 
                 and wk.working_date > IFNULL(p.pending_date,'0000-00-00 00:00:00') 
                 and wk.working_date >= IFNULL(i.assigned_date,'0000-00-00 00:00:00')then 'W'
                 
                 
                  
            when i.assigned_date <> '0000-00-00 00:00:00' 
                 and i.assigned_date > IFNULL(i.propose_closed_date,'0000-00-00 00:00:00')
                 and i.assigned_date > IFNULL(p.pending_date,'0000-00-00 00:00:00') 
                 and i.assigned_date > IFNULL(wk.working_date,'0000-00-00 00:00:00') then 'A'
            else 'N' end as status         
            from ( select 
                    i.id , i.cus_area, 
                    case when DATE(i.closed_date) <= '$edate' then i.closed_date
                            else '0000-00-00 00:00:00' end as closed_date, 
                            
                    case when DATE(i.resolved_date) <= '$edate' then i.resolved_date
                            else '0000-00-00 00:00:00' end as resolved_date, 
                            
                    case when DATE(i.propose_closed_date) <= '$edate' then  i.propose_closed_date
                            else '0000-00-00 00:00:00' end as propose_closed_date, 
                    
                    case when DATE(i.assigned_date_last) <> '0000-00-00' and DATE(i.assigned_date_last) <= '$edate' then i.assigned_date_last 
                            else (case when DATE(i.assigned_date) <= '$edate' then  i.assigned_date
                                      else '0000-00-00 00:00:00' end) end as assigned_date,
                    case when DATE(i.create_date) <= '$edate' then i.create_date
                            else '0000-00-00 00:00:00' end as create_date 
                    from helpdesk_tr_incident i   
                    where DATE(i.create_date) <= '$edate' and ( DATE(i.closed_date) > '$edate' or DATE(i.closed_date) = '0000-00-00')
                    and i.cus_company_id = $comp_id and i.project_id = '$project_id' 
                    and (case when ifnull(i.resol_prdtier1,0) <> 0 then ifnull(i.resol_prdtier1,0)
                                       else ifnull(i.cas_prd_tier_id1,0) end) = $class1
                    and (case when ifnull(i.resol_prdtier2,0) <> 0 then ifnull(i.resol_prdtier2,0)
                                       else ifnull(i.cas_prd_tier_id2,0) end) = $class2
                    and (case when ifnull(i.resol_prdtier3,0) <> 0 then ifnull(i.resol_prdtier3,0)
                                       else ifnull(i.cas_prd_tier_id3,0) end) = $class3
                    and ident_type_id in (SELECT  ident_type_id FROM  helpdesk_incident_type WHERE display_report in ($display_inc)) )i
            left join (SELECT incident_id, MAX( workinfo_date ) AS working_date
			FROM helpdesk_tr_workinfo
			WHERE DATE(workinfo_date) <= '$edate'
			GROUP BY incident_id) wk on wk.incident_id = i.id
            Left Join `helpdesk_cus_zone_area` `zarea` on `zarea`.`area_cus` = `i`.`cus_area`
            Left Join `helpdesk_cus_zone` `z` on `z`.`zone_id` = `zarea`.`zone_id`
            Left Join (SELECT incident_id, MAX( workinfo_date ) AS pending_date
			FROM helpdesk_tr_workinfo
			WHERE workinfo_status_id = 4 and DATE(workinfo_date) <= '$edate'
			GROUP BY incident_id) p on p.incident_id = i.id
              ";

        if (strUtil::isNotEmpty($zone_fr) && strUtil::isNotEmpty($zone_to)){
            $sql .= " AND ifnull(item,0) between $zone_fr and $zone_to ";
        }

        //echo $sql."<br>";
        $result = $this->db->query($sql);
        $total_row = $this->db->num_rows($result);

        if ($total_row == 0) return array();

        while($row = $this->db->fetch_array($result)){
            $arr_criteria[] = $row;
        }

        return array(
            "total_row" => $total_row
        , "data" => $arr_criteria
        );
    }
	
	public function getCustomerInfo($company_id){
            $field = "c.*"
                       . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                       . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name";
            $table = " helpdesk_cus_company c"
                        . " LEFT JOIN helpdesk_user u1 ON (c.created_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (c.modified_by = u2.user_id)";
            $condition = "c.cus_company_id = '$company_id'";

            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $company = $this->db->fetch_array($result);

            return $company;
    }
}

?>
