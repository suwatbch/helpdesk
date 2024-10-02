<?php
    session_start();
    include_once "incident.action.php";
    include_once "incident.getrunning.php";

    //echo $_GET["mode"];

    if ($incident["id"] != "" || $incident["id"] == 0) {
        $_SESSION["incident_id"] = $incident["id"];
    }

    #Set Tab Index
    if (!$incident["id"]) {
        $_SESSION["TabIndex"] = 0;
    } else if ($incident["status_id"] == 1 || $incident["status_id"] == 2) {
        $_SESSION["TabIndex"] = 3;
    } else if ($incident["status_id"] == 5) {
        $_SESSION["TabIndex"] = 5;
    } else if ($incident["status_id"] == 7) {
        $_SESSION["TabIndex"] = 6;
    } else {
        $_SESSION["TabIndex"] = 4;
    }

    #Show Incident Running Number
    $incident_run = incident_getrunning($incident["id"], $incident["ident_id_run_project"]);
    #Add by Uthen 18-4-2016
    echo '<script type="text/javascript">

                            var tmpStatusBefore = "' . $incident["status_id"] . '";
                            sessionStorage.setItem("tmpStatusBefore",tmpStatusBefore);
                            //console.log("incident.php->Status before: "+tmpStatusBefore);
    </script>';
    #end add line
    $attach_cas = "N";
    ?>

<script type="text/javascript" src="../../include/js/ajax-file-upload/ajaxupload.3.5.js"></script>
<!--script type="text/javascript" src="../../include/js/jquery/jquery-2.1.4.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			//alert("Alert from incident.php");
			var prior = $('select[name="priority_id"] option').filter(function () {
				return this.defaultSelected;
			}).prop("value");
			//alert(prior);
		});



	</script>

<!-- Watch Priority dropdownbox change event -->

<!-- End -->

<!-- Add by Uthen -->
<script type="text/javascript">
    $(document).ready(function() {
        var ssStatusBefore = sessionStorage.getItem("tmpStatusBefore");
        var ssPriorityBefore = sessionStorage.getItem("tmpPriorityBefore");

        var statusTxt = document.getElementById("hdStatusIdBefore");
        var priorityTxt = document.getElementById("hdPriorityIdBefore");

        statusTxt.value = ssStatusBefore;
        priorityTxt.value = ssPriorityBefore;
    });
</script>
<!-- end add -->

<script type="text/javascript">
    //    $(document).ready(function(){
    //		
    //		//---------------------
    //		//$("#btnbrowse").click(function(){;
    //			//alert("test");
    //			//new AjaxUpload($("#btnbrowse")
    //			new AjaxUpload($("#btnbrowse")
    //			, {action: "../../upload/upload_inc_workinfo.php?inci="+$("#incident_id").val()
    //				, name: 'uploadfile'
    //				, onSubmit: function(file, ext){
    //					/*
    //					if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
    //						// extension is not allowed
    //						alert("Only JPG, PNG,  JPEG or GIF files are allowed");
    //						return false;
    //					}*/
    //					add_file(file);
    //				}
    //					
    //				/*, onComplete: function(file, response){
    //					//On completion clear the status
    //					$("#wait").remove();
    //	
    //					//Add uploaded file to list
    //					if(response === "error"){
    //						alert("Can't not upload " + file + " !!!");
    //					} else {
    //						set_photo(response, response);
    //					}
    //				}*/
    //			});
    //                    
    //		//});
    //		//---------------------
    //    });

    //    $(document).ready(function(){
    //		
    //		//---------------------
    //		//$("#btnbrowse").click(function(){;
    //			//alert("test");
    //			//new AjaxUpload($("#btnbrowse")   
    //                     new AjaxUpload($("#btnbrowse_cass")
    //			, {action: "../../upload/upload_inc_cass.php?inci="+$("#incident_id").val()+"&incident_status="+$("#incident_status").val()+"&s_upload=1"
    //				, name: 'uploadfile_cass'
    //				, onSubmit: function(file, ext){
    //					/*
    //					if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
    //						// extension is not allowed
    //						alert("Only JPG, PNG,  JPEG or GIF files are allowed");
    //						return false;
    //					}*/
    //					add_file2(file);
    //				}
    //					
    //				/*, onComplete: function(file, response){
    //					//On completion clear the status
    //					$("#wait").remove();
    //	
    //					//Add uploaded file to list
    //					if(response === "error"){
    //						alert("Can't not upload " + file + " !!!");
    //					} else {
    //						set_photo(response, response);
    //					}
    //				}*/
    //			});
    //			
    //		//});
    //		//---------------------
    //    });
</script>

<!--Start Upload File-->
<script type="text/javascript">
    var i = 1;
    var items = new Array();

    function add_file(file) {
        //alert(file);

        var j = i - 1;

        var box = document.getElementById('file_list');
        var num = box.length;
        var file_exists = 0;

        //--------
        var theItem = file;
        items.push(theItem);
        document.getElementById('hd_file_name').value = items;

        //--------

        for (x = 0; x < num; x++) {
            if (box.options[x].text == file) {
                jAlert('error', 'This file has already been added to the Upload List.', 'Helpdesk System : Messages');
                document.getElementById('file_' + j).value = "";
                file_exists = 1;
                break;
            }
        }

        if (file_exists == 0) {
            // For Internet Explorer
            try {
                el = document.createElement('<input type="file" name="userfile[]" id="file_' + i + '" size="30" onChange="javascript:add_file(this.value);">');
            }
            // For other browsers
            catch (e) {
                el = document.createElement('input');
                el.setAttribute('type', 'file');
                el.setAttribute('name', 'userfile[]');
                el.setAttribute('id', 'file_' + i);
                el.setAttribute('size', '30');
                el.setAttribute('onChange', 'javascript:add_file(this.value);');
            }

            document.getElementById('file_' + j).style.display = 'none';

            if (document.getElementById('list_div').style.display == 'none') {
                document.getElementById('list_div').style.display = 'block';
            }

            document.getElementById('files_div').appendChild(el);
            box.options[num] = new Option(file, 'file_' + j);

            i++;
        }
    }

    function remove_file() {
        var box = document.getElementById('file_list');

        if (box.selectedIndex != -1) {
            var value = box.options[box.selectedIndex].value;
            var child = document.getElementById(value);
            var remove_f = box.options[box.selectedIndex].text;
            //alert(box.options[box.selectedIndex]);
            box.options[box.selectedIndex] = null;
            document.getElementById('files_div').removeChild(child);


            //--------
            //var theItem = file;
            //alert(remove_f);
            //document.getElementById('hd_file_name').value = items;
            //alert(items.length);
            //alert(box.options[box.selectedIndex]);
            for (var i = 0; i < items.length; i++) {
                if (items[i] == remove_f) {
                    //alert(remove_f);
                    //alert(i);
                    items.pop(box.options[box.selectedIndex]);
                }
            }
            //--------


            if (box.length == 0) {
                //document.getElementById('list_div').style.display = 'none';
            }
            //--------------------------------
            if (remove_f) {
                //alert(remove_f);
                $.get('../../upload/upload_inc_workinfo.php?remove_file=' + remove_f + '&inci=' + $("#incident_id").val(), function(data) {
                    $('.result').html(data);
                    //alert('Load was performed.');
                });
            }
            /*
            if(remove_f){
            	//alert(remove_f);
            	$.get('../../upload/upload_inc_workinfo.php?remove_file='+remove_f+'&inci='+$("#incident_id").val(), function(data) {
            	  $('.result').html(data);
            	  //alert('Load was performed.');
            	});
            }
            */
            //--------------------------------

        } else {
            jAlert('error', 'You must first select a file from the list.', 'Helpdesk System : Messages');
        }
    }


    function do_submit() {
        // Uncomment this block for the real onSubmit code

        var box = document.getElementById('file_list');
        var max_files = 5;

        if (box.length <= max_files) {
            var child = document.getElementById('file_' + (i - 1));

            div = document.getElementById('files_div');
            div.removeChild(child);
            div.style.display = 'none';

            return true;
        } else {
            jAlert('error', 'You have more files listed than the maximum allowed.\nPlease limit your upload files to no more than <? echo $upload_max_files; ?> at a time.', 'Helpdesk System : Messages');
            return false;
        }

        // Just for test page
        jAlert('success', 'Files uploaded successfully', 'Helpdesk System : Messages');
        return false;
    }
