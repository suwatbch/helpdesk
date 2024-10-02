<?php
   include_once "incident_identify.action.php";
   include_once "../../include/function.php";
?>
<script type="text/javascript" src="../../include/js/mulifile/jQuery.MultiFile.js"></script> 
<script type="text/javascript" language="javascript">
$('document').ready(function(){
    $('.blink').blink(); // default is 500ms blink interval.
});
$(function(){ // wait for document to load 
    $('#uploadfile_identify').MultiFile({ 
    list: '#show_file_identify'
    }); 
});
$(function(){
        $("img[alt=Delete]").live('click', function() {
            if (confirm_delete()){
                $(this).parent().parent().remove();
            }
        });
});
         
function getfile(){
        var getfile = "";
        $("#tblfile_identify tbody tr").each(function(){
            if (getfile != "") {
                getfile += ",";
            }
            getfile += $(this).attr("value");
        });
        return getfile;
}
function back_master(){
        <?
            $_SESSION["current_km"] = "incident_km/identify/index.php?action=incident_identify_list.php";
            
        ?>
            top.location.href= "../../home_km.php";
    }
(function($) {
    $.fn.blink = function(options) {
        var defaults = {
            delay: 500
        };
        var options = $.extend(defaults, options);

        return this.each(function() {
            var obj = $(this);
            setInterval(function() {
                if ($(obj).css("visibility") == "visible") {
                    $(obj).css('visibility', 'hidden');
                }
                else {
                    $(obj).css('visibility', 'visible');
                }
            }, options.delay);
        });
    }
}(jQuery)) 
</script>
<script type="text/javascript">
$('document').ready(function(){
$('a.delete_file_identify').click(function(){
if (confirm("Are you sure to delete")){
var del_id = $(this).parent().parent().attr('id');
var parent = $(this).parent().parent();
$.post('delete_file_identify.php', {id:del_id},function(data){
parent.fadeOut('fast', function() {$(this).remove();});
});
}
});
});
///////////////////////////////////////dropdown///////////////////////////////
 $(document).ready(function () {  
        $("#cus_company_id").change(function(){
           var cus_company_id = $(this).val();
           $.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.incident_type.php",
                data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
                success: function(response){
                    $("#ident_type_id").replaceWith(response);    
					//document.getElementById("ident_type_id").innerHTML =respone;
                }
            });
            
            $.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.project.php",
                data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
                success: function(response){
                    $("#project_id").replaceWith(response);    
                }
            });
            
            $.ajax({
                type: "GET",
                url: "../../master_data/common/dropdown_prd_tier1.php",
                data: "cus_comp_id=" + cus_company_id,
                success: function(respone){
                  //alert(respone);
                   document.getElementById("cas_prd_tier_id1").innerHTML =respone;
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.prd_tier2.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
                success: function(respone){;
                    //alert(respone);
                    document.getElementById("cas_prd_tier_id2").innerHTML =respone;
                }
            });
            
            $.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.prd_tier3.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cas_prd_tier_id2=" + cas_prd_tier_id2 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
                success: function(respone){
					//alert(respone);
					document.getElementById("cas_prd_tier_id3").innerHTML =respone;
                }
            });

          
            $.ajax({
                type: "GET",
                url: "../../master_data/common/dropdown_opr_tier1.php",
                data: "cus_comp_id=" + cus_company_id,
                success: function(respone){
                   // alert(respone);
                   document.getElementById("cas_opr_tier_id1").innerHTML =respone;
                }
            }); 
            
            $.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.opr_tier2.php",
                data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
                success: function(response){
                    //alert(response);
                    document.getElementById("cas_opr_tier_id2").innerHTML =response;
                }
            });
            
            $.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.opr_tier3.php",
                data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2 + "&cus_company_id=" + cus_company_id + "&attr=style=\"width: 100%;\"",
                success: function(respone){
                    //alert(respone);
                    document.getElementById("cas_opr_tier_id3").innerHTML =respone;
                }
            });
            
        });

