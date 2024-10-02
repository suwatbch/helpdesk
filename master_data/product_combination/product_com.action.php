<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_prd_com.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/model/prd_tier1.class.php";
    include_once "../../include/class/model/prd_tier2.class.php";
    include_once "../../include/class/model/prd_tier3.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $objective, $copy;
        
        if(strUtil::isNotEmpty($_REQUEST["tr_prd_tier_id"])){
            $objective = $_REQUEST["tr_prd_tier_id"];
            $copy = 0;
        }else if(strUtil::isNotEmpty($_REQUEST["c_tr_prd_tier_id"])){
            $objective = $_REQUEST["c_tr_prd_tier_id"];
            $copy = 1;
        }

        if (strUtil::isNotEmpty($objective)){
            $p = new helpdesk_prd_com($db);
            $objective = $p->getById($objective);
        }
    }

    function finalize(){
        global $db, $dd_cus_company, $objective, $dd_prd_tier_lv1, $dd_prd_tier_lv2 ,$dd_prd_tier_lv3;
        $dd_cus_company = dropdown::loadCusCompany($db, "cus_comp_id","required=\"true\" name=\"cus_comp_id\" style=\"width: 100%;\"", $objective["cus_company_id"]);
        $dd_prd_tier_lv1 = dropdown::loadPrd_tier1($db, "prd_tier_lv1_id","required=\"true\" name=\"prd_tier_lv1_id\" style=\"width: 100%;\"", $objective["prd_tier_lv1_id"], $objective["cus_company_id"] );
        $dd_prd_tier_lv2 = dropdown::loadPrd_tier2_master($db, "prd_tier_lv2_id","required=\"true\" name=\"prd_tier_lv2_id\" style=\"width: 100%;\"", $objective["prd_tier_lv2_id"], $objective["cus_company_id"]);
        $dd_prd_tier_lv3 = dropdown::loadPrd_tier3_master($db, "prd_tier_lv3_id","required=\"true\" name=\"prd_tier_lv3_id\" style=\"width: 100%;\"", $objective["prd_tier_lv3_id"], $objective["cus_company_id"]);
        $db->close();

    }

    function save(){
        global $db, $objective;

        # get input
        $objective = array(
            "tr_prd_tier_id" => $_REQUEST["tr_prd_tier_id"]
            , "cus_comp_id" => $_REQUEST["cus_comp_id"]
            , "prd_tier_lv1_id" => $_REQUEST["prd_tier_lv1_id"]
            , "prd_tier_lv2_id" => $_REQUEST["prd_tier_lv2_id"]
            , "prd_tier_lv3_id" => $_REQUEST["prd_tier_lv3_id"]
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );

            # save
            $db->begin_transaction();

            $p = new helpdesk_prd_com($db);

            if (strUtil::isEmpty($objective["tr_prd_tier_id"])){
                $result = $p->insert($objective);
            } else {
                $result = $p->update($objective);
            }

            $db->end_transaction($result);

            if ($result){
                $objective = $p->getById($objective["tr_prd_tier_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }
?>
