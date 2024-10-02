<?php
    include_once "../../include/error_message.php";
    include_once "../../include/function.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/model/sale_group.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/activity_plan.class.php";
    include_once "../../include/class/model/activity.class.php";
    include_once "../../include/handler/action_handler.php";
    include_once "../../include/class/mail.class.php";
//    require dirname(dirname(__FILE__))."/include/class/mail.class.php";   
    
    function unspecified() {
        global  $start_date, $end_date;
        
        $year = date("Y");
        $month = date("m");
        list($start_date, $end_date) = dateUtil::getMonthRange($year, $month);
        
        search();
    }

    function finalize(){
        global $db;
        global $dd_sale_group;
        

        if (strUtil::isEmpty(user_session::get_sale_group_id())){
            $dd_sale_group = dropdown::loadSaleGroup($db, "sale_group_id", "", $_REQUEST["sale_group_id"]);
        }
        
        
        $db->close();
    }

   function search(){
        global $activity_plan,$start_date,$end_date,$project_id,$employee_id,$type_status; 

        $start_date = $_REQUEST["start_date"];
        $end_date = $_REQUEST["end_date"];
        $project_id = $_REQUEST["project_id"];
        $employee_id = $_REQUEST["employee_id"];
        $type_status = $_REQUEST["type_status"];
        
//        echo "$type_status";
         
        if (strUtil::isEmpty($start_date) && strUtil::isEmpty($end_date) || strUtil::isEmpty($type_status)){
            list($start_date, $end_date) = dateUtil::getMonthRange(date("Y"), date("m"));
             $type_status = 'WP';
        } else {
            $start_date = dateUtil::date_ymd($start_date);
            $end_date = dateUtil::date_ymd($end_date);
        }
        
        $activity_plan = list_activity($start_date, $end_date,$employee_id,$project_id,$type_status);
    }
    
    
    function list_activity($start_date, $end_date,$employee_id,$project_id,$type_status){
        global $db;

        $activity = new activity_plan($db);
        
        $cratiria_search = array(
            "employee_id" => $employee_id
            , "start_date" => $start_date
            , "end_date" => $end_date
            , "project_id" => $project_id
            , "appv_id" => user_session::get_sale_id()
        );
        
        
        if (strUtil::isEmpty(user_session::get_sale_group_id())){
            //for admin : search by sale_group_id
            $cratiria_search["sale_group_id"] = $_REQUEST["sale_group_id"];
        }
        $page = strUtil::nvl($_REQUEST["page"], "1");

        return $activity->searchApprove($cratiria_search,$type_status, $page);
    }
    
   function approve(){
        $result = save("CP");
        if ($result != TRUE){
            alert_message(MESSAGE_SAVE_COMPLETE, "window.location = \'index.php?approve_list.php\'",SUCCESS_MESSAGE);
       } else{
           alert_message(message_field_duplicate("Activity Date"), "window.location = \'index.php?approve_list.php\'",ERROR_MESSAGE);
       }
    }

    function reject(){
        $result = save("RJ");
        if ($result != TRUE){
            alert_message(MESSAGE_SAVE_COMPLETE, "window.location = \'index.php?approve_list.php\'",SUCCESS_MESSAGE);
       } else{
           alert_message(message_field_duplicate("Activity Date"), "window.location = \'index.php?approve_list.php\'",ERROR_MESSAGE);
       }
    }
    
     function save($activity_status){
        global $db, $activity, $err_dup ;

        $act_plan = new activity_plan($db);
        $act = new activity($db);
            
        # variable
        $action_date = dateUtil::current_date_time();
        $selected_id = $_REQUEST["selected"];
        $id_array = explode(",", $selected_id);
        
        foreach ($id_array as $value) {
            $err_dup = "";
            
            # get input
            $activity = $act_plan->getById($value);
            $activity["activity_plan_status"] = $activity_status;
            $activity["reject_remark"] = $_REQUEST["reject_remark"];
            $activity["action_by"] = user_session::get_sale_id();
            $activity["action_date"] = $action_date;
            $activity["approve_by"] = user_session::get_sale_id();
            $activity["approve_date"] = $action_date;
            
            
            # save
            $db->begin_transaction();
            $result = $act_plan->update($activity);

            #insert activity if Approved
            if ($result and $activity_status == "CP"){
//                $activity = $act->getPlanById($value);
                
                #change value for prepare to insert activity
                $activity["activity_date"] = $activity["activity_plan_date"];
                $activity["activity"] = $activity["activity_plan"];
                $activity["activity_type"] = 'P';
                $activity["activity_status"] = 'SD';
                $activity["action_by"] = user_session::get_sale_id();
                $activity["action_date"] = $action_date;

                if ($act->isDuplicate($activity) == FALSE){
                   // not Dup >> insert
                  $result = $act->insert($activity);
                }
            }

            $db->end_transaction($result); 
            if ($result){
                $err_insert = FALSE;
            } else {
                $err_insert = TRUE;
            }
            
        }

      return $err_insert;
    }

