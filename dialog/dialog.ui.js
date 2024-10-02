$(document).ready(function(){
    $("span[lookuptype]").each(function(){
        var lookuptype = $(this).attr("lookuptype");
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        var title = $(this).attr("title");
        var width = $(this).css("width");
        var dialogWidth = $(this).attr("dialogWidth");
        var dialogHeight = $(this).attr("dialogHeight");
        var allowNone = $(this).attr("allowNone");
        var required = Trim($(this).attr("required"));
        var description = Trim($(this).attr("description"));
        var value = $(this).attr("value");
        var text = $(this).attr("text");
        var param = Trim($(this).attr("param"));
        param = ((param != "") ? "?" : "") + param;
        
        // dialog
        var dlg =
            $(document.createElement("div"))
            .attr("id", "dialog_" + id)
            .appendTo("body")
            .dialog({
                width: dialogWidth
                , height: dialogHeight
                , autoOpen: false
                , modal: true
                , resizable: false
                , title : title
            });

        // lookup
        var span = 
            $(document.createElement("span"))
            .appendTo($(this));
            
        var hdId =
            $(document.createElement("input"))
            .attr({type: "hidden", name: name + "_id", id: id + "_id", required: required, description: description})
            .val(value)
            .appendTo(span);

        var hdAllowNone =
            $(document.createElement("input"))
            .attr({type: "hidden", name: lookuptype + "_allow_none", id: lookuptype + "_allow_none"})
            .val(allowNone)
            .appendTo(span);
            
        var inputText =
            $(document.createElement("input"))
            .attr({type: "text", name: name + "_name", id: id + "_name", readonly:true})
            .css({width: width, margin: "0px 3px 0px 0px"})
            .addClass("disabled")
            .val(text)
            .appendTo(span);

        var btn =
            $(document.createElement("img"))
            .attr({id: "btn_" + id, src: web_root + "/images/find.png", align: "absmiddle"})
            .css({cursor: "pointer", verticalAlign: (($.browser.msie) ? "-10%" : ($.browser.webkit) ? "-20%" : "-25%")})
            .appendTo(span)
            .click(function(){            
                /*
                var button = {};
                if (allowNone == "true" || allowNone == true){
                    button["None"] = function() {if (dialog_onclosed()) $(this).dialog("close");};
                }

                button["Ok"] = function() {if (dialog_onclosed()) $(this).dialog("close");};
                button["Cancel"] = function() {if (dialog_onclosed()) $(this).dialog("close");};

                $( "#"+dialog_id ).dialog( "option", "buttons", button);
                 */

                var ifr = dlg.find("iframe");
                if (ifr.length == 0){
                    ifr = $(document.createElement("iframe"))
                            .attr({name: "ifr_" + name, id: "ifr_" + id, frameborder: 0, width: "100%", height: "100%", scrolling: "no"})
                            .appendTo(dlg);
                }

                var src = web_root +"/dialog/" + lookuptype + ".php" + dialog_onInitParam(lookuptype, param);
                if (ifr.attr("src") != src){
                    ifr.attr("src", web_root + "/blank.php");
                    ifr.attr("src", src);
                }

                dlg.dialog("open");
                return false;
            });
    });
});

function dialog_onClosed(lookuptype){
    $("#dialog_" + lookuptype).dialog("close");
}

function dialog_onSelected(lookuptype, obj){

}

function dialog_onInitParam(lookuptype, param){
    return param;
}
