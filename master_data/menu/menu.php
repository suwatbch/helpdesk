<?php
    include_once "menu.action.php";
?>
<script type="text/javascript">
    function validate_menu(){
        if($("#menu_code").val() == ""){
            jAlert('error', 'Please input Menu Code', 'Helpdesk System : Messages');
            $("#menu_code").focus();
            return false;   
        }else if($("#menu_name").val() == ""){
            jAlert('error', 'Please input Menu Name', 'Helpdesk System : Messages');
            $("#menu_name").focus();
            return false;   
        }else{
            return true;
        }
    }
    
    function validate_de_menu(){
        $.ajax({
                type: "GET",
                url: "../common/validate_detail.php",
                data: "action=menu&menu_code=" + $("#menu_code").val() + "&menu_name=" + $("#menu_name").val() + "&menu_id=" + $("#menu_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Menu Code Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else if(respone == 2){ 
                        jAlert('error', 'Menu Name Duplicate !!', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_submit("index.php?action=menu.php", "save")
                      }
                }
            });
           
    }
    
    function back_master(){
        <?
            $_SESSION["current"] = "master_data/menu/index.php?action=menu_list.php";
            
        ?>
            top.location.href= "../../home.php";
    }
    
    $(function(){
        $("#save").click(function(){
            if (validate_menu()){
                validate_de_menu();
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=menu.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=menu_list.php");
        });
    });
</script>
<br><br><br><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="3" align="center">
    <tr>
        <td class="tr_header">Menu Code <span class="required">*</span></td>
        <td><input type="text" name="menu_code" id="menu_code" maxlength="20" style="width: 100%;" value="<?=htmlspecialchars($menu["menu_code"])?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Menu Name <span class="required">*</span></td>
        <td><input type="text" name="menu_name" id="menu_name" maxlength="100" style="width: 100%;" value="<?=htmlspecialchars($menu["menu_name"])?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Parent Menu</td>
        <td>
            <?=$dd_parents?>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Link</td>
        <td><input type="text" name="href" maxlength="100" style="width: 100%;" value="<?=htmlspecialchars($menu["href"])?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Icon Name</td>
        <td ><input type="text" name="icon" maxlength="100" style="width: 100%;" value="<?=htmlspecialchars($menu["icon"])?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Status</td>
        <td>
            <input type="radio" name="status" id="active" value="A" style="border: 0px;" <?=checked("A", $menu["status"], "A")?>/><label for="active">Active</label>
            <input type="radio" name="status" id="inactive" value="I" style="border: 0px;" <?=checked("I", $menu["status"])?>/><label for="inactive">Inactive</label>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Create By</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly value="<? if($menu['created_by']!=0){echo $menu["created_name"];}else{ echo user_session::get_user_name();}?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Create Date</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?if(strUtil::isNotEmpty($menu['created_date'])){echo dateUtil::date_dmyhms2($menu['created_date']);} else { echo date("m/d/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($menu['menu_id'])){ ?>
    <tr>
        <td class="tr_header">Modified By</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=$menu['modified_name']?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Modified Date</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=dateUtil::date_dmyhms2($menu['modified_date'])?>"/></td>
    </tr>
    <? } ?>
</table>
<input type="hidden" name="menu_id" id="menu_id" value="<?=$menu["menu_id"]?>"/>