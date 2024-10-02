<?php
//    require_once "../../include/class/php_header.class.php";
//    require_once "../../include/class/mail.class.php";
//    require_once "../../include/class/util/strUtil.class.php";
//    require_once "../../include/class/util/fileUtil.class.php";
//
//    $action = $_REQUEST["action"];
//    if ($action == "mail"){
//        
//        $to = "Mananya.P@samartcorp.com"; //"urldecode($_REQUEST["email"]);
//        $subject = "Test send email from STAR-DEV"; //urldecode($_REQUEST["subject"]);
//        $message = "Test message"; // urldecode($_REQUEST["message"]);
//    //    $files[] = urldecode($_REQUEST["file"]);
//
//        $result = mail::send($to, $subject, $message, $files);
//
//        php_header::text_html_utf8();
//
//        if ($result){
//            echo "success : $result";
//        } else {
//            echo "error : $result";
//        }  
//        
//    } else {
//        echo "don't send email";
//    }
//    
    
    
    
?>


 <?
    //change this to your email.
    $to = "mananya.p@samartcorp.com";
    $from = "STAR_SYSTEM@samartcorp.com";
    $subject = "Hello! This is HTML email";

    //begin of HTML message
    $message = <<<EOF
<html>
  <body bgcolor="#DCEEFC">
    <center>
        <b>Looool!!! I am reciving HTML email......</b> <br>
        <font color="red">Thanks Mohammed!</font> <br>
        <a href="http://www.maaking.com/">* maaking.com</a>
    </center>
      <br><br>*** Now you Can send HTML Email <br> Regards<br>MOhammed Ahmed - Palestine
  </body>
</html>
EOF;
   //end of message
    $headers  = "From: $from\r\n";
    $headers .= "Content-type: text/html\r\n";

    //options to send to cc+bcc
    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]";
    //$headers .= "Bcc: [email]email@maaking.cXom[/email]";
    
    // now lets send the email.
    mail("mananya.p@samartcorp.com", "test send email from STAR", $message, $headers);

    echo "Message has been sent....!";
?> 
