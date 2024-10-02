<?php
    include_once "../../include/error_message.php";
    include_once "../../include/class/user_session.class.php";
    include_once "../../include/class/util/strUtil.class.php";
    include_once "../../include/class/util/dateUtil.class.php";
    include_once "../../include/class/db/db.php";
    include_once "../../include/class/model/customer_company.class.php";
    include_once "../../include/handler/action_handler.php";

    function unspecified() {
        global $db, $company;

        $cus_company_id = $_REQUEST["cus_company_id"];

        if (strUtil::isNotEmpty($cus_company_id)){
            $p = new customer_company($db);
            $company = $p->getById($cus_company_id);
        }
    }

    function finalize(){
        global $db;
        $db->close();

    }

    function save(){
        global $db, $company;

		move_uploaded_file($_FILES["fileLogo"]["tmp_name"],"../../images/".$_FILES["fileLogo"]["name"]); // Copy/Upload CSV
		
        # get input
        $company = array(
            "cus_company_id" => $_REQUEST["cus_company_id"]
            , "cus_company_name" => $_REQUEST["cus_company_name"]
			, "cus_company_logo" => $_FILES["fileLogo"]["name"]
            , "status" => $_REQUEST["status"]
            , "created_by" => user_session::get_user_id()
            , "created_date" => date("Y-m-d H:i:s")
            , "modified_by" => user_session::get_user_id()
            , "modified_date" => date("Y-m-d H:i:s")
        );

            # save
            $db->begin_transaction();

            $p = new customer_company($db);

            if (strUtil::isEmpty($company["cus_company_id"])){
                $result = $p->insert($company);
            } else {
                $result = $p->update($company);
            }

            $db->end_transaction($result);

            if ($result){
                $company = $p->getById($company["cus_company_id"]);
                alert_message_simple("Save Completed !! ", "back_master();");
            }
    }

?>
