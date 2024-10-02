<?php
    session_start();
    include_once "include/check_user_expire.php";

    
    if (!$_SESSION["current_km"]){
         $_SESSION["current_km"] = "incident_km/km_tree/index.php";
		
    }
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?="$application_name Version $application_version"?></title>
        <link type="text/css" rel="stylesheet" href="include/css/cctstyles.css"/>
        <link rel="shortcut icon" type="image/ico" href="images/logo.png">
        <script type="text/javascript" src="include/js/function.js"></script>
		
        <script type="text/javascript">
//            function user_account(){
////                alert('user info ');
//                window.open("main_screen/user_info/index.php", "main");
//            }
        </script>
        <style type="text/css">
            html, body{
                background-color: #fff;
            }
 
            #mainall{
                /*width: 1020px !important;*/
                width: 100% !important;
				background-color: #FFF;
            }
            
            #blank{
                height: 2px;
            }
        </style>
    </head>
	    <? //echo $_SESSION['current']; ?>
   <frameset name="mainall" id="mainall" border="0" frameborder="0" framespacing="0" rows="90, *,50">
    <frame name="header" src="header.php" scrolling="no">
    <!--<frame name="blank" id="blank" scrolling="no">-->
        <frameset name="col" border="0" frameborder="0" framespacing="0" cols="248,*">
        <frame name="leftmenu" src="menu_main_km.php" scrolling="no">
<!--                <frameset name="view" border="0" frameborder="0" framespacing="0" rows="35,*">
                 <frame name="tbar" frameborder="0" src="include/template/top.tpl.php" scrolling=no noresize="noresize">-->
        <frame name="main" frameborder="0" src="<?=$_SESSION["current_km"]?>">
<!--                </frameset>-->
         </frameset>
        <frame name="footer" src="footer.php" scrolling="no">
</frameset><noframes></noframes>


</html>