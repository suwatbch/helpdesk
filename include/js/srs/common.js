String.prototype.padLeft = function(n, pad){
    t = "";
    if( n > this.length){
        for(i=0;i < n-this.length;i++){
            t+=pad;
        }
    }
    return t+this;
}

String.prototype.padRight = function(n, pad){
    t = this;
    if(n>this.length){
        for(i=0;i < n-this.length;i++){
                t+=pad;
        }
    }
    return t;
}

function strToInt(s){
    return parseInt(s);
}

function strToDecimal(s){
    return parseFloat(s);
}

function LTrim(str){
    if(str==null){
        return null;
    }
    for(var i=0;str.charAt(i)==" ";i++);
    return str.substring(i,str.length);
}

function RTrim(str){
    if(str==null){
        return null;
    }
    for(var i=str.length-1;str.charAt(i)==" ";i--);
    return str.substring(0,i+1);
}

function Trim(str){
    return LTrim(RTrim(str));
}

function isNumeric(val){
    return(strToDecimal(val,10)==(val*1));
}

function columnCheck(chk){
    var form = chk.form;
    for (var i = 0; i < form.elements.length; i++) {
        if (form.elements[i].type=="checkbox") {
            form.elements[i].checked=chk.checked;
        }
    }
}

function chkToggleChild(chk){
    var form=chk.form;
    var name=chk.name;
    var n=name.length;
    for (var i = 0; i < form.elements.length; i++) {
        if ((form.elements[i].type=="checkbox")&&(form.elements[i].name.substr(0,n)==name)) {
            form.elements[i].checked=chk.checked;
        }
    }
}


function isDataChange(){
    var form = window.document.forms['frmData'];
    var bChange = false;
    for (var i = 0; i < form.elements.length; i++) {
        var name = form.elements[i].name;
        if ((name)&&(name.substr(0,6)=="input_")) {
            bChange = isChanged(form.elements[i]);
            if (bChange) break;
        }
    }
    return bChange;
}

 function isDate(dateStr)
{
    var datePat = /^(\d{2})(-)(\d{2})(-)(\d{4})$/;
    var matchArray = dateStr.match(datePat); // is the format ok?

    if (matchArray == null)
    {
        alert("Please input date in dd-mm-yyyy format.");
        return false;
    }

    // p@rse date into variables
    var day = matchArray[1];
    var month = matchArray[3];
    var year = matchArray[5];

    if (month < 1 || month > 12)
    {
        // check month range
        alert("Month must be between 1 and 12.");
        return false;
    }

    if (day < 1 || day > 31)
    {
        alert("Day must be between 1 and 31.");
        return false;
    }

    if ((month==4 || month==6 || month==9 || month==11) && day==31)
    {
        alert("Month "+month+" doesn`t have 31 days!")
        return false;
    }

    if (month == 2)
    {
        // check for february 29th
        var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
        if (day > 29 || (day==29 && !isleap))
        {
            alert("February " + year + " doesn`t have " + day + " days!");
            return false;
        }
    }
    return true; // date is valid
}

function isEmail(email){
    var regexp = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
    return regexp.test(email)
}

/*
function formatNumber(input, fraction) {
	data = deFormatDecimal("" + input);
	if (!isNumeric(data)) {
		return input;
	}
	var  n =  data.indexOf(".");
	if (n < 0) n = data.length;

	var tmp = "";
	for(var i = 0;  i < n; ++i) {
		if ( i !=0 && (i %3) == 0 && i ) {
			var c = data.charAt( n - i -1);
			if ( c != '-')	
				tmp = c + "," + tmp;
			else 
				tmp = c + tmp;
		} else {
			tmp = data.charAt( n - i -1)  + tmp;
		}
	}
	if (data.length != n && fraction > 0) {
		if (data.length - n + 1 >= fraction) {
			tmp = tmp + data.substr(n , fraction);
		} else {
			tmp = tmp + data.substr(n , data.length - n +1);
		}		
	}
	return tmp;
}*/

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function formatNumber(input, fraction) {
    var data = deFormatDecimal("" + input);
    if (!isNumeric(data)) {
        return "";
    }
    var num = strToDecimal(data);
    var tmp = num.toFixed(fraction);
    return addCommas(tmp);
}

function formatDecimal(data) {
    /*data = deFormatDecimal("" + data);
	var  n =  data.indexOf(".");
	if (n < 0) n = data.length;

	var tmp = "";
	for(var i = 0;  i < n; ++i) {
		if ( i !=0 && (i %3) == 0 && i ) {
			var c = data.charAt( n - i -1);
			if ( c != '-')	tmp = c + "," + tmp;
		} else {
			tmp = data.charAt( n - i -1)  + tmp;
		}
	}
	if (data.length != n)  {
		tmp = tmp +   data.substr(n , data.length - n +1);
	}
	return tmp;*/
    return formatNumber(data, 2);
}

