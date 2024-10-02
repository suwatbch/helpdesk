
<!-- Start AJAX Create Incident:Tab Customer-->
<script language="JavaScript">
    function showCostomer(e, cusid) {

        //alert('ss');
        var code = (e.keyCode ? e.keyCode : e.which);
        var cus_id = $("#cus_id").val();
        if (code == 13) { //Enter keycode
            ///////////km_ref/////////
            if ($("#s_km_id").val() != "") {
                page_submit("index.php?action=incident.php&cusid=" + cus_id + "&cus_company_id=" + $("#cus_company_id").val(), "get_new_incident");
            } else {

                if (cus_id != $("#s_t_code_cus").val()) {



                    var cusid = document.getElementById('cus_id').value;

                    if (cusid != "") {
                        //alert(cusid);
                        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                            xmlhttp = new XMLHttpRequest();
                        } else { // code for IE6, IE5
                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        xmlhttp.onreadystatechange = function() {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                document.getElementById("CusTab_Span").innerHTML = xmlhttp.responseText;
                                //เรียกฟังก์ชันดีงข้อมูลไปโชว์ทีี่่ dropdown list ที่เท็บ cassification
                                get_dropdown_ident_type();
                                get_dropdown_project();

                                get_dropdown_opr_tier1();
                                get_dropdown_prd_tier1();

                                get_dropdown_opr_tier1_resol();
                                get_dropdown_prd_tier1_resol();

                                show_alert_cus_id();
                            }
                        }
                        xmlhttp.open("GET", "incident.tab.customer.php?cusid=" + cusid, true);
                        xmlhttp.send();
                    }
                }
            }
        }
    }

    function get_dropdown_ident_type() {
        var cus_company_id = $("#cus_company_id").val();
        //data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
        $.ajax({
            type: "GET",
            url: "dropdown.incident_type.php",
            data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
            success: function(response) {
                $("#ident_type_id").replaceWith(response);
                //document.getElementById("ident_type_id").innerHTML =respone;
            }
        });
    }

    /*
    function get_dropdown_project(){
    	
            var cus_company_id = $("#cus_company_id").val();
    		$.ajax({
                    type: "GET",
                    url: "dropdown.project.php",
                    data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
                    success: function(response){
                        $("#project_id").replaceWith(response);    
                    }
                });
    }
    */

    function get_dropdown_project() {
        var customer_id = $("#customer_id").val();
        //data: "customer_id=" + customer_id +"&attr=style=\"width: 100%;\" required=\"true\"",
        $.ajax({
            type: "GET",
            url: "dropdown.project.php",
            data: "customer_id=" + customer_id +"&attr=style=\"width: 100%;\" required=\"true\"",
            success: function(response) {
                //console.log(response);
                //alert(response);
                $("#project_id").replaceWith(response);
            },
            //error: function(xhr, status, error) {
            //console.error("AJAX Error: " + status + " - " + error);
            //}
        });
    }

    function get_dropdown_opr_tier1() {
        var cus_company_id = $("#cus_company_id").val();
        //data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
        $.ajax({
            type: "GET",
            url: "dropdown.opr_tier1.php",
            data: "cus_company_id=" + cus_company_id,
            success: function(response) {
                //alert(response);
                //$("#cas_opr_tier_id1").replaceWith(response);  
                document.getElementById("cas_opr_tier_id1").innerHTML = response;
                //document.getElementById("show_cass").innerHTML =response;
                //$("#cas_opr_tier_id1").replaceWith('<select id="cas_opr_tier_id1" name="cas_opr_tier_id1"'); 


                var newdiv = document.createElement("div");
                newdiv.innerHTML = response;
                var container = document.getElementById("cas_opr_tier_id1");
                container.appendChild(newdiv);
            }
        });

        //Chagng Dropdown cas_opr_tier_id2  
        var cas_opr_tier_id1 = "";
        var cus_company_id = "";
        // data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cus_company_id=" + cus_company_id + "&attr=",
        $.ajax({
            type: "GET",
            url: "dropdown.opr_tier2.php",
            data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#cas_opr_tier_id2").replaceWith(respone);
                document.getElementById("cas_opr_tier_id2").innerHTML = respone;
            }
        });

        //Chagng Dropdown cas_opr_tier_id3  
        var cas_opr_tier_id1 = "";
        var cas_opr_tier_id2 = "";
        var cus_company_id = "";
        // data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2 + "&attr=style=\"width: 100%;\"",
        $.ajax({
            type: "GET",
            url: "dropdown.opr_tier3.php",
            data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2,
            success: function(respone) {
                //alert(respone);
                //$("#cas_opr_tier_id3").replaceWith(respone);
                document.getElementById("cas_opr_tier_id3").innerHTML = respone;
            }
        });

    }

    function get_dropdown_prd_tier1() {
        var cus_company_id = $("#cus_company_id").val();
        //data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
        $.ajax({
            type: "GET",
            url: "dropdown.prd_tier1.php",
            data: "cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#cas_prd_tier_id1").replaceWith(respone); 
                document.getElementById("cas_prd_tier_id1").innerHTML = respone;
            }
        });

        //Chagng Dropdown cas_prd_tier_id2  
        var cas_prd_tier_id1 = "";
        var cus_company_id = "";
        //data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
        $.ajax({
            type: "GET",
            url: "dropdown.prd_tier2.php",
            data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#cas_prd_tier_id2").replaceWith(respone);
                document.getElementById("cas_prd_tier_id2").innerHTML = respone;
            }
        });
        //Chagng Dropdown cas_prd_tier_id3  
        var cas_prd_tier_id1 = "";
        var cas_prd_tier_id2 = "";
        var cus_company_id = "";
        //data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "$cas_prd_tier_id2=" + cas_prd_tier_id2 + "&cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\"",
        $.ajax({
            type: "GET",
            url: "dropdown.prd_tier3.php",
            data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "$cas_prd_tier_id2=" + cas_prd_tier_id2 + "&cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#cas_prd_tier_id3").replaceWith(respone);
                document.getElementById("cas_prd_tier_id3").innerHTML = respone;
            }
        });

    }


    function get_dropdown_opr_tier1_resol() {
        var cus_company_id = $("#cus_company_id").val();
        //data: "cus_company_id=" + cus_company_id +"&attr=style=\"width: 100%;\" required=\"true\"",
        $.ajax({
            type: "GET",
            url: "dropdown.opr_tier1_resol.php",
            data: "cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#resol_oprtier1").replaceWith(respone);  
                document.getElementById("resol_oprtier1").innerHTML = respone;
            }
        });

        //Chagng Dropdown get_dropdown_opr_tier2_resol 
        var resol_oprtier1 = "";
        var cus_company_id = "";
        // data: "resol_oprtier1=" + resol_oprtier1 + "&cus_company_id=" + cus_company_id + "&attr=style=\"width: 100%;\"",
        $.ajax({
            type: "GET",
            url: "dropdown.opr_tier2_resol.php",
            data: "resol_oprtier1=" + resol_oprtier1 + "&cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#resol_oprtier2").replaceWith(respone);
                document.getElementById("resol_oprtier2").innerHTML = respone;
            }
        });

        //Chagng Dropdown get_dropdown_opr_tier2_resol  
        /*var resol_oprtier2 = $(this).val();
            var resol_oprtier1 = $("#resol_oprtier1").val();
            //alert(cas_opr_tier_id2);
            
			$.ajax({
                type: "GET",
                url: "dropdown.opr_tier3_resol.php",
                data: "resol_oprtier1=" + resol_oprtier1 + "&resol_oprtier2=" + resol_oprtier2 +"&attr=style=\"width: 100%;\"",
                success: function(respone){
                    //$("#resol_oprtier3").replaceWith(respone);
					//alert(respone);
					document.getElementById("resol_oprtier3").innerHTML =respone;
                }
            });*/
    }

    function get_dropdown_prd_tier1_resol() {
        var cus_company_id = $("#cus_company_id").val();
        // data: "cus_company_id=" + cus_company_id + "&attr=style=\"width: 100%;\" required=\"true\"",
        $.ajax({
            type: "GET",
            url: "dropdown.prd_tier1_sesol.php",
            data: "cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#resol_prdtier1").replaceWith(respone);  
                document.getElementById("resol_prdtier1").innerHTML = respone;
            }
        });

        //Chagng Dropdown resol_prdtier2  
        var resol_prdtier1 = "";
        var cus_company_id = "";
        // data: "resol_prdtier1=" + resol_prdtier1 + "&cus_company_id=" + cus_company_id + "&attr=style=\"width: 100%;\"",
        $.ajax({
            type: "GET",
            url: "dropdown.prd_tier2_resol.php",
            data: "resol_prdtier1=" + resol_prdtier1 + "&cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#resol_prdtier2").replaceWith(respone);
                document.getElementById("resol_prdtier2").innerHTML = respone;
            }
        });

        //Chagng Dropdown resol_prdtier3  
        var resol_prdtier1 = "";
        var resol_prdtier2 = "";
        var cus_company_id = "";
        // data: "resol_prdtier1=" + resol_prdtier1 + "$resol_prdtier2=" + resol_prdtier2 + "&cus_company_id=" + cus_company_id + "&attr=style=\"width: 100%;\"",
        $.ajax({
            type: "GET",
            url: "dropdown.prd_tier3_resol.php",
            data: "resol_prdtier1=" + resol_prdtier1 + "$resol_prdtier2=" + resol_prdtier2 + "&cus_company_id=" + cus_company_id,
            success: function(respone) {
                //alert(respone);
                //$("#resol_prdtier3").replaceWith(respone);
                document.getElementById("resol_prdtier3").innerHTML = respone;
            }
        });

    }
