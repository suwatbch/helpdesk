<?php
   include_once "resolve.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_sla_resolve(){
        if($("#cus_comp_id").val() == ""){
            jAlert('error', 'Please input Customer Company', 'Helpdesk System : Messages');
            $("#cus_comp_id").focus();
            return false;   
        }else if($("#tr_prd_tier_id").val() == ""){
            jAlert('error', 'Please input Product Classification Categories', 'Helpdesk System : Messages');
            $("#tr_prd_tier_id").focus();
            return false;   
        }else if($("#tr_opr_tier_id").val() == ""){
            jAlert('error', 'Please input Operation Classification Categories', 'Helpdesk System : Messages');
            $("#tr_opr_tier_id").focus();
            return false;   
        }else if($("#resolve_sla").val() == ""){
            jAlert('error', 'Please input Resolve SLA (Hour)', 'Helpdesk System : Messages');
            $("#resolve_sla").focus();
            return false;   
        }else if($('input[name="chk_priority[]"]:checked').length <= 0){
            jAlert('error', 'Please input priority ', 'Helpdesk System : Messages');
            return false; 
        }else{
            return true;
        }
    }
    function validate_de_resolve(){
        var chk_priority = $('input[name="chk_priority[]"]:checked').map(function(){
                return this.value;
            }).get().join(',');
        $("#sum_priority").val(chk_priority);
        
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=resolve&cus_comp_id=" + $("#cus_comp_id").val() + "&tr_prd_tier_id=" + $("#tr_prd_tier_id").val() 
                    + "&tr_opr_tier_id=" + $("#tr_opr_tier_id").val() + "&id_resolve_priority="+$("#id_resolve_priority").val()+"&chk_priority="+chk_priority,
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Reslove Service Level Agreement Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_submit("index.php?action=resolve.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/resolve/index.php?action=resolve_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            if (validate_sla_resolve()){
                validate_de_resolve();
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=resolve.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=resolve_list.php");
        });
    });
