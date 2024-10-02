<?php
    include_once "../../include/config.inc.php";
    include_once "../../include/class/db/db.php";
    include_once "unrelease_list.action.php";
    include_once "../../master_data/common/tablesorter_header.php";

?>
<script type="text/javascript" language="javascript">
$(function(){
$("#dialog-show_km_process").dialog({
				height: 400
				, width: 640
				, autoOpen: false
				, modal: true
				, resizable: false
				, close : function(){
					$("#ifr_show_km_process").attr("src", "");
				}
		});
 $('.info_link').click(function(event){
      var href = $(this).attr('href');
      $("#ifr_show_km_process").attr("src", href);
      $("#dialog-show_km_process").dialog("open");
      event.preventDefault();
      
    });
 
    // add multiple select / deselect functionality
    $("#selectall").click(function () {
          $('.case').attr('checked', this.checked);
    });
 
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){
 
        if($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }
 
    });
    
    $("#save_unrelease").click(function(){
        var values = $('input:checkbox:checked.case').map(function () {
            return this.value;
        }).get();
        $("#select_release").val(values);
        page_submit("index.php?action=unrelease_list.php&mode=1", "save")
       });
    
    $("#save_identify").click(function(){
        var values = $('input:checkbox:checked.case').map(function () {
            return this.value;
        }).get();
        $("#select_release").val(values);
        page_submit("index.php?action=unrelease_list.php&mode=2", "save")
       });
    
    $("#search").click(function(){   
        page_submit("index.php?action=unrelease_list.php", "")
        });
    
});
///////////////////////////////////////dropdown///////////////////////////////
 $(document).ready(function () {  
           var cus_company_id = $("#cus_company_id").val();
           var cas_prd_tier_id1 = $("#cas_prd_tier_id1").val();
           var cas_prd_tier_id2 = $("#cas_prd_tier_id2").val();
           var cas_prd_tier_id3 = $("#cas_prd_tier_id3").val();
        $("#cus_company_id").change(function(){
           
           page_submit("index.php?action=unrelease_list.php&cus_company_id="+cus_company_id+"&cas_prd_tier_id1="+cas_prd_tier_id1+
               "&cas_prd_tier_id2="+cas_prd_tier_id2+"&cas_prd_tier_id3="+cas_prd_tier_id3, "")
            
        });
		
        $("#cas_prd_tier_id1").change(function(){
           page_submit("index.php?action=unrelease_list.php&cus_company_id="+cus_company_id+"&cas_prd_tier_id1="+cas_prd_tier_id1+
               "&cas_prd_tier_id2="+cas_prd_tier_id2+"&cas_prd_tier_id3="+cas_prd_tier_id3, "")
           
			
        });
	
        $("#cas_prd_tier_id2").change(function(){
           page_submit("index.php?action=unrelease_list.php&cus_company_id="+cus_company_id+"&cas_prd_tier_id1="+cas_prd_tier_id1+
               "&cas_prd_tier_id2="+cas_prd_tier_id2+"&cas_prd_tier_id3="+cas_prd_tier_id3, "")
        });  
        
        $("#cas_prd_tier_id3").change(function(){
           page_submit("index.php?action=unrelease_list.php&cus_company_id="+cus_company_id+"&cas_prd_tier_id1="+cas_prd_tier_id1+
               "&cas_prd_tier_id2="+cas_prd_tier_id2+"&cas_prd_tier_id3="+cas_prd_tier_id3, "")
        }); 
});

</script>
<fieldset>
  <legend>PRODUCT CATEGORIZATION FILTER</legend>
  <table cellpadding="0" cellspacing="5" border="0" style="width:100%">
  <tr>
<td class="tr_header1">Customer Company</td>
<td  colspan="5" width="40%"><?=$dd_company_cus;?></td>
  </tr>
