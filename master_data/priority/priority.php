<?php
   include_once "priority.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_project(){
        if($("#priority_desc").val() == ""){
            jAlert('error', 'Please input Priority Description', 'Helpdesk System : Messages');
            $("#priority_desc").focus();
            return false;   
        }else{
            validate_de_priority();
        }
    }
        function validate_de_priority(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=priority&priority_id=" + $("#priority_id").val() + "&priority_desc=" + $("#priority_desc").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Priority Description Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_submit("index.php?action=priority.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/priority/index.php?action=priority_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            validate_project();
        });

        $("#undo").click(function(){
            page_submit("index.php?action=priority.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=priority_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Priority Description<span class="required">*</span></td>
        <td><input type="text" id="priority_desc" name="priority_desc" style="width: 100%;" value="<?=$objective["priority_desc"]?>"/></td>
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
    <? if(strUtil::isNotEmpty($objective['priority_id'])){ ?>
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
   
<input type="hidden" name="priority_id" id="priority_id" value="<?=$objective["priority_id"]?>"/>