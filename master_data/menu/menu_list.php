<?php
    include_once "../../include/config.inc.php";
    include_once "menu_list.action.php";
    include_once "../common/tablesorter_header.php";
?>
<div class="full_width" style="overflow: auto; height: 540px; ">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">
                <thead>
                    <tr>
                        <th width="2%"><span class="Head">No.</span></th>
                        <th ><span class="Head">Menu Code</span></th>
                        <th ><span class="Head">Menu Name</span></th>
                        <th ><span class="Head">Parent Menu</span></th>
                        <th ><span class="Head">Action</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $index = 1;
                        if (count($menus) > 0){
                            foreach ($menus as $menu) {
                    ?>
                    <tr>
                        <td align="center"><?=$index++?></td>
                        <td align="left"><?=$menu["menu_code"]?></td>
                        <td align="left"><?=$menu["menu_name"]?></td>
                        <td align="left"><?=$menu["parent_menu_name"]?></td>
                        <td>
                        <? if($menu['status']=='D'){  ?>
                            <img src="../../images/application_restore.png" id="restore" style="cursor: pointer;" onclick="page_delete('index.php?action=menu_list.php&menu_id=<?=$menu["menu_id"]?>', 'restore', 'Do you want restore ?');"/>
                            <?  } else { ?>
                            <a href="index.php?action=menu.php&action_master=1&menu_id=<?=$menu["menu_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
                            <img src="../../images/close_inline.png" id="delete" style="cursor: pointer;" onclick="page_delete('index.php?action=menu_list.php&menu_id=<?=$menu["menu_id"]?>', 'restore');"/>
                            <? } ?>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </tbody>
</table>
<input type="hidden" name="menu_id" id="menu_id"/>
</div>