<tr>
<td class="tr_header1">Class 1</td>
<td width="20%"><?=$dd_prd_tier1;?></td>
<td class="tr_header1" >Class 2</td>
<td width="20%"> <?=$dd_prd_tier2;?></td>
<td class="tr_header1" >Class 3</td>
<td width="20%"> <?=$dd_prd_tier3;?></td>
</tr>
  </table>

</fieldset><br>
<div class="full_width" style="overflow-y: auto; height: 355px; ">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    <thead>
        <tr>
            <th><span class="Head"><input type="checkbox" id="selectall" style="width:15px; height:15px;"/></span></th>
            <th><span class="Head">KM ID</span></th>
            <th><span class="Head">ID Incident</span></th>
            <th><span class="Head">Summarize</span></th>
             <th><span class="Head">Detail</span></th>
            <th><span class="Head">Resolution</span></th>
            <th><span class="Head">Product Class 1</span></th>
            <th><span class="Head">Product Class 2</span></th>
            <th><span class="Head">Product Class 3</span></th>
            <th><span class="Head">Resloved By</span></th>
            <th><span class="Head">Resloved Date</span></th>
<!--            <th><span class="Head">Attach</span></th>-->
<!--            <th width="8%"><span class="Head">Action</span></th>-->
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
            global $db, $total_row_attach, $att;
        //////////////////////////////////////////////////identify km/////////////////////////////////////////////////
        if (count($objective_km) > 0){
 
               foreach ($objective_km as $s_objective) {
                   $summary = $s_objective["summary"];
                   if (strlen($summary) > 25){
                            $summary = iconv_substr($s_objective["summary"], 0, 25, "UTF-8")."...";
                   }
                   $detail = $s_objective["detail"];
                   if (strlen($detail) > 25){
                            $detail = iconv_substr($s_objective["detail"], 0, 25, "UTF-8")."...";
                   }
                   $resolution = $s_objective["resolution"];
                   if (strlen($resolution) > 25){
                            $resolution = iconv_substr($s_objective["resolution"], 0, 25, "UTF-8")."...";
                   }
                   
//            $sql = "select count(attach_id) as total_row_attach from helpdesk_tr_attachment where km_id = '{$s_objective["km_id"]}'";
//            $result = $db->query($sql);
//            $objective_att = $db->fetch_array($result);
//            $total_row_attach = $objective_att["total_row_attach"];
    ?>
        <tr>
                        <td align="center" width="1%"><input type="checkbox" class="case" name="case" value="<?=$s_objective["km_id"]?>"/></td>
                        <td align="center"><a class="info_link" href="../../incident_km/km_base/km_base_show.php?km_id=<?=$s_objective["km_id"]?>"><?=$s_objective["km_no"]?></a></td>
                        <td align="center"><? if($s_objective["ident_id_run_project"] != ""){ echo $s_objective["ident_id_run_project"]; } else { echo "-";}?></td>
                        <td align="left"><?=$summary?></td>
                        <td align="left"><?=$detail?></td>
                        <td align="left"><?=$resolution?></td>
                        <td align="left"><?=$s_objective["prd_name1"]?></td>
                        <td align="left"><?=$s_objective["prd_name2"]?></td>
                        <td align="left"><?=$s_objective["prd_name3"]?></td>
                        <td align="left"><?=$s_objective["reslove_by"]?></td>
                        <td align="left"><?=$s_objective["resolved_date"]?></td>
                        <? //if($total_row_attach > 0){?>
<!--                        <td align="center"><img src="../../images/att.png"></td>-->
                        <?// }else { ?>
<!--                        <td align="center">-</td>-->
                        <? //} ?>
<!--                        <td align="center">
                            <a href="index.php?action=incident_identify.php&action_master=1&km_id=<?=$s_objective["km_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                        </td>-->
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
</div>
<input type="hidden" id ="select_release" name="select_release" value="">
<div id="dialog-show_km_process" title="Knowledge Management Base">
    <iframe id="ifr_show_km_process" frameborder="0" scrolling="no" width="100%" height="100%" src=""></iframe>
</div>



    


