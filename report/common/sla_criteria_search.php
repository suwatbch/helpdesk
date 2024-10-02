<?php

include_once 'sla_criteria_search.action.php';

?>

<style type="text/css">
  .ui-autocomplete { overflow-y: scroll; }
  * html .ui-autocomplete { /* IE max- */height: expression( this.scrollHeight > 200 ? "200px" : "auto" ); }
  .ui-autocomplete { max-height: 200px; }
</style>


<link type="text/css" rel="stylesheet" href="<?=$application_path_include?>/css/cctstyles.css"/>
<script type="text/javascript">
    $(function(){
        $("img#search").click(function(e){
            if (validate()){
               
                var arr = null;
                var d1 = $("#inc_date").val();
                var d2 = $("#l_inc_date").val();
                		
                if (d1 == ""){
                    jAlert('error', 'Please select start date!', 'Helpdesk System : Messages');
                    return false;
                } 
                
                if (d2 == ""){
                    jAlert('error', 'Please select end date!', 'Helpdesk System : Messages');
                    return false;
                } 
                
                arr = d1.split("-");
                d1 = arr[2] + "" + arr[1] + "" + arr[0];

                arr = d2.split("-");
                d2 = arr[2] + "" + arr[1] + "" + arr[0];

                if (d2 < d1) {
                    jAlert('error', 'Incident date to is greater than Incident date from!', 'Helpdesk System : Messages');
                    return false;
                }
                if($("#status_id").val() > $("#status_id_l").val() && $("#status_id_l").val()!=""){
                    jAlert('error', 'Status to is greater than Status from', 'Helpdesk System : Messages');
                    return false;
                }
                if($("#status_id").val()=="" && $("#status_id_l").val()!=""){
                    jAlert('error', 'Please select Status from', 'Helpdesk System : Messages');
                    return false;
                }

                if($("#ident_type_id").val() > $("#ident_type_id_l").val() && $("#ident_type_id_l").val()!= ""){
                    jAlert('error', 'Incident Type to is greater than Incident Type from ', 'Helpdesk System : Messages');
                    return false;
                }
                if($("#ident_type_id").val()=="" && $("#ident_type_id_l").val()!=""){
                    jAlert('error', 'Please select Incident Type from', 'Helpdesk System : Messages');
                    return false;
                }

                if($("#reference_from").val() > $("#reference_to").val()){
                    jAlert('error', 'Reference to is greater than Reference from', 'Helpdesk System : Messages');
                    return false;
                }
			
                        
                var show_to_customer = "N" ;       
                var page = $("#result_page").val();
                var comp = $("#cus_company_id").val();
                var project = $("#project_id").val();
                var ident_type_id = $("#ident_type_id").val();
                var ident_type_id_l = $("#ident_type_id_l").val();
                var status = $("#status_id").val();
                var status_l = $("#status_id_l").val();
                var priority = $("#priority_id").val();
                var priority_l = $("#priority_id_l").val();
                var reference_from =$("#reference_from").val();
                var reference_to =$("#reference_to").val();
                var s_respond = $("#s_respond").val();
                var rsp_group = $("#rsp_group_id").val();
                var rsp_subgroup = $("#rsp_subgrp_id").val();
                var s_resolved = ""; var rsv_group = ""; var rsv_subgroup = ""; var s_owner = "";// summary report : only user input
                if($("#show_to_customer").is(':checked')){
                    show_to_customer = "Y";
                }
//                var prd_tier_id1 = $("#prd_tier_id1").val();
//                var prd_tier_id2 = $("#prd_tier_id2").val();
//                var prd_tier_id3 = $("#prd_tier_id3").val();

                if ($("#hd_sla").val() != "s"){
                    
                    s_resolved = $("#s_resolved").val();
                    rsv_group = $("#rsv_group_id").val();
                    rsv_subgroup = $("#rsv_subgrp_id").val();
                    s_owner = $("#s_owner").val(); 
                    
                }
           
                

                var url = page + '?c=' + comp + '&d1=' + d1 + '&d2=' + d2
                        + '&pj=' + project + '&t1=' + ident_type_id + '&t2=' + ident_type_id_l
                    + '&s1=' + status + '&s2=' + status_l + '&p1=' + priority + '&p2=' + priority_l
//                    + '&c1=' + prd_tier_id1 + '&c2=' + prd_tier_id2 + '&c3=' + prd_tier_id3
                    + '&pg=' + rsp_group + '&psg=' + rsp_subgroup + '&vg=' + rsv_group + '&vsg=' + rsv_subgroup 
                    + '&rp=' + s_respond + '&rs=' + s_resolved + '&o=' + s_owner
                    + '&ref1=' + reference_from + '&ref2=' + reference_to + '&show_to_customer='+ show_to_customer;
                
//               var url = page + "&p=" + JSON.stringify(param);
               window.open(url,'_blank,_top');
           }
           
                
            
           
                
        });
        
        
        $("img#cancel").click(function(){
           page_submit("../../incident/main_incident/index.php?mode=1")
        });
     
     
     
    
     
       
    
    });
    
    $(document).ready(function () {   
//        get_dropdown_group();
    
	$("#cus_company_id").change(function(){
            
           var report = $("#hd_report").val();
           var cus_company_id = $(this).val();

            get_dropdown_ident_type(); 
            get_dropdown_project();
//            get_dropdown_prd_tier1();
            
        });
        
        
        
        $("#rsp_group_id").change(function(){
        var company_id = $("#user_company_id").val();
        var group_id = $(this).val();
        $.ajax({
                type: "GET",
                url: "../common/dropdown.subgrp_user.php",
                data: "assign_comp_id=" + company_id +"&assign_group_id=" + group_id + "&name=rsp_subgrp_id&attr=style=\"width: 100%;\" ",
                success: function(response){
                    $("#rsp_subgrp_id").replaceWith(response);    
                }
            });
        });
        
        $("#rsv_group_id").change(function(){
        var company_id = $("#user_company_id").val();
        var group_id = $(this).val();
        $.ajax({
                type: "GET",
                url: "../common/dropdown.subgrp_user.php",
                data: "assign_comp_id=" + company_id +"&assign_group_id=" + group_id + "&name=rsv_subgrp_id&attr=style=\"width: 100%;\" ",
                success: function(response){
                    $("#rsv_subgrp_id").replaceWith(response);    
                }
            });
        });
    
    
    
 });   
 
 
 
