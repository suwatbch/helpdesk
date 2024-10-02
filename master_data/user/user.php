<?php
   include_once "user.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_user(){
        if($("#user_code").val() == ""){
            jAlert('error', 'Please input User Code', 'Helpdesk System : Messages');
            $("#user_code").focus();
            return false;   
        }else if($("#employee_code").val() == ""){
            jAlert('error', 'Please input Employee Code', 'Helpdesk System : Messages');
            $("#employee_code").focus();
            return false;   
        }else if($("#first_name").val() == ""){
            jAlert('error', 'Please input First Name', 'Helpdesk System : Messages');
            $("#first_name").focus();
            return false;   
        }else if($("#last_name").val() == ""){
            jAlert('error', 'Please input Last Name', 'Helpdesk System : Messages');
            $("#last_name").focus();
            return false;   
        }else if($("#email").val() == ""){
            jAlert('error', 'Please input Email', 'Helpdesk System : Messages');
            $("#email").focus();
            return false;   
        }else if($("#company_id").val() == ""){
            jAlert('error', 'Please select Company', 'Helpdesk System : Messages');
            $("#company_id").focus();
            return false;   
        }else if($("#org_id").val() == ""){
            jAlert('error', 'Please select Organization', 'Helpdesk System : Messages');
            $("#org_id").focus();
            return false;   
        }else if($("#group_id").val() == ""){
            jAlert('error', 'Please select Group', 'Helpdesk System : Messages');
            $("#group_id").focus();
            return false;   
       }else if($('#subgrp_id > option[value!=""]').length != 0 && $("#subgrp_id").val() == "") {
            jAlert('error', 'Please select Sub Group', 'Helpdesk System : Messages');
            $("#subgrp_id").focus();
            return false;   
        }else{
            validate_de_user();
        }
    }
    function validate_de_user(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=user&user_id=" + $("#user_id").val() + "&user_code=" + $("#user_code").val() + "&employee_code=" + $("#employee_code").val(),
                success: function(respone){
                    //alert(respone);
					
				   page_submit("index.php?action=user.php", "save")
				   
				   /*
                   if(respone == 1){ 
                        jAlert('error', 'User Code Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else if(respone == 2){ 
                        jAlert('error', 'Employee Code Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_submit("index.php?action=user.php", "save")
                   }
				   */	
				   
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/user/index.php?action=user_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            validate_user();
        });

        $("#undo").click(function(){
            page_submit("index.php?action=user.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=user_list.php");
        });
    });
</script>
<script type="text/javascript">
   $(document).ready(function () {   
    
	$("#company_id").change(function(){
           var company_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "../common/dropdown.org.php",
                data: "company_id=" + company_id,
                success: function(respone){
                   // alert(respone);
                    $("#org_id").replaceWith(respone);
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown.grp.php",
                data: "company_id=" + company_id,
                success: function(respone){
                    //alert(respone);
                    document.getElementById("group_id").innerHTML =respone;
                }
            }); 
       });
       
       $("#group_id").change(function(){
           var company_id = $("#company_id").val();
           var group_id = $(this).val();
               
               $.ajax({
                type: "GET",
                url: "../common/dropdown.subgrp.php",
                data: "company_id=" + company_id + '&group_id=' + group_id,
                success: function(respone){
                    //alert(respone);
                    $("#subgrp_id").replaceWith(respone);
                }
            });
       });
    
   });   
    