//In active on change cas_opr_tier_id1
		$("#cas_opr_tier_id1").change(function(){
			//alert("1234");
            var cas_opr_tier_id1 = $(this).val();
            var cus_company_id = $("#cus_company_id").val();
            
			$.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.opr_tier2.php",
                data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
                success: function(response){
                    //alert(response);
                    document.getElementById("cas_opr_tier_id2").innerHTML =response;
                }
            });
			
            var cas_opr_tier_id2 = $(this).val();
            var cas_opr_tier_id1 = $("#cas_opr_tier_id1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cas_opr_tier_id2);
			$.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.opr_tier3.php",
                data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2  + "&cus_company_id=" + cus_company_id + "&attr=style=\"width: 100%;\"",
                success: function(respone){
                    //alert(respone);
                    //$("#cas_opr_tier_id3").replaceWith(respone);
                    document.getElementById("cas_opr_tier_id3").innerHTML =respone;
                }
            });
        });
		
		//In active on change cas_opr_tier_id2
		$("#cas_opr_tier_id2").change(function(){
               
            var cas_opr_tier_id2 = $(this).val();
            var cas_opr_tier_id1 = $("#cas_opr_tier_id1").val();
            var cus_company_id = $("#cus_company_id").val();
			$.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.opr_tier3.php",
                data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2 + "&cus_company_id=" + cus_company_id + "&attr=style=\"width: 100%;\"",
                success: function(respone){
                    //alert(respone);
                    //$("#cas_opr_tier_id3").replaceWith(respone);
                    document.getElementById("cas_opr_tier_id3").innerHTML =respone;
                }
            });
        });

        //In active on change cas_prd_tier_id1
		$("#cas_prd_tier_id1").change(function(){
            var cas_prd_tier_id1 = $(this).val();
            var cus_company_id = $("#cus_company_id").val();
            //var cas_opr_tier_id2 = $("#cas_opr_tier_id2").val();
            //alert(cas_opr_tier_id2);
            
			$.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.prd_tier2.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
                success: function(respone){
                    //$("#cas_opr_tier_id2").replaceWith(respone);
					//alert(respone);
					document.getElementById("cas_prd_tier_id2").innerHTML =respone;
                }
            });
            var cas_prd_tier_id2 = $(this).val();
            var cas_prd_tier_id1 = $("#cas_prd_tier_id1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cas_prd_tier_id1);
            //alert(cas_prd_tier_id2);
			$.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.prd_tier3.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cas_prd_tier_id2=" + cas_prd_tier_id2 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
                success: function(respone){
                    //$("#cas_opr_tier_id2").replaceWith(respone);
					//alert(respone);
					document.getElementById("cas_prd_tier_id3").innerHTML =respone;
                }
            });
			
        });
		
		//In active on change cas_prd_tier_id2
		$("#cas_prd_tier_id2").change(function(){
            var cas_prd_tier_id2 = $(this).val();
            var cas_prd_tier_id1 = $("#cas_prd_tier_id1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cas_prd_tier_id1);
            //alert(cas_prd_tier_id2);
			$.ajax({
                type: "GET",
                url: "../../incident/manage_incident/dropdown.prd_tier3.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cas_prd_tier_id2=" + cas_prd_tier_id2 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
				success: function(respone){
					//$("#cas_opr_tier_id2").replaceWith(respone);
					//alert(respone);
					document.getElementById("cas_prd_tier_id3").innerHTML =respone;
                }
            });
        });  
});

$(function(){
        $("#save_draft").click(function(){
            if (validate_identify()){
                $("#getfile_name").val(getfile());
                page_submit("index.php?action=incident_identify.php&km_release=N", "save")
            }
        });
        $("#save_release").click(function(){
            if (validate_identify()){
                $("#getfile_name").val(getfile());
                page_submit("index.php?action=incident_identify.php&km_release=Y", "save")
            }
        });

        $("#undo").click(function(){
            page_submit("index.php?action=incident_identify.php&action_master=1");
        });

        $("#cancel").click(function(){
            page_submit("index.php?action=incident_identify_list.php");
        });
    });

function validate_identify(){
         if($("#summary").val() == ""){
            jAlert('error', 'Please input summary', 'Helpdesk System : Messages');
            $("#summary").focus();
            return false; 
        }
        else if($("#detail").val() == ""){
            jAlert('error', 'Please input detail', 'Helpdesk System : Messages');
            $("#detail").focus();
            return false;
        }
        else if($('#cus_company_id').val() == "") {
                        jAlert('error', 'Please input Customer Company', 'Helpdesk System : Messages');
                        $("#cus_company_id").focus();
                        return false;
                }
        else if($("#ident_type_id").val() == ""){
                        jAlert('error', 'Please input incident type', 'Helpdesk System : Messages');
			$("#ident_type_id").focus();
			return false;   
		}else if($("#project_id").val() == ""){
                        jAlert('error', 'Please input project', 'Helpdesk System : Messages');
			$("#project_id").focus();
			return false;  
		}
        else if($("#cas_prd_tier_id1").val() == ""){
                        jAlert('error', 'Please input Product class1', 'Helpdesk System : Messages');
			$("#cas_prd_tier_id1").focus();
			return false;  
		}else if($("#cas_prd_tier_id2").val() == ""){
                        jAlert('error', 'Please input Product class2', 'Helpdesk System : Messages');
			$("#cas_prd_tier_id2").focus();
			return false;  
		}else if($("#cas_prd_tier_id3").val() == ""){
                        jAlert('error', 'Please input Product class3', 'Helpdesk System : Messages');
			$("#cas_prd_tier_id3").focus();
			return false;  
		}else if($("#cas_opr_tier_id1").val() == ""){
                        jAlert('error', 'Please input Operational class1', 'Helpdesk System : Messages');
			$("#cas_opr_tier_id1").focus();
			return false; 
		}else if($("#cas_opr_tier_id2").val() == ""){
                        jAlert('error', 'Please input Operational class2', 'Helpdesk System : Messages');
			$("#cas_opr_tier_id2").focus();
			return false; 
		}else if($('#cas_opr_tier_id3 > option[value!=""]').length != 0 && $("#cas_opr_tier_id3").val() == "") {
                        jAlert('error', 'Please input Operational class3', 'Helpdesk System : Messages');
                        return false;
                }else if($("#resolution").val() == ""){
                        jAlert('error', 'Please input resolution', 'Helpdesk System : Messages');
			$("#resolution").focus();
			return false; 
		}else if($("#km_keywords").val() == ""){
                        jAlert('error', 'Please input km keywords', 'Helpdesk System : Messages');
			$("#km_keywords").focus();
			return false; 
		}else{
			return true;
		}
}

