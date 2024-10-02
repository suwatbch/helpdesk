<?php
//We've included ../Includes/FusionCharts.php, which contains functions
//to help us easily embed the charts.
include("lib/FusionCharts.php");
?>
<HTML>
   <HEAD>
      <TITLE>FusionCharts - Form Based Data Charting Example</TITLE>
      <SCRIPT LANGUAGE="Javascript" SRC="js/FusionCharts.js"></SCRIPT>
   </HEAD>
   <BODY>

<?php   

   //We first request the data from the form (Default.php)
   $used = 0;
   $free = 20;

   //Now that we've the data in variables, we need to convert this into XML.
   //The simplest method to convert data into XML is using string concatenation. 

   //Initialize <graph> element
   $strXML  = "<graph caption='Folder Capacity' subCaption='' showPercentValues='1' pieSliceDepth='20' showNames='1' decimalPrecision='0' >";
   //Add all data
   $strXML .= "<set name='Used' value='" . $used . "' />";
   $strXML .= "<set name='free' value='" . $free . "' />";
   //Close <graph> element
   $strXML .= "</graph>";
   
   echo renderChart("swf/FCF_Pie3D.swf", "", $strXML, "Sales", 400, 350, "", "");
  
?>

</BODY>
</HTML>


