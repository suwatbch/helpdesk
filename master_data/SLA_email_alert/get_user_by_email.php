<?php

    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_user.class.php";

    php_header::text_html_utf8();

    $email = $_POST["email"];
    $arr = array();
    $name = "";
    
    $user = new helpdesk_user($db);
    $user = $user->searchUser_byEmail($email);

    foreach ($user as $value) {
        $name = $value["fullname"];
    }
//    echo json_encode($user);
  
    echo $name;
     
//    $db->close();
?>
