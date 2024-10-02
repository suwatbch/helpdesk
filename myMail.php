<html>
<head>
<title>Test Helpdesk Production send e-mail 09-05-16</title>
</head>
<body>
<?
	//$strTo = "dbstneox@gmail.com";
	 $strTo = "seksan.m@samtel.samartcorp.com,seksanmanee@gmail.com";
	//$strTo = "Punnee.E@Portalnet.co.th,Kriengsak.M@Portalnet.co.th,Raksaphan.K@Portalnet.co.th,uthen.p@portalnet.co.th";
	echo "Send e-mail to: ". $strTo;
	$strSubject = "Test Helpdesk Production send e-mail 09-05-16";
	$strHeader = "From: ptn_support@portalnet.co.th";
	$strMessage = "My Body & My Description";
	$flgSend = mail($strTo,$strSubject,$strMessage,$strHeader);  // @ = No Show Error //
	if($flgSend)
	{
		echo " <br/>Status: Email has been sent.";
	}
	else
	{
		echo "<br/> Status: Failure.";
	}
	echo "<br/> This tested text.";
?>
</body>
</html>