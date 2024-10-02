<?php
    include_once "include/class/php_header.class.php";
    include_once "include/class/db/db.php";
    include_once "include/class/util/strUtil.class.php";

    php_header::text_html_utf8();
    global $db;
    
    if(strUtil::isNotEmpty($_REQUEST["username"]) && strUtil::isNotEmpty($_REQUEST["password"])){
            $username = strtolower($_REQUEST["username"]);
            $password = strtoupper(md5($_REQUEST["password"]));
            $s_today = date("Y-m-d");
            $s_new_password = strtoupper(md5($_REQUEST["new_password"]));
            $pass_expire = $_REQUEST["pass_expire"];
            $field = "pass_expire,pass_count,user_status,pass";
            $table = "helpdesk_user";
            //Comment By Seksan 20/06/2559
			//$condition = "user_status = 1 AND lower(user_login)= '{$username}' AND company_id = '{$_REQUEST["comcode"]}'";
			$condition = "user_status = 1 AND lower(user_login)= '{$username}'";
            $result= $db->select($field,$table, $condition);
            $f_rows = $db->fetch_array($result);
            $rows = $db->num_rows($result);
            $s_date_expire = $f_rows["pass_expire"];
            $s_pass_count = $f_rows["pass_count"];
            $s_user_status = $f_rows["user_status"];
            $s_password = $f_rows["pass"];
            
//            if($rows < 1){
//                echo "1";
//                exit();
//            }else if(($s_user_status == '0') && ($s_password == $password)){
//                echo "2";
//                exit();
//            }else if(($s_password != $password) && ($s_pass_count < 3) && $s_pass_count != 'N'){
//                $sql = "update helpdesk_user set pass_count=pass_count+1 where user_login= '{$username}'";
//                $result = $db->query($sql);
//                echo "3";
//                exit();                
//            }else if (($s_today == $s_date_expire) && $pass_expire == ""){
//                echo "4";
//                exit();
//            }else if(($s_pass_count == 'N') && $pass_expire == ""){
//                echo "6";
//                exit();
//            }else if(($s_pass_count >= 3) && ($s_password == $password) && $pass_expire == ""){
//                echo "5";
//                exit();
//            }else if(($s_password != $password) && $s_pass_count == 'N'){
//                echo "8";
//                exit();
//            }else if(($s_password == $s_new_password) && $pass_expire == 1){
//                echo "9";
//                exit();
//            }else if($rows > 0){
//                echo "7";
//                exit();
//            }
            
             if($rows < 1){
                echo "1";
                exit();
             }else if($s_password == $password){
                if($pass_expire == ""){
                    if(($s_user_status == '0')){
                        echo "2";
                        exit();
                    }else if (($s_today == $s_date_expire)){
                        echo "4";
                        exit();
                    }else if($s_pass_count == 'N'){
                        echo "6";
                        exit();
                    }else if($s_pass_count >= 3){
                        echo "99";
                        exit();
                    }
                }else if($pass_expire == 1){
                    if($s_password == $s_new_password){
                        echo "9";
                        exit();
                    }
                }
            }else if($s_password != $password){
                if($s_pass_count >= 3 && $s_pass_count != 'N'){
                        echo "5";
                        exit();
                    }
                else if($s_pass_count < 3 && $s_pass_count != 'N'){
                    $sql = "update helpdesk_user set pass_count=pass_count+1 where user_login= '{$username}'";
                    $result = $db->query($sql);
                    echo "3";
                    exit();                
                }else if($s_pass_count == 'N'){
                    echo "8";
                    exit();
                }
            }else if($rows > 0){
                echo "7";
                exit();
            }
    }


   $db->close();
?>