</script>
<script type="text/javascript">
    var i_cass = 1;
    var items_cass = new Array();

    function add_file2(file) {
        //alert(file);

        var j = i_cass - 1;

        var box = document.getElementById('file_list_cass');
        var num = box.length;
        var file_exists = 0;

        //--------
        var theItem = file;
        items_cass.push(theItem);
        document.getElementById('hd_file_name_cass').value = items_cass;

        //--------

        for (x = 0; x < num; x++) {
            if (box.options[x].text == file) {
                jAlert('error', 'This file has been already added to the Upload List.', 'Helpdesk System : Messages');
                document.getElementById('file_cass_' + j).value = "";
                file_exists = 1;
                break;
            }
        }

        if (file_exists == 0) {
            // For Internet Explorer
            try {
                el = document.createElement('<input type="file" name="userfile_cass[]" id="file_cass_' + i + '" size="30" onChange="javascript:add_file2(this.value);">');
            }
            // For other browsers
            catch (e) {
                el = document.createElement('input');
                el.setAttribute('type', 'file');
                el.setAttribute('name', 'userfile_cass[]');
                el.setAttribute('id', 'file_cass_' + i_cass);
                el.setAttribute('size', '30');
                el.setAttribute('onChange', 'javascript:add_file2(this.value);');
            }

            document.getElementById('file_cass_' + j).style.display = 'none';

            if (document.getElementById('list_div_cass').style.display == 'none') {
                document.getElementById('list_div_cass').style.display = 'block';
            }

            document.getElementById('files_div_cass').appendChild(el);
            box.options[num] = new Option(file, 'file_cass_' + j);

            i_cass++;
        }
    }

    function remove_file2() {
        var box = document.getElementById('file_list_cass');

        if (box.selectedIndex != -1) {
            var value = box.options[box.selectedIndex].value;
            var child = document.getElementById(value);
            var remove_f = box.options[box.selectedIndex].text;
            //alert(box.options[box.selectedIndex]);
            box.options[box.selectedIndex] = null;
            document.getElementById('files_div_cass').removeChild(child);


            //--------
            //var theItem = file;
            //alert(remove_f);
            //document.getElementById('hd_file_name').value = items;
            //alert(items.length);
            //alert(box.options[box.selectedIndex]);
            for (var i = 0; i < items.length; i++) {
                if (items[i] == remove_f) {
                    //alert(remove_f);
                    //alert(i);
                    items.pop(box.options[box.selectedIndex]);
                }
            }
            //--------


            if (box.length == 0) {
                //document.getElementById('list_div').style.display = 'none';
            }
            //--------------------------------
            if (remove_f) {
                //alert(remove_f);
                $.get('../../upload/upload_inc_cass.php?remove_file_cass=' + remove_f + '&inci=' + $("#incident_id").val() + '&incident_status=' + $("#incident_status").val(), function(data) {
                    $('.result').html(data);
                    //alert('Load was performed.');
                });
            }
            /*
            if(remove_f){
            	//alert(remove_f);
            	$.get('../../upload/upload_inc_workinfo.php?remove_file='+remove_f+'&inci='+$("#incident_id").val(), function(data) {
            	  $('.result').html(data);
            	  //alert('Load was performed.');
            	});
            }
            */
            //--------------------------------

        } else {
            jAlert('error', 'You must first select a file from the list.', 'Helpdesk System : Messages');
        }
    }
</script>
<!--Stop Upload File-->
<link type="text/css" rel="stylesheet" href="../../include/js/tabber/example.css" />
<script src="SetdefaultTab.php" type="text/javascript"></script>
<script type="text/javascript" src="../../include/js/tabber/tabber.js"></script>
<script type="text/javascript" src="../../dialog/dialog.ui.js"></script>

