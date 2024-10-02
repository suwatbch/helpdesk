<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_opr_com.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/model/opr_tier1.class.php";
    include_once "../../include/class/model/opr_tier2.class.php";
    include_once "../../include/class/model/opr_tier3.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective, $copy;
        
        if(strUtil::isNotEmpty($_REQUEST["tr_opr_tier_id"])){
            $objective = $_REQUEST["tr_opr_tier_id"];
            $copy = 0;
        }else if(strUtil::isNotEmpty($_REQUEST["c_tr_opr_tier_id"])){
            $objective = $_REQUEST["c_tr_opr_tier_id"];
            $copy = 1;
        }

        if (strUtil::isNotEmpty($objective)){
            $p = new helpdesk_opr_com($db);
            $objective = $p->getById($objective);
        }
    }

    function finalize(){
        global $db, $dd_cus_company, $objective, $dd_opr_tier_lv1, $dd_opr_tier_lv2 ,$dd_opr_tier_lv3;
        $dd_cus_company = dropdown::loadCusCompany($db, "cus_comp_id","required=\"true\" name=\"cus_comp_id\" style=\"width: 100%;\"", $objective["cus_company_id"]);
        $dd_opr_tier_lv1 = dropdown::loadOpr_tier1($db, "opr_tier_lv1_id","required=\"true\" name=\"opr_tier_lv1_id\" style=\"width: 100%;\"", $objective["opr_tier_lv1_id"]);
        $dd_opr_tier_lv2 = dropdown::loadOpr_tier2_master($db, "opr_tier_lv2_id","required=\"true\" name=\"opr_tier_lv2_id\" style=\"width: 100%;\"", $objective["opr_tier_lv2_id"]);
        $dd_opr_tier_lv3 = dropdown::loadOpr_tier3_master($db, "opr_tier_lv3_id","required=\"true\" name=\"opr_tier_lv3_id\" style=\"width: 100%;\"", $objective["opr_tier_lv3_id"]);
        $db->close();

    }

    function save(){
        global $db, $objective;

        # get input
        $objective = array(
            "tr_opr_tier_id" => $_REQUEST["tr_opr_tier_id"]
            , "cus_comp_id" => $_REQUEST["cus_comp_id"]
            , "opr_tier_lv1_id" => $_REQUEST["opr_tier_lv1_id"]
            , "opr_tier_lv2_id" => $_REQUEST["opr_tier_lv2_id"]
            , "opr_tier_lv3_id" => $_REQUEST["opr_tier_lv3_id"]
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );
            # save
            $db->begin_transaction();

            $p = new helpdesk_opr_com($db);

            if (strUtil::isEmpty($objective["tr_opr_tier_id"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
            }

            $db->end_transaction($result);

            if ($result){
                $objective = $p->getById($objective["tr_opr_tier_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }

?>