</script>
<script type="text/javascript">
   $(document).ready(function () {   
    
	$("#cus_comp_id").change(function(){
           var company_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "../common/dropdown_prd.php",
                data: "company_id=" + company_id,
                success: function(respone){
                  //alert(respone);
                   document.getElementById("tr_prd_tier_id").innerHTML =respone;
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../common/dropdown_opr.php",
                data: "company_id=" + company_id,
                success: function(respone){
                    //alert(respone);
                    //$("#tr_opr_tier_id").replaceWith(respone);
                    document.getElementById("tr_opr_tier_id").innerHTML =respone;
                }
            }); 
            
            $("#prd_class1").val(null);
            $("#prd_class2").val(null);
            $("#prd_class3").val(null);
            $("#opr_class1").val(null);
            $("#opr_class2").val(null);
            $("#opr_class3").val(null);
            
            
       });
       
       $("#tr_prd_tier_id").change(function(){
           var tr_prd_tier_id = $(this).val();          
               $.ajax({
                type: "GET",
                url: "../common/class_sla.php",
                data: 'tr_prd_tier_id=' + tr_prd_tier_id + '&option_class=1',
                success: function(respone){
                    //alert(respone);
                    $("#prd_class1").val(respone);
                }
            });
            
            $.ajax({
                type: "GET",
                url: "../common/class_sla.php",
                data: 'tr_prd_tier_id=' + tr_prd_tier_id + '&option_class=2',
                success: function(respone){
                    //alert(respone);
                    $("#prd_class2").val(respone);
                }
            });
            
            $.ajax({
                type: "GET",
                url: "../common/class_sla.php",
                data: 'tr_prd_tier_id=' + tr_prd_tier_id + '&option_class=3',
                success: function(respone){
                    //alert(respone);
                    $("#prd_class3").val(respone);
                }
            });
       });
       
       $("#tr_opr_tier_id").change(function(){
           var tr_opr_tier_id = $(this).val();          
               $.ajax({
                type: "GET",
                url: "../common/class_sla.php",
                data: 'tr_opr_tier_id=' + tr_opr_tier_id + '&option_class=1',
                success: function(respone){
                    //alert(respone);
                    $("#opr_class1").val(respone);
                }
            });
            
            $.ajax({
                type: "GET",
                url: "../common/class_sla.php",
                data: 'tr_opr_tier_id=' + tr_opr_tier_id + '&option_class=2',
                success: function(respone){
                    //alert(respone);
                    $("#opr_class2").val(respone);
                }
            });
            
            $.ajax({
                type: "GET",
                url: "../common/class_sla.php",
                data: 'tr_opr_tier_id=' + tr_opr_tier_id + '&option_class=3',
                success: function(respone){
                    //alert(respone);
                    $("#opr_class3").val(respone);
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
        <td class="tr_header">Priority<span class="required">*</span></td>
        <td align="left">
            <? 
            foreach ($objective["data_priority"] as $data_priority){
                $data_pri[] = $data_priority["priority_id"];
            }
              if (count($s_list_priority) > 0){
                   if($objective["id_resolve_priority"]!=""){
                       foreach ($s_list_priority as $list_prior){
                           if(in_array($list_prior["priority_id"], $data_pri)){
                               echo "<input type='checkbox' name='chk_priority[]' value='$list_prior[priority_id]' checked>&nbsp;$list_prior[priority_desc]"."&nbsp;&nbsp;";
                           }else{
                                echo "<input type='checkbox' name='chk_priority[]' value='$list_prior[priority_id]'>&nbsp;$list_prior[priority_desc]"."&nbsp;&nbsp;";
                            }
                    }
                   }else{
                   foreach ($s_list_priority as $list_prior){
                                echo "<input type='checkbox' name='chk_priority[]' value='$list_prior[priority_id]' checked>&nbsp;$list_prior[priority_desc]"."&nbsp;&nbsp;";
                    }   
               }
               }
                
            ?>
        </td>
   </tr>
    <tr>
        <td class="tr_header">Product Classification Categories<span class="required">*</span></td>
        <td><?=$dd_prd_tire?></td>
    </tr>
    <tr>
        <td class="tr_header">Product Class 1<span class="required">*</span></td>
        <td><input type="text" id="prd_class1" name="prd_class1" style="width: 100%;" class="disabled" readonly value="<?=$objective["prd_name_class1"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Product Class 2<span class="required">*</span></td>
        <td><input type="text" id="prd_class2" name="prd_class2" style="width: 100%;" class="disabled" readonly value="<?=$objective["prd_name_class2"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Product Class 3<span class="required">*</span></td>
        <td><input type="text" id="prd_class3" name="prd_class3" style="width: 100%;" class="disabled" readonly value="<?=$objective["prd_name_class3"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Operation Classification Categories<span class="required">*</span></td>
        <td><?=$dd_opr_tire?></td>
    </tr>
    <tr>
        <td class="tr_header">Operation Class 1<span class="required">*</span></td>
        <td><input type="text" id="opr_class1" name="opr_class1" style="width: 100%;" class="disabled" readonly value="<?=$objective["opr_name_class1"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Operation Class 2<span class="required">*</span></td>
        <td><input type="text" id="opr_class2" name="opr_class2" style="width: 100%;" class="disabled" readonly value="<?=$objective["opr_name_class2"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Operation Class 3</td>
        <td><input type="text" id="opr_class3" name="opr_class3" style="width: 100%;" class="disabled" readonly value="<?=$objective["opr_name_class3"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Resolve SLA (Time) (HHHH:MM:SS)<span class="required">*</span></td>
        <td><input type="text" id="resolve_sla" name="resolve_sla" style="width: 100%;" value="<?=$objective["resolve_sla"]?>" maxlength="10" rule="time"/></td>
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
    <? if(strUtil::isNotEmpty($objective['id_resolve_priority'])){ ?>
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
   
<input type="hidden" name="id_resolve_priority" id="id_resolve_priority" value="<? if($copy==1){ echo "";}else { echo $objective["id_resolve_priority"]; }?>"/>
<input type="hidden" name="c_id_resolve_priority" id="c_id_resolve_priority" value="<? if($copy==1){ echo $objective["id_resolve_priority"];}else { echo "" ; }?>"/>
<input type="hidden" name="sum_priority" id="sum_priority" value=""/>