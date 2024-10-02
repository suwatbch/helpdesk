<link type="text/css" rel="stylesheet" href="../../include/css/report.css"/>
<style type="text/css" media="print">
    #export{
        display: none;
    }
</style>
<br>
<div align="center" id="export">
    
    <table width="20%">
       
        <tr>
            <td style="width: 50%; text-align: center;"><div id="export_excel" name="export_excel">Export</div></td>
            <td style="width: 50%; text-align: center;">
         <?if ($print != "N"){?>
                <div id="export_print" name="export_print" onclick="window.print();">Print</div>
        <?}?>
            </td>
        </tr>
        
    </table>
    
    
    <!--<button id="printbutton" onclick="window.print();" />-->
</div>
<br>