<script type="text/javascript">
    $(function() {

        $("#div").css("display", "block");

        $("#btn_cus_id").click(function() {
            $("#ifr_cus_id").attr("src", "../../dialog/customer.php");
            $("#dialog-customer").dialog("open");
        });
        /*
        $("<div id=\"dialog\"></div>")
        .appendTo("form")
        .dialog({
            width: 750
            , height: document.body.clientHeight - 25
            , autoOpen: false
            , modal: true
            , resizable: false
            , title: "Activity Plan"
            , close : function(){
                $("#ifr").attr("src", "");
            }
        });
        
        $("<div id=\"dialog-reason\"></div>")
        .appendTo("form")
        .dialog({
            width: 500
            , height: document.body.clientHeight - 200
            , autoOpen: false
            , modal: true
            , resizable: false
            , title: "Rejection Reason"
            , close : function(){
                $("#ifr-reason").attr("src", "");
            }
        });
        
        $("img[alt=View]").click(function(){
            if ($("#dialog").find("iframe").length == 0){
                $("#dialog").html("<iframe id=\"ifr\" frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"auto\" src=\"../../blank.php\"></iframe>");
            }
            
            $("#ifr").attr("src", "../../dialog/activity_plan.php?id=" + $(this).attr("value") + "&status=" + $("#type_status").val());

            var maxHeight = 420;
            var height = $("#dialog").dialog("option", "height");
            if ( height > maxHeight){
                $("#dialog").dialog("option", "height",  maxHeight);
            }

            $("#dialog").dialog("open");
        });
        
               
        $("#approve").click(function(){
                if (validate()){
                    if (validate2()){
                        var member = new Array;
                        $("#tblmember tbody").find(":checked").each(function(){
                        
                        var tr = $(this).parent().parent();
                        var obj = new Object;

                        obj.activity_plan_id = tr.attr("value");
                        member.push(obj);
                    });
                        var select_id = window.id_onselected(member);
                        if (select_id != ""){
                            $("#selected").val(select_id); 
                            page_submit("index.php?action=approve_list.php", "approve");
                        }
                    }
                }
            });

        $("#reject").click(function(){
            if (validate()){
                if (validate2()){
                    $("#click_type").val("reject");
                    $("#tblmember tbody").find(":checked").each(function(){
                        if ($("#dialog-reason").find("iframe").length == 0){
                        $("#dialog-reason").html("<iframe id=\"ifr-reason\" frameborder=\"0\" width=\"100%\" height=\"100%\" scrolling=\"no\" src=\"../../blank.php\"></iframe>");
                    }
                    $("#ifr-reason").attr("src", "reject_dialog.php");
                    $("#dialog-reason").dialog("open");
                    });
                    
                }
            }
        });

            
            
            $("#search").click(function(){
            if (validate()){
                var arr = null;
                var d1 = $("#start_date").val();
                var d2 = $("#end_date").val();
                
                arr = d1.split("-");
                d1 = arr[2] + "" + arr[1] + "" + arr[0];

                arr = d2.split("-");
                d2 = arr[2] + "" + arr[1] + "" + arr[0];

                if (d2 < d1) {
                    alert("Activity to is greater than Activity from.");
                    return false;
                }
                
                page_submit("index.php?action=approve_list.php", "search");
            }
        });
		
        $("#chkAll").change(function(){
                    var checked = $(this).is(":checked");
                    $("#tblmember tbody :checkbox").each(function(){
                        $(this).attr("checked", checked);
                    });
                });

        
        $("#tblmember tbody :checkbox").change(function(){
            var checked = true;
            $("#tblmember tbody :checkbox").each(function(){
                if (!$(this).is(":checked")){
                    checked = false;
                    return;
                }
            });

            $("#chkAll").attr("checked", checked);                    
        });
		
        $("#sendmail").click(function(){
                    page_submit("sendmail.php?action=mail");
                });
		*/
        //////////////////////////////////////////////////////////////////////////////////
        //In active on change status_id
        $("#status_id").change(function() {
            var status_id = $(this).val();
            var s_status_id = $("#s_status_id").val();
            //alert(status_id);
            //alert(s_status_id);   
            if (status_id == "" || status_id == 0) {
                jAlert('error', 'Status must not set to blank', 'Helpdesk System : Messages');
                return false;
            }
            if ((status_id != s_status_id) && (s_status_id != 5 && s_status_id != 6 && s_status_id != 7) && (status_id != 5 && status_id != 6 && status_id != 7)) {
                //alert('fucntion1');

                $.ajax({
                    type: "GET",
                    url: "dropdown.status_res.php",
                    data: "status_id=" + status_id /*+ "&attr=style=\"width:100%;\""*/,
                    success: function(respone) {
                        $("#status_res_id").replaceWith(respone);
                    }
                });
            }
            if ((status_id != s_status_id) && (status_id == 5 || status_id == 6 || status_id == 7) && (s_status_id != 5 && s_status_id != 6 && s_status_id != 7)) {
                //alert('fucntion2');

                $.ajax({
                    type: "GET",
                    url: "dropdown.status_res.php",
                    data: "status_id=" + status_id /*+ "&attr=style=\"width:100%;\""*/,
                    success: function(respone) {
                        $("#status_res_id").replaceWith(respone);
                    }
                });
            }
            if ((status_id != s_status_id) && (status_id != 5 && status_id != 6 && status_id != 7)) {
                //alert('fucntion3');

                $.ajax({
                    type: "GET",
                    url: "dropdown.status_res.php",
                    data: "status_id=" + status_id /*+ "&attr=style=\"width:100%;\""*/,
                    success: function(respone) {
                        $("#status_res_id").replaceWith(respone);
                    }
                });
            }
            $("#s_status_id").val(status_id);

        });

        $("#priority_id").change(function() {
            var priority_id = $(this).val();
            if (priority_id == "" || priority_id == 0) {
                jAlert('error', 'Priority must not set to  blank', 'Helpdesk System : Messages');
                return false;
            }
        });

        //In active on change impact_id
        $("#impact_id").change(function() {
            var impact_id = $(this).val();
            var urgency_id = $("#urgency_id").val();
            //alert(urgency_id);

            $.ajax({
                type: "GET",
                url: "dropdown.priority.php",
                data: "impact_id=" + impact_id + "&urgency_id=" + urgency_id /*+ "&attr=style=\"width: 100%;\" class=\"select_dis\" disabled"*/,
                success: function(respone) {
                    $("#priority_id").replaceWith(respone);
                    var v_priority_id = $("#priority_id").val();
                    //alert(v_priority_id);
                    $("#ddpriority_id").val(v_priority_id);
                }
            });
        });

        //In active on change urgency_id
        $("#urgency_id").change(function() {
            var urgency_id = $(this).val();
            var impact_id = $("#impact_id").val();

            $.ajax({
                type: "GET",
                url: "dropdown.priority.php",
                data: "impact_id=" + impact_id + "&urgency_id=" + urgency_id /*+ "&attr=style=\"width: 100%;\" class=\"select_dis\" disabled"*/,
                success: function(respone) {
                    $("#priority_id").replaceWith(respone);
                    var v_priority_id = $("#priority_id").val();
                    //alert(v_priority_id);
                    $("#ddpriority_id").val(v_priority_id);
                }
            });
        });

        //In active on change cas_opr_tier_id1
        $("#cas_opr_tier_id1").change(function() {
            //alert("1234");
            var cas_opr_tier_id1 = $(this).val();
            var cus_company_id = $("#cus_company_id").val();

            $.ajax({
                type: "GET",
                url: "dropdown.opr_tier2.php",
                data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(response) {
                    //alert(response);
                    //$("#cas_opr_tier_id2").replaceWith(response);
                    document.getElementById("cas_opr_tier_id2").innerHTML = response;
                }
            });

            var cas_opr_tier_id2 = $(this).val();
            var cas_opr_tier_id1 = $("#cas_opr_tier_id1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cas_opr_tier_id2);
            $.ajax({
                type: "GET",
                url: "dropdown.opr_tier3.php",
                data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //alert(respone);
                    //$("#cas_opr_tier_id3").replaceWith(respone);
                    document.getElementById("cas_opr_tier_id3").innerHTML = respone;
                }
            });
        });

        //In active on change cas_opr_tier_id2
        $("#cas_opr_tier_id2").change(function() {

            var cas_opr_tier_id2 = $(this).val();
            var cas_opr_tier_id1 = $("#cas_opr_tier_id1").val();
            var cus_company_id = $("#cus_company_id").val();
            $.ajax({
                type: "GET",
                url: "dropdown.opr_tier3.php",
                data: "cas_opr_tier_id1=" + cas_opr_tier_id1 + "&cas_opr_tier_id2=" + cas_opr_tier_id2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //alert(respone);
                    //$("#cas_opr_tier_id3").replaceWith(respone);
                    document.getElementById("cas_opr_tier_id3").innerHTML = respone;
                }
            });
        });

        //In active on change cas_prd_tier_id1
        $("#cas_prd_tier_id1").change(function() {
            var cas_prd_tier_id1 = $(this).val();
            var cus_company_id = $("#cus_company_id").val();
            //var cas_opr_tier_id2 = $("#cas_opr_tier_id2").val();

            $.ajax({
                type: "GET",
                url: "dropdown.prd_tier2.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("cas_prd_tier_id2").innerHTML = respone;
                }
            });
            var cas_prd_tier_id2 = $(this).val();
            var cas_prd_tier_id1 = $("#cas_prd_tier_id1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cus_company_id);
            $.ajax({
                type: "GET",
                url: "dropdown.prd_tier3.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cas_prd_tier_id2=" + cas_prd_tier_id2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("cas_prd_tier_id3").innerHTML = respone;
                }
            });

        });

        //In active on change cas_prd_tier_id2
        $("#cas_prd_tier_id2").change(function() {
            var cas_prd_tier_id2 = $(this).val();
            var cas_prd_tier_id1 = $("#cas_prd_tier_id1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cas_prd_tier_id1);
            //alert(cas_prd_tier_id2);
            $.ajax({
                type: "GET",
                url: "dropdown.prd_tier3.php",
                data: "cas_prd_tier_id1=" + cas_prd_tier_id1 + "&cas_prd_tier_id2=" + cas_prd_tier_id2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("cas_prd_tier_id3").innerHTML = respone;
                }
            });
        });


        //In active on change resol_oprtier1
        $("#resol_oprtier1").change(function() {
            var resol_oprtier1 = $(this).val();
            var cus_company_id = $("#cus_company_id").val();
            //var cas_opr_tier_id2 = $("#cas_opr_tier_id2").val();
            //alert(cus_company_id);

            $.ajax({
                type: "GET",
                url: "dropdown.opr_tier2_resol.php",
                data: "resol_oprtier1=" + resol_oprtier1 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("resol_oprtier2").innerHTML = respone;
                }
            });
            var resol_oprtier2 = $("#resol_oprtier2").val();
            var resol_oprtier1 = $("#resol_oprtier1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cas_opr_tier_id2);

            $.ajax({
                type: "GET",
                url: "dropdown.opr_tier3_resol.php",
                data: "resol_oprtier1=" + resol_oprtier1 + "&resol_oprtier2=" + resol_oprtier2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("resol_oprtier3").innerHTML = respone;
                }
            });
        });

        //In active on change resol_oprtier2
        $("#resol_oprtier2").change(function() {
            var resol_oprtier2 = $(this).val();
            var resol_oprtier1 = $("#resol_oprtier1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cas_opr_tier_id2);

            $.ajax({
                type: "GET",
                url: "dropdown.opr_tier3_resol.php",
                data: "resol_oprtier1=" + resol_oprtier1 + "&resol_oprtier2=" + resol_oprtier2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("resol_oprtier3").innerHTML = respone;
                }
            });

            // for check existing class3 from db
            $.ajax({
                type: "GET",
                url: "opr_tier3_exists.php",
                data: "resol_oprtier1=" + resol_oprtier1 + "&resol_oprtier2=" + resol_oprtier2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    $("#exists_opr_class3").val(respone);
                    //                    alert(respone);
                },
                error: function() {
                    $("#exists_opr_class3").val("");
                }

            });
        });


        $("#resol_oprtier3").change(function() {
            var resol_oprtier2 = $("#resol_oprtier2").val();
            var resol_oprtier1 = $("#resol_oprtier1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(cas_opr_tier_id2);


            // for check existing class3 from db
            $.ajax({
                type: "GET",
                url: "opr_tier3_exists.php",
                data: "resol_oprtier1=" + resol_oprtier1 + "&resol_oprtier2=" + resol_oprtier2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    $("#exists_opr_class3").val(respone);
                    //                    alert(respone);
                },
                error: function() {
                    $("#exists_opr_class3").val("");
                }

            });
        });


        //In active on change resol_prdtier1
        $("#resol_prdtier1").change(function() {
            var resol_prdtier1 = $(this).val();
            var cus_company_id = $("#cus_company_id").val();
            //var cas_opr_tier_id2 = $("#cas_opr_tier_id2").val();
            //alert(cas_opr_tier_id2);

            $.ajax({
                type: "GET",
                url: "dropdown.prd_tier2_resol.php",
                data: "resol_prdtier1=" + resol_prdtier1 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("resol_prdtier2").innerHTML = respone;
                }
            });
            var resol_prdtier2 = $("#resol_prdtier2").val();
            var resol_prdtier1 = $("#resol_prdtier1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(resol_prdtier2);

            $.ajax({
                type: "GET",
                url: "dropdown.prd_tier3_resol.php",
                data: "resol_prdtier1=" + resol_prdtier1 + "&resol_prdtier2=" + resol_prdtier2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("resol_prdtier3").innerHTML = respone;
                }
            });
        });

        //In active on change resol_prdtier2
        $("#resol_prdtier2").change(function() {
            var resol_prdtier2 = $(this).val();
            var resol_prdtier1 = $("#resol_prdtier1").val();
            var cus_company_id = $("#cus_company_id").val();
            //alert(resol_prdtier2);

            $.ajax({
                type: "GET",
                url: "dropdown.prd_tier3_resol.php",
                data: "resol_prdtier1=" + resol_prdtier1 + "&resol_prdtier2=" + resol_prdtier2 + "&cus_company_id=" + cus_company_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("resol_prdtier3").innerHTML = respone;
                }
            });
        });

        //In active on change assign_comp_id
        $("#assign_comp_id").change(function() {
            var assign_comp_id = $(this).val();
            //var cas_opr_tier_id2 = $("#cas_opr_tier_id2").val();
            //alert(assign_comp_id);

            $.ajax({
                type: "GET",
                url: "dropdown.org_user.php",
                data: "assign_comp_id=" + assign_comp_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_org_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_comp_id").val($("#assign_comp_id").val());
                    //===============================================
                    $("#ddassign_org_id").val($("#assign_org_id").val());
                }
            });
            //====In active on change assign_org_id
            var assign_org_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.grp_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_org_id=" + assign_org_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_group_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_org_id").val($("#assign_org_id").val());
                }
            });
            //====In active on change assign_group_id
            var assign_group_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.subgrp_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_group_id=" + assign_group_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_subgrp_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_group_id").val($("#assign_group_id").val());
                }
            });
            //====In active on change assign_subgrp_id
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.assingee_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_subgrp_id=" + assign_subgrp_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_assignee_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_subgrp_id").val($("#assign_subgrp_id").val());
                }
            });
        });

        //In active on change assign_org_id
        $("#assign_org_id").change(function() {
            var assign_org_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.grp_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_org_id=" + assign_org_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_group_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_org_id").val($("#assign_org_id").val());
                    //===============================================
                    $("#ddassign_group_id").val($("#assign_group_id").val());
                }
            });
            //====In active on change assign_group_id
            var assign_group_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.subgrp_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_group_id=" + assign_group_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_subgrp_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_group_id").val($("#assign_group_id").val());
                }
            });
            //====In active on change assign_subgrp_id
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.assingee_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_subgrp_id=" + assign_subgrp_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_assignee_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_subgrp_id").val($("#assign_subgrp_id").val());
                }
            });
        });

        //In active on change assign_group_id
        $("#assign_group_id").change(function() {
            var assign_group_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.subgrp_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_group_id=" + assign_group_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_subgrp_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_group_id").val($("#assign_group_id").val());
                }
            });
            //====In active on change assign_subgrp_id
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.assingee_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_subgrp_id=" + assign_subgrp_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_assignee_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_subgrp_id").val($("#assign_subgrp_id").val());
                }
            });
        });

        //In active on change assign_subgrp_id
        $("#assign_subgrp_id").change(function() {
            var assign_subgrp_id = $(this).val();
            var assign_comp_id = $("#assign_comp_id").val();
            //alert(assign_comp_id);
            //alert(assign_org_id);

            $.ajax({
                type: "GET",
                url: "dropdown.assingee_user.php",
                data: "assign_comp_id=" + assign_comp_id + "&assign_subgrp_id=" + assign_subgrp_id /*+ "&attr=style=\"width: 100%;\""*/,
                success: function(respone) {
                    //$("#cas_opr_tier_id2").replaceWith(respone);
                    //alert(respone);
                    document.getElementById("assign_assignee_id").innerHTML = respone;
                    //===============================================
                    $("#ddassign_subgrp_id").val($("#assign_subgrp_id").val());
                }
            });
        });

        //////////////////////////////////////////////////////////////////////////////////		
    });

    /* 
    function dialog_onSelected(lookuptype, obj){
            if (obj != null){
                if (lookuptype == "project"){
                    $("#project_id").val(obj.project_id);
                    $("#project_name").val(obj.project_name);

                } else if (lookuptype == "employee"){
                    $("#employee_id").val(obj.employee_id);
                    $("#employee_name").val(obj.employee_name);
                }
              } 
            }
            
            
    function validate2(){
            var err = $("#duration span").html();
            if (err != "" && err != null){
                alert(err);
                if (err.indexOf("End") > -1){
                    $("#end_time").focus();
                } else {
                    $("#start_time").focus();
                }
                return false;
            }
            return true;
        }
        
         
    function id_onselected(member){
            var plan_id = "" ;
            var i = 0;
            while (i< member.length){
                if (i==0){
                    plan_id = member[i].activity_plan_id
                }else{
                    plan_id = plan_id + ",";
                    plan_id = plan_id + member[i].activity_plan_id
                };
            i++;
            }
            return plan_id;
    }
    */
