function filterInput(filterType,evt,allowDecimal,decNum) {
    var keyCode, Char, inputField, filter = '';
    var alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var num   = '0123456789';
    var num_ex   = '-.0123456789';
    var dateSymbol = '/';
    if(window.event)
    {
        keyCode = window.event.keyCode;
        evt = window.event;
    }else if (evt)keyCode = evt.which;
    else return true;
    if(filterType == 0) filter = alpha;
    else if(filterType == 1) filter = num;
    else if(filterType == 2) filter = alpha + num;
    else if(filterType == 3) filter = num + dateSymbol;
    else if(filterType == 4) filter = num + dateSymbol + '-';
    else if(filterType == 5) filter = num_ex;
    if(filter == '')return true;
    inputField = evt.srcElement ? evt.srcElement : evt.target || evt.currentTarget;
    if((keyCode==null) || (keyCode==0) || (keyCode==8) || (keyCode==9) || (keyCode==13) || (keyCode==27) )return true;
    Char = String.fromCharCode(keyCode);
    if((filter.indexOf(Char) > -1))
    {
        if (decNum && inputField.value.indexOf('.') > -1)
        {
            var str = inputField.value;
            var afterDec = str.substring(inputField.value.indexOf('.'));
            var currDecNum =afterDec.length;
            if (currDecNum <= decNum)
            {
                return true;
            }else
            {
                return false;
            }
        }else
        {
            return true;
        }
        return true;
    }else if(filterType == 1 && allowDecimal && (Char == '.') && inputField.value.indexOf('.') == -1)
        return true;
    else return false;
}

function numberOnly(event){
    return filterInput(1, event);
}

function numberOnlyEx(event){
    return filterInput(5, event);
}

function decimalOnly(event){
    return filterInput(1, event, true);
}

function decimalLimitedOnly(event, len){
    return filterInput(1, event, true, len);
}

function letterEnOnly(event){
    return filterInput(0, event);
}

function letterEnNumberOnly(event){
    return filterInput(2, event);
}

function dateOnly(event){
    return filterInput(3, event);
}

function agreementOnly(event){
    return filterInput(4,event);
}

function filter(){
    $("textarea[maxlength]").keypress(function(){
        var max = parseInt($(this).attr("maxlength"));
        if($(this).val().length +1 > max){
            return false;
        }
    });

    $("input[rule]").focus(function(){
        var rule = $(this).attr("rule");
        switch (rule) {
            case "number":
                $(this).val(deFormatInteger($(this).val()));
                
                break;

            case "decimal":
                $(this).val(deFormatDecimal($(this).val()));
                break;

            default:
                break;
        }

        if (this.setSelectionRange){     /* DOM */
            setTimeout("this.setSelectionRange(this.value.length, this.value.length)",2);
        } else if (this.createTextRange){     /* IE */
            var r = this.createTextRange();
            r.moveStart("character", this.value.length);
            r.select();
        } 
    });
    
    $("input[rule]").blur(function(){
        var rule = $(this).attr("rule");
        switch (rule) {
            case "number":
                $(this).val(formatNumber($(this).val()));
                break;

            case "decimal":
                $(this).val(formatNumber($(this).val(), parseInt($(this).attr("digit"))));
                break;

            default:
                break;
        }
    });

    $("input[rule]").keypress(function(event){
        var rule = $(this).attr("rule");
        switch (rule) {
            case "number":
                return numberOnly(event);
                break;

            case "decimal":
                var digit = parseInt($(this).attr("digit"));
                if (digit > 0)
                    return decimalLimitedOnly(event, digit);
                else
                    return decimalOnly(event);
                break;

            case "english":
                return letterEnOnly(event);
                break;

            case "date":
                return dateOnly(event);
                break;

            default:
                break;
        }
    });
}

//$(document).ready(function(){
//    filter();
//});
