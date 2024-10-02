<?php
    include_once "../include/class/db/db.php";
    include_once "../include/class/php_header.class.php";
    include_once '../include/class/util/strUtil.class.php';
    include_once "../include/class/model/helpdesk_user.class.php";

    $criteria = array(
        "employee_code" => $_REQUEST["employee_code"]
        , "employee_name" => $_REQUEST["employee_name"]
        , "monthly" => $_REQUEST["monthly_per"]
//        , "sale_not_allow" => $_REQUEST["sale_not_allow"]
    );

    $user = new helpdesk_user($db);
    $arr_employee = $user->searchuser($criteria);
    $db->close();

//    echo count($arr_employee); exit();
    if (count($arr_employee["data"]) > 0){
        $respone = " <table width=\"550px\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"data-table\" style=\"margin-left: 5px;\">\n"
                         . "    <tbody>\n";

        foreach ($arr_employee["data"] as $employee){
            $respone .= "       <tr style=\"cursor: pointer;\" value=\"{$employee["user_id"]}\">\n"
                              . "          <td width=\"200px\" align=\"center\">{$employee["employee_code"]}</td>\n"
                              . "         <td width=\"378px\" style='padding-left: 5px'>".$employee["user_full_name"]."</td>\n"
                              . "      </tr>\n";
        }

        $respone .= "    </tbody>\n"
                          . " </table>";

        php_header::text_html_utf8();
        echo $respone;
    }
?>