<?php
    class fp_exception
    {
        public static function display($message, $title = "")
        {
?>
<!doctype html public "-//w3c//dtd html 4.01 transitional//en" "http://www.w3c.org/tr/1999/rec-html401-19991224/loose.dtd">
<!-- saved from url=(0076)http://www.ecrion.com/products/xfrenderingserver/xslfosamples/www.ecrion.com -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Exeption</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta content="mshtml 6.00.6000.17093" name="generator"/>
        <style type="text/css">
            body
            {
                font-size: 0.7em;
                background: #eeeeee;
                margin: 0px;
                font-family: verdana, arial, helvetica, sans-serif;
            }

            fieldset
            {
                padding-right: 15px;
                padding-left: 15px;
                padding-bottom: 10px;
                padding-top: 0px
            }

            h1
            {
                font-size: 2.4em;
                margin: 0px;
                color: #fff
            }

            h2
            {
                font-size: 1.7em;
                margin: 0px;
                color: #cc0000
            }

            h3
            {
                font-size: 1.2em;
                margin: 10px 0px 0px;
                color: #000000
            }

            #header
            {
                padding-right: 2%;
                padding-left: 2%;
                padding-bottom: 6px;
                margin: 0px;
                width: 96%;
                color: #fff;
                padding-top: 6px;
                font-family: "trebuchet ms", verdana, sans-serif;
                background-color: #555555
            }

            #content
            {
                margin: 0px 0px 0px 2%;
                position: relative
            }

            .content-container
            {
                padding-right: 10px;
                margin-top: 8px;
                padding-left: 10px;
                background: #fff;
                padding-bottom: 10px;
                width: 96%;
                padding-top: 10px;
                position: relative
            }
        </style>
    </head>
    <body>
        <div id="header">
            <h1>Server Error</h1>
        </div>
        <div id="content">
            <?php if ($title || $message) {?>
            <div class="content-container">
                <fieldset>
                    <?php if ($title) {?>
                    <h2><?=$title?></h2>
                    <?php }?>
                    <?php if ($message) {?>
                    <h3><?=$message?></h3>
                    <?php }?>
                </fieldset>
            </div>
            <?php }?>
        </div>
    </body>
</html>
<?php
            die();
        }
    }
?>

