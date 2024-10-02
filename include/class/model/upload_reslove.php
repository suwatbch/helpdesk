<?php

    function RandomStr_reslove($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }   
    if($chang_upload_file == 'change_log'){
      $counst_reslove = count($incident["uploadfile_reslove"]["name"])+1;  
    }else{
       $counst_reslove = count($incident["uploadfile_reslove"]["name"])-1;
    }
        if($counst_reslove > 0){
            $s_inc_file = $incident["id"];
            for($i=0;$i<=$counst_reslove-1;$i++){
        
        $tempdir 		= dirname(dirname(dirname(dirname(__FILE__))))."/upload/temp_inc_reslove";
        $tempname               = $arr_file = $incident["uploadfile_reslove"]["tmp_name"][$i];
        $s_filename             = $arr_file = $incident["uploadfile_reslove"]["name"][$i];
	$s_today		= date("Ymd");
	$s_hours		= date("His");
	$s_random		= RandomStr_reslove();
	$string_random	= $s_today.''.$s_hours.''.$s_random;
	$file_ext 		= pathinfo( $s_filename , PATHINFO_EXTENSION ) ;	//ext
	$filenewcon = 	$string_random.".".$file_ext;
	$filename 		= $tempdir."/".$string_random.".".$file_ext;
	$filename2 		= iconv("UTF-8","windows-874",$filename);  //แก้ปัญหาไฟล์ให้ชื่อเป็นภาษาไทย
            if($chang_upload_file == 'change_log'){
                $user_id_file = $_REQUEST["modified_change_log"];
            }else{
                $user_id_file = user_session::get_user_id();
            }
		if (move_uploaded_file($tempname, $filename2)) {
			date_default_timezone_set('Asia/Bangkok');
			$today 			= date("Y-m-d H:i:s");
                        $table 			= "helpdesk_tr_attachment";
			$field 			= "incident_id,attach_name,attach_ext,attach_date,attach_user_id,type_attachment,location_name";
			$data 			= "'{$s_inc_file}','{$s_filename}','{$file_ext}','{$today}','{$user_id_file}','3','{$filenewcon}'";
                        if($chang_upload_file == 'change_log'){
                            $result 		= $db->insert($table, $field, $data); 
                        }else{
                            $result 		= $this->db->insert($table, $field, $data);
                        }
			if(!$result) return false;
			#-------
		} else {	//echo "1"; 	
                    
                }
           }
        } //end if
?>

