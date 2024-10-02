<?php
    include_once "../../include/config.inc.php";
    include_once "incident_list.action.php";
    include_once dirname(dirname(__FILE__))."/manage_incident/incident.getrunning.php";

    if($incident_list["data"]){ $arr_incident_list = $incident_list["data"]; }
    if($incident_list["total_row"]){ $total_row = $incident_list["total_row"]; }
    $mode = $_GET["mode"];

    $page_len = 30;
    
    if(!$_SESSION["_pagelength"]){
        $_SESSION["_pagelength"] = 30;
        
    }

    $page_len = $_SESSION["_pagelength"];
?>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">

<style type="text/css" media="screen">
    
        /*@import "<?=$application_path_js?>/tablesorter-filter/css/demo_page.css";*/
        @import "<?=$application_path_js?>/tablesorter-filter/css/demo_table.css";
        /*@import "http://www.datatables.net/media/css/site_jui.ccss";*/
        /*@import "<?=$application_path_js?>/tablesorter-filter/css/demo_table_jui.css";*/
        /*@import "<?=$application_path_js?>/tablesorter-filter/css/themes/base/jquery-ui.css";*/
        /*@import "<?=$application_path_js?>/tablesorter-filter/css/themes/smoothness/jquery-ui-1.7.2.custom.css";*/
        /*
         * Override styles needed due to the mix of three different CSS sources! For proper examples
         * please see the themes example in the 'Examples' section of this site
         */
        .dataTables_info { padding-top: 0; }
        .dataTables_paginate { padding-top: 0; }
        .css_right { float: right; }
        #example_wrapper .fg-toolbar { font-size: 0.8em }
        #theme_links span { float: left; padding: 2px 10px; }
</style>
                              
<script type="text/javascript" src="<?=$application_path_js?>/tablesorter-filter/js/complete.js"></script>
<script src="<?=$application_path_js?>/tablesorter-filter/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script src="<?=$application_path_js?>/tablesorter-filter/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$application_path_js?>/tablesorter-filter/js/jquery.dataTables.columnFilter.js"></script>
<!-- Script -->
<script type="text/javascript">
$(document).ready(function(){

     $('#example').dataTable( {
        "iDisplayLength": <?=$page_len;?> /*$("#txt_length").val()*/
//        "bPaginate": false /* disable select length*/
      } );
      

      $("#example_length").change(function(){
          $.ajax({
            type: "POST",
            url: "session_length.php",
            data: {len:$("#example_length :selected").text()},
            success: function(response){
                $("#txt_length").val(response);
            }
           });
    });
      
});

</script>
<script type="text/javascript">

		    var _gaq = _gaq || [];
		    _gaq.push(['_setAccount', 'UA-17838786-4']);
		    _gaq.push(['_trackPageview']);

		    (function () {
		        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		    })();

</script>
<style>
        .Head{
            color: #cfdce7;
        }
    
    
		
		
</style>
<!-- Start AJAX -->
<script language="JavaScript">
function showIncident(str)
{
	//alert(str);
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("DetailTab_Span").innerHTML =xmlhttp.responseText;
    }
  }
  
xmlhttp.open("GET","incident_list.tab.detail.php?incdID="+str,true);
xmlhttp.send();
}
</script>

<!-- End AJAX -->
<div style="height:680px; overflow-y: auto;">
<input type="hidden" id="txt_length" name="txt_length" value="<?=$page_len;?>"  />
<div class="full_width">
  
    
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="width:100%">
    
    <thead>
        <tr>
            <!--<th width="5%"></th>-->
            <th width="12%"><span class="Head">ID</span></th>
            <th width="23%"><span class="Head">Summarize</span></th>
            <th width="7%"><span class="Head">Priority</span></th>
            <th width="13%"><span class="Head">Status</span></th>
            <!--<th width="10%"><span class="Head">Assigned Grp</span></th>-->
            <th width="14%"><span class="Head">Assigned Subgrp</span></th>
            <th width="10%"><span class="Head">Assignee</span></th>
            <th width="8%"><span class="Head">Prd Class3</span></th>
            <th width="10%"><span class="Head">Owner</span></th>
            <th width="5%"><span class="Head">Create Date</span></th>
        </tr>
    </thead>
    <tbody>
    <?php
            if (count($arr_incident_list) > 0){ 
                #ทำการวนลูปเพื่อแสดงข้อมูลในตาราง incident list
                foreach ($arr_incident_list as $incident_list) {
                    $id = $incident_list["id"];
                    $id_code = incident_getrunning($incident_list["id"],$incident_list["ident_id_run_project"]);
                    $summary = $incident_list["summary"];
					if (strlen($summary) > 25){
						$summary = iconv_substr($incident_list["summary"], 0, 25, "UTF-8")."...";
					}

                    
                    $priority_desc = $incident_list["priority_desc"];
                    $status_id = $incident_list["status_id"];
                    $status_desc = $incident_list["status_desc"];
                    $assign_group = $incident_list["assign_group"];
                    $assign_subgroup = $incident_list["assign_subgroup"];
                    $assignee = $incident_list["assignee_dp"];
                    $owner = $incident_list["owner"];
                    $temp = split("-", $incident_list["class3_name"]);
                    $class3_name = $temp[0];
                    $str = $id;
                    $create_date_dp = $incident_list["create_inc_display"];
                    
					
					
					
        ?>
        
        <tr>
            <!--<td>.</td>-->
            <td width="12%" align="center"><a id="link_inc[]" href="../../home_incident.php?incident_id=<?=$id?>&mode=<?=$_GET["mode"];?>&len=" target="_top"><?=$id_code;?></a></td>
            <td width="23%" align="left"><?=$summary;?></td>
            <td width="7%" align="center"><?=$priority_desc;?></td>
            <td width="13%" align="center"><?=$status_desc;?></td>
            <td width="14%"><?=$assign_subgroup;?></td>
            <td width="10%"><?=$assignee;?></td>
            <td width="8%"><?=$class3_name;?></td>
            <td width="10%"><?=$owner;?></td>
            <td width="5%"><?=$create_date_dp;?></td>
        </tr>
         <?php 		
		 		 }//end foreach
		 	} //end if
		 
//				$_SESSION["$incident_list"]=$incident_list;
		 ?>
        </tr>
    </tbody>
</table>

    
</div>
</div>



    


