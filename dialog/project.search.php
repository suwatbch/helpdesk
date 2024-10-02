<?php
    include_once "../include/class/db/db.php";
    include_once "../include/class/php_header.class.php";
    include_once "../include/class/model/project.class.php";

    $criteria = array(
        "project_code" => $_REQUEST["project_code"]
        , "project_name" => $_REQUEST["project_name"]
        , "sale_group_id" => $_REQUEST["sale_group_id"]
        , "customer_id" => $_REQUEST["customer_id"]
    );

    $p = new project($db);
    $arr_project = $p->searchLookup($criteria);
    $db->close();

    if (count($arr_project) > 0){
        $respone = " <table width=\"628px\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"data-table\" style=\"margin-left: 5px;\">\n"
                         . "    <tbody>\n";

        foreach ($arr_project as $project){
            $respone .= "       <tr style=\"cursor: pointer;\" value=\"{$project["project_id"]}\">\n"
                              . "          <td width=\"170px\" align=\"center\">{$project["project_code"]}</td>\n"
                              . "          <td width=\"458px\">{$project["project_name"]}</td>\n"
                              . "       </tr>\n";
        }
        
        $respone .= "    </tbody>\n"
                          . " </table>";

        php_header::text_html_utf8();
        echo $respone;
    }
?>