</script>
<div style="height : 550px; overflow-y: auto;" >
<table width="100%" border="0" cellpadding="0" cellspacing="1" align="center">
     <tr>
         <td valign="top" style="border-right: #D4D6D6 solid thin; border-width:2px;" width="47%">
             <table width="100%" border="0" cellpadding="0" cellspacing="6" >
                 <? if($identify_km["id"]!= ""){ ?>
                 <tr>
                    <td><span class="styleBlue">INCIDENT ID</span></td>
                    <td style="font-size:20px; color: #990000;" align="left"><?=$identify_km["ident_id_run_project"];?>
                 </tr>
                 <? }?>
                 <tr>
                     <? if($identify_km["km_no"]!= ""){ ?>
                 <tr>
                    <td><span class="styleBlue">KM ID</span></td>
                    <td style="font-size:20px; color: #990000;" align="left"><?=$identify_km["km_no"];?>
                 </tr>
                 <? }?>
                 <tr>
            <td class="tr_header1">Summarize <span class="required">*</span></td>
            <td align="left"><textarea name="summary" id="summary" style="height: 70px;"><?=htmlspecialchars($identify_km["summary"])?></textarea></td>
            </tr>
          <tr>
            <td class="tr_header1">Detail <span class="required">*</span></td>
            <td align="left"><textarea name="detail" id="detail"  style="height: 100px;"><?=htmlspecialchars($identify_km["notes"])?></textarea></td>
          </tr>
          <tr>
            <td class="tr_header1">Customer Company <span class="required">*</span></td>
            <td><?=$dd_company_cus;?></td>
        </tr>
        <tr>
                    <td class="tr_header1">Incident type <span class="required">*</span></td>
                    <td>
                        <?=$dd_incident_type;?>
                    </td>  
                </tr>
                <tr>
                   <td class="tr_header1" >Project <span class="required">*</span></td>
                    <td><?=$dd_project;?></td>
                    
                </tr>
          <tr style="height: 30px">
                    <td colspan="2"  ><span class="styleGray">PRODUCT CATEGORIZATION</span></td>
                </tr>
                <tr>
                    <td class="tr_header1" >Class 1 <span class="required">*</span></td>
                    <td>
                        <?=$dd_prd_tier1;?>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header1"  >Class 2 <span class="required">*</span></td>
                    <td>
                        <?=$dd_prd_tier2;?>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header1" >Class 3 <span class="required">*</span></span></td>
                    <td>
                        <?=$dd_prd_tier3;?>
                    </td>
                </tr>
                <tr style="height: 30px">
                    <td colspan="2"><span class="styleGray">OPERATIONAL CATEGORIZATION</span></td>
                </tr>
                <tr>
                    <td class="tr_header1" >Class 1 <span class="required">*</span></td>
                    <td>
                        <?=$dd_opr_tier1;?>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header1" >Class 2 <span class="required">*</span></td>
                    <td>
                        <?=$dd_opr_tier2;?>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header1"  >Class 3</td>
                    <td>
                        <?=$dd_opr_tier3;?>
                    </td>
                </tr>
                <tr>
                <td class="tr_header1">KM By</td>
                    <td >
                    <input type="text" name="create_by" id="create_by" value="<?=$identify_km["resloved_name"];?>" readonly class="disabled" readonly style="width: 100%;"/>
                </td>
                </tr>
                <tr>
        <td class="tr_header1">Incident Reference</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=$identify_km['ident_id_run_project']?>"/></td>
    </tr>
             </table>
         </td>
         <td valign="top" width="53%">
             <table width="100%" border="0" cellpadding="0" cellspacing="3" align="center">
                <tr>
                    <td class="tr_header1">Resolution <span class="required">*</span></td>
                    <td>
                        <textarea name="resolution" id="resolution"  style="width: 100%px; height: 80px;"><?=htmlspecialchars($identify_km["resolution"])?></textarea>
                    </td>
                </tr>
                <tr>
                   <td class="tr_header1">Attach File</td>
                    <td>
                        <input type="file" id="uploadfile_identify" name="uploadfile_identify[]"/>
                            <div id="show_file_identify" style="border:#999 solid 3px; padding:10px;">
                            </div>
                    </td>  
                </tr>
                <tr><td colspan="2">
                        <table width="100%" border="0" cellpadding="0" cellspacing="1" align="center">
                <tr style="height: 30px">
                    <td><span class="styleGray">&nbsp;&nbsp;Attachment</span></td>
                </tr>
                <tr>
                    <td>
