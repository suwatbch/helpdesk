<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_prd.class.php";
    include_once "../../include/class/model/helpdesk_opr.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/model/helpdesk_resolve.class.php";
    include_once "../../include/class/model/priority.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective, $copy, $list_priority, $s_list_priority;
        
        $p = new helpdesk_resolve($db);
        
        if(strUtil::isNotEmpty($_REQUEST["id_resolve_priority"])){
            $objective = $_REQUEST["id_resolve_priority"];
            $copy = 0;
        }else if(strUtil::isNotEmpty($_REQUEST["c_id_resolve_priority"])){
            $objective = $_REQUEST["c_id_resolve_priority"];
            $copy = 1;
        }

        if (strUtil::isNotEmpty($objective)){
            $objective = $p->getById($objective);
        }
        
        $list_priority = $p->list_priority();
        $s_list_priority = $list_priority["data"];
    }

    function finalize(){
        global $db, $dd_cus_company, $objective, $dd_prd_tire, $dd_opr_tire, $dd_priority;
        $dd_cus_company = dropdown::loadCusCompany($db, "cus_comp_id","required=\"true\" name=\"cus_comp_id\" style=\"width: 100%;\"", $objective["cus_comp_id"]);
        if(strUtil::isNotEmpty($objective["cus_comp_id"])){
            $dd_prd_tire = dropdown::loadPrdSla($db, "tr_prd_tier_id","required=\"true\" name=\"tr_prd_tier_id\" style=\"width: 100%;\"", $objective["tr_prd_tier_id"], $objective["cus_comp_id"]);
            $dd_opr_tire = dropdown::loadOprSla($db, "tr_opr_tier_id","required=\"true\" name=\"tr_opr_tier_id\" style=\"width: 100%;\"", $objective["tr_opr_tier_id"], $objective["cus_comp_id"]);
        }else{
            $dd_prd_tire = dropdown::select("tr_prd_tier_id", "<option></option>", "style=\"width: 100%\"");
            $dd_opr_tire = dropdown::select("tr_opr_tier_id", "<option></option>", "style=\"width: 100%\"");
        }
        $dd_priority = dropdown::loadPriority($db, "priority_id", "name=\"priority_id\" style=\"width: 100%;\" ", $objective["priority_id"]);
        $db->close();

    }

    function save(){
        global $db, $objective;
        
        $sum_resolve_sla = strUtil::sum_sla($_REQUEST["resolve_sla"]);

        # get input
        $objective = array(
            "id_resolve_priority" => $_REQUEST["id_resolve_priority"]
            , "cus_comp_id" => $_REQUEST["cus_comp_id"]
            , "tr_prd_tier_id" => $_REQUEST["tr_prd_tier_id"]
            , "tr_opr_tier_id" => $_REQUEST["tr_opr_tier_id"]
            , "resolve_sla" => $_REQUEST["resolve_sla"]
            , "sum_resolve_sla" => $sum_resolve_sla
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
            , "priority_id" => $_REQUEST["priority_id"]
             , "chk_priority" => $_REQUEST["chk_priority"]
            , "sum_priority" => $_REQUEST["sum_priority"]
        );
            # save
            $db->begin_transaction();

            $p = new helpdesk_resolve($db);

            if (strUtil::isEmpty($objective["id_resolve_priority"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
                $result = $p->insert($objective);
            }

            $db->end_transaction($result);

            if ($result){
                //echo $objective["id_resolve_priority"]; exit();
                $objective = $p->getById($objective["id_resolve_priority"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }
?>
