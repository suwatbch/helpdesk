<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/helpdesk_project.class.php";
    
    global $criteria, $db;

    $criteria = array(
        "code_cus" => $_REQUEST["code_cus"]
        , "first_name" => $_REQUEST["first_name"]
        , "last_name" => $_REQUEST["last_name"]
        , "project_id" => $_REQUEST["project_id"]
		, "cus_comp_id" => $_REQUEST["cus_comp_id"]
    );
	
	//print_r($criteria);
	
    $ag = new helpdesk_project($db);
    $arr_member = $ag->searchMember($criteria);

    if (count($arr_member) > 0){
        $respone = " <table id=\"example\" width=\"590px\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"data-table\" style=\"margin-left: 5px;\">\n"
                         . "    <tbody>\n";
        foreach ($arr_member as $member){
            $respone .= "       <tr value=\"{$member["code_cus"]}\">\n"
                              . "          <td width=\"15px\" align=\"center\"><input type=\"checkbox\" name=\"chk[]\" style=\"border: 0px;\" value=\"{$member["code_cus"]}\"/></td>\n"
                              . "          <td width=\"80px\" align=\"center\">{$member["code_cus"]}</td>\n"
                              . "          <td width=\"100px\" align=\"left\">{$member["firstname_cus"]}</td>\n"
                              . "          <td width=\"100px\" align=\"left\">{$member["lastname_cus"]}</td>\n"
                              . "          <td width=\"150px\" align=\"left\">{$member["cus_company_name"]}</td>\n"
                              . "       </tr>\n";
        }
        
        $respone .= "    </tbody>\n"
                          . " </table>";

        
    }else{
        $respone = "<table id=\"example\" width=\"570px\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"data-table\" style=\"margin-left: 5px;\">\n"
                         . "    <tbody>\n";
       $respone.= " <tr>\n"
                         . "<td colspan=\"4\" align=\"center\" ><b>No Data</b></td>\n";
       $respone .= "    </tbody>\n"
                         . " </table>";
    }
    
    echo $respone;

    $db->close();
?>