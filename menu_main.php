<?php
//    include_once "include/class/user_session.class.php";
//    include_once "include/config.inc.php";
//    include_once "include/class/util/strUtil.class.php";
//    include_once "include/class/db/db.php";
//    
    
    include_once "include/check_user_expire.php";
    include_once "include/class/model/menu.class.php";
    include_once "include/class/util/strUtil.class.php";
    include_once "include/class/db/db.php";
    
//echo "menu_main.php : user : " . user_session::get_user_id() ;
//    exit();

    $m = new menu($db);
    $permission_create = $m->checkCreateInc(user_session::get_user_id());
    $premission_km = $m->checkCreateKm(user_session::get_user_id());
//    $db->close();
    
//    print_r($premission_km);
//    function Search(){
//        $_SESSION["search_word"] = "";
//    }
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="include/css/cctstyles.css"/>
        <script type="text/javascript" src="include/js/function.js"></script>
        <script type="text/javascript" src="include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                resizeIframe();

                $(window).resize(function(){
                    resizeIframe();
                });
				
				$('#tb_search').keypress(function(event) {
                    if (event.keyCode == 13) {
                        Search();
                    }
                });
                
                
                 
            });

            function resizeIframe(){
                $("iframe").attr({
                    width: document.body.clientWidth
                    , height: document.body.clientHeight - 30
                });
            }
            
            function Search(){
                var s_number ;
                s_number = $("#tb_search").val();
                if (s_number != ""){
                    top.frames['main'].location.href = "incident/search_incident/index.php?id=" + s_number ;

                }else  jAlert('warning', 'Please type incident number!', 'Helpdesk System : Messages');
            }
            
            function advSearch(){
                top.frames['main'].location.href = "incident/search_incident/index.php?action=advance_search.php" ;
            }
            
            function createInc(url){
			
//bodyHome").load(url);
//document.body.innerHTML=url;
//                alert(url);
//                window.open(url);
            }
        </script>
        
        <style type="text/css">
            body, html{
                background-color: white;
            }

            span.ellipsis {
                width: 175px;
                cursor: pointer;
            }
            
            .nonborder{
                 border-style: none;
            }
            
                       
            
        </style>
    </head>
    <body height="100%">
        <!--<div  height="100px">&nbsp;</div>-->
        <!--<div height="90%">-->
        <table class="box_search" style="height: 83px; width: 248px;">
            <tr>
                <td width="15px">&nbsp;</td>
                <td>
                    <table>
                        <tr>
                            <td width="100%">
                            <span class="styleBlue">INCIDENT</span><span class="styleGray"> SEARCH</span>
                            <table>
                                <tr>
                                    <td width="70%"><input id="tb_search" type="text" title="Please type Incident number"  style="border-color:gray; border-style: solid; border-width: 1px; width: 150px;"/>
                                    </td>
                                    <td width="30%">
                                        <div align="center" id="GO" onclick="javascript:Search();">GO</div>
                                        <!--<a href="incident/main_incident/index_search.php" target="main"><div align="center" id="GO">GO</div></a>-->
                                    </td>
                                </tr>
                            </table>
                                <img id="adv_search" title="See more search option, Click here" src="images/adv_search.png" onclick="javascript:advSearch();" /> 
						</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br> 
<!--        <a href="home_km.php" target="_blank">go to km</a>-->
        <table width="248px" height="45px" border="0" cellpadding="0" cellspacing="0">
			
			<?php if(count($premission_km)>0){ ?>
			<tr>
                <td align="center">
                    <?php
                     ////km_ref/////
                     if(count($premission_km)>0){
                         foreach ($premission_km as $m)
                        {			
                            $create_control_km = "<a href='home_km.php?mode=' target='_top' ><img title='Knowledge Management' src='images/create_km.png' class='nonborder'  /></a><br>"; 
                        }
                         
                     } else {
                         $create_control_km = "<img class='nonborder' title='Sorry,You are not authorize to Knowledge Management ' src='images/km_disable.png' /><br>";
                     }
                        
                     echo $create_control_km;
                     ?>
                </td>
            </tr>
			<?php } ?>
            <tr style="height: 45px; width: 220px">
                 <td style="background: url(images/create_box_f.png); background-repeat: no-repeat; background-position: center;  background-size: 90% 100%;" align="center">
                     <?php
                     ////////////////////////////////////create button incident//////////////
                     
                     if (count($permission_create) > 0){
                        foreach ($permission_create as $m)
                        {
//                                                    
							
                            $create_control = "<a href='home_incident.php?mode=' target='_top' ><img title='Create Incident' src='images/img_create_inc.png' class='nonborder'  /></a>"; 
                       //$create_control = "<input class='nonborder' id='create_inc' type='image' title='Create Incident' src='images/img_create_inc.png' onclick='javascript:createInc(\"".$m["href"]."\")' />"; 
                     
                        }
                     }  else {
                         $create_control = "<img class='nonborder' title='Sorry,You are not authorize to create Incident' src='images/img_create_inc_g.png' />";
                     }
                        
                     echo $create_control;
					
                     
                     ?>
                 </td>
            </tr>
        </table>
        <br>
        
            <table width="248px"  border="0" cellpadding="0" cellspacing="0">
            <tr style="height: 370px; width: 248px">
                 <td style="background: url(images/menu_box_f.png); background-repeat: no-repeat; background-position: center; vertical-align: top;  background-size: 90% 100%;" 
                     align="center" >
                     <br>
                     <span class="styleBlue">INCIDENT</span><span class="styleGray"> CONTROL</span>
                     <br><br>
                     <div style="overflow-y: auto; width: 240px; height: 280px; padding-left: 12px;
                          scrollbar-arrow-color:white; scrollbar-face-color: gray; 
                          scrollbar-3dlight-color: gray; scrollbar-darkshadow-color:gray;" align="Left">
                         
                     <?php
                         include_once  './menu.php';
                     ?>
                     </div>   
                </td>
            </tr>
        </table>
    </body>
</html>