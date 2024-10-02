<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/db/db.php";

    php_header::text_html_utf8();
    global $db, $total_row, $objective;
    foreach ($_GET['listItem'] as $position => $item){
    $position = $position +1;
    $sql = "UPDATE helpdesk_vlookup SET item = $position WHERE id = $item"; 
    $result = $db->query($sql);
    
    }
   // print_r($sql);

   $db->close();
?>
