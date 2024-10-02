<?php
set_time_limit(10000);
include_once '../../include/config.inc.php';
include_once "../../include/error_message.php";
include_once "../../include/function.php";
include_once "../../include/class/user_session.class.php";
include_once "../../include/handler/action_handler.php";
//include_once 'change_log_list.action.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Change Log Helpdesk</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="<?=$application_path_css?>/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="<?=$application_path_js?>/jquery/ui/themes/redmond/jquery-ui-1.8.13.custom.css" />
        <link type="text/css" rel="stylesheet" href="<?=$application_path_css?>/alert.css"/>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/ui/jquery-ui-1.8.13.custom.min.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/jquery/meio/jquery.meio.mask.min.js"></script>
        <script type="text/javascript" src="<?=$application_path_include?>/config.js.php"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/function.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/common.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/srs/form.js"></script>
        <script type="text/javascript" src="<?=$application_path_js?>/alert/alert.js"></script>
         
    </head>
      <script type="text/javascript">
            $(document).ready(function(){
                form_list();      
                
            $(".change_log_class").live('keydown', function() {
               var mystr = $(this).attr("id");
               var myarr = mystr.split("_");
               $("#s_change_log"+myarr[1]).val("yes");
            });
            
            $("#save").click(function(){
                $("#action_page").val("save");
                $.ajax({
                type: "POST",
                url: "./change_log_workinfo.search.php",
                data : $("form").serialize() ,  /*data : {t1:tb1,t2:tb2,t3:tb3,header:head} ,      */   
                beforeSend:function(){
                    // this is where we append a loading image
                    $('#ajax-panel').html('<img src="../../images/loading_small.gif" alt="Loading..." />');
                },
                success: function(response){
                    //alert(response);
                    if(response == 1){
                          $("#action_page").val("");
                          alert("Save Change Log Completed");
                          form_list();
                          $('#ajax-panel').empty();
                    }else if(response == 0){
                            $("#action_page").val("");
                          alert("Don't Save Change Log Completed");
                          $('#ajax-panel').empty();
                    }
                },
                error:function(){
                    $("#action_page").val("");
                    alert("Don't Save Change Log Completed");
                          $('#ajax-panel').empty();
                   
                }
                });
            });
                    
                $("#search").click(function(){
                    form_list();
                });

                $("#cancel").click(function(){
                    window.parent.cancel_form('ifr_show_workinfo','dialog-show_workinfo');
                });              
            });
            
            function form_list(){
                 $.get("./change_log_workinfo.search.php",$("form").serialize(),  function(respone){
                        $("#divdata").html(respone);

                    });
            }
        </script>
    <style type="text/css" media="screen">
    
        @import "<?=$application_path_js?>/tablesorter-filter/css/demo_table.css";
        .dataTables_info { padding-top: 0; }
        .dataTables_paginate { padding-top: 0; }
        .css_right { float: right; }
        #example_wrapper .fg-toolbar { font-size: 0.8em }
        #theme_links span { float: left; padding: 2px 10px; }
        
</style>
    <style>
        .Head{
            color: #cfdce7;
        }
        #example tr:nth-child(even){background-color: white; }
        #example tr:nth-child(odd) {background: #ecf2f6}
        #example td:first-child {background: #B0BED9; opacity:0.4;}
</style>
    <body bgcolor="#fff">
        <div id="ajax-panel" name="ajax-panel"></div>
 
<form name="frmMain" method="post" action="">
<div style=" height: 395px; overflow-y: auto;">
   <? $user_id = user_session::get_sale_id();?>
<div id="divdata" style="height:350px; overflow:auto;">
</div>
 <center>
<img id="save" name="save" src="<?=$application_path_images;?>/btn_save.png" title="save" style="cursor: pointer; border: none;" />&nbsp;&nbsp;
<img id="cancel" name="cancel" src="<?=$application_path_images;?>/btn_back.png" title="Back" style="cursor: pointer; border: none;" />
 </center>
<input type="hidden" id="action_page" name="action_page" value="">
<input type="hidden" id="modified_change_log" name="modified_change_log" value="<?=$user_id?>">
<input type="hidden" id="incident_id" name="incident_id" value="<?=$_REQUEST["incident_id"]?>">
</div>
</form>
            
    </body>
</html>
