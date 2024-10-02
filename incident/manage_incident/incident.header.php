<script type="text/javascript" src="../../dialog/dialog.ui.js"></script>
<script type="text/javascript">
function dialog_onSelected_cus(lookuptype, obj){

        if (lookuptype == "cus_id"){

            if($("#s_km_id").val()!="" && obj != null){
                page_submit("index.php?action=incident.php&cusid="+ obj.code_cus + "&cus_company_id=" + obj.cus_company_id, "get_new_incident");
            }else if ($("#s_km_id").val()=="" && obj !=  null){
                $("#s_cus_id").val(obj.code_cus);
                $("#cus_id").val(obj.code_cus);
                $("#cus_firstname").val(obj.cus_firstname);
                $("#cus_lastname").val(obj.cus_lastname);
                $("#cus_phone").val(obj.cus_phone);
                $("#cus_company").val(obj.cus_company);
                $("#cus_ipaddress").val(obj.cus_ipaddress);
                $("#cus_email").val(obj.cus_email);
                $("#cus_company_id").val(obj.cus_company_id);
                $("#cus_organize").val(obj.cus_org_name);
                $("#cus_area").val(obj.cus_area);
				$("#cus_area_name").val(obj.cus_area_name);
                $("#cus_office").val(obj.cus_office);
                $("#cus_department").val(obj.cus_department);
                $("#cus_site").val(obj.cus_site);
                $("#s_t_code_cus").val(obj.code_cus);
                $("#customer_id").val(obj.code_cus);

				
        get_dropdown_ident_type();
		get_dropdown_project();
		get_dropdown_opr_tier1();
		get_dropdown_prd_tier1();
		get_dropdown_opr_tier1_resol();
		get_dropdown_prd_tier1_resol();
            }
            
           $("#dialog-customer").dialog("close");
        }
    }
</script>
<script>
    //////////km ref/////////////////////////////
