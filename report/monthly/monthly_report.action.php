<?php

    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/report.class.php";
    include_once "../../include/class/model/incident_type.class.php";
	
//    include_once "../../include/class/model/prd_tier3_resol.class.php";
    include_once "../../include/class/model/prd_tier3.class.php";
    include_once "../../include/handler/action_handler.php";
    
    
    function unspecified() {
        global $report ,$db, $chk_dup_data, $customerinfo;
        $report = new report($db);
		
        
//        $chk_dup_data = $report->chk_rpt_dup($_GET["comp"], $_GET["start"], $_GET["end"]);
        
//        $type = "report_aging";
        getcriteria($_GET["comp"]);
        $customerinfo = getcustomerinfo($_GET["comp"]); 
    }
    
    
    function getcriteria($comp_id){
        global $report ,$criteria ,$db;
        
        $report = new report($db);
//        $page = strUtil::nvl($_REQUEST["page"], "1");

        $criteria =  $report->getcustomerzone($comp_id);
    }
    
    function getincidenttype($comp_id,$display_inc){
         global $incident_type ,$db;
         
         $incident_type = new incident_type($db);
         
         return $incident_type->listCombo_display($comp_id,$display_inc);
//         return
        
    }
    
    function countIncident_typezone($comp_id, $inctype_id, $sdate, $edate,$zone_id,$project_id,$display_inc){
        global $report;
        
        return $report->countincident_bytype_zone($comp_id, $inctype_id, $sdate, $edate,$zone_id,$project_id,$display_inc);
        
    }
    
    function getclass3($comp_id){
         global $Prd_tier3 ,$db;
         
         $Prd_tier3 = new Prd_tier3($db);
         
//         return $Prd_tier3->listnonClass3("","",$comp_id,"Y");  
         return $Prd_tier3->listnonClass3_BPM("","",$comp_id,"Y");
    }
    
    function countIncident_typezoneclass3($comp_id, $inctype_id, $class3_id, $sdate, $edate,$zone_id,$project_id,$display_inc){
        global $report;
        
        return $report->countincident_bytype_zone_class3($comp_id, $inctype_id, $class3_id, $sdate, $edate,$zone_id,$project_id,$display_inc);
        
    }
    
    
    
    function getadditional($comp_id,$start_date,$end_date,$report_type_id,$project_id){
        //get_rptaddt_header
         global $report;
         
         return $report->get_rptaddt_header($comp_id,$start_date,$end_date,$report_type_id,$project_id);
        
    }
    
    
    function getadditional_dt($report_id){
        global $report;
         
         return $report->get_rptaddt_detail($report_id);
    }
    
	function getcustomerinfo($comp_id){
        global $data,$db;
        $report = new report($db);
        $data =  $report->getCustomerInfo($comp_id);
		return $data;
    }
?>
