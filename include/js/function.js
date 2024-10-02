window.status = 'Sale Report System';
var retv = null;

function dialog_return_value(value){
    if (window.opener != null && window.opener != undefined){
        window.opener.retv = value;
        window.returnValue = value;
    } else {
        retv = value;
        window.returnValue = value;
    }
    
    window.close();
}

function open_dialog(uri, width, height, arg){
    var useragent = navigator.userAgent;

    if (useragent.indexOf("MSIE") != -1){
        var arra = useragent.split("MSIE");
         var version = parseInt(arra[1]);

        if (version == 6){
            height += 40;
        }
    } else if (useragent.indexOf("Safari") != -1){
        height += 10;
        
    } else if (useragent.indexOf("Firefox") != -1){
        height += 10;
    }
    
    var options = "dialogWidth:" + width + "px; dialogHeight:" + height + "px; center:yes; status:no; scroll:no;";
    var ret = window.showModalDialog(uri, arg, options);

    if (ret == null || ret == undefined){
        ret = retv;
    }
    
    return ret;
}

function loadmenu(tops,bottom){
    parent.tbar.location.href = tops;
//    parent.bmenu.location.href = bottom;
}


document.onmousemove = mouseMove;
function mouseMove(ev){
    ev = ev || window.event;
    var mousePos = mouseCoords(ev);
}

function mouseCoords(ev){
    try {
        if(ev.pageX || ev.pageY){
            return {x:ev.pageX, y:ev.pageY};
	}
        
	return {
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
		y:ev.clientY + document.body.scrollTop  - document.body.clientTop
	};
    } catch (exception) {

    }
}


function hidestatus(){  
    window.status = '' 
    return true 
}

if (document.layers)  
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT | Event.MOUSEDOWN)  
document.onmouseover = hidestatus  
document.onmouseout = hidestatus 
document.onmousedown = hidestatus 


//begin of Disable right click script
//var message="Sorry, right-click has been disabled";
///////////////////////////////////
function clickIE() {
    if (document.all){
        return false;
    }

    return true
}

function clickNS(e){
    if(document.layers || (document.getElementById && !document.all)) {
        if (e.which==2 || e.which==3){
            return false;
        }
    }
    return true;
}

if (document.layers){
    document.captureEvents(Event.MOUSEDOWN);
    document.onmousedown=clickNS;
} else {
    document.onmouseup=clickNS;
    document.oncontextmenu = clickIE;
}

document.oncontextmenu=new Function("return false")
//end of Disable right click script


