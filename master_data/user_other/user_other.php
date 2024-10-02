<?php
   include_once "user_other.action.php";
   include_once "../../include/function.php";
   include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript">
    function validate_user_other(){
        if($("#company_id").val() == ""){
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
            validate_detail();
        }
    }
    
    function validate_detail(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=user_specorg&company_id=" + $("#company_id").val() + "&org_id=" + $("#subgrp_id").val() 
                    + "&user_id=" + $("#user_id").val() + "&specorg_id=" + $("#specorg_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'User Other Group Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                    }else{
                       $("#company_dialog").val($("#company_id").val());
                       $("#subgrp_dialog").val($("#subgrp_id").val());
                       page_submit("index.php?action=user_other.php&action_add_user_other=1", "save")
                    }
                }
            });
           
    }
   
    $(function(){
        $("#btn_add_user_other").click(function(){
            jQuery('#dialog1').dialog('open'); return false;
        });
        
        jQuery(document).ready(function() {
            $([1, 2, 3, 4]).each(function() {
                var id= this;
                jQuery('#dialog' + id).dialog({
                    bgiframe: true, autoOpen: false, height: 200,width: 600, modal: true
                });
            });
        });

        $("#btn_cancel").click(function(){
            jQuery('#dialog1').dialog('close'); return false;
        });
        
        $("img[alt=Modify]").click(function(){
         var data_object = $(this).attr("value");
            var arr_object = data_object.split('|');
            $("#s_com_id").val(arr_object['0']);
            $("#s_org_id").val(arr_object['1']);
            $("#s_grp_id").val(arr_object['2']);
            $("#s_subgrp_id").val(arr_object['3']);
            $("#specorg_id").val(arr_object['4']);
            jQuery('#dialog1').dialog('open');
            check_detail();
          });
          
            
        
          
    });
    
      $(function(){
        $("img[alt=delete]").live('click', function() {
          $("#specorg_id").val($(this).attr("value"));
          page_delete('index.php?action=user_other.php&specorg_id=' + $("#specorg_id").val() + '&user_id=' + $("#user_id").val(),'delete');
          
        });
        
        $("#cancel").click(function(){
            page_submit("index.php?action=user_other_list.php");
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
<script type="text/javascript">
        function check_detail(){
            if($("#s_com_id").val()!=""){
                var company_id = $("#s_com_id").val();
                
                $.ajax({ 
                    type: "GET",
                    url: "../common/dropdown.com.php",
                    data: "s_com_id=" + company_id,
                    success: function(respone){
                        //alert(respone);
                        document.getElementById("company_id").innerHTML =respone;
                    }
                });
                
                var s_org_id = $("#s_org_id").val();
                $.ajax({
                    type: "GET",
                    url: "../common/dropdown.org.php",
                    data: "company_id=" + company_id +"&s_org_id=" + s_org_id,
                    success: function(respone){
                       // alert(respone);
                        document.getElementById("org_id").innerHTML =respone;
                    }
                }); 
                
                var s_grp_id = $("#s_grp_id").val();
                $.ajax({
                    type: "GET",
                    url: "../common/dropdown.grp.php",
                    data: "company_id=" + company_id + "&s_grp_id=" + s_grp_id,
                    success: function(respone){
                        //alert(respone);
                        document.getElementById("group_id").innerHTML =respone;
                    }
                }); 
                var s_subgrp_id = $("#s_subgrp_id").val();
                $.ajax({
                    type: "GET",
                    url: "../common/dropdown.subgrp.php",
                    data: "company_id=" + company_id + "&group_id=" + s_grp_id + "&s_subgrp_id=" + s_subgrp_id,
                    success: function(respone){
                        //alert(respone);
                        document.getElementById("subgrp_id").innerHTML =respone;
                    }
                }); 
            
            }
        }
</script>
<br>
<table width="80%" border="0" cellpadding="0" cellspacing="3" align="center">
    <tr>
        <td class="tr_header">User Code</td>
        <td><input type="text" style="width: 95%" class="disabled" readonly value="<?=$user["user_code"]?>"/></td>
        <td class="tr_header">Employee Code</td>
        <td><input type="text" style="width: 95%" class="disabled" readonly value="<?=$user["employee_code"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">First Name</td>
        <td><input type="text" style="width: 95%" class="disabled" readonly value="<?=$user["first_name"]?>"/></td>
        <td class="tr_header">Last Name</td>
        <td><input type="text" style="width: 95%" class="disabled" readonly value="<?=$user["last_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Company</td>
        <td><input type="text" style="width: 95%" class="disabled" readonly value="<?=$user["company_name"]?>"></td>
        <td class="tr_header">Organization</td>
        <td><input type="text" style="width: 95%" class="disabled" readonly value="<?=$user["organization_name"]?>"></td> 
    </tr>
    <tr>
        <td class="tr_header">Group</td>
        <td><input type="text" style="width: 95%" class="disabled" readonly value="<?=$user["group_name"]?>"></td>
        <td class="tr_header">Sub Group</td>
        <td><input type="text" style="width: 95%" class="disabled" readonly value="<?=$user["subgroup_name"]?>"></td>
    </tr>
</table>
<br>
<!--<input type="button" id="btn_add_user_other" value="Add User Other" class="input-button"  style=" width: 100px; height: 20px;" style="cursor: pointer;"/>-->
<br>
<span class='styleBlue_master2'>User Other List</span><br>

<div class="full_width" style=" overflow:  auto; height: 400px;">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    <thead>
        <tr>
            <!--<th width="5%"></th>-->
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">Company</span></th>
            <th><span class="Head">Organization</span></th>
            <th><span class="Head">Group</span></th>
            <th><span class="Head">Sub Group</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
           if (count($user_other) > 0){
               foreach ($user_other as $ss_user) {
    ?>
        <tr>
                        <td align="center"><?=$index++?></td>
                        <td align="left"><?=$ss_user["company_name"]?></td>
                        <td align="left"><?=$ss_user["organization_name"]?></td>
                        <td align="left"><?=$ss_user["group_name"]?></td>
                        <td align="left"><?=$ss_user["subgroup_name"]?></td>
                        <td>
                            <? //if($company['status_company']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" alt="Restore" style="cursor: pointer;" />-->
                            <? // } else { ?>
                            <img src="../../images/edit_inline.png" alt="Modify" style="cursor: pointer;" value="<?=$ss_user["company_id"]."|".$ss_user["s_org_id"]."|".$ss_user["s_grp_id"]."|".$ss_user["s_subgrp_id"]."|".$ss_user["specorg_id"]?>"/>
<!--                            <img src="../../images/close_inline.png" alt="Delete" style="cursor: pointer;" value="<?=$ss_user["specorg_id"]?>"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$ss_user["specorg_id"]?>" />
<!--<img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="javascript:page_delete('index.php?action=user_other.php&specorg_id='<?=$ss_user["specorg_id"]?>,'delete');"/>-->
                            <? //} ?>
                            
                        </td>
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
</div>

 <div id="dialog1" title="User Other">
    <? include("user_other_dialog.php"); ?>
</div>

<input type="hidden" id="user_id" name="user_id" value="<?=$user["user_id"]?>">
<input type="hidden" id="company_dialog" name="company_dialog" value="">
<input type="hidden" id="subgrp_dialog" name="subgrp_dialog" value="">

<input type="hidden" name="specorg_id" id="specorg_id" value=""/>
<input type="hidden" id="s_com_id" name="s_company_id" value="">
<input type="hidden" id="s_org_id" name="s_company_id" value="">
<input type="hidden" id="s_grp_id" name="s_company_id" value="">
<input type="hidden" id="s_subgrp_id" name="s_company_id" value="">