function chkvalidate(){
    if ($("#cus_company_id").val == ""){
        jAlert('error', 'Please select customer company!', 'Helpdesk System : Messages');
        return false;
    }else if ($("#project_id") == ""){
        jAlert('error', 'Please select project!', 'Helpdesk System : Messages');
        return false;
    }
        return true;
    

} 



function get_dropdown_project(){
//    alert('project');
        var cus_company_id = $("#cus_company_id").val();
		$.ajax({
                type: "GET",
                url: "../common/dropdown.project.php",
                data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
                success: function(response){
                    $("#project_id").replaceWith(response);    
                }
            });
}


function get_dropdown_prd_tier1(){
//    alert('prd_tier');
        var cus_company_id = $("#cus_company_id").val();
		$.ajax({
                type: "GET",
                url: "../common/dropdown.prd_tier1.php",
                data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
                success: function(respone){
                        document.getElementById("prd_tier_id1").innerHTML =respone;  
                }
            });
			
            //Chagng Dropdown cas_prd_tier_id2  
            var cas_prd_tier_id1 = "";
            var cus_company_id = "";
			$.ajax({
                type: "GET",
                url: "../common/dropdown.prd_tier2.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
                success: function(respone){
					//alert(respone);
                    //$("#cas_prd_tier_id2").replaceWith(respone);
					document.getElementById("prd_tier_id2").innerHTML =respone;
                }
            });
            
            //Chagng Dropdown cas_prd_tier_id3  
            var cas_prd_tier_id1 = "";
            var cas_prd_tier_id2 = "";
            var cus_company_id = "";
			$.ajax({
                type: "GET",
                url: "../common/dropdown.prd_tier3.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "$cas_prd_tier_id2=" + cas_prd_tier_id2 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
                success: function(respone){

					document.getElementById("prd_tier_id3").innerHTML =respone;
                }
            });
			
}


function get_dropdown_ident_type(){
//    alert('ident_type');
        var cus_company_id = $("#cus_company_id").val();
        //alert(cus_company_id);
		$.ajax({
                type: "GET",
                url: "../common/dropdown.incident_type.php",
                data: "cus_company_id=" + cus_company_id + "&id=ident_type_id" ,
                success: function(response){
                    $("#ident_type_id").replaceWith(response);   
                    

                }
            });
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown.incident_type.php",
                data: "cus_company_id=" + cus_company_id + "&id=ident_type_id_l" ,
                success: function(response){
                    $("#ident_type_id_l").replaceWith(response);

                }
            });
}


</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#s_owner").autocomplete({
            source: '../common/get_owner.php',
            minLength:1
        });

        $("#s_resolved").autocomplete({
            source: '../common/get_owner.php',
            minLength:1
        });
        
        $("#s_respond").autocomplete({
            source: '../common/get_owner.php',
            minLength:1
        });

        
    });
