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
                //form_list();
                $("#footer02").css("display", "none");
                $("#dialog-show_workinfo").dialog({
				height: 450
				, width: 750
				, autoOpen: false
				, modal: true
				, resizable: false
				, close : function(){
					$("#ifr_show_workinfo").attr("src", "");
				}
		});
                
                 $('.info_link').live('click', function(event) {
                    var incident_id  = $(this).attr('value');
                    $("#ifr_show_workinfo").attr("src", 'change_log_workinfo.php?incident_id='+incident_id);
                    $("#dialog-show_workinfo").dialog("open");
                    event.preventDefault();
      
                });
                
                $("#dialog-solution_attach").dialog({
				height: 450
				, width: 750
				, autoOpen: false
				, modal: true
				, resizable: false
				, close : function(){
					$("#ifr_solution_attach").attr("src", "");
				}
		});
                
                 $('.info_link02').live('click', function(event) {
                    var incident_id  = $(this).attr('value');
                    $("#ifr_solution_attach").attr("src", 'change_log_attach.php?incident_id='+incident_id);
                    $("#dialog-solution_attach").dialog("open");
                    event.preventDefault();
      
                });
    
                
                
            $(".change_log_class").live('keydown', function() {
               var mystr = $(this).attr("id");
               var myarr = mystr.split("_");
               $("#s_change_log"+myarr[1]).val("yes");
            });
            
            $("#save").live('click', function() {
                $("#action_page").val("save");
                $.ajax({
                type: "POST",
                url: "./change_log.search.php",
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
                
                $('#s_incident').bind('keypress', function(e) {
                    if(e.keyCode==13){
                            form_list();
                            e.preventDefault();
                    }
                });
                
                $('#e_incident').bind('keypress', function(e) {
                    if(e.keyCode==13){
                            form_list();
                            e.preventDefault();
                    }
                });
                
                $("#cancel").live('click', function() {
                    window.close();
                });

//                $("#close").click(function(){
//                    window.parent.dialog_onSelected("cost_center", null);
//                    window.parent.dialog_onClosed("cost_center");
//                });              
            });
            
            function form_list(){
                 $.get("./change_log.search.php",{s_incident:$("#s_incident").val(),e_incident:$("#e_incident").val()},  function(respone){
                        $("#divdata").html(respone);
                        var rowCount = $('#example tr').length;
                        if(rowCount > 0){
                            $("#footer02").css("display", "");
                        }else{
                            $("#footer02").css("display", "none");
                        }

                    });
               
            }
            
            function cancel_form(ifr,dialog){
                $("#"+ifr).attr("src", "blank.php");
                $("#"+dialog).dialog("close");
            }
    
        </script>

    <style type="text/css" media="screen">
    
        @import "<?=$application_path_js?>/tablesorter-filter/css/demo_table.css";
        html,body
    {
        margin:0; padding:0; height:100%;
    }
        .dataTables_info { padding-top: 0; }
        .dataTables_paginate { padding-top: 0; }
        .css_right { float: right; }
        #example_wrapper .fg-toolbar { font-size: 0.8em }
        #theme_links span { float: left; padding: 2px 10px; }
        #footer02{
    position:fixed;
    left:0px;
    bottom:0px;
    height:35px;
    width:100%;
    background: #C0D9EA;
    padding-top: 10px;
}
        
</style>
<style>
        .Head{
            color: #cfdce7;
        }
        #example tr:nth-child(even){background-color: white; }
        #example tr:nth-child(odd) {background: #ecf2f6}
        #example td:first-child {background: #B0BED9; opacity:0.4;}
</style>
<body bgcolor="#fff"><br>
<table id="tb_adv_left" width="100%" >
                    <tr style="border-bottom: #B40431 solid medium;">
                        <td align="left" width="50%"  style="border-bottom: #B40431 solid medium;">
                            <span class="styleBlue"><font style=" font-size: 15px;">Change Incident</font></span>
                        </td>
                        <td align="right" width="50%" style="border-bottom: #B40431 solid medium;">
                            <font style=" font-size: 11px; color: red;"><b>* Maximum Record is 100</b></font>
                        </td>
                    </tr>
</table>
<div id="ajax-panel" name="ajax-panel"></div>
<form name="frmMain" id="frmMain"><br>
   <? $user_id = user_session::get_sale_id();?>
    <center>
    <table width="50%" align="center">
<tr><td class="tr_header" width="10%"><b>Search Incident No :</b></td>
<td><input type="text" id="s_incident" name="s_incident" value="<?=$_REQUEST["s_incident"]?>"> To 
    <input type="text" id="e_incident" name="e_incident" value="<?=$_REQUEST["e_incident"]?>">&nbsp;&nbsp;
<img id="search" src="../../images/search.png" style="cursor: pointer; border: none;"/>
    </td></tr>
</table></center><br>

<div id="divdata" style="overflow: auto; position:absolute; top:90px; bottom:45px;">
</div>

<div id="footer02">
    <center>
<img id="save" name="save" src="<?=$application_path_images;?>/btn_save.png" title="save" style="cursor: pointer; border: none;" />&nbsp;&nbsp;
<img id="cancel" name="cancel" src="<?=$application_path_images;?>/btn_back.png" title="Back" style="cursor: pointer; border: none;" />
    </center>
</div>

<input type="hidden" id="action_page" name="action_page" value="">
<input type="hidden" id="modified_change_log" name="modified_change_log" value="<?=$user_id?>">
<div id="dialog-show_workinfo" title="Change Log Work Info">
    <iframe id="ifr_show_workinfo" frameborder="0" scrolling="no" width="100%" height="100%" src=""></iframe>
</div>
<div id="dialog-solution_attach" title="Change Log Solution Attach File">
    <iframe id="ifr_solution_attach" frameborder="0" scrolling="no" width="100%" height="100%" src=""></iframe>
</div>
</form>
</body>
</html>
