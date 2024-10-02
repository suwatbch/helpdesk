<?php
    include_once dirname(dirname(dirname(__FILE__)))."/config.inc.php";
    include_once dirname(dirname(dirname(__FILE__)))."/handler/error_handler.php";
    include_once dirname(__FILE__)."/mysql.class.php";

    $db = new db();
    $con = $db->connect($db_host, $db_user, $db_password);
    $db->select_db($db_schemata, $con);
?>