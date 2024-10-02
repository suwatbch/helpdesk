<?php
include_once dirname(dirname(dirname(__FILE__)))."/v.1/incident/manage_incident/incident.getrunning.php";
include_once "../include/class/db/db.php";	 
include_once "../include/class/dropdown.class.php";
include_once "../include/class/util/strUtil.class.php";
include_once "../include/class/util/dateUtil.class.php";
global $db;

for($i=1;$i<=103;$i++){
    $sql = "insert into helpdesk_tr_assignment (incident_id,assign_status_id,assign_status_res_id,assign_comp_id,assign_org_id,assign_group_id,assign_subgrp_id,
assign_assignee_id,entry_date,duration_time) values ('{$i}', '1','0','2','22','36','38','0','2013-06-26 21:08:28','0')";
    $result = $db->query($sql);
    $rows = $db->num_rows($result);
    echo $i;
    if(!$result){
        echo"fsfd";
    }
    
}
echo"fsfdf";
?>
