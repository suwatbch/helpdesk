<?php
session_start();
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
//if(user_session::get_sale_group_id() == 9 || user_session::get_sale_group_id() == 10) $create_role = "Y";
?>
<link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
<style type="text/css">
    body, html{
        /*background-color: #E9E9E9;*/
        margin: 0px;
        padding: 0px;
    }

    .tr_detail{
        padding-left: 5px;
        font-size: 11px;
        
    }
</style>
<table id="tb_adv_left" width="98%" border="0" cellpadding="0" cellspacing="1">
    <tr >
        <td width="25%"></td>
        <td><br>
        </td>
        <td width="12%"></td>
    </tr>
    <tr>
        <th align=left>Employee Code</th>
        <td class="tr_detail"><?= user_session::get_employee_code(); ?></td>
        <!--<td rowspan="7" align="center" valign="top" class="tr_detail"><img src="<?//=$application_path?>/master_data/sale/sale.photo.php?employee_code=<?//= $sale["employee_code"]?>" alt="Photo" style="margin-bottom: 1px; width: 108px; height: 113px;"/></td>-->
    </tr>
    <tr>
        <th align=left>User Name</th>
        <td class="tr_detail"><?=user_session::get_user_name(); ?></td>
    </tr>
    <tr>
        <th align=left>Company</th>
        <td class="tr_detail"><?=user_session::get_user_company_name(); ?></td>
    </tr>
    <tr>
        <th align=left>Organize</th>
        <td  class="tr_detail"><?=user_session::get_user_org_name(); ?></td>
    </tr>
    <tr>
       <th align=left>Group</th>
        <td  class="tr_detail"><?=user_session::get_user_grp_name(); ?></td>
    </tr>
    <tr>
        <th align=left>Subgroup</th>
        <td  class="tr_detail"><?=user_session::get_user_subgrp_name(); ?></td>
    </tr>
    <tr>
        <th align=left>Transfer permission</th>
        <td  class="tr_detail"><?=user_session::get_user_tra_inc_per(); ?></td>
    </tr>
    <tr>
        <th align=left>Admin permission</th>
        <td  class="tr_detail"><?=user_session::get_user_admin_permission(); ?></td>
    </tr>
    <tr>
        <th align=left>Edit Report permission</th>
        <td  class="tr_detail"><?=user_session::get_edit_rpt_per(); ?></td>
    </tr>
    <tr>
        <th align=left>Approve Report permission</th>
        <td  class="tr_detail"><?=user_session::get_appv_rpt_per(); ?></td>
    </tr>
    
    <tr>
        <td></td>
        <td></td>
    </tr>
</table>
