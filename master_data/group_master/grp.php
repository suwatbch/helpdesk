<?php
   include_once "grp.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_grp_mas(){
        if($("#company_id").val() == ""){
            jAlert('error', 'Please input Company Name', 'Helpdesk System : Messages');
            $("#company_id").focus();
            return false;   
        }else if($("#org_id").val() == ""){
            jAlert('error', 'Please input Organization Name', 'Helpdesk System : Messages');
            $("#org_id").focus();
            return false;   
        }else if($("#org_name").val() == ""){
            jAlert('error', 'Please input Group Name', 'Helpdesk System : Messages');
            $("#org_name").focus();
            return false;   
        }else{
            return true;
        }
    }
    function validate_de_grp_mas(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=group_master&company_id=" + $("#company_id").val() + "&org_id=" + $("#s_org_id").val() + "&org_name=" + $("#org_name").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Group Master Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_submit("index.php?action=grp.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/group_master/index.php?action=grp_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            if (validate_grp_mas()){
                validate_de_grp_mas();
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=grp.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=grp_list.php");
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
       });
    
   });   
    
</script> 
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Company Name<span class="required">*</span></td>
        <td><?=$dd_company?></td>
    </tr>
    <tr>
        <td class="tr_header">Organization Name<span class="required">*</span></td>
        <td><?=$dd_org?></td>
    </tr>
    <tr>
        <td class="tr_header">Group Name<span class="required">*</span></td>
        <td><input type="text" id="org_name" name="org_name" style="width: 100%;" value="<?=$objective["org_name"]?>"/></td>
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
    <? if(strUtil::isNotEmpty($objective['org_id'])){ ?>
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
   
<input type="hidden" name="s_org_id" id="s_org_id" value="<?=$objective["org_id"]?>"/>
<input type="hidden" name="s_org_comp" id="s_org_comp" value="<?=$objective["org_comp"]?>"/>