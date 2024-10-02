<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    
    $s_owner = $_GET['term'];
    $ss_owner = array();
    $sql = "SELECT first_name,last_name FROM helpdesk_user where (first_name like '%$s_owner%' or last_name like '%$s_owner%') 
            and ifnull(user_status,'0') = '1' ";
    $result = $db->query($sql);
    $rows =   $db->num_rows($result);
    if ($rows != 0){
            while($row = $db->fetch_array($result)){
                $ss_owner[] = $row['first_name']." ".$row['last_name'];
                
            }
            echo json_encode($ss_owner);
    }
 ?>
