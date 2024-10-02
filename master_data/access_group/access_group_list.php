<?php
    include_once "../../include/config.inc.php";
    include_once "access_group_list.action.php";
    include_once "../common/tablesorter_header.php";
    $arr_access_group= $output["arr_access_group"];
    $total_row = $output["total_row"];
    
?>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=access_group&access_group_id=" + $("#access_group_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_delete("index.php?action=access_group_list.php&access_group_id="+ $("#access_group_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
          $("#access_group_id").val($(this).attr("value"));
          validate_delete();
        });
    });
</script>
<div class="full_width" style="overflow: auto; height: 540px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
                <thead>
                    <tr>
                        <th width="2%"><span class="Head">No.</span></th>
                        <th><span class="Head">Group Code</span></th>
                        <th><span class="Head">Group Name</span></th>
                        <th><span class="Head">Action</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $index = 1;
                        if (count($arr_access_group) > 0){
                            //$index = get_first_reccord($page, $page_size);
                            foreach ($arr_access_group as $access_group) {
                    ?>
                    <tr>
                        <td align="center"><?=$index++?></td>
                        <td align="center"><?=$access_group["access_group_code"]?></td>
                        <td><?=$access_group["access_group_name"]?></td>
                        <td align="center">
                             <? //if($access_group["access_group_status"]=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=access_group_list.php&access_group_id=<?=$access_group["access_group_id"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <?  //} else { ?>
                            <a href="index.php?action=access_group.php&action_master=1&access_group_id=<?=$access_group["access_group_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$access_group["access_group_id"]?>" />
                                <?// } ?>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
<input type="hidden" name="access_group_id" id="access_group_id"/>
</div>