<?php
    session_start();
    header("Content-type: text/html; charset=utf-8");
    include_once "../include/class/db/db.php";	
    include_once "../include/class/user_session.class.php"; 
    include_once "../include/class/util/fileUtil.class.php";
    include_once "../include/class/util/urlUtil.class.php";
    function RandomStr($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
	}

    if($_GET["inci"]) 			$inci 			= $_GET["inci"];
    if($_GET["remove_file_cass"]) 	$remove_file 	= $_GET["remove_file_cass"];
    if($_GET["incident_status"])	$incident_status	= $_GET["incident_status"];
    $s_upload = $_GET["s_upload"];
	
    $tempdir 		= dirname(__FILE__)."/temp_inc_cass";
    $tempname 		= $_FILES["uploadfile_cass"]["tmp_name"];
    $s_filename 	= $_FILES["uploadfile_cass"]["name"];
	$s_today		= date("Ymd");
	$s_hours		= date("His");
	$s_random		= RandomStr();
	$string_random	= $s_today.''.$s_hours.''.$s_random;
	$file_ext 		= pathinfo( $s_filename , PATHINFO_EXTENSION ) ;	//ext
	$filenewcon = 	$string_random.".".$file_ext;
	
	$filename 		= $tempdir."/".$string_random.".".$file_ext;
	$filename2 		= iconv("UTF-8","windows-874",$filename);  //แก้ปัญหาไฟล์ให้ชื่อเป็นภาษาไทย

	//$file_basename 	= pathinfo( $filename , PATHINFO_BASENAME ) ; //filename.ext
	
    //$filename = $tempdir."/".strtoupper(fileUtil::rnunid());//.".".fileUtil::file_extension($filename));
    /*
	#Select Count Attach File/ Workinfo----------------------------------------------------

            $field = "w.workinfo_id,workinfo_name,workinfo_summary,workinfo_notes,first_name,last_name,workinfo_date,status_desc";
            $table = " helpdesk_tr_workinfo w"
					. " LEFT JOIN helpdesk_user u ON (w.workinfo_user_id = u.user_id)"
					. " LEFT JOIN helpdesk_work_type wt ON (w.workinfo_type_id = wt.workinfo_id)"
					. " LEFT JOIN helpdesk_status s ON (w.workinfo_status_id = s.status_id)";
            $condition = " incident_id = $incident_id ORDER BY w.workinfo_id Desc ";

            $result = $this->db->select($field, $table, $condition);
	*/
    #Insert Attach File----------------------------------------------------
	//fileUtil::clear_cache($tempdir, 60);
        
	if($s_upload == 1){
        
        ///////กรณีที่มี history working แล้วไม่สามารถเปลี่ยน attach ได้
            $field_work = "incident_id";
            $table_work = " helpdesk_tr_workinfo";
            $condition_work = " incident_id ='{$inci}'";
            $result_work = $db->select($field_work, $table_work, $condition_work);
            $rows_work = $db->num_rows($result_work);
            
            if($rows_work < 1){

            $user_id 		= user_session::get_user_id();
            $field = "attach_name";
            $table = "helpdesk_tr_attachment";
            $condition = "attach_name = '$s_filename' AND attach_user_id ='$user_id' AND incident_id = '$inci' AND type_attachment = 1 AND workinfo_id = 0";
            $s_result = $db->select($field, $table, $condition);
            $rows = $db->num_rows($s_result);
            if($rows < 1){
		if (move_uploaded_file($tempname, $filename2)) {
			echo urlUtil::getWebDir($filename);
			date_default_timezone_set('Asia/Bangkok');
			$today 			= date("Y-m-d H:i:s");
                        $table 			= "helpdesk_tr_attachment";
			$field 			= "incident_id,attach_name,attach_ext,attach_date,attach_user_id,type_attachment,location_name";
			$data 			= "'{$inci}','{$s_filename}','{$file_ext}','{$today}','{$user_id}','1','{$filenewcon}'";
			$result 		= $db->insert($table, $field, $data);
			if(!$result) return false;
			#-------
		} else {	echo "error insert attach file"; 	}
           }
	}
        }
	#Remove Attach File----------------------------------------------------
       if($s_upload == ""){
	///////กรณีที่มี history working แล้วไม่สามารถเปลี่ยน attach ได้
            $field_work = "incident_id";
            $table_work = " helpdesk_tr_workinfo";
            $condition_work = " incident_id ='{$inci}'";
            $result_work = $db->select($field_work, $table_work, $condition_work);
            $rows_work = $db->num_rows($result_work);
            
            if($rows_work < 1){
		$user_id 		= user_session::get_user_id();
		$remove_file_del 	= $remove_file;
		
		$field = "location_name";
		$table = "helpdesk_tr_attachment";
		$condition = "attach_name = '$remove_file_del' AND attach_user_id ='$user_id' AND incident_id = '$inci' AND type_attachment = 1 AND workinfo_id = 0";
		$s_result = $db->select($field, $table, $condition);
                $rows = $db->num_rows($s_result);
                $f_file = $db->fetch_array($s_result);
		$s_file_remove = $f_file["location_name"];
		
		$remove_file_unlink = $tempdir."/".$s_file_remove;
		$remove_file_unlink = iconv("UTF-8","windows-874",$remove_file_unlink);  //แ้ก้ปัญหาไฟล์ให้ชื่อเป็นภาษาไทย
		
		if(unlink($remove_file_unlink)){
			#-----Delete Attach File
			$user_id 		= user_session::get_user_id();
			date_default_timezone_set('Asia/Bangkok');
			$today 			= date("Y-m-d H:i:s");
			$table 			= "helpdesk_tr_attachment";
			$condition 		= " attach_name = '$remove_file_del' AND incident_id = '$inci' AND type_attachment = 1 AND workinfo_id = 0 AND attach_user_id = '$user_id' ";
			$result 		= $db->delete($table, $condition);
			if(!$result) return false;
			#-------
		}else{	echo "error remove attach file";	}
	}
       }
?>
