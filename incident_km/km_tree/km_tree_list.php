<?php
    include_once "../../include/config.inc.php";
    include_once "../../include/class/db/db.php";
    include_once "km_tree_list.action.php";
    include_once "../../master_data/common/tablesorter_header.php";
?>
<script type="text/javascript" language="javascript">
$(function(){
 $("#dialog-show_km_process").dialog({
				height: 400
				, width: 640
				, autoOpen: false
				, modal: true
				, resizable: false
				, close : function(){
					$("#ifr_show_km_process").attr("src", "");
				}
		});
 $('.info_link').click(function(event){
      var href = $(this).attr('href');
      $("#ifr_show_km_process").attr("src", href);
      $("#dialog-show_km_process").dialog("open");
      event.preventDefault();
      
    });
$("#btn_search").click(function(){
      page_submit("index.php?action=km_tree_list.php&prd_tier_id1="+$("#prd_tier_id1").val()+"&prd_tier_id2="+$("#prd_tier_id2").val()+
     "&prd_tier_id3="+$("#prd_tier_id1").val()+"&s_mode=search", "");  
});

$('#search_key_words').keypress(function(event) {
                    if (event.keyCode == 13) {
                        page_submit("index.php?action=km_tree_list.php&prd_tier_id1="+$("#prd_tier_id1").val()+"&prd_tier_id2="+$("#prd_tier_id2").val()+
     "&prd_tier_id3="+$("#prd_tier_id1").val()+"&s_mode=search", ""); 
                    }
                });
});
    </script>
<br>
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
    <tr>
        <td width="70%" align="left">
            <a href="index.php?action=km_tree_list.php"><img src="<?=$application_path_images;?>/floder1.jpg" title="delete" style="padding-bottom: 4px;vertical-align: middle;"/>Incident KM</a>
 
<?if($_REQUEST["prd_tier_id1"]!= ""){ ?>
<a href="index.php?action=km_tree_list.php&prd_tier_id1=<?=$_REQUEST["prd_tier_id1"]?>&name_link1=<?=$_REQUEST["name_link1"]?>">
    <img src="<?=$application_path_images;?>/link_right.png" style=" padding-bottom: 4px;vertical-align: middle;"/><?=$_REQUEST["name_link1"]?></a>

<?}if($_REQUEST["prd_tier_id1"]!= "" && $_REQUEST["prd_tier_id2"]!= ""){ ?>
<a href="index.php?action=km_tree_list.php&prd_tier_id1=<?=$_REQUEST["prd_tier_id1"]?>&prd_tier_id2=<?=$_REQUEST["prd_tier_id2"]?>&name_link1=<?=$_REQUEST["name_link1"]?>&name_link2=<?=$_REQUEST["name_link2"]?>">
    <img src="<?=$application_path_images;?>/link_right.png" style=" padding-bottom: 4px;vertical-align: middle;"/><?=$_REQUEST["name_link2"]?></a>

<?}if($_REQUEST["prd_tier_id1"]!= "" && $_REQUEST["prd_tier_id2"]!= "" && $_REQUEST["prd_tier_id3"]!= ""){ ?> 
<a href="index.php?action=km_tree_list.php&prd_tier_id1=<?=$_REQUEST["prd_tier_id1"]?>&prd_tier_id2=<?=$_REQUEST["prd_tier_id2"]?>&prd_tier_id3=<?=$_REQUEST["prd_tier_id3"]?>&name_link1=<?=$_REQUEST["name_link1"]?>&name_link2=<?=$_REQUEST["name_link2"]?>&name_link3=<?=$_REQUEST["name_link3"]?>">
    <img src="<?=$application_path_images;?>/link_right.png" style="padding-bottom: 4px;vertical-align: middle;"/><?=$_REQUEST["name_link3"]?></a>
<? } ?>
        </td>
        <td align="right" width="30%">
            <input type="text" id="search_key_words" placeholder="Key Words Search" name="search_key_words" value="<?=$_REQUEST["search_key_words"]?>" style="width: 90%">
            <img id="btn_search" src="../../images/find.png" alt="Find Keywords" style="padding-bottom: 4px;vertical-align: middle; cursor: pointer;"/>
        </td>
    </tr>
