<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/customer.class.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/model/helpdesk_org.class.php";
    include_once "../../include/class/model/helpdesk_grp.class.php";
    include_once "../../include/class/model/helpdesk_subgrp.class.php";
    include_once "../../include/class/model/helpdesk_check_org.class.php";
    include_once "../../include/class/model/helpdesk_area.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $customer, $objective, $copy;
        
        if(strUtil::isNotEmpty($_REQUEST["cus_id"])){
            $objective = $_REQUEST["cus_id"];
            $copy = 0;
        }else if(strUtil::isNotEmpty($_REQUEST["c_cus_id"])){
            $objective = $_REQUEST["c_cus_id"];
            $copy = 1;
        }

        if (strUtil::isNotEmpty($objective)){
            $p = new customer($db);
            $customer = $p->getById($objective);
        }
    }

    function finalize(){
        
        global $db ,$dd_company_cus ,$dd_org_cus ,$dd_area_cus, $customer;
        $dd_company_cus = dropdown::loadCusCompany($db, "cus_company_id","required=\"true\" name=\"cus_company_id\" style=\"width: 100%;\"", $customer["cus_company_id"]);
        $dd_org_cus = dropdown::loadCusOrg($db,"org_cus", "required=\"true\" name=\"org_cus\" style=\"width: 100%;\"", $customer["org_cus"], $customer["cus_company_id"]);
        $dd_area_cus = dropdown::loadCusArea($db,"area_cus", "required=\"true\" name=\"area_cus\" style=\"width: 100%;\"", $customer["area_cus"]);
       
        $db->close();

    }

    function save(){
        global $db, $customer;

        # get input
        $customer = array(
            "cus_id" => $_REQUEST["cus_id"]
            , "code_cus" => $_REQUEST["code_cus"]
            , "firstname_cus" => $_REQUEST["firstname_cus"]
            , "lastname_cus" => $_REQUEST["lastname_cus"]
            , "phone_cus" => $_REQUEST["phone_cus"]
            , "ipaddress_cus" => $_REQUEST["ipaddress_cus"]
            , "email_cus" => $_REQUEST["email_cus"]
            , "cus_company_id" => $_REQUEST["cus_company_id"]
            , "org_cus" => $_REQUEST["org_cus"]
            , "area_cus" => $_REQUEST["area_cus"]
            , "office_cus" => $_REQUEST["office_cus"]
            , "dep_cus" => $_REQUEST["dep_cus"]
            , "site_cus" => $_REQUEST["site_cus"]
           // , "status_customer" => $_REQUEST["status_customer"]=='A'?'A':'I'
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
            , "create_incident" => $_REQUEST["create_incident"]
        );

            # save
            
            $db->begin_transaction();

            $p = new customer($db);

            if (strUtil::isEmpty($customer["cus_id"])){
                $result = $p->insert($customer);
            } else {
                $result = $p->update($customer);
            }

            $db->end_transaction($result);

            if ($result){
                $customer = $p->getById($customer["cus_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }
?>
