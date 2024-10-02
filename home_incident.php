<?php
    //session_start();
    include_once "include/check_user_expire.php";
    $s_incident_id = $_GET["incident_id"];
    $s_mode = $_GET["mode"];
//    $_SESSION["current"] = "incident/manage_incident/index.php?incident_id=".$s_incident_id."&mode=".$s_mode;
    
    $_SESSION["current"] = "incident/manage_incident/index.php?incident_id=$s_incident_id&mode=$s_mode";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">

<html>
    <head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
		
        <title><?="$application_name Version $application_version"?></title>
        <link type="text/css" rel="stylesheet" href="include/css/cctstyles.css"/>
        <link rel="shortcut icon" type="image/ico" href="images/logo.png">
        <script type="text/javascript" src="include/js/function.js"></script>
        <script type="text/javascript">
            function user_account(){
                window.open("main_screen/user_info/index.php", "main");
            }
        </script>
        <style type="text/css">
            html, body{
                background-color: #fff;
            }
 
            #main{
                /*width: 1020px !important;*/
                width: 100% !important;
				background-color: #FFF;
            }
        </style>
    </head>
    <? //echo $_SESSION['current'];
    ?>
   <frameset name="main" id="main" border="0" frameborder="0" framespacing="0" rows="87, *,50">
        <frame name="header" src="header.php" scrolling="no">
        <frame name="main" frameborder="0" src="<?=$_SESSION["current"]?>" scrolling="no">
        <frame name="footefr" src="footer.php" scrolling="no" style="background-color: red;">
</frameset><noframes></noframes>

</html>