<div style="overflow: auto;">
   <table width="100%" cellpadding="0" cellspacing="1" class="data-table" border="0" id ="tblfile_identify">
    
    <thead>
        <tr>
            <td align="center">Name File</td>
            <td width="20%" align="center">User</td>
            <td width="20%" align="center">Date</td>
            <td width="5%" align="center">Delete</td>
        </tr>
    </thead>
    <tbody>
    <?php
	
   if (count($identify_km["file_resolution"]) > 0){
                    foreach ($identify_km["file_resolution"] as $fetch_file) {
?>
        <tr id="<?=$fetch_file["attach_id"]?>" value="<?=$fetch_file["location_name"]."|".$fetch_file["attach_name"]?>">
            <? if($fetch_file["incident_id"] != 0){ ?>
            <td align="left"><a href="../../upload/temp_inc_reslove/<?=$fetch_file["location_name"]?>" target="_blank"><?=htmlspecialchars($fetch_file["attach_name"])?></a></td>
            <? }else{ ?>
            <td align="left"><a href="../../incident_km/temp_identify/<?=$fetch_file["location_name"]?>" target="_blank"><?=htmlspecialchars($fetch_file["attach_name"])?></a></td>
            <? } ?>
            <td align="center"><?=$fetch_file["first_name"]." ".$fetch_file["last_name"]?></td>
            <td align="center"><?=dateUtil::date_dmyhms2($fetch_file["attach_date"])?></td>
            <? if($fetch_file["incident_id"] != 0){?>
            <td width="8%" align="center"><img src="../../images/close_inline.png" alt="Delete" style="cursor: pointer;"/></td>
            <? }else {?>
            <td align="center" ><a href="javascript:return(0);" class="delete_file_identify"><img src="../../images/error.png" height="12px" width="12px"/></a></td>
            <? } ?>
        </tr>
    <?
	 }  
}  ?>
 
    </tbody>
</table>
</div>
		</td>
                </tr>
          <tr style="height: 45px">
                    <td style="width: 180px" ></td>
                </tr>
      </table>
                    </td></tr>
                <tr>
                   
                    <td class="tr_header1"><span class="styleBlue">KM Keyword</span><span class="required"> *</span></span></td>
                    <td>
                        <textarea name="km_keywords" id="km_keywords"  style="width: 100%px; height: 90px;"><?=htmlspecialchars($identify_km["km_keyword"])?></textarea>
                    </td>
                  
                </tr>
                <tr><td colspan="2"><p class="blink" style="color: red;">Separate Keyword with comma(,)</p></td></tr>
                <? if($identify_km["km_id"]!= ""){ ?>
                 <tr>
        <td class="tr_header1">Create By</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly value="<?=$identify_km["created_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header1">Create Date</td>
        <td><input type="text" style="width: 100%;" class="disabled" readonly  value="<?=date("d/m/Y H:i:s",strtotime($identify_km["create_date"]))?>"/></td>
    </tr>
    <tr>
        <td class="tr_header1">Modified By</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=$identify_km["modified_name"]?>"/></td>
    </tr>
    <tr>
        <td class="tr_header1">Modified Date</td>
        <td><input type="text" class="disabled" readonly style="width: 100%;" value="<?=date("d/m/Y H:i:s",strtotime($identify_km["modified_date"]))?>"/></td>
    </tr>
    <? } ?>
    
             </table>
         </td>
     </tr>
</table>
<input type="hidden" id="s_incident_id" name="s_incident_id" value="<?=$identify_km["id"]?>">
<input type="hidden" id="s_km_id" name="s_km_id" value="<?=$identify_km["km_id"]?>">
<input type="hidden" id="getfile_name" name="getfile_name" value="">
<input type="hidden" id="km_no" name="km_no" value="<?=$identify_km["km_no"]?>">
</div>