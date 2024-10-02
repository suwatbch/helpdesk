<?php
    include_once "../../include/config.inc.php";
    include_once "priority_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=priority&priority_id=" + $("#priority_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_delete("index.php?action=priority_list.php&priority_id="+ $("#priority_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
          $("#priority_id").val($(this).attr("value"));
          validate_delete();
        });
    });
</script>
<div class="full_width" style="overflow: auto; height: 540px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
    <thead>
        <tr>
            <!--<th width="5%"></th>-->
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">Priority</span></th>
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
                        <td align="left"><?=$s_objective["priority_desc"]?></td>
                        <td>
                            <? //if($s_objective['status']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=priority_list.php&priority_id=<?=$s_objective["priority_id"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <?  //} else { ?>
                            <a href="index.php?action=priority.php&action_master=1&priority_id=<?=$s_objective["priority_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <!--<img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=priority_list.php&priority_id=<?=$s_objective["priority_id"]?>', 'restore');"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$s_objective["priority_id"]?>" />
                                <?// } ?>
                            
                        </td>
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="priority_id" id="priority_id"/>
</div>



    


