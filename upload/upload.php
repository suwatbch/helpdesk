<?php
    include_once "../include/config.inc.php";
    include_once "../include/class/util/fileUtil.class.php";
    include_once "../include/class/util/urlUtil.class.php";
  
    $tempdir = dirname(__FILE__)."/temp";
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $filename = $_FILES["uploadfile"]["name"];
    //$filename = $tempdir."/".strtoupper(fileUtil::rnunid());//.".".fileUtil::file_extension($filename));
    $filename = $tempdir."/".$inci.$filename;

    fileUtil::clear_cache($tempdir, 60);
    if (move_uploaded_file($tempname, $filename)) {
        echo urlUtil::getWebDir($filename);
    } else {
	echo "error";
    }
?>