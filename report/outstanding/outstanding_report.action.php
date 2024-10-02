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
//        
//        $type = "report_aging";
//        getcriteria($type);
        
//        getClassdata($_GET["comp"]);
          $customerinfo = getcustomerinfo($_GET["comp"]); 
    }
    
    function getClassdata($comp_id,$class3_fr, $class3_to,$project_id,$display_inc){
        global $report ,$db;
        
//        $report = new report($db);
//        $page = strUtil::nvl($_REQUEST["page"], "1");

        return  $report->out_getProdClassCurrent($comp_id,$class3_fr, $class3_to,$project_id,$display_inc);
        
   }
   
   function balanceforward($comp_id,$date,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
        global $report ,$db;
        
//        $report = new report($db);
        return  $report->out_balanceforward($comp_id,$date,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc);
   }
   
   function open($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
       global $report ,$db;
        
//        $report = new report($db);
//        $page = strUtil::nvl($_REQUEST["page"], "1");

        return  $report->out_open($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc);
       
   }
   
   function closed_complete($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
       global $report ,$db;
       
      return  $report-> out_closed_complete($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc);
   }
   
   
   function closed_cancel($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
       global $report ,$db;
       
      return  $report-> out_closed_cancel($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc);
   }
   
   function closed_nocontact($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
       global $report ,$db;
       
      return  $report-> out_closed_nocontact($comp_id,$sdate,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc);
   }
   
   
   function outstanding_bystatus($comp_id,$date,$edate,$class1,$class2,$class3,$status,$zone_fr,$zone_to,$project_id,$display_inc){
       global $report ,$db;
       
//       if ($status == 'new'){
//            return  $report-> out_outst_new($comp_id,$date,$edate,$class1,$class2,$class3,$status,$zone_fr,$zone_to,$project_id,$display_inc);
//       }else if ($status == 'assign'){
//            return  $report-> out_outst_assign($comp_id,$date,$edate,$class1,$class2,$class3,$status,$zone_fr,$zone_to,$project_id,$display_inc);
//       }else {
          return  $report-> out_outst_status($comp_id,$date,$edate,$class1,$class2,$class3,$status,$zone_fr,$zone_to,$project_id,$display_inc); 
//       }
   }
   
   //
   function outstanding_all($comp_id,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc){
       global $report ,$db;

      return  $report-> out_outst_all($comp_id,$edate,$class1,$class2,$class3,$zone_fr,$zone_to,$project_id,$display_inc); 
   }
   
   function getcustomerinfo($comp_id){
        global $data,$db;
        $report = new report($db);
        $data =  $report->getCustomerInfo($comp_id);
		return $data;
    }
?>
