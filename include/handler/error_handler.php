<?php
    include_once dirname(dirname(__FILE__))."/config.inc.php";

    function error_handler($message, $title="")
    {
        global $application_path;

        $title = ($title != "") ? $title : Exception;
        $html = " <style type=\"text/css\">\n"
                  . "    .error\n"
                  . "    {\n"
                  . "        background-color: #FFFFCC;\n"
                  . "        color: #FF0000;\n"
                  . "    }\n"
                  . "    h1.error, div.error\n"
                  . "    {\n"
                  . "       margin: 0.5em 0 0.5em 0;\n"
                  . "       border: 0.1em solid #FF0000;\n"
                  . "       width: 98%;\n"
                  . "       background-repeat: no-repeat;\n"
                  . "       background-position: 10px 50%;\n"
                  . "       padding: 10px 10px 10px 36px;\n"
                  . "    }\n"
                  . "    div.error h1\n"
                  . "    {\n"
                  . "        border-bottom: 0.1em solid #FF0000;\n"
                  . "        font-weight: bold;\n"
                  . "        font-size: medium;\n"
                  . "        margin: 0 0 0.2em 0;\n"
                  . "    }\n"
                  . "    .notice\n"
                  . "    {\n"
                  . "        color: #000000;\n"
                  . "        background-color:#FFFFDD;\n"
                  . "    }\n"
                  . "    h1.notice, div.notice\n"
                  . "    {\n"
                  . "        margin: 0.5em 0 0.5em 0;\n"
                  . "        border: 0.1em solid #FFD700;\n"
                  . "        width: 100%;\n"
                  . "        background-repeat:  no-repeat;\n"
                  . "        background-position: 10px 50%;\n"
                  . "        padding: 10px 10px 10px 10px;\n"
                  . "    }\n"
                  . "    .notice h1\n"
                  . "    {\n"
                  . "        border-bottom: 0.1em solid #FFD700;\n"
                  . "        font-weight: bold;\n"
                  . "        margin: 0 0 0.2em 0;\n"
                   . "   }\n"
                   . "</style>\n"
                   . " <div align=\"center\">\n"
                   . " <div class=\"error\" align=\"left\">\n"
                   . "      <h1><img src=\"$application_path/images/exception.png\" alt=\"$title\"/>&nbsp;$title</h1>\n"
                   . "      <div class=\"notice\">".str_replace("\\", "", $message)."</div>\n"
                   . "      <div align=\"right\">\n"
                   . "      <input type=\"button\" value=\"Back\" onclick=\"history.go(-1);\"\n"
                   . "      </div>\n"
                   . "   </div>\n"
                   . "</div>\n";
        die($html);
        //die("<script>window.location.href =\"$root_path/handler/error_page.php?title=$title&message=$message\"</script>");
    }
    
    function error_handler_mysql($sql, $title = "SQL Error")
    {
        $message = mysql_errno()
                          . " - "
                          . mysql_error()
                          . "<br><br>"
                          . "<b><u>SQL</u> :</b> [$sql]";
        error_handler($message, $title);
    }
?>