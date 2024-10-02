<?php
    include_once dirname(__FILE__)."/util/arrUtil.class.php";
	include_once dirname(__FILE__)."/util/dateUtil.class.php";

    class dropdown {

         public static function select($name, $option, $attr = ""){
            $dd = "<select id=\"$name\" name=\"$name\" $attr>\n";
            $dd .= "   ".$option."\n";
            $dd .= "</select>\n";

            return $dd;
        }
		
        public static function bindDropdown($data, $name, $allowBlank = true, $valueMember = "id", $displayMember = "text", $attr = "", $selectValue = ""){
            
			if ($allowBlank){
                arrUtil::insert($data, array(), 0);
            }

            if (count($data) > 0){                
                foreach ($data as $d) {
                    $option .= "   <option value=\"{$d[$valueMember]}\" ".(($selectValue == $d[$valueMember]) ? "selected" : "").">{$d[$displayMember]}</option>\n";
                }

                return self::select($name, $option, $attr);
            }
            return "";
        }

        public static function bindDropdownByGroup($data, $name, $allowBlank = true, $optGroup = "optGroup", $valueMember = "id", $displayMember = "text", $attr = "", $selectValue = ""){
            if ($allowBlank){
                $option = "   <option></option>\n";
            }

            $og = "";

            if (count($data) > 0){
                foreach ($data as $d) {
                    $oglabel = $d[$optGroup];

                    if ($og != $oglabel){
                        if (strUtil::isNotEmpty($og)){
                            $option .= "   </optgroup>\n";
                        }
                        $og = $oglabel;
                        $option .= "   <optgroup label=\"$og\">\n";
                    }

                    $option .= "      <option value=\"{$d[$valueMember]}\" ".(($selectValue == $d[$valueMember]) ? "selected" : "").">{$d[$displayMember]}</option>\n";
                }
                $option .= "   </optgroup>\n";
            }

            return self::select($name, $option, $attr);
        }
/*
        public static function loadContinent($db, $name, $attr = "", $select = ""){
            $continent = new continent($db);
            $continent = $continent->listCombo();

            return self::bindDropdown($continent, $name, true, "con_id", "con_name", $attr, $select);
        }
*/
		//===================================================================================
        public static function loadStatus($db, $name, $attr = "", $select = ""){
            $status = new status($db);
            $status = $status->listCombo();

            return self::bindDropdown($status, $name, true, "status_id", "status_desc", $attr, $select);
        }
		
		public static function loadStatus2($db, $name, $attr = "", $select = ""){
            $status = new status($db);
            $status = $status->listCombo2();

            return self::bindDropdown($status, $name, true, "status_id", "status_desc", $attr, $select);
        }
		
        public static function loadStatus_res($db, $name, $attr = "", $select = "", $status_id = ""){
            $status_res = new status_res($db);
            $status_res = $status_res->listCombo($status_id);

            return self::bindDropdown($status_res, $name, true, "status_res_id", "status_res_desc", $attr, $select);
        }
		
        public static function loadImpact($db, $name, $attr = "", $select = ""){
            $impact = new Impact($db);
            $impact = $impact->listCombo();

            return self::bindDropdown($impact, $name, true, "impact_id", "impact_desc", $attr, $select);
        }
		
        public static function loadUrgency($db, $name, $attr = "", $select = ""){
            $Urgency = new Urgency($db);
            $Urgency = $Urgency->listCombo();

            return self::bindDropdown($Urgency, $name, true, "urgency_id", "urgency_desc", $attr, $select);
        }
		
        public static function loadPriority($db, $name, $attr = "", $select = ""){
            $priority = new priority($db);
            $priority = $priority->listCombo();

            return self::bindDropdown($priority, $name, true, "priority_id", "priority_desc", $attr, $select);
        }
		
	public static function loadincident_type($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $incident_type = new incident_type($db);
            $incident_type = $incident_type->listCombo($cus_company_id);

            return self::bindDropdown($incident_type, $name, true, "ident_type_id", "ident_type_desc", $attr, $select);
        }
		
        public static function loadProject($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $Project = new helpdesk_project($db);
            $Project = $Project->listCombo($cus_company_id);

            return self::bindDropdown($Project, $name, true, "project_id", "project_name", $attr, $select);
        }
		
		public static function loadProjectPerson($db, $name, $attr = "", $select = "", $customer_id = ""){
			$Project = new helpdesk_project($db);
            $Project = $Project->listComboPerson($customer_id);
            return self::bindDropdown($Project, $name, true, "project_id", "project_name", $attr, $select);
        }
		
        public static function loadOpr_tier1($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $Opr_tier1 = new Opr_tier1($db);
            $Opr_tier1 = $Opr_tier1->listCombo($cus_company_id);

            return self::bindDropdown($Opr_tier1, $name, true, "opr_tier_id", "opr_tier_name", $attr, $select);
        }
		
        public static function loadOpr_tier2($db, $name, $attr = "", $select = "", $cas_opr_tier_id1 = "", $cus_company_id = ""){
            $Opr_tier2 = new Opr_tier2($db);
            $Opr_tier2 = $Opr_tier2->listCombo($cas_opr_tier_id1,$cus_company_id);

            return self::bindDropdown($Opr_tier2, $name, true, "opr_tier_id", "opr_tier_name", $attr, $select);
        }
		
        public static function loadOpr_tier3($db, $name, $attr = "", $select = "", $cas_opr_tier_id1 = "", $cas_opr_tier_id2 = "", $cus_company_id = ""){
            $Opr_tier3 = new Opr_tier3($db);
            $Opr_tier3 = $Opr_tier3->listCombo($cas_opr_tier_id1,$cas_opr_tier_id2,$cus_company_id);

            return self::bindDropdown($Opr_tier3, $name, true, "opr_tier_id", "opr_tier_name", $attr, $select);
        }
		
        public static function loadPrd_tier1($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $Prd_tier1 = new Prd_tier1($db);
            $Prd_tier1 = $Prd_tier1->listCombo($cus_company_id);

            return self::bindDropdown($Prd_tier1, $name, true, "prd_tier_id", "prd_tier_name", $attr, $select);
        }
		
        public static function loadPrd_tier2($db, $name, $attr = "", $select = "", $cas_prd_tier_id1 = "", $cus_company_id = ""){
            $Prd_tier2 = new Prd_tier2($db);
            $Prd_tier2 = $Prd_tier2->listCombo($cas_prd_tier_id1,$cus_company_id);

            return self::bindDropdown($Prd_tier2, $name, true, "prd_tier_id", "prd_tier_name", $attr, $select);
        }
		
        public static function loadPrd_tier3($db, $name, $attr = "", $select = "", $cas_prd_tier_id1 = "", $cas_prd_tier_id2 = "", $cus_company_id = ""){
            $Prd_tier3 = new Prd_tier3($db);
            $Prd_tier3 = $Prd_tier3->listCombo($cas_prd_tier_id1,$cas_prd_tier_id2,$cus_company_id);

            return self::bindDropdown($Prd_tier3, $name, true, "prd_tier_id", "prd_tier_name", $attr, $select);
        }
        
        public static function loadPrd_tier3_report($db, $name, $attr = "", $select = "", $cas_prd_tier_id1 = "", $cas_prd_tier_id2 = "", $cus_company_id = ""){
            $Prd_tier3 = new Prd_tier3($db);
            $Prd_tier3 = $Prd_tier3->listCombo_report($cas_prd_tier_id1,$cas_prd_tier_id2,$cus_company_id);

            return self::bindDropdown($Prd_tier3, $name, true, "prd_tier_name", "prd_tier_name", $attr, $select);
        }
		
        /*public static function loadPrd_tier3($db, $name, $attr = "", $select = ""){
            $Prd_tier3 = new Prd_tier3($db);
            $Prd_tier3 = $Prd_tier3->listCombo();

            return self::bindDropdown($Prd_tier3, $name, true, "prd_tier_id", "prd_tier_name", $attr, $select);
        }*/
		
        public static function loadCompany($db, $name, $attr = "", $select = ""){
            $helpdesk_company = new helpdesk_company($db);
            $helpdesk_company = $helpdesk_company->listCombo();

            return self::bindDropdown($helpdesk_company, $name, true, "assign_comp_id", "assign_comp_name", $attr, $select);
        }
        
        public static function loadCompanyMaster($db, $name, $attr = "", $select = ""){
            $helpdesk_company = new helpdesk_company($db);
            $helpdesk_company = $helpdesk_company->listCombo_master();

            return self::bindDropdown($helpdesk_company, $name, true, "company_id", "company_name", $attr, $select);
        }
		
        public static function loadOrg($db, $name, $attr = "", $select = "", $assign_comp_id = ""){
			
            $org = new helpdesk_org($db);
            $org = $org->listCombo($assign_comp_id);

            return self::bindDropdown($org, $name, true, "assign_org_id", "assign_org_name", $attr, $select);
        }
        
        
		
        public static function loadGrp($db, $name, $attr = "", $select = "", $assign_comp_id = "", $assign_org_id = ""){
            $grp = new helpdesk_grp($db);
            $grp = $grp->listCombo($assign_comp_id,$assign_org_id);

            return self::bindDropdown($grp, $name, true, "assign_group_id", "assign_group_name", $attr, $select);
        }
		
        public static function loadSubGrp($db, $name, $attr = "", $select = "", $assign_comp_id = "", $assign_group_id = ""){
            $subgrp = new helpdesk_subgrp($db);
            $subgrp = $subgrp->listCombo($assign_comp_id, $assign_group_id);

            return self::bindDropdown($subgrp, $name, true, "assign_subgrp_id", "assign_subgrp_name", $attr, $select);
        }
		
        public static function loadAssign_assignee_id($db, $name, $attr = "", $select = "", $assign_comp_id = "", $assign_subgrp_id = ""){
            $assignee = new helpdesk_user($db);
            $assignee = $assignee->listCombo($assign_comp_id, $assign_subgrp_id);

            return self::bindDropdown($assignee, $name, true, "assign_assignee_id", "assign_assignee_name", $attr, $select);
        }
		
        public static function loadOpr_tier1_resol($db, $name, $attr = "", $select = "",$cus_company_id = ""){
            $Opr_tier1_resol = new Opr_tier1_resol($db);
            $Opr_tier1_resol = $Opr_tier1_resol->listCombo($cus_company_id);

            return self::bindDropdown($Opr_tier1_resol, $name, true, "resol_oprtier1_id", "resol_oprtier1_name", $attr, $select);
        }
		
        public static function loadOpr_tier2_resol($db, $name, $attr = "", $select = "", $resol_oprtier1 = "",$cus_company_id = ""){
            $Opr_tier2_resol = new Opr_tier2_resol($db);
            $Opr_tier2_resol = $Opr_tier2_resol->listCombo($resol_oprtier1,$cus_company_id);
			
            return self::bindDropdown($Opr_tier2_resol, $name, true, "resol_oprtier2_id", "resol_oprtier2_name", $attr, $select);
        }
		
        public static function loadOpr_tier3_resol($db, $name, $attr = "", $select = "", $resol_oprtier1 = "", $resol_oprtier2 = "",$cus_company_id = ""){
            $Opr_tier3_resol = new Opr_tier3_resol($db);
            $Opr_tier3_resol = $Opr_tier3_resol->listCombo($resol_oprtier1,$resol_oprtier2,$cus_company_id);

            return self::bindDropdown($Opr_tier3_resol, $name, true, "resol_oprtier3_id", "resol_oprtier3_name", $attr, $select);
        }
		
        public static function loadPrd_tier1_resol($db, $name, $attr = "", $select = "",$cus_company_id = ""){
            $Prd_tier1_resol = new Prd_tier1_resol($db);
            $Prd_tier1_resol = $Prd_tier1_resol->listCombo($cus_company_id);

            return self::bindDropdown($Prd_tier1_resol, $name, true, "resol_prdtier1_id", "resol_prdtier1_name", $attr, $select);
        }
		
        /* public static function loadPrd_tier2_resol($db, $name, $attr = "", $select = "", $resol_prdtier1 = ""){
            $Prd_tier2_resol = new Prd_tier2_resol($db);
            $Prd_tier2_resol = $Prd_tier2_resol->listCombo($resol_prdtier1);

            return self::bindDropdown($Prd_tier2_resol, $name, true, "resol_prdtier2_id", "resol_prdtier2_name", $attr, $select);
        }*/
		
        public static function loadPrd_tier2_resol($db, $name, $attr = "", $select = "", $resol_prdtier1 = "", $cus_company_id = ""){
            $Prd_tier2_resol = new Prd_tier2_resol($db);
            $Prd_tier2_resol = $Prd_tier2_resol->listCombo($resol_prdtier1,$cus_company_id);

            return self::bindDropdown($Prd_tier2_resol, $name, true, "resol_prdtier2_id", "resol_prdtier2_name", $attr, $select);
        }
		
        public static function loadPrd_tier3_resol($db, $name, $attr = "", $select = "", $resol_prdtier1 = "", $resol_prdtier2 = "", $cus_company_id = ""){
            $Prd_tier3_resol = new Prd_tier3_resol($db);
            $Prd_tier3_resol = $Prd_tier3_resol->listCombo($resol_prdtier1,$resol_prdtier2,$cus_company_id);

            return self::bindDropdown($Prd_tier3_resol, $name, true, "resol_prdtier3_id", "resol_prdtier3_name", $attr, $select);
        }
		
        public static function loadWorkinfotype($db, $name, $attr = "", $select = ""){
            $Workinfotype = new Workinfotype($db);
            $Workinfotype = $Workinfotype->listCombo();

            return self::bindDropdown($Workinfotype, $name, true, "workinfo_id", "workinfo_name", $attr, $select);
        }
		
        public static function loadSatisfac_id($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $Satisfacation = new Satisfacation($db);
            $Satisfacation = $Satisfacation->listCombo($cus_company_id);

            return self::bindDropdown($Satisfacation, $name, true, "satisfac_id", "satisfac_desc", $attr, $select);
        }
		
		
		//===================================================================================

        public static function loadCountry($db, $name, $attr = "", $select = "", $con_id = ""){
            $country = new country($db);
            $country = $country->listCombo($con_id);

            return self::bindDropdownByGroup($country, $name, true, "con_name", "cou_id", "cou_name", $attr, $select);
        }

        public static function loadRegion($db, $name, $attr = "", $select = ""){
            $region = new region($db);
            $region = $region->listCombo();

            return self::bindDropdown($region, $name, true, "reg_id", "reg_name", $attr, $select);
        }

        public static function loadProvince($db, $name, $attr = "", $select = "", $reg_id = ""){
            $province = new province($db);
            $province = $province->listCombo($reg_id);

            return self::bindDropdownByGroup($province, $name, true, "reg_name", "prv_id", "prv_name", $attr, $select);
        }

        public static function loadAmphur($db, $name, $attr = "", $select = "", $prv_id = ""){
            $amphur = new amphur($db);
            $amphur = $amphur->listCombo($prv_id);

            return self::bindDropdown($amphur, $name, true, "amp_id", "amp_name", $attr, $select);
        }

        public static function loadSaleGroup($db, $name, $attr = "", $select = ""){
            $sale_group = new sale_group($db);
            $sale_group = $sale_group->listCombo();

            return self::bindDropdown($sale_group, $name, true, "sale_group_id", "sale_group_name", $attr, $select);
        }

        public static function loadCustomerGroup($db, $name, $attr = "", $select = ""){
            $customer_group = new customer_group($db);
            $customer_group = $customer_group->listCombo();

            return self::bindDropdown($customer_group, $name, true, "customer_group_id", "customer_group_name", $attr, $select);
        }

        public static function loadObjective($db, $name, $attr = "", $select = ""){
            $objective = new objective($db);
            $objective = $objective->listCombo();

            return self::bindDropdown($objective, $name, true, "objective_id", "objective_name", $attr, $select);
        }

        public static function loadNextStep($db, $name, $attr = "", $select = ""){
            $nextstep = new nextstep($db);
            $nextstep = $nextstep->listCombo();

            return self::bindDropdown($nextstep, $name, true, "next_step_id", "next_step_name", $attr, $select);
        }

        public static function loadPosition($db, $name, $attr = "", $select = ""){
            $position = new position($db);
            $position = $position->listCombo();

            return self::bindDropdown($position, $name, true, "position_id", "position_name", $attr, $select);
        }

        public static function loadMenu($db, $name, $attr = "", $select = ""){
            $menu = new menu($db);
            $menu = $menu->listCombo();

            return self::bindDropdown($menu, $name, true, "menu_id", "menu_name", $attr, $select);
        }

        public static function loadLob($db, $name, $attr = "", $select = ""){
            $lob = new lob($db);
            $lob = $lob->listCombo();

            return self::bindDropdown($lob, $name, true, "lob_id", "lob_name", $attr, $select);
        }

        public static function loadTitle($name, $attr = "", $select = ""){
            $title = array(
                array("id" => "Mr", "text" => "Mr")
                , array("id" => "Mrs", "text" => "Mrs")
                , array("id" => "Ms", "text" => "Ms")
            );

            return self::bindDropdown($title, $name, true, "id", "text", $attr, $select);
        }

        public static function loadProjectSize($name, $attr = "", $select = ""){
            $title = array(
                array("id" => "S", "text" => "S")
                , array("id" => "M", "text" => "M")
                , array("id" => "L", "text" => "L")
            );

            return self::bindDropdown($title, $name, true, "id", "text", $attr, $select);
        }

        public static function loadEngineType($name, $attr = "", $select = ""){
            $title = array(
                array("id" => "L", "text" => "Leave")
                , array("id" => "M", "text" => "Manager")
                , array("id" => "P", "text" => "Person")
                , array("id" => "W", "text" => "Weekly Report")
            );

            return self::bindDropdown($title, $name, true, "id", "text", $attr, $select);
		}
		
		 // MY FUNCTION
        public static function loadCusCompany($db, $name, $attr = "", $select = ""){
            $helpdesk_company = new helpdesk_company($db);
            $helpdesk_company = $helpdesk_company->cuscompany();

            return self::bindDropdown($helpdesk_company, $name, true, "cus_company_id", "cus_company_name", $attr, $select);
        }
        
        
        public static function loadCusZone($db, $name, $cus_comp_id = "", $attr = "", $select = ""){
            $report = new report($db);
            $report = $report->getcustomerzone($cus_comp_id);

            return self::bindDropdown($report["arr_criteria"], $name, true, "item", "display_name", $attr, $select);
        }
        
        public static function loadOrg_master($db, $name, $attr = "", $select = "", $company_id = ""){
            $org = new helpdesk_org($db);
            $org = $org->listCombo_master($company_id);

            return self::bindDropdown($org, $name, true, "org_id", "org_name", $attr, $select);
        }
        
        public static function loadGrp_master($db, $name, $attr = "", $select = "", $company_id = ""){
            $grp = new helpdesk_grp($db);
            $grp = $grp->listCombo_master($company_id);

            return self::bindDropdown($grp, $name, true, "org_id", "org_name", $attr, $select);
        }
        
        public static function loadSubGrp_master($db, $name, $attr = "", $select = "", $company_id = "", $group_id = ""){
            $subgrp = new helpdesk_subgrp($db);
            $subgrp = $subgrp->listCombo_master($company_id,$group_id);
            
            return self::bindDropdown($subgrp, $name, true, "org_id", "org_name", $attr, $select);
        }
        
        public static function loadCusOrg($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $helpdesk_org = new helpdesk_org($db);
            $helpdesk_org = $helpdesk_org->cusorg($cus_company_id);
            return self::bindDropdown($helpdesk_org, $name, true, "cus_org_id", "cus_org_name", $attr, $select);
        }
        
         public static function loadCusArea($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            //$cus_company_id = 10;
	    $helpdesk_area = new helpdesk_area($db);
            $helpdesk_area = $helpdesk_area->cusarea($cus_company_id);
            return self::bindDropdown($helpdesk_area, $name, true, "area_cus", "area_cus_name", $attr, $select);
        }
        
        public static function loadZone($db, $name, $attr = "", $select = ""){
            $helpdesk_zone= new helpdesk_zone($db);
            $helpdesk_zone = $helpdesk_zone->cuszone();

            return self::bindDropdown($helpdesk_zone, $name, true, "zone_id", "name", $attr, $select);
        }
        
        public static function loadOpr_tier2_master($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $Opr_tier2 = new Opr_tier2($db);
            $Opr_tier2 = $Opr_tier2->listCombo_master($cus_company_id);

            return self::bindDropdown($Opr_tier2, $name, true, "opr_tier_id", "opr_tier_name", $attr, $select);
        }
        
        public static function loadOpr_tier3_master($db, $name, $attr = "", $select = "", $cus_company_id=""){
            $Opr_tier3 = new Opr_tier3($db);
            $Opr_tier3 = $Opr_tier3->listCombo_master($cus_company_id);

            return self::bindDropdown($Opr_tier3, $name, true, "opr_tier_id", "opr_tier_name", $attr, $select);
        }
        
        public static function loadPrdSla($db, $name, $attr = "", $select = "", $company_id = ""){
            $grp = new helpdesk_prd($db);
            $grp = $grp->list_prd_sla($company_id);

            return self::bindDropdown($grp, $name, true, "tr_prd_tier_id", "prd_name", $attr, $select);
        }
        
        public static function loadOprSla($db, $name, $attr = "", $select = "", $company_id = ""){
            $grp = new helpdesk_opr($db);
            $grp = $grp->list_opr_sla($company_id);

            return self::bindDropdown($grp, $name, true, "tr_opr_tier_id", "opr_name", $attr, $select);
        }
        
        public static function loadDateMonthly($db, $name, $cus_comp_id = "", $attr = "", $select = ""){
            $report = new report($db);
            $report = $report->getsearchdate_monthly($cus_comp_id);
			
            $date = array();
            
            for($i=0; $i < count($report); $i++){
                $date_text = split(",",$report[$i]["fulldate"]);
                $dp_date = dateUtil::thai_date_ddmmyyyy($date_text[0]) . " - " . dateUtil::thai_date_ddmmyyyy($date_text[1]);
                
                $date[$i]["val"] = $report[$i]["fulldate"];
                $date[$i]["name"] = $dp_date;
            }

            return self::bindDropdown($date, $name, true, "val", "name", $attr, $select);
        }
        
         public static function loadYear($db, $name, $attr = "", $select = ""){
            $working_calendar = new working_calendar($db);
            $working_calendar = $working_calendar->getYear();

            return self::bindDropdown($working_calendar, $name, true, "year", "year", $attr, $select);
        }
        
        public static function loadPrd_tier2_master($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $objective = new Prd_tier2($db);
            $objective = $objective->listCombo_master($cus_company_id);

            return self::bindDropdown($objective, $name, true, "prd_tier_id", "prd_tier_name", $attr, $select);
        }
        
         public static function loadPrd_tier3_master($db, $name, $attr = "", $select = "", $cus_company_id = ""){
            $objective = new Prd_tier3($db);
            $objective = $objective->listCombo_master($cus_company_id);

            return self::bindDropdown($objective, $name, true, "prd_tier_id", "prd_tier_name", $attr, $select);
        }
        
        public static function loadStatus3($db, $name, $attr = "", $select = ""){
            $status = new status($db);
            $status = $status->listCombo3();

            return self::bindDropdown($status, $name, true, "status_id", "status_desc", $attr, $select);
        }
        
    }
?>
