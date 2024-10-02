<?php
   include_once "aging.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript">
    function validate_aging(){
        if($("#value").val() == ""){
            jAlert('error', 'Please input Value (>=)', 'Helpdesk System : Messages');
            $("#value").focus();
            return false;   
        }else{
            return true;
        }
    }
    function validate_de_aging(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=aging&id=" + $("#id").val() + "&value=" + $("#value").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Aging Value Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_submit("index.php?action=aging.php", "save")
                      }
                }
            });
           
    }
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/aging_report/index.php?action=aging_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    $(function(){
        $("#save").click(function(){
            if (validate_aging()){
                validate_de_aging();
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=aging.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=aging_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="75%" border="0" cellpadding="0" cellspacing="5" align="center">
    <tr>
        <td class="tr_header">Value (>=)<span class="required">*</span></td>
        <td><input type="text" id="value" name="value" style="width: 500px" value="<?=$objective["value"]?>" OnKeyPress="return chkNumber(this)"/></td>
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
        <td><input type="text" style="width: 500px" class="disabled" readonly value="<? if($objective['created_by']!=0){echo $objective["created_name"];}else{ echo user_session::get_user_name();}?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Create Date</td>
        <td><input type="text" style="width: 500px" class="disabled" readonly  value="<?if(strUtil::isNotEmpty($objective['created_date'])){echo dateUtil::date_dmyhms2($objective['created_date']);} else { echo date("m/d/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($objective['id'])){ ?>
    <tr>
        <td class="tr_header">Modified By</td>
        <td><input type="text" class="disabled" readonly style="width: 500px" value="<?=$objective['modified_name']?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Modified Date</td>
        <td><input type="text" class="disabled" readonly style="width: 500px" value="<?=dateUtil::date_dmyhms2($objective['modified_date'])?>"/></td>
    </tr>
    <? } ?>
</table>
   
<input type="hidden" name="id" id="id" value="<?=$objective["id"]?>"/>