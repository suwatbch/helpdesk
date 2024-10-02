<?php
    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/report.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $report ,$db,$customerinfo;
        $report = new report($db);
        
        $type = "report_aging";
        getcriteria($type);
        $customerinfo = getcustomerinfo($_GET["comp"]); 
    }

    function finalize(){
//        global $db;
//        $db->close();
    }
    
    function getcriteria($type){
        global $report ,$criteria,$db;
        
        $report = new report($db);
        $page = strUtil::nvl($_REQUEST["page"], "1");

        $criteria =  $report->getCriteria($type, $page);
        
   }
   
   function countincident($company, $start_date, $inc_type, $class1, $class2, $class3,$min,$max ,$project_id, $display_inc){
       global $db, $report;
       
       if ($max  == 0){ $max = ""; }
       
       $filter = array(
            "company_id" => $company
           , "project_id" => $project_id
            ,"start_date" => $start_date
            , "inc_type_id" => $inc_type
           , "class1_id" => $class1
           , "class2_id" => $class2
           , "class3_id" => $class3
           , "value_min" => $min
           , "value_max" => $max 
           , "display_inc" => $display_inc
           );
       
       return $report->aging_countIncident_byage($filter);
   }
   
   function getclass_data($company_id,$start,$class3_fr, $class3_to,$project_id,$display_inc ){
       global $db,$report;
       
//       $report = new report($db);
       return $report->aging_getProdClassCurrent($company_id,$start,$class3_fr, $class3_to,$project_id,$display_inc );
       
   }

   function getcustomerinfo($comp_id){
        global $data,$db;
        $report = new report($db);
        $data =  $report->getCustomerInfo($comp_id);
		return $data;
    } 	
?>
