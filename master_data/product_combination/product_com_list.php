<?php
    include_once "../../include/config.inc.php";
    include_once "product_com_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=product_combination&prd_tire1=" + $("#prd_tire1").val()+"&prd_tire2="+$("#prd_tire2").val()+"&prd_tire3="+$("#prd_tire3").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_delete("index.php?action=product_com_list.php&tr_prd_tier_id="+ $("#tr_prd_tier_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
            var data_object = $(this).attr("value");
            var arr_object = data_object.split('|');
            $("#prd_tire1").val(arr_object['0']);
            $("#prd_tire2").val(arr_object['1']);
            $("#prd_tire3").val(arr_object['2']);
            $("#tr_prd_tier_id").val(arr_object['3']);
          validate_delete();
        });
    });
</script>
<div class="full_width" style="overflow: auto; height: 540px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
    <thead>
        <tr>
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">Product Class 1</span></th>
            <th><span class="Head">Product Class 2</span></th>
            <th><span class="Head">Product Class 3</span></th>
            <th><span class="Head">Customer Company</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
           if (count($objective) > 0){
               foreach ($objective as $s_objective) {
    ?>
        <tr>
                        <td align="center"><?=$index++?></td>
                        <td align="left"><?=$s_objective["prd_name1"]?></td>
                        <td align="left"><?=$s_objective["prd_name2"]?></td>
                        <td align="left"><?=$s_objective["prd_name3"]?></td>
                        <td align="left"><?=$s_objective["cus_company_name"]?></td>
                        <td>
                            <? //if($s_objective['status']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=product_com_list.php&tr_prd_tier_id=<?=$s_objective["tr_prd_tier_id"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <? // } else { ?>
                            <a href="index.php?action=product_com.php&action_master=1&c_tr_prd_tier_id=<?=$s_objective["tr_prd_tier_id"]?>"><img src="../../images/copy.png" style="cursor: pointer;"></a> 
                            <a href="index.php?action=product_com.php&action_master=1&tr_prd_tier_id=<?=$s_objective["tr_prd_tier_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$s_objective["prd_tier_lv1_id"]."|".$s_objective["prd_tier_lv2_id"]."|".$s_objective["prd_tier_lv3_id"]."|".$s_objective["tr_prd_tier_id"]?>" />
                            <!--<img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=product_com_list.php&tr_prd_tier_id=<?=$s_objective["prd_tier_lv1_id"]."|".$s_objective["prd_tier_lv2_id"]."|".$s_objective["prd_tier_lv3_id"]?>', 'restore');"/>-->
                            <? //} ?>
                        </td>
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="tr_prd_tier_id" id="tr_prd_tier_id"/>
<input type="hidden" name="prd_tire1" id="prd_tire1"/>
<input type="hidden" name="prd_tire2" id="prd_tire2"/>
<input type="hidden" name="prd_tire3" id="prd_tire3"/>
</div>



    

