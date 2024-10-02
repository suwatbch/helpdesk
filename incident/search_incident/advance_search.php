<?php
    unset($_SESSION["advance_search"] );
    
    include_once "../../include/config.inc.php";
    //include_once "../../include/template/index_report.tpl.php";
    include_once 'advance_search.action.php';
?>

<link type="text/css" rel="stylesheet" href="<?=$application_path_include?>/css/cctstyles.css"/> 
<!--<script type="text/javascript" src="../../include/js/function.js"></script>-->
<!--<script type="text/javascript" src="../../include/js/jquery/jquery-1.5.1.js"></script>-->
<style type="text/css">
  .ui-autocomplete { overflow-y: scroll; }
  * html .ui-autocomplete { /* IE max- */height: expression( this.scrollHeight > 200 ? "200px" : "auto" ); }
  .ui-autocomplete { max-height: 200px; }
</style>
<style type="text/css">
    select{
        
        padding: 0px;
        margin: 0px;
        border: 1px solid #B9BCBD;
        font-size: 11px;
        font-family: Verdana,Arial,Helvetica,sans-serif;
        width: 100%;
    }
    
    
</style>
<script type="text/javascript">
 
    
    $(function(){
        $("img#search").click(function(){
//            alert($("#owner").val());

            if (chkValidate()){
                 page_submit("../search_incident/index.php?action=result_list.php", "search_adv");
            }
        });
        
        $("img#cancel").click(function(){
                page_submit("../main_incident/index.php?mode=1");
        });
		
            //In active on change status_id
            $("#status_id").change(function(){
            var status_id = $(this).val();
			//alert(status_id);
            $.ajax({
                type: "GET",
                url: "dropdown.status_res.php",
                data: "status_id=" + status_id + "&attr=style=\"width: 100%;\"",
                success: function(respone){
                    $("#status_res_id").replaceWith(respone);
                }
            });
        });
		
            //In active on change impact_id
            $("#impact_id").change(function(){
            var impact_id = $(this).val();
            var urgency_id = $("#urgency_id").val();
			//alert(urgency_id);
            
			$.ajax({
                type: "GET",
                url: "dropdown.priority.php",
                data: "impact_id=" + impact_id + "&urgency_id="+ urgency_id +"&attr=style=\"width: 100%;\" class=\"select_dis\" disabled",
                success: function(respone){
                    $("#priority_id").replaceWith(respone);
                    var v_priority_id = $("#priority_id").val();
                        $("#ddpriority_id").val(v_priority_id);
                }
            });
        });
		
            //In active on change urgency_id
            $("#urgency_id").change(function(){
            var urgency_id = $(this).val();
            var impact_id = $("#impact_id").val();
            
			$.ajax({
                type: "GET",
                url: "dropdown.priority.php",
                data: "impact_id=" + impact_id + "&urgency_id="+ urgency_id +"&attr=style=\"width: 100%;\" class=\"select_dis\" disabled",
                success: function(respone){
                    $("#priority_id").replaceWith(respone);
                    var v_priority_id = $("#priority_id").val();
			$("#ddpriority_id").val(v_priority_id);
                }
            });
        });
		
            //In active on change cas_opr_tier_id1
            $("#cas_opr_tier_id1").change(function(){
            var cas_opr_tier_id1 = $(this).val();
            
			$.ajax({
                            type: "GET",
                            url: "dropdown.opr_tier2.php",
                            data: "cas_opr_tier_id1=" + cas_opr_tier_id1 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("cas_opr_tier_id2").innerHTML =respone;
                            }
                        });
			
            var cas_opr_tier_id2 = $(this).val();
            var cas_opr_tier_id1 = $("#cas_opr_tier_id1").val();
            
			$.ajax({
                            type: "GET",
                            url: "dropdown.opr_tier3.php",
                            data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("cas_opr_tier_id3").innerHTML =respone;
                            }
                        });
            });
		
            //In active on change cas_opr_tier_id2
            $("#cas_opr_tier_id2").change(function(){
            var cas_opr_tier_id2 = $(this).val();
            var cas_opr_tier_id1 = $("#cas_opr_tier_id1").val();
            
			$.ajax({
                            type: "GET",
                            url: "dropdown.opr_tier3.php",
                            data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("cas_opr_tier_id3").innerHTML =respone;
                            }
                        });
            });
		
                
            //In active on change cas_prd_tier_id1
            $("#cas_prd_tier_id1").change(function(){
            var cas_prd_tier_id1 = $(this).val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.prd_tier2.php",
                            data: "cas_prd_tier_id1=" + cas_prd_tier_id1 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("cas_prd_tier_id2").innerHTML =respone;
                            }
                        });
            
            var cas_prd_tier_id2 = $(this).val();
            var cas_prd_tier_id1 = $("#cas_prd_tier_id1").val();
            
			$.ajax({
                            type: "GET",
                            url: "dropdown.prd_tier3.php",
                            data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cas_prd_tier_id2=" + cas_prd_tier_id2 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("cas_prd_tier_id3").innerHTML =respone;
                            }
                        });
			
            });
		
            //In active on change cas_prd_tier_id2
            $("#cas_prd_tier_id2").change(function(){
            var cas_prd_tier_id2 = $(this).val();
            var cas_prd_tier_id1 = $("#cas_prd_tier_id1").val();
            
			$.ajax({
                            type: "GET",
                            url: "dropdown.prd_tier3.php",
                            data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cas_prd_tier_id2=" + cas_prd_tier_id2 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("cas_prd_tier_id3").innerHTML =respone;
                            }
                        });
            });
		
		
            //In active on change resol_oprtier1
            $("#resol_oprtier1").change(function(){
            var resol_oprtier1 = $(this).val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.opr_tier2_resol.php",
                            data: "resol_oprtier1=" + resol_oprtier1 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("resol_oprtier2").innerHTML =respone;
                            }
                        });
                        
            var resol_oprtier2 = $(this).val();
            var resol_oprtier1 = $("#resol_oprtier1").val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.opr_tier3_resol.php",
                            data: "resol_oprtier1=" + resol_oprtier1 + "&resol_oprtier2=" + resol_oprtier2 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("resol_oprtier3").innerHTML =respone;
                            }
                        });
            });
            
		
            //In active on change resol_oprtier2
            $("#resol_oprtier2").change(function(){
            var resol_oprtier2 = $(this).val();
            var resol_oprtier1 = $("#resol_oprtier1").val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.opr_tier3_resol.php",
                            data: "resol_oprtier1=" + resol_oprtier1 + "&resol_oprtier2=" + resol_oprtier2 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("resol_oprtier3").innerHTML =respone;
                            }
                        });
            });
		
		
            //In active on change resol_prdtier1
            $("#resol_prdtier1").change(function(){
            var resol_prdtier1 = $(this).val();
            
			$.ajax({
                            type: "GET",
                            url: "dropdown.prd_tier2_resol.php",
                            data: "resol_prdtier1=" + resol_prdtier1 +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("resol_prdtier2").innerHTML =respone;
                            }
                        });
                        
            var resol_prdtier2 = $(this).val();
            var resol_prdtier1 = $("#resol_prdtier1").val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.prd_tier3_resol.php",
                            data: "resol_prdtier1=" + resol_prdtier1 + "&resol_prdtier2=" + resol_prdtier2 + "&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("resol_prdtier3").innerHTML =respone;
                            }
                        });
            });
            
		
            //In active on change resol_prdtier2
            $("#resol_prdtier2").change(function(){
            var resol_prdtier2 = $(this).val();
            var resol_prdtier1 = $("#resol_prdtier1").val();
                       
			$.ajax({
                            type: "GET",
                            url: "dropdown.prd_tier3_resol.php",
                            data: "resol_prdtier1=" + resol_prdtier1 + "&resol_prdtier2=" + resol_prdtier2 + "&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("resol_prdtier3").innerHTML =respone;
                            }
                        });
            });
		
                
            //In active on change assign_comp_id
            $("#assign_comp_id").change(function(){
            var assign_comp_id = $(this).val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.org_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("assign_org_id").innerHTML =respone;
                                //===============================================
                                $("#ddassign_comp_id").val($("#assign_comp_id").val());
                                //===============================================
                                $("#ddassign_org_id").val($("#assign_org_id").val());
                            }
                        });
                        
            //====In active on change assign_org_id
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
                            }
                        });
                        
            //====In active on change assign_group_id
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
                        
            //====In active on change assign_subgrp_id
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.assingee_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_subgrp_id=" + assign_subgrp_id +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("assign_assignee_id").innerHTML =respone;
                                //===============================================
                                $("#ddassign_subgrp_id").val($("#assign_subgrp_id").val());      
                            }
                        });
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
                            success: function(respone){
                                document.getElementById("assign_subgrp_id").innerHTML =respone;
                                //===============================================
                                $("#ddassign_group_id").val($("#assign_group_id").val());   
                            }
                        });
                        
                        
            //====In active on change assign_subgrp_id
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.assingee_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_subgrp_id=" + assign_subgrp_id +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("assign_assignee_id").innerHTML =respone;
                                //===============================================
                                $("#ddassign_subgrp_id").val($("#assign_subgrp_id").val());      
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
                        
            //====In active on change assign_subgrp_id
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
                       
			$.ajax({
                            type: "GET",
                            url: "dropdown.assingee_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_subgrp_id=" + assign_subgrp_id +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("assign_assignee_id").innerHTML =respone;
                                //===============================================
                                $("#ddassign_subgrp_id").val($("#assign_subgrp_id").val());      
                            }
                        });
            });
		
            //In active on change assign_subgrp_id
            $("#assign_subgrp_id").change(function(){
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
                        
			$.ajax({
                            type: "GET",
                            url: "dropdown.assingee_user.php",
                            data: "assign_comp_id=" + assign_comp_id +"&assign_subgrp_id=" + assign_subgrp_id +"&attr=style=\"width: 100%;\"",
                            success: function(respone){
                                document.getElementById("assign_assignee_id").innerHTML =respone;
                                //===============================================
                                $("#ddassign_subgrp_id").val($("#assign_subgrp_id").val());      
                            }
                        });
            });
	
        
});


