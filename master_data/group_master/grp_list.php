<?php
    include_once "../../include/config.inc.php";
    include_once "grp_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=group&org_id=" + $("#org_id").val() + "&org_comp=" + $("#company_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                        page_delete("index.php?action=grp_list.php&org_id="+ $("#org_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
            var data_object = $(this).attr("value");
            var arr_object = data_object.split('|');
            $("#org_id").val(arr_object['0']);
            $("#company_id").val(arr_object['1']);
          validate_delete();
        });
    });
</script>
<div class="full_width" style="overflow: auto; height: 540px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
    <thead>
        <tr>
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">Company Name</span></th>
            <th><span class="Head">Organization Name</span></th>
             <th><span class="Head">Group Name</span></th>
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
                        <td align="left"><?=$s_objective["company_name"]?></td>
                        <td align="left"><?=$s_objective["organization_master"]?></td>
                        <td align="left"><?=$s_objective["group_master"]?></td>
                        <td>
                            <? //if($s_objective['status']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=grp_list.php&org_id=<?=$s_objective["org_id"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <? // } else { ?>
                            <a href="index.php?action=grp.php&action_master=1&s_org_id=<?=$s_objective["org_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <!--<img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=grp_list.php&org_id=<?=$s_objective["org_id"]?>', 'restore');"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$s_objective["org_id"]."|".$s_objective["company_id"]?>" />
                                <?// } ?>
                        </td>

        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="org_id" id="org_id"/>
<input type="hidden" name="company_id" id="company_id"/>
</div>



    


