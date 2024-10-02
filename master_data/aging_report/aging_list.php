<?php
    include_once "../../include/config.inc.php";
    include_once "aging_list.action.php";
    include_once "../common/tablesorter_header.php";
    ?>

<script type="text/javascript"> 
    // When the document is ready set up our sortable with it's inherant function(s) 
    $(document).ready(function() { 
        $("#example tbody").sortable({ 
            handle : '.handle', 
            update : function () { 
                var order = $(this).sortable('serialize'); 
                $("#info").load("aging_item.php?"+order);
                page_submit("index.php?action=aging_list.php", "");
            } 
        }); 
    }); 
</script>
<!--<div class="full_width">-->
  
<div class="full_width" style="overflow: auto; height: 540px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
    
    <thead>
        <tr>
            <!--<th width="5%"></th>-->
            <th width="2%">&nbsp;</th>
<!--            <th width="2%"><span class="Head">No.</span></th>-->
            <th width="2%"><span class="Head">Sequence</span></th>
            <th><span class="Head">Condition Aging</span></th>
            <th><span class="Head">Condition Aging Description</span></th>
            <th><span class="Head">Value</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
           if (count($objective) > 0){
               foreach ($objective as $s_objective) {
    ?>
        <tr id="listItem_<?=$s_objective["id"]?>">
            <td><img src="../../images/arrow.png" alt="move" width="16" height="16" class="handle" /></td>
<!--                        <td align="center"><?=$index++?></td>-->
                        <td align="center"><?=$s_objective["item"]?></td>
                        <td align="left"><?=$s_objective["shortname"]?></td>
                        <td align="left"><?=$s_objective["name"]?></td>
                        <td align="left"><?=$s_objective["value"]?></td>
                        <td>
                           <? //if($s_objective['status']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=aging_list.php&id=<?=$s_objective["id"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <?//  } else { ?>
                            <a href="index.php?action=aging.php&action_master=1&id=<?=$s_objective["id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=aging_list.php&id=<?=$s_objective["id"]?>', 'delete');"/>
                            <?// } ?>
                        </td>
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="id" id="id"/>
</div>

<!--</div>-->
<pre> 
    <div id="info" style="display: none;">Waiting for update</div> 
</pre> 



    