$(document).ready(function(){
  $("#km_entrant").change(function(){
    if($(this).is(":checked")){
        $("#show_keyword").css("display", "");
       $("#km_keyword").removeAttr("disabled");
    }
    else{
        $("#show_keyword").css("display", "none");
       $("#km_keyword").attr("disabled" , "disabled");
    }
});
////////km ref////
    $("#km_process").click(function(){
        if($("#cus_id").val() == ""){
            jAlert('error', 'Please input Customer ID', 'Helpdesk System : Messages');
                $("#cus_id").focus();
                return false;
        }else if($("#s_cus_id").val() == ""){
            jAlert('error', 'Please input Customer ID', 'Helpdesk System : Messages');
                $("#s_cus_id").focus();
                return false;
        }
        else if($("#txt_summary").val() == "" && $("#txt_notes").val() == ""){
            jAlert('error', 'Please input Summarize or Detail', 'Helpdesk System : Messages');
                $("#txt_summary").focus();
                return false;
        }
//        else if($("#ident_type_id").val() == ""){
//                        jAlert('error', 'Cassification Tab: Please input incident type', 'Helpdesk System : Messages');
//			$("#ident_type_id").focus();
//			return false;   
//		}
//                else if($("#project_id").val() == ""){
//                        jAlert('error', 'Cassification Tab: Please input project', 'Helpdesk System : Messages');
//			$("#project_id").focus();
//			return false;  
//		}else if($("#cas_prd_tier_id1").val() == ""){
//                        jAlert('error', 'Cassification Tab: Please input Product class1', 'Helpdesk System : Messages');
//			$("#cas_prd_tier_id1").focus();
//			return false;  
//		}else if($("#cas_prd_tier_id2").val() == ""){
//                        jAlert('error', 'Cassification Tab: Please input Product class2', 'Helpdesk System : Messages');
//			$("#cas_prd_tier_id2").focus();
//			return false;  
//		}else if($("#cas_prd_tier_id3").val() == ""){
//                        jAlert('error', 'Cassification Tab: Please input Product class3', 'Helpdesk System : Messages');
//			$("#cas_prd_tier_id3").focus();
//			return false;  
//		}
//                else if($("#cas_opr_tier_id1").val() == ""){
//                        jAlert('error', 'Cassification Tab: Please input Operational class1', 'Helpdesk System : Messages');
//			$("#cas_opr_tier_id1").focus();
//			return false; 
//		}else if($("#cas_opr_tier_id2").val() == ""){
//                        jAlert('error', 'Cassification Tab: Please input Operational class2', 'Helpdesk System : Messages');
//			$("#cas_opr_tier_id2").focus();
//			return false; 
//		}else if($('#cas_opr_tier_id3 > option[value!=""]').length != 0 && $("#cas_opr_tier_id3").val() == "") {
//                        jAlert('error', 'Cassification Tab: Please input Operational class3', 'Helpdesk System : Messages');
//                        return false;
//                }
               else{
                   
            $("#ifr_km_process").attr("src", "../../incident_km/km_base/km_base_list.php?cus_company_id = "+ $("#cus_company_id").val() + 
                "&text_summary=" + $("#txt_summary").val() + "&txt_notes=" + $("#txt_notes").val());
                //"&ident_type_id=" + $("#ident_type_id").val() + 
               // "&project_id=" + $("#project_id").val() + "&cas_prd_tier_id1=" + $("#cas_prd_tier_id1").val() +
                //"&cas_prd_tier_id2=" + $("#cas_prd_tier_id2").val() + "&cas_prd_tier_id3=" + $("#cas_prd_tier_id3").val());
               // "&cas_opr_tier_id1=" + $("#cas_opr_tier_id1").val() + "&cas_opr_tier_id2=" + $("#cas_opr_tier_id2").val() +
                //"&cas_opr_tier_id3=" + $("#cas_opr_tier_id3").val());
            $("#dialog-km_process").dialog("open");
        }
    });
});
 function copy_to_km(km_id){
       page_submit("index.php?action=incident.php&km_id="+ km_id + "&cusid=" + $("#s_cus_id").val(), "");
       $("#ifr-km_process").attr("src", "blank.php");
       $("#dialog-km_process").dialog("close");
    }
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="5">
        <!--<tr><td colspan="5" style="line-height:10px;">&nbsp;</td></tr>
        <tr>
            <td colspan="5"><b>Incident Request Information</b><br></td>
        </tr>-->
		<? if(strUtil::isEmpty($incident["id"])){ ?>
            <tr>
                <td class="tr_header1" style="width: 30%;">Customer ID <span class="required">*</span></td>
                <td align="left">
                <input type="text" name="cus_id" id="cus_id" style="width: 90%; margin-right: 3px;" maxlength="150" description="Tab Customer:cus code" value="<?=$t_code_cus;?><?=$incident["cus_id"]; ?><?=$_REQUEST["cus_id"];?>" onkeypress="showCostomer(event, this);"/><img id="btn_cus_id" src="../../images/find.png" alt="Find Customer" align="absmiddle" style="cursor: pointer;"/>
<!--                    <input type="text" name="cus_id" id="cus_id"  maxlength="20" required="true" description="Tab Customer:cus code" value="<?=$t_code_cus;?><?=$incident["cus_id"]; ?>" onkeypress="showCostomer(event, this);"/>-->
                </td>
            </tr>
		<?  }else{ ?>
		<tr style="height: 30px">
                <td><span class="styleBlue">INCIDENT ID</span></td>
                <td style="font-size:20px; color: #990000;" align="left"><div id="tmpProjectId"></div><?=$incident["ident_id_run_project"];?>
                <td style="font-size:20px; color: #990000;" align="left">

                <input type="hidden" id="ss_ident_id_run_project" name="ss_ident_id_run_project" value="<?=$incident["ident_id_run_project"];?>">
                </td>    
            </tr>
		<? 	}  
                if(strUtil::isEmpty($incident["status_id"]) || $incident["status_id"] == 5){ ?>
            <tr>
                <td>&nbsp;</td>
                <td align="left">
                    <? if(strUtil::isEmpty($incident["status_id"]) && $km_id == ""){?>
                    <img id="km_process" name="km_process" alt="km_process" src="../../images/km_process.png" style="cursor: pointer;">
                    <? }else if($incident["status_id"] == 5 && $km_id == ""){ ?>
                    <input type="checkbox"  id="km_entrant" name="km_entrant" value="Y" <? if($incident["km_entrant"]== 'Y'){ echo "checked ";} if($incident["km_release"]=="N" || $incident["km_release"] == "Y"){echo "disabled";} ?> style="margin: 0px 0px;width: 25px;"><span class="styleBlue">Entrance to KM</span>
                    <? } ?>
                </td>
            </tr>
            <? } ?>
            <tr>
            <td class="tr_header1">Summarize <span class="required">*</span></td>
            <td align="left"><textarea name="txt_summary" id="txt_summary" required="required"  description="txt_summary" maxlength="300" style="height: 120px;"><?=htmlspecialchars($incident["summary"])?></textarea></td>
            </tr>
          <tr>
            <td class="tr_header1">Detail <span class="required">*</span></td>
            <td align="left"><textarea name="txt_notes" id="txt_notes"  style="height: 150px;"><?=htmlspecialchars($incident["notes"])?></textarea></td>
          </tr>
          <tr>
          	<td class="tr_header1">Status <span class="required">*</span></td>
            <td align="left">
			<?php
				if($incident["id"]!="" || $incident["s_km_id"]!= ""){ 
					echo $dd_status; 
				}else{ 
			?>
                <select id="ddstatus_id" name="ddstatus_id" required="true" class="select_dis" disabled style="width:100%;">
                    <option value="1" selected>New</option>
                </select><input type="hidden" id="status_id" name="status_id" value="1"/>
            <?php } ?>
                <input type="hidden" id="h_status_idOld" name="h_status_idOld" value="<?=$incident["status_id"];?>"/>
            </td>
          </tr>
          <tr>
          	<td class="tr_header1">Status Reason</td>
            <td align="left"><?=$dd_Status_res;?></td>
          </tr>
          <tr>
          	<td class="tr_header1">Priority <span class="required">*</span></td>
            <td align="left"><?=$dd_priority?></td>

          </tr>
          <tr>
          	<td class="tr_header1">Reference No.</td>
            <td align="left"><input type="text" id="reference" name="reference_no" value="<?=$incident["reference_no"];?>"></td>
          </tr>
          
          <tr>
	<td colspan="2"><br>
                    <div width="100%" style="background-color: #C0D9EA;" align="center">
                        <br><br>
                        <?if($incident["status_id"] != 7){?>
                        <img id="save" src="../../images/head_d/06.jpg" style="cursor: pointer;">&nbsp;&nbsp;&nbsp;&nbsp;
                        <? } ?>
                        <img id="back" src="../../images/head_d/07.jpg" style="cursor: pointer;">
                        <input type="hidden" name="mode_back" id="mode_back" value="<?=$_GET["mode"];?>">
                        <br><br>
                    </div> 
                </td>
