<?php
session_start();
include_once "include/config.inc.php";
include_once "include/class/db/db.php";
include_once "include/class/user_session.class.php";
include_once "include/class/util/strUtil.class.php";
//include_once "include/class/model/menu.class.php";
include_once "include/class/model/incident_list.class.php";

$mode = $_GET["mode"];

//global $db, $incident_list, $count;
                
$cratiria = array(
     "user_id" => user_session::get_user_id()
    ,"user_subgrp_id" => user_session::get_user_subgrp_id() 
    ,"user_subgrp_id_spec" => user_session::get_subgrp_id_spec_arr() 
    ,"mode" => $mode
);

$incident_list = new incident_list($db);
$count = $incident_list->search($cratiria);

if ($count){
    echo $count["total_row"];
}else{
    echo 0;
}
                
            

?>
