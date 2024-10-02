<?php
    header('Content-Type: text/html; charset=utf8');
    date_default_timezone_set('Asia/Bangkok');
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/model/change_log.class.php";
    global  $db;
    
    if($_REQUEST["action_page"]=='save'){
        $chang_upload_file = 'change_log';
       $incident["uploadfile_reslove"] = $_FILES["uploadfile_reslove"];

        $incident["id"] = $_REQUEST['incident_id'];
        include "../../include/class/model/upload_reslove.php";
        if($result==true){
        //////update tr_incident///
                $str_incident = "update helpdesk_tr_incident set";
                $str_incident .= " modified_change_log = '".$_REQUEST["modified_change_log"]."'";
                $str_incident .=", modified_change_log_date = '".date("Y-m-d H:i:s")."' ";
                $str_incident .=" WHERE id = '{$_REQUEST["incident_id"]}' ";
                $objQuery = $db->query($str_incident);
                 if(!$objQuery){
                    echo "0";
                    exit();
                }
        }
        echo "1";
        exit();
    }else{
           $field = "att.*, u.first_name, u.last_name";
            $table = "helpdesk_tr_attachment att left join helpdesk_user u on(att.attach_user_id=u.user_id)";
            $condition = "1=1 and att.incident_id = '{$_REQUEST['incident_id']}' AND att.type_attachment = '3' AND att.workinfo_id = '0' ";
            $condition .= " ORDER BY att.attach_id asc";
            $result = $db->select($field, $table, $condition);
            $rows = $db->num_rows($result);  

        ?>
<table width="100%" border="0" cellpadding="0" cellspacing="1" align="center">
                <tr style="height: 30px">
                    <td><span class="styleGray">&nbsp;&nbsp;Attachment</span></td>
                </tr>
                <tr>
                    <td>
<div style="overflow: auto;">
   <table width="100%" cellpadding="0" cellspacing="1" class="data-table" border="0" id ="tblfile_resolution">
    
    <thead>
        <tr>
            <td align="center">Name File</td>
            <td width="20%" align="center">User</td>
            <td width="20%" align="center">Date</td>
            <td width="5%" align="center">Delete</td>
        </tr>
    </thead>
    <tbody>
        <?
   if ($rows > 0){
               $index = 1;
               $i = 1;
               while($fetch_file = $db->fetch_array($result)){
?>
        <tr id="<?=$fetch_file["attach_id"];?>">
            <td align="left"><a href="../../upload/temp_inc_reslove/<?=$fetch_file["location_name"]?>" target="_blank"><?=$fetch_file["attach_name"]?></a></td>
            <td align="center"><a herf="#" style="cursor: pointer;"><?=$fetch_file["first_name"]." ".$fetch_file["last_name"]?></a>
            <td align="center"><?=date("d/m/Y H:i:s",  strtotime($fetch_file["attach_date"]))?></td>
            <td align="center" ><a href="javascript:return(0);" class="delete_file_reslove"><img src="../../images/error.png" height="12px" width="12px"/></a></td>
        </tr>
                 <?php
                 $index++;
                 $i++;
               }//end while
            
           } //end if
		 ?>
    </tbody>
</table>
</div>
		</td>
                </tr>
          <tr style="height: 45px">
                    <td style="width: 180px" ></td>
                </tr>
      </table>
<input type="hidden" name="lineid" id="lineid" value="<?=$i?>">
<? } ?>
        