</tr>

    </table>
 <input type="hidden" id="s_status_id" name="s_status_id" value="<?=$incident["status_id"];?>"/>
 <div id="dialog-customer" title="Customer">
    <iframe id="ifr_cus_id" frameborder="0" scrolling="no" width="100%" height="100%" src=""></iframe>
</div>
  <div id="dialog-km_process" title="Knowledge Management Base">
    <iframe id="ifr_km_process" frameborder="0" scrolling="no" width="100%" height="100%" src=""></iframe>
</div>
<script>
    ///////////km ref/////////////////
$(document).ready(function(){
    if($("#km_entrant").is(":checked")){
        $("#show_keyword").css("display", "");
       $("#km_keyword").removeAttr("disabled");
    }
    else{
        $("#show_keyword").css("display", "none");
       $("#km_keyword").attr("disabled" , "disabled");
    }

    //Add by Uthen 18-4-2016
    var tmpPriorityBefore = $("#priority_id").val();
    sessionStorage.setItem("tmpPriorityBefore",tmpPriorityBefore);
    //console.log("incident.header.php->Priority Id: "+tmpPriorityBefore);
});
</script>
<?php
#add by Uthen
echo '<script type="text/javascript">
                            var idRunProject = "'.$incident["ident_id_run_project"].'";
                            sessionStorage.setItem("tmpProjectId",idRunProject);
                            //console.log("incident.header.php->Project Id: "+idRunProject);
    </script>';
#end add
?>