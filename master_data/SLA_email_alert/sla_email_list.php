<?php
include_once 'sla_email_list.action.php';

?>
<script type="text/javascript">
$(function(){
//In active on change assign_comp_id
            

            $("#assign_comp_id").change(function(){
            var assign_comp_id = $(this).val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.org_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&attr=style=\"width: 100%;\"",
                            success: function(response){
                                document.getElementById("assign_org_id").innerHTML =response;
                                //===============================================
                                $("#ddassign_comp_id").val($("#assign_comp_id").val());
                                //===============================================
                                $("#ddassign_org_id").val($("#assign_org_id").val());
                            }
                        });
                        
            //====In active on change assign_org_id
            var assign_org_id = $("#assign_org_id").val();
            var assign_comp_id = $(this).val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.grp_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_org_id=" + assign_org_id +"&attr=style=\"width: 100%;\"",
                            success: function(response){
                                document.getElementById("assign_group_id").innerHTML =response;
                                //===============================================
                                $("#ddassign_org_id").val($("#assign_org_id").val());  
                            }
                        });
                        
            //====In active on change assign_group_id
            var assign_group_id = $("#assign_group_id").val();
            var assign_comp_id = $(this).val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.subgrp_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_group_id=" + assign_group_id +"&attr=style=\"width: 100%;\"",
                            success: function(response){
                                document.getElementById("assign_subgrp_id").innerHTML =response;
                                //===============================================
                                $("#ddassign_group_id").val($("#assign_group_id").val());   
                            }
                        });
                        
