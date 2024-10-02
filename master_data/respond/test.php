<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>Jquery Time Picker Example By Deawx </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css">
<style>
		body,img,p,h1,h2,h3,h4,h5,h6,form,table,td,ul,li,dl,dt,dd,pre,blockquote,fieldset,label{
				margin:0;
				padding:0;
				border:0;
			}
/* css for timepicker */
.clear{ clear: both; }
#ui-datepicker-div, .ui-datepicker{ font-size: 80%; }

.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
.ui-timepicker-div dl { text-align: left; }
.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
.ui-timepicker-div td { font-size: 90%; }
.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
</style>
  <script type="text/javascript" src="  https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" src="http://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js"></script>
        

 </head>

 <body>
  <script>
$(function(){
 		
//แบบมี OPTION		
$('#timer').timepicker({
	timeOnlyTitle: 'เลือกเวลา',
	timeText: 'เวลา',
	hourText: 'ชั่วโมง',
	minuteText: 'นาที',
	secondText: 'วินาที',
	currentText: 'ปัจจุบัน',
	closeText: 'ปิด',
//timeFormat: 'hh:mm:ss',
//showSecond: true,
ampm: true,
	hourGrid: 4,
	minuteGrid: 10
});
 
//หรือจะใช้แบบไม่มี Option ก็ใช้แบบนี้ได้ครับ บรรทัดเดียวจบเลย ได้ทั้งปฏิทินและเวลา
//$('#timer').timepicker();
});

  </script>
  <input type="text" name="timer" id="timer" value=""  />

 </body>
</html>
