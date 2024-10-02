

<?php
    include_once "include/config.inc.php";
    include_once "include/class/db/db.php";
    include_once "include/class/model/incident_recal.class.php";
    // phpinfo();

    $obj_recal = new incident_recal($db);
    $obj_recal->recal();
    

?>