//            //==== USER
//            var assign_subgrp_id = $("#assign_subgrp_id").val();
//            var assign_comp_id = $(this).val();
//                        
//			$.ajax({
//                            type: "POST",
//                            url: "search_user.php",
//                            data: "assign_comp_id=" + assign_comp_id +"&assign_subgrp_id=" + assign_subgrp_id ,
//                            success: function(response){
//                                var arr_all = $.parseJSON(response);
//                                clearUser();
//                                loadUser(arr_all);
//                            }
//                        });

            });
            
            
            
            
            //In active on change assign_org_id
            $("#assign_org_id").change(function(){
            var assign_org_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
           
			$.ajax({
                            type: "GET",
                            url: "dropdown.grp_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_org_id=" + assign_org_id +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("assign_group_id").innerHTML =respone;
                                //===============================================
                                $("#ddassign_org_id").val($("#assign_org_id").val());
                                //===============================================
                                $("#ddassign_group_id").val($("#assign_group_id").val());   
                            }
                        });
                        
                        
                        //====In active on change assign_group_id
            var assign_group_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.subgrp_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_group_id=" + assign_group_id +"&attr=style=\"width: 100%;\"",
                            success: function(response){
                                document.getElementById("assign_subgrp_id").innerHTML =response;
                                //===============================================
                                $("#ddassign_group_id").val($("#assign_group_id").val());   
                            }
                        });
                        
            //==== USER
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
                        
			$.ajax({
                            type: "GET",
                            url: "search_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_subgrp_id=" + assign_subgrp_id ,
                            success: function(response){
                                var arr_all = $.parseJSON(response);
                                clearUser();
                                loadUser(arr_all);
                            }
                        });
                        
            
                    var head = new Array();
                    
                    head[0] = $("#assign_comp_id").val();
                    head[1] = $("#assign_org_id").val();
                    head[2] = $("#assign_group_id").val();
                    head[3] = $("#assign_subgrp_id").val();
                    
                        $.ajax({
                            type: "POST",
                            url: "load.php",
                            data: {head : head } , 
                            success: function(response){
//                                $("#message").html(response);
                                clearallControl();
                                var arr_all = $.parseJSON(response);
                                loadtoControl(arr_all);

                            }
                        });
                        
            });
		
                
            //In active on change assign_group_id
            $("#assign_group_id").change(function(){
            var assign_group_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
                       
			$.ajax({
                            type: "GET",
                            url: "dropdown.subgrp_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_group_id=" + assign_group_id +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("assign_subgrp_id").innerHTML =respone;
                                //===============================================
                                $("#ddassign_group_id").val($("#assign_group_id").val());   
                            }
                        });
                        
                        
//                        //==== USER
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
//                        
//			$.ajax({
//                            type: "GET",
//                            url: "search_user.php",
//                            data: "assign_comp_id=" + assign_comp_id +"&assign_subgrp_id=" + assign_subgrp_id ,
//                            success: function(response){
//                                var arr_all = $.parseJSON(response);
//                                clearUser();
//                                loadUser(arr_all);
//                            }
//                        });
                        
                        var head = new Array();
                    
                        head[0] = $("#assign_comp_id").val();
                        head[1] = $("#assign_org_id").val();
                        head[2] = $("#assign_group_id").val();
                        head[3] = $("#assign_subgrp_id").val();
                    
                        $.ajax({
                            type: "POST",
                            url: "load.php",
                            data: {head : head } , 
                            success: function(response){
//                                $("#message").html(response);
                                clearallControl();
                                var arr_all = $.parseJSON(response);
                                loadtoControl(arr_all);

                            }
                        });
              });
		
            //In active on change assign_subgrp_id
            $("#assign_subgrp_id").change(function(){
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
//
//			$.ajax({
//                            type: "GET",
//                            url: "search_user.php",
//                            data: "assign_comp_id=" + assign_comp_id +"&assign_subgrp_id=" + assign_subgrp_id ,
//                            success: function(response){
//                                var arr_all = $.parseJSON(response);
//                                clearUser();
//                                loadUser(arr_all);
//     
//                            }
//                        });
                        
                        
                        var head = new Array();
                    
                        head[0] = $("#assign_comp_id").val();
                        head[1] = $("#assign_org_id").val();
                        head[2] = $("#assign_group_id").val();
                        head[3] = $("#assign_subgrp_id").val();

                        $.ajax({
                            type: "POST",
                            url: "load.php",
                            data: {head : head } , 
                            success: function(response){
//                                $("#message").html(response);
                                clearallControl();
                                var arr_all = $.parseJSON(response);
                                loadtoControl(arr_all);

                            }
                        });
            });
            
            
            /*================ On SLA ==============*/
            
            /*---------- LEVEL 1 */
            $("#btn_to_lv1").click(function(){
                if (chkRequire("pc_lv1")){
                    appendUser("user_to_lv1");
                }
            });
            
            $("#del_to_lv1").click(function(){
                $("#user_to_lv1").find('option:selected').remove();
            });
            
            $("#btn_cc_lv1").click(function(){
                if (chkRequire("pc_lv1")){
                    appendUser("user_cc_lv1");
                }
            });
            
            $("#del_cc_lv1").click(function(){
                $("#user_cc_lv1").find('option:selected').remove();
            });
            
            
            /*---------- LEVEL 2 */
            $("#btn_to_lv2").click(function(){
                if (chkRequire("pc_lv2")){
                    appendUser("user_to_lv2");
                }
            });
            
            $("#del_to_lv2").click(function(){
                $("#user_to_lv2").find('option:selected').remove();
            });
            
            $("#btn_cc_lv2").click(function(){
                if (chkRequire("pc_lv2")){
                    appendUser("user_cc_lv2");
                }
            });
            
            $("#del_cc_lv2").click(function(){
                $("#user_cc_lv2").find('option:selected').remove();
            });
            
            /*---------- LEVEL 3 */
            $("#btn_to_lv3").click(function(){
                if (chkRequire("pc_lv3")){
                    appendUser("user_to_lv3");
                }
            });
            
            $("#del_to_lv3").click(function(){
                $("#user_to_lv3").find('option:selected').remove();
            });
            
            $("#btn_cc_lv3").click(function(){
                if (chkRequire("pc_lv3")){
                    appendUser("user_cc_lv3");
                }
            });
            
            $("#del_cc_lv3").click(function(){
                $("#user_cc_lv3").find('option:selected').remove();
            });
            
            
            /*================ Over SLA ==============*/
            
            /*---------- LEVEL 1 */
            $("#btn_to_over_lv1").click(function(){
                if (chkRequire("pc_over_lv1")){
                    appendUser("user_to_over_lv1");
                }
            });
            
            $("#del_to_over_lv1").click(function(){
                $("#user_to_over_lv1").find('option:selected').remove();
            });
            
            $("#btn_cc_over_lv1").click(function(){
                if (chkRequire("pc_over_lv1")){
                    appendUser("user_cc_over_lv1");
                }
            });
            
            $("#del_cc_over_lv1").click(function(){
                $("#user_cc_over_lv1").find('option:selected').remove();
            });
            
            
            
            /*---------- LEVEL 2 */
            $("#btn_to_over_lv2").click(function(){
                if (chkRequire("pc_over_lv2")){
                    appendUser("user_to_over_lv2");
                }
            });
            
            $("#del_to_over_lv2").click(function(){
                $("#user_to_over_lv2").find('option:selected').remove();
            });
            
            $("#btn_cc_over_lv2").click(function(){
                if (chkRequire("pc_over_lv2")){
                    appendUser("user_cc_over_lv2");
                }
            });
            
            $("#del_cc_over_lv2").click(function(){
                $("#user_cc_over_lv2").find('option:selected').remove();
            });
            
            /*---------- LEVEL 3 */
            $("#btn_to_over_lv3").click(function(){
                if (chkRequire("pc_over_lv3")){
                    appendUser("user_to_over_lv3");
                }
            });
            
            $("#del_to_over_lv3").click(function(){
                $("#user_to_over_lv3").find('option:selected').remove();
            });
            
            $("#btn_cc_over_lv3").click(function(){
                if (chkRequire("pc_over_lv3")){
                    appendUser("user_cc_over_lv3");
                }
            }); 
            
            $("#del_cc_over_lv3").click(function(){
                $("#user_cc_over_lv3").find('option:selected').remove();
            });
            
            
            
            /* =============== SAVE ==============*/
            $("#btn_save").click(function(){
//                alert($('#user_to_lv1 option').length);
                if (chkValidate()){
                    var arr_on = getOnSLA();
                    var arr_over = getOverSLA();
                    var head = new Array();
                    
                    head[0] = $("#assign_comp_id").val();
                    head[1] = $("#assign_org_id").val();
                    head[2] = $("#assign_group_id").val();
                    head[3] = $("#assign_subgrp_id").val();
                    head[4] = $('#cb_deduct_pending').is(":checked") ? "Y" : "N";
                    
//                    alert(head[0] + "," + head[1] + "," + head[2] + "," + head[3] )
                    
                    $.ajax({
                    type: "POST",
                    url: "save.php",
                    data : {head : head, on : arr_on,over : arr_over } ,         
                    beforeSend:function(){
                        $('#ajax-panel').html('<img src="../../images/loading_small.gif" alt="Loading..." />');
                    },
                    success: function(response){
                        $('#ajax-panel').empty();
                        if (response == 1){
//                            $("#message").html("บันทึกรายการเรียบร้อยแล้ว!");
                            jAlert('success', "บันทึกรายการเรียบร้อยแล้ว!", 'Helpdesk System : Messages');
                        }else{
                            jAlert('error', "บันทึกรายการไม่สมบูรณ์!", 'Helpdesk System : Messages');
                        }

                    },
                    error:function(){
//                        alert('error');
//                     $("#message").html('บันทึกรายการไม่สมบูรณ์!');
                    jAlert('error', "บันทึกรายการไม่สมบูรณ์!", 'Helpdesk System : Messages');
                     $('#ajax-panel').empty();  
                    }
                    });
                }
                 
            });
            
            
            
            $("#btn_back").click(function(){ 
                $("#assign_comp_id").val("");
                $("#assign_org_id").val("");
                $("#assign_group_id").val("");
                $("#assign_subgrp_id").val("");

                clearUser();
                clearallControl();
            });
            
            
            