</script>
<!-- End AJAX -->
<?php
$cusid = $_GET["cusid"];
include_once "../../include/class/db/db.php";
include_once "../../include/class/util/strUtil.class.php";
include_once "../../include/class/user_session.class.php";
include_once "../../include/class/model/helpdesk_customer.class.php";

if ($cusid) {
    //echo $cusid; 
    if (strUtil::isNotEmpty($cusid)) {
        global $db, $customer;
        $customer = new helpdesk_customer($db);
        $customer = $customer->getByCustomerCode($cusid);
        $t_code_cus = $customer["code_cus"];
        $t_firstname_cus = $customer["firstname_cus"];
        $t_lastname_cus = $customer["lastname_cus"];
        $t_phone_cus = $customer["phone_cus"];
        $t_ipaddress_cus = $customer["ipaddress_cus"];
        $t_email_cus = $customer["email_cus"];
        $t_cus_company_id = $customer["cus_company_id"];
        $t_cus_company_name = $customer["cus_company_name"];
        $t_org_cus = $customer["cus_org_name"];
        $t_area_cus = $customer["area_cus"];
        $t_area_cus_name = $customer["area_cus_name"];
        $t_office_cus = $customer["office_cus"];
        $t_dep_cus     = $customer["dep_cus"];
        $t_site_cus = $customer["site_cus"];
        //$t_keyuser = $customer["keyuser_f"]." ".$customer["keyuser_l"];
        $t_keyuser = $customer["keyuser"];
        $t_customer_id = $customer["code_cus"];
        $incident["cus_id"] = $customer["code_cus"];
    }
}