#comment for send email function   
//        $sql = "SELECT comp.company_name, comp.short_name AS compay_shortname, "
//            . "s.sale_id, s.employee_code, s.title, s.sale_first_name AS firstname, "
//            . "s.sale_last_name AS lastname, CONCAT( s.sale_first_name, ' ', s.sale_last_name ) AS sale_full_name,"
//            . "s.email, pj.project_code, pj.project_name, ac.activity_plan, "
//            . "ac.activity_plan_date, ac.start_time, ac.end_time, cus.customer_name,"
//            . "obj.objective_name, nex.next_step_name "
//            . "FROM tb_activity_plan ac "
//            . "INNER JOIN tb_sale s ON s.sale_id = ac.sale_id "
//            . "INNER JOIN tb_project pj ON pj.project_id = ac.project_id "
//            . "INNER JOIN tb_customer cus ON cus.customer_id = ac.customer_id "
//            . "INNER JOIN tb_objective obj ON obj.objective_id = ac.objective_id "
//            . "INNER JOIN tb_next_step nex ON nex.next_step_id = ac.next_step_id "
//            . "LEFT JOIN tb_company comp ON comp.company_id = s.company_id "
//            . "WHERE ac.activity_plan_id "
//            . "IN ( 2, 3 ) ";
    
//    function sendemail(){
//        global $send_result;
////        include 'sendmail.php';
//        $email = new mail();
//    $sale_name = "Mananya Piboonsak";
//    $to = "mananya.p@samartcorp.com";
//    //$to = "seksan.m@samtel.samartcorp.com";
//    $subject = "TESTTTTTTTTTTTT";
//
//    $messsage = "<font size=2>"
//                . "ส่งจากแพรเองจ้าาาาาาาาาาาาา..."
//                . "</font>";
//    $send_result = $email->send($to, $subject, $messsage);

        
//        global $db;
//        $mail = new mail();
//
//        # begin transaction
////        $db->begin_transaction();
////
////        try {
//                    $to = "mananya.p@samartcorp.com";
//                    $sale_name = "Mananya Piboonsak";
////                    $subject = "Sale Report Notification";
//                    $message = "<font size=2>test by PEAR</font>";
////                    $messsage = "<font size=2>"
////                                        . "เรียน คุณ  $sale_name"
////                                        . "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
////                                        . "เนื่องจากในวันที่ ".display_date($date_check)." <U>ท่านยังไม่ได้ส่งรายงานการปฏิบัติงาน</U>  กรุณาเข้าสู่ระบบเพื่อทำการบันทึกข้อมูลการปฏิบัติงานในวันดังกล่าว"
////                                        . "<br>โดยสามารถเข้าสู่ระบบได้ที่  http://star.samartcorp.com"
////                                        . "</font>";
//
////                    $success =  mail::send($to, $subject, $messsage);
//                    $mail ->send($to, $subject, $messsage);
//
////        } catch (Exception $ex) {
////            $error =  $ex->getMessage();
////        }
////
////        # update log
//////        update_log($log_id, $mail, $error);
////
////        # end transaction
////        $db->end_transaction(true);
////
////        $db->close();
//    }
    
?>
