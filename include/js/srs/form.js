var frmMain = null; 
var bLockUI = false;

function page_init() {
    frmMain = document.forms["frmMain"];
    // set focus
    var pageSetFocus = document.getElementById("SET_FOCUS");
    if (pageSetFocus && pageSetFocus.value && pageSetFocus.value!="") {
        var id = pageSetFocus.value;
        var e = document.getElementById(id);
        if (!e) {
          e = document.getElementsByName(id);
          if (e) {
                e = e[0];
          }
        }
        if (e) {
          e.focus();
        }
    }
}

function page_submit(action, action_name) {
	//alert(action);
	//alert(action_name);
    if (!bLockUI) {
        //waitShow();
        if (action != undefined && action != null && action != ""){
            frmMain.action = action;
        }
        
        frmMain.action_name.value = (action_name == undefined || action_name == null) ? "" : action_name;
        setTimeout(function(){
            frmMain.submit()
        }, 500);
        bLockUI = true;
    }
}

//function page_submit(action, action_name) {
//    if (!bLockUI) {
//        if (action != undefined && action != null && action != "")
//        {
//            frmMain.action = action;
//        }
//        frmMain.action_name.value = action_name;
//        frmMain.submit();
//        bLockUI = true;
//
//        var divDisplayMsg = document.getElementById("divDisplayMsg");
//        if (divDisplayMsg) {
//                divDisplayMsg.innerHTML = "<span class='text_display'>&nbsp;<img src='../images/wait.gif'>&nbsp;��س����ѡ���� ...</img></span>";
//        }
//    }
//}

function page_delete(action, action_name,msg) {
    if (confirm_delete(msg)){
        page_submit(action, action_name);
        return true;
    }

    return false;
}

function confirm_delete(msg){
    return confirm((msg != "" && msg != undefined) ? msg : "Do you want delete?");
}

//document.onkeydown = checkKey;
//function beforeCheckKey(oEvent, oTarget) {
//	return true;
//}
//function checkKey(oEvent){
//	var oEvent = (oEvent)? oEvent : event;
//	var oTarget =(oEvent.target)? oEvent.target : oEvent.srcElement;
//
//	beforeCheckKey(oEvent, oTarget)
//
//	if((oEvent.keyCode==13) && (oTarget.name!="RECORD_NO") && (oTarget.type=="text" || oTarget.type=="select-one" || oTarget.type=="select-multiple" || oTarget.type=="checkbox" || oTarget.type=="password"))
//		oEvent.keyCode = 9;
//}

function waitShow(){
   /*
   $("html").css("cursor", "wait");
   
   var div = $(document.createElement("div"))
   
   div.attr({
        id: "wait"
    }).css({
       border: "1px solid #000000"
        , padding: "4px"
        , margin: "2px"
        , fontSize: "12px"
        , position: "fixed"
        , bottom: "0px"
        , width: "110px"
        , backgroundColor: "#FFD700"
    }).appendTo("body");

    $(document.createElement("img"))
    .attr({
        src: web_root + "/images/waiting16x16.gif"
        , align: "absmiddle"
    }).appendTo(div);

    div.append("&nbsp;Please wait...");
	*/
}

function waitHide(){
    $("html").css("cursor", "default");
    $("#wait").remove();
}

function onSuccess(data) {
    if (typeof(data) == "string") {
        document.write(data);
        return null;
    } else {
        wait_hide();

        var json = eval(data);
        var msg = json["RET_MSG"];

        if (msg != "") {
            alert(msg);
        }

        return eval(data);
    }
}

function validate(){
    var ret = true;
    // require
    $("input[required], select[required], textarea[required]").each(function(){
        if ($(this).attr("required") == true || $(this).attr("required") == "true"){
            if ($(this).val() == ""){
                var description = Trim($(this).attr("description"));                
                if (description != "" && description != null){
                    jAlert('warning', 'Please input ' + description + ' !!', 'Helpdesk System : Messages');
                    //alert("Please input " + description + " !!");
                } else {
                    jAlert('warning', 'Please input Required Field !!', 'Helpdesk System : Messages');
                   // alert("Please input Required Field !!");
                }

                if ($(this).attr("type") != "hidden"){
                    $(this).addClass("input_required");
                    $(this).focus();
                }

                ret = false;
                return ret;
            } else {
                if ($(this).hasClass("input_required")){
                    $(this).removeClass("input_required");
                }
            }
        }
    });

    if (ret){
        $("input[rule]").each(function(){
            var rule = $(this).attr("rule");
            var description = Trim($(this).attr("description"));
            var val = $(this).val();

            if (rule == "email"){
                var arr = val.split(",");

                for (var i = 0; i < arr.length; i++){
                    val = Trim(arr[i]);
                    if (!isEmail(val)){
                        if (description != "" && description != null){
                            jAlert('warning', 'Invalid ' + description + ' !!', 'Helpdesk System : Messages');
                            //alert("Invalid " + description + " !!");
                        } else {
                            jAlert('warning', 'Invalid Email !!', 'Helpdesk System : Messages');
                            //alert("Invalid Email !!");
                        }

                        $(this).focus();
                        ret = false;
                        return ret;
                    }
                }
            }
        });
    }

    return ret;
}