function chkValidate(){

    if ($("#l_txt_ref").val() != "" && $("#txt_ref").val() == ""){
        jAlert('error', 'Please input Reference No. from !!', 'Helpdesk System : Messages');
        return false;
    }else if ($("#l_txt_ref").val() < $("#txt_ref").val() && $("#l_txt_ref").val() != ""){
        jAlert('error', 'Invalid Reference No. !!', 'Helpdesk System : Messages');
        return false;
    }
    
    return true;
}
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#owner").autocomplete({
            source: '../search_incident/get_user.php',
            minLength:1
        });

        $("#resolve").autocomplete({
            source: '../search_incident/get_user.php',
            minLength:1
        });
    });
</script>

    <br>
   
    <div id="divLeft" align="center">
        <table id="tb_adv_left" width="90%">
            <tr>
                <td colspan="6" align="left">
                    <span class="styleBlue">INCIDENT</span><span class="styleGray"> REQUEST INFORMATION</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">Incident ID</th>
                <td colspan="3" align="left"><input id="txt_ident_id" name="txt_ident_id" type="text" /></td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">Status</th>
                <td colspan="3" align="left">
                    <select id="status_id" name="status_id">
                        <option value="0" selected></option>
                        <option value="1,2,3,4,5,6">Not Closed</option>
                        <option value="1">New</option>
                        <option value="2">Assigned</option>
                        <option value="3">Working</option>
                        <option value="4">Pending</option>
                        <option value="5">Resolved</option>
                        <option value="6">Propose Close</option>
                        <option value="7">Closed</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">Summarize</th>
                <td colspan="3" align="left"><input id="txt_summary" name="txt_summary" type="text" /></td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left" valign="bottom">Detail</th>
                <td colspan="3" align="left"><textarea id="txt_notes" name="txt_notes" type="text"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <th align="left">Reference No.</th>
                <td align="right">From</td>
                <td align="left"><input id="txt_ref" name="txt_ref" type="text" /></td>
                <td>To</td>
                <td align="left"><input id="l_txt_ref" name="l_txt_ref" type="text" /></td>
            </tr>
            <tr>
                <td colspan="6" align="left"><br><br>
                    <span class="styleBlue">DATE</span><span class="styleGray"> INFORMATION</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <th align="left">Created Date</th>
                <td align="right">From</td>
                <td align="left">
                    <span width="100%" type="calendar" name="created_date" id="created_date" value="" img="../../images/calendar.png" />
                </td>
                <td>To</td>
                <td align="left">
                    <span type="calendar" name="l_created_date" id="l_created_date" value="" img="../../images/calendar.png"></span>
                </td>
            </tr>
            <tr>
                <td></td>
                <th align="left">Assigned Date</th>
                <td align="right">From</td>
                <td align="left"><span type="calendar" name="assigned_date" id="assigned_date" value="" img="../../images/calendar.png"></span></td>
                <td>To</td>
                <td align="left"><span type="calendar" name="l_assigned_date" id="l_assigned_date" value="" img="../../images/calendar.png"></span></td>
            </tr>
            <tr>
                <td></td>
                <th align="left">Working Date</th>
                <td align="right">From</td>
                <td align="left"><span type="calendar" name="working_date" id="working_date" value="" img="../../images/calendar.png"></span></td>
                <td>To</td>
                <td align="left"><span type="calendar" name="l_working_date" id="l_working_date" value="" img="../../images/calendar.png"></span></td>
            </tr>
            <tr>
                <td></td>
                <th align="left">Resolved Date</th>
                <td align="right">From</td>
                <td align="left"><span type="calendar" name="resolved_date" id="resolved_date" value="" img="../../images/calendar.png"></span></td>
                <td>To</td>
                <td align="left"><span type="calendar" name="l_resolved_date" id="l_resolved_date" value="" img="../../images/calendar.png"></span></td>
            </tr>
            <tr>
                <td></td>
                <th align="left">Closed Date</th>
                <td align="right">From</td>
                <td align="left"><span type="calendar" name="closed_date" id="closed_date" value="" img="../../images/calendar.png"></span></td>
                <td>To</td>
                <td align="left"><span type="calendar" name="l_closed_date" id="l_closed_date" value="" img="../../images/calendar.png"></span></td>
            </tr>
	    <!-- Visible 19/07/2022 	
            <tr>
                <td colspan="6" align="left"><br><br>
                    <span class="styleBlue">PRODUCT </span><span class="styleGray">CATAGORIZATION</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Class 1</th>
                <td colspan="3" align="left"><?=$dd_prd_tier1?></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Class 2</th>
                <td colspan="3" align="left"><?=$dd_prd_tier2?></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Class 3</th>
                <td colspan="3" align="left"><?=$dd_prd_tier3?></td>
            </tr>
	    -->
            <tr>
                <td width="5%">&nbsp;</td>
                <td width="35%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
            </tr> 
                
        </table>

    </div>
    

    <div id="divRight" align="center">
        <table id="tb_adv_left" width="90%">
          <tr>
                <td colspan="6" align="left">
                    <span class="styleBlue">CUSTOMER</span><span class="styleGray"> INFORMATION</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">Customer ID</th>
                <td colspan="3" align="left"><input id="cus_id" name="cus_id" type="text" /></td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">Firstname</th>
                <td colspan="3" align="left"><input id="cus_firstname" name="cus_firstname" type="text" /></td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">Lastname</th>
                <td colspan="3" align="left"><input id="cus_lastname" name="cus_lastname" type="text" /></td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">Phone Number</th>
                <td colspan="3" align="left"><input id="cus_phone" name="cus_phone" type="text" /></td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">E-mail</th>
                <td colspan="3" align="left"><input id="cus_email" name="cus_email" type="text" /></td>
            </tr>
            <tr>
                <td colspan="6" align="left"><br><br>
                    <span class="styleBlue">PERSONAL</span><span class="styleGray"> INFORMATION</span>
                </td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Company</th>
                <td colspan="3" align="left"><?=$dd_company;?></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Organization</th>
                <td colspan="3" align="left"><?=$dd_org;?></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Group</th>
                <td colspan="3" align="left"><?=$dd_grp;?></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Sub Group</th>
                <td colspan="3" align="left"><?=$dd_subgrp;?></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Assignee</th>
                <td colspan="3" align="left"><?=$dd_assign_assignee;?></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Owner</th>
                <td colspan="3"><input type="text" name="owner" id="owner" maxlength="20"/></td>
            </tr>
            <tr>
                <td></td>
                <th align="left" colspan="2">Resolve by</th>
                <td colspan="3"><input type="text" name="resolve" id="resolve" maxlength="20"/></td>
            </tr>
            <tr>
                <td></td>
                <th colspan="2" align="left">hits(Records)</th>
                <td colspan="3" align="left"><input id="txtRecords" name="txtRecords" type="text" disabled value="100" /></td>
            </tr>
            <tr>
                <td colspan="6"><br>
                    <div width="95%" style="background-color: #C0D9EA;" align="center">
                        <br><br>
                        <img id="search" src="<?=$application_path_images?>/search.gif" style="cursor: pointer;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <img id="cancel" src="<?=$application_path_images?>/btn_cancel.png" style="cursor: pointer;">
                        <br><br>
                    </div> 
                </td>
            </tr>
            <tr>
                <td width="5%">&nbsp;</td>
                <td width="35%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
                <td width="5%">&nbsp;</td>
                <td width="25%">&nbsp;</td>
            </tr>
            </table>
        
         
    </div>
    
  
