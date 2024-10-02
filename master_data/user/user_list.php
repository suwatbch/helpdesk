<?php
    include_once "../../include/config.inc.php";
    include_once "user_list.action.php";
    include_once "../common/tablesorter_header.php";
    
?>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=user&user_id=" + $("#user_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_delete("index.php?action=user_list.php&user_id="+ $("#user_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
          $("#user_id").val($(this).attr("value"));
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
            <th><span class="Head">User Code</span></th>
            <th><span class="Head">first Name</span></th>
            <th><span class="Head">Last Name</span></th>
            <th><span class="Head">Copany</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
           if (count($s_user) > 0){
               foreach ($s_user as $ss_user) {
    ?>
        <tr>
                        <td align="center"><?=$index++?></td>
                        <td align="left"><?=$ss_user["user_code"]?></td>
                        <td align="left"><?=$ss_user["first_name"]?></td>
                        <td align="left"><?=$ss_user["last_name"]?></td>
                        <td align="left"><?=$ss_user["company_name"]?></td>
                        <td>
                            <? if($ss_user['user_status']=='0'){  ?>
                            <img src="../../images/restore2.jpg" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=user_list.php&user_id=<?=$ss_user["user_id"]?>', 'restore', 'Do you want restore ?');"/>
                            <?  } else { ?>
                            <a href="index.php?action=user.php&action_master=1&c_user_id=<?=$ss_user["user_id"]?>"><img src="../../images/copy.png" style="cursor: pointer;"></a> 
                            <a href="index.php?action=user.php&action_master=1&user_id=<?=$ss_user["user_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <!--<img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=user_list.php&user_id=<?=$ss_user["user_id"]?>', 'delete');"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$ss_user["user_id"]?>" />
                                <? } ?>
                            
                        </td>
        </tr>
        <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="user_id" id="user_id"/>
</div>



    


