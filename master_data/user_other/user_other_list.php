<?php
    include_once "../../include/config.inc.php";
    include_once "user_other_list.action.php";
    include_once "../common/tablesorter_header.php";
    ?>

  
<div class="full_width" style="overflow: auto; height: 540px; " >
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%;">   
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
                            <a href="index.php?action=user_other.php&action_master=2&action_add_user_other=1&user_id=<?=$ss_user["user_id"]?>"><img src="../../images/edit_inline.png" style="cursor: pointer;"></a> 
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
    


