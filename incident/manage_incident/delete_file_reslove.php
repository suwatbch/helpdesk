<?php
    session_start();
    header("Content-type: text/html; charset=utf-8");
    include_once "../../include/class/db/db.php";	
    include_once "../../include/class/user_session.class.php"; 
    include_once "../../include/class/util/fileUtil.class.php";
    include_once "../../include/class/util/urlUtil.class.php";
    $tempdir 		= dirname(__FILE__)."/temp_inc_reslove";
    $id = $_POST['id'];

if($id!=""){
                $field = "location_name";
		$table = "helpdesk_tr_attachment";
		$condition = " attach_id = '{$id}'";
		$s_result = $db->select($field, $table, $condition);
                $f_file = $db->fetch_array($s_result);
		$s_file_remove = $f_file["location_name"];
		
		$remove_file_unlink = "../../upload/temp_inc_reslove/".$s_file_remove;
		$remove_file_unlink = iconv("UTF-8","windows-874",$remove_file_unlink);  //แ้ก้ปัญหาไฟล์ให้ชื่อเป็นภาษาไทย
		//unlink($remove_file_unlink);
	if(unlink($remove_file_unlink)){
                 $user_id = user_session::get_user_id();
                 $table                 = "helpdesk_tr_attachment";
                 $condition 		= " attach_id = '{$id}'";
                 $result 		= $db->delete($table, $condition);
                    if(!$result) return false;
                    else{	echo "no remove file";	}
             }
    
}

			

?>