</table>
<br><br>
<? if (count($objective_list) > 0){ ?>
<div class="full_width" style="overflow: auto; height: 540px; ">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    <thead>
        <tr>
            <th><span class="Head"></span></th>
             <th><span class="Head">Production Class 1</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
          foreach ($objective_list as $s_objective) {
    ?>
        <tr>
            <td width="3%"><img src="<?=$application_path_images;?>/floder.jpg" title="delete" style="cursor: pointer; border: none;" /></td>
            <? if($_REQUEST["prd_tier_id1"]=="" && $_REQUEST["prd_tier_id2"]=="" ){ ?>
            <td align="left"><a href="index.php?action=km_tree_list.php&prd_tier_id1=<?=$s_objective["prd_tier_id"]?>&name_link1=<?=$s_objective["prd_tier_name"]?>"><?=$s_objective["prd_tier_name"]?></a></td>
            <?} else if($_REQUEST["prd_tier_id1"]!= "" && $_REQUEST["prd_tier_id2"]== ""){ ?>
            <td align="left"><a href="index.php?action=km_tree_list.php&prd_tier_id1=<?=$_REQUEST["prd_tier_id1"]?>&prd_tier_id2=<?=$s_objective["prd_tier_id"]?>&name_link1=<?=$_REQUEST["name_link1"]?>&name_link2=<?=$s_objective["prd_tier_name"]?>"><?=$s_objective["prd_tier_name"]?></a></td>
            <? }else if($_REQUEST["prd_tier_id1"]!= "" && $_REQUEST["prd_tier_id2"]!= ""){ ?>
            <td align="left"><a href="index.php?action=km_tree_list.php&prd_tier_id1=<?=$_REQUEST["prd_tier_id1"]?>&prd_tier_id2=<?=$_REQUEST["prd_tier_id2"]?>&prd_tier_id3=<?=$s_objective["prd_tier_id"]?>&name_link1=<?=$_REQUEST["name_link1"]?>&name_link2=<?=$_REQUEST["name_link2"]?>&name_link3=<?=$s_objective["prd_tier_name"]?>"><?=$s_objective["prd_tier_name"]?></a></td>
            <? } ?>
        </tr>
                 <?php 		
		 		 }//end foreach
                        ?>
       
    </tbody>
</table>
</div>
<? } 
    if(count($objective_km) > 0 || $_REQUEST["s_mode"]== "search"){?>
<div class="full_width" style="overflow: auto; height: 540px; ">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    <thead>
        <tr>
            <th><span class="Head">KM ID</span></th>
            <th><span class="Head">ID Incident</span></th>
            <th><span class="Head">Summarize</span></th>
             <th><span class="Head">Detail</span></th>
            <th><span class="Head">Resolution</span></th>
            <th><span class="Head">Product Class 1</span></th>
            <th><span class="Head">Product Class 2</span></th>
            <th><span class="Head">Product Class 3</span></th>
            <th><span class="Head">Resloved By</span></th>
            <th><span class="Head">Resloved Date</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
            global $db, $total_row_attach, $att;
        //////////////////////////////////////////////////identify km/////////////////////////////////////////////////
            if(count($objective_km) > 0){
               foreach ($objective_km as $s_objective) {
                   
            $sql = "select count(attach_id) as total_row_attach from helpdesk_tr_attachment where km_id = '{$s_objective["km_id"]}'";
            $result = $db->query($sql);
            $objective_att = $db->fetch_array($result);
            $total_row_attach = $objective_att["total_row_attach"];
    ?>
        <tr>
                        <td align="center"><a class="info_link" href="../../incident_km/km_base/km_base_show.php?km_id=<?=$s_objective["km_id"]?>"><?=$s_objective["km_no"]?></a></td>
                        <td align="center"><? if($s_objective["ident_id_run_project"] != ""){ echo $s_objective["ident_id_run_project"]; } else { echo "-";}?></td>
                        <td align="left"><?=$s_objective["summary"]?></td>
                        <td align="left"><?=$s_objective["detail"]?></td>
                        <td align="left"><?=$s_objective["resolution"]?></td>
                        <td align="left"><?=$s_objective["prd_name1"]?></td>
                        <td align="left"><?=$s_objective["prd_name2"]?></td>
                        <td align="left"><?=$s_objective["prd_name3"]?></td>
                        <td align="left"><?=$s_objective["reslove_by"]?></td>
                        <td align="left"><?=$s_objective["resolved_date"]?></td> 
        </tr>
                 <?php 		
		 		 }//end foreach
            }
		 ?>
    </tbody>
</table>
    <div id="dialog-show_km_process" title="Knowledge Management Base">
    <iframe id="ifr_show_km_process" frameborder="0" scrolling="no" width="100%" height="100%" src=""></iframe>
</div>
</div>
<? } //end if ?>
<input type="hidden" id="prd_tier_id1" name="prd_tier_id1" value="<?=$_REQUEST["prd_tier_id1"]?>">
<input type="hidden" id="prd_tier_id2" name="prd_tier_id2" value="<?=$_REQUEST["prd_tier_id2"]?>">
<input type="hidden" id="prd_tier_id3" name="prd_tier_id3" value="<?=$_REQUEST["prd_tier_id3"]?>">

<input type="hidden" id="name_link1" name="name_link1" value="<?=$_REQUEST["name_link1"]?>">
<input type="hidden" id="name_link2" name="name_link2" value="<?=$_REQUEST["name_link2"]?>">
<input type="hidden" id="name_link3" name="name_link3" value="<?=$_REQUEST["name_link3"]?>">

    


