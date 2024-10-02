<?php
   include_once "cus_zone.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_zone(){
        if($("#shortname").val() == ""){
            jAlert('error', 'Please input Zone Short Name', 'Helpdesk System : Messages');
            $("#shortname").focus();
            return false;   
        }else if($("#name").val() == ""){
            jAlert('error', 'Please input Zone Name ', 'Helpdesk System : Messages');
            $("#name").focus();
            return false;   
        }else if($("#cus_company_id").val() == ""){
            jAlert('error', 'Please input Customer Company', 'Helpdesk System : Messages');
            $("#cus_company_id").focus();
            return false;   
        }else{
            validate_de_cus_zone();
        }
    }
        function validate_de_cus_zone(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=customer_zone&shortname=" + $("#shortname").val() + "&name=" + $("#name").val() + 
                    "&zone_id=" + $("#zone_id").val() + "&cus_company_id=" + $("#cus_company_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Zone Short Name Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else if(respone == 2){ 
                        jAlert('error', 'Zone Name Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_submit("index.php?action=cus_zone.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/customer_zone/index.php?action=cus_zone_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            validate_zone();
        });

        $("#undo").click(function(){
            page_submit("index.php?action=cus_zone.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=cus_zone_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Zone Number<span class="required">*</span></td>
        <td><input type="text" id="shortname" name="shortname" style="width: 100%;" value="<?=$objective["shortname"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Zone Name<span class="required">*</span></td>
        <td><input type="text" id="name" name="name" style="width: 100%;" value="<?=$objective["name"]?>"/></td>
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
    <? if(strUtil::isNotEmpty($objective['zone_id'])){ ?>
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
   
<input type="hidden" name="zone_id" id="zone_id" value="<?=$objective["zone_id"]?>"/>