<?php

    function RandomStr_identify($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }   
       $counst_reslove = count($identify["uploadfile_identify"]["name"])-1;

        if($counst_reslove > 0){
            for($i=0;$i<=$counst_reslove-1;$i++){
        
        $tempdir 		= dirname(dirname(dirname(dirname(__FILE__))))."/incident_km/temp_identify";
        $tempname               = $arr_file = $identify["uploadfile_identify"]["tmp_name"][$i];
        $s_filename             = $arr_file = $identify["uploadfile_identify"]["name"][$i];
	$s_today		= date("Ymd");
	$s_hours		= date("His");
	$s_random		= RandomStr_identify();
	$string_random	= $s_today.''.$s_hours.''.$s_random;
	$file_ext 		= pathinfo( $s_filename , PATHINFO_EXTENSION ) ;	//ext
	$filenewcon = 	$string_random.".".$file_ext;
	$filename 		= $tempdir."/".$string_random.".".$file_ext;
	$filename2 		= iconv("UTF-8","windows-874",$filename);  //แก้ปัญหาไฟล์ให้ชื่อเป็นภาษาไทย

            $user_id_file = user_session::get_user_id();
		if (move_uploaded_file($tempname, $filename2)) {
			date_default_timezone_set('Asia/Bangkok');
			$today 			= date("Y-m-d H:i:s");
                        $table 			= "helpdesk_tr_attachment";
			$field 			= "attach_name,attach_ext,attach_date,attach_user_id,type_attachment,location_name,km_id";
			$data 			= "'{$s_filename}','{$file_ext}','{$today}','{$user_id_file}','4','{$filenewcon}','{$km_id}'";
			$result 		= $this->db->insert($table, $field, $data);
			if(!$result) return false;
			#-------
		} else {	echo "error insert attach file"; 	}
           }
        } //end if
?>