//            //setup before functions
//            var typingTimer;                //timer identifier
//            var doneTypingInterval = 3000;  //time in ms, 5 second for example
//
//            //on keyup, start the countdown
//            $('#pc_lv2').keyup(function(){
//                clearTimeout(typingTimer);
//                if ($('#myInput').val) {
//                    typingTimer = setTimeout(doneTyping, doneTypingInterval);
//                }
//            });
            
            
            
            
});
          
            


////user is "finished typing," do something
//function doneTyping () {
//    //do something
//    alert('finish!');
//}
            
            
function loadtoControl(arr){
    
    $.each(arr, function (index, value) {
    
        $('input[name=cb_deduct_pending]').attr('checked', (value.deduct_pending == "Y") ? true:false);
        $("#pc_lv1").val((value.on_sla_l1 == 0) ? "":value.on_sla_l1);
        loadtoListbox("user_to_lv1",value.on_sla_l1_to);
        loadtoListbox("user_cc_lv1",value.on_sla_l1_cc);
        $("#pc_lv2").val((value.on_sla_l2 == 0) ? "":value.on_sla_l2);
        loadtoListbox("user_to_lv2",value.on_sla_l2_to);
        loadtoListbox("user_cc_lv2",value.on_sla_l2_cc);
        $("#pc_lv3").val((value.on_sla_l3 == 0) ? "":value.on_sla_l3);
        loadtoListbox("user_to_lv3",value.on_sla_l3_to);
        loadtoListbox("user_cc_lv3",value.on_sla_l3_cc);  

        $("#pc_over_lv1").val((value.over_sla_l1 == 0) ? "":value.over_sla_l1);
        loadtoListbox("user_to_over_lv1",value.over_sla_l1_to);
        loadtoListbox("user_cc_over_lv1",value.over_sla_l1_cc);
        $("#pc_over_lv2").val((value.over_sla_l2 == 0) ? "":value.over_sla_l2);
        loadtoListbox("user_to_over_lv2",value.over_sla_l2_to);
        loadtoListbox("user_cc_over_lv2",value.over_sla_l2_cc);
        $("#pc_over_lv3").val((value.over_sla_l3 == 0) ? "":value.over_sla_l3);
        loadtoListbox("user_to_over_lv3",value.over_sla_l3_to);
        loadtoListbox("user_cc_over_lv3",value.over_sla_l3_cc);
    }); 
}

