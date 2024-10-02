<?php

    class arrUtil {
        public static function insert(&$array, $insert, $position = -1) {
            $position = ($position == -1) ? (count($array)) : $position ;
            if($position != (count($array))) {
                $ta = $array;
                for($i = $position; $i < (count($array)); $i++) {
                    if(!isset($array[$i])) {
                        die(print_r($array, 1)."\r\nInvalid array: All keys must be numerical and in sequence.");
                    }
                   $tmp[$i+1] = $array[$i];
                   unset($ta[$i]);
                }

                $ta[$position] = $insert;
                $array = $ta + $tmp;
                //print_r($array);
            } else {
                $array[$position] = $insert;
            }

            ksort($array);
            return true;
        }
    }
?>
