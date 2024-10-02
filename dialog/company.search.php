<?php
    include_once "../include/class/db/db.php";
    include_once "../include/class/php_header.class.php";
    include_once "../include/class/util/strUtil.class.php";
    include_once "../include/class/model/company.class.php";

    $carteria = array(
        "company_code" => $_REQUEST["company_code"]
        , "company_name" => $_REQUEST["company_name"]
    );

    $comp = new company($db);
    $arr_company = $comp->searchLookup($carteria);
    $db->close();

    if (count($arr_company) > 0){
        $respone = " <table width=\"578px\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"data-table\" style=\"margin-left: 5px;\">\n"
                         . "    <tbody>\n";

        foreach ($arr_company as $company){
            $respone .= "       <tr style=\"cursor: pointer;\" value=\"{$company["company_id"]}\">\n"
                              . "          <td width=\"110px\" align=\"center\">{$company["company_code"]}</td>\n"
                              . "         <td width=\"468px\">".htmlspecialchars($company["company_name"])."</td>\n"
                              . "      </tr>\n";
        }

        $respone .= "    </tbody>\n"
                          . " </table>";

        php_header::text_html_utf8();
        echo $respone;
    }
?>