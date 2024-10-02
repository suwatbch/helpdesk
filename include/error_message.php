<?php
    include_once "class/util/strUtil.class.php";
    
     #  Error Message
    define("MESSAGE_SAVE_COMPLETE", "Save Complete !!");
    
    # message status
    define("SUCCESS_MESSAGE", "success");
    define("WARNING_MESSAGE", "warning");
    define("INFO_MESSAGE", "info");
    define("ERROR_MESSAGE", "error");


    function message_field_duplicate($description){
        return "$description is duplicate !!";
    }
    
    function message_field_messing_input($description){
        return "$description is messing input !!";
    }
    
    function alert_message($message, $script_continue="",$status_message = "info"){
        if (strUtil::isNotEmpty($message)){
            echo "<script>setTimeout('jAlert(\"$status_message\", \"$message\", \" HELPDESK SYSTEM  :  Message \", \"$script_continue\")', 150);</script>";
//            echo "<script>jAlert(\"$status_message\", \"$message\", \"Helpdesk System : Messages\", \"$script_continue\");</script>";
        }
    }
    
    function alert_message_simple($message, $script_continue=""){
         if (strUtil::isNotEmpty($message)){
            echo "<script>setTimeout('alert(\"$message\"); $script_continue', 150);</script>";
        }
    }
    
    function message_not_found_incident_id($description){
        return "Error!! not found Incident: $description";
    }
?>
