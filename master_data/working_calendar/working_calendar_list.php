<?php
   include_once 'working_calendar_list.action.php';
   
?>
<script type="text/javascript">
  $(function() {
    $( "#datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy',  
        changeMonth: true,  
        changeYear: true  
    }); 
    
    $( "#spe_datepicker" ).datepicker({
        dateFormat: 'dd-mm-yy',  
        changeMonth: true,  
        changeYear: true  
    }); 
    
  });
  
 $(document).ready(function () {    
     
     
        /* ===========  Calendar Left side =========== */
        $("#btn_select_holiday").click(function(){
            var selected_date = $( "#datepicker" ).datepicker("getDate");
            var d = selected_date.getDate();
            var m = selected_date.getMonth() + 1; //Months are zero based
            var y = selected_date.getFullYear();
            
            selected_date = (d <= 9 ? '0' + d : d) + "-" + (m<=9 ? '0' + m : m) + "-" + y;
            var selected_date_val = y + "" + (m<=9 ? '0' + m : m) + "" + (d <= 9 ? '0' + d : d);
//            alert (selected_date + ", " + selected_date_val);
            var o = new Option(selected_date, selected_date_val);
            $(o).html(selected_date);
            $("#date_holiday").append(o);
        });
          
        $('#btn_deselect_holiday').click(function() {
            $("#date_holiday").find('option:selected').remove();
         });
         
         
         
         /* ===========  Calendar Right side =========== */
        $("#btn_save_spe").click(function(){
             if (chkValidate()){
                 if ($("#txt_speworktime_fr_1").val() == "" && $("#txt_speworktime_to_1").val() == ""){
                    jAlert('error', 'กรุณาใส่เวลาของวันทำงานพิเศษ!', 'Helpdesk System : Messages');
                    return false;
                }


                var selected_date = $( "#spe_datepicker" ).datepicker("getDate");

                var time1_fr = $("#txt_speworktime_fr_1").val();
                var time1_to = $("#txt_speworktime_to_1").val();
                var time2_fr = $("#txt_speworktime_fr_2").val();
                var time2_to = $("#txt_speworktime_to_2").val();
                var time3_fr = $("#txt_speworktime_fr_3").val();
                var time3_to = $("#txt_speworktime_to_3").val();

                var d = selected_date.getDate();
                var m = selected_date.getMonth() + 1; //Months are zero based
                var y = selected_date.getFullYear();

                selected_date = (d <= 9 ? '0' + d : d) + "-" + (m<=9 ? '0' + m : m) + "-" + y;
                appendWorkingSPE(selected_date,time1_fr + "-" + time1_to,time2_fr + "-" + time2_to,time3_fr + "-" + time3_to);

             }
            
        });

            $("#trash").live("click",function(){
              $(this).closest("tr").remove();
            });
        
        $("#dd_year").change(function(){  
            $("#cus_company_id").val("");
            $("#message").html("");
            clear_StandardWorking()
            clear_Holiday()
            clear_SpecialWorking()
        });        
         
        $("#cus_company_id").change(function(){  
            var year = $("#dd_year").val();
            var cus_comp_id = $(this).val();
            
            
            if (year == "" || year == "0"){
                 jAlert('error', 'กรุณาเลือก Year!', 'Helpdesk System : Messages');
                 $("#cus_company_id option[value='']").attr("selected", "selected");
                 return false;
             }
            
            if (cus_comp_id != "" && cus_comp_id != "0"){
                $.ajax({
                    type: "POST",
                    url: "getWorkingCalendar.php",
                    data : {cus_comp_id: cus_comp_id, year:year} ,         
                    beforeSend:function(){
                        // this is where we append a loading image
                        $('#ajax-panel').html('<img src="../../images/loading_small.gif" alt="Loading..." />');
                    },
                    success: function(response){
                        $('#ajax-panel').empty();
                        $("#message").html("");
            
                        clear_StandardWorking()
                        clear_Holiday()
                        clear_SpecialWorking()
            
                        var arr_all = $.parseJSON(response)
                        LoadToControl(arr_all);
                        
                    }
                });
            }else {
                $('#ajax-panel').empty();
                $("#message").html("");
                clear_StandardWorking()
                clear_Holiday()
                clear_SpecialWorking()
                        
                LoadToControl(arr_all);
                
            }
            
        });
        
        
        $("#btn_save").click(function(){        
            if (chkValidate()){
                var year = $("#dd_year").val();
                var cus_comp_id = $("#cus_company_id").val();
                var standard_working = {};
                var holiday = {};
                var special_working = {};
                
              
                standard_working = getStandardWorking();
                holiday = getHoliday();
                special_working = getSpecialWorking();
                $.ajax({
                    type: "POST",
                    url: "saveWorkingCalendar.php",
                    data : {year:year, cus_comp_id: cus_comp_id,standard_working : standard_working, holiday:holiday, special_working:special_working } ,         
                    beforeSend:function(){
                        // this is where we append a loading image
//                        alert('loading');
                        $('#ajax-panel').html('<img src="../../images/loading_small.gif" alt="Loading..." />');
                    },
                    success: function(response){
//                         alert(response);
                        $('#ajax-panel').empty();
                        if (response == "E"){
//                            $("#message").html("บันทึกรายการไม่สมบูรณ์!");
                            jAlert('error', "บันทึกรายการไม่สมบูรณ์!", 'Helpdesk System : Messages');
                            
                        }else {
//                            $("#message").html("บันทึกรายการเรียบร้อยแล้ว!");
                            jAlert('success', "บันทึกรายการเรียบร้อยแล้ว!", 'Helpdesk System : Messages');
                            
                        }
                    },
                    error:function(){
//                        alert('error');
                     $('#ajax-panel').empty();   
//                     $("#message").html('บันทึกรายการไม่สมบูรณ์!');
                    jAlert('error', "บันทึกรายการไม่สมบูรณ์!", 'Helpdesk System : Messages');
                     
                    }
                });
            }
            
        });
        
        
        $("#btn_back").click(function(){ 
            $("#dd_year").val("");
            $("#cus_company_id").val("");
            $("#message").html("");
            
            clear_StandardWorking()
            clear_Holiday()
            clear_SpecialWorking()
        });
        
});



