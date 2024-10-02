<?php
	session_start();
    include_once "include/config.inc.php";
    include_once "include/class/user_session.class.php";
	
	
	function php_home(){
		$_SESSION["current"] = "incident/main_incident/index.php?mode=1";
		header( "location: home.php#TOP" );
	}
	//echo $application_path_js;
?>
<html>
    
    <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="include/css/cctstyles.css"/>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/ui/jquery-ui-1.8.13.custom.min.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/meio/jquery.meio.mask.min.js"></script>
        <script type="text/javascript" src="<?=$application_path_include?>/config.js.php"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/function.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/common.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/form.js"></script>
        <script type="text/javascript">
            function logout(){
                if (confirm("Are you sure to Log out ?")) {
                    top.location = "logout.php";
        	}
            }
            
            function gotoHome(){
                top.location = "home.php?p=incident/main_incident/index.php?mode=1";
		//window.open("<?=$application_path?>/incident/main_incident/index.php?mode=1", "main");   <input type="text" id="page_session" name="page_session" />
            }
            
            function userInfo(){
		top.location= "home.php?p=main_screen/user_info/index.php";
                 
                //window.open("<?=$application_path?>/main_screen/user_info/index.php", "main");
            }
            
            
        </script>
        <style type="text/css">
            body
            {
/*                background-image:url('images/bg_ltr_w.jpg');  */
                background-image:url('images/header_new.png');  
                background-repeat:repeat-x;
                background-size: 100% 85%;
            }
        </style>
    </head>
    <body>
        <form name="frmMain" method="post" action="home.php">
		
            <table width="100%" height="48" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <table width="95%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="30%" style="padding-top: 30px; " align="center">
                                    <img src="images/logo.png" /><br>
                                    <font style="color: #000; font-size: 12px"><b><?=$application_name?></b>&nbsp;<b>Version <?=$application_version?></b>  <? //user_session::get_user_company_name() ?> </font>
								</td>
                                <td width="70%" align="right" valign="top"><br>
                                    <img id="ico_home" src="images/icon_home.png" onClick="gotoHome();" title="Home" alt="Home" style="cursor:pointer;" />&nbsp;
                                    <!--<a id="ico_home" target="_top" href="home.php" ><img src="images/icon_home.png" title="Home" alt="Home" style="cursor:pointer;" /></a>&nbsp;-->
                                    <img id="ico_profile" src="images/icon_id_card.png" onClick="userInfo();" title="User Information" style="cursor:pointer;" />&nbsp;
                                    <img id="ico_logout" src="images/icon_logout.png" onClick="logout();" title="Log out" style="cursor:pointer;" />
									<?php $s_user_se = user_session::get_user_name();
										//$s_con	=  iconv( 'UTF-8' , 'windows-874' , $s_user_se);
									?>
                                    <br><span class="welcome">[<?=$s_user_se?>]</span>			 		
                                  <!--<img src="images/home31x27.png" width="93" height="27" border="0" style="cursor: pointer; margin-top:12px;" usemap="#menu_icon" />-->
                                </td>
                            </tr>
                            
                        </table>
                    </td>
                </tr>
            </table>
        </form>

<!--<map name="menu_icon">
<area shape="rect" coords="2,0,29,112" onClick="gotoHome();" alt="Home" style="cursor:pointer;">
<area shape="rect" coords="35,0,62,112" onClick="window.parent.user_account(); alt="User Information" style="cursor:pointer;">
<area shape="rect" coords="66,1,93,113" onClick="logout();" alt="Log out" style="cursor:pointer;">
</map>      -->
</body>
</html>