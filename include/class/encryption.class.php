<?php
    class encryption {
//     	public static  function fnc_utf8_to_tis620($str){
//	  $res = "";
//	  for ($i = 0; $i < strlen($str); $i++) {
//		if (ord($str[$i]) == 224) {
//		  $unicode = ord($str[$i+2]) & 0x3F;
//		  $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
//		  $unicode |= (ord($str[$i]) & 0x0F) << 12;
//		  $res .= chr($unicode-0x0E00+0xA0);
//		  $i += 2;
//		} else {
//		  $res .= $str[$i];
//		}
//	  }
//	  return $res;
//	}

        public static function encode($string,$key)
        {
            $key = sha1($key);
            $strLen = strlen($string);
            $keyLen = strlen($key);
            for ($i = 0; $i < $strLen; $i++)
            {
                $ordStr = ord(substr($string,$i,1));
                if ($j == $keyLen) { $j = 0; }
                $ordKey = ord(substr($key,$j,1));
                $j++;
                $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
            }
            return $hash;
        }

        public static function decode($string,$key)
        {
            $key = sha1($key);
            $strLen = strlen($string);
            $keyLen = strlen($key);
            for ($i = 0; $i < $strLen; $i+=2)
            {
                $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
                if ($j == $keyLen) { $j = 0; }
                $ordKey = ord(substr($key,$j,1));
                $j++;
                $hash .= chr($ordStr - $ordKey);
            }
            return $hash;
        }

        public static function has_password($user, $password)
        {
            if ($user == "" && $password == "")
            {
                return "";
            }
           
            //return strtoupper(md5("$user@$password"));
            return strtoupper(md5("$password"));
        }
    }
?>
