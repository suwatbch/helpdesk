<?php
	session_start();
    include_once "../include/class/db/db.php";
    include_once "../include/class/php_header.class.php";
    include_once "../include/class/util/strUtil.class.php";
    include_once "../include/class/model/helpdesk_customer.class.php";
	include_once "../include/class/user_session.class.php";
	
    $criteria = array(
        "code_cus" => $_REQUEST["code_cus"]
        , "first_name" => $_REQUEST["first_name"]
        , "last_name" => $_REQUEST["last_name"]
        , "area_cus" => $_REQUEST["area_cus"]
    );
            $customer = new helpdesk_customer($db);
            $ss_customer = $customer->getByCustomer($criteria);
            $s_customer = $ss_customer["arr_customer"];
			

    if (count($ss_customer["total_row"]) > 0){
        $respone = " <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"data-table\">\n"
                         . "    <tbody>\n";

        foreach ($s_customer as $c){
            $respone .= "       <tr style=\"cursor: pointer;\" value=\"{$c["cus_id"]}\">\n"
                              . "          <td width=\"85px\" align=\"center\">".$c["code_cus"]."</td>\n"
                              . "         <td width=\"120px\">".$c["firstname_cus"]."</td>\n"
                              . "         <td width=\"120px\">".$c["lastname_cus"]."</td>\n"
                              . "         <td width=\"150px\" name=\"cus_company_name\">".$c["cus_company_name"]."</td>\n"
                              . "         <td style=\"display : none\" name=\"phone_cus\">".$c["phone_cus"]."</td>\n"
                              . "         <td style=\"display : none\" name=\"address\">".$c["ipaddress_cus"]."</td>\n"
                            . "         <td style=\"display : none\" name=\"address\">".$c["email_cus"]."</td>\n"
                            . "         <td style=\"display : none\" name=\"address\">".$c["cus_company_id"]."</td>\n"
                            . "         <td style=\"display : none\" width=\"150px\" name=\"address\">".$c["cus_org_name"]."</td>\n"
                            . "         <td style=\"display : none\" name=\"address\">".$c["area_cus"]."</td>\n"
                            . "         <td style=\"display : none\" name=\"address\">".$c["office_cus"]."</td>\n"
                            . "         <td style=\"display : none\" name=\"address\">".$c["dep_cus"]."</td>\n"
                            . "         <td style=\"display : none\" name=\"address\">".$c["site_cus"]."</td>\n"
                            . "         <td style=\"display : none\" name=\"address\">".$c["keyuser"]."</td>\n"
                            . "         <td  name=\"address\">".$c["area_cus_name"]."</td>\n"
							. "         <td style=\"display : none\" name=\"cus_id\">".$c["cus_id"]."</td>\n"
                              . "      </tr>\n";
        }

        $respone .= "    </tbody>\n"
                          . " </table>";

        php_header::text_html_utf8();
        echo $respone;
    }else{
        $respone = " <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"data-table\">\n"
                         . "    <tbody>\n";

            $respone .= "<tr>\n"
                              . " <td colspan=\"4\" align=\"center\">No Data</td>\n"
                              . " </tr>\n";

        $respone .= "    </tbody>\n"
                          . " </table>";
        
        php_header::text_html_utf8();
        echo $respone;
        
    }
?>
