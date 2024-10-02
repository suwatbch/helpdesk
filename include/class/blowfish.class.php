<?php
    include_once "encryption.class.php";

    class blowfish {
        const MODULE_NAME = "blowfish";
        const KEY = "123456";

        public static function encrypt($plaintext){
          $plaintext = "x".trim($plaintext)."x";
          $key = self::KEY;
          $td = mcrypt_module_open(self::MODULE_NAME,'',"cfb",'');
          $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
          mcrypt_generic_init($td, $key, $iv);
          $crypttext = mcrypt_generic($td, $plaintext);
          mcrypt_generic_deinit($td);
          return encryption::encode($iv.$crypttext, $key);
       }

       public static function decrypt($crypttext){
          $key = self::KEY;
          $crypttext = encryption::decode($crypttext, $key);
          $plaintext = "";
          $td = mcrypt_module_open(self::MODULE_NAME,"","cfb",'');
          $ivsize = mcrypt_enc_get_iv_size($td);
          $iv = substr($crypttext, 0, $ivsize);
          $crypttext = substr($crypttext, $ivsize);
          if ($iv){
             mcrypt_generic_init($td, $key, $iv);
             $plaintext = mdecrypt_generic($td, $crypttext);
          }
          return  substr($plaintext, 1, strlen($plaintext) - 2);
       }
    }

?>