function getStandardWorking(){
    var arr = new Array();
    
    
    arr[0] = $('#cb_sun').is(":checked") ? "Y" : "N";
    arr[1] = $('#cb_mon').is(":checked") ? "Y" : "N";
    arr[2] = $('#cb_tue').is(":checked") ? "Y" : "N";
    arr[3] = $('#cb_wed').is(":checked") ? "Y" : "N";
    arr[4] = $('#cb_thu').is(":checked") ? "Y" : "N";
    arr[5] = $('#cb_fri').is(":checked") ? "Y" : "N";
    arr[6] = $('#cb_sat').is(":checked") ? "Y" : "N";
    arr[7] = $('#cb_working').is(":checked") ? "Y" : "N";
    arr[8] = $('#txt_worktime_fr_1').val();
    arr[9]  = $('#txt_worktime_to_1').val();
    arr[10] = $('#txt_worktime_fr_2').val();
    arr[11]  = $('#txt_worktime_to_2').val();
    arr[12] = $('#txt_worktime_fr_3').val();
    arr[13]  = $('#txt_worktime_to_3').val();
    arr[14] = $('#cb_pending').is(":checked") ? "Y" : "N";
    
    
    return arr;
 }
 
 function getHoliday(){
     var arr = new Array();
     var n = 0;
     var id = "#date_holiday > option";

    $(id).each(function() {
        arr[n] = $(this).val();
//        alert(arr[n])
        n = n+1;
    });
    
    return arr;
 }
 
 
 function getSpecialWorking(){
    var tb = new Array();
    var tb_name = "table#tb_working_spe tr";
    var n = 0;
    
    $("#tb_working_spe tr").each(function() {   
        tb[n] = new Array();
        var date = this.cells[1].innerHTML.split("-");
        var time1 = this.cells[2].innerHTML.split("-");
        var time2 = this.cells[3].innerHTML.split("-");
        var time3 = this.cells[4].innerHTML.split("-");

        tb[n][0] = date[2] + "" + date[1] + "" + date[0];
        tb[n][1] = time1[0];
        tb[n][2] = time1[1];
        tb[n][3] = time2[0];
        tb[n][4] = time2[1];
        tb[n][5] = time3[0];
        tb[n][6] = time3[1];
        n = n+1;
    });
           
    return tb;       
 }
   
        
 function chkValidate(){
     if ($("#dd_year").val() == "" || $("#dd_year").val() == "0"){
         jAlert('error', 'กรุณาเลือก Year!', 'Helpdesk System : Messages');
         return false;
     }else if ($("#cus_company_id").val() == "" || $("#cus_company_id").val() == "0"){
         jAlert('error', 'กรุณาเลือก Customer Company!', 'Helpdesk System : Messages');
         return false;
     }
     return true;
 }       
        
        
 function appendWorkingSPE(date,time1,time2,time3){
        var tb_name = "table#tb_working_spe tr:last";//# + name + " tr";
        var str_append = "<tr>";
        str_append += "<td align='center'><a id='trash' name='trash' class='nonborder' ><img src='../../images/trash.png' /></a></td>";
        str_append += "<td>" + date + "</td>";
        str_append += "<td>" + time1 + "</td>";
        str_append += "<td>" + time2 + "</td>";
        str_append += "<td>" + time3 + "</td>";
        str_append += "</tr>";
        $(tb_name).after(str_append);
        return false;

    }       
        
  function LoadToControl(arr){

    if (arr.length > 0){
      var arr_standard = arr[0];
      load_StandardWorking(arr_standard);
      
      var arr_holiday = arr[1];
      load_Holiday(arr_holiday);
      
      var arr_special = arr[2];
      load_SpecialWorking(arr_special);
      
    }
  }

  
  function load_StandardWorking(arr){
      $.each(arr, function (index, value) {
//            alert(value.sunday);
            $("input[name=cb_sun]").attr('checked', (value.sunday == "Y") ? true : false);
            $("input[name=cb_mon]").attr('checked', (value.monday == "Y") ? true : false);
            $("input[name=cb_tue]").attr('checked', (value.tuesday == "Y") ? true : false);
            $("input[name=cb_wed]").attr('checked', (value.wednesday == "Y") ? true : false);
            $("input[name=cb_thu]").attr('checked', (value.thursday == "Y") ? true : false);
            $("input[name=cb_fri]").attr('checked', (value.friday == "Y") ? true : false);
            $("input[name=cb_sat]").attr('checked', (value.saturday == "Y") ? true : false);
            $('input[name=cb_working]').attr('checked', (value.flag_working == "Y") ? true : false);
            $('#txt_worktime_fr_1').val((value.time1_from == "00:00") ? "" : value.time1_from);
            $('#txt_worktime_to_1').val((value.time1_to == "00:00") ? "" : value.time1_to);
            $('#txt_worktime_fr_2').val((value.time2_from == "00:00") ? "" : value.time2_from);
            $('#txt_worktime_to_2').val((value.time2_to == "00:00") ? "" : value.time2_to);
            $('#txt_worktime_fr_3').val((value.time3_from == "00:00") ? "" : value.time3_from);
            $('#txt_worktime_to_3').val((value.time3_to == "00:00") ? "" : value.time3_to);
            $('input[name=cb_pending]').attr('checked', (value.deduct_pending == "Y") ? true : false);
       });      
  }
  
  function clear_StandardWorking(){
        $("input[name=cb_sun]").attr('checked', false);
        $("input[name=cb_mon]").attr('checked', false);
        $("input[name=cb_tue]").attr('checked', false);
        $("input[name=cb_wed]").attr('checked', false);
        $("input[name=cb_thu]").attr('checked', false);
        $("input[name=cb_fri]").attr('checked', false);
        $("input[name=cb_sat]").attr('checked', false);
        $('input[name=cb_working]').attr('checked', false);
        $('#txt_worktime_fr_1').val("");
        $('#txt_worktime_to_1').val("");
        $('#txt_worktime_fr_2').val("");
        $('#txt_worktime_to_2').val("");
        $('#txt_worktime_fr_3').val("");
        $('#txt_worktime_to_3').val("");
        $('input[name=cb_pending]').attr('checked', false);
  }
  
  
  function load_Holiday(arr){
      $.each(arr, function (index, value) {
          var selected_date = value.display_date;
          var selected_date_val = value.value_date;
          
          var o = new Option(selected_date, selected_date_val);
          $(o).html(selected_date);
          $("#date_holiday").append(o);
      }); 
  }
  
  function clear_Holiday(){
       $("#date_holiday").find('option').remove();
  }

    
  function load_SpecialWorking(arr){
      $.each(arr, function (index, value) {
          var date = value.display_date;
          var time1 = value.time1_from + "-" + value.time1_to;
          var time2 = value.time2_from + "-" + value.time2_to;
          var time3 = value.time3_from + "-" + value.time3_to;
          
          appendWorkingSPE(date,time1,time2,time3)
      }); 
  }  
  
  
  function clear_SpecialWorking(){
      var table = document.getElementById("tb_working_spe");
      for(var i = table.rows.length - 1; i > 0; i--)
      {
        table.deleteRow(i);
      }
      
        $("#txt_speworktime_fr_1").val("");
        $("#txt_speworktime_to_1").val("");
        $("#txt_speworktime_fr_2").val("");
        $("#txt_speworktime_to_2").val("");
        $("#txt_speworktime_fr_3").val("");
        $("#txt_speworktime_to_3").val("");
        
      
  }



 



        
