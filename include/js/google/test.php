<!--
You are free to copy and use this sample in accordance with the terms of the
Apache license (http://www.apache.org/licenses/LICENSE-2.0.html)
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Google Visualization API Sample
    </title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['orgchart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');
        data.addRows(5);
        data.setCell(0, 0, 'Mike');
        data.setCell(0, 2, 'The President');
        data.setCell(1, 0,
            'Jim', 'Jim<br/><font color="red"><i>Vice President<i></font>');
        data.setCell(1, 1, 'Mike');
        data.setCell(2, 0, 'Alicexxxxxxxsssssssssssssssssss<br/>x<br/>x<br/>x');
        data.setCell(2, 1, 'Mike');
        data.setCell(3, 0, 'Bob');
        data.setCell(3, 1, 'Jim');
        data.setCell(3, 2, 'Bob Sponge');
        data.setCell(4, 0, 'Carol');
        data.setCell(4, 1, 'Bob');

        // Create and draw the visualization.
        new google.visualization.OrgChart(document.getElementById('visualization')).
            draw(data, {allowHtml: true, allowCollapse: true});
      }


      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <body style="font-family: Arial;border: 0 none;">
    <div id="visualization" style="width: 300px; height: 300px;"></div>
  </body>
</html>