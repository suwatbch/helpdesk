<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/db/db.php";

    php_header::text_html_utf8();
    global $db, $total_row, $objective;
    foreach ($_GET['listItem'] as $position => $item){
    $position = $position +1;
    $sql = "UPDATE helpdesk_cus_zone SET item = $position WHERE zone_id = $item"; 
    $result = $db->query($sql);
    
    }
   // print_r($sql);

   $db->close();
?>
