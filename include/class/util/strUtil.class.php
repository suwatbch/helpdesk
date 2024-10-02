<?php
    class strUtil {
        public static function nvl($str, $def = ""){
            return (self::isEmpty($str) ? $def : $str);
        }

        public static function isEmpty($str){
            if ($str == null || $str == "") return true;
            if (strlen($str) == 0) return true;
            return false;
			
        }

        public static function isNotEmpty($str){
           return !self::isEmpty($str);
        }
        
        public static function sum_sla($sla){
        
        $sla_hh =  substr($sla,0,4);
        $sla_mm =  substr($sla,5,2);
        $sla_ss =  substr($sla,8,2);
        
        $s_hh = (int)$sla_hh * 3600;
        $s_mm = (int)$sla_mm * 60;
        $s_ss = (int)$sla_ss;

        $sum_respond_sla = (int)$s_hh + (int)$s_mm + (int)$s_ss;
        return $sum_respond_sla;
        }
    }
?>