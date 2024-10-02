<?php
   include_once "product.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_project(){
        if($("#cus_comp_id").val() == ""){
            jAlert('error', 'Please input Customer Company', 'Helpdesk System : Messages');
            $("#cus_comp_id").focus();
            return false;   
        }else if($("#prd_tier_name").val() == ""){
            jAlert('error', 'Please input Product Class', 'Helpdesk System : Messages');
            $("#prd_tier_name").focus();
            return false;   
        }else{
            validate_de_product();
        }
    }
    function validate_de_product(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=product_class&prd_tier_id=" + $("#prd_tier_id").val() + "&cus_comp_id=" + $("#cus_comp_id").val() + "&prd_tier_name=" + $("#prd_tier_name").val(),
                success: function(respone){
                    //alert(respone);
                    //if(respone == 1){
                    //    jAlert('error', 'Product Class Duplicate !!', 'Helpdesk System : Messages');
                    //    return false;
                   //}else{
                   //    page_submit("index.php?action=product.php", "save")
                   //   }
                    page_submit("index.php?action=product.php", "save")
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/product_class/index.php?action=product_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            validate_project();
        });

        $("#undo").click(function(){
            page_submit("index.php?action=product.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=product_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Customer Company<span class="required">*</span></td>
        <td><?=$dd_cus_company?></td>
    </tr>
    <tr>
        <td class="tr_header">Product Class<span class="required">*</span></td>
        <td><input type="text" id="prd_tier_name" name="prd_tier_name" style="width: 100%;" value="<?=$objective["prd_tier_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Product Class Level<span class="required">*</span></td>
        <td>
            <input type="radio" name="prd_tier_level" id="prd_tier_level1" value="1" style="border: 0px;" <?=checked("1", $objective["prd_tier_level"], "1")?>/> Level 1
            <input type="radio" name="prd_tier_level" id="prd_tier_level2" value="2" style="border: 0px;" <?=checked("2", $objective["prd_tier_level"])?>/> Level 2
            <input type="radio" name="prd_tier_level" id="prd_tier_level3" value="3" style="border: 0px;" <?=checked("3", $objective["prd_tier_level"])?>/> Level 3
        </td>
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
    <? if(strUtil::isNotEmpty($objective['prd_tier_id'])){ ?>
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
   
<input type="hidden" name="prd_tier_id" id="prd_tier_id" value="<?=$objective["prd_tier_id"]?>"/>