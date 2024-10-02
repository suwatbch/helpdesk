<?php
    include_once "../../include/config.inc.php";
    include_once "cus_area_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=area&area_cus=" + $("#area_cus").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_delete("index.php?action=cus_area_list.php&cus_area_id="+ $("#cus_area_id").val(), 'delete');
                      }
                }
            });
           
    }
 $(document).ready(function(){  
         $("img[alt=delete]").live('click', function() { 
            var data_object = $(this).attr("value");
            var arr_object = data_object.split('|');
            $("#cus_area_id").val(arr_object['0']);
            $("#area_cus").val(arr_object['1']);
          validate_delete();
        });
    });
</script>
<div class="full_width" style="overflow: auto; height: 540px; ">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    <thead>
        <tr>
            <!--<th width="5%"></th>-->
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">Area Code</span></th>
             <th><span class="Head">Area Name</span></th>
            <th><span class="Head">Zone</span></th>
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
                        <td align="left"><?=$s_objective["area_cus"]?></td>
                        <td align="left"><?=$s_objective["area_cus_name"]?></td>
                        <td align="left"><?=$s_objective["name"]?></td>
                        <td>
                            <?// if($s_objective['status']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=cus_area_list.php&cus_area_id=<?=$s_objective["id"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <?  //} else { ?>
                            <a href="index.php?action=cus_area.php&action_master=1&cus_area_id=<?=$s_objective["id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <!--<img src="../../images/close_inline.png" id="delete" onclick="page_delete('index.php?action=cus_area_list.php&cus_area_id=<?=$s_objective["id"]?>', 'restore');"style="cursor: pointer;"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$s_objective["id"]."|".$s_objective["area_cus"]?>" />
                           
                                <?// } ?>
                            
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



    


