<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";

    php_header::text_html_utf8();
    global $db;
    
    if($_REQUEST["action"]== "user_specorg"){
            $table = "helpdesk_tr_user_specorg";
            $condition = "company_id = '{$_REQUEST["company_id"]}' AND org_id = '{$_REQUEST["org_id"]}' AND user_id = '{$_REQUEST["user_id"]}' ";
            if (strUtil::isNotEmpty($_REQUEST["specorg_id"])){
                $condition .= " AND specorg_id <> '{$_REQUEST["specorg_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_user";
            $condition = "company_id = '{$_REQUEST["company_id"]}' AND org_id = '{$_REQUEST["org_id"]}' AND user_id = '{$_REQUEST["user_id"]}' ";
            if (strUtil::isNotEmpty($_REQUEST["specorg_id"])){
                $condition .= " AND specorg_id <> '{$_REQUEST["specorg_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "company"){
            $table = "helpdesk_company";
            $condition = "company_name = '{$_REQUEST["company_name"]}'";
            if (strUtil::isNotEmpty($_REQUEST["company_id"])){
                $condition .= " AND company_id <> '{$_REQUEST["company_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }

    }else if($_REQUEST["action"]== "user"){
            $table = "helpdesk_user";
            # check duplicate user code
            $condition = "user_code = '{$_REQUEST["user_code"]}'";
            if (strUtil::isNotEmpty($_REQUEST["user_id"])){
                $condition .= " AND user_id <> '{$_REQUEST["user_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);
            
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            # check duplicate employee code
            $condition = "employee_code = '{$_REQUEST["employee_code"]}'";
            if (strUtil::isNotEmpty($_REQUEST["user_id"])){
                $condition .= " AND user_id <> '{$_REQUEST["user_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);
            
            if ($rows > 0){
                echo "2";
                exit();
            }

    }else if($_REQUEST["action"]== "customer_company"){
            $table = "helpdesk_cus_company";
            $condition = "cus_company_name = '{$_REQUEST["cus_company_name"]}'";
            if (strUtil::isNotEmpty($_REQUEST["cus_company_id"])){
                $condition .= " AND cus_company_id <> '{$_REQUEST["cus_company_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "customer_organization"){
            $table = "helpdesk_cus_org";
            $condition = "cus_company_id = '{$_REQUEST["cus_company_id"]}'";
            if (strUtil::isNotEmpty($_REQUEST["cus_org_id"])){
                $condition .= " AND cus_org_id <> '{$_REQUEST["cus_org_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo '1';
                exit();
            }
    }else if($_REQUEST["action"]== "customer_area"){
            $table = "helpdesk_cus_zone_area";
            $condition = "area_cus = '{$_REQUEST["area_cus"]}'";
            if (strUtil::isNotEmpty($_REQUEST["id"])){
                $condition .= " AND id <> '{$_REQUEST["id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo '1';
               exit();
            }
            
            $condition = "area_cus_name = '{$_REQUEST["area_cus_name"]}'";
            if (strUtil::isNotEmpty($_REQUEST["id"])){
                $condition .= " AND id <> '{$_REQUEST["id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo '2';
                exit();
            }
    }else if($_REQUEST["action"]== "customer_zone"){
             $table = "helpdesk_cus_zone";
            $condition = "shortname = '{$_REQUEST["shortname"]}' AND cus_company_id = {$_REQUEST["cus_company_id"]}";
            if (strUtil::isNotEmpty($_REQUEST["zone_id"])){
                $condition .= " AND zone_id <> '{$_REQUEST["zone_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo '1';
               exit();
            }
            
            $condition = "name = '{$_REQUEST["name"]}' AND cus_company_id = {$_REQUEST["cus_company_id"]}";
            if (strUtil::isNotEmpty($_REQUEST["zone_id"])){
                $condition .= " AND zone_id <> '{$_REQUEST["zone_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo '2';
               exit();
            }
    }else if($_REQUEST["action"]== "incident_type"){
            $table = "helpdesk_incident_type";
            $condition = "ident_type_desc = '{$_REQUEST["ident_type_desc"]}' AND cus_comp_id = '{$_REQUEST["cus_comp_id"]}'";
            if (strUtil::isNotEmpty($_REQUEST["ident_type_id"])){
                $condition .= " AND ident_type_id <> '{$_REQUEST["ident_type_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "priority"){
            $table = "helpdesk_priority";
            $condition = "priority_desc = '{$_REQUEST["priority_desc"]}'";
            if (strUtil::isNotEmpty($_REQUEST["priority_id"])){
                $condition .= " AND priority_id <> '{$_REQUEST["priority_id"]}'";
            }
            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }

    }else if($_REQUEST["action"]== "product_class"){
            $table = "helpdesk_prd_tier";
            $condition = "prd_tier_name = '{$_REQUEST["prd_tier_name"]}' AND cus_comp_id = '{$_REQUEST["cus_comp_id"]}'";
            if (strUtil::isNotEmpty($_REQUEST["prd_tier_id"])){
                $condition .= " AND prd_tier_id <> '{$_REQUEST["prd_tier_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo "1";
               exit();
            }
    }else if($_REQUEST["action"]== "operation"){
            $table = "helpdesk_opr_tier";
            $condition = "opr_tier_name  = '{$_REQUEST["opr_tier_name"]}' AND cus_comp_id = '{$_REQUEST["cus_comp_id"]}'";
            if (strUtil::isNotEmpty($_REQUEST["opr_tier_id"])){
                $condition .= " AND opr_tier_id <> '{$_REQUEST["opr_tier_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo "1";
               exit();
            }
    }else if($_REQUEST["action"]== "product_combination"){
            $table = "helpdesk_tr_prd_tier";
            $condition = "prd_tier_lv1_id = '{$_REQUEST["prd_tier_lv1_id"]}' AND prd_tier_lv2_id = '{$_REQUEST["prd_tier_lv2_id"]}'"
                          . " AND prd_tier_lv3_id = '{$_REQUEST["prd_tier_lv3_id"]}' AND cus_company_id = '{$_REQUEST["cus_comp_id"]}'";
            if (strUtil::isNotEmpty($_REQUEST["tr_prd_tier_id"])){
                $condition .= " AND tr_prd_tier_id <> '{$_REQUEST["tr_prd_tier_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo "1";
               exit();
            }
    }else if($_REQUEST["action"]== "operation_combination"){
            $table = "helpdesk_tr_opr_tier";
            $condition = "opr_tier_lv1_id = '{$_REQUEST["opr_tier_lv1_id"]}' AND opr_tier_lv2_id = '{$_REQUEST["opr_tier_lv2_id"]}'"
                          . " AND opr_tier_lv3_id = '{$_REQUEST["opr_tier_lv3_id"]}' AND cus_company_id = '{$_REQUEST["cus_comp_id"]}'";
            if (strUtil::isNotEmpty($_REQUEST["tr_opr_tier_id"])){
                $condition .= " AND tr_opr_tier_id <> '{$_REQUEST["tr_opr_tier_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo "1";
               exit();
            }

    }else if($_REQUEST["action"]== "aging"){
            $table = "helpdesk_vlookup";
            $condition = "value = '{$_REQUEST["value"]}'";
            if (strUtil::isNotEmpty($_REQUEST["id"])){
                $condition .= " AND id <> '{$_REQUEST["id"]}' AND type ='report_aging' ";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo "1";
               exit();
            }
    }else if($_REQUEST["action"]== "respond"){
            $table = "helpdesk_respond";
            $condition = "cus_comp_id = '{$_REQUEST["cus_comp_id"]}' AND tr_prd_tier_id = '{$_REQUEST["tr_prd_tier_id"]}'"
                . " AND tr_opr_tier_id = '{$_REQUEST["tr_opr_tier_id"]}' AND priority_id in ({$_REQUEST["chk_priority"]})";
//            if (strUtil::isNotEmpty($_REQUEST["id_respond"])){
//                $condition .= " AND id_respond <> '{$_REQUEST["id_respond"]}'";
//            }
            if (strUtil::isNotEmpty($_REQUEST["id_respond_priority"])){
//                $condition .= " AND id_respond not in (select id_respond from helpdesk_respond where cus_comp_id ='{$_REQUEST["cus_comp_id"]}' 
//                    AND tr_prd_tier_id = '{$_REQUEST["tr_prd_tier_id"]}' AND tr_opr_tier_id = '{$_REQUEST["tr_opr_tier_id"]}' )";
                $condition .= " AND id_respond_priority <> '{$_REQUEST["id_respond_priority"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo "1";
               exit();
            }
    }else if($_REQUEST["action"]== "resolve"){
            $table = "helpdesk_resolve";
            $condition = "cus_comp_id = '{$_REQUEST["cus_comp_id"]}' AND tr_prd_tier_id = '{$_REQUEST["tr_prd_tier_id"]}'"
                . " AND tr_opr_tier_id = '{$_REQUEST["tr_opr_tier_id"]}' AND priority_id in ({$_REQUEST["chk_priority"]})";
            if (strUtil::isNotEmpty($_REQUEST["id_resolve_priority"])){
//                $condition .= " AND id_resolve not in (select id_resolve from helpdesk_resolve where cus_comp_id ='{$_REQUEST["cus_comp_id"]}' 
//                    AND tr_prd_tier_id = '{$_REQUEST["tr_prd_tier_id"]}' AND tr_opr_tier_id = '{$_REQUEST["tr_opr_tier_id"]}' )";
                $condition .= " AND id_resolve_priority <> '{$_REQUEST["id_resolve_priority"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
               echo "1";
               exit();
            }
    }else if($_REQUEST["action"]== "menu"){
            $table = "tb_menu";

            # check duplicate menu_code
            $condition = "menu_code = '{$_REQUEST["menu_code"]}'";
            if (strUtil::isNotEmpty($_REQUEST["menu_id"])){
                $condition .= " AND menu_id <> '{$_REQUEST["menu_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
               exit();
            }

            # check duplicate menu_name
            $condition = "menu_name = '{$_REQUEST["menu_name"]}'";
            if (strUtil::isNotEmpty($_REQUEST["menu_id"])){
                $condition .= " AND menu_id <> '{$_REQUEST["menu_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "2";
               exit();
            }
    }else if($_REQUEST["action"]== "access_group"){
            $table = "tb_access_group";

            # check duplicate access_group_code
            $condition = "access_group_code = '{$_REQUEST["access_group_code"]}'";
            if (strUtil::isNotEmpty($_REQUEST["access_group_id"])){
                $condition .= " AND access_group_id <> '{$_REQUEST["access_group_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
               exit();
            }

            # check duplicate access_group_name
            $condition = "access_group_name = '{$_REQUEST["access_group_name"]}'";
            if (strUtil::isNotEmpty($_REQUEST["access_group_id"])){
                $condition .= " AND access_group_id <> '{$_REQUEST["access_group_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "2";
               exit();
            }
    }else if($_REQUEST["action"]== "organization_master"){
            $table = "helpdesk_org";
            $condition = "LENGTH(org_code) = 2 AND org_comp = '{$_REQUEST["org_comp"]}'";
            if (strUtil::isNotEmpty($_REQUEST["org_id"])){
                $condition .= " AND org_id <> '{$_REQUEST["org_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "group_master"){
                $table = "helpdesk_org";
            $condition = "LENGTH(org_code) = 4 AND org_name = '{$_REQUEST["org_name"]}' AND org_comp = '{$_REQUEST["company_id"]}' ";
            if (strUtil::isNotEmpty($_REQUEST["org_id"])){
                $condition .= " AND org_id <> '{$_REQUEST["org_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "subgrp_master"){
                $table = "helpdesk_org";
            $condition = "LENGTH(org_code) = 6 AND org_name = '{$_REQUEST["org_name"]}' AND org_comp = '{$_REQUEST["company_id"]}' ";
            if (strUtil::isNotEmpty($_REQUEST["org_id"])){
                $condition .= " AND org_id <> '{$_REQUEST["org_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "customer"){
            $table = "helpdesk_customer";
            $condition = "code_cus = '{$_REQUEST["code_cus"]}'";
            if (strUtil::isNotEmpty($_REQUEST["cus_id"])){
                $condition .= " AND cus_id <> '{$_REQUEST["cus_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }

    }else if($_REQUEST["action"]== "project"){
            $table = "helpdesk_project";
            $condition = "project_code = '{$_REQUEST["project_code"]}' AND cus_comp_id = '{$_REQUEST["cus_comp_id"]}'";
            if (strUtil::isNotEmpty($_REQUEST["project_id"])){
                $condition .= " AND project_id <> '{$_REQUEST["project_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $condition = "project_name = '{$_REQUEST["project_name"]}'";
            if (strUtil::isNotEmpty($_REQUEST["project_id"])){
                $condition .= " AND project_id <> '{$_REQUEST["project_id"]}' AND cus_comp_id = '{$_REQUEST["cus_comp_id"]}'";
            }

            $rows = $db->count_rows($table, $condition);

            if ($rows > 0){
                echo "2";
                exit();
            }

    }

   $db->close();
?>