</script>
<style type="text/css">
.ui-datepicker{  
    width:170px;  
    font-family:tahoma;  
    font-size:11px;  
    text-align:center;  
}  

.nonborder{
    border: none;
    cursor: pointer;
}

</style>
<div style="height:650px; overflow-y: auto;">
    <br>
    <!--<input id="test" name="test" type="text" />-->
    <div align="left">
        <table id="tb_adv_left" width="90%">
                <tr>
                    <th align="left" width="30%">Year <span class="required">*</span></th>
                    <td align="left" width="50%"><?=$dd_year;?></td>
                    <td align="left" width="20%"></td>
                </tr>
                <tr>
                    <th align="left" width="30%">Customer Company <span class="required">*</span></th>
                    <td align="left" width="50%"><?=$dd_company;?></td>
                    <td align="left" width="20%" style="padding-left: 5px"><span id="ajax-panel"></span></td>
                </tr>
        </table>
    </div>   
    
    <br><label id="message" name="message"></label><br>
    <div id="divLeft" align="left">
        <table id="tb_adv_left" width="90%">
            <tr>
                <td colspan="3"><span class="styleGray">For Standard</span></td>
            </tr>
            
            <tr>
                <th colspan="3" align="left" ><br><br>Standard Working Day<span class="required">*</span></th>
            </tr>  
            <tr>
                <td colspan="3" align="left"><br>
                    <div align="right">
                        <input type="checkbox" id="cb_sun" name="cb_sun" value="sunday" style="width: 5%">Sun.&nbsp;&nbsp;
                        <input type="checkbox" id="cb_mon" name="cb_mon" value="monday" style="width: 5%">Mon.&nbsp;&nbsp;
                        <input type="checkbox" id="cb_tue" name="cb_tue" value="tuesday" style="width: 5%">Tue.&nbsp;&nbsp;
                        <input type="checkbox" id="cb_wed" name="cb_wed" value="wednesday" style="width: 5%">Wed.&nbsp;&nbsp;
                        <input type="checkbox" id="cb_thu" name="cb_thu" value="thursday" style="width: 5%">Thu.&nbsp;&nbsp;
                        <input type="checkbox" id="cb_fri" name="cb_fri" value="friday" style="width: 5%">Fri.&nbsp;&nbsp;
                        <input type="checkbox" id="cb_sat" name="cb_sat" value="saturday" style="width: 5%">Sat.&nbsp;&nbsp;
                    </div>
                </td>
            </tr>
            <tr>
                <th colspan="3" align="left" ><br><br>Working Time<span class="required">*</span></th>
            </tr>
            <tr>
                <td><br><input class="timepicker" id="txt_worktime_fr_1" name="txt_worktime_fr_1" style="text-align: center;" type="time" /></td>
                <td align="center"><br>To</td>
                <td><br><input class="timepicker" id="txt_worktime_to_1" name="txt_worktime_to_1" style="text-align: center;" type="time"  /></td>
            </tr>
            <tr>
                <td><input id="txt_worktime_fr_2" name="txt_worktime_fr_2" style="text-align: center;"  type="time"   /></td>
                <td align="center">To</td>
                <td><input id="txt_worktime_to_2" name="txt_worktime_to_2" style="text-align: center;" type="time"   /></td>
            </tr>
            <tr>
                <td><input id="txt_worktime_fr_3" name="txt_worktime_fr_3" style="text-align: center;" type="time"  /></td>
                <td align="center">To</td>
                <td><input id="txt_worktime_to_3" name="txt_worktime_to_3" style="text-align: center;" type="time"  /></td>
            </tr>
            <tr>
                <th colspan="3" align="left" ><br><br>Special Holiday<span class="required">*</span></th>
            </tr>
            <tr>
                <td><br><span id="datepicker" name="datepicker" style="width: 50%" /></td>
                <td align="center" style=" position: inherit">
                    <img src="../../images/m_forward.png" title="select" id="btn_select_holiday" name="btn_select_holiday" /><br><br><br><br><br>
                    <img src="../../images/m_back.png" title="deselect" id="btn_deselect_holiday" name="btn_deselect_holiday"  />
                </td>
                <td><br>
                    <select name="date_holiday" id="date_holiday" multiple style="resize: none; overflow-y: auto; height: 150px; width: 100%; text-align: center;"></select>
                    <!--<textarea style="resize: none; overflow-y: auto; height: 150px; text-align: center;" cols="1" rows="100" readonly="true"></textarea>-->
                </td>
            </tr>
            <tr>
                <th colspan="3" align="right" ><br><br>
                    <div style="float: left;">
                        SLA Calculate within working day&time&nbsp;&nbsp;&nbsp;&nbsp; 
                    </div>
                    <div style="float: right;">
                        <input type="checkbox" name="cb_working" id="cb_working" value="1" >
                    </div>
                </th>
                
            </tr>
            <tr>
                <th colspan="3" align="right" >
                    <div style="float: left;">
                        Deduct pending status&nbsp;&nbsp;&nbsp;&nbsp; 
                    </div>
                    <div style="float: right;">
                        <input type="checkbox" name="cb_pending" id="cb_pending" value="1" >
                    </div>
                </th>
                
            </tr>
            <tr>
                <td width="40%"></td>
                <td width="20%"></td>
                <td width="40%"></td>
            </tr>

        </table>

    </div>    
    <div id="divRight" align="left">
        <table id="tb_adv_left" width="90%" style=" padding-left: 30px">
            <tr>
                <td colspan="4"><span class="styleGray">For Special Working Day</span></td>
            </tr>
            
            <tr>
                <th colspan="4" align="left" ><br><br>Date&Time Set</th>
            </tr>
            <tr>
                <td rowspan="4"><br><span id="spe_datepicker" name="spe_datepicker" style="width: 50%" /></td>
                <td style=" padding-left: 3px"><br><br><br><input class="timepicker" id="txt_speworktime_fr_1" name="txt_speworktime_fr_1" style="text-align: center;" type="time" /></td>
                <td align="center"><br><br><br>To</td>
                <td><br><br><br><input class="timepicker" id="txt_speworktime_to_1" name="txt_speworktime_to_1" style="text-align: center;" type="time"  /></td>
            </tr>
            <tr>
                <td style=" padding-left: 3px"><br><input id="txt_speworktime_fr_2" name="txt_speworktime_fr_2" style="text-align: center;"  type="time"   /></td>
                <td align="center"><br>To</td>
                <td><br><input id="txt_speworktime_to_2" name="txt_speworktime_to_2" style="text-align: center;" type="time"   /></td>
            </tr>
            <tr>
                <td style=" padding-left: 3px"><br><input id="txt_speworktime_fr_3" name="txt_speworktime_fr_3" style="text-align: center;" type="time"  /></td>
                <td align="center"><br><br>To</td>
                <td><br><input id="txt_speworktime_to_3" name="txt_speworktime_to_3" style="text-align: center;" type="time"  /></td>
            </tr>
            <tr>
                <td align="center">
                    <img id="btn_save_spe" name="btn_save_spe" src="../../images/arrow_down.png" title="save special working day" style="cursor: pointer; border: none;" />&nbsp;&nbsp;&nbsp;&nbsp; 
                    <!--<img id="btn_del_spe" name="btn_del_spe" src="../../images/cancel_round.png" title="delete selected special working day" style="cursor: pointer; border: none;" />-->
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4"><br>
                    <div style="width:110%; height: 240px; overflow-y: auto;">
                        <table id="tb_working_spe" name="tb_working_spe" class="working_spe" style="width:98%; ">
                            <tr style="background-color: #dce6ee">
                                
                                    <th width="5%" align="center">&nbsp;</th>
                                    <th width="20%" align="center" >Date</th>
                                    <th width="25%" align="center" >Time1</th>
                                    <th width="25%" align="center" >Time2</th>
                                    <th width="25%" align="center" >Time3</th>
                               
                            </tr>
                            
                        </table>
                    </div>
                    
                </td>
            </tr>
<!--            <tr>
                <th colspan="3" align="right" ><br><br>
                    <div style="float: left;">
                        SLA Calculate within working time&nbsp;&nbsp;&nbsp;&nbsp; 
                    </div>
                    <div style="float: right;">
                        <input type="checkbox" name="cb_work" id="cb_work" value="1" >
                    </div>
                </th>
                
            </tr>-->
            <tr>
                <td width="40%"></td>
                <td width="27%"></td>
                <td width="6%"></td>
                <td width="27%"></td>
                
            </tr>

        </table>
    </div>
</div>
