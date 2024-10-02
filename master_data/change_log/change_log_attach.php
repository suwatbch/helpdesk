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
        <script type="text/javascript" src="<?=$application_path_js?>/mulifile/jQuery.MultiFile.js"></script> 
    </head>
    <script type="text/javascript" language="javascript">
                              $(function(){ // wait for document to load 
                               $('#uploadfile_reslove').MultiFile({ 
                                list: '#show_file_reslove'
                               }); 
                              });
                              </script>
<script type="text/javascript">
$(document).ready(function(){
    form_list();
 
 //Program a custom submit function for the form
$("form#data").submit(function(event){
 if($("#uploadfile_reslove").val() == ""){
     alert('Please upload file !!!');
     return false;
 }else{
 $("#action_page").val("save");
  event.preventDefault();
  var formData = new FormData($(this)[0]);
 
  $.ajax({
    url: './change_log_attach.search.php',
    type: 'POST',
    data: formData,
    async: false,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      //alert(response);
                    if(response == 1){
                          
                          $("#action_page").val("");
                          alert("Save Change Log Completed");
                          $('#ajax-panel').empty();
                          $("#show_file_reslove").empty();
                          $("#uploadfile_reslove").val(null);
                          form_list();
                    }else if(response != 1){
                         
                          $("#action_page").val("");
                          alert("Don't Save Change Log Completed");
                          $('#ajax-panel').empty();
                          $("#show_file_reslove").empty();
                          $("#uploadfile_reslove").val(null);
                           form_list();
                    }
    },
    error:function(){
                    
                    $("#action_page").val("");
                    alert("Don't Save Change Log Completed");
                    $('#ajax-panel').empty();
                    $("#show_file_reslove").empty();
                    $("#uploadfile_reslove").val(null);
                    form_list();
                   
                }
  });
 }
  return false;
});
    
$('.delete_file_reslove').live('click', function() {
if (confirm("Are you sure to delete")){
var del_id = $(this).parent().parent().attr('id');
var parent = $(this).parent().parent();
$.post('../../incident/manage_incident/delete_file_reslove.php', {id:del_id},function(data){
parent.fadeOut('fast', function() {$(this).remove();});
});
}
});
$('.blink').blink(); // default is 500ms blink interval.

$("#cancel").click(function(){
                    window.parent.cancel_form('ifr_solution_attach','dialog-solution_attach');
}); 

});

(function($) {
    $.fn.blink = function(options) {
        var defaults = {
            delay: 500
        };
        var options = $.extend(defaults, options);

        return this.each(function() {
            var obj = $(this);
            setInterval(function() {
                if ($(obj).css("visibility") == "visible") {
                    $(obj).css('visibility', 'hidden');
                }
                else {
                    $(obj).css('visibility', 'visible');
                }
            }, options.delay);
        });
    }
}(jQuery)) 

</script>
<script type="text/javascript">          
            function form_list(){
                 $.get("./change_log_attach.search.php",$("form").serialize(),  function(respone){
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
<form id="data" enctype="multipart/form-data">
   <? $user_id = user_session::get_sale_id();?>

<table width="100%" border="0" cellpadding="0" cellspacing="3" align="center">
    <tr>
                   <td class="tr_header1">Attach File</td>
                    <td>
                        <input type="file" id="uploadfile_reslove" name="uploadfile_reslove[]"/>
                            <div id="show_file_reslove" style="border:#999 solid 3px; padding:10px;">
                            </div>
                    </td>  
                </tr>
</table>
    <div style=" height: 310px; overflow-y: auto;">
<div id="divdata" ></div>
<center>
    <input type="image" src="<?=$application_path_images;?>/btn_save.png" alt="Submit Form" style="cursor: pointer; border: none;" />&nbsp;&nbsp;
<!--<img id="save" name="save" src="<?=$application_path_images;?>/btn_save.png" title="save" style="cursor: pointer; border: none;" />&nbsp;-->
<img id="cancel" name="cancel" src="<?=$application_path_images;?>/btn_back.png" title="Back" style="cursor: pointer; border: none;" />
</center>
    </div>
<input type="hidden" id="action_page" name="action_page" value="">
<input type="hidden" id="modified_change_log" name="modified_change_log" value="<?=$user_id?>">
<input type="hidden" id="incident_id" name="incident_id" value="<?=$_REQUEST["incident_id"]?>">
</form>
            
    </body>
</html>