function loadtoListbox(id,arr){
    var i;
    id = "#" + id;
    
//    alert(arr.length);
    if (arr != ""){
        arr = arr.split(",");
        $.each(arr , function(i, val) { 
            var s_email = arr[i];
            $.ajax({
                  type: "POST",
                  url: "get_user_by_email.php",
                  data: "email=" + s_email ,
                  success: function(response){
//                      alert(id + ":" + s_email + ":" + i);
                      var o = new Option(response, s_email);
                      $(o).html(response);
                      $(id).append(o);
                  }            
              }); 
        });
    }    
}



function loadUser(arr){

    $('#lb_user option').each(function(index, option) {
        $(option).remove();
    });

    $.each(arr, function (index, value) {
          var name = value.assign_assignee_name;
          var id = value.assign_assignee_id;
          var email = value.email;

          var o = new Option(name, email);
          $(o).html(name);
          $("#lb_user").append(o);
      }); 
      
}


function clearUser(){
    $('#lb_user option').each(function(index, option) {
        $(option).remove();
    });
}

function appendUser(id){
    id = "#" + id;
    $('#lb_user :selected').each(function(i, selected){ 
        var text = $(selected).text();
        var val = $(selected).val();
//        alert(val);

        var o = new Option(text, val);
        $(o).html(text);
        $(id).append(o);
    });
}

function getOnSLA(){
    var arr = new Array()
    
    arr[0] = new Array()
    arr[0][0] = $("#pc_lv1").val();
    arr[0][1] = getUser("user_to_lv1");
    arr[0][2] = getUser("user_cc_lv1");
    
    arr[1] = new Array()
    arr[1][0] = $("#pc_lv2").val();
    arr[1][1] = getUser("user_to_lv2");
    arr[1][2] = getUser("user_cc_lv2");
    
    arr[2] = new Array()
    arr[2][0] = $("#pc_lv3").val();
    arr[2][1] = getUser("user_to_lv3");
    arr[2][2] = getUser("user_cc_lv3");
    
    return arr;
    
}

function getOverSLA(){
    var arr = new Array()
    
    arr[0] = new Array()
    arr[0][0] = $("#pc_over_lv1").val();
    arr[0][1] = getUser("user_to_over_lv1");
    arr[0][2] = getUser("user_cc_over_lv1");
    
    arr[1] = new Array()
    arr[1][0] = $("#pc_over_lv2").val();
    arr[1][1] = getUser("user_to_over_lv2");
    arr[1][2] = getUser("user_cc_over_lv2");
    
    arr[2] = new Array()
    arr[2][0] = $("#pc_over_lv3").val();
    arr[2][1] = getUser("user_to_over_lv3");
    arr[2][2] = getUser("user_cc_over_lv3");
    
    return arr;
}

function getUser(id){
     var id = "#" + id + " > option";
     var s_val = "";
     
    $(id).each(function() {
//        alert($(this).val());
        if (s_val != ""){
            s_val += ",";
        }
        s_val += $(this).val();
        
    });
    
    return s_val;
}

