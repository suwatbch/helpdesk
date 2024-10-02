<?php
   include_once "org.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_org_mas(){
        if($("#company_id").val() == ""){
            jAlert('error', 'Please input Company Name', 'Helpdesk System : Messages');
            $("#company_id").focus();
            return false;   
        }else if($("#org_name").val() == ""){
            jAlert('error', 'Please input Organization Name', 'Helpdesk System : Messages');
            $("#org_name").focus();
            return false;   
        }else{
            return true;
        }
    }
    function validate_de_org_mas(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=organization_master&org_comp=" + $("#company_id").val() + "&org_id=" + $("#org_id").val()+"&org_name="+$("#org_name").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Organization Master Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_submit("index.php?action=org.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/organization_master/index.php?action=org_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            if (validate_org_mas()){
                validate_de_org_mas();
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=org.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=org_list.php");
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
   
<input type="hidden" name="org_id" id="org_id" value="<?=$objective["org_id"]?>"/>