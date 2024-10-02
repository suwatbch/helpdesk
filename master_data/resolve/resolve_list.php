<?php
    include_once "../../include/config.inc.php";
    include_once "resolve_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<div class="full_width" style="overflow: auto; height: 540px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
    <thead>
        <tr>
            <th width="2%"><span class="Head">No.</span></th>
            <th><span class="Head">Customer Company</span></th>
            <th><span class="Head">Priority</span></th>
            <th><span class="Head">Prd Class 1</span></th>
            <th><span class="Head">Prd Class 2</span></th>
            <th><span class="Head">Prd Class 3</span></th>
            <th><span class="Head">Opr Class 1</span></th>
            <th><span class="Head">Opr Class 2</span></th>
            <th><span class="Head">Opr Class 3</span></th>
            <th><span class="Head">SLA(Time)</span></th>
            <th width="8%"><span class="Head">Action</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
            global $db;
           if (count($objective) > 0){
               foreach ($objective as $s_objective) {
                   $p = new helpdesk_resolve($db);
                   $array_priority = $p->search_list_priority($s_objective["priority_id"]);
                   $s_data = $array_priority["data"];
                   $txt_priority = "";
                   foreach ($s_data as $ss_data){
                       if($txt_priority == ""){
                           $txt_priority .= $ss_data["priority_desc"];
                       }else{
                           $txt_priority .= ','.$ss_data["priority_desc"];
                       }
                       
                   }
    ?>
        <tr>
                        <td align="center"><?=$index++?></td>
                        <td align="left"><?=$s_objective["cus_company_name"]?></td>
                        <td align="left"><?=$txt_priority?></td>
                        <td align="left"><?=$s_objective["prd_name_class1"]?></td>
                        <td align="left"><?=$s_objective["prd_name_class2"]?></td>
                        <td align="left"><?=$s_objective["prd_name_class3"]?></td>
                        <td align="left"><?=$s_objective["opr_name_class1"]?></td>
                        <td align="left"><?=$s_objective["opr_name_class2"]?></td>
                        <td align="left"><?=$s_objective["opr_name_class3"]?></td>
                        <td align="left"><?=$s_objective["resolve_sla"]?></td>
                        <td>
                            <? //if($s_objective['status']=='D'){  ?>
                            <!--<img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=resolve_list.php&id_resolve=<?=$s_objective["id_resolve_priority"]?>', 'restore', 'Do you want restore ?');"/>-->
                            <? // } else { ?>
                            <a href="index.php?action=resolve.php&action_master=1&c_id_resolve_priority=<?=$s_objective["id_resolve_priority"]?>"><img src="../../images/copy.png" style="cursor: pointer;"></a> 
                            <a href="index.php?action=resolve.php&action_master=1&id_resolve_priority=<?=$s_objective["id_resolve_priority"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=resolve_list.php&id_resolve_priority=<?=$s_objective["id_resolve_priority"]?>', 'delete');"/>
                            <? //} ?>
                        </td>
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
<input type="hidden" name="id_resolve_priority" id="id_resolve_priority"/>
</div>



    


