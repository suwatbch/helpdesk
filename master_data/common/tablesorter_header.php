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
                              
<!--<script type="text/javascript" src="<?=$application_path_js?>/tablesorter-filter/js/complete.js"></script>
<script src="<?=$application_path_js?>/tablesorter-filter/js/jquery-1.4.4.min.js" type="text/javascript"></script>-->
<script src="<?=$application_path_js?>/tablesorter-filter/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=$application_path_js?>/tablesorter-filter/js/jquery.dataTables.columnFilter.js"></script>
<!-- Script -->
<script type="text/javascript">
$(document).ready(function(){

     $('#example').dataTable( {
        "iDisplayLength": <?=$page_len;?>/*$("#txt_length").val()*/
       // "bPaginate": false /* disable select length*/
      });     
});

</script>
<style>
        .Head{
            color: #cfdce7;
        }		
</style>
<input type="hidden" id="txt_length" name="txt_length" value="<?=$page_len;?>"  />
