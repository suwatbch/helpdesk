<script type="text/javascript" src="../../dialog/dialog.ui.js"></script>
<script type="text/javascript" src="../../include/js/mulifile/jQuery.MultiFile.js"></script> 
<script type="text/javascript" language="javascript">
                              $(function(){ // wait for document to load 
                               $('#uploadfile_working').MultiFile({ 
                                list: '#show_file_working'
                               }); 
                              });
                              </script>
<script type="text/javascript">
function Showdialog_workinfo(workinfo_id){
	var workinfo_id = workinfo_id;
	if (workinfo_id == ""){
                jAlert('warning', 'Please input workinfo !!!', 'Helpdesk System : Messages');
                return;
        }
	//alert(workinfo_id);
	$("#ifr").attr("src", "../../dialog/helpdesk_workinfo.php?workinfo_id=" +workinfo_id);
        $("#dialog-display-workinfo").dialog("open");
	
}
</script>

<?php 

#Check Allow Tab Dropdown Object Required Field
//if(!$incident["id"]){ $dd_required = "";  }else{ $dd_required = 'required=\"true'; }  //exit();
if($incident["working_date"] != "0000-00-00 00:00:00"){
	$head_tbworkinfo = ".";
}

?>
<input type="hidden" id="h_working_date" name="h_working_date" value="<?=$incident["working_date"];?>"/>
<div style="overflow-y: auto;">
<br>
<table width="98%" border="0" cellpadding="0" cellspacing="3" >
<tr>
	<td valign="top">
    	<table width="98%" border="0" cellpadding="0" cellspacing="1" align="center">
                <tr style="height: 30px">
                    <td colspan="2">
                        <span class="styleBlue">WORK DETAIL</span><span class="styleGray"> INFORMATION</span>
                        
                    </td>
                </tr>
        </table>
        <table width="80%" border="0" cellpadding="0" cellspacing="3" align="center">
          <tr>
                    <td class="tr_header" width="40%">Work Detail <span class="required">*</span></td>
                    <td colspan="2">
                        <textarea name="workinfo_summary" id="workinfo_summary" <?=$dd_required;?> description="Tab Work Info: Summary" style="width: 100%; height: 70px;"><?=htmlspecialchars($incident["workinfo_summary"])?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header">Internal Notes </td>
                    <td colspan="2">
                      <textarea name="workinfo_notes" id="workinfo_notes" <?=$dd_required;?> maxlength="300" description="Tab Work Info: Notes" style="width: 100%; height: 40px;"><?=htmlspecialchars($access_group["workinfo_notes"])?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header" >Attach File</td>
                    <td>
                        <input type="file" id="uploadfile_working" name="uploadfile_working[]"/>
                            <div id="show_file_working" style="border:#999 solid 3px; padding:10px;">
                            </div>
                    </td>
<!--                    <td>
                        <div name="list_div" id="list_div" >
                                <select multiple name="file_list" id="file_list" size="4" style="width: 100%; height: 80px;"></select>
                        </div>
                        <div name="files_div" id="files_div" style="display: none">
                                <input type="file" name="userfile[]" id="file_0" size="30" onChange="javascript:add_file(this.value);" style="width: 180px">
                            <input type="hidden" name="hd_file_name[]" id="hd_file_name"/>
                        </div>
                    </td>
                    <td valign="top" width="2%">
						<img id="btnbrowse" src="../../images/head_d/18.jpg" style="cursor: pointer;"><br><br><br>
                        <img id="remove_file_btn" src="../../images/head_d/19.jpg" style="cursor: pointer;" onClick="javascript:remove_file();">
                    </td>-->
                </tr>
                
            </table>
    </td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="1" align="center">
                <tr style="height: 30px">
                    <td><span class="styleGray">&nbsp;&nbsp;WORK DETAIL HISTORY</span>
                    <?
                            if ($attach_cas == "Y"){
                                ?>
                        <span style="color: palevioletred; font-size: 10.5px; font-weight: bold;">( More attached files in Classification tab)</span>
                                <?
                            }
                        ?>
                    
                    </td>
                </tr>
                <tr>
                    <td>
<div style="overflow: auto;">
   <table id="workinfo_table" name="workinfo_table" width="100%" cellpadding="0" cellspacing="1" class="data-table">
    
    <thead>
        <tr>
            <td width="3%" align="center">View</td> 
            <td width="4%" align="center">Attach</td>
            <td width="24%" align="center">Work Detail</td>
            <td width="11%" align="center">User</td>
            <td width="11%" align="center">Date</td>
        </tr>
    </thead>
    <tbody>
    <?php
    if (count($incident["Workinfo"]) > 0){
                    $index = 1;
                    foreach ($incident["Workinfo"] as $wif) {
                        $count_work = strlen($wif["workinfo_summary"]);
                        if($count_work > 50){
                            $sub_workinfo_summary = iconv_substr($wif["workinfo_summary"], 0, 71, "UTF-8")."...";
                        }else{
                            $sub_workinfo_summary = $wif["workinfo_summary"];
                        }
						if($wif["workinfo_attach"]==1){ $img_att = '<img src="../../images/att.png" alt="Attachment" align="absmiddle"/>';
						}else{ $img_att = ""; }
    ?>
        <tr>
            <td align="center"><img id="btn_display_workinfo" src="../../images/find.png" alt="Display Work Info" align="absmiddle" style="cursor: pointer;" onclick="Showdialog_workinfo('<?=$wif["workinfo_id"]?>','<?=$wif["incident_id"]?>')"/></td>
            <td align="center"><?=$img_att;?></td>
            <td align="left" width="20%"><?=$sub_workinfo_summary?></td>
            <td align="center"><a herf="#" style="cursor: pointer;"><?=$wif["first_name"]." ".$wif["last_name"]?></a></td>
            <td align="center"><?=dateUtil::date_dmyhms2($wif["workinfo_date"])?></td>  
        </tr>
    <?				$index++;
	 }  }  ?>
    </tbody>
</table>
</div>
		</td>
                </tr>
          <tr style="height: 45px">
           <td style="width: 180px" ></td>
                </tr>
      </table>
</div>

<div id="dialog-display-workinfo" title="Work Info">
  <iframe id="ifr" frameborder="0" scrolling="no" width="100%" height="100%" src=""></iframe>
</div>