<?php
   include_once "customer.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_customer(){
        if($("#code_cus").val() == ""){
            jAlert('error', 'Please input Customer ID', 'Helpdesk System : Messages');
            $("#code_cus").focus();
            return false;   
        }else if($("#firstname_cus").val() == ""){
            jAlert('error', 'Please input First Name', 'Helpdesk System : Messages');
            $("#firstname_cus").focus();
            return false;   
        }else if($("#lastname_cus").val() == ""){
            jAlert('error', 'Please input Last Name', 'Helpdesk System : Messages');
            $("#lastname_cus").focus();
            return false;   
        }else if($("#cus_company_id").val() == ""){
            jAlert('error', 'Please input Company', 'Helpdesk System : Messages');
            $("#cus_company_id").focus();
            return false;   
        }else if($("#org_cus").val() == ""){
            jAlert('error', 'Please input Organization', 'Helpdesk System : Messages');
            $("#org_cus").focus();
            return false;   
        }else if($("#area_cus").val() == ""){
            jAlert('error', 'Please select Area', 'Helpdesk System : Messages');
            $("#area_cus").focus();
            return false;   
        }else if($("#dep_cus").val() == ""){
            jAlert('error', 'Please select Department', 'Helpdesk System : Messages');
            $("#dep_cus").focus();
            return false;   
        }else if($("#office_cus").val() == ""){
            jAlert('error', 'Please select Office', 'Helpdesk System : Messages');
            $("#office_cus").focus();
            return false;   
       }else{
            return true;
        }
    }
    function validate_de_customer(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=customer&code_cus=" + $("#code_cus").val() + "&cus_id=" + $("#cus_id").val(),
                success: function(respone){
                    //alert(respone);
                    
					page_submit("index.php?action=customer.php", "save")
					
					/*
					if(respone == 1){ 
                        jAlert('error', 'Customer ID Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                    }else{
                        page_submit("index.php?action=customer.php", "save")
                    }
					*/
					
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/customer/index.php?action=customer_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            if (validate_customer()){
                validate_de_customer();
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=customer.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=customer_list.php");
        });
    });
</script> 
<script type="text/javascript">
   $(document).ready(function () {   
    
	$("#cus_company_id").change(function(){
           var cus_company_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "../common/dropdown.cus_org.php",
                data: "cus_company_id=" + cus_company_id,
                success: function(respone){
                  //alert(respone);
                    //$("#org_cus").replaceWith(respone);
                    document.getElementById("org_cus").innerHTML =respone;
                }
            }); 
       });
    
   });   
    
</script> 
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Customer ID <span class="required">*</span></td>
        <td><input type="text" id="code_cus" name="code_cus" style="width: 100%;" value="<?=$customer["code_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">First Name <span class="required">*</span></td>
        <td><input type="text" id="firstname_cus" name="firstname_cus" style="width: 100%;" value="<?=$customer["firstname_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Last Name <span class="required">*</span></td>
        <td><input type="text" id="lastname_cus" name="lastname_cus" style="width: 100%;" value="<?=$customer["lastname_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Phone Number</td>
        <td><input type="text" id="phone_cus" name="phone_cus" style="width: 100%;" value="<?=$customer["phone_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">IP Address</td>
        <td><input type="text" id="ipaddress_cus" name="ipaddress_cus" style="width: 100%;" value="<?=$customer["ipaddress_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Email</td>
        <td><input type="text" id="email_cus" name="email_cus" style="width: 100%;" value="<?=$customer["email_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Company <span class="required">*</span></td>
        <td><?=$dd_company_cus;?>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Organization <span class="required">*</span></td>
        <td><?=$dd_org_cus;?>
        </td> 
    </tr>
    <tr>
        <td class="tr_header">Area <span class="required">*</span></td>
        <td><?=$dd_area_cus;?>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Office <span class="required">*</span></td>
        <td><input type="text" id="office_cus" name="office_cus" style="width: 100%;" value="<?=$customer["office_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Department <span class="required">*</span></td>
        <td><input type="text" id="dep_cus" name="dep_cus" style="width: 100%;" value="<?=$customer["dep_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Site</td>
        <td><input type="text" id="site_cus" name="site_cus" style="width: 100%;" value="<?=$customer["site_cus"]?>"/></td>
    </tr>
<!--    <tr>
        <td class="tr_header">Customer Active <span class="required">*</span></td>
        <td><input type="checkbox" name="status_customer" id="status_customer" value="A" <? if($customer["status_customer"]== 'A'){ echo "checked"; }?>></td>
    </tr>-->
    <tr>
        <td class="tr_header">Create By</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly value="<? if($customer['created_by']!=0){echo $customer["created_name"];}else{ echo user_session::get_user_name();}?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Create Date</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?if(strUtil::isNotEmpty($customer['created_date'])){echo dateUtil::date_dmyhms2($customer['created_date']);} else { echo date("m/d/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($customer['cus_id'])){ ?>
    <tr>
        <td class="tr_header">Modified By</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=$customer['modified_name']?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Modified Date</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=dateUtil::date_dmyhms2($customer['modified_date'])?>"/></td>
    </tr>
    <? } ?>
</table>
   
<input type="hidden" name="cus_id" id="cus_id" value="<? if($copy==1){ echo "";}else { echo $customer["cus_id"]; }?>"/>
<input type="hidden" name="c_cus_id" id="c_cus_id" value="<? if($copy==1){ echo $customer["cus_id"];}else { echo ""; }?>"/>