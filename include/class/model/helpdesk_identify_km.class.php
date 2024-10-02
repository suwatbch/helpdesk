<?php
    include_once "model.class.php";

    class helpdesk_identify_km extends model {
       
        public function search($cratiria = null, $page = 1){
            global $page_size;

            # field
            $field = "inc.ident_id_run_project,inc.summary,inc.notes,inc.resolution,inc.resolved_date,inc.id,p1.prd_tier_name as prd_name1,
                p2.prd_tier_name as prd_name2,p3.prd_tier_name as prd_name3,CONCAT(us.first_name,' ', us.last_name) as reslove_by";
            # table
            $table = "helpdesk_tr_incident inc"
                      . " LEFT JOIN helpdesk_prd_tier p1 on(inc.resol_prdtier1=p1.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p2 on(inc.resol_prdtier2=p2.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p3 on(inc.resol_prdtier3=p3.prd_tier_id)"
                      . " LEFT JOIN helpdesk_user us on(inc.resolved_by=us.user_id)";
            # condition
            $condition = " inc.km_entrant='Y' and inc.km_id = 0";

            $condition .= " ORDER BY inc.ident_id_run_project asc";

            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

        //    if ($rows == 0) return null;

            while($row = $this->db->fetch_array($result)){
                $data[] = $row;
            }
            ///////////////////////select helpdesk_km_incident////////////////
            $field = "inc.km_id,inc.km_no,inc.summary_km as summary,inc.detail,inc.resolution_km as resolution,inc.resolved_km_date as resolved_date,p1.prd_tier_name as prd_name1,
                p2.prd_tier_name as prd_name2,p3.prd_tier_name as prd_name3,CONCAT(us.first_name,' ', us.last_name) as reslove_by,
                cd.ident_id_run_project";
            $table = "helpdesk_km_incident inc"
                      . " LEFT JOIN helpdesk_prd_tier p1 on(inc.prd_tier_id1=p1.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p2 on(inc.prd_tier_id2=p2.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p3 on(inc.prd_tier_id3=p3.prd_tier_id)"
                      . " LEFT JOIN helpdesk_user us on(inc.resolution_user_id=us.user_id)"
                      . " LEFT JOIN helpdesk_tr_incident cd on(inc.incident_id=cd.id)";
            $condition = "1=1 and inc.km_release = 'N'";
            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

          //  if ($rows == 0) return null;

            while($row_km = $this->db->fetch_array($result)){
                $data_km[] = $row_km;
            }
            return array(
                "total_row" => $total_row
                , "data" => $data
                , "data_km" => $data_km
            );
        }
        
        public function insert(&$identify){
            if($identify["km_release"] == 'Y' && $identify["km_no"] == ""){
                $get_km_no = helpdesk_identify_km::getKmRunningByProject($identify["project_id"]);
            }
            $table = "helpdesk_km_incident";
            $field = "km_no,incident_id,summary_km,detail,incident_type_id,project_id_km,
                opr_tier_id1,opr_tier_id2,opr_tier_id3,prd_tier_id1,prd_tier_id2,
                prd_tier_id3,resolution_km,resolution_user_id,resolved_km_date,create_by,
                created_date,modified_by,modified_date,km_keywords,cus_comp_id,km_release";
            $data = "'{$get_km_no}','{$identify["incident_id"]}', '{$identify["summary"]}', '{$identify["detail"]}', 
                '{$identify["incident_type_id"]}', '{$identify["project_id"]}', '{$identify["opr_tier_id1"]}', 
                '{$identify["opr_tier_id2"]}', '{$identify["opr_tier_id3"]}', '{$identify["prd_tier_id1"]}',
                '{$identify["prd_tier_id2"]}', '{$identify["prd_tier_id3"]}', '{$identify["resolution"]}',
                '{$identify["resolution_user_id"]}', '{$identify["resolved_date"]}','{$identify["create_by"]}',
                '{$identify["create_date"]}', '{$identify["modified_by"]}', '{$identify["modified_date"]}',
                '{$identify["km_keywords"]}', '{$identify["cus_comp_id"]}','{$identify["km_release"]}'";

            $result = $this->db->insert($table, $field, $data);
            $km_id = $this->db->insert_id();
            
            if($identify["incident_id"] != ""){
                $table = "helpdesk_tr_incident";
                $data = "km_id = '{$km_id}'";
                $condition = "id = '{$identify["incident_id"]}'";
                $result = $this->db->update($table, $data, $condition);
                
                //////////////////////copy file&insert attach//////////////////////
                $attach_date = date("Y-m-d H:i:s");
                $attach_user_id = user_session::get_user_id();
                if($identify["getfile_name"]!=""){
                foreach ($identify["getfile_name"] as $file){
                    
                    $parth1 = "../../upload/temp_inc_reslove/";
                    $parth2 = "../../incident_km/temp_identify/";
                    $attach_name = explode("|",$file);
                    $attach_ext = explode(".",$attach_name[0]);
                    $random_string = helpdesk_identify_km::RandomStr_km();
                   if(copy($parth1.$attach_name[0],$parth2.$attach_ext[0].$random_string.".".$attach_ext[1])){
                        $conv_location_name = $attach_ext[0].$random_string.".".$attach_ext[1];
                        $table = "helpdesk_tr_attachment";
                        $field = "attach_name,location_name,attach_ext,attach_date,attach_user_id,type_attachment,km_id";
                        $data = "'{$attach_name[1]}','{$conv_location_name}',
                            '{$attach_ext[1]}','{$attach_date}',
                            '{$attach_user_id}','4','{$km_id}'";
                       $result = $this->db->insert($table, $field, $data);
                    }
                }
                }
            }
            include 'upload_identify.php';
            
            if ($result){
                $identify["km_id"] = $km_id;
            }

            return $result;
        }

        public function update(&$identify){
            if($identify["km_release"] == 'Y' && $identify["km_no"] == ""){
                $get_km_no = helpdesk_identify_km::getKmRunningByProject($identify["project_id"]);
            }
            $table = "helpdesk_km_incident";
            $data = //"incident_id = '{$objective["incident_id"]}'"
                         "summary_km = '{$identify["summary"]}'"
                        . ", detail = '{$identify["detail"]}'"
                        . ", incident_type_id = '{$identify["incident_type_id"]}'"
                        . ", project_id_km = '{$identify["project_id"]}'"
                        . ", opr_tier_id1 = '{$identify["opr_tier_id1"]}'"
                        . ", opr_tier_id2 = '{$identify["opr_tier_id2"]}'"
                        . ", opr_tier_id3 = '{$identify["opr_tier_id3"]}'"
                        . ", prd_tier_id1 = '{$identify["prd_tier_id1"]}'"
                        . ", prd_tier_id2 = '{$identify["prd_tier_id2"]}'"
                        . ", prd_tier_id3 = '{$identify["prd_tier_id3"]}'"
                        . ", resolution_km = '{$identify["resolution"]}'"
                        . ", resolution_user_id = '{$identify["resolution_user_id"]}'"
                        . ", resolved_km_date = '{$identify["resolved_date"]}'"
                        . ", modified_by = '{$identify["modified_by"]}'"
                        . ", modified_date = '{$identify["modified_date"]}'"
                        . ", km_keywords = '{$identify["km_keywords"]}'"
                        . ", cus_comp_id = '{$identify["cus_comp_id"]}'"
                        . ", km_release = '{$identify["km_release"]}'";
                   
                        if($identify["km_no"]==""){
                   $data .=  ", km_no = '{$get_km_no}'";
                        }
            $condition = "km_id = '{$identify["km_id"]}'";
            $result = $this->db->update($table, $data, $condition);
            $km_id = $identify["km_id"];
            include 'upload_identify.php';

            return  $result;
        }
        
        public function getByID($incident_id="",$km_id=""){
            if(strUtil::isNotEmpty($incident_id)){
            $field = "inc.summary,inc.notes,inc.ident_type_id,inc.cus_company_id,inc.project_id,inc.resol_oprtier1,
                        inc.resol_oprtier2,inc.resol_oprtier3,inc.resol_prdtier1,inc.resol_prdtier2,inc.resol_prdtier3,
                        inc.resolution,inc.inc_km_keyword as km_keyword ,inc.resolution_user_id,inc.resolved_date,inc.id,
                        inc.ident_id_run_project"
                       //. ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                      // . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name"
                       . ",CONCAT(u3.first_name,' ',u3.last_name) as resloved_name";
            $table = " helpdesk_tr_incident inc"
                        //. " LEFT JOIN helpdesk_user u1 ON (inc.created_by = u1.user_id)"
                        //. " LEFT JOIN helpdesk_user u2 ON (inc.modified_by = u2.user_id)"
                        . " LEFT JOIN helpdesk_user u3 ON (inc.resolution_user_id = u3.user_id)";
            $condition = "inc.id = '$incident_id'";
            
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);
            
            #Get Attach Files identify
			$table = " helpdesk_tr_attachment a inner join helpdesk_user u on(a.attach_user_id = u.user_id)";
			$field = " attach_name,first_name,last_name,attach_date,location_name,attach_id,incident_id";
			$condition = " incident_id = $incident_id AND type_attachment = 3"
						. " ORDER BY attach_date";
			$result = $this->db->select($field, $table, $condition);
                        $rows = $this->db->num_rows($result);
			if ($rows > 0){
                        while($row = $this->db->fetch_array($result)){
                            $objective["file_resolution"][] = $row;
                }
            }
            }
            //////////////////////////////identify////////////////////////////
            if(strUtil::isNotEmpty($km_id)){
            $field = "km.km_no,km.summary_km as summary,km.detail as notes,km.incident_type_id as ident_type_id,km.cus_comp_id as cus_company_id,
                        km.project_id_km as project_id,km.opr_tier_id1 as resol_oprtier1,
                        km.opr_tier_id2 as resol_oprtier2,km.opr_tier_id3 as resol_oprtier3,
                        km.prd_tier_id1 as resol_prdtier1,km.prd_tier_id2 as resol_prdtier2,km.prd_tier_id3 as resol_prdtier3,
                        km.resolution_km as resolution,km.km_keywords as km_keyword ,km.resolution_user_id,km.resolved_km_date as resolved_date,km.km_id,cd.ident_id_run_project,
                        km.created_date as create_date,km.modified_date,cp.cus_company_name,it.ident_type_desc,pj.project_name,p1.prd_tier_name as prd_name1,
                        p2.prd_tier_name as prd_name2,p3.prd_tier_name as prd_name3,o1.opr_tier_name as opr_name1,o2.opr_tier_name as opr_name2,
                        o3.opr_tier_name as opr_name3 "
                        . ",CONCAT(u1.first_name,' ',u1.last_name) as created_name"
                        . ",CONCAT(u2.first_name,' ',u2.last_name) as modified_name"
                        . ",CONCAT(u3.first_name,' ',u3.last_name) as resloved_name";
            $table = " helpdesk_km_incident km"
                        . " LEFT JOIN helpdesk_user u1 ON (km.create_by = u1.user_id)"
                        . " LEFT JOIN helpdesk_user u2 ON (km.modified_by = u2.user_id)"
                        . " LEFT JOIN helpdesk_user u3 ON (km.resolution_user_id = u3.user_id)"
                        . " LEFT JOIN helpdesk_cus_company cp ON (km.cus_comp_id=cp.cus_company_id)"
                        . " LEFT JOIN helpdesk_incident_type it ON (km.incident_type_id=it.ident_type_id)"
                        . " LEFT JOIN helpdesk_project pj ON (km.project_id_km=pj.project_id)"
                        . " LEFT JOIN helpdesk_prd_tier p1 on(km.prd_tier_id1=p1.prd_tier_id)"
                        . " LEFT JOIN helpdesk_prd_tier p2 on(km.prd_tier_id2=p2.prd_tier_id)"
                        . " LEFT JOIN helpdesk_prd_tier p3 on(km.prd_tier_id3=p3.prd_tier_id)"
                        . " LEFT JOIN helpdesk_opr_tier o1 on(km.opr_tier_id1=o1.opr_tier_id)"
                        . " LEFT JOIN helpdesk_opr_tier o2 on(km.opr_tier_id2=o2.opr_tier_id)"
                        . " LEFT JOIN helpdesk_opr_tier o3 on(km.opr_tier_id3=o3.opr_tier_id)"
                        . " LEFT JOIN helpdesk_tr_incident cd on(km.incident_id=cd.id)";
            $condition = "km.km_id = '$km_id'";
            
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            $objective = $this->db->fetch_array($result);
            
            #Get Attach Files identify
			$table = " helpdesk_tr_attachment a inner join helpdesk_user u on(a.attach_user_id = u.user_id)";
			$field = " attach_name,first_name,last_name,attach_date,location_name,attach_id,km_id";
			$condition = " km_id = $km_id AND type_attachment = 4"
						. " ORDER BY attach_date";
			$result = $this->db->select($field, $table, $condition);
                        $rows = $this->db->num_rows($result);
			if ($rows > 0){
                        while($row = $this->db->fetch_array($result)){
                            $objective["file_resolution"][] = $row;
                }
            }
            }

            return $objective;
        }

        public function delete($objective){
//            return $this->deleteWithUpdate("helpdesk_cus_zone_area", "status", "D", "id = '$objective'");
            return $this->deleteWithoutUpdate("helpdesk_cus_zone_area", "id = '$objective'");
        }
        
        public function restore_master($objective){
            return $this->deleteWithUpdate("helpdesk_cus_zone_area", "status", "A", "id = '$objective'");
        }
        
         public function search_unrelease($cratiria = null, $page = 1){
            global $page_size;
            ///////////////////////select helpdesk_km_incident////////////////
            $field = "inc.km_id,inc.km_no,inc.summary_km as summary,inc.detail,inc.resolution_km as resolution,inc.resolved_km_date as resolved_date,p1.prd_tier_name as prd_name1,
                p2.prd_tier_name as prd_name2,p3.prd_tier_name as prd_name3,CONCAT(us.first_name,' ', us.last_name) as reslove_by,
                cd.ident_id_run_project";
            $table = "helpdesk_km_incident inc"
                      . " LEFT JOIN helpdesk_prd_tier p1 on(inc.prd_tier_id1=p1.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p2 on(inc.prd_tier_id2=p2.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p3 on(inc.prd_tier_id3=p3.prd_tier_id)"
                      . " LEFT JOIN helpdesk_user us on(inc.resolution_user_id=us.user_id)"
                      . " LEFT JOIN helpdesk_tr_incident cd on(inc.incident_id=cd.id)";
            $condition = "1=1 and inc.km_release = 'Y' and km_on_release = ''";
            if(strUtil::isNotEmpty($cratiria["cus_comp_id"])){
                $condition .= " and inc.cus_comp_id = '{$cratiria["cus_comp_id"]}'";
            }
             if(strUtil::isNotEmpty($cratiria["prd_tier_id1"])){
                $condition .= " and inc.prd_tier_id1 = '{$cratiria["prd_tier_id1"]}'";
            }
             if(strUtil::isNotEmpty($cratiria["prd_tier_id2"])){
                $condition .= " and inc.prd_tier_id2 = '{$cratiria["prd_tier_id2"]}'";
            }
             if(strUtil::isNotEmpty($cratiria["prd_tier_id3"])){
                $condition .= " and inc.prd_tier_id3 = '{$cratiria["prd_tier_id3"]}'";
            }
            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

          //  if ($rows == 0) return null;

            while($row_km = $this->db->fetch_array($result)){
                $data_km[] = $row_km;
            }
            return array(
                "total_row" => $total_row
                , "data_km" => $data_km
            );
        }
        
         public function search_release($cratiria = null, $page = 1){
            global $page_size;
            ///////////////////////select helpdesk_km_incident////////////////
            $field = "inc.km_id,inc.km_no,inc.summary_km as summary,inc.detail,inc.resolution_km as resolution,inc.resolved_km_date as resolved_date,p1.prd_tier_name as prd_name1,
                p2.prd_tier_name as prd_name2,p3.prd_tier_name as prd_name3,CONCAT(us.first_name,' ', us.last_name) as reslove_by,
                cd.ident_id_run_project,inc.ranking,inc.km_keywords";
            $table = "helpdesk_km_incident inc"
                      . " LEFT JOIN helpdesk_prd_tier p1 on(inc.prd_tier_id1=p1.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p2 on(inc.prd_tier_id2=p2.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p3 on(inc.prd_tier_id3=p3.prd_tier_id)"
                      . " LEFT JOIN helpdesk_user us on(inc.resolution_user_id=us.user_id)"
                      . " LEFT JOIN helpdesk_tr_incident cd on(inc.incident_id=cd.id)";
            $condition = "1=1 and inc.km_on_release = 'Y'";
             if(strUtil::isNotEmpty($cratiria["cus_comp_id"])){
                $condition .= " and inc.cus_comp_id = '{$cratiria["cus_comp_id"]}'";
            }
             if(strUtil::isNotEmpty($cratiria["prd_tier_id1"])){
                $condition .= " and inc.prd_tier_id1 = '{$cratiria["prd_tier_id1"]}'";
            }
             if(strUtil::isNotEmpty($cratiria["prd_tier_id2"])){
                $condition .= " and inc.prd_tier_id2 = '{$cratiria["prd_tier_id2"]}'";
            }
             if(strUtil::isNotEmpty($cratiria["prd_tier_id3"])){
                $condition .= " and inc.prd_tier_id3 = '{$cratiria["prd_tier_id3"]}'";
            }
            $total_row = $this->db->count_rows($table, $condition);
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

          //  if ($rows == 0) return null;
            if($rows > 0){
                if($cratiria["s_mode"]=="search"){
                    while($fetch_km = $this->db->fetch_array($result)){
                    $count_keywords = helpdesk_identify_km::search_in_keywords($cratiria["search_key_words"],$fetch_km["km_keywords"]);
                 //echo $count_keywords."<br>";
                    if($count_keywords > 0){
                       
                        $data_km[] = $fetch_km;
                    }
                }
                }else{
                    while($row_km = $this->db->fetch_array($result)){
                        $data_km[] = $row_km;
                    }
                }
            
                
                
            }
            return array(
                "total_row" => $total_row
                , "data_km" => $data_km
            );
        }
        
        public function update_unrelease($objective){
            foreach ($objective["km_id"] as $update_un){
            $table = "helpdesk_km_incident";
            $data = "km_on_release = 'Y',modified_by = '".user_session::get_user_id()."',modified_date = '".date("Y-m-d H:i:s")."'";
            $condition = "km_id = '{$update_un}'";
            $result = $this->db->update($table, $data, $condition);
        }
            return $result;
        }
        
        public function update_release($objective){
            foreach ($objective["km_id"] as $update_release){
            $table = "helpdesk_km_incident";
            $data = "km_on_release = '',km_release = 'Y',modified_by = '".user_session::get_user_id()."',modified_date = '".date("Y-m-d H:i:s")."'";
            $condition = "km_id = '{$update_release}'";
            $result = $this->db->update($table, $data, $condition);
        }
            return $result;
        }
        
        public function update_identify($objective){
            foreach ($objective["km_id"] as $update_release){
            $table = "helpdesk_km_incident";
            $data = "km_on_release = '',km_release = 'N',modified_by = '".user_session::get_user_id()."',modified_date = '".date("Y-m-d H:i:s")."'";
            $condition = "km_id = '{$update_release}'";
            $result = $this->db->update($table, $data, $condition);
        }
            return $result;
        }
        
        public function search_release_base($cratiria = null){
            ///////////////////////select helpdesk_km_incident_base////////////////      
            $field = "inc.km_id,inc.km_no,inc.summary_km as summary,inc.detail,inc.resolution_km as resolution,inc.resolved_km_date as resolved_date,p1.prd_tier_name as prd_name1,
                p2.prd_tier_name as prd_name2,p3.prd_tier_name as prd_name3,CONCAT(us.first_name,' ', us.last_name) as reslove_by,
                cd.ident_id_run_project,inc.ranking,inc.km_keywords";
            $table = "helpdesk_km_incident inc"
                      . " LEFT JOIN helpdesk_prd_tier p1 on(inc.prd_tier_id1=p1.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p2 on(inc.prd_tier_id2=p2.prd_tier_id)"
                      . " LEFT JOIN helpdesk_prd_tier p3 on(inc.prd_tier_id3=p3.prd_tier_id)"
                      . " LEFT JOIN helpdesk_user us on(inc.resolution_user_id=us.user_id)"
                      . " LEFT JOIN helpdesk_tr_incident cd on(inc.incident_id=cd.id)";
            $condition = "1=1 and inc.km_on_release = 'Y'";
            if(strUtil::isNotEmpty($cratiria["cus_comp_id"])){
                $condition .= " and inc.cus_comp_id = '{$cratiria["cus_comp_id"]}'";
            }
//            if(strUtil::isNotEmpty($cratiria["ident_type_id"])){
//                $condition .= " and inc.incident_type_id = '{$cratiria["ident_type_id"]}'";
//            }
//            if(strUtil::isNotEmpty($cratiria["project_id"])){
//                $condition .= " and inc.project_id_km = '{$cratiria["project_id"]}'";
//            }
//            if(strUtil::isNotEmpty($cratiria["cas_prd_tier_id1"])){
//                $condition .= " and inc.prd_tier_id1 = '{$cratiria["cas_prd_tier_id1"]}'";
//            }
//            if(strUtil::isNotEmpty($cratiria["cas_prd_tier_id2"])){
//                $condition .= " and inc.prd_tier_id2 = '{$cratiria["cas_prd_tier_id2"]}'";
//            }
//            if(strUtil::isNotEmpty($cratiria["cas_prd_tier_id3"])){
//                $condition .= " and inc.prd_tier_id3 = '{$cratiria["cas_prd_tier_id3"]}'";
//            }
//            if(strUtil::isNotEmpty($cratiria["cas_opr_tier_id1"])){
//                $condition .= " and inc.opr_tier_id1 = '{$cratiria["cas_opr_tier_id1"]}'";
//            }
//            if(strUtil::isNotEmpty($cratiria["cas_opr_tier_id2"])){
//                $condition .= " and inc.opr_tier_id2 = '{$cratiria["cas_opr_tier_id2"]}'";
//            }
//            if(strUtil::isNotEmpty($cratiria["cas_opr_tier_id3"])){
//                $condition .= " and inc.opr_tier_id3 = '{$cratiria["cas_opr_tier_id3"]}'";
//            }
            $condition .= "order by inc.ranking desc ";
            $result_km = $this->db->select($field, $table, $condition);
            $rows_km = $this->db->num_rows($result_km);
            if($rows_km > 0){
                while($fetch_km = $this->db->fetch_array($result_km)){
                $count_keywords = helpdesk_identify_km::search_in_keywords($cratiria["text_summary"]." ".$cratiria["txt_notes"],$fetch_km["km_keywords"]);
                //echo $count_keywords."<br>";
                    if($count_keywords > 0){
                       
                      $data_km[] = $fetch_km;
                    }
                }
                return array(
                    "data_km" => $data_km
                );
            }
        }
        
        public function search_in_keywords($word, $text){

            $parts = explode(",", $text);
            $result = array();
            $word = strtolower($word);

            foreach($parts as $v){
             if(strpos(ereg_replace('[[:space:]]+', '', trim($word)), ereg_replace('[[:space:]]+', '', trim(strtolower($v)))) !== false){
                 
             //if(strpos(strtolower($v), $word) !== false){
              $result[] = $v;
             }

            }

            if(!empty($result)){
                return count($result);
               //return implode(", ", $result);
            }else{
               return 0;
            }
           }
        
        public function getKmRunningByProject($project_id){
			global $asm,$wif;
            # Incident Header  
            $field = "km_id_run_project,project_code";
            $table = " helpdesk_project";
            $condition = " project_id = $project_id";
			
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return array();
            
            $KmRunningByProjectID = $this->db->fetch_array($result);
			$KmID = $KmRunningByProjectID["km_id_run_project"]+1;
			#Update field km_id_run_project
			if($KmID){  
					$table = "helpdesk_project";
					$data = "km_id_run_project = '{$KmID}'"; //exit;
            		$condition = " project_id = $project_id";
					
					$result = $this->db->update($table, $data, $condition);
					if (!$result) return false;
			}
                        $KmID_conv = sprintf("%05d", $KmID);
                        $KmID_con = "KM-".$KmRunningByProjectID["project_code"]."-".$KmID_conv;
			
			return $KmID_con;
		}
       
       public function list_production($prd_tier_id1,$prd_tier_id2){
            $field = "prd_tier_id,prd_tier_name";
            $table = "helpdesk_km_incident km";
            if($prd_tier_id1 == ""){
                $table.= " LEFT JOIN helpdesk_prd_tier p1 on(km.prd_tier_id1=p1.prd_tier_id)";
                $condition = " km.km_on_release = 'Y' group by km.prd_tier_id1";
            }else if($prd_tier_id1 != "" && $prd_tier_id2 == ""){
                $table.= " LEFT JOIN helpdesk_prd_tier p2 on(km.prd_tier_id2=p2.prd_tier_id)";
                $condition = " km.km_on_release = 'Y' and km.prd_tier_id1 = '{$prd_tier_id1}' group by km.prd_tier_id2";
            }else if(prd_tier_id1 != "" && $prd_tier_id2 != ""){
                $table.= " LEFT JOIN helpdesk_prd_tier p3 on(km.prd_tier_id3=p3.prd_tier_id)";
                $condition = " km.km_on_release = 'Y' and km.prd_tier_id1 = '{$prd_tier_id1}' and km.prd_tier_id2 = '{$prd_tier_id2}' group by km.prd_tier_id3";
            }
            
            $result = $this->db->select($field, $table, $condition);
            $rows = $this->db->num_rows($result);

            if ($rows == 0) return null;

            while($row_list = $this->db->fetch_array($result)){
                $data_list[] = $row_list;
            }
            
            return array(
                "data_list" => $data_list
            );
           
       }
       
       public function delete_incident_km($incident_id){
            $table = "helpdesk_tr_incident";
            $data = "km_entrant = '',km_id = '',inc_km_keyword = '' ";
            $condition = "id = '{$incident_id}'";
            $result = $this->db->update($table, $data, $condition);
            return $result;   
        }
           
        public function delete_km($km_id){
            return $this->deleteWithoutUpdate("helpdesk_km_incident", "km_id = '$km_id'");   
        }
        
        public function RandomStr_km($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    }
    
?>