?>
<div id="CusTab_Span" name="CusTab_Span" style="overflow-y: auto;">
    <table width="98%" border="0" cellpadding="0" cellspacing="1" align="center">
        <tr style="height: 30px">
            <td>
                <span class="styleBlue">CUSTOMER</span><span class="styleGray"> INFORMATION</span>
            </td>
        </tr>
    </table>
    <table width="75%" border="0" cellpadding="0" cellspacing="3" align="center">
        <tr>
            <td class="tr_header" style="width: 40%">Customer ID <span class="required">*</span></td>
            <td>
                <input type="hidden" name="customer_id" id="customer_id" value="<?= $t_customer_id; ?>">
                <input type="text" name="s_cus_id" id="s_cus_id" maxlength="20" required="true" readonly class="disabled" description="Tab Customer:cus code" value="<?= $incident["cus_id"]; ?>" />
            </td>
        </tr>
        <tr>
            <td class="tr_header">First Name <span class="required">*</span></td>
            <td><input type="text" name="cus_firstname" id="cus_firstname" maxlength="50" required="true" readonly class="disabled" description="Tab Customer:cus firstname" value="<?= $t_firstname_cus; ?><?= htmlspecialchars($incident["cus_firstname"]) ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">Last Name <span class="required">*</span></td>
            <td><input type="text" name="cus_lastname" id="cus_lastname" readonly class="disabled" maxlength="50" required="true" description="Tab Customer:cus lastname" value="<?= $t_lastname_cus; ?><?= htmlspecialchars($incident["cus_lastname"]) ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">Phone Number</td>
            <td><input type="text" name="cus_phone" id="cus_phone" readonly class="disabled" value="<?= $t_phone_cus; ?><?= $incident["cus_phone"] ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">IP Address</td>
            <td><input type="text" name="cus_ipaddress" id="cus_ipaddress" readonly class="disabled" value="<?= $t_ipaddress_cus; ?><?= $incident["cus_ipaddress"] ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">E-mail</td>
            <td><input type="text" name="cus_email" id="cus_email" readonly class="disabled" value="<?= $t_email_cus; ?><?= htmlspecialchars($incident["cus_email"]) ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">Company </td>
            <td>
                <input type="hidden" id="cus_company_id" name="cus_company_id" value="<? if ($t_cus_company_id != "") {
                                                                                            echo $t_cus_company_id;
                                                                                        } else {
                                                                                            echo $incident["cus_company_id"];
                                                                                        } ?>" />
                <input type="text" name="cus_company" id="cus_company" readonly class="disabled" maxlength="50" description="Tab Customer:cus company" value="<?= $t_cus_company_name; ?><?= htmlspecialchars($incident["cus_company"]) ?>" />
            </td>
        </tr>
        <tr>
            <td class="tr_header" style="width: 180px">Organization </td>
            <td><input type="text" name="cus_organize" id="cus_organize" readonly class="disabled" maxlength="50" description="Tab Customer:cus organize" value="<?= $t_org_cus; ?><?= htmlspecialchars($incident["cus_organize"]) ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">Area </td>
            <td>
                <input type="hidden" name="cus_area" id="cus_area" readonly class="disabled" maxlength="50" description="Tab Customer:cus area" value="<?= $t_area_cus; ?><?= htmlspecialchars($incident["area_cus"]) ?>" />
                <input type="text" name="cus_area_name" id="cus_area_name" readonly class="disabled" maxlength="50" description="Tab Customer:cus area" value="<?= $t_area_cus_name; ?><?= htmlspecialchars($incident["area_cus_name"]) ?>" />
            </td>
        </tr>
        <tr>
            <td class="tr_header">Office </td>
            <td><input type="text" name="cus_office" id="cus_office" readonly class="disabled" maxlength="50" description="Tab Customer:cus office" value="<?= $t_office_cus; ?><?= htmlspecialchars($incident["cus_office"]) ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">Department </td>
            <td><input type="text" name="cus_department" id="cus_department" readonly class="disabled" maxlength="50" description="Tab Customer:cus_department" value="<?= $t_dep_cus; ?><?= htmlspecialchars($incident["cus_department"]) ?>" /></td>
        </tr>
        <tr>
            <td class="tr_header">Site </td>
            <td><input type="text" name="cus_site" id="cus_department" readonly class="disabled" maxlength="50" description="Tab Customer:cus_site" value="<?= $t_site_cus; ?><?= htmlspecialchars($incident["cus_site"]) ?>" /></td>
        </tr>
    </table>
    <input type="hidden" id="s_t_code_cus" name="s_t_code_cus" value="<?= $t_code_cus ?>">
    <input type="hidden" id="s_cusid" name="s_cusid" value="<?= $cusid ?>">
</div>
<script type="text/javascript">
    function show_alert_cus_id() {
        if ($("#s_t_code_cus").val() == "" && $("#s_cusid").val() != "") {
            clear_cus_infor();
            jAlert('error', '** Customer ID not found in Master Data', 'Helpdesk System : Messages');
            return false;

        }
    }
</script>