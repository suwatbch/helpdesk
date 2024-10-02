<?php

    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/report.class.php";
    include_once "../../include/handler/action_handler.php";

   
//   $id = $_POST["id"];
//   $rpt_type_id = $_POST["rpt"];
//   $report_mode = $_POST["mode"];
//   $company = $_POST["c"];
//   $start = $_POST["s"];
//   $end = $_POST["e"];
//   $employee = $_POST["us"];
//   
    
//   $id = 0;
//   $rpt_type_id = 7;
//   $report_mode = 'save';
//   $company = "1";
//   $start = "20130601";
//   $end = "20130630";
//   $employee = "45";
    $report_mode = "";
    $rpt_type_id = "";
    $company = "";
    $start = "";
    $end = "";
    $employee= "";
    $id= "";
    
//    head[0][0] = "save";
//                head[0][1] = $("#report_type_id").val() ;
//                head[0][2] = $("#comp_id").val();
//                head[0][3] = $("#start_date").val();
//                head[0][4] = $("#end_date").val();
//                head[0][5] = $("#employee_id").val();
//                head[0][6] = $("#report_id").val();
   
//   if ( $_POST["head"]){ 
//       global $head ,$report_mode,$rpt_type_id,$company,$start,$end,$employee,$id;
       $head = $_POST["header"];
//       foreach ($head as $value) {
           $report_mode = $head[0];
           $rpt_type_id=  $head[1];
           $company=  $head[2];
           $start=  $head[3];
           $end=  $head[4];
           $employee=  $head[5];
           $id = $head[6];
           
//       }
       
       
//       echo " $id / $company / $start / $end / $employee "; 
//       exit();
       
       
//   }
//   if ( $_POST["t1"]){ 
       $arr_t1 = $_POST["t1"];
       
//       }
//   if ( $_POST["t2"]){ 
       $arr_t2 = $_POST["t2"];
       
//   if ( $_POST["t3"]){ 
       $arr_t3 = $_POST["t3"];
       
//       }

   
   if ($report_mode == 'save' && strUtil::isNotEmpty($rpt_type_id)){
       save($arr_t1,$arr_t2,$arr_t3,$id,$rpt_type_id,$company,$start,$end,$employee);
//       echo "id : $id / $company / $start / $end / $employee "; 
       
       
   }
   
   
   function save($t1,$t2,$t3,$id,$rpt_type_id,$company,$start,$end,$employee){
//       $act = new activity($db);
//
//        # save
//        $db->begin_transaction();
//
//        if ($act->isDuplicate($activity)){
//            alert_message(message_field_duplicate("Activity Date"));
//        } else {
//            if (strUtil::isEmpty($activity["activity_id"])){
//                $result = $act->insert($activity);
//            } else {
//                $result = $act->update($activity);
//            }
//        }
//
//        $db->end_transaction($result);
//
//        if ($result){
//            $activity = $act->getById($activity["activity_id"]);
//            alert_message(MESSAGE_SAVE_COMPLETE, "window.location = \'index.php?activity_list.php\'");
//        }
       global $header ,$db, $report ;
       $report = new report($db);
       
       $id = ($id == "") ? "0" : $id ;
//       echo $id; exit();
       $header = array(
           "id" => $id,
           "report_type_id" => $rpt_type_id,
           "cus_company_id" => $company,
           "start_date" => $start,
           "end_date" => $end,
           "response_id" => $employee,
           "user_id" => user_session::get_user_id()
       );
       
        # save
       $db->begin_transaction();
       
       $chkexists = chkexists($id);
       if ($chkexists != 0){
           $result = $report->update_rpt_header($header);
       }else {
           $result = $report->insert_rpt_header($header);
       }
       
       if ($result){
           $report_hd_id = $header["id"];
           $del = $report->delete_rpt_detail($report_hd_id);
           
           if ($del){
               if ($t1){
                   $table = 1;
                   $i = 1;
                   foreach ($t1 as $value) {
                       if ($value[0] != "" || $value[1] != "" ||  $value[2] != "" || $value[3] != "" || $value[4] != "" || $value[5] != "" ){
                           $result = $report->insert_rpt_detail($value,$i,$table,$report_hd_id,user_session::get_user_id());
                           $i++;
                       }
                   }
               }
               
               if ($t2){
                   $table = 2;
                   $i = 1;
                   foreach ($t2 as $value) {
                       if ($value[0] != "" || $value[1] != "" ||  $value[2] != "" || $value[3] != "" || $value[4] != "" || $value[5] != "" ){
                           $result = $report->insert_rpt_detail($value,$i,$table,$report_hd_id,user_session::get_user_id());
                           $i++;
                       }
                 }
               }
               
               if ($t3){
                   $table = 3;
                   $i = 1;
                   foreach ($t3 as $value) {
                       if ($value[0] != "" || $value[1] != "" ||  $value[2] != "" || $value[3] != "" || $value[4] != "" || $value[5] != "" ){
                           $result = $report->insert_rpt_detail($value,$i,$table,$report_hd_id,user_session::get_user_id());
                           $i++;
                       }
                 }
               }
           }
       }
       
       $db->end_transaction($result);
       if ($result){
            echo $report_hd_id;
        }else{
            echo "";
        }
       
       
       
   }
   
   function chkexists($id){
       global $db, $report ;
       
       $report = new report($db);
       return $report->chkexists_report($id);
       
   }
   
       
    
?>