function init_wating(){
    $("html").bind("ajaxStart", function(){
        waitShow();
    }).bind("ajaxStop", function(){
        waitHide();
    });
}

function init_datatable(){
    $("table.data-table tr:odd").addClass("odd");
    $("table.data-table tr:even").addClass("even");
}

function init_ui(){
    // filter
    $("textarea[maxlength]").keypress(function(){
        var max = parseInt($(this).attr("maxlength"));
        if($(this).val().length +1 > max){
            return false;
        }
    });

    $("input[rule]").each(function(){
        var mask = null;
        var options = null;
        var rule = $(this).attr("rule");
        var maxlength = parseInt($(this).attr("maxlength"));
        var value = $(this).val();

        switch (rule) {
            case "number":
                mask = "999,999,999,999";
                 if (maxlength > 0){
                    mask = "";
                    for (var i = 0; i < maxlength; i++){
                        if (i != 0 && i%3 == 0){
                            mask += ",";
                        }

                        mask += "9";
                    }
                }
                
                options = {autoTab: false, mask: mask, type: "reverse"};
                break;

            case "decimal":
                var digit = parseInt($(this).attr("digit"));

                mask = "999,999,999,999";                
                if (maxlength > 0){
                    mask = "";
                    for (var i = 0; i < maxlength - digit; i++){
                        if (i != 0 && i%3 == 0){
                            mask += ",";
                        }

                        mask += "9";
                    }                    
                }

                if (digit > 0) {
                    mask = "".padLeft(digit, "9") + "." + mask;
                }
                
                options = {autoTab: false, mask: mask, type: "reverse"};
                break;

            case "english":
                options = {autoTab: false, mask: "a"};
                break;

            case "date":
                options = {autoTab: false, mask: "31/12/9999"};
                break;

            case "time":
                options = {autoTab: false, mask: "9999:59:59"};
                break;

            default:
                break;
        }

        if (options != null){
            $(this).setMask(options).val(value);
        }
    });

    // calendar
    if ($("span[type=calendar]").length > 0){
        // css
        $("head").append("<link>").children(":last")
        .attr({
            media: "all"
            , rel: "stylesheet"
            , type: "text/css"
            , href: web_root + "/include/js/jscalendar/css/calendar-blue.css"
        });

        // script
        $(document.createElement("script"))
        .attr({
            type: "text/javascript"
            , src: web_root + "/include/js/jscalendar/js/calendar.js"
        }).appendTo("head");

        $(document.createElement("script"))
        .attr({
            type: "text/javascript"
            , src: web_root + "/include/js/jscalendar/js/calendar-setup.js"
        }).appendTo("head");

        $(document.createElement("script"))
        .attr({
            type: "text/javascript"
            , src: web_root + "/include/js/jscalendar/js/lang/calendar-en.js"
        }).appendTo("head");

        // setup
        $("span[type=calendar]").each(function(){
            var name = $(this).attr("name");
            var id = $(this).attr("id");
            var value = $(this).attr("value");
            var img = $(this).attr("img");
            var required = ($(this).attr("required") == "true") ? true : false;
            var description = $(this).attr("description");

            var span = $(document.createElement("span"));

            $(document.createElement("input"))
            .attr({type: "text", name: name, id: id, maxlength: 10, rule: "date", required: required, description: description, readonly: true})
            .css({width: "80px", margin: "0px 2px 0px 0px", textAlign: "center"})
            .addClass("disabled")
            .val(value)
            .appendTo(span);

            $(document.createElement("img"))
            .attr({src: img, id: "btn_" + id, alt: "Date", align: "absmiddle"})
            .css({cursor: "pointer", border: "1px solid gray", verticalAlign: (($.browser.msie) ? "-10%" : ($.browser.webkit) ? "-20%" : "-25%")})
            .addClass("disabled")
            .val(value)
            .appendTo(span)
            .hover(function(){
                $(this).css("background", "gray");
            }, function(){
                $(this).css("background", "");
            });

            $(this).replaceWith(span);

            Calendar.setup({
                inputField : id
                , ifFormat : "%d-%m-%Y"
                , button : "btn_" + id
                , align : "Br"
                , singleClick : true
            })
        });
    }

    // ui
    $("span.ui-state-default").hover(
        function() {$(this).addClass("ui-state-hover");},
        function() {$(this).removeClass("ui-state-hover");}
    );


    // action name
    if ($("form #action_name").length == 0){
        $(document.createElement("input"))
        .attr({type: "hidden", name: "action_name", id: "action_name"})
        .appendTo("form");
    }
}

function back_inc(){
//    alert('back_inc function');
    top.location.href= '../../home.php';
}

$(document).ready(function(){
    page_init();

    // wating
    init_wating();

    // data table
   init_datatable();

    // UI
    init_ui();
});
