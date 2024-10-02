<script type="text/javascript" src="../../include/js/mulifile/jQuery.MultiFile.js"></script> 
<script type="text/javascript" language="javascript">
                              $(function(){ // wait for document to load 
                               $('#uploadfile_reslove').MultiFile({ 
                                list: '#show_file_reslove'
                               }); 
                              });
                              </script>
<script type="text/javascript">
$('document').ready(function(){
$('a.delete_file_reslove').click(function(){
if (confirm("Are you sure to delete")){
var del_id = $(this).parent().parent().attr('id');
var parent = $(this).parent().parent();
$.post('delete_file_reslove.php', {id:del_id},function(data){
parent.fadeOut('fast', function() {$(this).remove();});
});
}
});
$('.blink').blink(); // default is 500ms blink interval.
});
$(function(){
        $("img[alt=Delete_km]").live('click', function() {
            if (confirm_delete()){
                $(this).parent().parent().remove();
            }
        });
});
function getfile(){
        var getfile = "";
        $("#tblfile_resolution tbody tr").each(function(){
            if (getfile != "") {
                getfile += ",";
            }
            getfile += $(this).attr("value");
        });
        return getfile;
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
<input type="hidden" id="h_resolved_date" name="h_resolved_date" value="<?=$incident["resolved_date"];?>"/>
<div style="overflow-y: auto;">
<br>
<table width="98%" border="0" cellpadding="0" cellspacing="1" align="center">
    	
                <tr style="height: 30px">
                    <td colspan="2">
                         <span class="styleBlue">RESOLUTION</span><span class="styleGray"> INFORMATION</span>
                    </td>
                </tr>
</table>
    <table width="80%" border="0" cellpadding="0" cellspacing="3" align="center">
                <tr>
                    <td class="tr_header1">Resolution <span class="required">*</span></td>
                    <td>
                        <textarea name="resolution" id="resolution"  style="width: 100%px; height: 70px;"><?=htmlspecialchars($incident["resolution"])?></textarea>
                    </td>
                </tr>
                 <tr style="height: 30px">
                    <td colspan="2"  ><span class="styleGray">PRODUCT CATEGORIZATION</span></td>
                </tr>
                <tr>
                    <td class="tr_header1" >Class 1 <span class="required">*</span></td>
                    <td>
                        <?=$dd_prd_tier1_resol;?>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header1"  >Class 2 <span class="required">*</span></td>
                    <td>
                        <?=$dd_prd_tier2_resol;?>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header1" >Class 3 <span class="required">*</span></span></td>
                    <td>
                        <?=$dd_prd_tier3_resol;?>
                    </td>
                </tr>
                <tr style="height: 30px">
                    <td colspan="2"><span class="styleGray">OPERATIONAL CATEGORIZATION</span></td>
                </tr>
                <tr>
                    <td class="tr_header1" >Class 1 <span class="required">*</span></td>
                    <td>
                        <?=$dd_opr_tier1_resol;?>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header1" >Class 2 <span class="required">*</span></td>
                    <td>
                        <?=$dd_opr_tier2_resol;?>
                    </td>
                </tr>
                <tr>
                    <td class="tr_header1"  >Class 3</td>
                    <td>
                        <?=$dd_opr_tier3_resol;?>
                    </td>
                </tr>
                 <tr>
                   <td class="tr_header1">Attach File</td>
                    <td>
                        <input type="file" id="uploadfile_reslove" name="uploadfile_reslove[]"/>
                            <div id="show_file_reslove" style="border:#999 solid 3px; padding:10px;">
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
   <table width="100%" cellpadding="0" cellspacing="1" class="data-table" border="0" id ="tblfile_resolution">
    
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
	
   //if (count($incident["file_resolution"]) > 0){
                    //foreach ($incident["file_resolution"] as $fetch_file) {
                       // $attach_cas = "Y";
?>
<!--        <tr id="<?=$fetch_file["attach_id"];?>">
            <td align="left"><a href="../../upload/temp_inc_reslove/<?=$fetch_file["location_name"]?>" target="_blank"><?=htmlspecialchars($fetch_file["attach_name"])?></a></td>
            <td align="center"><a herf="#" style="cursor: pointer;"><?=$fetch_file["first_name"]." ".$fetch_file["last_name"]?></a>
            <td align="center"><?=dateUtil::date_dmyhms2($fetch_file["attach_date"])?></td>
            <td align="center" ><a href="javascript:return(0);" class="delete_file_reslove"><img src="../../images/error.png" height="12px" width="12px"/></a></td>
        </tr>-->
    <?
	// }  
//}  ?>
        
        
         <?php
	////km ref///
   if (count($incident["file_resolution"]) > 0){
                    foreach ($incident["file_resolution"] as $fetch_file) {
?>
        <tr id="<?=$fetch_file["attach_id"]?>" value="<?=$fetch_file["location_name"]."|".$fetch_file["attach_name"]?>">
            <? if($fetch_file["km_id"] == ""){ ?>
            <td align="left"><a href="../../upload/temp_inc_reslove/<?=$fetch_file["location_name"]?>" target="_blank"><?=htmlspecialchars($fetch_file["attach_name"])?></a></td>
            <? }else{ ?>
            <td align="left"><a href="../../incident_km/temp_identify/<?=$fetch_file["location_name"]?>" target="_blank"><?=htmlspecialchars($fetch_file["attach_name"])?></a></td>
            <? } ?>
            <td align="center"><a herf="#" style="cursor: pointer;"><?=$fetch_file["first_name"]." ".$fetch_file["last_name"]?></a>
            <td align="center"><?=dateUtil::date_dmyhms2($fetch_file["attach_date"])?></td>
            <? if($fetch_file["km_id"] != 0){?>
            <td width="8%" align="center"><img src="../../images/close_inline.png" alt="Delete_km" style="cursor: pointer;"/></td>
            <? }else {?>
            <td align="center" ><a href="javascript:return(0);" class="delete_file_reslove"><img src="../../images/error.png" height="12px" width="12px"/></a></td>
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
              
               <? 
               //if($incident["km_entrant"]== 'Y' || $incident["status_id"] == 5){ ?>
                <tr id="show_keyword">
                   
                    <td class="tr_header1"><span class="styleBlue">KM Keyword</span><span class="required"> *</span></td>
                    <td>
                        <textarea name="km_keyword" id="km_keyword"  style="width: 100%px; height: 40px;" <? if($incident["km_release"]=="N" || $incident["km_release"] == "Y"){echo " class='disabled' readonly";} ?>><?=htmlspecialchars($incident["inc_km_keyword"])?></textarea>
                <p class="blink" style="color: red;">Separate Keyword with comma(,)</p>
                    </td>
                  
                </tr>
                <? //} ?>
                
                <tr>
                    <td class="tr_header1">Resolved By</td>
                    <td>
                    <input type="text" name="resolution_user" id="resolution_user" value="<?=$incident["resolution_user"];?>" readonly class="disabled"/>
                    <input type="hidden" name="resolution_user_id" id="resolution_user_id" value="<?=$incident["resolution_user_id"];?>"/></td>
                </tr>
     
</table>
</div>
