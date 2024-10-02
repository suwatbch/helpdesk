<?php
    header('Content-Type: text/html; charset=utf8');
    date_default_timezone_set('Asia/Bangkok');
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/model/change_log.class.php";
    global  $db;
    
    if($_REQUEST["action_page"]=='save'){
       
        for($i=1;$i<=$_REQUEST["lineid"];$i++)
	{
            
            if($_REQUEST["s_change_log$i"] == 'yes'){
		$strSQL = "UPDATE helpdesk_tr_workinfo SET ";
		$strSQL .=" workinfo_summary = '".$_REQUEST["workinfo_summary$i"]."' ";
		$strSQL .=",workinfo_notes = '".$_REQUEST["workinfo_notes$i"]."' ";
                $strSQL .=",change_log_workinfo = '".$_REQUEST["modified_change_log"]."' ";
                $strSQL .=",change_log_workinfo_date = '".date("Y-m-d H:i:s")."' ";
		$strSQL .=" WHERE workinfo_id = '".$_REQUEST["workinfo_id$i"]."' and incident_id = '{$_REQUEST["incident_id"]}' ";
		$objQuery = $db->query($strSQL);
                
                
                if(!$objQuery){
                    echo "0";
                    exit();
                }
            }
        }
        if($objQuery==true){
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
        //if($_REQUEST["s_incident"]!="" || $_REQUEST["e_incident"]!=""){

            $field = "*";
            $table = "helpdesk_tr_workinfo";
            $condition = "1=1 and incident_id = '{$_REQUEST['incident_id']}' ";
            $condition .= " ORDER BY workinfo_id asc";
            $result = $db->select($field, $table, $condition);
            $rows = $db->num_rows($result);

            
        ?>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%"> 
    <thead>
        <tr>
            <th width="3%"><span class="Head">No.</span></th>
            <th width="70%"><span class="Head">Work Detail</span></th>
            <th width="27%"><span class="Head">Internal Notes</span></th>
        </tr>
    </thead>
 <tbody>
 <?       
           if ($rows > 0){
               $index = 1;
               $i = 1;
               while($s_objectives = $db->fetch_array($result)){
    ?>
        <tr value="">
                        <td align="center" style=" color: black;"><?=$index?>
                        <input type="hidden" id="s_change_log<?=$i?>" name="s_change_log<?=$i?>">
                        <input type="hidden" id="workinfo_id<?=$i?>" name="workinfo_id<?=$i?>" value="<?=$s_objectives["workinfo_id"]?>"></td>
                        <td align="left"><textarea name="workinfo_summary<?=$i?>" id="workinfosummary_<?=$i?>" class="change_log_class" style="width: 100%px; height: 100px;"><?=$s_objectives["workinfo_summary"]?></textarea></td>
                        <td align="left"><textarea name="workinfo_notes<?=$i?>" id="workinfonotes_<?=$i?>" class="change_log_class"  style="width: 100%px; height: 100px;"><?=$s_objectives["workinfo_notes"]?></textarea></td>
                        
        </tr>
                 <?php
                 $index++;
                 $i++;
               }//end while
            
           } //end if
		 ?>
 </tbody>     
</table>
<input type="hidden" name="lineid" id="lineid" value="<?=$i?>">
<? } ?>
        
