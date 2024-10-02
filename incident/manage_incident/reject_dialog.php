<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Reason for Reject</title>
        <base target="_self"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link type="text/css" rel="stylesheet" href="../../include/css/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="../../include/css/dialog.css"/>
        <script type="text/javascript" src="../../include/config.js.php"></script>
        <script type="text/javascript" src="../../include/js/function.js"></script>
        <script type="text/javascript" src="../../include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="../../include/js/srs/form.js"></script>
        <script type="text/javascript">
 $(document).ready(function(){
     $("#reason").focus();
 });
 
 $(function(){
     $("#ok").click(function(){
        var value = $("#reason").val();
        if ($.trim(value) == ""){
            jAlert('warning', 'Please input reason.', 'Helpdesk System : Messages');
//            $("#error").val('Please input reason');
//            $("#error").css("forecolor", "red")
        } else {
            window.parent.reject_reason(value,"Y") 
        }
     });
        
        
     $("#cancel").click(function(){
           window.parent.reject_reason("","N")
        });
     });
        
                
                
                
        
                
        </script>
    </head>
    <body>
        <form name="frmMain" method="post" action="" height="90%">
            
            <table width="100%" border="0" cellpadding="0" cellspacing="1" style="margin-left: 5px;margin-right: 5px;">
                <thead>
                    <tr>
                        <td align="left">Please Input Reason For Reject Activity Plan
                            <label id="error"></label></td>
                        
                    </tr>
                </thead>
                <tbody>
                    <td align="center"><br>
                        <textarea id="reason" style="width: 70%; height: 120px" ></textarea>
                    </td>
                    
                </tbody>
            </table>
            <div id="divbutton" style="text-align: center">
                <input type="button" id="ok" value="OK" style="width: 60px; margin-right: 5px;" class="input-button"/>
                <input type="button" id="cancel" value="Cancel" style="width: 60px;" class="input-button"/>
            </div>
           
            <input type="hidden" name="selected" id="selected" value="<?=$_REQUEST["selected"]?>"/>
        </form>
    </body>
</html>
