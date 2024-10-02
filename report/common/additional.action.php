<?php

    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/report.class.php";
    include_once "../../include/handler/action_handler.php";

    $report_mode = "";
    $rpt_type_id = "";
    $company = "";
    $start = "";
    $end = "";
    $employee= "";
    $id= "";
    $final = "";
    $project_id = "";

    $head = $_POST["header"];
    $arr_detail = $_POST["detail"];

   $report_mode = $head[0];
   $rpt_type_id=  $head[1];
   $company=  $head[2];
   $start=  $head[3];
   $end=  $head[4];
   $employee=  $head[5];
   $id = $head[6];
   $final = $head[7];
   $project_id = $head[8];
   
//   echo print_r($arr_detail);
           
   if ($final == 'Y'){
      $employee =  user_session::get_user_id();
   }

  
       
   
   if ($report_mode == 'save' && strUtil::isNotEmpty($rpt_type_id)){
       save($arr_detail,$id,$rpt_type_id,$company,$start,$end,$employee,$final,$project_id); 
   }
   
   
   function save($arr_detail,$id,$rpt_type_id,$company,$start,$end,$employee,$final,$project_id){
       global $header ,$db, $report ;
       $report = new report($db);
       
       $id = ($id == "") ? "0" : $id ;
       $header = array(
           "id" => $id,
           "project_id" => $project_id,
           "report_type_id" => $rpt_type_id,
           "cus_company_id" => $company,
           "start_date" => $start,
           "end_date" => $end,
           "response_id" => $employee,
           "user_id" => user_session::get_user_id(),
           "final" => $final,
           "text1" => (strUtil::isNotEmpty($arr_detail[1]) ? str_replace("'", " ", $arr_detail[1]):""),
           "text2" => (strUtil::isNotEmpty($arr_detail[2]) ? str_replace("'", " ", $arr_detail[2]):""),
           "text3" => (strUtil::isNotEmpty($arr_detail[3]) ? str_replace("'", " ", $arr_detail[3]):""),
           "text4" => (strUtil::isNotEmpty($arr_detail[4]) ? str_replace("'", " ", $arr_detail[4]):""),
           "text5" => (strUtil::isNotEmpty($arr_detail[5]) ? str_replace("'", " ", $arr_detail[5]):""),
           "text6" => (strUtil::isNotEmpty($arr_detail[6]) ? str_replace("'", " ", $arr_detail[6]):""),
           "text7" => (strUtil::isNotEmpty($arr_detail[7]) ? str_replace("'", " ", $arr_detail[7]):""),
           "text8" => (strUtil::isNotEmpty($arr_detail[8]) ? str_replace("'", " ", $arr_detail[8]):""),
           "text9" => (strUtil::isNotEmpty($arr_detail[9]) ? str_replace("'", " ", $arr_detail[9]):""),
           "text10" => (strUtil::isNotEmpty($arr_detail[10]) ? str_replace("'", " ", $arr_detail[10]):""),
           "text11" => (strUtil::isNotEmpty($arr_detail[11]) ? str_replace("'", " ", $arr_detail[11]):""),
           "text12" => (strUtil::isNotEmpty($arr_detail[12]) ? str_replace("'", " ", $arr_detail[12]):""),
           "text13" => (strUtil::isNotEmpty($arr_detail[13]) ? str_replace("'", " ", $arr_detail[13]):""),
           "text14" => (strUtil::isNotEmpty($arr_detail[14]) ? str_replace("'", " ", $arr_detail[14]):""),
           "text15" => (strUtil::isNotEmpty($arr_detail[15]) ? str_replace("'", " ", $arr_detail[15]):""),
           "text16" => (strUtil::isNotEmpty($arr_detail[16]) ? str_replace("'", " ", $arr_detail[16]):""),
           "text17" => (strUtil::isNotEmpty($arr_detail[17]) ? str_replace("'", " ", $arr_detail[17]):""),
           "text18" => (strUtil::isNotEmpty($arr_detail[18]) ? str_replace("'", " ", $arr_detail[18]):""),
           
           "BPM_text1" => (strUtil::isNotEmpty($arr_detail[19]) ? str_replace("'", " ", $arr_detail[19]):""),
           "BPM_text2" => (strUtil::isNotEmpty($arr_detail[20]) ? str_replace("'", " ", $arr_detail[20]):""),
           "BPM_text3" => (strUtil::isNotEmpty($arr_detail[21]) ? str_replace("'", " ", $arr_detail[21]):""),
           "BPM_text4" => (strUtil::isNotEmpty($arr_detail[22]) ? str_replace("'", " ", $arr_detail[22]):""),
           "BPM_text5" => (strUtil::isNotEmpty($arr_detail[23]) ? str_replace("'", " ", $arr_detail[23]):""),
           "BPM_text6" => (strUtil::isNotEmpty($arr_detail[24]) ? str_replace("'", " ", $arr_detail[24]):""),
           "BPM_text7" => (strUtil::isNotEmpty($arr_detail[25]) ? str_replace("'", " ", $arr_detail[25]):""),
           "BPM_text8" => (strUtil::isNotEmpty($arr_detail[26]) ? str_replace("'", " ", $arr_detail[26]):""),
           "BPM_text9" => (strUtil::isNotEmpty($arr_detail[27]) ? str_replace("'", " ", $arr_detail[27]):""),
           "BPM_text10" => (strUtil::isNotEmpty($arr_detail[28]) ? str_replace("'", " ", $arr_detail[28]):""),
           "BPM_text11" => (strUtil::isNotEmpty($arr_detail[29]) ? str_replace("'", " ", $arr_detail[29]):""),
           "BPM_text12" => (strUtil::isNotEmpty($arr_detail[30]) ? str_replace("'", " ", $arr_detail[30]):""),
           "BPM_text13" => (strUtil::isNotEmpty($arr_detail[31]) ? str_replace("'", " ", $arr_detail[31]):""),
           "BPM_text14" => (strUtil::isNotEmpty($arr_detail[32]) ? str_replace("'", " ", $arr_detail[32]):""),
           "BPM_text15" => (strUtil::isNotEmpty($arr_detail[33]) ? str_replace("'", " ", $arr_detail[33]):""),
           "BPM_text16" => (strUtil::isNotEmpty($arr_detail[34]) ? str_replace("'", " ", $arr_detail[34]):""),
           "BPM_text17" => (strUtil::isNotEmpty($arr_detail[35]) ? str_replace("'", " ", $arr_detail[35]):""),
           "BPM_text18" => (strUtil::isNotEmpty($arr_detail[36]) ? str_replace("'", " ", $arr_detail[36]):"")
       );
//       echo print_r($header);
       
       
        # save
//       $db->begin_transaction();
       
       $chkexists = chkexists($id);
       if ($chkexists != 0){
           $result = $report->update_rpt_header($header);
       }else {
           $result = $report->insert_rpt_header($header);
       }
       
//       $db->end_transaction($result);
       if ($result){
            echo $header["id"];;
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
