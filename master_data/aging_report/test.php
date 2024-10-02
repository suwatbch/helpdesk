<script type="text/javascript"> 
    // When the document is ready set up our sortable with it's inherant function(s) 
    $(document).ready(function() { 
        $("#example_test tbody").sortable({ 
            handle : '.handle', 
            update : function () { 
                var order = $(this).sortable('serialize'); 
                $("#info").load("test1.php?"+order); 
            } 
        }); 
    }); 
</script>
<pre> 
    <div id="info">Waiting for update</div> 
</pre> 
 
 <table cellpadding="0" cellspacing="0" border="0"  class="display" id="example_test" style="width:100%">
     <tbody>
         <tr id="listItem_1">
             <td>
                 <img src="../../images/arrow.png" alt="move" width="16" height="16" class="handle" /> 
        <strong>Item 1 </strong>with a link to <a href="http://www.google.co.uk/" rel="nofollow">Google</a> 
                 
             </td>
             
         </tr>
         <tr id="listItem_2">
             <td>
             <img src="arrow.png" alt="move" width="16" height="16" class="handle" /> 
        <strong>Item 2</strong> 
             </td>
         </tr>
         <tr id="listItem_3">
             <td>
        <img src="arrow.png" alt="move" width="16" height="16" class="handle" /> 
        <strong>Item 3</strong> 
             </td>
 </tr>
   <tr id="listItem_4">
       <td>
        <img src="arrow.png" alt="move" width="16" height="16" class="handle" /> 
        <strong>Item 4</strong> 
       </td>
 </tr>
     </tbody>
</table>
 
<form action="test1.php" method="post" name="sortables"> 
    <input type="hidden" name="test-log" id="test-log" /> 
</form>