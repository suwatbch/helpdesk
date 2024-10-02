<?php
    include_once "../../include/config.inc.php";
    include_once "cus_zone_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<script type="text/javascript"> 
    // When the document is ready set up our sortable with it's inherant function(s) 
    $(document).ready(function() { 
        $("#example tbody").sortable({ 
            handle : '.handle', 
            update : function () { 
                var order = $(this).sortable('serialize'); 
                $("#info").load("cus_zone_item.php?"+order);
                page_submit("index.php?action=cus_zone_list.php", "");
            } 
        }); 
    }); 
</script>
<script type="text/javascript">
     function validate_delete(){
        $.ajax({
                type: "GET",
                url: "../common/validate_delete.php",
                data: "action=zone&zone_id=" + $("#zone_id").val(),
                success: function(respone){
                    //alert(respone);
                    if(respone == 1){ 
                        jAlert('error', 'Cannot delete because this data was used to process', 'Helpdesk System : Messages');
                        return false;
                   }else{
                       page_delete("index.php?action=cus_zone_list.php&zone_id="+ $("#zone_id").val(), 'delete');
                      }
                }
            });
           
    }
    $(function(){
        $("img[alt=delete]").live('click', function() {
          $("#zone_id").val($(this).attr("value"));
          validate_delete();
        });
    });
</script>
<div class="full_width" style="overflow: auto; height: 540px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">  
    <thead>
        <tr>
            <th width="2%">&nbsp;</th>
<!--            <th width="2%"><span class="Head">No.</span></th>-->
            <th><span class="Head">sequence</span></th>
            <th><span class="Head">Zone Number</span></th>
             <th><span class="Head">Zone Name</span></th>
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
        <tr id="listItem_<?=$s_objective["zone_id"]?>">
                        <td><img src="../../images/arrow.png" alt="move" width="16" height="16" class="handle" /></td>
                        <td align="center"><?=$index++?></td>
                        <!--<td align="center"><?=$s_objective["item"]?></td>-->
                        <td align="left"><?=$s_objective["shortname"]?></td>
                        <td align="left"><?=$s_objective["name"]?></td>
                        <td align="left"><?=$s_objective["cus_company_name"]?></td>
                        <td>
                            <? //if($s_objective['status']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=cus_zone_list.php&zone_id=<?=$s_objective["zone_id"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <? // } else { ?>
                            <a href="index.php?action=cus_zone.php&action_master=1&zone_id=<?=$s_objective["zone_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <!--<img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=cus_zone_list.php&zone_id=<?=$s_objective["zone_id"]?>', 'restore');"/>-->
                            <img id="delete" name="delete" alt="delete" src="<?=$application_path_images;?>/close_inline.png" title="delete" style="cursor: pointer; border: none;" value="<?=$s_objective["zone_id"]?>" />
                                <?// } ?>
                            
                        </td>

        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="zone_id" id="zone_id"/>
</div>
<pre> 
    <div id="info" style="display: none;" >Waiting for update</div> 
</pre>


    


