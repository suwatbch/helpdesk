<?php

session_start();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <title><?=$application_name;?></title>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="include/css/demo.css"/>
        <link type="text/css" rel="stylesheet" href="include/css/alert.css"/>
        <script type="text/javascript" src="include/config.js.php"></script>
        <script type="text/javascript" src="include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="include/js/function.js"></script>
        <script type="text/javascript" src="include/js/srs/common.js"></script>
        <script type="text/javascript" src="include/js/srs/filter.js"></script>
        <script type="text/javascript" src="include/js/srs/form.js"></script>
        <script type="text/javascript" src="include/js/alert/alert.js"></script>
        <script type="text/javascript">
            $(function(){

		$("img[alt=login]").click(function(){
                   // var ret = validate();
                   chk_password();
				});

                $("#username").keypress(function(event) {
                  if (event.which == "13") {
                     $("#password").focus();
                   }
                });

                $("#password").keypress(function(event) {
                  if (event.which == "13") {
                     $("img[alt=login]").click();
                   }
                });

                $("#username").focus();
            });
           function chk_form (){
               if($("#username").val() == ""){
                   jAlert('error', 'Please Input Username', 'Helpdesk System : Messages');
                   $("#username").focus();
                  clear_expire();
                   return false;
               }else if($("#password").val() == ""){
                   jAlert('error', 'Please Input password', 'Helpdesk System : Messages');
                   $("#password").focus();
                   clear_expire();
                   return false;
               }else if($("#new_password").val() == "" && $("#pass_expire").val() == 1){
                   jAlert('error', 'Please Input New Password', 'Helpdesk System : Messages');
                   $("#new_password").focus();
                   return false;
               }else if($("#re_password").val() == "" && $("#pass_expire").val() == 1){
                   jAlert('error', 'Please Input Re Password', 'Helpdesk System : Messages');
                   $("#re_password").focus();
                   return false;
               }else if(($("#new_password").val() != $("#re_password").val()) && $("#pass_expire").val()== 1){
                   jAlert('error', 'New Password must be Difference Old Password ', 'Helpdesk System : Messages');
                   $("#re_password").focus();
                   return false;
               }else{
                   //alert('submit');
                    page_submit("load_config.php","");
               }
           }
        function chk_password(){     
        $.ajax({
                type: "GET",
                url: "chk_password.php",
                data: "action=chk_password&username=" + $("#username").val() + "&password=" + $("#password").val() + 
                    "&comcode=" + $("#comcode").val()+"&new_password="+$("#new_password").val()+"&pass_expire=" + $("#pass_expire").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'No Username in PTN Helpdesk System!!!', 'Helpdesk System : Messages');
                        clear_expire();
                        return false;
                   }else if(respone == 2){
                       jAlert('error', 'Employee not active !!!', 'Helpdesk System : Messages');
                        clear_expire();
                        return false;
                       
                   }else if(respone == 3 || respone == 8){
                       jAlert('error', 'Password incorrect !!!', 'Helpdesk System : Messages');
                       $("#password").focus();
                        clear_expire();
                        return false;
                       
                   }else if(respone == 4 && $("#pass_expire").val()== ""){
                        jAlert('error', 'Password Expire!! Please Change Password', 'Helpdesk System : Messages');
                        $("#show_new_password").css("display", "");
                        $("#pass_expire").val(1);
                        return false;
                        
                   }else if(respone == 5){
                       jAlert('error', 'The system has locked this user because you specify wrong password than 3 time, Please contact administrator !!', 'Helpdesk System : Messages');
                        clear_expire();
                        return false;
                   }else if(respone == 6 && $("#pass_expire").val()== ""){
                        jAlert('error', 'First Login!! Please Change Password', 'Helpdesk System : Messages');
                        $("#show_new_password").css("display", "");
                        $("#pass_expire").val(1);
                        return false;
                        
                   }else if(respone == 9){
                        jAlert('error', 'Old Password and New Password must be the same', 'Helpdesk System : Messages');
                        return false;
                       
                   }else if(respone == 7){
                        clear_expire();
                        chk_form();
                       
                   }else{
                       chk_form();
                       
                   }
                }
            });
           
    }
    function clear_expire(){
        $("#show_new_password").css("display", "none");
        $("#pass_expire").val(null);
        $("#new_password").val(null);
        $("#re_password").val(null);
    }

        </script>
    </head>
    <body background="images/bg1.jpg">
        <br><br><br><br><br><br><br><br><br><br>
        <form name="frmMain" action="load_config.php" method="post">
            <center>
                <table width="717" height="304" background="images/bg2.jpg" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="70%" height="300" bgcolor="">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="24%" rowspan="4" align="right"><!--<img src="images/star_logo.png" alt=""/>--></td>
                                    <td width="32%" align="right"></td>
                                    <td width="44%" align="left"></td>
                                </tr>
                                <tr>
                                    <td align="right"><label for="username">User Name</label><span class="required">*</span> :</td>
                                    <td align="left"><input type="text" name="username" id="username" required="true" description="User Name" style="width: 200px;"/></td>
                                </tr>
                                <tr>
                                    <td align="right"><label for="password">Password</label><span class="required">*</span> :</td>
                                    <td align="left"><input type="password" name="password" id="password" required="true" description="Password" style="width: 200px;"></td>
                                </tr>
                            </table>
                            <div id="show_new_password" style="display: none;">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="24%" rowspan="4" align="right"><!--<img src="images/star_logo.png" alt=""/>--></td>
                                    <td width="32%" align="right"><label for="password">New Password</label><span class="required">*</span> :</td>
                                    <td width="44%" align="left"><input type="password" name="new_password" id="new_password"  style="width: 200px;"></td>
                                </tr>
                                <tr>
                                    <td align="right"><label for="password">Re Password</label><span class="required">*</span> :</td>
                                    <td align="left"><input type="password" name="re_password" id="re_password"  style="width: 200px;"></td>
                                </tr>
                            </table>
                            </div>
                            <table width="100%" border="0">
                                <tr>
                                    <td width="24%" rowspan="4" align="right"><!--<img src="images/star_logo.png" alt=""/>--></td>
                                    <td width="32%" align="right"></td>
                                    <td align="left"><img src="(../../images/login.gif" alt="login" style="cursor: pointer;">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="color: #939393;">&nbsp;</td>
                                    <td align="left">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right" style="color: #939393;">&nbsp;</td>
                                    <td align="left">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="right" style="color: #939393;">&nbsp;</td>
                                    <td align="left">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <input type="hidden" id="pass_expire" name="pass_expire" value="">
            </center>
        </form>
    </body>
</html>
