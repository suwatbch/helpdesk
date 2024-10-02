<?php
    include_once "../../include/config.inc.php";
    include_once "../../include/class/db/db.php";
    include_once "km_base_list.action.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title></title>
        <base target="_self"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
       <link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
    <link type="text/css" rel="stylesheet" href="../../include/js/jquery/ui/themes/redmond/jquery-ui-1.8.13.custom.css" />
    <script type="text/javascript" src="../../include/js/jquery/jquery-1.5.1.js"></script>
    <script type="text/javascript" src="../../include/js/jquery/ui/jquery-ui-1.8.13.custom.min.js"></script>
    <script type="text/javascript" src="../../include/js/srs/form.js"></script>

<? //include_once "../../master_data/common/tablesorter_header.php"; ?>
     <?
 $page_len = 30;
?>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">

<style type="text/css" media="screen">
    
        @import "<?=$application_path_js?>/tablesorter-filter/css/demo_table.css";
        .dataTables_info { padding-top: 0; }
        .dataTables_paginate { padding-top: 0; }
        .css_right { float: right; }
        #example_wrapper .fg-toolbar { font-size: 0.8em }
        #theme_links span { float: left; padding: 2px 10px; }
</style>
                              
<script src="<?=$application_path_js?>/tablesorter-filter/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$application_path_js?>/tablesorter-filter/js/jquery.dataTables.columnFilter.js"></script>
<style>
        .Head{
            color: #cfdce7;
        }		
</style>
<input type="hidden" id="txt_length" name="txt_length" value="<?=$page_len;?>"  />
            <script type="text/javascript">
$(document).ready(function(){

     $('#example').dataTable( {
        "iDisplayLength": <?=$page_len;?>,/*$("#txt_length").val()*/
       // "bSort" : false
       "aaSorting": [[7,'desc'], [0,'asc']]
      });  
      });
	 
</script>
        <script type="text/javascript" language="javascript">
$(function(){
 
$("#dialog-show_km_process").dialog({
				height: 380
				, width: 750
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

 $("img[alt=copy_km]").live('click', function() { 
            var data_object = $(this).attr("value");
            window.parent.copy_to_km(data_object);
            ////            var arr_object = data_object.split('|');
//            $("#cus_area_id").val(arr_object['0']);
//            $("#area_cus").val(arr_object['1']);
//          validate_delete();
        });
    
});

    
</script>
    </head>
    <body>
<div class="full_width" style="overflow-y: auto; height: 400px;" style="font-size: 20px;">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%; font-size: 11px;" >
    <thead>
        <tr>
<!--            <th width="2%"><span class="Head">No.</span></th>-->
           
            <th><span class="Head">KM ID</span></th>
             <th><span class="Head">ID Incident</span></th>
            <th><span class="Head">Summarize</span></th>
             <th><span class="Head">Detail</span></th>
            <th><span class="Head">Resolution</span></th>
            <th><span class="Head">Attach Files</span></th>
            <th><span class="Head">Resolutin By</span></th>
            <th><span class="Head">Raking</span></th>
            <th width="5%"><span class="Head">Helpful</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            $index=1;
            global $db, $total_row_attach, $att;
        //////////////////////////////////////////////////identify km/////////////////////////////////////////////////
        if (count($objective_km) > 0){
 
               foreach ($objective_km as $s_objective) {
                   
            $sql = "select attach_id,attach_name,location_name from helpdesk_tr_attachment where km_id = '{$s_objective["km_id"]}'";
            $result = $db->query($sql);  
            $total_row_attach = $db->num_rows($result);
           
    ?>
        <tr>
<!--            <td width="1%"><?=$index++;?></td>-->
                        
                        <td align="center"><div style="overflow-y: auto; height: 100px;">
                                <? if($s_objective["km_id"]!=0){?>
                                <a class="info_link" href="../../incident_km/km_base/km_base_show.php?km_id=<?=$s_objective["km_id"]?>&action=km_process"><?=$s_objective["km_no"]?></a>
                                <?
                                }else{
                                    echo "-";
                                }
?>
                            </div></td>
                        <td align="center"><div style="overflow-y: auto; height: 100px;">
                                <? if($s_objective["ident_id_run_project"] != ""){
                                    echo $s_objective["ident_id_run_project"];
                                }else{ echo "-"; }
?>
                            </div></td>
                        <td align="left" width="15%"><div style="overflow-y: auto; height: 100px;"><?=$s_objective["summary"]?></div></td>
                        <td align="left" width="15%"><div style="overflow-y: auto; height: 100px;"><?=$s_objective["detail"]?></div></td>
                        <td align="left" width="15%"><div style="overflow-y: auto; height: 100px;"><?=$s_objective["resolution"]?></div></td>
                        <td align="left" width="15%">
                            <div style="overflow-y: auto; height: 100px;">
                                <? if($total_row_attach > 0){
                                     while($fetch_file = $db->fetch_array($result)){?>
                                <a href="../../incident_km/temp_identify/<?=$fetch_file["location_name"]?>" target="_blank"><?=htmlspecialchars($fetch_file["attach_name"])?></a>
                                         <?
                                     }
                                }
                                 ?>
                            </div></td>
                        <td align="left" width="5%"><div style="overflow-y: auto; height: 100px;"><?=$s_objective["reslove_by"]?></div></td>
                        <td align="center" width="3%"><div style="overflow-y: auto; height: 100px;"><?=$s_objective["ranking"]?></div></td>
                        <td align="center" width="1%"><img src="../../images/like.jpg" id="copy_km" name="copy_km" alt="copy_km" style="cursor: pointer; border: none;" value="<?=$s_objective["km_id"]?>"></td>
                        
        </tr>
                 <?php 		
		 		 }//end foreach
		 	} //end if
		 ?>
    </tbody>
</table>
</div>
<input type="hidden" id ="select_unrelease" name="select_unrelease" value="">
<div id="dialog-show_km_process" title="Knowledge Management Base">
    <iframe id="ifr_show_km_process" frameborder="0" scrolling="no" width="100%" height="100%" src=""></iframe>
</div>
    </body>
</html>


    


