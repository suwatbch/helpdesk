<?php
    class php_header{
        public static function redirect($url) {
            //header("Location: $url");
            header("Location: $url");
        }

        public static function text_html_utf8(){
            //header("Content-type: text/html; charset=utf-8");
            //header("Content-type: text/html; charset=utf-8");
        }

        public static function application_json(){
            header('Content-Type: application/json');
        }

        public static function text_plain(){
            header("Content-type: text/plain");
        }

        public static function image_jpeg(){
            header("Content-Type: image/jpeg");
        }

        public static function image_gif(){
            header("Content-Type: image/gif");
        }

        public static function image_png(){
            header("Content-Type: image/png");
        }
    }
?>