</script>
<script type="text/javascript">
    function back_inc() {
        <?
        if ($_GET["mode"] == "adv") { //from advance search
            $_SESSION["current"] = "incident/search_incident/index.php?action=result_list.php&ses=1";
        } else {
            $_SESSION["current"] = "incident/main_incident/index.php?mode=" . $_GET["mode"];
        }
        ?>
        top.location.href = "../../home.php";
    }

    function validate_cusid() {
        var cus_id = $("#cus_id").val();
        if ($("#incident_id").val() == "") {
            if (cus_id != $("#s_t_code_cus").val()) {
                $.ajax({
                    type: "GET",
                    url: "check_cusid.php",
                    data: "cus_id=" + cus_id,
                    success: function(respone) {
                        //alert(respone)
                        var myProduct = respone
                        if (myProduct != "") {

                            var myArr = myProduct.split("|");
                            $("#s_cus_id").val(myArr[0]);
                            $("#cus_firstname").val(myArr[1]);
                            $("#cus_lastname").val(myArr[2]);
                            $("#cus_phone").val(myArr[3]);
                            $("#cus_ipaddress").val(myArr[4]);
                            $("#cus_email").val(myArr[5]);
                            $("#cus_company").val(myArr[6]);
                            $("#cus_organize").val(myArr[7]);
                            $("#cus_area").val(myArr[8]);
                            $("#cus_office").val(myArr[9]);
                            $("#cus_department").val(myArr[10]);
                            $("#cus_site").val(myArr[11]);
                            $("#cus_company_id").val(myArr[12]);
                            $("#s_t_code_cus").val(myArr[0]);

                            clear_dropdown();
                            jAlert('error', 'Cassification Tab: Please input incident type', 'Helpdesk System : Messages');
                            return true;

                        } else {
                            clear_cus_infor();
                            clear_dropdown();
                            jAlert('error', '** Customer ID not found in Master Data', 'Helpdesk System : Messages');
                            return false;

                        }
                    }
                });
            } else {
                return true;
            }

        } else {
            // clear_dropdown();
            return true;
        }


    }

    function clear_dropdown() {
        get_dropdown_ident_type();
        get_dropdown_project();
        get_dropdown_opr_tier1();
        get_dropdown_prd_tier1();
        get_dropdown_opr_tier1_resol();
        get_dropdown_prd_tier1_resol();

    }

    function clear_cus_infor() {
        $("#s_cus_id").val(null);
        $("#cus_firstname").val(null);
        $("#cus_lastname").val(null);
        $("#cus_phone").val(null);
        $("#cus_ipaddress").val(null);
        $("#cus_email").val(null);
        $("#cus_company").val(null);
        $("#cus_organize").val(null);
        $("#cus_area").val(null);
        $("#cus_office").val(null);
        $("#cus_department").val(null);
        $("#cus_site").val(null);
        $("#cus_company_id").val(null);
        $("#s_t_code_cus").val(null);
        $("#s_t_code_cus").val(null);
    }
