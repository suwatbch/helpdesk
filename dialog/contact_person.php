<?php
    include_once "../include/class/db/db.php";
    include_once "../include/class/util/strUtil.class.php";

    $contact_person = array();
    $customer_id = $_REQUEST["customer_id"];
    
    if (strUtil::isNotEmpty($customer_id)){
        $sql = " SELECT contact_person_name, email, telephone, mobile"
                . " FROM tb_customer_contact_person"
                . " WHERE customer_id = $customer_id"
                . " ORDER BY contact_person_name";

        $result = $db->query($sql);
        $rows = $db->num_rows($result);
        if ($rows != 0){
            while($row = $db->fetch_array($result)){
                $contact_person[] = $row;
            }
        }
    }

    $db->close();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Customer</title>
        <base target="_self"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link type="text/css" rel="stylesheet" href="../include/css/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="../include/css/dialog.css"/>
        <script type="text/javascript" src="../include/config.js.php"></script>
        <script type="text/javascript" src="../include/js/function.js"></script>
        <script type="text/javascript" src="../include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="../include/js/srs/common.js"></script>
        <script type="text/javascript" src="../include/js/srs/form.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#close").click(function(){
                    window.parent.dialog_onSelected("contact_person", null);
                });

                $(".data-table").last().find("tr").click(function(){
                    var obj = new Object();
                    obj.contact_person_name = decodeXml($(this).find("td").eq(1).html());

                    window.parent.dialog_onSelected("contact_person", obj);
                });
            });
        </script>
    </head>
    <body>
        <form name="frmMain" method="post" action="">
            <table width="650px" border="0" cellpadding="0" cellspacing="1" class="data-table" style="margin: 10px 0px 0px 5px;">
                   <thead>
                        <tr>
                            <td width="5%" align="center">No.</td>
                            <td width="35%" align="center">Contact Person</td>
                            <td width="30%" align="center">Email Address</td>
                            <td width="30%" align="center">Telephone / Mobile</td>
                        </tr>
                    </thead>
            </table>
            <div style="height: 300px; overflow: auto;">
                <table width="650px" border="0" cellpadding="0" cellspacing="1" class="data-table" style="margin-left: 5px;">
                    <tbody>
                        <?php
                            if (count($contact_person) > 0){
                                $index = 1;
                                foreach ($contact_person as $cp) {
                        ?>
                        <tr style="cursor: hand;">
                            <td width="5%" align="center"><?=$index++?></td>
                            <td width="35%" align="left"><?=htmlspecialchars($cp["contact_person_name"])?></td>
                            <td width="30%" align="left"><?=htmlspecialchars($cp["email"])?></td>
                            <td width="30%" align="left"><span><?=htmlspecialchars($cp["telephone"])?></span> <?=(strUtil::isNotEmpty($cp["telephone"]) && strUtil::isNotEmpty($cp["mobile"]) ? "/" : "")?> <span><?=htmlspecialchars($cp["mobile"])?></span></td>
                        </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="divbutton"><input type="button" id="close" value="Close" class="input-button"/></div>
        </form>
    </body>
</html>