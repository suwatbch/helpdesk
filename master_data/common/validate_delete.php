<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";

    php_header::text_html_utf8();
    global $db;
    
    if($_REQUEST["action"]== "company"){
            $table = "helpdesk_user";
            $condition = "company_id = '{$_REQUEST["company_id"]}' ";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_org";
            $condition = "org_comp = '{$_REQUEST["company_id"]}' ";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "organization"){
            $table = "helpdesk_org orgm"
                    . " LEFT JOIN (SELECT org_code,org_id FROM helpdesk_org WHERE LENGTH(org_code) = 2 ) org on (SUBSTRING(orgm.org_code, 1, 2)=org.org_code)";
            $condition = "LENGTH(orgm.org_code) = 4 AND org.org_id= '{$_REQUEST["org_id"]}' AND orgm.org_comp = '{$_REQUEST["org_comp"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }

    }else if($_REQUEST["action"]== "group"){
            $table = "helpdesk_org orgm"
                    . " LEFT JOIN (SELECT org_code,org_id FROM helpdesk_org WHERE LENGTH(org_code) = 4 ) grp on (SUBSTRING(orgm.org_code, 1, 4)=grp.org_code)"; 
            $condition = "LENGTH(orgm.org_code) = 6 AND grp.org_id= '{$_REQUEST["org_id"]}' AND orgm.org_comp = '{$_REQUEST["org_comp"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }

    }else if($_REQUEST["action"]== "subgroup"){
            $table = "helpdesk_user";     
            $condition = "org_id= '{$_REQUEST["org_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }

    }else if($_REQUEST["action"]== "cus_company"){
            $table = "helpdesk_customer";     
            $condition = "cus_company_id= '{$_REQUEST["cus_company_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_cus_zone";     
            $condition = "cus_company_id= '{$_REQUEST["cus_company_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_project";     
            $condition = "cus_comp_id= '{$_REQUEST["cus_company_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_incident_type";     
            $condition = "cus_comp_id= '{$_REQUEST["cus_company_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_prd_tier";     
            $condition = "cus_comp_id= '{$_REQUEST["cus_company_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_opr_tier";     
            $condition = "cus_comp_id= '{$_REQUEST["cus_company_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_tr_prd_tier";     
            $condition = "cus_company_id= '{$_REQUEST["cus_company_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_tr_opr_tier";     
            $condition = "cus_company_id= '{$_REQUEST["cus_company_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }

    }else if($_REQUEST["action"]== "cus_org"){
            $table = "helpdesk_customer";     
            $condition = "org_cus= '{$_REQUEST["cus_org_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "zone"){
            $table = "helpdesk_cus_zone_area";     
            $condition = "zone_id= '{$_REQUEST["zone_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "area"){
            $table = "helpdesk_customer";     
            $condition = "area_cus= '{$_REQUEST["area_cus"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "project"){
            $table = "helpdesk_tr_incident";     
            $condition = "project_id= '{$_REQUEST["project_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "incident_type"){
            $table = "helpdesk_tr_incident";     
            $condition = "ident_type_id= '{$_REQUEST["ident_type_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "priority"){
            $table = "helpdesk_tr_incident";     
            $condition = "priority_id= '{$_REQUEST["priority_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    //}else if($_REQUEST["action"]== "product_class"){
    //        $table = "helpdesk_tr_prd_tier";     
    //        $condition = "prd_tier_lv1_id= '{$_REQUEST["prd_tier_id"]}' or prd_tier_lv2_id= '{$_REQUEST["prd_tier_id"]}' or prd_tier_lv3_id= '{$_REQUEST["prd_tier_id"]}'";
    //        $rows = $db->count_rows($table, $condition);
    //        if ($rows > 0){
    //            echo "1";
    //            exit();
    //        }
    }else if($_REQUEST["action"]== "operation_class"){
            $table = "helpdesk_tr_opr_tier";     
            $condition = "opr_tier_lv1_id= '{$_REQUEST["opr_tier_id"]}' or opr_tier_lv2_id= '{$_REQUEST["opr_tier_id"]}' or opr_tier_lv3_id= '{$_REQUEST["opr_tier_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "product_combination"){
            $table = "helpdesk_tr_incident";     
            $condition = "(cas_prd_tier_id1= '{$_REQUEST["prd_tire1"]}' AND cas_prd_tier_id2= '{$_REQUEST["prd_tire2"]}' AND cas_prd_tier_id3= '{$_REQUEST["prd_tire3"]}') 
                OR (resol_prdtier1= '{$_REQUEST["prd_tire1"]}' AND resol_prdtier2= '{$_REQUEST["prd_tire2"]}' AND resol_prdtier3= '{$_REQUEST["prd_tire3"]}') ";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "operation_combination"){
            $table = "helpdesk_tr_incident";     
            $condition = "(cas_opr_tier_id1= '{$_REQUEST["opr_tire1"]}' AND cas_opr_tier_id2= '{$_REQUEST["opr_tire2"]}' AND cas_opr_tier_id3= '{$_REQUEST["opr_tire3"]}') 
                OR (resol_oprtier1= '{$_REQUEST["opr_tire1"]}' AND resol_oprtier2= '{$_REQUEST["opr_tire2"]}' AND resol_oprtier3= '{$_REQUEST["opr_tire3"]}') ";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "user"){
            $table = "helpdesk_tr_incident";     
            $condition = "owner_user_id = '{$_REQUEST["user_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
            
            $table = "helpdesk_tr_assignment";     
            $condition = "assign_assignee_id = '{$_REQUEST["user_id"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }else if($_REQUEST["action"]== "customer"){
            $table = "helpdesk_tr_incident";     
            $condition = "cus_id = '{$_REQUEST["code_cus"]}'";
            $rows = $db->count_rows($table, $condition);
            if ($rows > 0){
                echo "1";
                exit();
            }
    }

   $db->close();
?>
