<?php
   include_once "company.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_company(){
        if($("#company_name").val() == ""){
            jAlert('error', 'Please input Company Name', 'Helpdesk System : Messages');
            $("#company_name").focus();
            return false;   
        }else{
            validate_de_company();
        }
    }
     function validate_de_company(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=company&company_id=" + $("#company_id").val() + "&company_name=" + $("#company_name").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Company Name Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_submit("index.php?action=company.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/company/index.php?action=company_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            validate_company();
        });

        $("#undo").click(function(){
            page_submit("index.php?action=company.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=company_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Company Name <span class="required">*</span></td>
        <td><input type="text" id="company_name" name="company_name" required="true" description="Company Name"  style="width: 100%;" value="<?=$company["company_name"]?>"/></td>
    </tr>
<!--    <tr>
        <td class="tr_header">Status <span class="required">*</span></td>
        <td>
            <input type="radio" name="status_company" id="active" value="A" style="border: 0px;" <?=checked("A", $company["status_company"], "A")?>/><label for="active">Active</label>
            <input type="radio" name="status_company" id="inactive" value="I" style="border: 0px;" <?=checked("I", $company["status_company"])?>/><label for="inactive">Inactive</label>
        </td>
    </tr>-->
    <tr>
        <td class="tr_header">Create By</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly value="<? if($company['created_name']!=""){echo $company["created_name"];}else{ echo user_session::get_user_name();}?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Create Date</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?if($company['created_date']=="0000-00-00 00:00:00"){echo dateUtil::date_dmyhms2($company['created_date']);} else { echo date("m/d/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($company['company_id'])){ ?>
    <tr>
        <td class="tr_header">Modified By</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=$company['modified_name']?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Modified Date</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=dateUtil::date_dmyhms2($company['modified_date'])?>"/></td>
    </tr>
    <? } ?>
</table>
   
<input type="hidden" name="company_id" id="company_id" value="<?=$company["company_id"]?>"/>