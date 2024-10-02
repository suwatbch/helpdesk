<?
    include_once "user_other.action.php";
?>
            <table width="100%" border="0" cellpadding="0" cellspacing="3" align="center">
                <tr>
        <td class="tr_header">Company <span class="required">*</span></td>
        <td><?=$dd_company;?></td>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Organization <span class="required">*</span></td>
        <td><?=$dd_org;?></td>
        </td> 
    </tr>
    <tr>
        <td class="tr_header">Group <span class="required">*</span></td>
        <td><?=$dd_grp;?></td>
        </td>
    </tr>
    <tr>
        <td class="tr_header">Sub Group <span class="required">*</span></td>
        <td><?=$dd_subgrp;?></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td colspan="2" align="center">
                        <input type="button" id="btn_save" value="Save" class="input-button" style=" width: 80px; height: 20px;" style="cursor: pointer;" onclick="validate_user_other();"/>
                        <input type="button" id="btn_cancel" value="Cancel" class="input-button" style=" width: 80px; height: 20px;" style="cursor: pointer;"/>
        </td></tr>
            </table>