</script>
<input type="hidden" name="hd_sla" id="hd_sla" value="<?=$sla;?>" />
<input type="hidden" name="user_company_id" id="user_company_id" value="<?= user_session::get_user_company_id();?>" />
<!--<div width="100%">-->
       <table id="tb_adv_left" width="98%" border="0">
        
        
        <tr>
            <td></td>
            <th align="left">Company Code/รหัสบริษัท <span class="required">*</span></th>
            <td align="left" colspan="3"><?=$dd_company;?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Project/โครงการ <span class="required">*</span></th>
            <td align="left" colspan="3"><?=$dd_project;?></td>
            <td></td>
        </tr>
        <tr>
                <td></td>
                <th align="left">Incident Type</th>
                <td align="left"><?=$dd_incident_type;?></td>
                <td align="center">To</td>
                <td><?=$dd_incident_type_l;?></td>
                <td></td>
        </tr>
        
        <tr>
            <td></td>
            <th align="left">Incident Date/วันที่ <span class="required">*</span></th>
            <td align="left"><span required type="calendar" name="inc_date" id="inc_date" value="" img="../../images/calendar.png"></span></td>
            <td align="center">To</td>
            <td align="left"><span required type="calendar" name="l_inc_date" id="l_inc_date" img="../../images/calendar.png" ></span></td>
            
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Status/สถานะ</th>
            <td align="left"><?=$dd_status;?></td>
            <td align="center">To</td>
            <td><?=$dd_status_l;?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Priority</th>
            <td align="left"><?=$dd_priority;?></td>
            <td align="center">To</td>
            <td><?=$dd_priority_l;?></td>
            <td></td>
        </tr>
        
<?
            if ($sla == "s"){ // use responded object
                ?>
       <tr>
            <td></td>
            <th align="left" >Responsibility Person</th>
            <td colspan="3"><input type="text" id="s_respond" name="s_respond" style="width: 460px;"></td>
            <td></td>
        </tr> 
        <tr>
            <td></td>
            <th align="left">Group</th>
            <td align="left" colspan="3"><?=$dd_grp_rsp;?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Sub Group</th>
            <td align="left" colspan="3"><?=$dd_subgrp_rsp;?></td>
            <td></td>
        </tr>             
              <?
            }else{
                ?>
        <tr>
            <td></td>
            <th align="left" >Responded By</th>
            <td colspan="3"><input type="text" id="s_respond" name="s_respond" style="width: 460px;"></td>
            <td></td>
        </tr> 
        <tr>
            <td></td>
            <th align="left">Responded Group</th>
            <td align="left" colspan="3"><?=$dd_grp_rsp;?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Responded Sub Group</th>
            <td align="left" colspan="3"><?=$dd_subgrp_rsp;?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left" >Resolved By</th>
            <td colspan="3"><input type="text" id="s_resolved" name="s_resolved" style="width: 460px;"></td>
            <td></td>
        </tr> 
        <tr>
            <td></td>
            <th align="left">Resolved Group</th>
            <td align="left" colspan="3"><?=$dd_grp_rsv;?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left">Resolved Sub Group</th>
            <td align="left" colspan="3"><?=$dd_subgrp_rsv;?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <th align="left" >Owner</th>
            <td colspan="3"><input type="text" id="s_owner" name="s_owner" style="width: 460px;"></td>
            <td></td>
        </tr>
            <?
            }
        ?>
        
        <tr>
            <td></td>
            <th align="left" >Reference No.</th>
            <td ><input type="text" id="reference_from" name="reference_from" style="width:100%;"></td>
            <td align="center">To</td>
            <td ><input type="text" id="reference_to" name="reference_to" style="width:100%;"></td>
            <td></td>
        </tr>
    
        <tr>
                <td></td>
                <th align="left">Report to customer</th>
                <td align="left"><input type="checkbox" id="show_to_customer" name="show_to_customer" value="Y" style="margin: 0px 0px;width: 19px;" /></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        
        <tr>
                <td colspan="6" ><br><br><br><br><br>
                    <div width="100%" style="background-color: #C0D9EA;" align="center">
                        <br><br>
                        <img id="search" name="search" src="<?=$application_path_images?>/search.gif" style="cursor: pointer;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img id="cancel" name="cancel" src="<?=$application_path_images?>/btn_cancel.png" style="cursor: pointer;">
                        <br><br>
                    </div> 
                </td>
                
            </tr>
        <tr>
            <td width="15%"></td>
            <td width="30%"></td>
            <td width="15%"></td>
            <td width="10%"></td>
            <td width="15%"></td>
            <td width="15%"></td>
        </tr>
    </table>
    