function chkValidate(){
//    alert(Number($("#pc_over_lv1").val()));
//    alert(Number($("#pc_over_lv2").val()));
//    alert(Number($("#pc_over_lv3").val()))
    
     if ($("#assign_comp_id").val() == ""){
         jAlert('error', 'กรุณาเลือก Company!', 'Helpdesk System : Messages');
         return false;
     }else if ($("#assign_org_id").val() == ""){
         jAlert('error', 'กรุณาเลือก Organize!', 'Helpdesk System : Messages');
         return false;
     }else if (!Number($("#pc_lv1").val()) && $("#pc_lv1").val() != ''){ //typeof num1 == 'number'
         jAlert('error', 'กรุณากรอกเปอร์เซ็นต์ On SLA : level1 เป็นตัวเลข!', 'Helpdesk System : Messages');
         return false;
     }else if ((!Number($("#pc_lv2").val())) && $("#pc_lv2").val() != ''){
         jAlert('error', 'กรุณากรอกเปอร์เซ็นต์ On SLA : level2 เป็นตัวเลข!', 'Helpdesk System : Messages');
         return false;
     }else if ((!Number($("#pc_lv3").val())) && $("#pc_lv3").val() != ''){
            jAlert('error', 'กรุณากรอกเปอร์เซ็นต์ On SLA : level3 เป็นตัวเลข!', 'Helpdesk System : Messages');
            return false;  
     }else if (!Number($("#pc_over_lv1").val()) && $("#pc_over_lv1").val() != ''){ //typeof num1 == 'number'
         jAlert('error', 'กรุณากรอกเปอร์เซ็นต์ Over SLA : level1 เป็นตัวเลข!', 'Helpdesk System : Messages');
         return false;
     }else if ((!Number($("#pc_over_lv2").val())) && $("#pc_over_lv2").val() != ''){
         jAlert('error', 'กรุณากรอกเปอร์เซ็นต์ Over SLA : level2 เป็นตัวเลข!', 'Helpdesk System : Messages');
         return false; 
     }else if ((!Number($("#pc_over_lv3").val())) && $("#pc_over_lv3").val() != ''){
         jAlert('error', 'กรุณากรอกเปอร์เซ็นต์ Over SLA : level3 เป็นตัวเลข!', 'Helpdesk System : Messages');
         return false;  
     }else if ($("#pc_lv3").val() != "" && $("#pc_lv2").val() != "" 
         && (Number($("#pc_lv3").val()) >= Number($("#pc_lv2").val()))){
         jAlert('error', 'On SLA : level3 ต้องน้อยกว่า level2', 'Helpdesk System : Messages');
         return false; 
     }else if ($("#pc_lv2").val() != "" && $("#pc_lv1").val() != "" 
         && (Number($("#pc_lv2").val()) >= Number($("#pc_lv1").val()))){
         jAlert('error', 'On SLA : level2 ต้องน้อยกว่า level1!', 'Helpdesk System : Messages');
         return false; 
     }else if ($("#pc_over_lv3").val() != "" && $("#pc_over_lv2").val() != "" 
         && (Number($("#pc_over_lv3").val()) <= Number($("#pc_over_lv2").val()))){
         jAlert('error', 'Over SLA : level3 ต้องมากกว่า level2!', 'Helpdesk System : Messages');
         return false; 
     }else if ($("#pc_over_lv2").val() != "" && $("#pc_over_lv1").val() != "" 
         && (Number($("#pc_over_lv2").val()) <= Number($("#pc_over_lv1").val())) ){
         jAlert('error', 'Over SLA : level2 ต้องมากกว่า level1!', 'Helpdesk System : Messages');
         return false; 
     }else if (Number($("#pc_lv3").val()) > 100 || Number($("#pc_lv2").val()) > 100 || Number($("#pc_lv1").val()) > 100 ||
         Number($("#pc_over_lv3").val()) > 100 || Number($("#pc_over_lv2").val()) > 100 || Number($("#pc_over_lv1").val()) > 100) {
         jAlert('error', 'ไม่สามารถใส่จำนวนเกิน 100%!', 'Helpdesk System : Messages');
         return false; 
     }else if ( $("#pc_lv1").val() != "" && $("#pc_lv1").val() != "0" && $('#user_to_lv1 option').length == 0 && $('#user_cc_lv1 option').length == 0 ){
         jAlert('error', 'กรุณาเลือกรายชื่อ On SLA : level1!', 'Helpdesk System : Messages');
         return false;
     }else if ( $("#pc_lv2").val() != "" && $("#pc_lv2").val() != "0" && $('#user_to_lv2 option').length == 0 && $('#user_cc_lv2 option').length == 0 ){
         jAlert('error', 'กรุณาเลือกรายชื่อ On SLA : level2!', 'Helpdesk System : Messages');
         return false;
     }else if ( $("#pc_lv3").val() != "" && $("#pc_lv3").val() != "0" && $('#user_to_lv3 option').length == 0 && $('#user_cc_lv3 option').length == 0 ){
         jAlert('error', 'กรุณาเลือกรายชื่อ On SLA : level3!', 'Helpdesk System : Messages');
         return false;
     }else if ( $("#pc_over_lv1").val() != "" && $("#pc_over_lv1").val() != "0" && $('#user_to_over_lv1 option').length == 0 && $('#user_cc_over_lv1 option').length == 0 ){
         jAlert('error', 'กรุณาเลือกรายชื่อ Over SLA : level1!', 'Helpdesk System : Messages');
         return false;
     }else if ( $("#pc_over_lv2").val() != "" && $("#pc_over_lv2").val() != "0"  && $('#user_to_over_lv2 option').length == 0 && $('#user_cc_over_lv2 option').length == 0 ){
         jAlert('error', 'กรุณาเลือกรายชื่อ Over SLA : level2!', 'Helpdesk System : Messages');
         return false;
     }else if ( $("#pc_over_lv3").val() != "" && $("#pc_over_lv3").val() != "0"  && $('#user_to_over_lv3 option').length == 0 && $('#user_cc_over_lv3 option').length == 0 ){
         jAlert('error', 'กรุณาเลือกรายชื่อ Over SLA : level3!', 'Helpdesk System : Messages');
         return false;
     }else if ( $("#pc_lv1").val() == "" && $("#pc_lv2").val() == "" && $("#pc_lv3").val() == "" 
            &&  $("#pc_over_lv1").val() == "" && $("#pc_over_lv2").val() == "" && $("#pc_over_lv3").val() == "" 
            &&  $('#user_to_lv1 option').length == 0 && $('#user_cc_lv1 option').length == 0 
            &&  $('#user_to_lv2 option').length == 0 && $('#user_cc_lv2 option').length == 0 
            &&  $('#user_to_lv3 option').length == 0 && $('#user_cc_lv3 option').length == 0 
            &&  $('#user_to_over_lv1 option').length == 0 && $('#user_cc_over_lv1 option').length == 0 
            &&  $('#user_to_over_lv2 option').length == 0 && $('#user_cc_over_lv2 option').length == 0 
            &&  $('#user_to_over_lv3 option').length == 0 && $('#user_cc_over_lv3 option').length == 0 ){
         jAlert('error', 'กรุณาใส่ข้อมูลที่ต้องการบันทึก!', 'Helpdesk System : Messages');
         return false;
     }
     return true;
 }   
 
 
 
 function chkRequire(id){
     id = "#" + id;
     if ($("#assign_comp_id").val() == ""){
         jAlert('error', 'กรุณาเลือก Company!', 'Helpdesk System : Messages');
         return false;
     }else if ($("#assign_org_id").val() == ""){
         jAlert('error', 'กรุณาเลือก Organize!', 'Helpdesk System : Messages');
         return false;
     }else if ( $(id).val() == "" || $(id).val() == "0" ){
         jAlert('error', 'กรุณาใส่เปอร์เซนต์ก่อนเลือกรายชื่อ', 'Helpdesk System : Messages');
         return false;
     }
     return true;
 }   
 
 
 function clearallControl(){
     
     $('input[name=cb_deduct_pending]').attr('checked', false);
 
     $("#pc_lv1").val("");
     $("#user_to_lv1").find('option').remove();
     $("#user_cc_lv1").find('option').remove();
     
     $("#pc_lv2").val("");
     $("#user_to_lv2").find('option').remove();
     $("#user_cc_lv2").find('option').remove();
     
     $("#pc_lv3").val("");
     $("#user_to_lv3").find('option').remove();
     $("#user_cc_lv3").find('option').remove();
     
     $("#pc_over_lv1").val("");
     $("#user_to_over_lv1").find('option').remove();
     $("#user_cc_over_lv1").find('option').remove();
     
     $("#pc_over_lv2").val("");
     $("#user_to_over_lv2").find('option').remove();
     $("#user_cc_over_lv2").find('option').remove();
     
     $("#pc_over_lv3").val("");
     $("#user_to_over_lv3").find('option').remove();
     $("#user_cc_over_lv3").find('option').remove();
     
     $("#message").html("");
 }
 

