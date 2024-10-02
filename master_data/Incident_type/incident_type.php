<?php
   include_once "incident_type.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_inc(){
        if($("#ident_type_desc").val() == ""){
            jAlert('error', 'Please input Incident Type', 'Helpdesk System : Messages');
            $("#ident_type_desc").focus();
            return false;   
        }else if($("#cus_comp_id").val() == ""){
            jAlert('error', 'Please input Customer Company', 'Helpdesk System : Messages');
            $("#cus_comp_id").focus();
            return false;   
        }else{
            validate_de_incident_type();
        }
    }
    function validate_de_incident_type(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=incident_type&ident_type_id=" + $("#ident_type_id").val() + "&ident_type_desc=" + $("#ident_type_desc").val() + "&cus_comp_id=" + $("#cus_comp_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Incident Type Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_submit("index.php?action=incident_type.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/incident_type/index.php?action=incident_type_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            validate_inc();
        });

        $("#undo").click(function(){
            page_submit("index.php?action=incident_type.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=incident_type_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="75%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Customer Company<span class="required">*</span></td>
        <td><?=$dd_cus_company?></td>
    </tr>
        <tr>
        <td class="tr_header">Incident Type<span class="required">*</span></td>
        <td><input type="text" id="ident_type_desc" name="ident_type_desc" style="width: 100%;" value="<?=$objective["ident_type_desc"]?>"/></td>
    </tr>
    </tr>
        <tr>
        <td class="tr_header">Display Report<span class="required">*</span></td>
        <td align="left"><input type="checkbox" id="display_report" name="display_report" value="1" <? if($objective["display_report"]== 1){ echo "checked";} ?>></td>
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
    <? if(strUtil::isNotEmpty($objective['ident_type_id'])){ ?>
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
   
<input type="hidden" name="ident_type_id" id="ident_type_id" value="<?=$objective["ident_type_id"]?>"/>