<br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="3" align="center">
    <tr>
        <td class="tr_header">Group Code <span class="required">*</span></td>
        <td><input type="text" name="access_group_code" id="access_group_code" style="width: 100%;" maxlength="20" required="true" description="Group Code" value="<?=$access_group["access_group_code"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Group Name <span class="required">*</span></td>
        <td><input type="text" name="access_group_name" id="access_group_name" style="width: 100%;" maxlength="50" required="true" description="Group Name" value="<?=htmlspecialchars($access_group["access_group_name"])?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Description</td>
        <td><textarea name="description" maxlength="300" id="description" style="width: 100%;; height: 50px;"><?=htmlspecialchars($access_group["description"])?></textarea></td>
    </tr>
    <tr>
        <td class="tr_header">Status</td>
        <td>
            <input type="radio" name="access_group_status" id="active" value="A" style="border: 0px;" <?=(in_array($access_group["access_group_status"], array("A", ""))) ? "checked" : ""?>/><label for="active" style="font-size: 12px;">Active</label>
            <input type="radio" name="access_group_status" id="inactive" value="I" style="border: 0px;" <?=($access_group["access_group_status"] == "I") ? "checked" : ""?>/><label for="inactive" style="font-size: 12px;">Inactive</label>
        </td>
    </tr>
        <tr>
        <td class="tr_header">Create By</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly value="<? if($access_group['created_by']!=0){echo $access_group["created_name"];}else{ echo user_session::get_user_name();}?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Create Date</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?if(strUtil::isNotEmpty($access_group['created_date'])){echo dateUtil::date_dmyhms2($access_group['created_date']);} else { echo date("m/d/Y");}?>"/></td>
    </tr>
    <? if(strUtil::isNotEmpty($access_group['access_group_id'])){ ?>
    <tr>
        <td class="tr_header">Modified By</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=$access_group['modified_name']?>"/></td>
    </tr>
    <tr>
        <td class="tr_header">Modified Date</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=dateUtil::date_dmyhms2($access_group['modified_date'])?>"/></td>
    </tr>
    <? } ?>
</table>
