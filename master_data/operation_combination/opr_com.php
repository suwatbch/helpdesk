<?php
   include_once "opr_com.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_opr_com(){
        if($("#cus_comp_id").val() == ""){
            jAlert('error', 'Please input Customer Company', 'Helpdesk System : Messages');
            $("#cus_comp_id").focus();
            return false;   
        }else if($("#opr_tier_lv1_id").val() == ""){
            jAlert('error', 'Please input Opration Class 1', 'Helpdesk System : Messages');
            $("#opr_tier_lv1_id").focus();
            return false;   
        }else if($("#opr_tier_lv2_id").val() == ""){
            jAlert('error', 'Please input Opration Class 2', 'Helpdesk System : Messages');
            $("#opr_tier_lv2_id").focus();
            return false;   
        }else{
            return true;
        }
    }
    function validate_de_opr_com(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=operation_combination&cus_comp_id=" + $("#cus_comp_id").val() + "&opr_tier_lv1_id=" + $("#opr_tier_lv1_id").val() 
                    + "&opr_tier_lv2_id=" + $("#opr_tier_lv2_id").val() + "&opr_tier_lv3_id=" + $("#opr_tier_lv3_id").val()+"&tr_opr_tier_id=" +$("#tr_opr_tier_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Operation Class Combination Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_submit("index.php?action=opr_com.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/operation_combination/index.php?action=opr_com_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            if (validate_opr_com()){
                validate_de_opr_com();
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=opr_com.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=opr_com_list.php");
        });
    });
</script>
<script type="text/javascript">
   $(document).ready(function () {   
    
	$("#cus_comp_id").change(function(){
            
           var company_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "../common/dropdown_opr_tier1.php",
                data: "cus_comp_id=" + company_id,
                success: function(respone){
                   // alert(respone);
                    $("#opr_tier_lv1_id").replaceWith(respone);
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown_opr_tier2.php",
                data: "cus_comp_id=" + company_id,
                success: function(respone){
                    $("#opr_tier_lv2_id").replaceWith(respone);
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown_opr_tier3.php",
                data: "cus_comp_id=" + company_id,
                success: function(respone){
                   // alert(respone);
                    $("#opr_tier_lv3_id").replaceWith(respone);
                }
            }); 
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
        <td class="tr_header">Operation Class 1<span class="required">*</span></td>
        <td><?=$dd_opr_tier_lv1?></td>
    </tr>
     <tr>
        <td class="tr_header">Operation Class 2<span class="required">*</span></td>
        <td><?=$dd_opr_tier_lv2?></td>
    </tr>
     <tr>
        <td class="tr_header">Operation Class 3</td>
        <td><?=$dd_opr_tier_lv3?></td>
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
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?if(strUtil::isNotEmpty($objective['created_date'])){echo dateUtil::date_dmyhms2($objective['created_date']);} else { echo date("d/m/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($objective['tr_opr_tier_id'])){ ?>
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
   
<input type="hidden" name="tr_opr_tier_id" id="tr_opr_tier_id" value="<? if($copy==1){ echo "";}else { echo $objective["tr_opr_tier_id"]; }?>"/>
<input type="hidden" name="c_tr_opr_tier_id" id="c_tr_opr_tier_id" value="<? if($copy==1){ echo $objective["tr_opr_tier_id"];}else { echo "" ; }?>"/>