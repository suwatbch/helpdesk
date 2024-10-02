<?php
   include_once "cus_org.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_cus_org(){
        if($("#cus_org_name").val() == ""){
            jAlert('error', 'Please input Customer Organization Name', 'Helpdesk System : Messages');
            $("#cus_org_name").focus();
            return false;   
        }else{
            validate_de_cus_org();
        }
    }
        function validate_de_cus_org(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=customer_organization&cus_org_name=" + $("#cus_org_name").val() + "&cus_org_id=" + $("#cus_org_id").val() + "&cus_company_id=" + $("#cus_company_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Customer Organization Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_submit("index.php?action=cus_org.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/customer_organization/index.php?action=cus_org_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            if (validate_cus_org()){
                page_submit("index.php?action=cus_org.php&action_master=1", "save");
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=cus_org.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=cus_org_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
      <tr>
        <td class="tr_header">Customer Company <span class="required">*</span></td>
        <td><?=$dd_company_cus;?>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Customer Organization Name <span class="required">*</span></td>
        <td><input type="text" id="cus_org_name" name="cus_org_name" style="width: 100%;" value="<?=$objective["cus_org_name"]?>"/></td>
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
    <? if(strUtil::isNotEmpty($objective['cus_org_id'])){ ?>
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
   
<input type="hidden" name="cus_org_id" id="cus_org_id" value="<?=$objective["cus_org_id"]?>"/>