<?php
include_once 'sla_schedule_list.action.php';
global $type_id,$arr_schedule;

//print_r($arr_schedule);
if ($arr_schedule["data"]){
    $schedule = $arr_schedule["data"];
    
//    print_r($schedule);
    foreach ($schedule as $val){
        $start_datetime = $val["start_datetime"];
        $start_datetime = substr($start_datetime, 0,10)."T".substr($start_datetime, 11,8);
        $job = $val["schedule"];
        $enabled = $val["enabled"];
        $run_datetime = $val["latest_run"];
    }
    
}
?>
<link type="text/css" rel="stylesheet" href="<?=$application_path_include?>/css/cctstyles.css"/>
<script type="text/javascript">
    $(function(){
        
            $("#btn_save").click(function(){
//                var param1 = new Date();
//                var param2 = param1.getDate() + '/' + (param1.getMonth()+1) + '/' + param1.getFullYear() + ' ' + param1.getHours() + ':' + param1.getMinutes() + ':' + param1.getSeconds();
//                alert(param2);

                if (chkValidate()){
                    
                    var type_id = $("#type_id").val();
                    var startdate = $("#sch_start").val();
                    var latest_run = '0000-00-00 00:00:00';
                    var schedule = ""; 
                    var enabled =  $('#enabled').is(":checked") ? "Y" : "N";
                    var user_id = $("#user_id").val();
                  
                      $('input[name="schedule"]').each(function(){
                         if ($(this).attr('checked')){
                             schedule = $(this).val();
                         }
                      });
                      
                                            
                    $.ajax({
                    type: "POST",
                    url: "save.php",
                    data : {type_id:type_id , startdate:startdate,schedule:schedule ,enabled:enabled, user_id:user_id , latest_run:latest_run} ,         
                    beforeSend:function(){
                        $('#ajax-panel').html('<img src="../../images/loading_small.gif" alt="Loading..." />');
                    },
                    success: function(response){
                        
                        $('#ajax-panel').empty();
//                        $("#message").html(response)
                        if (response == 1){
//                            $("#message").html("บันทึกรายการเรียบร้อยแล้ว!");
                            jAlert('success', "บันทึกรายการเรียบร้อยแล้ว!", 'Helpdesk System : Messages');
                        }else{
//                            $("#message").html("บันทึกรายการไม่สมบูรณ์!");
                            jAlert('error', "บันทึกรายการไม่สมบูรณ์!", 'Helpdesk System : Messages');
                        }

                    },
                    error:function(){

//                     $("#message").html('บันทึกรายการไม่สมบูรณ์!');
                     jAlert('error', "บันทึกรายการไม่สมบูรณ์!", 'Helpdesk System : Messages');
                     $('#ajax-panel').empty();  
                    }
                    });
                }
                 
            });
            
            
            
            $("#btn_back").click(function(){ 
                $("#sch_start").val("");
                $("#start_old").val("");
                $('input[name="schedule"]').attr('checked', false);
                $('input[name="enabled"]').attr('checked', false);
                $("#message").val("");
            });
            
            function chkValidate(){
               var dStart = $("#sch_start").val();
               dStart = Date.parse(dStart.replace('T', ' '));
               
               var dNOW = new Date();
               var dNOW_dp = dNOW.getDate() + '/' + (dNOW.getMonth()+1) + '/' + dNOW.getFullYear() + ' ' + dNOW.getHours() + ':' + dNOW.getMinutes() + ':' + dNOW.getSeconds()
               dNOW = Date.parse(dNOW.getFullYear() + '-' + (dNOW.getMonth()+1) + '-' + dNOW.getDate() + ' ' + dNOW.getHours() + ':' + dNOW.getMinutes() + ':' + dNOW.getSeconds());
                    
                if ($("#sch_start").val() == ''){
                    jAlert('error', 'กรุณาเลือกวันและเวลเริ่ม!', 'Helpdesk System : Messages');
                    return false;
                }else if (!$('input[name="schedule"]').is(":checked")){
                    jAlert('error', 'กรุณาเลือก Schedule!', 'Helpdesk System : Messages');
                    return false;
                }else if (dStart < dNOW){
                    jAlert('error', 'กรุณาเลือก Start Date/Time มากกว่า วันและเวลาปัจจุบัน (' + dNOW_dp + ')', 'Helpdesk System : Messages');
                    return false;
                }
                return true;
                
            }
            
    });

</script>
<br><br><br><br><br>
<input id="type_id" name="type_id" value="<?=$type_id?>" type="hidden" />
<input id="user_id" name="user_id" value="<?=  user_session::get_user_id();?>" type="hidden" />
<div align="center" width="98%">
    <table id="tb_adv_left" width="50%" border="0">
    <tr>
        <th align="left">Start Date/Time<span class="required">*</span></th>
        <td><input id="sch_start" name="sch_start" type="datetime-local" value="<?=$start_datetime;?>">
        
        </td>
    </tr>
    <tr>
        <th align="left" valign="bottom">Schedule Task<span class="required">*</span></th>
        <td align="left" valign="central"><br>
                <input type="radio" name="schedule" value="H" style="width: 10%; height: 15px;" <?=($job == "H") ? "checked" : ""; ?> >Hourly<br>
                <input type="radio" name="schedule" value="D" style="width: 10%; height: 15px;" <?=($job == "D") ? "checked" : ""; ?> >Daily<br>
                <input type="radio" name="schedule" value="W" style="width: 10%; height: 15px;" <?=($job == "W") ? "checked" : ""; ?> >Weekly<br>
                <input type="radio" name="schedule" value="M" style="width: 10%; height: 15px;" <?=($job == "M") ? "checked" : ""; ?> >Monthly<br>  
        </td>
    </tr>
    <tr>
        <th align="left">Enable</th>
        <td align="left" ><input id="enabled" name="enabled" type="checkbox" style="width: 10%;" <?=($enabled == "Y") ? "checked" : ""; ?> /></td>
    </tr>
    <tr>
        <td clospan="2" align="center"><span id="ajax-panel"></span><br><label id="message" name="message"></label></td>
    </tr>
    <tr>
        <td width="50%"><input id="ip1" type="hidden"/><input id="ip2" type="hidden"/></td>
        <td width="50%"></td>
    </tr>
    
    </table>
    
</div>
    
    