</script>
<style type="text/css" >
    .pc_green{
        color:#6a4;
    }
    .pc_green input{
        width:50px; 
        color:white; 
        text-align: center;
        font-weight: bold;
        background-color: #6a4;
    }
    
    
    .pc_yellow{
        color: #FACC2E;
    }
    .pc_yellow input{
        width:50px; 
        color:white; 
        text-align: center;
        font-weight: bold;
        background-color: #FACC2E;
    }
    
    
    .pc_orange{
        color: #F36C00;
    }
    .pc_orange input{
        width:50px; 
        color:white; 
        text-align: center;
        font-weight: bold;
        background-color: #F36C00;
    }
    
    
    .pc_red{
        color: #f00;
    }
    .pc_red input{
        width:50px; 
        color:white; 
        text-align: center;
        font-weight: bold;
        background-color: #f00;
    }
    
    
    
   .To{
        width: 40px;
        height: 16px;
        border:#939393 solid thin;
        vertical-align: central;
        font-weight: bold;
        color: whitesmoke;
        font-size: 8.5pt;
        font-family: Tahoma;
        background-color: #939393;
        -moz-border-radius: 5px;
        border-radius: 5px;
        cursor: pointer;
    }
    
    select{
        border: #D5D5D5 solid thin;
        
    }
    
    fieldset{
        border: solid thin #788480;
    }
    
    .select_user{
        resize: none; 
        overflow-y: auto; 
        height: 45px; 
        width: 90%;
        border: #D5D5D5 solid thin;
    }
    
    .del{
        cursor: pointer;
        border: none;
    }
