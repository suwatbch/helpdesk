<?php
   include_once "cus_area.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_cus_area(){
        if($("#area_cus").val() == ""){
            jAlert('error', 'Please input Area Code', 'Helpdesk System : Messages');
            $("#area_cus").focus();
            return false;   
        }else if($("#area_cus_name").val() == ""){
            jAlert('error', 'Please input Area Name', 'Helpdesk System : Messages');
            $("#area_cus_name").focus();
            return false;   
        }else if($("#zone_id").val() == ""){
            jAlert('error', 'Please input Zone', 'Helpdesk System : Messages');
            $("#zone_id").focus();
            return false;   
        }else{
            validate_de_cus_area();
        }
    }
    function validate_de_cus_area(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=customer_area&id=" + $("#cus_area_id").val() + "&area_cus=" + $("#area_cus").val() + "&area_cus_name=" + $("#area_cus_name").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Area Code Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else if(respone == 2){ 
                        jAlert('error', 'Area Name Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_submit("index.php?action=cus_area.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/customer_area/index.php?action=cus_area_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
           validate_cus_area();
        });

        $("#undo").click(function(){
            page_submit("index.php?action=cus_area.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=cus_area_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Area Code<span class="required">*</span></td>
        <td><input type="text" id="area_cus" name="area_cus" style="width: 100%;" value="<?=$objective["area_cus"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Area Name<span class="required">*</span></td>
        <td><input type="text" id="area_cus_name" name="area_cus_name" style="width: 100%;" value="<?=$objective["area_cus_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Zone<span class="required">*</span></td>
        <td><?=$dd_cus_zone?></td>
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
    <? if(strUtil::isNotEmpty($objective['id'])){ ?>
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
   
<input type="hidden" name="cus_area_id" id="cus_area_id" value="<?=$objective["id"]?>"/>