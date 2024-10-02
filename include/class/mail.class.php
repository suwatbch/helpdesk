<?php
    class mail{
        public static function send($to,$cc,$bcc, $subject, $messsage, $files = null){
            # uniqid session
            $sid = strtoupper(md5(uniqid(time())));

            # mail from
            $from = "HelpdeskSystem@samartcorp.com";

            # header
            $header = "From: $from\r\n";
            if ($cc <> ""){ $header .= "Cc:  $cc\n"; }
            if ($bcc <> ""){ $header .= "Bcc:  $bcc\n"; }
            $header .= "X-Mailer: PHP/" . phpversion()."\n";

            $header .= "MIME-Version: 1.0\n";
            //$header .= "Content-Type: multipart/mixed; boundary=\"$sid\"\n\n";
//
            //$header .= "--$sid\n";
            $header .= "Content-type: text/html; charset=UTF-8\n";
            $header .= "Content-Transfer-Encoding: 7bit\n\n";

//            # attachment files
            if (count($files) > 0){
                $header .= "$messsage\n\n";
                $messsage = "";
                
                for ($i = 0; $i < count($files); $i++){
                    $filename = $files[$i];

                    if (file_exists($filename)){
                        $header .= "--$sid\n";
                        $header .= "Content-Type: application/octet-stream; name=\"".basename($filename)."\"\n";
                        $header .= "Content-Transfer-Encoding: base64\n";
                        $header .= "Content-Disposition: attachment; filename=\"".basename($filename)."\"\n\n";
                        $header .= chunk_split(base64_encode(file_get_contents($filename)))."\n\n";
                    }
                }
            }

            return mail($to, $subject, $messsage, $header, $from);
        }
    }
?>
