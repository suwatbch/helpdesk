<?php
    include_once "../../include/config.inc.php";
    include_once "../../include/class/db/db.php";
    include_once "incident_identify_list.action.php";
    include_once "../../master_data/common/tablesorter_header.php";
?>
<script type="text/javascript">
 $(document).ready(function(){  
         $("img[alt=delete_km]").live('click', function() { 
            var data_object = $(this).attr("value");
            validate_delete(data_object);
        });
        
        $("img[alt=delete_inc]").live('click', function() {
            if(confirm("Do you want to delete")){
            var data_object = $(this).attr("value");
            page_submit("index.php?action=incident_identify_list.php&incident_id=" + data_object, "delete")
            }
        });
    });
    function validate_delete(data_object){
        $.ajax({
                type: "GET",
                url: "validate_deleted.php",
                data: "action=deleted_km&km_id=" + data_object,
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                      page_delete("index.php?action=incident_identify_list.php&km_id=" + data_object, "delete")
                    }
                }
            });
           
    }
</script>
<div class="full_width" style="overflow-y: auto; height: 450px; ">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    <thead>
        <tr>
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
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
            global $db, $total_row_attach, $att;
           if (count($objective) > 0){
               foreach ($objective as $s_objective) {
                   $summary = $s_objective["summary"];
                   if (strlen($summary) > 25){
                            $summary = iconv_substr($s_objective["summary"], 0, 25, "UTF-8")."...";
                   }
                   $notes = $s_objective["notes"];
                   if (strlen($notes) > 25){
                            $notes = iconv_substr($s_objective["notes"], 0, 25, "UTF-8")."...";
                   }
                   $resolution = $s_objective["resolution"];
                   if (strlen($resolution) > 25){
                            $resolution = iconv_substr($s_objective["resolution"], 0, 25, "UTF-8")."...";
                   }
//            $sql = "select count(attach_id) as total_row_attach from helpdesk_tr_attachment where incident_id = '{$s_objective["id"]}'";
//            $result = $db->query($sql);
//            $objective_att = $db->fetch_array($result);
//            $total_row_attach = $objective_att["total_row_attach"];
    ?>
        <tr>
                        <td align="center"><? if($s_objective["km_no"]!= ""){ echo $s_objective["km_no"]; }else { echo "-"; }?></td>
                        <td align="center"><? if($s_objective["ident_id_run_project"] != ""){ echo $s_objective["ident_id_run_project"]; } else { echo "-";}?></td>
                        <td align="left"><?=$summary?></td>
                        <td align="left"><?=$notes?></td>
                        <td align="left"><?=$resolution?></td>
                        <td align="left"><?=$s_objective["prd_name1"]?></td>
                        <td align="left"><?=$s_objective["prd_name2"]?></td>
                        <td align="left"><?=$s_objective["prd_name3"]?></td>
                        <td align="left"><?=$s_objective["reslove_by"]?></td>
                        <td align="left"><?=$s_objective["resolved_date"]?></td>
                        <? //if($total_row_attach > 0){?>
<!--                        <td align="center"><img src="../../images/att.png"></td>-->
                        <? //}else { ?>
<!--                        <td align="center">-</td>-->
                        <?// } ?>
                        <td align="center">
                            <a href="index.php?action=incident_identify.php&action_master=1&incident_id=<?=$s_objective["id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <img id="delete_inc" name="delete_inc" alt="delete_inc" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$s_objective["id"]?>" />
                            
                        </td>
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
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
                        <td align="center"><? if($s_objective["km_no"]!= ""){ echo $s_objective["km_no"]; }else { echo "-"; }?></td>
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
                        <? //}else { ?>
<!--                        <td align="center">-</td>-->
                        <?// } ?>
                        <td align="center">
                            <a href="index.php?action=incident_identify.php&action_master=1&km_id=<?=$s_objective["km_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <img id="delete_km" name="delete_km" alt="delete_km" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$s_objective["km_id"]?>" />     
                        </td>
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="cus_area_id" id="cus_area_id"/>
<input type="hidden" id="area_cus" name="area_cus">
</div>



    


