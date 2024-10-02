<?php
    header('Content-Type: text/html; charset=utf8');
    date_default_timezone_set('Asia/Bangkok');
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/php_header.class.php";
    //include_once "../../include/class/model/change_log.class.php";
    global  $db;
    
    if($_REQUEST["action_page"]=='save'){
       
        for($i=1;$i<=$_REQUEST["lineid"];$i++)
	{
            if($_REQUEST["s_change_log$i"] == 'yes'){
		$strSQL = "UPDATE helpdesk_tr_incident SET ";
		$strSQL .="summary = '".$_REQUEST["txtsummary$i"]."' ";
		$strSQL .=",notes = '".$_REQUEST["txtnotes$i"]."' ";
		$strSQL .=",reference_no = '".$_REQUEST["referenceno$i"]."' ";
		$strSQL .=",resolution = '".$_REQUEST["resolution$i"]."' ";
                $strSQL .=",modified_change_log = '".$_REQUEST["modified_change_log"]."' ";
                $strSQL .=",modified_change_log_date = '".date("Y-m-d H:i:s")."' ";
		$strSQL .=" WHERE id = '".$_REQUEST["id_incident$i"]."' ";
		$objQuery = $db->query($strSQL);
                if(!$objQuery){
                    echo "0";
                    exit();
                }
            }
        }
        echo "1";
        exit();
    }else if($_REQUEST["s_incident"]!="" || $_REQUEST["e_incident"]!=""){

            $field = "*";
            $table = "helpdesk_tr_incident";
            $condition = "1=1 and status_id = '7' ";
            if($_REQUEST["s_incident"]!="" && $_REQUEST["e_incident"] == ""){
                $condition .= " and ident_id_run_project like '%{$_REQUEST["s_incident"]}%'";
            }else if($_REQUEST["s_incident"]=="" && $_REQUEST["e_incident"] != ""){
                $condition .= " and ident_id_run_project like '%{$_REQUEST["e_incident"]}%'";
            }else if($_REQUEST["s_incident"]!="" && $_REQUEST["e_incident"] != ""){
                $condition .= " and ident_id_run_project BETWEEN '{$_REQUEST["s_incident"]}' and '{$_REQUEST["e_incident"]}' ";
            }
            
            $condition .= " ORDER BY ident_id_run_project asc limit 0,100";
            $result = $db->select($field, $table, $condition);
            $rows = $db->num_rows($result);
            
        ?>
<!--<img id="save" name="save" src="<?=$application_path_images;?>/btn_save.png" title="save" style="cursor: pointer; border: none;" />&nbsp;&nbsp;
<img id="cancel" name="cancel" src="<?=$application_path_images;?>/btn_back.png" title="Back" style="cursor: pointer; border: none;" />-->
<? if ($rows > 0){ ?>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%"> 
    <thead>
        <tr>
            <th width="3%"><span class="Head">No.</span></th>
            <th width="10%"><span class="Head">Incident NO.</span></th>
            <th width="10%"><span class="Head">Summarize</span></th>
            <th width="25%"><span class="Head">Detail</span></th>
            <th width="10%"><span class="Head">Reference No</span></th>
            <th width="8%"><span class="Head">Work Info</span></th>
            <th width="25%"><span class="Head">Resolution</span></th>
            <th width="5%"><span class="Head">Attach.</span></th>
        </tr>
    </thead>
 <tbody>
 <?       
           
               $index = 1;
               $i = 1;
               while($s_objectives = $db->fetch_array($result)){
    ?>
        <tr value="">
                        <td align="center" style=" color: black;"><?=$index?></td>
                        <td align="left"><?=$s_objectives["ident_id_run_project"]?>
                        <input type="hidden" id="s_change_log<?=$i?>" name="s_change_log<?=$i?>">
                        <input type="hidden" id="id_incident<?=$i?>" name="id_incident<?=$i?>" value="<?=$s_objectives["id"]?>">
                        </td>
                        <td align="left"><textarea name="txtsummary<?=$i?>" id="txtsummary_<?=$i?>" class="change_log_class" maxlength="300" style="width: 100%px; height: 150px;"><?=$s_objectives["summary"]?></textarea></td>
                        <td align="left"><textarea name="txtnotes<?=$i?>" id="txtnotes_<?=$i?>" class="change_log_class"  style="width: 100%px; height: 150px;"><?=$s_objectives["notes"]?></textarea></td>
                        <td align="left"><textarea type="text" id="referenceno_<?=$i?>" name="referenceno<?=$i?>" class="change_log_class"  style="height: 150px;"><?=$s_objectives["reference_no"]?></textarea></td>
                        <td align="center"><img class ="info_link" id="search" src="../../images/workinfo.jpg" style="cursor: pointer; border: none;" value="<?=$s_objectives["id"]?>"/></td>
                        <td align="left"><textarea name="resolution<?=$i?>" id="resolution_<?=$i?>" class="change_log_class"  style="width: 100%px; height: 150px;"><?=$s_objectives["resolution"]?></textarea></td>
                        <td align="center"><img class ="info_link02" id="so_attach" src="../../images/attach.jpg" style="cursor: pointer; border: none;" value="<?=$s_objectives["id"]?>"/></td>
        </tr>
                 <?php
                 $index++;
                 $i++;
               }//end while
            
         
		 ?>
 </tbody>     
</table>
<input type="hidden" name="lineid" id="lineid" value="<?=$i?>">
<?
  } //end if
 } ?>
        
