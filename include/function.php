<?php
    function selected($value, $value_selected, $default_value = ""){
        if ($value == $value_selected){
            return "selected";
        } else if ($default_value != "" && $default_value == $value){
            return "selected";
        }

        return "";
    }

    function checked($value, $value_checked, $default_value = ""){
        if ($value == $value_checked){
            return "checked";
        } else if ($default_value != "" && $default_value == $value){
            return "checked";
        }

        return "";
    }

    function show_message($type,$message,$btn_name,$link,$btn_name1="",$link1=""){
        $txt_icon = "/paperless/images/".strtolower($type).".png";
        $title= strtoupper($type);
        
        echo "<div align='center'>";
        echo "  <div class='$type' align='left'>";
        echo "        <h1><img src=$txt_icon alt='$title'/>&nbsp;$title</h1>";
        echo "        <div class='notice'>$message</div>";
        echo "        <div align='center'>";
        echo "            <input type='button' name='btn_button' class='input-button' value='$btn_name' onclick='$link'>";
        if (($btn_name1)!="")
        {
            echo "            <input type='button' name='btn_button' class='input-button' value='$btn_name1' onclick='$link1'>";
        }
        echo "        </div>";
        echo "    </div>";
        echo "</div>";
     }

     
?>