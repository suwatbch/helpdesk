<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_user.class.php";

    php_header::text_html_utf8();

    $assign_comp_id = $_GET["assign_comp_id"];
    $assign_subgrp_id = $_GET["assign_subgrp_id"];
    
    $assignee = new helpdesk_user($db);
    $assignee = $assignee->searchUser_grp($assign_comp_id, $assign_subgrp_id);
    echo json_encode($assignee);
  
     
    $db->close();
?>