</script> 
<br>
<table width="80%" border="0" cellpadding="0" cellspacing="3" align="center">
    <tr>
        <td class="tr_header">User Code <span class="required">*</span></td>
        <td><input type="text" id="user_code" name="user_code" style="width: 100%;" value="<?=$user["user_code"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Employee Code <span class="required">*</span></td>
        <td><input type="text" id="employee_code" name="employee_code" style="width: 100%;" value="<?=$user["employee_code"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">First Name <span class="required">*</span></td>
        <td><input type="text" id="first_name" name="first_name" style="width: 100%;" value="<?=$user["first_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Last Name <span class="required">*</span></td>
        <td><input type="text" id="last_name" name="last_name" style="width: 100%;" value="<?=$user["last_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Email <span class="required">*</span></td>
        <td><input type="text" id="email" name="email" style="width: 100%;" value="<?=$user["email"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Company <span class="required">*</span></td>
        <td><?=$dd_company;?><input type="hidden" id="ddassign_comp_id" name="ddassign_comp_id" value="<?=$ddassign_comp_id;?>"/>
            <input type="hidden" id="ss_assign_comp_id" name="ss_assign_comp_id" value="<?=$ddassign_comp_id?>">
        </td>
    </tr>
	<tr>
        <td class="tr_header">Customer Company </td>
        <td><?=$dd_company_cus;?>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Organization <span class="required">*</span></td>
        <td><?=$dd_org;?><input type="hidden" id="ddassign_org_id" name="ddassign_org_id" value="<?=$ddassign_org_id;?>"/>
            <input type="hidden" id="ss_assign_org_id" name="ss_assign_org_id" value="<?=$ddassign_org_id;?>"/>
        </td> 
    </tr>
    <tr>
        <td class="tr_header">Group <span class="required">*</span></td>
        <td><?=$dd_grp;?><input type="hidden" id="ddassign_group_id" name="ddassign_group_id" value="<?=$ddassign_group_id;?>"/>
            <input type="hidden" id="ss_assign_group_id" name="ss_assign_group_id" value="<?=$ddassign_group_id;?>"/>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Sub Group <span class="required">*</span></td>
        <td><?=$dd_subgrp;?><input type="hidden" id="ddassign_subgrp_id" name="ddassign_subgrp_id" value="<?=$ddassign_subgrp_id;?>"/>
            <input type="hidden" id="ss_assign_subgrp_id" name="ss_assign_subgrp_id" value="<?=$ddassign_subgrp_id;?>"/>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Password <span class="required">*</span></td>
        <td><input type="password" id="pass" name="pass" style="width: 100%;" value="<?=$user["pass"]?>"/>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Password Expire</td>
        <td><input type="text" style="width: 100%;" value="<?=$user["pass_expire"]?>" class="disabled" readonly/>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Lock Password</td>
        <td><input type="checkbox" name="pass_count" id="pass_count" value="3" <? if($user["pass_count"]== 3){ echo "checked"; }?>></td>
        </td>
    </tr>
<!--    <tr>
        <td class="tr_header">User Active</td>
        <td><input type="checkbox" name="user_status" id="user_status" value="1" <? if($user["user_status"]== 1){ echo "checked"; }?>></td>
    </tr>-->
    <tr>
        <td class="tr_header">Admin Helpdesk</td>
        <td><input type="checkbox" name="admin_permission" id="admin_permission" value="Y" <? if($user["admin_permission"]== 'Y'){ echo "checked"; }?>></td>
    </tr>
<!--    <tr>
        <td class="tr_header">Create Incident <span class="required">*</span></td>
        <td><input type="checkbox" name="create_incident" id="create_incident" value="1" <? if($user["access_group_id"]== 3 || $user["access_group_id"]== 2 ){ echo "checked"; }?>></td>
    </tr>-->
    <tr>
        <td class="tr_header">Transfer Incident</td>
        <td><input type="checkbox" name="transfer_incident_permission" id="transfer_incident_permission" value="Y" <? if($user["transfer_incident_permission"]== 'Y'){ echo "checked"; }?>></td>
    </tr>
    <tr>
        <td class="tr_header">Edit Report</td>
        <td><input type="checkbox" name="edit_report_permission" id="edit_report_permission" value="Y" <? if($user["edit_report_permission"]== 'Y'){ echo "checked"; }?>></td>
    </tr>
    <tr>
        <td class="tr_header">Approve Report</td>
        <td><input type="checkbox" name="approve_report_permission" id="approve_report_permission" value="Y" <? if($user["approve_report_permission"]== 'Y'){ echo "checked"; }?>></td>
    </tr>
	<tr>
        <td class="tr_header">Advance Search</td>
        <td><input type="checkbox" name="advance_search_permission" id="advance_search_permission" value="Y" <? if($user["advance_search_permission"]== 'Y'){ echo "checked"; }?>></td>
    </tr>
    <tr>
        <td class="tr_header">Create By</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly value="<? if($user['created_by']!=0){echo $user["created_name"];}else{ echo user_session::get_user_name();}?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Create Date</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?if(strUtil::isNotEmpty($user['created_date'])){echo dateUtil::date_dmyhms2($user['created_date']);} else { echo date("m/d/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($user['company_id'])){ ?>
    <tr>
        <td class="tr_header">Modified By</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=$user['modified_name']?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Modified Date</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=dateUtil::date_dmyhms2($user['modified_date'])?>"/></td>
    </tr>
    <? } ?>
</table>
<input type="hidden" name="user_id" id="user_id" value="<? if($copy==1){ echo "";}else { echo $user["user_id"]; }?>"/>
<input type="hidden" name="s_admin" id="s_admin" value="<?=$user["admin"]?>">
<input type="hidden" name="s_password" id="s_password" value="<?=$user["pass"]?>">
<input type="hidden" name="c_user_id" id="c_user_id" value="<? if($copy==1){ echo $user["user_id"];}else { echo ""; }?>"/>
<input type="hidden" name="s_pass_count" id="s_pass_count" value="<?=$user["pass_count"]?>">