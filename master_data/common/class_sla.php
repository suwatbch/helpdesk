<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_prd.class.php";
    include_once "../../include/class/model/helpdesk_opr.class.php";

    php_header::text_html_utf8();

    $tr_prd_tier_id = $_REQUEST["tr_prd_tier_id"];
    $tr_opr_tier_id = $_REQUEST["tr_opr_tier_id"];
    $option_class = $_REQUEST["option_class"];
    global  $db;
    
    //////////////////////product class//////////////////////////////
    $arr_object = new helpdesk_prd($db);
    if($tr_prd_tier_id != "" && $option_class == 1){
        $arr_object = $arr_object->prd_sla1($tr_prd_tier_id);
        echo $arr_object;
    }
    if($tr_prd_tier_id != "" && $option_class == 2){
        $arr_object = $arr_object->prd_sla2($tr_prd_tier_id);
        echo $arr_object;
    }
    if($tr_prd_tier_id != "" && $option_class == 3){
        $arr_object = $arr_object->prd_sla3($tr_prd_tier_id);
        echo $arr_object;
    }
    
    ////////////////////////operation class/////////////////////////////////////
    $arr_object = new helpdesk_opr($db);
    if($tr_opr_tier_id != "" && $option_class == 1){
        $arr_object = $arr_object->opr_sla1($tr_opr_tier_id);
        echo $arr_object;
    }
    if($tr_opr_tier_id != "" && $option_class == 2){
        $arr_object = $arr_object->opr_sla2($tr_opr_tier_id);
        echo $arr_object;
    }
    if($tr_opr_tier_id != "" && $option_class == 3){
        $arr_object = $arr_object->opr_sla3($tr_opr_tier_id);
        echo $arr_object;
    }
    
?>
