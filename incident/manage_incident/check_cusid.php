<?php
    include_once "../../include/class/php_header.class.php";
    include_once "../../include/class/db/db.php";

    php_header::text_html_utf8();
    global $db;
    $cus_id = $_REQUEST["cus_id"];
    $sql = " select c.code_cus,c.firstname_cus,c.lastname_cus,c.phone_cus,c.ipaddress_cus,
                c.email_cus,c.cus_company_id,com.cus_company_name,org.cus_org_name,c.area_cus,c.office_cus,c.dep_cus,
		c.site_cus,CONCAT(c2.firstname_cus,' ',c2.lastname_cus) as keyuser";
    $sql .= " from helpdesk_customer c"
                . " LEFT JOIN helpdesk_cus_company com ON (c.cus_company_id = com.cus_company_id)"
		. " LEFT JOIN helpdesk_cus_org org ON (c.org_cus = org.cus_org_id)"
                . " LEFT JOIN helpdesk_customer c2 ON (c.keyuser_id_cus = c2.cus_id)";
    $sql .= " where c.code_cus = '{$cus_id}' ";
    
            
    $result = $db->query($sql);
    $rows = $db->num_rows($result);
    $f_row = $db->fetch_array($result);
    if($rows > 0)
	{
		echo $f_row["code_cus"]."|".$f_row["firstname_cus"]."|".$f_row["lastname_cus"]."|".
                    $f_row["phone_cus"]."|".$f_row["ipaddress_cus"]."|".$f_row["email_cus"]."|".$f_row["cus_company_name"]."|".$f_row["cus_org_name"]."|".
                    $f_row["area_cus"]."|".$f_row["office_cus"]."|".$f_row["dep_cus"]."|".$f_row["site_cus"]."|".$f_row["cus_company_id"];
	}else{
            echo "";
        }

   $db->close();
?>
