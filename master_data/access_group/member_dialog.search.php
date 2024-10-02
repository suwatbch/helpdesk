<?php
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/model/access_group.class.php";
    
    global $criteria, $db;

    $criteria = array(
        "employee_code" => $_REQUEST["employee_code"]
        , "first_name" => $_REQUEST["first_name"]
        , "last_name" => $_REQUEST["last_name"]
        , "access_group_id" => $_REQUEST["access_group_id"]
    );
    
    $ag = new access_group($db);
    $arr_member = $ag->searchMember($criteria);

    if (count($arr_member) > 0){
        $respone = " <table id=\"example\" width=\"590px\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\" class=\"data-table\" style=\"margin-left: 5px;\">\n"
                         . "    <tbody>\n";
        foreach ($arr_member as $member){
            $respone .= "       <tr value=\"{$member["user_id"]}\">\n"
                              . "          <td width=\"15px\" align=\"center\"><input type=\"checkbox\" name=\"chk[]\" style=\"border: 0px;\" value=\"{$member["user_id"]}\"/></td>\n"
                              . "          <td width=\"80px\" align=\"center\">{$member["employee_code"]}</td>\n"
                              . "          <td width=\"100px\" align=\"left\">{$member["first_name"]}</td>\n"
                              . "          <td width=\"100px\" align=\"left\">{$member["last_name"]}</td>\n"
                              . "          <td width=\"150px\" align=\"left\">{$member["company_name"]}</td>\n"
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