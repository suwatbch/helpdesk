<?php
   include_once "project.action.php";
   include_once "../../include/function.php";
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
<br><br><br><br><br>
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
   
<input type="hidden" name="project_id" id="project_id" value="<?=$objective["project_id"]?>"/>