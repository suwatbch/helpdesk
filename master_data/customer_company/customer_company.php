<?php
   include_once "customer_company.action.php";
   include_once "../../include/function.php";
   
   if($company["cus_company_logo"]=="")
   {
	   $logo = "nologo.png";
   }
   else
   {
	   $logo = $company["cus_company_logo"];
   }
   
?>
<script type="text/javascript">
    function validate_customer_company(){
        if($("#cus_company_name").val() == ""){
            jAlert('error', 'Please input Customer Company Name', 'Helpdesk System : Messages');
            $("#cus_company_name").focus();
            return false;   
        }else{
            validate_de_cus_com();
        }
    }
    function validate_de_cus_com(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=customer_company&cus_company_name=" + $("#cus_company_name").val() + "&cus_company_id=" + $("#cus_company_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Customer Company Name Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_submit("index.php?action=customer_company.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/customer_company/index.php?action=customer_company_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            if (validate_customer_company()){
                page_submit("index.php?action=customer_company.php&action_master=1", "save");
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=customer_company.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=customer_company_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Customer Company Name <span class="required">*</span></td>
        <td><input type="text" id="cus_company_name" name="cus_company_name" style="width: 100%;" value="<?=$company["cus_company_name"]?>"/></td>
    </tr>
	<tr>
        <td class="tr_header">Logo </td>
        <td><input name="fileLogo" type="file" id="fileLogo" style=" width: 100%;"></td>
    </tr>
	<tr>
        <td></td>
        <td>
			 <img src="<?=$application_path_images?>/<?=$logo?>" width="100" height="100">
		</td>
    </tr>
<!--    <tr>
        <td class="tr_header">Status <span class="required">*</span></td>
        <td>
            <input type="radio" name="status" id="active" value="A" style="border: 0px;" <?=checked("A", $company["status"], "A")?>/><label for="active">Active</label>
            <input type="radio" name="status" id="inactive" value="I" style="border: 0px;" <?=checked("I", $company["status"])?>/><label for="inactive">Inactive</label>
        </td>
    </tr>-->
    <tr>
        <td class="tr_header">Create By</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly value="<? if($company['created_by']!=0){echo $company["created_name"];}else{ echo user_session::get_user_name();}?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Create Date</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?if(strUtil::isNotEmpty($company['created_date'])){echo dateUtil::date_dmyhms2($company['created_date']);} else { echo date("d/m/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($company['cus_company_id'])){ ?>
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
   
<input type="hidden" name="cus_company_id" id="cus_company_id" value="<?=$company["cus_company_id"]?>"/>