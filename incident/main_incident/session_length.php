<?php
    session_start();
    $_SESSION["_pagelength"] = $_POST["len"];

    echo $_SESSION["_pagelength"];
?>