function formatDecimalEx(data, n) {
    /*data = deFormatDecimal("" + data);
	var  n =  data.indexOf(".");
	if (n < 0) n = data.length;

	var tmp = "";
	for(var i = 0;  i < n; ++i) {
		if ( i !=0 && (i %3) == 0 && i ) {
			var c = data.charAt( n - i -1);
			if ( c != '-')	tmp = c + "," + tmp;
		} else {
			tmp = data.charAt( n - i -1)  + tmp;
		}
	}
	if (data.length != n)  {
		tmp = tmp +   data.substr(n , data.length - n +1);
	}
	return tmp;*/
    return formatNumber(data, n);
}

function deFormatDecimal(data){
    data = Trim(data);
    if (data) {
        var n = data.length;
        var tmp = "";
        for (var i = 0; i < n; ++i ) {
            if (data.charAt(i) != ',' ) tmp += data.charAt(i);
        }
        return tmp;
    } else {
        return "";
    }
}

function formatDecimalObj(obj) {
    obj.value = formatDecimal(obj.value);
}

function formatDecimalExObj(obj, n) {
    obj.value = formatDecimalEx(obj.value, n);
}


function deFormatDecimalObj(obj) {
    obj.value = deFormatDecimal(obj.value);
}

function formatInteger(data) {
    /*data = deFormatInteger("" + data);
	var n = data.length;
	var tmp = "";
	for(var i = 0;  i < n; ++i) {
		if ( i !=0 && (i %3) == 0 ) {
			var c = data.charAt( n - i -1);
			if ( c != '-')	tmp = c + "," + tmp;
		} else {
			tmp = data.charAt( n - i -1)  + tmp;
		}
	}
	return tmp;*/
    return formatNumber(data, 0);

}

function deFormatInteger(data){
    /*data = Trim(data);
	if (data) {
		var n = data.length;
		var tmp = "";
		for (var i = 0; i < n; ++i ) {
			if (data.charAt(i) != ',' ) tmp += data.charAt(i);
		}
		return tmp;
	} else {
		return "";
	}*/
    return deFormatDecimal(data);
}

function formatIntegerObj(obj) {
    obj.value = formatInteger(obj.value);
}

function deFormatIntegerObj(obj) {
    obj.value = deFormatInteger(obj.value);
}



function insertDefaultInteger(srcObj, dscObj) {
    if (!srcObj || !dscObj) return;
    var value = deFormatInteger(dscObj.value);
    if (isNumeric(value)) {
        value = strToInt(value);
    } else {
        value = 0;
    }

    srcObj.value = formatInteger(srcObj.value)
    if (value == 0) {
        dscObj.value = srcObj.value;
    }
}


function insertDefaultDecimal(srcObj, dscObj) {
    if (!srcObj || !dscObj) return;
    var value = deFormatDecimal(dscObj.value);
    if (isNumeric(value)) {
        value = strToDecimal(value);
    } else {
        value = 0;
    }

    srcObj.value = formatDecimal(srcObj.value)
    if (value == 0) {
        dscObj.value = srcObj.value;
    }
}

function insertDefaultDecimalEx(srcObj, dscObjName, n) {
    if (!srcObj || !dscObjName) return;
    var form = window.document.forms['frmData'];
    var dscObj = form.elements[dscObjName];
    var value = deFormatDecimal(dscObj.value);
    if (isNumeric(value)) {
        value = strToDecimal(value);
    } else {
        value = 0;
    }

    srcObj.value = formatDecimalEx(srcObj.value, n)
    if (value == 0) {
        dscObj.value = srcObj.value;
    }
}

var xml_special_to_escaped_one_map = {
    "&" : "&amp;"
    , "\"" : "&quot;"
    , "<" : "&lt;"
    , ">" : "&gt;"
};

var escaped_one_to_xml_special_map = {
    "&amp;" : "&"
    , "&quot;" : "\""
    , "&lt;" : "<"
    , "&gt;" : ">"
};

function encodeXml(string) {
    return string.replace(/([\&"<>])/g, function(str, item) {
        return xml_special_to_escaped_one_map[item];
    });
}

function decodeXml(string) {
    return string.replace(/(&quot;|&lt;|&gt;|&amp;)/g, function(str, item) {
        return escaped_one_to_xml_special_map[item];
    });
}

function basename(path) {
    return path.replace(/\\/g,'/').replace( /.*\//, '' );
}

function dirname(path) {
    return path.replace(/\\/g,'/').replace(/\/[^\/]*$/, '');;
}