</script>
<script type="text/javascript">
    $(function() {
        $("#save").click(function() {

            if ($("#s_km_id").val() != "") {
                $("#getfile_name_resolution").val(getfile());
            }
            if ($("#status_id").val() == 5) {
                chk_resol_opr();
            }
            if (validate_status_inc()) {}

        });

        $("#back").click(function() {

            <?
            if ($_GET["mode"] == "adv") { //from advance search
                $_SESSION["current"] = "incident/search_incident/index.php?action=result_list.php&ses=1";
            } else {
                $_SESSION["current"] = "incident/main_incident/index.php?mode=1";
                //$_SESSION["current"] = "incident/main_incident/index.php?action=incident_list.php";
            }
            ?>
            top.location.href = "../../home.php";
        });

        //$("#perm").attr("src", "access_group.permission.php?access_group_id=<?= $access_group["access_group_id"] ?>");
        //$("#div").css("display", "block");


        $("#dialog-display-workinfo").dialog({
            height: 400,
            width: 700,
            autoOpen: false,
            modal: true,
            resizable: false,
            close: function() {
                $("#ifr").attr("src", "");
            }
        });

        $("#dialog-customer").dialog({
            height: 400,
            width: 700,
            autoOpen: false,
            modal: true,
            resizable: false,
            close: function() {
                $("#ifr_cus_id").attr("src", "");
            }
        });

        $("#dialog-km_process").dialog({
            height: 450,
            width: 900,
            autoOpen: false,
            modal: true,
            resizable: false,
            close: function() {
                $("#ifr_km_process").attr("src", "");
            }
        });
    });



    function chk_resol_opr() {
        var resol_oprtier2 = $("#resol_oprtier2").val();
        var resol_oprtier1 = $("#resol_oprtier1").val();
        var cus_company_id = $("#cus_company_id").val();

        $.ajax({
            type: "GET",
            url: "opr_tier3_exists.php",
            data: "resol_oprtier1=" + resol_oprtier1 + "&resol_oprtier2=" + resol_oprtier2 + "&cus_company_id=" + cus_company_id,
            success: function(respone) {
                $("#exists_opr_class3").val(respone);
                //                    alert(chk_exists_resol_oprtier3);
            }
        });
    }


    function chk_datasubmit_CreateIncident3Tab() {

        if ($("#cus_id").val() == "") {
            jAlert('error', 'Please input Customer ID', 'Helpdesk System : Messages');
            $("#cus_id").focus();
            return false;
        } else if ($("#txt_summary").val() == "") {
            jAlert('error', 'Please input summary', 'Helpdesk System : Messages');
            $("#txt_summary").focus();
            return false;
        } else if ($("#txt_notes").val() == "") {
            jAlert('error', 'Please input detail', 'Helpdesk System : Messages');
            $("#txt_notes").focus();
            return false;
        } else if ($("#impact_id").val() == "") {
            jAlert('error', 'Please input impact', 'Helpdesk System : Messages');
            $("#impact_id").focus();
            return false;
        } else if ($("#urgency_id").val() == "") {
            jAlert('error', 'Please input urgency', 'Helpdesk System : Messages');
            $("#urgency_id").focus();
            return false;
        } else if ($("#priority_id").val() == "") {
            jAlert('error', 'Please input priority', 'Helpdesk System : Messages');
            $("#priority_id").focus();
            return false;
        } else if ($("#cus_id").val() == "") {
            jAlert('error', 'Customer Tab: Please input Employee/Customer ID', 'Helpdesk System : Messages');
            $("#cus_id").focus();
            return false;
        } else if ($("#cus_firstname").val() == "") {
            jAlert('error', 'Customer Tab: Please input customer firstname', 'Helpdesk System : Messages');
            $("#cus_firstname").focus();
            return false;
        } else if ($("#cus_lastname").val() == "") {
            jAlert('error', 'Customer Tab: Please input customer lastname', 'Helpdesk System : Messages');
            $("#cus_lastname").focus();
            return false;
        } else if ($("#ident_type_id").val() == "") {
            jAlert('error', 'Cassification Tab: Please input incident type', 'Helpdesk System : Messages');
            $("#ident_type_id").focus();
            return false;
        } else if ($("#project_id").val() == "") {
            jAlert('error', 'Cassification Tab: Please input project', 'Helpdesk System : Messages');
            $("#project_id").focus();
            return false;
        } else if ($("#cas_opr_tier_id1").val() == "") {
            jAlert('error', 'Cassification Tab: Please input Operational class1', 'Helpdesk System : Messages');
            $("#cas_opr_tier_id1").focus();
            return false;
        } else if ($("#cas_opr_tier_id2").val() == "") {
            jAlert('error', 'Cassification Tab: Please input Operational class2', 'Helpdesk System : Messages');
            $("#cas_opr_tier_id2").focus();
            return false;
        } else if ($("#cas_prd_tier_id1").val() == "") {
            jAlert('error', 'Cassification Tab: Please input Product class1', 'Helpdesk System : Messages');
            $("#cas_prd_tier_id1").focus();
            return false;
        } else if ($("#cas_prd_tier_id2").val() == "") {
            jAlert('error', 'Cassification Tab: Please input Product class2', 'Helpdesk System : Messages');
            $("#cas_prd_tier_id2").focus();
            return false;
        } else if ($("#cas_prd_tier_id3").val() == "") {
            jAlert('error', 'Cassification Tab: Please input Product class3', 'Helpdesk System : Messages');
            $("#cas_prd_tier_id3").focus();
            return false;
        } else if ($('#cas_opr_tier_id3 > option[value!=""]').length != 0 && $("#cas_opr_tier_id3").val() == "") {
            jAlert('error', 'Cassification Tab: Please input Operational class3', 'Helpdesk System : Messages');
            return false;
        } else {
            return true;
        }
    }

    function validate_status_inc() {
        $.ajax({
            type: "GET",
            url: "validate_status_inc.php",
            data: "action=validate_status_inc&incident_id=" + $("#incident_id").val(),
            success: function(respone) {
                //alert(respone);
                if (respone == 1) {
                    jAlert('error', 'This Incident already exits to closed', 'Helpdesk System : Messages');
                    return false;
                } else {
                    if (validate_cusid()) {
                        if (chk_datasubmit()) {
                            //alert('submit');
                            page_submit("index.php?action=incident.php&cas_opr_tier_1=" + $("#cas_opr_tier_id1").val() + "&mode=" + $("#mode_back").val(), "save");
                        }
                    }
                }
            }
        });

    }

    function chk_datasubmit() {
        var set_data_inc = "";
        var chk_status_id = $("#status_id").val();

        if ($("#km_entrant").is(':checked')) {
            if ($("#km_keyword").val() == "") {
                jAlert('error', 'Resolution Tab:please input KM Keywords');
                return false;
            }
        }
        //alert($("#workinfo_summary").val()!="" || $("#workinfo_notes").val()!="" || $("#file_list").val()!= null);
        //alert($("#ss_assign_assignee_id").val());

        if (($("#assign_comp_id").val() != $("#ss_assign_comp_id").val()) ||
            ($("#assign_org_id").val() != $("#ss_assign_org_id").val()) ||
            ($("#assign_group_id").val() != $("#ss_assign_group_id").val()) ||
            ($("#assign_subgrp_id").val() != $("#ss_assign_subgrp_id").val()) ||
            ($("#assign_assignee_id").val() != $("#ss_assign_assignee_id").val())) {

            set_data_inc = 'a';
        } else if ($("#workinfo_summary").val() != "" || $("#workinfo_notes").val() != "" || $("#file_list").val() != null) {
            set_data_inc = 'w';
        } else if (($("#resol_prdtier1").val() != "" || $("#resol_oprtier1").val() != "" || $("#resolution").val() != "") &&
            (chk_status_id != 6 && chk_status_id != 7 && chk_status_id != 3 && chk_status_id != 4)) {
            set_data_inc = 'r';
        }
        if (set_data_inc == 'a' && chk_status_id != 2) {
            jAlert('error', 'please change status is assigned', 'Helpdesk System : Messages');
            return false;
        }
        if (set_data_inc == 'w' && (chk_status_id != 3 && chk_status_id != 4)) {
            jAlert('error', 'please change status is working or pending', 'Helpdesk System : Messages');
            return false;
        }
        if (set_data_inc == 'r' && chk_status_id != 5) {
            jAlert('error', 'please change status is resolved', 'Helpdesk System : Messages');
            return false;
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        if (chk_status_id == "") {
            jAlert('error', 'Please Select Status', 'Helpdesk System : Messages');
            $("#status_id").focus();
            return false;
            //New	
        } else if (chk_status_id == 1) {
            if (chk_datasubmit_CreateIncident3Tab()) {
                return true;
            }

            //Assigned	
        } else if (chk_status_id == 2) {
            if (!chk_datasubmit_CreateIncident3Tab()) {
                return false;
            }

            var chk_ddassign_comp_id = $("#ddassign_comp_id").val();
            var chk_ddassign_org_id = $("#ddassign_org_id").val();
            var chk_ddassign_group_id = $("#ddassign_group_id").val();
            var chk_ddassign_subgrp_id = $("#ddassign_subgrp_id").val();
            //if($("#h_status_idOld").val() == 5 || ( $("#h_status_idOld").val() == 6) && ($("#h_assign_assignee_id").val() == $("#h_userid_login").val())){ //ไม่อนุญาตให้ assigned กรณีที่ resloved แล้ว
            //		if($("#h_status_idOld").val() == 5){ //ไม่อนุญาตให้ assigned กรณีที่ resloved แล้ว
            //			alert("You are't allow assign incident because incident status to set resolved aleady.");
            //			$("#assign_comp_id").focus();
            //			return false;
            //		}

            if (chk_ddassign_comp_id == "") {
                jAlert('error', 'Assignment Tab: Please input assign company', 'Helpdesk System : Messages');
                $("#assign_comp_id").focus();
                return false;
            } else if (chk_ddassign_org_id == "") {
                jAlert('error', 'Assignment Tab: Please input assign organize', 'Helpdesk System : Messages');
                $("#assign_org_id").focus();
                return false;
            } else if (chk_ddassign_group_id == "") {
                jAlert('error', 'Assignment Tab: Please input assign group', 'Helpdesk System : Messages');
                $("#assign_group_id").focus();
                return false;
            } else if (chk_ddassign_subgrp_id == "") {
                jAlert('error', 'Assignment Tab: Please input assign sub group', 'Helpdesk System : Messages');
                $("#assign_subgrp_id").focus();
                return false;
            } else {
                return true;
            }
            //Working+Pending	
        } else if (chk_status_id == 3 || chk_status_id == 4) {
            if (!chk_datasubmit_CreateIncident3Tab()) {
                return false;
            }
            var chk_status_res_id = $("#status_res_id").val();
            var chk_workinfo_type_id = $("#workinfo_type_id").val();
            var chk_workinfo_summary = $("#workinfo_summary").val();
            var chk_workinfo_notes = $("#workinfo_notes").val();

            //if($("#h_status_idOld").val() == 5 || $("#h_status_idOld").val() == 6){
            if ($("#h_status_idOld").val() == 5) {
                //alert("You are't allow working/pending incident because incident status to set resolved aleady.");
                //$("#assign_comp_id").focus();
                //return false;
            } else if ($("#h_assign_assignee_id").val() != $("#h_userid_login").val()) {
                jAlert('error', 'Not allow working/pending because you do not owner.', 'Helpdesk System : Messages');
                return false;
            } else if (chk_status_id == 4) {
                if (chk_status_res_id == "") {
                    jAlert('error', 'Please input status reason', 'Helpdesk System : Messages');
                    $("#status_res_id").focus();
                    return false;
                }
            }
            if (chk_workinfo_type_id == "") {
                jAlert('error', 'Work Info Tab: Please input workinfo type', 'Helpdesk System : Messages');
                $("#workinfo_type_id").focus();
                return false;
            } else if (chk_workinfo_summary == "") {
                jAlert('error', 'Please Input Work Detail Information', 'Helpdesk System : Messages');
                $("#workinfo_summary").focus();
                return false;
            }
            /*else if(chk_workinfo_notes == ""){
            			alert("Work Info Tab: Please input workinfo notes ");
            			$("#workinfo_notes").focus();
            			return false;
            		}*/
            else {
                return true;
            }
            //Resolv	
        } else if (chk_status_id == 5) {

            if (!chk_datasubmit_CreateIncident3Tab()) {
                return false;
            }
            var chk_status_res_id = $("#status_res_id").val();
            var chk_resolution = $("#resolution").val();
            var chk_resol_oprtier1 = $("#resol_oprtier1").val();
            var chk_resol_oprtier2 = $("#resol_oprtier2").val();
            var chk_resol_oprtier3 = $("#resol_oprtier3").val();
            var chk_resol_prdtier1 = $("#resol_prdtier1").val();
            var chk_resol_prdtier2 = $("#resol_prdtier2").val();
            var chk_resol_prdtier3 = $("#resol_prdtier3").val();

            //                alert("select " + chk_resol_oprtier3);
            //                var chk_exists_resol_oprtier3 = $("#exists_opr_class3").val();
            //                alert("exists : " +  $("#exists_opr_class3").val());
            //                alert("class3 : " + chk_resol_oprtier3);
            //                
            $('#workinfo_table tr').each(function() {
                //var Type = $(this).find("td:first").html();
                //var Type = $(this).find("td").eq(1).html();
                //if(!this.rowIndex){ return;  }
                var chk_workinfo = this.cells[0].innerHTML;
                //alert(chk_workinfo);
                if (chk_workinfo == "") {
                    jAlert('error', 'Please set status to working/pending before resolved.', 'Helpdesk System : Messages');
                    $("#workinfo_type_id").focus();
                    return false;
                }
            })
            if ($("#h_assign_assignee_id").val() != $("#h_userid_login").val()) {
                jAlert('error', 'Not allow resolved because you do not owner.', 'Helpdesk System : Messages');
                $("#assign_assignee_id").focus();
                return false;
            } else if (chk_status_res_id == "") {
                jAlert('error', 'Please input status reason', 'Helpdesk System : Messages');
                $("#status_res_id").focus();
                return false;
            } else if (chk_resolution == "") {
                jAlert('error', 'Resolution Tab: Please input resolution', 'Helpdesk System : Messages');
                $("#resolution").focus();
                return false;
            } else if (chk_resol_oprtier1 == "") {
                jAlert('error', 'Resolution Tab: Please input resolution  operational class1', 'Helpdesk System : Messages');
                $("#resol_oprtier1").focus();
                return false;
            } else if (chk_resol_oprtier2 == "") {
                jAlert('error', 'Resolution Tab: Please input resolution  operational class2', 'Helpdesk System : Messages');
                $("#resol_oprtier2").focus();
                return false;
            } else if (chk_resol_prdtier1 == "") {
                jAlert('error', 'Resolution Tab: Please input resolution  Product class1', 'Helpdesk System : Messages');
                $("#resol_prdtier1").focus();
                return false;
            } else if (chk_resol_prdtier2 == "") {
                jAlert('error', 'Resolution Tab: Please input resolution  Product class2', 'Helpdesk System : Messages');
                $("#resol_prdtier2").focus();
                return false;
            } else if (chk_resol_prdtier3 == "") {
                jAlert('error', 'Resolution Tab: Please input resolution  Product class3', 'Helpdesk System : Messages');
                $("#resol_prdtier3").focus();
                return false;
            } else if ($("#exists_opr_class3").val() != "0" && $("#exists_opr_class3").val() != "" && chk_resol_oprtier3 == "") {
                //                        alert("ex : " +  $("#exists_opr_class3").val());
                //                        alert("select : " + chk_resol_oprtier3);
                jAlert('error', 'Resolution Tab: Please input resolution Operation class3', 'Helpdesk System : Messages');
                $("#resol_prdtier3").focus();
                return false;

            } else {
                return true;
            }
            //Propose Closed	
        } else if (chk_status_id == 6) {
            if (!chk_datasubmit_CreateIncident3Tab()) {
                return false;
            }
            if ($("#h_working_date").val() == "0000-00-00 00:00:00") {
                jAlert('error', 'Please set status to working/pending before Propose Closed.', 'Helpdesk System : Messages');
                $("#workinfo_type_id").focus();
                return false;
            } else if ($("#h_working_date").val() == "0000-00-00 00:00:00") {
                jAlert('error', 'Please set status to working/pending before Propose Closed.', 'Helpdesk System : Messages');
                $("#workinfo_type_id").focus();
                return false;
            } else if ($("#resolution_user").val() == "") {
                jAlert('error', 'Please set status to resolved before Propose Closed.', 'Helpdesk System : Messages');
                $("#resolution").focus();
                return false;
            }
            var chk_status_res_id = $("#status_res_id").val();

            if ($("#h_assign_assignee_id").val() != $("#h_userid_login").val()) {
                jAlert('error', 'Not allow propose closed because you do not owner', 'Helpdesk System : Messages');
                $("#assign_assignee_id").focus();
                return false;
            } else if (chk_status_res_id == "") {
                jAlert('error', 'Please input status reason', 'Helpdesk System : Messages');
                $("#status_res_id").focus();
                return false;
            } else {
                return true;
            }

        } else if (chk_status_id == 7) { //Colse
            if (!chk_datasubmit_CreateIncident3Tab()) {
                return false;
            }
            var chk_status_res_id = $("#status_res_id").val();
            var chk_h_userid_login = $("#h_userid_login").val();
            var chk_h_user_admin = $("#h_user_admin").val();
            var chk_assign_assignee_id = $("#assign_assignee_id").val();


            //		if($("#h_assign_assignee_id").val() != chk_h_userid_login && chk_h_user_admin == ""){
            if ($("#h_assign_assignee_id").val() != chk_h_userid_login) {
                jAlert('error', 'Not allow colsed because you do not owner', 'Helpdesk System : Messages');
                $("#status_res_id").focus();
                return false;
            } else if ($("#h_working_date").val() == "0000-00-00 00:00:00") {
                jAlert('error', 'Please set status to working/pending before closed.', 'Helpdesk System : Messages');
                $("#workinfo_type_id").focus();
                return false;
            } else if ($("#resolution_user").val() == "") {
                jAlert('error', 'Please set status to resolved before closed.', 'Helpdesk System : Messages');
                $("#resolution").focus();
                return false;
            }
            /* Comment by Uthen.p for jump to close directly
		else if($("#proposeclosed_date").val() == ""){
                        jAlert('error', 'Please set status to propose closed before closed.', 'Helpdesk System : Messages');
			$("#status_id").focus();
			return false;
		}
		*/
            else if (chk_status_res_id == "") {
                jAlert('error', 'Please input status reason', 'Helpdesk System : Messages');
                $("#status_res_id").focus();
                return false;
            } else {
                return true;
            }
        } else {
            //alert('Error');
            return true;
        }

        // Just for test page
        //alert('Files uploaded successfully');
    }
</script>
<!--<table width="100%">
	<tr>
		<td width="100%" style="border-bottom: #B40431 solid medium;" colspan="2"><br>
			<? if (strUtil::isEmpty($incident["id"])) { ?>
			<span class="styleBlue">CREATE INCIDENT</span>
			<? } else { ?>
			<span class="styleBlue">INCIDENT : <?= $incident["ident_id_run_project"] ?></span>
			<? } ?>
		</td>
	</tr>
	</table>-->
<table width="100%" border="0" style="position: absolute; top: -5px">
    <tr>
        <td width="35%" valign="top">
            <div align="center" style="border-right: #D4D6D6 solid thin; height : 600px; border-width:2px;">
                <table id="tb_adv_left" width="95%" style="height:550px;" border="0">
                    <tr>
                        <td valign="top">
                            <?php include "incident.header.php"; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td width="65%" valign="top">
            <div style="height : 550px; overflow-y: auto;">
                <table id="tb_adv_left" width="100%" border="0">
                    <tr>
                        <td>
                            <?php //$tabShoworhide = "tabbertab";
                            ?>
                            <div class="tabber" align="left">
                                <div align="left" class="tabbertab" title="Customer" style="height: 480px; overflow-y: auto;">
                                    <?php include "incident.tab.customer.php"; ?>
                                </div>
                                <div align="left" class="tabbertab" title="Contact" style="height: 480px; overflow-y: auto;">
                                    <?php include "incident.tab.contact.php"; ?>
                                </div>
                                <div align="left" class="tabbertab" title="Classification" style="height: 480px; overflow-y: auto;">
                                    <?php include_once "incident.tab.cassification.php"; ?>
                                </div>
                                <div align="left" class="<?= $tabShoworhide ?>" title="Assignment" style="height: 480px; overflow-y: auto;">
                                    <?php include_once "incident.tab.assignment.php"; ?>
                                </div>
                                <div align="left" class="<?= $tabShoworhide ?>" title="Work Info" style="height: 480px; overflow-y: auto;">
                                    <?php include_once "incident.tab.workinfo.php"; ?>
                                </div>
                                <div align="left" class="<?= $tabShoworhide ?>" title="Resolution" style="height: 480px; overflow-y: auto;">
                                    <?php include_once "incident.tab.Resolution.php"; ?>
                                </div>
                                <div align="left" class="<?= $tabShoworhide ?>" title="Date/System" style="height: 480px; overflow-y: auto;">
                                    <?php include_once "incident.tab.datesystem.php"; ?>
                                </div>

                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>



</table>


<input type="hidden" id="hdStatusIdBefore" name="hdStatusIdBefore" value="<?= $tmpStatusIdBefore; ?>" />
<input type="hidden" id="hdPriorityIdBefore" name="hdPriorityIdBefore" value="<?= $tmpPriorityIdBefore; ?>" />

<input name="incident_id" id="incident_id" type="hidden" value="<?= $incident["id"] ?>" />
<input name="incident_status" id="incident_status" type="hidden" value="<?= $incident["status_id"] ?>" />
<input type="hidden" name="assigned_date" value="<?= $incident["assigned_date"] ?>" />
<input type="hidden" id="h_userid_login" name="h_userid_login" value="<?= user_session::get_user_id(); ?>" />
<input type="hidden" id="h_user_admin" name="h_user_admin" value="<?= user_session::get_user_admin(); ?>" />
<input name="exists_opr_class3" id="exists_opr_class3" type="hidden" value="<?= $ex_opr_class3; ?>" />
<input name="exists_cas_opr_class3" id="exists_cas_opr_class3" type="hidden" value="<?= $ex_cas_opr_class3; ?>" />
<input type="hidden" id="s_km_id" name="s_km_id" value="<?= $incident["s_km_id"] ?>">
<input type="hidden" id="getfile_name_resolution" name="getfile_name_resolution" value="">
<input type="hidden" id="km_release" name="km_release" value="<?= $incident["km_release"] ?>"