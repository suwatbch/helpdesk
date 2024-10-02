<?php
    ini_set('max_execution_time', 0);
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/helpdesk_company.class.php";
    include_once "../../include/class/model/helpdesk_org.class.php";
    include_once "../../include/class/dropdown.class.php";
    include_once "../../include/handler/action_handler.php";

    function finalize(){
        global $db ,$dd_company_cus ,$dd_org_cus, $action_master;
        $action_master = 2;
        $dd_company_cus = dropdown::loadCusCompany($db, "cus_company_id","required=\"true\" name=\"cus_company_id\" style=\"width: 100%;\"", "");
        $dd_org_cus = dropdown::loadCusOrg($db,"cus_org_id", "required=\"true\" name=\"cus_org_id\" style=\"width: 100%;\"", "");
        $db->close();

    }

    function save(){
        global $db, $objective;
        $created_by = user_session::get_user_id();
        $created_date = date("Y-m-d H:i:s");
        $modified_by = user_session::get_user_id();
        $modified_date =  date("Y-m-d H:i:s");
        $cus_company_id = $_REQUEST["cus_company_id"];
        $org_cus = $_REQUEST["cus_org_id"];
        $i = 1;

        move_uploaded_file($_FILES["fileCSV"]["tmp_name"],$_FILES["fileCSV"]["name"]); // Copy/Upload CSV

        $objCSV = fopen($_FILES["fileCSV"]["name"], "r");
     while (($objArr = fgetcsv($objCSV, 1000, ";")) !== FALSE) {
         if($i > 1){
         if(strUtil::isNotEmpty($objArr[0]) || strUtil::isNotEmpty($objArr[1]) || isNotEmpty::isEmpty($objArr[2]) || strUtil::isNotEmpty($objArr[3]) || strUtil::isNotEmpty($objArr[4]) || strUtil::isNotEmpty($objArr[5])){
         $s_sql = "select code_cus from helpdesk_customer where code_cus= '$objArr[0]' ";
         $s_result = $db->query($s_sql);
         $s_num_rows = $db->num_rows($s_result);
         if($s_num_rows > 0){
             $strSQL = "update helpdesk_customer set code_cus='".$objArr[0]."',firstname_cus='".$objArr[1]."',lastname_cus='".$objArr[2]."'";
             $strSQL .= ", area_cus='".$objArr[3]."',office_cus='".$objArr[4]."',dep_cus='".$objArr[5]."',cus_company_id='{$cus_company_id}'";
             $strSQL .= ", org_cus='{$org_cus}',status_customer='A'";
             $strSQL .= ", modified_by='{$modified_by}',modified_date='{$modified_date}'";
             $strSQL .= " where code_cus = '$objArr[0]'";
             $result = $db->query($strSQL);
         }else{
	$strSQL = "INSERT INTO helpdesk_customer ";
	$strSQL .="(code_cus,firstname_cus,lastname_cus,area_cus,office_cus,dep_cus,cus_company_id,org_cus,status_customer,created_by,created_date,modified_by,modified_date) ";
	$strSQL .="VALUES ";
	$strSQL .="('".$objArr[0]."','".$objArr[1]."','".$objArr[2]."' ";
	$strSQL .=",'".$objArr[3]."','".$objArr[4]."','".$objArr[5]."' ";
        $strSQL .=",'{$cus_company_id}','{$org_cus}','A','{$created_by}','{$created_date}','{$modified_by}','{$modified_date}') ";
	$result = $db->query($strSQL);
         }//end else
         }//end if
         }//end if
         $i++;
}//end while

fclose($objCSV);

alert_message_simple("Upload & Import Done. !! ", "back_master();");

//echo "Upload & Import Done.";
//exit();

//            $db->end_transaction($result);
//
//            if ($result){
//                $objective = $p->getById($objective["priority_id"]);
//                alert_message_simple("Save Completed !! ", "back_master();");
//            }
    }
?>
