<?php
/*
if (count($incident["Assignment"]) > 0){
	$index = 1;
    foreach ($incident["Assignment"] as $asm) {
		echo $asm["assign_group_id"];
	}
}
echo $asm["assign_group_id"];
exit();
*/
$dd_disable2 = $incident["per_ddAssign2"];
if($dd_disable2 == "Y"){ //กรณีเป็นการ create incident ครั้งแรกและคนเปิดไม่มีสิทธิ์ transfer incedent 
	/*
	$ddassign_comp_id = $incident["owner_comp_id"];
	$ddassign_org_id = $incident["owner_org_id"];
	$ddassign_group_id = $incident["owner_grp_id"];
	$ddassign_subgrp_id = $incident["owner_subgrp_id"]; 
	*/
	$ddassign_comp_id = user_session::get_user_company_id();
	$ddassign_org_id = user_session::get_user_org_id();
	$ddassign_group_id = user_session::get_user_grp_id();
	$ddassign_subgrp_id = user_session::get_user_subgrp_id();
}else{
	$ddassign_comp_id = $asm["assign_comp_id"];
	$ddassign_org_id = $asm["assign_org_id"];
	$ddassign_group_id = $asm["assign_group_id"];
	$ddassign_subgrp_id = $asm["assign_subgrp_id"];
}
?>			
<input type="hidden" id="h_assigned_date" name="h_assigned_date" value="<?=$incident["assigned_date"];?>"/>
<input type="hidden" name="h_owner_user_email" id="h_owner_user_email" value="<?=htmlspecialchars($incident["owner_user_email"])?>"/>
<div style="overflow-y: auto;">
			<br>
            <table width="98%" border="0" cellpadding="0" cellspacing="1" align="center">
                <tr style="height: 30px">
                    <td>
                        <span class="styleBlue">ASSIGNMENT</span><span class="styleGray"> INFORMATION</span>
                    </td>
                </tr>
            </table>
            <table width="80%" border="0" cellpadding="0" cellspacing="3" align="center">
                <tr>
                    <td class="tr_header" style="width: 180px" >Assigned Company <span class="required">*</span></td>
                    <td><?=$dd_company;?><input type="hidden" id="ddassign_comp_id" name="ddassign_comp_id" value="<?=$ddassign_comp_id;?>"/>
                    <input type="hidden" id="ss_assign_comp_id" name="ss_assign_comp_id" value="<?=$ddassign_comp_id?>">
                    </td>
                </tr>
                <tr>
                    <td class="tr_header">Assigned Organization <span class="required">*</span></td>
                    <td><?=$dd_org;?><input type="hidden" id="ddassign_org_id" name="ddassign_org_id" value="<?=$ddassign_org_id;?>"/>
                    <input type="hidden" id="ss_assign_org_id" name="ss_assign_org_id" value="<?=$ddassign_org_id;?>"/>
                    </td>                 
                <tr>
                    <td class="tr_header">Assigned Group<span class="required">*</span></td>
                    <td><?=$dd_grp;?><input type="hidden" id="ddassign_group_id" name="ddassign_group_id" value="<?=$ddassign_group_id;?>"/>
                    <input type="hidden" id="ss_assign_group_id" name="ss_assign_group_id" value="<?=$ddassign_group_id;?>"/>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header">Assigned Sub Grp<span class="required">*</span></td>
                    <td><?=$dd_subgrp;?><input type="hidden" id="ddassign_subgrp_id" name="ddassign_subgrp_id" value="<?=$ddassign_subgrp_id;?>"/>
                    <input type="hidden" id="ss_assign_subgrp_id" name="ss_assign_subgrp_id" value="<?=$ddassign_subgrp_id;?>"/>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header">Assignee</td>
                    <td><?=$dd_assign_assignee;?><input type="hidden" id="h_assign_assignee_id" name="h_assign_assignee_id" value="<?=$asm["assign_assignee_id"];?>"/>
                    <input type="hidden" id="ss_assign_assignee_id" name="ss_assign_assignee_id" value="<? if($asm["assign_assignee_id"]==0){echo "";}else {echo $asm["assign_assignee_id"];}?>"/>
                    </td>
                </tr>
            </table>
</div>
