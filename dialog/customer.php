<?php
    session_start();
    include_once "../include/class/user_session.class.php";
    include_once "../include/class/db/db.php";
    include_once "../include/class/model/helpdesk_area.class.php";
    include_once "../include/class/dropdown.class.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Customer</title>
        <base target="_self"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link type="text/css" rel="stylesheet" href="../include/css/cctstyles.css"/>
        <link type="text/css" rel="stylesheet" href="../include/css/dialog.css"/>
        <link type="text/css" rel="stylesheet" href="../include/css/alert.css"/>
        <script type="text/javascript" src="../include/config.js.php"></script>
        <script type="text/javascript" src="../include/js/function.js"></script>
        <script type="text/javascript" src="../include/js/jquery/jquery-1.5.1.js"></script>
        <script type="text/javascript" src="../include/js/srs/common.js"></script>
        <script type="text/javascript" src="../include/js/srs/form.js"></script>
        <script type="text/javascript" src="../include/js/alert/alert.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#search").click(function(){
                  
                    if($("#code_cus").val()== "" && $("#first_name").val()== "" && $("#last_name").val()== "" && $("#area_cus").val()=="" ){
                          jAlert('error', 'Please Input data', 'Helpdesk System : Messages');
                           return false;
                    }else{
                    $.get("./customer.search.php", $("form").serialize(),  function(respone){
                        $("#divdata").html(respone);
                        init_datatable();

                        $("#divdata .data-table").find("tr").click(function(){
                            var obj = new Object();
                            obj.code_cus = decodeXml($(this).find("td").eq(0).html());
                            obj.cus_firstname = decodeXml($(this).find("td").eq(1).html());
                            obj.cus_lastname = decodeXml($(this).find("td").eq(2).html());
                            obj.cus_company = decodeXml($(this).find("td").eq(3).html());
                            obj.cus_phone = decodeXml($(this).find("td").eq(4).html());
                            obj.cus_ipaddress = decodeXml($(this).find("td").eq(5).html());
                            obj.cus_email = decodeXml($(this).find("td").eq(6).html());
                            obj.cus_company_id = decodeXml($(this).find("td").eq(7).html());
                            obj.cus_org_name = decodeXml($(this).find("td").eq(8).html());
                            obj.cus_area = decodeXml($(this).find("td").eq(9).html());
                            obj.cus_office = decodeXml($(this).find("td").eq(10).html());
                            obj.cus_department = decodeXml($(this).find("td").eq(11).html());
                            obj.cus_site = decodeXml($(this).find("td").eq(12).html());
							obj.cus_id = decodeXml($(this).find("td").eq(15).html());
                            obj.cus_area_name = decodeXml($(this).find("td").eq(14).html());
                            window.parent.dialog_onSelected_cus("cus_id", obj);
                        });
                    });
                    }
                });

                $("#reset").click(function(){
                    $("#divdata").html("");
                    $("#code_cus, #first_name, #last_name").val("");
                });
          
            });
        </script>
    </head>
    <body>
        <? 
        global $db; $dd_area_cus;
	
	/*MOD 19/07/2022 */
	if($_SESSION["_USER_COMPANY_ID"]=='2')
        {
        	$dd_area_cus = dropdown::loadCusArea($db,"area_cus", "required=\"true\" name=\"area_cus\" style=\"width: 100%;\"","","");
        }else{
	        $dd_area_cus = dropdown::loadCusArea($db,"area_cus", "required=\"true\" name=\"area_cus\" style=\"width: 100%;\"","",$_SESSION["_USER_COMPANY_ID"]);
        }

        ?>
        <form name="frmMain" method="post" action="">
            <table width="100%" border="0" cellpadding="0" cellspacing="3" align="center">
                <tr>
                    <td><b>Customer Code : <b></td>
                    <td><input type="text" id="code_cus" name="code_cus" style="width: 150px" value="<?=$_REQUEST["code_cus"]?>"/>
                    </td>
                    <td><b>Area :</b></td>
                    <td><?=$dd_area_cus;?></td>
                </tr>
                <tr>
                    <td><b>First Name :<b></td>
                    <td>
                        <input type="text" id="first_name" name="first_name" style="width: 150px" value="<?=$_REQUEST["first_name"]?>"/>
                    </td><td>
                        <b>Last Name :</b></td>
                        <td><input type="text" id="last_name" name="last_name" style="width: 150px" value="<?=$_REQUEST["last_name"]?>"/>
                        <input type="button" id="search" value="Search" class="input-button"/>
                        <input type="button" id="reset" value="Reset" class="input-button"/>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="1" class="data-table">
                <thead>
                    <tr style="text-align: center">
                        <td width="85px">Customer Code</td>
                        <td width="120px">First Name</td>
                        <td width="120px">Last Name</td>
                        <td width="150px">Company</td>
                        <td width="150px">Area</td>
                    </tr>
                </thead>
            </table>
            <div id="divdata" style="height: 255px; overflow: auto;"></div>
<!--            <div id="divbutton"><input type="button" id="close" value="Close" class="input-button"/></div>-->
        </form>
    </body>
</html>