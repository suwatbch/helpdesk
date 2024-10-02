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
//    $db->close();
    
    
//    function Search(){
//        $_SESSION["search_word"] = "";
//    }
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<table width="248px"  border="0" cellpadding="0" cellspacing="0">
            <tr style="height: 370px; width: 248px">
                 <td style="background: url(images/menu_box_f.png); background-repeat: no-repeat; background-position: center; vertical-align: top;  background-size: 90% 100%;" 
                     align="center" >
                     <br>
                     <span class="styleBlue">Knowledge</span><span class="styleGray"> Management</span>
                     <br><br>
                     <div style="overflow-y: auto; width: 240px; height: 300px; padding-left: 12px;
                          scrollbar-arrow-color:white; scrollbar-face-color: gray; 
                          scrollbar-3dlight-color: gray; scrollbar-darkshadow-color:gray;" align="Left">
                         
                     <?
                         include_once  './menu_km.php';
                     ?>
                     </div>   
                </td>
            </tr>
        </table>
    </body>
</html>

