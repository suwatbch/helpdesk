<?php
//echo $incident["assigned_date"];
//echo "<br>";
//echo $incident["working_date"];
if(dateUtil::date_dmyhms2($incident["working_date"])){
    //Commented by Uthen.P for change Crate Date---> Assigned
    //$RespondedDays = dateUtil::date_diff2($incident["assigned_date"], $incident["working_date"]);
    $RespondedDays = dateUtil::date_diff2($incident["create_date"],$incident["working_date"]);
}
if(dateUtil::date_dmyhms2($incident["resolved_date"])){
    //Commented by Uthen.P for change [Assigned Date] ---> [Resolved]
    //$ResolvedDays = dateUtil::date_diff2($incident["working_date"], $incident["resolved_date"]);
    $ResolvedDays = dateUtil::date_diff2($incident["assigned_date"], $incident["resolved_date"]);

    // $slaResolvedDays = dateUtil::sec_to_time_desc($incident["resolved_days"]);
    // $slaResolvedPendingDays = dateUtil::sec_to_time_desc($incident["resolved_pending"]);
    // $slaResolvedWorkDays = dateUtil::sec_to_time_desc($incident["resolved_days"] - $incident["resolved_pending"]);

    // $slaResolvedDays_byworking = dateUtil::sec_to_time_byworking_sec($incident["resolved_days"],$incident["sla_working_sec"]);
    // $slaResolvedPendingDays_byworking = dateUtil::sec_to_time_byworking_sec($incident["resolved_pending"],$incident["sla_working_sec"]);
    // $slaResolvedWorkDays_byworking = dateUtil::sec_to_time_byworking_sec($incident["resolved_days"] - $incident["resolved_pending"],$incident["sla_working_sec"]);

    $totalActualWorkingSec = dateUtil::sec_to_time_desc($incident["tot_actual_working_sec"]);
    $totalActualPendingSec = dateUtil::sec_to_time_desc($incident["tot_actual_pending_sec"]);

}
if(dateUtil::date_dmyhms2($incident["closed_date"])){
	$IncidentAge = dateUtil::date_diff2($incident["create_date"], $incident["closed_date"]);
}else{
	$today = dateUtil::get_today_datetime_1();
	$IncidentAge = dateUtil::date_diff2($incident["create_date"], $today);
}
////////////////////////////////km reference/////////////////
if($incident["s_km_id"]!=""){
    $incident["create_date"] = date("Y-m-d H:i:s");
    $incident["assigned_date"] = date("Y-m-d H:i:s");
    $incident["working_date"] = date("Y-m-d H:i:s");
   // $incident["resolved_date"] =date("Y-m-d H:i:s");
    $incident["last_modify_date"] = date("Y-m-d H:i:s");
    $incident["first_name2"] = user_session::get_first_name();
    $incident["last_name2"] = user_session::get_last_name();
    $incident["owner_company_name"] = user_session::get_user_company_name();
    $incident["owner_comp_id"] = user_session::get_user_company_id();
    $incident["owner_org_name"] = user_session::get_user_org_name();
    $incident["owner_org_id"] = user_session::get_user_org_id();       
    $incident["owner_grp_id"] = user_session::get_user_grp_id();
    $incident["owner_grp_name"] = user_session::get_user_grp_name();
    $incident["owner_subgrp_id"] = user_session::get_user_subgrp_id();
    $incident["owner_subgrp_name"] = user_session::get_user_subgrp_name();
    $incident["owner_user_id"] = user_session::get_user_id();
    $incident["first_name"] = user_session::get_first_name();
    $incident["last_name"] = user_session::get_last_name();
}
?>
<input type="hidden" id="h_propose_closed_date" name="h_propose_closed_date" value="<?=$incident["propose_closed_date"];?>"/>
<input type="hidden" id="h_closed_date" name="h_closed_date" value="<?=$incident["closed_date"];?>"/>
<div style="overflow-y: auto;">
<br>
 <table width="98%" border="0" cellpadding="0" cellspacing="1" align="center">
     <tr>
         <td valign="top" style="border-right: #D4D6D6 solid thin; border-width:2px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="1" >
                <tr style="height: 30px">
                    <td colspan="2">
                         <span class="styleBlue">DATE</span><span class="styleGray"> INFORMATION</span>
                    </td>
                </tr>
			</table>
			<table width="96%" border="0" cellpadding="0" cellspacing="3" align="center">
                <tr>
                    <td class="tr_header">Created Date</td>
                    <td ><input type="text" name="create_date"  maxlength="50" readonly class="disabled" description="Datesystem Tab: Create Date" value="<?=dateUtil::date_dmyhms2($incident["create_date"])?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Assigned Date </td>
                    <td><input type="text" name="assigned_date" maxlength="50" readonly class="disabled" description="Datesystem Tab: Assigned Date" value="<?=dateUtil::date_dmyhms2($incident["assigned_date"])?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Working Date</td>
                    <td><input type="text" name="working_date"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Working Date" value="<?=dateUtil::date_dmyhms2($incident["working_date"])?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Resolved Date</td>
                    <td><input type="text" name="resolved_date"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Resolved Date" value="<?=dateUtil::date_dmyhms2($incident["resolved_date"])?>"/></td>
                </tr>
				<!-- Comment by Uthen.P
                <tr>					
                    <td class="tr_header">Porpose closed Date</td>
                    <td><input type="text" id="proposeclosed_date" name="proposeclosed_date" s maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Closed Date" value="<?=dateUtil::date_dmyhms2($incident["propose_closed_date"])?>"/></td>
                </tr>
				-->
                <tr>
                    <td class="tr_header">Closed Date</td>
                    <td><input type="text" name="closed_date"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Closed Date" value="<?=dateUtil::date_dmyhms2($incident["closed_date"])?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Responded Days</td>
                    <td><input type="text" name="responded_days"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Responded days" value="<?=$RespondedDays?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Resolved Days</td>
                    <td><input type="text" name="resolved_days"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Resolved Days" value="<?=$ResolvedDays?>"/></td>    
                </tr>
    
                <tr><td>&nbsp;</td></tr>
                <!-- <tr>
                    <td class="tr_header"> SLA Resolved days </td>
                    <td><input type="text" name="resolved_sla_days"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Resolved Days" value="<?=$slaResolvedDays_byworking?>"/></td>    
                </tr>
                <tr>
                    <td class="tr_header"> SLA Resolved pending days</td>
                    <td><input type="text" name="resolved_sla_days"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Resolved Days" value="<?=$slaResolvedPendingDays_byworking?>"/></td>    
                </tr>
                <tr>
                    <td class="tr_header"> SLA Resolved working days</td>
                    <td><input type="text" name="resolved_sla_days"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Resolved Days" value="<?=$slaResolvedWorkDays_byworking?>"/></td>    
                </tr> -->

                <tr>
                    <td class="tr_header"> Actual work days </td>
                    <td><input type="text" name="resolved_sla_days"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Resolved Days" value="<?=$totalActualWorkingSec?>"/></td>    
                </tr>

                <tr>
                    <td class="tr_header"> Actual pending days </td>
                    <td><input type="text" name="resolved_sla_days"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: Resolved Days" value="<?=$totalActualPendingSec?>"/></td>    
                </tr>

                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td class="tr_header">Incident Age (Days)</td>
                    <td><input type="text" name="incident_age"  maxlength="50" readonly="readonly" class="disabled" description="Datesystem Tab: incident_age" value="<?=$IncidentAge?>"/></td>    
                </tr>
				<tr><td>&nbsp;</td></tr>
                <tr>
                    <td class="tr_header">Last modified By</td>
                    <td><input type="text" name="last_modify_by"  maxlength="50" readonly class="disabled" description="Datesystem Tab: Last modified By" value="<?=$incident["first_name2"]." ".$incident["last_name2"]?>"/></td>
                </tr>
                <tr>
                    <td class="tr_header">Last modified Date</td>
                    <td><input type="text" name="last_modify_date"  maxlength="50" readonly class="disabled" description="Datesystem Tab: Last Modify_date" value="<?=dateUtil::date_dmyhms2($incident["last_modify_date"])?>"/></td>
                </tr>
            </table>
         </td>
		 <td valign="top">
			<table width="96%" align="center" border="0" cellpadding="0" cellspacing="1">
                  <tr style="height: 30px">
                    <td colspan="2">
                         <span class="styleBlue">OWNER</span><span class="styleGray"> INFORMATION</span>
                    </td>
                </tr>
			</table>
			<table width="100%" align="center" border="0" cellpadding="0" cellspacing="3">
                 <tr>
                    <td class="tr_header">Owner Support Company </td>
                    <td><input type="text" name="owner_comp_id"  maxlength="50" readonly class="disabled" description="Owner company" value="<?=htmlspecialchars($incident["owner_company_name"])?>"/>
                    <input type="hidden" name="h_owner_comp_id" id="h_owner_comp_id"  maxlength="50" value="<?=htmlspecialchars($incident["owner_comp_id"])?>"/></td>
                 </tr>
                 <tr>
                    <td class="tr_header" style="width: 180px">Owner Support Org.</td>
                    <td><input type="text" name="owner_org_id"  maxlength="50" readonly class="disabled" description="Owner Organize" value="<?=htmlspecialchars($incident["owner_org_name"])?>"/>
                    <input type="hidden" name="h_owner_org_id"  maxlength="50" value="<?=htmlspecialchars($incident["owner_org_id"])?>"/></td>
                 </tr>
                 <tr>
                    <td class="tr_header">Owner Group </td>
                    <td><input type="text" name="owner_grp_id"  maxlength="50" readonly class="disabled" description="Owner Grp" value="<?=htmlspecialchars($incident["owner_grp_name"])?>"/>
                    <input type="hidden" name="h_owner_grp_id"  maxlength="50" value="<?=htmlspecialchars($incident["owner_grp_id"])?>"/></td>
                 </tr>
                 <tr>
                    <td class="tr_header">Owner Sub Grp </td>
                    <td><input type="text" name="owner_suborg_id"  maxlength="50" readonly class="disabled" description="Owner Sub Grp" value="<?=htmlspecialchars($incident["owner_subgrp_name"])?>"/>
                    <input type="hidden" name="h_owner_subgrp_id"  maxlength="50" value="<?=htmlspecialchars($incident["owner_subgrp_id"])?>"/></td>
                 </tr>
                 <tr>
                    <td class="tr_header">Owner </td>
                    <td><input type="text" name="owner_user_id"  maxlength="50" readonly class="disabled" description="Owner Assignee" value="<?=$incident["first_name"]." ".$incident["last_name"]?>"/>
                    <input type="hidden" name="h_owner_user_id"  maxlength="50" value="<?=htmlspecialchars($incident["owner_user_id"])?>"/></td>
                 </tr>
              </table>
		 </td>
     </tr>
 </table>
             
</div>