</style>
<br>

<div align="left">
    <table id="tb_adv_left" width="95%" >
        <tr>
            <th align="left" width="20%">Company <span class="required">*</span></th>
            <td align="left" width="27%"><?=$dd_company;?></td>
            <td align="left" width="6%">&nbsp;</td>
            <th align="left" width="20%">Group </th>
            <td align="left" width="27%"><?=$dd_grp;?></td>
        </tr>
        <tr>
            <th align="left" width="20%">Organization <span class="required">*</span></th>
            <td align="left" width="25%"><?=$dd_org;?></td>
            <td align="left" width="10%">&nbsp;</td>
            <th align="left" width="20%">Sub Group </th>
            <td align="left" width="25%"><?=$dd_subgrp;?></td>
        </tr>
    </table>
</div>   
<br>
<label id="message" name="message"></label>
<span id="ajax-panel"></span><br>

<hr>

<div style="height:520px; overflow-y: auto;">    

      <table width="99%">
          <tr>
              <td style="width: 40%;"></td>
              <td style="width: 20%;"></td>
              <td style="width: 40%;"></td>
          </tr>
          <tr>
              <td align="Left"><span class="styleGray">On SLA</span></td>
              <td></td>
              <td align="Left"><span class="styleGray">Over SLA</span></td>
          </tr>
          <tr>
              <!--============================ LEFT SIDE : ON SLA  ======================== -->
              <td><br>
                  <!--================ LEVEL1 ===================== -->
                  <fieldset>
                    <legend> Level 1 </legend>
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="pc_green">
                                <input id="pc_lv1" name="pc_lv1" /><b>  % of remaining</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_to_lv1" name="btn_to_lv1">To ></div>
    
                            </td>
                            <td style="width: 85%">
                                <select name="user_to_lv1" id="user_to_lv1" multiple class="select_user" ></select>
                                <img id="del_to_lv1" name="del_to_lv1" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_cc_lv1" name="btn_cc_lv1">CC ></div>
                                
                            </td>
                            <td style="width: 85%;" valign="central">
                                <select name="user_cc_lv1" id="user_cc_lv1" multiple class="select_user" ></select>
                                <img id="del_cc_lv1" name="del_cc_lv1" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                    </table>
                  </fieldset><br>
                  
                  <!--================ LEVEL2 ===================== -->
                  <fieldset>
                    <legend> Level 2 </legend>
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="pc_yellow">
                                <input id="pc_lv2" name="pc_lv2" /><b>  % of remaining</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_to_lv2" name="btn_to_lv2">To ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_to_lv2" id="user_to_lv2" multiple class="select_user" ></select>
                                <img id="del_to_lv2" name="del_to_lv2" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_cc_lv2" name="btn_cc_lv2">CC ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_cc_lv2" id="user_cc_lv2" multiple class="select_user" ></select>
                                <img id="del_cc_lv2" name="del_cc_lv2" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                    </table>
                  </fieldset><br>
                  
                  
                  <!--================ LEVEL3 ===================== -->
                  <fieldset>
                    <legend> Level 3 </legend>
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="pc_orange">
                                <input id="pc_lv3" name="pc_lv3" /><b>  % of remaining</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_to_lv3" name="btn_to_lv3">To ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_to_lv3" id="user_to_lv3" multiple class="select_user" ></select>
                                <img id="del_to_lv3" name="del_to_lv3" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_cc_lv3" name="btn_cc_lv3">CC ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_cc_lv3" id="user_cc_lv3" multiple class="select_user" ></select>
                                <img id="del_cc_lv3" name="del_cc_lv3" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                    </table>
                  </fieldset>
              </td>
              
              <!--============================ CENTER : ALL USER  ======================== -->
              <td valign="top" align="center">
                  <div style=" text-align: inherit;" hidden>
                      <input id="cb_deduct_pending" name="cb_deduct_pending" type="checkbox" style="width: 5%" />&nbsp;&nbsp;<b>Deduct Pending Status</b><br><br>
                  
                  </div>
                  <select name="lb_user" id="lb_user" multiple style="resize: none; overflow-y: auto; height: 450px; width: 80%;"></select>
              </td>
              
              
              <!--============================ RIGHT SIDE : OVER SLA ======================== -->
              <td><br>
                  <!--================ LEVEL1 ===================== -->
                  <fieldset>
                    <legend> Level 1 </legend>
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="pc_red">
                                <input id="pc_over_lv1" name="pc_over_lv1" /><b>  % of over</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_to_over_lv1" name="btn_to_over_lv1">To ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_to_over_lv1" id="user_to_over_lv1" multiple class="select_user" ></select>
                                <img id="del_to_over_lv1" name="del_to_over_lv1" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_cc_over_lv1" name="btn_cc_over_lv1">CC ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_cc_over_lv1" id="user_cc_over_lv1" multiple class="select_user" ></select>
                                <img id="del_cc_over_lv1" name="del_cc_over_lv1" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                    </table>
                  </fieldset><br>
                  
                  <!--================ LEVEL2 ===================== -->
                  <fieldset>
                    <legend> Level 2 </legend>
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="pc_red">
                                <input id="pc_over_lv2" name="pc_over_lv2" /><b>  % of over</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_to_over_lv2" name="btn_to_over_lv2">To ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_to_over_lv2" id="user_to_over_lv2" multiple class="select_user" ></select>
                                <img id="del_to_over_lv2" name="del_to_over_lv2" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_cc_over_lv2" name="btn_cc_over_lv2">CC ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_cc_over_lv2" id="user_cc_over_lv2" multiple class="select_user" ></select>
                                <img id="del_cc_over_lv2" name="del_cc_over_lv2" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                    </table>
                  </fieldset><br>
                  
                  
                  <!--================ LEVEL3 ===================== -->
                  <fieldset>
                    <legend> Level 3 </legend>
                    <table width="100%">
                        <tr>
                            <td colspan="2" class="pc_red">
                                <input id="pc_over_lv3" name="pc_over_lv3" /><b>  % of over</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_to_over_lv3" name="btn_to_over_lv3">To ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_to_over_lv3" id="user_to_over_lv3" multiple class="select_user" ></select>
                                <img id="del_to_over_lv3" name="del_to_over_lv3" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 15%; vertical-align: top;" >
                                <div class="To" align="center" id="btn_cc_over_lv3" name="btn_cc_over_lv3">CC ></div>
                            </td>
                            <td style="width: 85%">
                                <select name="user_cc_over_lv3" id="user_cc_over_lv3" multiple class="select_user" ></select>
                                <img id="del_cc_over_lv3" name="del_cc_over_lv3" src="../../images/trash.png" class="del" />
                            </td>
                        </tr>
                    </table>
                  </fieldset>
              </td>
          </tr>
          
      </table>
    
    
</div>
    

