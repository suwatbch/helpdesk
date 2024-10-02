<?php
   //include_once "pp.action.php";
   include_once "user_other.action.php";
   include_once "../../include/function.php";
   include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript">

    function validate_project(){
        if($("#project_code").val() == ""){
            jAlert('error', 'Please input Project Code', 'Helpdesk System : Messages');
            $("#project_code").focus();
            return false;   
        }else if($("#project_name").val() == ""){
            jAlert('error', 'Please input Project Name', 'Helpdesk System : Messages');
            $("#project_name").focus();
            return false;   
        }else if($("#cus_comp_id").val() == ""){
            jAlert('error', 'Please input Customer Company', 'Helpdesk System : Messages');
            $("#cus_comp_id").focus();
            return false;   
        }else{
            return true;
        }
    }
     function validate_de_project(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=project&project_code=" + $("#project_code").val() + "&project_name=" + $("#project_name").val() 
                    + "&cus_comp_id=" + $("#cus_comp_id").val() + "&project_id=" + $("#project_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Project Code Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else if(respone == 2){ 
                        jAlert('error', 'Project Name Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_submit("index.php?action=project.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/project/index.php?action=project_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
		
		$("#btn_add_user_other").click(function(){
            jQuery('#dialog1').dialog('open'); return false;
        });
		
        $("#save").click(function(){
            if (validate_project()){
                validate_de_project();
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=project.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=project_list.php");
        });
    });
</script>
<br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Project Code<span class="required">*</span></td>
        <td><input type="text" id="project_code" name="project_code" style="width: 100%;" value="<?=$objective["project_code"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Project Name<span class="required">*</span></td>
        <td><input type="text" id="project_name" name="project_name" style="width: 100%;" value="<?=$objective["project_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Customer Company<span class="required">*</span></td>
        <td><?=$dd_cus_company?></td>
    </tr>
<!--    <tr>
        <td class="tr_header">Status <span class="required">*</span></td>
        <td>
            <input type="radio" name="status" id="active" value="A" style="border: 0px;" <?=checked("A", $objective["status"], "A")?>/><label for="active">Active</label>
            <input type="radio" name="status" id="inactive" value="I" style="border: 0px;" <?=checked("I", $objective["status"])?>/><label for="inactive">Inactive</label>
        </td>
    </tr>-->
    <tr>
        <td class="tr_header">Create By</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly value="<? if($objective['created_by']!=0){echo $objective["created_name"];}else{ echo user_session::get_user_name();}?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Create Date</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?if(strUtil::isNotEmpty($objective['created_date'])){echo dateUtil::date_dmyhms2($objective['created_date']);} else { echo date("m/d/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($objective['project_id'])){ ?>
    <tr>
        <td class="tr_header">Modified By</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=$objective['modified_name']?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Modified Date</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=dateUtil::date_dmyhms2($objective['modified_date'])?>"/></td>
    </tr>
    <? } ?>
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
            <th><span class="Head">User Code</span></th>
            <th><span class="Head">First Name</span></th>
            <th><span class="Head">Last Name</span></th>
            <th><span class="Head">Company</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
           if (count($user) > 0){
               foreach ($user as $ss_user) {
    ?>
        <tr>
                        <td align="center"><?=$index++?></td>
                        <td align="left"><?=$ss_user["user_code"]?></td>
                        <td align="left"><?=$ss_user["first_name"]?></td>
                        <td align="left"><?=$ss_user["last_name"]?></td>
                        <td align="left"><?=$ss_user["company_name"]?></td>
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

   
<input type="hidden" name="project_id" id="project_id" value="<?=$objective["project_id"]?>"/>