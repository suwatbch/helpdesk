(function() {
    /**
 * SWFObject v1.4.2: Flash Player detection and embed - http://blog.deconcept.com/swfobject/
 *
 * SWFObject is (c) 2006 Geoff Stearns and is released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * **SWFObject is the SWF embed script formerly known as FlashObject. The name was changed for
 *   legal reasons.
 */
    if(typeof deconcept=="undefined"){
        var deconcept=new Object();
    }
    if(typeof deconcept.util=="undefined"){
        deconcept.util=new Object();
    }
    if(typeof deconcept.SWFObjectUtil=="undefined"){
        deconcept.SWFObjectUtil=new Object();
    }
    deconcept.SWFObject=function(_1,id,w,h,_5,c,_7,_8,_9,_a,_b){
        if(!document.getElementById){
            return;
        }
        this.DETECT_KEY=_b?_b:"detectflash";
        this.skipDetect=deconcept.util.getRequestParameter(this.DETECT_KEY);
        this.params=new Object();
        this.variables=new Object();
        this.attributes=new Array();
        if(_1){
            this.setAttribute("swf",_1);
        }
        if(id){
            this.setAttribute("id",id);
        }
        if(w){
            this.setAttribute("width",w);
        }
        if(h){
            this.setAttribute("height",h);
        }
        if(_5){
            this.setAttribute("version",new deconcept.PlayerVersion(_5.toString().split(".")));
        }
        this.installedVer=deconcept.SWFObjectUtil.getPlayerVersion();
        if(c){
            this.addParam("bgcolor",c);
        }
        var q=_8?_8:"high";
        this.addParam("quality",q);
        this.setAttribute("useExpressInstall",_7);
        this.setAttribute("doExpressInstall",false);
        var _d=(_9)?_9:window.location;
        this.setAttribute("xiRedirectUrl",_d);
        this.setAttribute("redirectUrl","");
        if(_a){
            this.setAttribute("redirectUrl",_a);
        }
    };
deconcept.SWFObject.prototype={
    setAttribute:function(_e,_f){
        this.attributes[_e]=_f;
    },
    getAttribute:function(_10){
        return this.attributes[_10];
    },
    addParam:function(_11,_12){
        this.params[_11]=_12;
    },
    getParams:function(){
        return this.params;
    },
    addVariable:function(_13,_14){
        this.variables[_13]=_14;
    },
    getVariable:function(_15){
        return this.variables[_15];
    },
    getVariables:function(){
        return this.variables;
    },
    getVariablePairs:function(){
        var _16=new Array();
        var key;
        var _18=this.getVariables();
        for(key in _18){
            _16.push(key+"="+_18[key]);
        }
        return _16;
    },
    getSWFHTML:function(){
        var _19="";
        if(navigator.plugins&&navigator.mimeTypes&&navigator.mimeTypes.length){
            if(this.getAttribute("doExpressInstall")){
                this.addVariable("MMplayerType","PlugIn");
            }
            _19="<embed type=\"application/x-shockwave-flash\" src=\""+this.getAttribute("swf")+"\" width=\""+this.getAttribute("width")+"\" height=\""+this.getAttribute("height")+"\"";
            _19+=" id=\""+this.getAttribute("id")+"\" name=\""+this.getAttribute("id")+"\" ";
            var _1a=this.getParams();
            for(var key in _1a){
                _19+=key+"=\""+_1a[key]+"\" ";
            }
            var _1c=this.getVariablePairs().join("&");
            if(_1c.length>0){
                _19+="flashvars=\""+_1c+"\"";
            }
            _19+="/>";
        }else{
            if(this.getAttribute("doExpressInstall")){
                this.addVariable("MMplayerType","ActiveX");
            }
            _19="<object id=\""+this.getAttribute("id")+"\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\""+this.getAttribute("width")+"\" height=\""+this.getAttribute("height")+"\">";
            _19+="<param name=\"movie\" value=\""+this.getAttribute("swf")+"\" />";
            var _1d=this.getParams();
            for(var key in _1d){
                _19+="<param name=\""+key+"\" value=\""+_1d[key]+"\" />";
            }
            var _1f=this.getVariablePairs().join("&");
            if(_1f.length>0){
                _19+="<param name=\"flashvars\" value=\""+_1f+"\" />";
            }
            _19+="</object>";
        }
        return _19;
    },
    write:function(_20){
        if(this.getAttribute("useExpressInstall")){
            var _21=new deconcept.PlayerVersion([6,0,65]);
            if(this.installedVer.versionIsValid(_21)&&!this.installedVer.versionIsValid(this.getAttribute("version"))){
                this.setAttribute("doExpressInstall",true);
                this.addVariable("MMredirectURL",escape(this.getAttribute("xiRedirectUrl")));
                document.title=document.title.slice(0,47)+" - Flash Player Installation";
                this.addVariable("MMdoctitle",document.title);
            }
        }
    if(this.skipDetect||this.getAttribute("doExpressInstall")||this.installedVer.versionIsValid(this.getAttribute("version"))){
        var n=(typeof _20=="string")?document.getElementById(_20):_20;
        n.innerHTML=this.getSWFHTML();
        return true;
    }else{
        if(this.getAttribute("redirectUrl")!=""){
            document.location.replace(this.getAttribute("redirectUrl"));
        }
    }
return false;
}
};
deconcept.SWFObjectUtil.getPlayerVersion=function(){
    var _23=new deconcept.PlayerVersion([0,0,0]);
    if(navigator.plugins&&navigator.mimeTypes.length){
        var x=navigator.plugins["Shockwave Flash"];
        if(x&&x.description){
            _23=new deconcept.PlayerVersion(x.description.replace(/([a-zA-Z]|\s)+/,"").replace(/(\s+r|\s+b[0-9]+)/,".").split("."));
        }
    }else{
        try{
            var axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
        }
        catch(e){
            try{
                var axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
                _23=new deconcept.PlayerVersion([6,0,21]);
                axo.AllowScriptAccess="always";
            }
            catch(e){
                if(_23.major==6){
                    return _23;
                }
            }
            try{
            axo=new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
        }
        catch(e){}
    }
if(axo!=null){
    _23=new deconcept.PlayerVersion(axo.GetVariable("$version").split(" ")[1].split(","));
}
}
return _23;
};
deconcept.PlayerVersion=function(_27){
    this.major=_27[0]!=null?parseInt(_27[0],10):0;
    this.minor=_27[1]!=null?parseInt(_27[1],10):0;
    this.rev=_27[2]!=null?parseInt(_27[2],10):0;
};
deconcept.PlayerVersion.prototype.versionIsValid=function(fv){
    if(this.major<fv.major){
        return false;
    }
    if(this.major>fv.major){
        return true;
    }
    if(this.minor<fv.minor){
        return false;
    }
    if(this.minor>fv.minor){
        return true;
    }
    if(this.rev<fv.rev){
        return false;
    }
    return true;
};
deconcept.util={
    getRequestParameter:function(_29){
        var q=document.location.search||document.location.hash;
        if(q){
            var _2b=q.substring(1).split("&");
            for(var i=0;i<_2b.length;i++){
                if(_2b[i].substring(0,_2b[i].indexOf("="))==_29){
                    return _2b[i].substring((_2b[i].indexOf("=")+1));
                }
            }
            }
return "";
}
};
deconcept.SWFObjectUtil.cleanupSWFs=function(){
    var _2d=document.getElementsByTagName("OBJECT");
    for(var i=0;i<_2d.length;i++){
        _2d[i].style.display="none";
        for(var x in _2d[i]){
            if(typeof _2d[i][x]=="function"){
                _2d[i][x]=null;
            }
        }
        }
    };
if(typeof window.onunload=="function"){
    if (!deconcept.SWFObjectUtil.cleanupInstalled){
        deconcept.SWFObjectUtil.cleanupInstalled = true;
        var oldunload=window.onunload;
        window.onunload=function(){
            deconcept.SWFObjectUtil.cleanupSWFs();
            oldunload();
        };

}
}else{
    window.onunload=deconcept.SWFObjectUtil.cleanupSWFs;
    deconcept.SWFObjectUtil.cleanupInstalled = true;
}
if(Array.prototype.push==null){
    Array.prototype.push=function(_30){
        this[this.length]=_30;
        return this.length;
    };

}

var getQueryParamValue=deconcept.util.getRequestParameter;
var FlashObject=deconcept.SWFObject; // for legacy support
var SWFObject=deconcept.SWFObject;

(function (){
    if(window["__gvizguard__"])return;
    function e(a){
        throw a;
    }
    var g=void 0,i=null,aa=clearInterval,ba=encodeURIComponent,k=google_exportSymbol,ca=window,da=Number,ea=Object,fa=Infinity,l=Error,ga=parseInt,ha=parseFloat,ja=String,ka=isFinite,n=document,la=decodeURIComponent,ma=isNaN,o=google_exportProperty,na=RegExp,oa=Array,p=Math;
    function pa(a,b){
        return a.width=b
        }
        function ra(a,b){
        return a.innerHTML=b
        }
        function ta(a,b){
        return a.currentTarget=b
        }
        function ua(a,b){
        return a.left=b
        }
        function va(a,b){
        return a.screenX=b
        }
    function wa(a,b){
        return a.screenY=b
        }
        function za(a,b){
        return a.format=b
        }
        function Aa(a,b){
        return a.keyCode=b
        }
        function Ba(a,b){
        return a.handleEvent=b
        }
        function Ca(a,b){
        return a.type=b
        }
        function Da(a,b){
        return a.setContent=b
        }
        function Ea(a,b){
        return a.getValue=b
        }
        function Fa(a,b){
        return a.clientX=b
        }
        function Ga(a,b){
        return a.clientY=b
        }
        function Ha(a,b){
        return a.visibility=b
        }
        function Ia(a,b){
        return a.setState=b
        }
        function Ja(a,b){
        return a.length=b
        }
        function Ka(a,b){
        return a.setValue=b
        }
    function La(a,b){
        return a.className=b
        }
        function Ma(a,b){
        return a.next=b
        }
        function Na(a,b){
        return a.clone=b
        }
        function Oa(a,b){
        return a.target=b
        }
        function Pa(a,b){
        return a.contains=b
        }
        function Qa(a,b){
        return a.display=b
        }
        function Ra(a,b){
        return a.height=b
        }
    var Sa="appendChild",r="push",Ta="isCollapsed",Ua="trigger",Va="getBoundingClientRect",Wa="getParent",Xa="open",Ya="DataTable",Za="test",$a="relatedTarget",ab="clearTimeout",s="width",bb="collapse",cb="round",db="slice",t="replace",eb="nodeType",fb="events",gb="floor",hb="getElementById",ib="getOptions",jb="RequestParameters",kb="concat",lb="charAt",mb="createTextNode",nb="getNumberOfColumns",ob="getDate",pb="value",qb="getDataTable",rb="preventDefault",sb="insertBefore",tb="targetTouches",v="indexOf",
    ub="setEnd",w="dispatchEvent",vb="getProperty",wb="capture",xb="getColumnProperties",yb="nodeName",zb="currentTarget",x="left",Ab="setColumnProperties",Bb="screenX",Cb="screenY",Db="match",Eb="format",Fb="getBoxObjectFor",Gb="send",Hb="charCode",Ib="getObject",Jb="isError",Kb="focus",Lb="createElement",Mb="getColumnLabel",Nb="toDataTable",Ob="scrollHeight",Pb="keyCode",y="getColumnType",Qb="firstChild",Rb="getSortedRows",Sb="forEach",Tb="clientLeft",Ub="getTableRowIndex",Vb="setAttribute",Wb="clientTop",
    Xb="handleEvent",Yb="getRowProperties",Zb="getTableProperties",$b="setRefreshInterval",z="type",ac="childNodes",bc="defaultView",cc="setCell",ec="source",fc="setContent",gc="name",hc="getHours",A="getValue",ic="getTime",jc="addRows",kc="setActive",lc="getElementsByTagName",mc="clientX",nc="clientY",oc="documentElement",pc="substr",qc="setState",rc="scrollTop",sc="toString",tc="altKey",uc="getMonth",vc="setStart",wc="getView",xc="getNumberOfRows",B="length",yc="propertyIsEnumerable",zc="getProperties",
    Ac="addError",C="prototype",Bc="toJSON",Cc="setValue",Dc="clientWidth",Ec="abort",Fc="setTimeout",Gc="document",Hc="getSeconds",Ic="ctrlKey",Jc="split",Kc="getColumnProperty",Lc="constructor",Mc="stopPropagation",Nc="getColumnPattern",Oc="location",Pc="setFormattedValue",Qc="visualization",Rc="disabled",Sc="message",Tc="hasOwnProperty",Uc="style",Vc="setQuery",Wc="body",Xc="removeChild",Yc="clone",Zc="getDataSourceUrl",$c="target",ad="lastChild",bd="getOption",F="call",cd="isEnabled",dd="removeAll",
    ed="start",fd="lastIndexOf",gd="draw",hd="setProperty",id="getFullYear",jd="DataView",kd="getRefreshInterval",ld="getColumnRange",md="getState",nd="clientHeight",od="scrollLeft",pd="addRange",qd="charCodeAt",rd="getPackages",sd="bottom",td="href",ud="substring",vd="getQuery",wd="apply",xd="shiftKey",yd="tagName",zd="addColumn",Ad="element",Bd="getFormattedValue",Cd="errors",Dd="parentNode",Ed="getMinutes",Fd="label",Gd="offsetTop",H="height",Hd="splice",I="join",Id="setColumns",Jd="toLowerCase",Kd=
    "right",Ld="setOption",Md="getTimezoneOffset",J="",Nd="\n",Od="\n<\/script>",Pd=" ",Qd=" [",Rd=" is duplicate in sortColumns.",Sd=' name="',Td=' type="',Ud='"',Vd='" />',Wd='" src="http://www.google.com/ig/ifr?url=',Xd='">\n',Yd="#",Zd="#$1$1$2$2$3$3",$d="#fff",ae="$1",be="%",ce="%22",de="%27",ee="&",fe="&amp;",ge="&gt;",he="&lt;",ie="&quot;",je="&requireauth=1&",ke="&up_",le="&up__table_query_url=",me="'",ne="''",oe="').send(\n     function(response) {\n      new ",pe="']});\n\n   function drawVisualization() {\n    new google.visualization.Query('",
    qe="(",re='(\n       document.getElementById(\'visualization\')).\n        draw(response.getDataTable(), null);\n      });\n   }\n\n   google.setOnLoadCallback(drawVisualization);\n  <\/script>\n </head>\n <body>\n  <div id="visualization" style="width: 500px; height: 500px;"></div>\n </body>\n</html>',se="(\\d*)(\\D*)",te=")",ue="*",ve="+",we=",",xe=", ",ye="-",ze="-active",Ae="-bg",Be="-buttons",Ce="-caption",De="-checkbox",Ee="-checked",Fe="-content",Ge="-default",He="-disabled",Ie="-dropdown",
    Je="-focused",Ke="-highlight",Le="-horizontal",Me="-hover",Ne="-inner-box",Oe="-open",Pe="-outer-box",Qe="-rtl",Re="-selected",Te="-title",Ue="-title-close",Ve="-title-draggable",We="-title-text",Xe="-vertical",Ye=".",Ze="..",$e="./",af='.png" height="12" width="',bf="/",cf="/.",df="//",ef="/chart.html",ff="/chart.js",gf="/static/modules/gviz/",hf="/tq",jf="/util/bar_",kf="/util/util.css",lf="0",mf="0.5",nf="0.6",of="00",pf="000",qf="0000000000000000",rf="1",sf="1.0",tf="1.9",uf="5.7",vf="500",wf=
    "525",xf="528",yf="7",zf="9",Af=":",Bf=";",Cf=";sig:",Df=";type:",Ef="<",Ff="</span>\u00a0",Gf='<html>\n <head>\n  <title>Google Visualization API</title>\n  <script type="text/javascript" src="http://www.google.com/jsapi"><\/script>\n  <script type="text/javascript">\n   google.load(\'visualization\', \'1\', {packages: [\'',Hf='<iframe style="',If='<img style="padding: 0" src="',Jf='<script type="text/javascript" src="',Kf='<span style="padding: 0; float: left; white-space: nowrap;">',Lf="=",Mf=
    ">",Nf="?",Of="@",Pf="APPLET",Qf="AREA",Rf="Add to iGoogle",Sf="AreaChart",Tf="BASE",Uf="BODY",Vf="BR",Wf="BUTTON",Xf="BarChart",Yf="COL",Zf="CSS1Compat",$f="Chart options",ag="Column index ",bg="ColumnChart",cg="Component already rendered",dg="Container is not defined",eg="Content-Type",fg="Copy-Paste this code to an HTML page",gg="Date(",hg="E",ig="End",jg="EndToEnd",kg="Etc/GMT",lg="Export data as CSV",mg="Export data as HTML",ng="FRAME",og="G",pg="GET",qg="GMT",rg="Google Visualization",sg="Google_Visualization",
    tg="H",ug="HR",vg="HTML",wg="IFRAME",xg="IMG",yg="INPUT",zg="ISINDEX",Ag="ImageChart",Bg="ImageRadarChart",Cg="Invalid DataView column type.",Dg="Invalid formatType parameter ",Eg="Invalid listener argument",Fg="JavaScript",Gg="Javascript code",Hg="K",Ig="L",Jg="LINK",Kg="LineChart",Lg="M",Mg="META",Ng="MSXML2.XMLHTTP",Og="MSXML2.XMLHTTP.3.0",Pg="MSXML2.XMLHTTP.6.0",Qg="Microsoft.XMLHTTP",Rg="MozOpacity",Sg="NOFRAMES",Tg="NOSCRIPT",Ug="Name",Vg="Not a valid 2D array.",Wg="OBJECT",Xg="PARAM",Yg="POST",
    Zg="Publish to web page",$g="Q",ah="Request timed out",bh="S",ch="SCRIPT",dh="SELECT",eh="STYLE",fh="ScatterChart",gh="Start",hh="StartToEnd",ih="StartToStart",jh="TEXTAREA",kh="TR",lh="Timed out after ",mh="To",nh="Type",oh="UTC",ph="Unable to set parent component",qh="Uneven number of arguments",rh="Unspported type",sh="W",th="Z",uh="[",vh="[object Array]",wh="[object Function]",xh="[object Window]",yh="\\",zh="\\\\",Ah="\\c",Bh="\\s",Ch="\\u",Dh="]",Eh="_",Fh="_bar_format_old_value",Gh="_swf",
    Hh="_table_query_refresh_interval",Ih="_table_query_url",Jh="a",Kh="abort",Lh="absolute",Mh="action",Nh="activate",Oh="activedescendant",Ph="addGradientRange",Qh="afterhide",Rh="aftershow",Sh="allowFullscreen",Th="allowScriptAccess",Uh="alpha(opacity=",Vh="altKey",Wh="always",Xh="application/x-www-form-urlencoded;charset=utf-8",Yh="aria-",Zh="array",$h="auto",ai="b",bi="background-color:",ci="beforedrag",di="block",ei="blur",fi="body",gi="boolean",hi="border:0;vertical-align:bottom;",ii="borderLeftWidth",
    ji="borderRightWidth",ki="borderTopWidth",li="br",mi="button",ni="c",oi="call",pi="callee",qi="character",ri="chart",si="check",ti="checked",ui="cht",vi="class",wi="className",xi="click",yi="close",zi="color:",Ai="column",Bi="columnFilters[",Ci="complete",Di="control",Ei="corechart",Fi="csv",Gi="ctrlKey",Hi="d",Ii="date",Ji="datetime",Ki="dblclick",Li="deactivate",Mi="desc",Ni="detailed_message",Oi="dialog",Pi="dialogselect",Qi="direction",Ri="disable",Si="disabled",Ti="display",Ui="display: none; padding-top: 2px",
    Vi="div",Wi="drag",Xi="dragstart",Yi="draw",Zi="enable",$i="end",aj="enter",bj="error",cj="expanded",dj="false",ej="filter",fj="fixed",gj="focus",hj="focusin",ij="focusout",jj="for",kj="format",lj="full",mj="function",nj="g",oj="gadgets.io.makeRequest",pj="gadgets.io.makeRequest failed",qj="getColumnIndex",rj="getColumnLabel",sj="getColumnPattern",tj="getColumnProperties",uj="getColumnProperty",vj="getColumnRange",wj="getContainerId",xj="getDataSourceUrl",yj="getDataTable",zj="getDistinctValues",
    Aj="getFilteredRows",Bj="getFormattedValue",Cj="getNumberOfColumns",Dj="getNumberOfRows",Ej="getRefreshInterval",Fj="getRowProperties",Gj="getRowProperty",Hj="getTableProperties",Ij="getTableProperty",Jj="goog-button",Kj="goog-container",Lj="goog-control",Mj="goog-custom-button",Nj="goog-inline-block ",Oj="goog-menu",Pj="goog-menu-button",Qj="goog-menuheader",Rj="goog-menuitem",Sj="goog-menuitem-accel",Tj="goog-menuseparator",Uj="goog-option",Vj="goog-option-selected",Wj="google-visualization-formatters-arrow-dr",
    Xj="google-visualization-formatters-arrow-empty",Yj="google-visualization-formatters-arrow-ug",Zj="google-visualization-toolbar-big-dialog",$j="google-visualization-toolbar-export-data",ak="google-visualization-toolbar-export-igoogle",bk="google-visualization-toolbar-html-code",ck="google-visualization-toolbar-html-code-explanation",dk="google-visualization-toolbar-small-dialog",ek="google-visualization-toolbar-triangle",fk="google.loader.GoogleApisBase",gk="google.visualization.",hk="google.visualization.Player.",
    ik="google.visualization.Version",jk="h",kk="hAxis",lk="hasLabelsColumn",mk="haspopup",nk="head",ok="hex",pk="hidden",qk="hide",rk="highlight",sk="horizontal",tk="html",uk="htmlcode",vk="http%",xk="http://ajax.googleapis.com/ajax",yk="http://dummy.com",zk="http://www.google.com/ig/adde?moduleurl=",Ak="https%",Bk="iframe",Ck="igoogle",Dk="img",Ek="inline",Fk="innerText",Gk="input",Hk="invalid_query",Ik='javascript:""',Jk="jscode",Kk="json",Lk="k",Mk="key",Nk="keydown",Ok="keypress",Pk="keyup",Qk="labelledby",
    Rk="leave",Sk="left",Tk="link",Uk="long",Vk="losecapture",Wk="m",Xk="makeRequest",Yk="make_request_failed",Zk="maxValue",$k="medium",al="menu",bl="menuitem",cl="message",dl="metaKey",el="minValue",fl="modal-dialog",gl="modifier",hl="mousedown",il="mousemove",jl="mouseout",kl="mouseover",ll="mouseup",ml="ms, aborting",nl="name",ol="named",pl="native code",ql="new ",rl="nodeType",sl="none",tl="not_modified",ul="null",L="number",vl="object",wl="on",xl="opacity",yl="open",zl="options",Al="out:csv;",Bl=
    "out:html;",Cl="outerHTML",Dl="overflow",El="package",Fl="padding: 2px",Gl="pause",Hl="platformModifierKey",Il="play",Jl="position",Kl="position:fixed;width:0;height:0;left:0;top:0;",Ll="pre",Ml="pressed",Nl="pub",Ol="px",Pl="r",Ql="range",Rl="ready",Sl="readystatechange",Tl="reason",Ul="refresh",Vl="relative",Wl="reqId:",Xl="resize",Yl="rgb",Zl="right",$l="role",am="rs",bm="rtl",cm="s",dm="script",em="scroll",fm="seek",gm="seekRelease",hm="select",im="selected",jm="separator",km="setContainerId",
    lm="setDataSourceUrl",mm="setOptions",nm="setQuery",om="setRefreshInterval",pm="shiftKey",qm="short",rm="show",sm="sortColumns",tm="sortColumns[",um="span",vm="splice",wm="start",xm="statechange",ym="static",M="string",zm="style",Am="stylesheet",Bm="success",Cm="tabIndex",Dm="tabindex",Em="text/css",Fm="text/javascript",Gm="textContent",Hm="tick",Im="timeofday",Jm="timeout",Km="toJSON",Lm="touchcancel",Mm="touchend",Nm="touchmove",Om="touchstart",Pm="tqrt",Qm="tqx",Rm="true",Sm="type",Tm="uncheck",
    Um="unhighlight",Vm="unselect",Wm="unselectable",Xm="user_not_authenticated",Ym="v",Zm="vAxis",$m="value",an="var _et_ = 1;",bn="vertical",cn="visible",dn="visualization",en="w",fn="warning",gn="width: 700px; height: 500px;",hn="window.event",jn="withCredentials",kn="xhr",ln="xhrpost",mn="y",nn="z",on="zx",pn="{",qn="}",rn="\u00a0",sn="\u00d7",tn="\u25bc",N,un=un||{},O=this,vn=i;
    function wn(a,b){
        for(var c=a[Jc](Ye),d=b||O,f;f=c.shift();)if(xn(d[f]))d=d[f];else return i;return d
        }
        function yn(){}
    function zn(a){
        a.qa=function(){
            return a.Lk||(a.Lk=new a)
            }
        }
    function An(a){
    var b=typeof a;
    if(b==vl)if(a){
        if(a instanceof oa)return Zh;
        else if(a instanceof ea)return b;
        var c=ea[C][sc][F](a);
        if(c==xh)return vl;
        if(c==vh||typeof a[B]==L&&typeof a[Hd]!="undefined"&&typeof a[yc]!="undefined"&&!a[yc](vm))return Zh;
        if(c==wh||typeof a[F]!="undefined"&&typeof a[yc]!="undefined"&&!a[yc](oi))return mj
            }else return ul;
    else if(b==mj&&typeof a[F]=="undefined")return vl;
    return b
    }
    function Bn(a){
    return a!==g
    }
function xn(a){
    return a!=i
    }
    function P(a){
    return An(a)==Zh
    }
    function Cn(a){
    var b=An(a);
    return b==Zh||b==vl&&typeof a[B]==L
    }
    function Dn(a){
    return En(a)&&typeof a[id]==mj
    }
    function Q(a){
    return typeof a==M
    }
    function Fn(a){
    return typeof a==L
    }
    function Gn(a){
    return An(a)==mj
    }
    function En(a){
    a=An(a);
    return a==vl||a==Zh||a==mj
    }
    function Hn(a){
    return a[In]||(a[In]=++Jn)
    }
    var In="closure_uid_"+p[gb](p.random()*2147483648)[sc](36),Jn=0;
    function Kn(a){
        var b=An(a);
        if(b==vl||b==Zh){
            if(a[Yc])return a[Yc]();
            var b=b==Zh?[]:{},c;
            for(c in a)b[c]=Kn(a[c]);return b
            }
            return a
        }
        function Ln(a){
        return a[F][wd](a.bind,arguments)
        }
        function Mn(a,b){
        var c=b||O;
        if(arguments[B]>2){
            var d=oa[C][db][F](arguments,2);
            return function(){
                var b=oa[C][db][F](arguments);
                oa[C].unshift[wd](b,d);
                return a[wd](c,b)
                }
            }else return function(){
        return a[wd](c,arguments)
        }
    }
function Nn(){
    Nn=Function[C].bind&&Function[C].bind[sc]()[v](pl)!=-1?Ln:Mn;
    return Nn[wd](i,arguments)
    }
    function On(a){
    var b=oa[C][db][F](arguments,1);
    return function(){
        var c=oa[C][db][F](arguments);
        c.unshift[wd](c,b);
        return a[wd](this,c)
        }
    }
var Pn=Date.now||function(){
    return+new Date
    };
function Qn(a){
    if(O.execScript)O.execScript(a,Fg);
    else if(O.eval)if(vn==i&&(O.eval(an),typeof O._et_!="undefined"?(delete O._et_,vn=!0):vn=!1),vn)O.eval(a);
        else{
        var b=O[Gc],c=b[Lb](dm);
        Ca(c,Fm);
        c.defer=!1;
        c[Sa](b[mb](a));
        b[Wc][Sa](c);
        b[Wc][Xc](c)
        }else e(l("goog.globalEval not available"))
        }
        function R(a,b){
    function c(){}
    c.prototype=b[C];
    a.b=b[C];
    a.prototype=new c;
    a[C].constructor=a
    };

function Rn(a){
    var b;
    if(n[lc](nk)[B]==0){
        b=n[lc](tk)[0];
        var c=n[lc](fi)[0],d=n[Lb](nk);
        b[sb](d,c)
        }
        b=n[lc](nk)[0];
    c=n[Lb](dm);
    Ca(c,Fm);
    c.src=a;
    b[Sa](c)
    }
    function Sn(a){
    return function(b){
        google[Qc][Cd][dd](a);
        var c=b[Jb]();
        c&&google[Qc][Cd].addErrorFromQueryResponse(a,b);
        return!c
        }
    };

function Tn(a,b){
    this.x=Bn(a)?a:0;
    this.y=Bn(b)?b:0
    }
    Na(Tn[C],function(){
    return new Tn(this.x,this.y)
    });
function Un(a,b){
    return new Tn(a.x-b.x,a.y-b.y)
    };

function Vn(a,b){
    pa(this,a);
    Ra(this,b)
    }
    Na(Vn[C],function(){
    return new Vn(this[s],this[H])
    });
Vn[C].ceil=function(){
    pa(this,p.ceil(this[s]));
    Ra(this,p.ceil(this[H]));
    return this
    };

Vn[C].floor=function(){
    pa(this,p[gb](this[s]));
    Ra(this,p[gb](this[H]));
    return this
    };

Vn[C].round=function(){
    pa(this,p[cb](this[s]));
    Ra(this,p[cb](this[H]));
    return this
    };

function Wn(a){
    return a[t](/[\t\r\n ]+/g,Pd)[t](/^[\t\r\n ]+|[\t\r\n ]+$/g,J)
    }
    function Xn(a){
    return a[t](/^[\s\xa0]+|[\s\xa0]+$/g,J)
    }
    var Yn=/^[a-zA-Z0-9\-_.!~*'()]*$/;
function Zn(a){
    a=ja(a);
    if(!Yn[Za](a))return ba(a);
    return a
    }
    function $n(a,b){
    if(b)return a[t](ao,fe)[t](bo,he)[t](co,ge)[t](eo,ie);
    else{
        if(!fo[Za](a))return a;
        a[v](ee)!=-1&&(a=a[t](ao,fe));
        a[v](Ef)!=-1&&(a=a[t](bo,he));
        a[v](Mf)!=-1&&(a=a[t](co,ge));
        a[v](Ud)!=-1&&(a=a[t](eo,ie));
        return a
        }
    }
var ao=/&/g,bo=/</g,co=/>/g,eo=/\"/g,fo=/[&<>\"]/;
function go(a,b,c){
    a=Bn(c)?a.toFixed(c):ja(a);
    c=a[v](Ye);
    c==-1&&(c=a[B]);
    return oa(p.max(0,b-c)+1)[I](lf)+a
    }
    function ho(a,b){
    for(var c=0,d=Xn(ja(a))[Jc](Ye),f=Xn(ja(b))[Jc](Ye),h=p.max(d[B],f[B]),j=0;c==0&&j<h;j++){
        var m=d[j]||J,q=f[j]||J,u=na(se,nj),D=na(se,nj);
        do{
            var E=u.exec(m)||[J,J,J],K=D.exec(q)||[J,J,J];
            if(E[0][B]==0&&K[0][B]==0)break;
            c=io(E[1][B]==0?0:ga(E[1],10),K[1][B]==0?0:ga(K[1],10))||io(E[2][B]==0,K[2][B]==0)||io(E[2],K[2])
            }while(c==0)
    }
    return c
    }
function io(a,b){
    if(a<b)return-1;
    else if(a>b)return 1;
    return 0
    };

var jo=na("^(?:([^:/?#.]+):)?(?://(?:([^/?#]*)@)?([\\w\\d\\-\\u0100-\\uffff.%]*)(?::([0-9]+))?)?([^?#]+)?(?:\\?([^#]*))?(?:#(.*))?$");
function ko(a){
    return a&&la(a)
    }
    var lo=/#|$/;
var mo=/\/spreadsheet/,no=/\/(ccc|tq|pub)$/,oo=/^\/a\/(\w+.)*\w+/,po=/^(\/a\/(\w+.)*\w+)?/,qo=/^spreadsheets?[0-9]?\.google\.com$/,ro=/^docs\.google\.com*$/,so=/(trix|spreadsheets|docs|webdrive)-[a-z]+\.corp\.google\.com/,to=/^(\w*\.){1,2}corp\.google\.com$/;
function uo(a){
    var b=ko(a[Db](jo)[3]||i),c=qo[Za](b),d=so[Za](b),f=to[Za](b),b=ro[Za](b),h=ko(a[Db](jo)[5]||i),j=na(po[ec]+no[ec]),h=(a=na(po[ec]+mo[ec]+no[ec])[Za](h))||j[Za](h);
    return b&&a||(d||f||c)&&h
    };

var vo=oa[C],wo=vo[v]?function(a,b,c){
    return vo[v][F](a,b,c)
    }:function(a,b,c){
    c=c==i?0:c<0?p.max(0,a[B]+c):c;
    if(Q(a)){
        if(!Q(b)||b[B]!=1)return-1;
        return a[v](b,c)
        }
        for(;c<a[B];c++)if(c in a&&a[c]===b)return c;return-1
    },xo=vo[Sb]?function(a,b,c){
    vo[Sb][F](a,b,c)
    }:function(a,b,c){
    for(var d=a[B],f=Q(a)?a[Jc](J):a,h=0;h<d;h++)h in f&&b[F](c,f[h],h,a)
        },yo=vo.filter?function(a,b,c){
    return vo.filter[F](a,b,c)
    }:function(a,b,c){
    for(var d=a[B],f=[],h=0,j=Q(a)?a[Jc](J):a,m=0;m<d;m++)if(m in j){
        var q=j[m];
        b[F](c,
            q,m,a)&&(f[h++]=q)
        }
        return f
    },zo=vo.map?function(a,b,c){
    return vo.map[F](a,b,c)
    }:function(a,b,c){
    for(var d=a[B],f=oa(d),h=Q(a)?a[Jc](J):a,j=0;j<d;j++)j in h&&(f[j]=b[F](c,h[j],j,a));
    return f
    },Ao=vo.every?function(a,b,c){
    return vo.every[F](a,b,c)
    }:function(a,b,c){
    for(var d=a[B],f=Q(a)?a[Jc](J):a,h=0;h<d;h++)if(h in f&&!b[F](c,f[h],h,a))return!1;return!0
    };

function Bo(a,b){
    return wo(a,b)>=0
    }
    function Co(a,b){
    var c=wo(a,b),d;
    (d=c>=0)&&vo[Hd][F](a,c,1);
    return d
    }
function Do(){
    return vo[kb][wd](vo,arguments)
    }
    function Eo(a){
    if(P(a))return Do(a);
    else{
        for(var b=[],c=0,d=a[B];c<d;c++)b[c]=a[c];
        return b
        }
    }
function Fo(a){
    for(var b=1;b<arguments[B];b++){
        var c=arguments[b],d;
        if(P(c)||(d=Cn(c))&&c[Tc](pi))a[r][wd](a,c);
        else if(d)for(var f=a[B],h=c[B],j=0;j<h;j++)a[f+j]=c[j];else a[r](c)
            }
        }
    function Go(a){
    return vo[Hd][wd](a,Ho(arguments,1))
    }
    function Ho(a,b,c){
    return arguments[B]<=2?vo[db][F](a,b):vo[db][F](a,b,c)
    }
    function Io(a,b){
    vo.sort[F](a,b||Jo)
    }
function Ko(a,b){
    for(var c=0;c<a[B];c++)a[c]={
        index:c,
        value:a[c]
        };

    var d=b||Jo;
    Io(a,function(a,b){
        return d(a[pb],b[pb])||a.index-b.index
        });
    for(c=0;c<a[B];c++)a[c]=a[c][pb]
        }
        function Jo(a,b){
    return a>b?1:a<b?-1:0
    };

function Lo(a,b,c){
    for(var d in a)b[F](c,a[d],d,a)
        }
        function Mo(a){
    var b=[],c=0,d;
    for(d in a)b[c++]=a[d];return b
    }
    function No(a){
    var b=[],c=0,d;
    for(d in a)b[c++]=d;return b
    }
    function Oo(a,b){
    for(var c in a)if(a[c]==b)return!0;return!1
    }
    function Po(a,b){
    var c;
    (c=b in a)&&delete a[b];
    return c
    }
    var Qo=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"];
function Ro(a){
    for(var b,c,d=1;d<arguments[B];d++){
        c=arguments[d];
        for(b in c)a[b]=c[b];for(var f=0;f<Qo[B];f++)b=Qo[f],ea[C][Tc][F](c,b)&&(a[b]=c[b])
            }
        }
    function So(){
    var a=arguments[B];
    if(a==1&&P(arguments[0]))return So[wd](i,arguments[0]);
    a%2&&e(l(qh));
    for(var b={},c=0;c<a;c+=2)b[arguments[c]]=arguments[c+1];
    return b
    };

var To,Uo,Vo,Wo,Xo,Yo;
function Zo(){
    return O.navigator?O.navigator.userAgent:i
    }
    function $o(){
    return O.navigator
    }
    Xo=Wo=Vo=Uo=To=!1;
var ap;
if(ap=Zo()){
    var bp=$o();
    To=ap[v]("Opera")==0;
    Uo=!To&&ap[v]("MSIE")!=-1;
    Wo=(Vo=!To&&ap[v]("WebKit")!=-1)&&ap[v]("Mobile")!=-1;
    Xo=!To&&!Vo&&bp.product=="Gecko"
    }
    var cp=To,S=Uo,dp=Xo,ep=Vo,fp=Wo,gp=$o(),hp=gp&&gp.platform||J;
Yo=hp[v]("Mac")!=-1;
hp[v]("Win");
hp[v]("Linux");
var ip=!!$o()&&($o().appVersion||J)[v]("X11")!=-1,jp;
    a:{
        var kp=J,lp;
        if(cp&&O.opera)var mp=O.opera.version,kp=typeof mp==mj?mp():mp;
        else if(dp?lp=/rv\:([^\);]+)(\)|;)/:S?lp=/MSIE\s+([^\);]+)(\)|;)/:ep&&(lp=/WebKit\/(\S+)/),lp)var np=lp.exec(Zo()),kp=np?np[1]:J;
        if(S){
            var op,pp=O[Gc];
            op=pp?pp.documentMode:g;
            if(op>ha(kp)){
                jp=ja(op);
                break a
            }
        }
        jp=kp
    }
    var qp=jp,rp={};

function sp(a){
    return rp[a]||(rp[a]=ho(qp,a)>=0)
    }
    var tp={};

function up(a){
    return tp[a]||(tp[a]=S&&n.documentMode&&n.documentMode>=a)
    };

var vp,wp=!S||sp(zf);
!dp&&!S||S&&sp(zf)||dp&&sp("1.9.1");
var xp=S&&!sp(zf);
function yp(a){
    return(a=a.className)&&typeof a[Jc]==mj?a[Jc](/\s+/):[]
    }
    function zp(a){
    var b=yp(a),c=Ho(arguments,1),d;
    d=b;
    for(var f=0,h=0;h<c[B];h++)Bo(d,c[h])||(d[r](c[h]),f++);
    d=f==c[B];
    La(a,b[I](Pd));
    return d
    }
    function Ap(a){
    var b=yp(a),c=Ho(arguments,1),d;
    d=b;
    for(var f=0,h=0;h<d[B];h++)Bo(c,d[h])&&(Go(d,h--,1),f++);
    d=f==c[B];
    La(a,b[I](Pd));
    return d
    };

function Bp(a){
    return a?new Cp(Dp(a)):vp||(vp=new Cp)
    }
    function Ep(a){
    return Q(a)?n[hb](a):a
    }
    function Fp(a,b){
    Lo(b,function(b,d){
        d==zm?a[Uc].cssText=b:d==vi?La(a,b):d==jj?a.htmlFor=b:d in Gp?a[Vb](Gp[d],b):a[d]=b
        })
    }
    var Gp={
    cellpadding:"cellPadding",
    cellspacing:"cellSpacing",
    colspan:"colSpan",
    rowspan:"rowSpan",
    valign:"vAlign",
    height:"height",
    width:"width",
    usemap:"useMap",
    frameborder:"frameBorder",
    maxlength:"maxLength",
    type:Sm
};
function Hp(a){
    var b=a[Gc];
    if(ep&&!sp(vf)&&!fp){
        typeof a.innerHeight=="undefined"&&(a=ca);
        var b=a.innerHeight,c=a[Gc][oc][Ob];
        a==a.top&&c<b&&(b-=15);
        return new Vn(a.innerWidth,b)
        }
        a=Ip(b)?b[oc]:b[Wc];
    return new Vn(a[Dc],a[nd])
    }
    function Jp(a){
    return a?a.parentWindow||a[bc]:ca
    }
    function Kp(){
    return Lp(n,arguments)
    }
function Lp(a,b){
    var c=b[0],d=b[1];
    if(!wp&&d&&(d[gc]||d[z])){
        c=[Ef,c];
        d[gc]&&c[r](Sd,$n(d[gc]),Ud);
        if(d[z]){
            c[r](Td,$n(d[z]),Ud);
            var f={};

            Ro(f,d);
            d=f;
            delete d[z]
        }
        c[r](Mf);
        c=c[I](J)
        }
        c=a[Lb](c);
    d&&(Q(d)?La(c,d):P(d)?zp[wd](i,[c][kb](d)):Fp(c,d));
    b[B]>2&&Mp(a,c,b,2);
    return c
    }
    function Mp(a,b,c,d){
    function f(c){
        c&&b[Sa](Q(c)?a[mb](c):c)
        }
        for(;d<c[B];d++){
        var h=c[d];
        Cn(h)&&!Np(h)?xo(Op(h)?Eo(h):h,f):f(h)
        }
    }
    function Ip(a){
    return a.compatMode==Zf
    }
    function Pp(a){
    for(var b;b=a[Qb];)a[Xc](b)
        }
function Qp(a){
    return a&&a[Dd]?a[Dd][Xc](a):i
    }
    function Np(a){
    return En(a)&&a[eb]>0
    }
    function Rp(a,b){
    if(a.contains&&b[eb]==1)return a==b||a.contains(b);
    if(typeof a.compareDocumentPosition!="undefined")return a==b||Boolean(a.compareDocumentPosition(b)&16);
    for(;b&&a!=b;)b=b[Dd];
    return b==a
    }
    function Dp(a){
    return a[eb]==9?a:a.ownerDocument||a[Gc]
    }
    function Sp(a,b){
    if(Gm in a)a.textContent=b;
    else if(a[Qb]&&a[Qb][eb]==3){
        for(;a[ad]!=a[Qb];)a[Xc](a[ad]);
        a[Qb].data=b
        }else Pp(a),a[Sa](Dp(a)[mb](b))
        }
function Tp(a){
    if(Cl in a)return a.outerHTML;
    else{
        var b=Dp(a)[Lb](Vi);
        b[Sa](a.cloneNode(!0));
        return b.innerHTML
        }
    }
var Up={
    SCRIPT:1,
    STYLE:1,
    HEAD:1,
    IFRAME:1,
    OBJECT:1
},Vp={
    IMG:Pd,
    BR:Nd
};

function Wp(a){
    var b=a.getAttributeNode(Dm);
    if(b&&b.specified)return a=a.tabIndex,Fn(a)&&a>=0;
    return!1
    }
    function Xp(a){
    var b=[];
    Yp(a,b,!1);
    return b[I](J)
    }
function Yp(a,b,c){
    if(!(a[yb]in Up))if(a[eb]==3)c?b[r](ja(a.nodeValue)[t](/(\r\n|\r|\n)/g,J)):b[r](a.nodeValue);
        else if(a[yb]in Vp)b[r](Vp[a[yb]]);else for(a=a[Qb];a;)Yp(a,b,c),a=a.nextSibling
        }
        function Op(a){
    if(a&&typeof a[B]==L)if(En(a))return typeof a.item==mj||typeof a.item==M;
        else if(Gn(a))return typeof a.item==mj;
    return!1
    }
    function Cp(a){
    this.m=a||O[Gc]||n
    }
    N=Cp[C];
N.A=Bp;
N.a=function(a){
    return Q(a)?this.m[hb](a):a
    };

N.setProperties=Fp;
N.hk=function(a){
    a=a||this.Mg();
    return Hp(a||ca)
    };
N.d=function(){
    return Lp(this.m,arguments)
    };

N.createElement=function(a){
    return this.m[Lb](a)
    };

N.createTextNode=function(a){
    return this.m[mb](a)
    };

N.Lg=function(){
    return Ip(this.m)
    };

N.Mg=function(){
    return this.m.parentWindow||this.m[bc]
    };

N.gk=function(){
    return!ep&&Ip(this.m)?this.m[oc]:this.m[Wc]
    };

N.Yb=function(){
    var a=this.m,b=!ep&&Ip(a)?a[oc]:a[Wc],a=a.parentWindow||a[bc];
    return new Tn(a.pageXOffset||b[od],a.pageYOffset||b[rc])
    };

N.appendChild=function(a,b){
    a[Sa](b)
    };

N.He=Pp;
N.Xk=function(a,b){
    b[Dd]&&b[Dd][sb](a,b)
    };

N.removeNode=Qp;
Pa(N,Rp);
var Zp="StopIteration"in O?O.StopIteration:l("StopIteration");
function $p(){}
Ma($p[C],function(){
    e(Zp)
    });
$p[C].Ph=function(){
    return this
    };

function aq(a){
    if(typeof a.Nb==mj)return a.Nb();
    if(Q(a))return a[Jc](J);
    if(Cn(a)){
        for(var b=[],c=a[B],d=0;d<c;d++)b[r](a[d]);
        return b
        }
        return Mo(a)
    }
    function bq(a,b,c){
    if(typeof a[Sb]==mj)a[Sb](b,c);
    else if(Cn(a)||Q(a))xo(a,b,c);
    else{
        var d;
        if(typeof a.Mb==mj)d=a.Mb();
        else if(typeof a.Nb!=mj)if(Cn(a)||Q(a)){
            d=[];
            for(var f=a[B],h=0;h<f;h++)d[r](h)
                }else d=No(a);else d=g;
        for(var f=aq(a),h=f[B],j=0;j<h;j++)b[F](c,f[j],d&&d[j],a)
            }
        };

function cq(a){
    this.va={};

    this.o=[];
    var b=arguments[B];
    if(b>1){
        b%2&&e(l(qh));
        for(var c=0;c<b;c+=2)this.set(arguments[c],arguments[c+1])
            }else a&&this.Vj(a)
        }
        N=cq[C];
N.w=0;
N.Db=0;
N.Nb=function(){
    this.Bd();
    for(var a=[],b=0;b<this.o[B];b++)a[r](this.va[this.o[b]]);
    return a
    };

N.Mb=function(){
    this.Bd();
    return this.o[kb]()
    };

N.eb=function(a){
    return dq(this.va,a)
    };

N.clear=function(){
    this.va={};

    Ja(this.o,0);
    this.Db=this.w=0
    };
N.remove=function(a){
    if(dq(this.va,a))return delete this.va[a],this.w--,this.Db++,this.o[B]>2*this.w&&this.Bd(),!0;
    return!1
    };

N.Bd=function(){
    if(this.w!=this.o[B]){
        for(var a=0,b=0;a<this.o[B];){
            var c=this.o[a];
            dq(this.va,c)&&(this.o[b++]=c);
            a++
        }
        Ja(this.o,b)
        }
        if(this.w!=this.o[B]){
        for(var d={},b=a=0;a<this.o[B];)c=this.o[a],dq(d,c)||(this.o[b++]=c,d[c]=1),a++;
        Ja(this.o,b)
        }
    };

N.get=function(a,b){
    if(dq(this.va,a))return this.va[a];
    return b
    };
N.set=function(a,b){
    dq(this.va,a)||(this.w++,this.o[r](a),this.Db++);
    this.va[a]=b
    };

N.Vj=function(a){
    var b;
    a instanceof cq?(b=a.Mb(),a=a.Nb()):(b=No(a),a=Mo(a));
    for(var c=0;c<b[B];c++)this.set(b[c],a[c])
        };

Na(N,function(){
    return new cq(this)
    });
N.Ph=function(a){
    this.Bd();
    var b=0,c=this.o,d=this.va,f=this.Db,h=this,j=new $p;
    Ma(j,function(){
        for(;;){
            f!=h.Db&&e(l("The map has changed since the iterator was created"));
            b>=c[B]&&e(Zp);
            var j=c[b++];
            return a?j:d[j]
            }
        });
return j
};
function dq(a,b){
    return ea[C][Tc][F](a,b)
    };

function eq(){}
eq[C].Ze=!1;
eq[C].D=function(){
    if(!this.Ze)this.Ze=!0,this.j()
        };

eq[C].j=function(){};

var fq=new Function(Jh,"return a");
var gq,hq=!S||sp(zf),iq=S&&!sp("8");
function jq(a,b){
    Ca(this,a);
    Oa(this,b);
    ta(this,this[$c])
    }
    R(jq,eq);
N=jq[C];
N.j=function(){
    delete this[z];
    delete this[$c];
    delete this[zb]
};

N.Lb=!1;
N.Mc=!0;
N.stopPropagation=function(){
    this.Lb=!0
    };

N.preventDefault=function(){
    this.Mc=!1
    };

function kq(a){
    a[rb]()
    };

function lq(a,b){
    a&&this.Ib(a,b)
    }
    R(lq,jq);
var mq=[1,4,2];
N=lq[C];
Oa(N,i);
N.relatedTarget=i;
N.offsetX=0;
N.offsetY=0;
Fa(N,0);
Ga(N,0);
va(N,0);
wa(N,0);
N.button=0;
Aa(N,0);
N.charCode=0;
N.ctrlKey=!1;
N.altKey=!1;
N.shiftKey=!1;
N.metaKey=!1;
N.kk=!1;
N.Z=i;
N.Ib=function(a,b){
    var c=Ca(this,a[z]);
    jq[F](this,c);
    Oa(this,a[$c]||a.srcElement);
    ta(this,b);
    var d=a[$a];
    if(d){
        if(dp){
            var f;
                a:{
                try{
                    fq(d[yb]);
                    f=!0;
                    break a
                }catch(h){}
                f=!1
                }
                f||(d=i)
            }
        }else if(c==kl)d=a.fromElement;
else if(c==jl)d=a.toElement;
this.relatedTarget=d;
this.offsetX=a.offsetX!==g?a.offsetX:a.layerX;
this.offsetY=a.offsetY!==g?a.offsetY:a.layerY;
Fa(this,a[mc]!==g?a[mc]:a.pageX);
Ga(this,a[nc]!==g?a[nc]:a.pageY);
va(this,a[Bb]||0);
wa(this,a[Cb]||0);
this.button=a.button;
Aa(this,a[Pb]||0);
this.charCode=
a[Hb]||(c==Ok?a[Pb]:0);
this.ctrlKey=a[Ic];
this.altKey=a[tc];
this.shiftKey=a[xd];
this.metaKey=a.metaKey;
this.kk=Yo?a.metaKey:a[Ic];
this.state=a.state;
this.Z=a;
delete this.Mc;
delete this.Lb
};

N.Ll=function(a){
    return hq?this.Z.button==a:this[z]==xi?a==0:!!(this.Z.button&mq[a])
    };

N.pe=function(){
    return this.Ll(0)&&!(ep&&Yo&&this[Ic])
    };

N.stopPropagation=function(){
    lq.b[Mc][F](this);
    this.Z[Mc]?this.Z[Mc]():this.Z.cancelBubble=!0
    };
N.preventDefault=function(){
    lq.b[rb][F](this);
    var a=this.Z;
    if(a[rb])a[rb]();
    else if(a.returnValue=!1,iq)try{
        (a[Ic]||a[Pb]>=112&&a[Pb]<=123)&&Aa(a,-1)
        }catch(b){}
    };

N.pj=function(){
    return this.Z
    };

N.j=function(){
    lq.b.j[F](this);
    this.Z=i;
    Oa(this,i);
    ta(this,i);
    this.relatedTarget=i
    };

function nq(a,b){
    this.kh=b;
    this.Fb=[];
    this.Jk(a)
    }
    R(nq,eq);
N=nq[C];
N.Bf=i;
N.jh=i;
N.Nc=function(a){
    this.Bf=a
    };

N.getObject=function(){
    if(this.Fb[B])return this.Fb.pop();
    return this.th()
    };

N.jc=function(a){
    this.Fb[B]<this.kh?this.Fb[r](a):this.rg(a)
    };

N.Jk=function(a){
    a>this.kh&&e(l("[goog.structs.SimplePool] Initial cannot be greater than max"));
    for(var b=0;b<a;b++)this.Fb[r](this.th())
        };

N.th=function(){
    return this.Bf?this.Bf():{}
};
N.rg=function(a){
    if(this.jh)this.jh(a);
    else if(En(a))if(Gn(a.D))a.D();else for(var b in a)delete a[b]
        };

N.j=function(){
    nq.b.j[F](this);
    for(var a=this.Fb;a[B];)this.rg(a.pop());
    delete this.Fb
    };

var oq,pq=(oq="ScriptEngine"in O&&O.ScriptEngine()=="JScript")?O.ScriptEngineMajorVersion()+Ye+O.ScriptEngineMinorVersion()+Ye+O.ScriptEngineBuildVersion():lf;
function qq(){}
var rq=0;
N=qq[C];
N.key=0;
N.ic=!1;
N.bh=!1;
N.Ib=function(a,b,c,d,f,h){
    Gn(a)?this.ah=!0:a&&a[Xb]&&Gn(a[Xb])?this.ah=!1:e(l(Eg));
    this.ec=a;
    this.Ig=b;
    this.src=c;
    Ca(this,d);
    this.capture=!!f;
    this.sd=h;
    this.bh=!1;
    this.key=++rq;
    this.ic=!1
    };

Ba(N,function(a){
    if(this.ah)return this.ec[F](this.sd||this.src,a);
    return this.ec[Xb][F](this.ec,a)
    });
var sq,tq,uq,vq,wq,xq,yq,zq,Aq,Bq,Cq;
(function(){
    function a(){
        return{
            w:0,
            sa:0
        }
    }
    function b(){
    return[]
    }
    function c(){
    function a(b){
        return j[F](a.src,a.key,b)
        }
        return a
    }
    function d(){
    return new qq
    }
    function f(){
    return new lq
    }
    var h=oq&&!(ho(pq,uf)>=0),j;
    xq=function(a){
    j=a
    };

if(h){
    sq=function(){
        return m[Ib]()
        };

    tq=function(a){
        m.jc(a)
        };

    uq=function(){
        return q[Ib]()
        };

    vq=function(a){
        q.jc(a)
        };

    wq=function(){
        return u[Ib]()
        };

    yq=function(){
        u.jc(c())
        };

    zq=function(){
        return D[Ib]()
        };

    Aq=function(a){
        D.jc(a)
        };

    Bq=function(){
        return E[Ib]()
        };

    Cq=function(a){
        E.jc(a)
        };
    var m=new nq(0,600);
    m.Nc(a);
    var q=new nq(0,600);
    q.Nc(b);
    var u=new nq(0,600);
    u.Nc(c);
    var D=new nq(0,600);
    D.Nc(d);
    var E=new nq(0,600);
    E.Nc(f)
    }else sq=a,tq=yn,uq=b,vq=yn,wq=c,yq=yn,zq=d,Aq=yn,Bq=f,Cq=yn
    })();
var Dq={},Eq={},Fq={},Gq={};
function Hq(a,b,c,d,f){
    if(b)if(P(b)){
        for(var h=0;h<b[B];h++)Hq(a,b[h],c,d,f);
        return i
        }else{
        var d=!!d,j=Eq;
        b in j||(j[b]=sq());
        j=j[b];
        d in j||(j[d]=sq(),j.w++);
        var j=j[d],m=Hn(a),q;
        j.sa++;
        if(j[m]){
            q=j[m];
            for(h=0;h<q[B];h++)if(j=q[h],j.ec==c&&j.sd==f){
                if(j.ic)break;
                return q[h].key
                }
            }else q=j[m]=uq(),j.w++;
        h=wq();
        h.src=a;
        j=zq();
        j.Ib(c,h,a,b,d,f);
        c=j.key;
        h.key=c;
        q[r](j);
        Dq[c]=j;
        Fq[m]||(Fq[m]=uq());
        Fq[m][r](j);
        a.addEventListener?(a==O||!a.Cg)&&a.addEventListener(b,h,d):a.attachEvent(Iq(b),h);
        return c
        }else e(l("Invalid event type"))
    }
function Jq(a,b,c,d,f){
    if(P(b)){
        for(var h=0;h<b[B];h++)Jq(a,b[h],c,d,f);
        return i
        }
        d=!!d;
    a=Kq(a,b,d);
    if(!a)return!1;
    for(h=0;h<a[B];h++)if(a[h].ec==c&&a[h][wb]==d&&a[h].sd==f)return Lq(a[h].key);return!1
    }
function Lq(a){
    if(!Dq[a])return!1;
    var b=Dq[a];
    if(b.ic)return!1;
    var c=b.src,d=b[z],f=b.Ig,h=b[wb];
    c.removeEventListener?(c==O||!c.Cg)&&c.removeEventListener(d,f,h):c.detachEvent&&c.detachEvent(Iq(d),f);
    c=Hn(c);
    f=Eq[d][h][c];
    if(Fq[c]){
        var j=Fq[c];
        Co(j,b);
        j[B]==0&&delete Fq[c]
    }
    b.ic=!0;
    f.Sg=!0;
    Mq(d,h,c,f);
    delete Dq[a];
    return!0
    }
function Mq(a,b,c,d){
    if(!d.Id&&d.Sg){
        for(var f=0,h=0;f<d[B];f++)if(d[f].ic){
            var j=d[f].Ig;
            j.src=i;
            yq(j);
            Aq(d[f])
            }else f!=h&&(d[h]=d[f]),h++;Ja(d,h);
        d.Sg=!1;
        h==0&&(vq(d),delete Eq[a][b][c],Eq[a][b].w--,Eq[a][b].w==0&&(tq(Eq[a][b]),delete Eq[a][b],Eq[a].w--),Eq[a].w==0&&(tq(Eq[a]),delete Eq[a]))
        }
    }
function Nq(a,b,c){
    var d=0,f=b==i,h=c==i,c=!!c;
    if(a==i)Lo(Fq,function(a){
        for(var j=a[B]-1;j>=0;j--){
            var m=a[j];
            if((f||b==m[z])&&(h||c==m[wb]))Lq(m.key),d++
        }
        });
else if(a=Hn(a),Fq[a])for(var a=Fq[a],j=a[B]-1;j>=0;j--){
    var m=a[j];
    if((f||b==m[z])&&(h||c==m[wb]))Lq(m.key),d++
}
return d
}
function Kq(a,b,c){
    var d=Eq;
    if(b in d&&(d=d[b],c in d&&(d=d[c],a=Hn(a),d[a])))return d[a];
    return i
    }
    function Iq(a){
    if(a in Gq)return Gq[a];
    return Gq[a]=wl+a
    }
function Oq(a,b,c,d,f){
    var h=1,b=Hn(b);
    if(a[b]){
        a.sa--;
        a=a[b];
        a.Id?a.Id++:a.Id=1;
        try{
            for(var j=a[B],m=0;m<j;m++){
                var q=a[m];
                q&&!q.ic&&(h&=Pq(q,f)!==!1)
                }
            }finally{
        a.Id--,Mq(c,d,b,a)
        }
    }
return Boolean(h)
}
function Pq(a,b){
    var c=a[Xb](b);
    a.bh&&Lq(a.key);
    return c
    }
function Qq(a,b){
    var c=b[z]||b,d=Eq;
    if(!(c in d))return!0;
    if(Q(b))b=new jq(b,a);
    else if(b instanceof jq)Oa(b,b[$c]||a);
    else{
        var f=b,b=new jq(c,a);
        Ro(b,f)
        }
        var f=1,h,d=d[c],c=!0 in d,j;
    if(c){
        h=[];
        for(j=a;j;j=j.pd)h[r](j);
        j=d[!0];
        j.sa=j.w;
        for(var m=h[B]-1;!b.Lb&&m>=0&&j.sa;m--)ta(b,h[m]),f&=Oq(j,h[m],b[z],!0,b)&&b.Mc!=!1
            }
            if(!1 in d)if(j=d[!1],j.sa=j.w,c)for(m=0;!b.Lb&&m<h[B]&&j.sa;m++)ta(b,h[m]),f&=Oq(j,h[m],b[z],!1,b)&&b.Mc!=!1;else for(d=a;!b.Lb&&d&&j.sa;d=d.pd)ta(b,d),f&=Oq(j,d,b[z],!1,b)&&b.Mc!=
        !1;
    return Boolean(f)
    }
xq(function(a,b){
    if(!Dq[a])return!0;
    var c=Dq[a],d=c[z],f=Eq;
    if(!(d in f))return!0;
    var f=f[d],h,j;
    gq===g&&(gq=S&&!O.addEventListener);
    if(gq){
        h=b||wn(hn);
        var m=!0 in f,q=!1 in f;
        if(m){
            if(h[Pb]<0||h.returnValue!=g)return!0;
                a:{
                var u=!1;
                if(h[Pb]==0)try{
                    Aa(h,-1);
                    break a
                }catch(D){
                    u=!0
                    }
                    if(u||h.returnValue==g)h.returnValue=!0
                    }
                }
            u=Bq();
    u.Ib(h,this);
    h=!0;
    try{
        if(m){
            for(var E=uq(),K=u[zb];K;K=K[Dd])E[r](K);
            j=f[!0];
            j.sa=j.w;
            for(var G=E[B]-1;!u.Lb&&G>=0&&j.sa;G--)ta(u,E[G]),h&=Oq(j,E[G],d,!0,u);
            if(q){
                j=f[!1];
                j.sa=
                j.w;
                for(G=0;!u.Lb&&G<E[B]&&j.sa;G++)ta(u,E[G]),h&=Oq(j,E[G],d,!1,u)
                    }
                }else h=Pq(c,u)
        }finally{
    E&&(Ja(E,0),vq(E)),u.D(),Cq(u)
    }
    return h
}
d=new lq(b,this);
try{
    h=Pq(c,d)
    }finally{
    d.D()
    }
    return h
});
function Rq(){}
R(Rq,eq);
N=Rq[C];
N.Cg=!0;
N.pd=i;
N.Qe=function(a){
    this.pd=a
    };

N.addEventListener=function(a,b,c,d){
    Hq(this,a,b,c,d)
    };

N.removeEventListener=function(a,b,c,d){
    Jq(this,a,b,c,d)
    };

N.dispatchEvent=function(a){
    return Qq(this,a)
    };

N.j=function(){
    Rq.b.j[F](this);
    Nq(this);
    this.pd=i
    };

function Sq(a){
    var a=ja(a),b;
    b=/^\s*$/[Za](a)?!1:/^[\],:{}\s\u2028\u2029]*$/[Za](a[t](/\\["\\\/bfnrtu]/g,Of)[t](/"[^"\\\n\r\u2028\u2029\x00-\x08\x10-\x1f\x80-\x9f]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,Dh)[t](/(?:^|:|,)(?:[\s\u2028\u2029]*\[)+/g,J));
    if(b)try{
        return eval(qe+a+te)
        }catch(c){}
        e(l("Invalid JSON string: "+a))
    }
    function Tq(){}
Tq[C].Ql=function(a){
    var b=[];
    this.zf(a,b);
    return b[I](J)
    };
Tq[C].zf=function(a,b){
    switch(typeof a){
        case M:
            this.uh(a,b);
            break;
        case L:
            this.Rk(a,b);
            break;
        case gi:
            b[r](a);
            break;
        case "undefined":
            b[r](ul);
            break;
        case vl:
            if(a==i){
            b[r](ul);
            break
        }
        if(P(a)){
            this.Qk(a,b);
            break
        }
        this.Sk(a,b);
            break;
        case mj:
            break;
        default:
            e(l("Unknown type: "+typeof a))
            }
        };

var Uq={
    '"':'\\"',
    "\\":zh,
    "/":"\\/",
    "\u0008":"\\b",
    "\u000c":"\\f",
    "\n":"\\n",
    "\r":"\\r",
    "\t":"\\t",
    "\u000b":"\\u000b"
},Vq=/\uffff/[Za]("\uffff")?/[\\\"\x00-\x1f\x7f-\uffff]/g:/[\\\"\x00-\x1f\x7f-\xff]/g;
Tq[C].uh=function(a,b){
    b[r](Ud,a[t](Vq,function(a){
        if(a in Uq)return Uq[a];
        var b=a[qd](0),f=Ch;
        b<16?f+=pf:b<256?f+=of:b<4096&&(f+=lf);
        return Uq[a]=f+b[sc](16)
        }),Ud)
    };

Tq[C].Rk=function(a,b){
    b[r](ka(a)&&!ma(a)?a:ul)
    };

Tq[C].Qk=function(a,b){
    var c=a[B];
    b[r](uh);
    for(var d=J,f=0;f<c;f++)b[r](d),this.zf(a[f],b),d=we;
    b[r](Dh)
    };

Tq[C].Sk=function(a,b){
    b[r](pn);
    var c=J,d;
    for(d in a)if(ea[C][Tc][F](a,d)){
        var f=a[d];
        typeof f!=mj&&(b[r](c),this.uh(d,b),b[r](Af),this.zf(f,b),c=we)
        }
        b[r](qn)
    };

function Wq(a,b){
    this.Ld=a||1;
    this.Cc=b||Xq;
    this.df=Nn(this.uk,this);
    this.ef=Pn()
    }
    R(Wq,Rq);
Wq[C].enabled=!1;
var Xq=O.window;
N=Wq[C];
N.fa=i;
N.uk=function(){
    if(this.enabled){
        var a=Pn()-this.ef;
        if(a>0&&a<this.Ld*0.8)this.fa=this.Cc[Fc](this.df,this.Ld-a);
        else if(this.fk(),this.enabled)this.fa=this.Cc[Fc](this.df,this.Ld),this.ef=Pn()
            }
        };

N.fk=function(){
    this[w](Hm)
    };

N.start=function(){
    this.enabled=!0;
    if(!this.fa)this.fa=this.Cc[Fc](this.df,this.Ld),this.ef=Pn()
        };
N.stop=function(){
    this.enabled=!1;
    if(this.fa)this.Cc[ab](this.fa),this.fa=i
        };

N.j=function(){
    Wq.b.j[F](this);
    this.stop();
    delete this.Cc
    };

function Yq(){
    if(dp)this.Pb={},this.Nd={},this.Md=[]
        }
        N=Yq[C];
N.ga=dp;
N.pg=function(a){
    this.ga&&this.Md[r](Q(a)?a:En(a)?Hn(a):J)
    };

N.og=function(){
    this.ga&&this.Bk(this.Md.pop())
    };

N.wi=function(a){
    if(this.ga)for(var a=Hn(a),b=0;b<this.Md[B];b++){
        var c=this.Md[b];
        this.Od(this.Pb,c,a);
        this.Od(this.Nd,a,c)
        }
    };

N.Oj=function(a){
    if(this.ga)for(var b in a=Hn(a),delete this.Nd[a],this.Pb)Co(this.Pb[b],a),this.Pb[b][B]==0&&delete this.Pb[b]
        };
N.Bk=function(a){
    var b=this.Nd[a],c=this.Pb[a];
    b&&c&&xo(b,function(a){
        xo(c,function(b){
            this.Od(this.Pb,a,b);
            this.Od(this.Nd,b,a)
            },this)
        },this)
    };

N.Od=function(a,b,c){
    a[b]||(a[b]=[]);
    Bo(a[b],c)||a[b][r](c)
    };

var Zq=new Yq;
function $q(){}
$q[C].Oh=i;
$q[C].getOptions=function(){
    return this.Oh||(this.Oh=this.ol())
    };

function ar(){
    return br.Hh()
    }
    var br;
function cr(){}
R(cr,$q);
cr[C].Hh=function(){
    var a=this.Qh();
    return a?new ActiveXObject(a):new XMLHttpRequest
    };

cr[C].ol=function(){
    var a={};

    this.Qh()&&(a[0]=!0,a[1]=!0);
    return a
    };

cr[C].Df=i;
cr[C].Qh=function(){
    if(!this.Df&&typeof XMLHttpRequest=="undefined"&&typeof ActiveXObject!="undefined"){
        for(var a=[Pg,Og,Ng,Qg],b=0;b<a[B];b++){
            var c=a[b];
            try{
                return new ActiveXObject(c),this.Df=c
                }catch(d){}
        }
        e(l("Could not create ActiveXObject. ActiveX might be disabled, or MSXML might not be installed"))
    }
    return this.Df
};
br=new cr;
function dr(a){
    this.headers=new cq;
    this.wd=a||i
    }
    R(dr,Rq);
var er=/^https?:?$/i,fr=[];
function gr(a){
    a.D();
    Co(fr,a)
    }
    N=dr[C];
N.bb=!1;
N.q=i;
N.md=i;
N.td=J;
N.vi=J;
N.yc=0;
N.Bb=J;
N.Ee=!1;
N.fd=!1;
N.Ae=!1;
N.zb=!1;
N.xd=0;
N.Cb=i;
N.fg=J;
N.yi=!1;
N.Vl=function(a){
    this.xd=p.max(0,a)
    };
N.send=function(a,b,c,d){
    this.q&&e(l("[goog.net.XhrIo] Object is active with another request"));
    b=b?b.toUpperCase():pg;
    this.td=a;
    this.Bb=J;
    this.yc=0;
    this.vi=b;
    this.Ee=!1;
    this.bb=!0;
    this.q=this.ui();
    this.md=this.wd?this.wd[ib]():br[ib]();
    Zq.wi(this.q);
    this.q.onreadystatechange=Nn(this.$f,this);
    try{
        this.Ae=!0,this.q[Xa](b,a,!0),this.Ae=!1
        }catch(f){
        this.eg(5,f);
        return
    }
    var a=c||J,h=this.headers[Yc]();
    d&&bq(d,function(a,b){
        h.set(b,a)
        });
    b==Yg&&!h.eb(eg)&&h.set(eg,Xh);
    bq(h,function(a,b){
        this.q.setRequestHeader(b,
            a)
        },this);
    if(this.fg)this.q.responseType=this.fg;
    if(jn in this.q)this.q.withCredentials=this.yi;
    try{
        if(this.Cb)Xq[ab](this.Cb),this.Cb=i;
        if(this.xd>0)this.Cb=Xq[Fc](Nn(this.xi,this),this.xd);
        this.fd=!0;
        this.q[Gb](a);
        this.fd=!1
        }catch(j){
        this.eg(5,j)
        }
    };

N.ui=function(){
    return this.wd?this.wd.Hh():new ar
    };

N.dispatchEvent=function(a){
    if(this.q){
        Zq.pg(this.q);
        try{
            return dr.b[w][F](this,a)
            }finally{
            Zq.og()
            }
        }else return dr.b[w][F](this,a)
    };
N.xi=function(){
    if(typeof un!="undefined"&&this.q)this.Bb=lh+this.xd+ml,this.yc=8,this[w](Jm),this[Ec](8)
        };

N.eg=function(a,b){
    this.bb=!1;
    if(this.q)this.zb=!0,this.q[Ec](),this.zb=!1;
    this.Bb=b;
    this.yc=a;
    this.tg();
    this.cd()
    };

N.tg=function(){
    if(!this.Ee)this.Ee=!0,this[w](Ci),this[w](bj)
        };

N.abort=function(a){
    if(this.q&&this.bb)this.bb=!1,this.zb=!0,this.q[Ec](),this.zb=!1,this.yc=a||7,this[w](Ci),this[w](Kh),this.cd()
        };
N.j=function(){
    if(this.q){
        if(this.bb)this.bb=!1,this.zb=!0,this.q[Ec](),this.zb=!1;
        this.cd(!0)
        }
        dr.b.j[F](this)
    };

N.$f=function(){
    !this.Ae&&!this.fd&&!this.zb?this.nf():this.ih()
    };

N.nf=function(){
    this.ih()
    };

N.ih=function(){
    if(this.bb&&typeof un!="undefined"&&(!this.md[1]||!(this.Lc()==4&&this.Ye()==2)))if(this.fd&&this.Lc()==4)Xq[Fc](Nn(this.$f,this),0);
        else if(this[w](Sl),this.lj())this.bb=!1,this.Hg()?(this[w](Ci),this[w](Bm)):(this.yc=6,this.Bb=this.jj()+Qd+this.Ye()+Dh,this.tg()),this.cd()
        };
N.cd=function(a){
    if(this.q){
        var b=this.q,c=this.md[0]?yn:i;
        this.md=this.q=i;
        if(this.Cb)Xq[ab](this.Cb),this.Cb=i;
        a||(Zq.pg(b),this[w](Rl),Zq.og());
        Zq.Oj(b);
        try{
            b.onreadystatechange=c
            }catch(d){}
    }
};

N.Ca=function(){
    return!!this.q
    };

N.lj=function(){
    return this.Lc()==4
    };

N.Hg=function(){
    switch(this.Ye()){
        case 0:
            return!this.jl();
        case 200:case 204:case 304:
            return!0;
        default:
            return!1
            }
        };
N.jl=function(){
    var a=Q(this.td)?this.td[Db](jo)[1]||i:this.td.oa;
    if(a)return er[Za](a);
    return self[Oc]?er[Za](self[Oc].protocol):!0
    };

N.Lc=function(){
    return this.q?this.q.readyState:0
    };

N.Ye=function(){
    try{
        return this.Lc()>2?this.q.status:-1
        }catch(a){
        return-1
        }
    };

N.jj=function(){
    try{
        return this.Lc()>2?this.q.statusText:J
        }catch(a){
        return J
        }
    };

N.Zk=function(){
    try{
        return this.q?this.q.responseText:J
        }catch(a){
        return J
        }
    };

N.Yk=function(){
    return Q(this.Bb)?this.Bb:ja(this.Bb)
    };

dr.send=function(a,b,c,d,f,h){
    var j=new dr;
    fr[r](j);
    b&&Hq(j,Ci,b);
    Hq(j,Rl,On(gr,j));
    h&&j.Vl(h);
    j[Gb](a,c,d,f)
    };

dr.vm=function(){
    for(;fr[B];)fr.pop().D()
        };

dr.xm=function(a){
    dr[C].nf=a.am(dr[C].nf)
    };

dr.wm=gr;
dr.em=eg;
dr.jm=Xh;
dr.zm=fr;
function hr(a,b){
    var c;
    a instanceof hr?(this.cc(b==i?a.Da:b),this.jd(a.oa),this.kd(a.yb),this.gd(a.wb),this.xc(a.La),this.wc(a.na),this.Ce(a.$[Yc]()),this.hd(a.xb)):a&&(c=ja(a)[Db](jo))?(this.cc(!!b),this.jd(c[1]||J,!0),this.kd(c[2]||J,!0),this.gd(c[3]||J,!0),this.xc(c[4]),this.wc(c[5]||J,!0),this[Vc](c[6]||J,!0),this.hd(c[7]||J,!0)):(this.cc(!!b),this.$=new ir(i,this,this.Da))
    }
    N=hr[C];
N.oa=J;
N.yb=J;
N.wb=J;
N.La=i;
N.na=J;
N.xb=J;
N.Ml=!1;
N.Da=!1;
N.toString=function(){
    if(this.ra)return this.ra;
    var a=[];
    this.oa&&a[r](jr(this.oa,kr),Af);
    if(this.wb){
        a[r](df);
        this.yb&&a[r](jr(this.yb,kr),Of);
        var b;
        b=this.wb;
        b=Q(b)?ba(b):i;
        a[r](b);
        this.La!=i&&a[r](Af,ja(this.La))
        }
        this.na&&(this.ze()&&this.na[lb](0)!=bf&&a[r](bf),a[r](jr(this.na,lr)));
    (b=ja(this.$))&&a[r](Nf,b);
    this.xb&&a[r](Yd,jr(this.xb,mr));
    return this.ra=a[I](J)
    };
N.ck=function(a){
    var b=this[Yc](),c=a.Ei();
    c?b.jd(a.oa):c=a.Fi();
    c?b.kd(a.yb):c=a.ze();
    c?b.gd(a.wb):c=a.Ci();
    var d=a.na;
    if(c)b.xc(a.La);
    else if(c=a.qg()){
        if(d[lb](0)!=bf)if(this.ze()&&!this.qg())d=bf+d;
            else{
            var f=b.na[fd](bf);
            f!=-1&&(d=b.na[pc](0,f+1)+d)
            }
            f=d;
        if(f==Ze||f==Ye)d=J;
        else if(f[v]($e)==-1&&f[v](cf)==-1)d=f;
        else{
            for(var d=f[fd](bf,0)==0,f=f[Jc](bf),h=[],j=0;j<f[B];){
                var m=f[j++];
                m==Ye?d&&j==f[B]&&h[r](J):m==Ze?((h[B]>1||h[B]==1&&h[0]!=J)&&h.pop(),d&&j==f[B]&&h[r](J)):(h[r](m),d=!0)
                }
                d=h[I](bf)
            }
        }
    c?
b.wc(d):c=a.Di();
c?b[Vc](a.Ai()):c=a.Bi();
c&&b.hd(a.xb);
return b
};

Na(N,function(){
    var a=this.oa,b=this.yb,c=this.wb,d=this.La,f=this.na,h=this.$[Yc](),j=this.xb,m=new hr(i,this.Da);
    a&&m.jd(a);
    b&&m.kd(b);
    c&&m.gd(c);
    d&&m.xc(d);
    f&&m.wc(f);
    h&&m.Ce(h);
    j&&m.hd(j);
    return m
    });
N.jd=function(a,b){
    this.Pa();
    delete this.ra;
    if(this.oa=b?a?la(a):J:a)this.oa=this.oa[t](/:$/,J);
    return this
    };

N.Ei=function(){
    return!!this.oa
    };

N.kd=function(a,b){
    this.Pa();
    delete this.ra;
    this.yb=b?a?la(a):J:a;
    return this
    };

N.Fi=function(){
    return!!this.yb
    };
N.gd=function(a,b){
    this.Pa();
    delete this.ra;
    this.wb=b?a?la(a):J:a;
    return this
    };

N.ze=function(){
    return!!this.wb
    };

N.xc=function(a){
    this.Pa();
    delete this.ra;
    a?(a=da(a),(ma(a)||a<0)&&e(l("Bad port number "+a)),this.La=a):this.La=i;
    return this
    };

N.Ci=function(){
    return this.La!=i
    };

N.wc=function(a,b){
    this.Pa();
    delete this.ra;
    this.na=b?a?la(a):J:a;
    return this
    };

N.qg=function(){
    return!!this.na
    };

N.Di=function(){
    return this.$[sc]()!==J
    };
N.Ce=function(a,b){
    this.Pa();
    delete this.ra;
    a instanceof ir?(this.$=a,this.$.Ve=this,this.$.cc(this.Da)):(b||(a=jr(a,nr)),this.$=new ir(a,this,this.Da));
    return this
    };

N.setQuery=function(a,b){
    return this.Ce(a,b)
    };

N.Kl=function(){
    return this.$[sc]()
    };

N.Ai=function(){
    return this.$.Gk()
    };

N.getQuery=function(){
    return this.Kl()
    };

N.nd=function(a,b){
    this.Pa();
    delete this.ra;
    this.$.set(a,b);
    return this
    };

N.hh=function(a){
    return this.$.get(a)
    };
N.hd=function(a,b){
    this.Pa();
    delete this.ra;
    this.xb=b?a?la(a):J:a;
    return this
    };

N.Bi=function(){
    return!!this.xb
    };

N.Uj=function(){
    this.Pa();
    this.nd(on,p[gb](p.random()*2147483648)[sc](36)+p.abs(p[gb](p.random()*2147483648)^Pn())[sc](36));
    return this
    };

N.Pa=function(){
    this.Ml&&e(l("Tried to modify a read-only Uri"))
    };

N.cc=function(a){
    this.Da=a;
    this.$&&this.$.cc(a);
    return this
    };

var or=/^[a-zA-Z0-9\-_.!~*'():\/;?]*$/;
function jr(a,b){
    var c=i;
    Q(a)&&(c=a,or[Za](c)||(c=encodeURI(a)),c.search(b)>=0&&(c=c[t](b,pr)));
    return c
    }
    function pr(a){
    a=a[qd](0);
    return be+(a>>4&15)[sc](16)+(a&15)[sc](16)
    }
    var kr=/[#\/\?@]/g,lr=/[\#\?]/g,nr=/[\#\?@]/g,mr=/#/g;
function ir(a,b,c){
    this.Ua=a||i;
    this.Ve=b||i;
    this.Da=!!c
    }
    N=ir[C];
N.hb=function(){
    if(!this.z&&(this.z=new cq,this.Ua))for(var a=this.Ua[Jc](ee),b=0;b<a[B];b++){
        var c=a[b][v](Lf),d=i,f=i;
        c>=0?(d=a[b][ud](0,c),f=a[b][ud](c+1)):d=a[b];
        d=la(d[t](/\+/g,Pd));
        d=this.Hb(d);
        this.add(d,f?la(f[t](/\+/g,Pd)):J)
        }
    };

N.z=i;
N.w=i;
N.add=function(a,b){
    this.hb();
    this.Jc();
    a=this.Hb(a);
    if(this.eb(a)){
        var c=this.z.get(a);
        P(c)?c[r](b):this.z.set(a,[c,b])
        }else this.z.set(a,b);
    this.w++;
    return this
    };
N.remove=function(a){
    this.hb();
    a=this.Hb(a);
    if(this.z.eb(a)){
        this.Jc();
        var b=this.z.get(a);
        P(b)?this.w-=b[B]:this.w--;
        return this.z.remove(a)
        }
        return!1
    };

N.clear=function(){
    this.Jc();
    this.z&&this.z.clear();
    this.w=0
    };

N.eb=function(a){
    this.hb();
    a=this.Hb(a);
    return this.z.eb(a)
    };

N.Mb=function(){
    this.hb();
    for(var a=this.z.Nb(),b=this.z.Mb(),c=[],d=0;d<b[B];d++){
        var f=a[d];
        if(P(f))for(var h=0;h<f[B];h++)c[r](b[d]);else c[r](b[d])
            }
            return c
    };
N.Nb=function(a){
    this.hb();
    if(a)if(a=this.Hb(a),this.eb(a)){
        var b=this.z.get(a);
        if(P(b))return b;else a=[],a[r](b)
            }else a=[];else for(var b=this.z.Nb(),a=[],c=0;c<b[B];c++){
        var d=b[c];
        P(d)?Fo(a,d):a[r](d)
        }
        return a
    };

N.set=function(a,b){
    this.hb();
    this.Jc();
    a=this.Hb(a);
    if(this.eb(a)){
        var c=this.z.get(a);
        P(c)?this.w-=c[B]:this.w--
    }
    this.z.set(a,b);
    this.w++;
    return this
    };

N.get=function(a,b){
    this.hb();
    a=this.Hb(a);
    if(this.eb(a)){
        var c=this.z.get(a);
        return P(c)?c[0]:c
        }else return b
        };
N.toString=function(){
    if(this.Ua)return this.Ua;
    if(!this.z)return J;
    for(var a=[],b=0,c=this.z.Mb(),d=0;d<c[B];d++){
        var f=c[d],h=Zn(f),f=this.z.get(f);
        if(P(f))for(var j=0;j<f[B];j++)b>0&&a[r](ee),a[r](h),f[j]!==J&&a[r](Lf,Zn(f[j])),b++;else b>0&&a[r](ee),a[r](h),f!==J&&a[r](Lf,Zn(f)),b++
    }
    return this.Ua=a[I](J)
    };

N.Gk=function(){
    if(!this.oc)this.oc=this[sc]()?la(this[sc]()):J;
    return this.oc
    };

N.Jc=function(){
    delete this.oc;
    delete this.Ua;
    this.Ve&&delete this.Ve.ra
    };
Na(N,function(){
    var a=new ir;
    if(this.oc)a.oc=this.oc;
    if(this.Ua)a.Ua=this.Ua;
    if(this.z)a.z=this.z[Yc]();
    return a
    });
N.Hb=function(a){
    a=ja(a);
    this.Da&&(a=a[Jd]());
    return a
    };

N.cc=function(a){
    a&&!this.Da&&(this.hb(),this.Jc(),bq(this.z,function(a,c){
        var d=c[Jd]();
        c!=d&&(this.remove(c),this.add(d,a))
        },this));
    this.Da=a
    };

N.extend=function(){
    for(var a=0;a<arguments[B];a++)bq(arguments[a],function(a,c){
        this.add(c,a)
        },this)
    };

function qr(a){
    a=rr(a,sr);
    return(new Tq).Ql(a)
    }
    function tr(a){
    Sq(a);
    return ur(a)
    }
    function ur(a){
    a=vr(a);
    return eval(qe+a+te)
    }
    function rr(a,b){
    var a=b(a),c=An(a);
    if(c==vl||c==Zh){
        var c=c==Zh?[]:{},d;
        for(d in a){
            var f=rr(a[d],b);
            Bn(f)&&(c[d]=f)
            }
        }else c=a;
return c
}
function vr(a){
    return a[t](/"(Date\([\d,\s]*\))"/g,function(a,c){
        return ql+c
        })
    }
function sr(a){
    Dn(a)&&(a=a.getMilliseconds()!==0?[a[id](),a[uc](),a[ob](),a[hc](),a[Ed](),a[Hc](),a.getMilliseconds()]:a[Hc]()!==0||a[Ed]()!==0||a[hc]()!==0?[a[id](),a[uc](),a[ob](),a[hc](),a[Ed](),a[Hc]()]:[a[id](),a[uc](),a[ob]()],a=gg+a[I](xe)+te);
    return a
    };

var wr={
    sl:["BC","AD"],
    rl:["Before Christ","Anno Domini"],
    al:["J","F",Lg,"A",Lg,"J","J","A",bh,"O","N","D"],
    dl:["J","F",Lg,"A",Lg,"J","J","A",bh,"O","N","D"],
    $k:["January","February","March","April","May","June","July","August","September","October","November","December"],
    cl:["January","February","March","April","May","June","July","August","September","October","November","December"],
    bl:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
    fl:["Jan","Feb","Mar","Apr","May","Jun",
    "Jul","Aug","Sep","Oct","Nov","Dec"],
    wl:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
    hl:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
    vl:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
    gl:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],
    lm:[bh,Lg,"T",sh,"T","F",bh],
    el:[bh,Lg,"T",sh,"T","F",bh],
    ul:["Q1","Q2","Q3","Q4"],
    tl:["1st quarter","2nd quarter","3rd quarter","4th quarter"],
    Fl:["AM","PM"],
    xh:["EEEE, MMMM d, y","MMMM d, y","MMM d, y","M/d/yy"],
    yh:["h:mm:ss a zzzz",
    "h:mm:ss a z","h:mm:ss a","h:mm a"],
    hm:6,
    sm:[5,6],
    im:2
};

function xr(){}
function yr(a){
    if(typeof a==L){
        var b=new xr;
        b.ph=a;
        var c;
        c=a;
        if(c==0)c=kg;
        else{
            var d=[kg,c<0?ye:ve];
            c=p.abs(c);
            d[r](p[gb](c/60)%100);
            c%=60;
            c!=0&&d[r](Af,go(c,2));
            c=d[I](J)
            }
            b.sh=c;
        a==0?a=oh:(c=[oh,a<0?ve:ye],a=p.abs(a),c[r](p[gb](a/60)%100),a%=60,a!=0&&c[r](Af,a),a=c[I](J));
        b.pf=[a,a];
        b.Xd=[];
        return b
        }
        b=new xr;
    b.sh=a.id;
    b.ph=-a.std_offset;
    b.pf=a.names;
    b.Xd=a.transitions;
    return b
    }
    N=xr[C];
N.Lh=function(a){
    for(var a=Date.UTC(a.getUTCFullYear(),a.getUTCMonth(),a.getUTCDate(),a.getUTCHours(),a.getUTCMinutes())/36E5,b=0;b<this.Xd[B]&&a>=this.Xd[b];)b+=2;
    return b==0?0:this.Xd[b-1]
    };

N.yl=function(a){
    var a=this.vf(a),b=[qg];
    b[r](a<=0?ve:ye);
    a=p.abs(a);
    b[r](go(p[gb](a/60)%100,2),Af,go(a%60,2));
    return b[I](J)
    };

N.zl=function(a){
    return this.pf[this.Ih(a)?3:1]
    };

N.vf=function(a){
    return this.ph-this.Lh(a)
    };
N.Al=function(a){
    var a=-this.vf(a),b=[a<0?ye:ve],a=p.abs(a);
    b[r](go(p[gb](a/60)%100,2),go(a%60,2));
    return b[I](J)
    };

N.Bl=function(a){
    return this.pf[this.Ih(a)?2:0]
    };

N.Ih=function(a){
    return this.Lh(a)>0
    };

function zr(a){
    this.Ud=[];
    typeof a==L?this.oh(a):this.nh(a)
    }
    var Ar=[/^\'(?:[^\']|\'\')*\'/,/^(?:G+|y+|M+|k+|S+|E+|a+|h+|K+|H+|c+|L+|Q+|d+|m+|s+|v+|z+|Z+)/,/^[^\'GyMkSEahKHcLQdmsvzZ]+/];N=zr[C];N.nh=function(a){for(;a;)for(var b=0;b<Ar[B];++b){var c=a[Db](Ar[b]);if(c){c=c[0];a=a[ud](c[B]);b==0&&(c==ne?c=me:(c=c[ud](1,c[B]-1),c=c[t](/\'\'/,me)));this.Ud[r]({text:c
    ,type:b});break}}};
za(N,function(a,b){
    var c=b?(a[Md]()-b.vf(a))*6E4:0,d=c?new Date(a[ic]()+c):a,f=d;
    b&&d[Md]()!=a[Md]()&&(c+=c>0?-864E5:864E5,f=new Date(a[ic]()+c));
    for(var c=[],h=0;h<this.Ud[B];++h){
        var j=this.Ud[h].text;
        1==this.Ud[h][z]?c[r](this.Nk(j,a,d,f,b)):c[r](j)
        }
        return c[I](J)
    });
N.oh=function(a){
    if(a<4)a=wr.xh[a];
    else if(a<8)a=wr.yh[a-4];
    else if(a<12)a=wr.xh[a-8]+Pd+wr.yh[a-8];
    else{
        this.oh(10);
        return
    }
    this.nh(a)
    };

N.Cj=function(a,b){
    var c=b[id]()>0?1:0;
    return a>=4?wr.rl[c]:wr.sl[c]
    };
N.Nj=function(a,b){
    var c=b[id]();
    c<0&&(c=-c);
    return a==2?go(c%100,2):ja(c)
    };

N.Fj=function(a,b){
    var c=b[uc]();
    switch(a){
        case 5:
            return wr.al[c];
        case 4:
            return wr.$k[c];
        case 3:
            return wr.bl[c];
        default:
            return go(c+1,a)
            }
        };

N.yj=function(a,b){
    return go(b[hc]()||24,a)
    };

N.Dj=function(a,b){
    return(b[ic]()%1E3/1E3).toFixed(p.min(3,a))[pc](2)+(a>3?go(0,a-3):J)
    };

N.Bj=function(a,b){
    var c=b.getDay();
    return a>=4?wr.wl[c]:wr.vl[c]
    };

N.zj=function(a,b){
    var c=b[hc]();
    return wr.Fl[c>=12&&c<24?1:0]
    };
N.xj=function(a,b){
    return go(b[hc]()%12||12,a)
    };

N.vj=function(a,b){
    return go(b[hc]()%12,a)
    };

N.wj=function(a,b){
    return go(b[hc](),a)
    };

N.Ij=function(a,b){
    var c=b.getDay();
    switch(a){
        case 5:
            return wr.el[c];
        case 4:
            return wr.hl[c];
        case 3:
            return wr.gl[c];
        default:
            return go(c,1)
            }
        };

N.Jj=function(a,b){
    var c=b[uc]();
    switch(a){
        case 5:
            return wr.dl[c];
        case 4:
            return wr.cl[c];
        case 3:
            return wr.fl[c];
        default:
            return go(c+1,a)
            }
        };

N.Gj=function(a,b){
    var c=p[gb](b[uc]()/3);
    return a<4?wr.ul[c]:wr.tl[c]
    };
N.Aj=function(a,b){
    return go(b[ob](),a)
    };

N.Ej=function(a,b){
    return go(b[Ed](),a)
    };

N.Hj=function(a,b){
    return go(b[Hc](),a)
    };

N.Lj=function(a,b,c){
    c=c||yr(b[Md]());
    return a<4?c.Al(b):c.yl(b)
    };

N.Mj=function(a,b,c){
    c=c||yr(b[Md]());
    return a<4?c.Bl(b):c.zl(b)
    };

N.Kj=function(a,b){
    b=b||yr(a[Md]());
    return b.sh
    };
N.Nk=function(a,b,c,d,f){
    var h=a[B];
    switch(a[lb](0)){
        case og:
            return this.Cj(h,c);
        case mn:
            return this.Nj(h,c);
        case Lg:
            return this.Fj(h,c);
        case Lk:
            return this.yj(h,d);
        case bh:
            return this.Dj(h,d);
        case hg:
            return this.Bj(h,c);
        case Jh:
            return this.zj(h,d);
        case jk:
            return this.xj(h,d);
        case Hg:
            return this.vj(h,d);
        case tg:
            return this.wj(h,d);
        case ni:
            return this.Ij(h,c);
        case Ig:
            return this.Jj(h,c);
        case $g:
            return this.Gj(h,c);
        case Hi:
            return this.Aj(h,c);
        case Wk:
            return this.Ej(h,d);
        case cm:
            return this.Hj(h,d);
        case Ym:
            return this.Kj(b,f);
        case nn:
            return this.Mj(h,b,f);
        case th:
            return this.Lj(h,b,f);
        default:
            return J
            }
        };

function Br(a,b,c){
    typeof b!=vl||!(Ai in b)?e(l(c+' must have a property "column"')):Mi in b&&typeof b.desc!=gi&&e(l('Property "desc" in '+c+" must be boolean."));
    T(a,b.column)
    }
function Cr(a,b){
    if(typeof b==L)return T(a,b),[{
        column:b
    }];
    else if(typeof b==vl)if(Cn(b)){
        b[B]<1&&e(l("sortColumns is an empty array. Must have at least one element."));
        var c={};

        if(typeof b[0]==vl){
            for(var d=0;d<b[B];d++){
                Br(a,b[d],tm+d+Dh);
                var f=b[d].column;
                f in c&&e(l(ag+f+Rd));
                c[f]=!0
                }
                return b
            }else if(typeof b[0]==L){
            for(var h=[],d=0;d<b[B];d++)T(a,b[d]),b[d]in c&&e(l(ag+f+Rd)),c[f]=!0,h[r]({
                column:b[d]
                });
            return h
            }else e(l("sortColumns is an array, but neither of objects nor of numbers. Must be either of those."))
            }else return Br(a,
        b,sm),[b]
    }
    function Dr(a,b){
    var c=a[xc]();
    c>0?(p[gb](b)!==b||b<0||b>=c)&&e(l("Invalid row index "+b+". Should be in the range [0-"+(c-1)+"].")):e(l("Table has no rows."))
    }
    function T(a,b){
    var c=a[nb]();
    c>0?(p[gb](b)!==b||b<0||b>=c)&&e(l("Invalid column index "+b+". Should be an integer in the range [0-"+(c-1)+"].")):e(l("Table has no columns."))
    }
function Er(a,b,c){
    if(c!=i){
        var a=a[y](b),d=typeof c;
        switch(a){
            case L:
                if(d==L)return;
                break;
            case M:
                if(d==M)return;
                break;
            case gi:
                if(d==gi)return;
                break;
            case Ii:case Ji:
                if(Dn(c))return;
                break;
            case Im:
                if(Cn(c)&&c[B]>2&&c[B]<5){
                for(var d=!0,f=0;f<c[B];f++){
                    var h=c[f];
                    if(typeof h!=L||h!=p[gb](h)){
                        d=!1;
                        break
                    }
                }
                if(c[0]<0||c[0]>23||c[1]<0||c[1]>59||c[2]<0||c[2]>59)d=!1;
                if(c[B]==4&&(c[3]<0||c[3]>999))d=!1;
                if(d)return
            }
        }
        e(l("Type mismatch. Value "+c+" does not match type "+a+" in column index "+b))
}
}
function Fr(a,b,c){
    if(b==i)return c==i?0:-1;
    if(c==i)return 1;
    switch(a){
        case gi:case L:case M:case Ii:case Ji:
            return b<c?-1:c<b?1:0;
        case Im:
            for(a=0;a<3;a++)if(b[a]<c[a])return-1;
            else if(c[a]<b[a])return 1;b=b[B]<4?0:b[3];
            c=c[B]<4?0:c[3];
            return b<c?-1:c<b?1:0
            }
        }
function Gr(a,b){
    T(a,b);
    var c=a[y](b),d=i,f=i,h,j,m=a[xc]();
    for(h=0;h<m;h++)if(j=a[A](h,b),xn(j)){
        f=d=j;
        break
    }
    if(d==i)return{
        min:i,
        max:i
    };

    for(h++;h<m;h++)j=a[A](h,b),xn(j)&&(Fr(c,j,d)<0?d=j:Fr(c,f,j)<0&&(f=j));
    return{
        min:d,
        max:f
    }
}
function Hr(a,b){
    for(var b=Cr(a,b),c=[],d=a[xc](),f=0;f<d;f++)c[r](f);
    Ko(c,function(c,d){
        for(var f=0;f<b[B];f++){
            var q=b[f],u=q.column,u=Fr(a[y](u),a[A](c,u),a[A](d,u));
            if(u!=0)return u*(q.desc?-1:1)
                }
                return 0
        });
    return c
    }
    function Ir(a,b){
    T(a,b);
    var c=a[xc]();
    if(c==0)return[];
    for(var d=[],f=0;f<c;++f)d[r](a[A](f,b));
    var h=a[y](b);
    Ko(d,function(a,b){
        return Fr(h,a,b)
        });
    var c=d[0],j=[];
    j[r](c);
    for(f=1;f<d[B];f++){
        var m=d[f];
        Fr(h,m,c)!=0&&j[r](m);
        c=m
        }
        return j
    }
function Jr(a,b,c){
    for(var d=0;d<b[B];d++){
        var f=b[d],h=f.column,j=a[A](c,h),h=a[y](h);
        if(f.minValue!=i||f.maxValue!=i){
            if(j==i)return!1;
            if(f.minValue!=i&&Fr(h,j,f.minValue)<0)return!1;
            if(f.maxValue!=i&&Fr(h,j,f.maxValue)>0)return!1
                }else if(Fr(h,j,f[pb])!=0)return!1
            }
            return!0
    }
function Kr(a,b){
    (!Cn(b)||b[B]==0)&&e(l("columnFilters must be a non-empty array"));
    for(var c={},d=0;d<b[B];d++){
        if(typeof b[d]!=vl||!(Ai in b[d]))$m in b[d]||el in b[d]||Zk in b[d]?$m in b[d]&&(el in b[d]||Zk in b[d])&&e(l(Bi+d+'] must specify either "value" or range properties ("minValue" and/or "maxValue"')):e(l(Bi+d+'] must have properties "column" and "value", "minValue"or "maxValue"'));
        var f=b[d].column;
        f in c&&e(l(ag+f+" is duplicate in columnFilters."));
        T(a,f);
        Er(a,f,b[d][pb]);
        c[f]=!0
        }
        c=[];
    d=a[xc]();
    for(f=0;f<d;f++)Jr(a,b,f)&&c[r](f);
    return c
    }
    function Lr(a,b){
    var c;
    b==Im?(c=[],c[r](a[0]),c[r]((a[1]<10?lf:J)+a[1]),c[r]((a[2]<10?lf:J)+a[2]),c=c[I](Af),a[B]>3&&a[3]>0&&(c+=Ye+(a[3]<10?of:a[3]<100?lf:J)+a[3])):b==Ii?(c=new zr(2),c=c[Eb](a)):b==Ji?(c=new zr(10),c=c[Eb](a)):c=ja(a);
    return c
    }
    function Mr(a,b,c,d){
    for(var f=i,h=a[xc]();(d?b>=0:b<h)&&f===i;)f=a[A](b,c),b+=d?-1:1;
    return f
    };

function U(a,b){
    this.Db=b?b==mf?mf:nf:nf;
    a?(Q(a)&&(a=tr(a)),this.B=a.cols||[],this.F=a.rows||[],this.Va=a.p||i):(this.B=[],this.F=[],this.Va=i)
    }
    var Nr={
    dm:gi,
    mm:L,
    om:M,
    fm:Ii,
    pm:Im,
    gm:Ji
};

N=U[C];
N.B=i;
N.Db=i;
N.F=i;
N.Va=i;
N.getNumberOfRows=function(){
    return this.F[B]
    };

N.getNumberOfColumns=function(){
    return this.B[B]
    };

Na(N,function(){
    return new U(this[Bc]())
    });
N.getColumnId=function(a){
    T(this,a);
    return this.B[a].id
    };
N.getColumnIndex=function(a){
    for(var b=this.B,c=0;c<b[B];c++)if(b[c].id==a)return c;return-1
    };

N.getColumnLabel=function(a){
    T(this,a);
    return this.B[a][Fd]
    };

N.getColumnPattern=function(a){
    T(this,a);
    return this.B[a].pattern
    };

N.getColumnType=function(a){
    T(this,a);
    return this.B[a][z]
    };

Ea(N,function(a,b){
    Dr(this,a);
    T(this,b);
    var c=this.Pc(a,b),d=i;
    if(c)d=c.v,d=Bn(d)?d:i;
    return d
    });
N.Pc=function(a,b){
    return this.F[a].c[b]
    };
N.getFormattedValue=function(a,b){
    Dr(this,a);
    T(this,b);
    var c=this.Pc(a,b),d=J;
    if(c)if(typeof c.f!="undefined"&&c.f!=i)d=c.f;
        else if(c=this[A](a,b),c!==i)return Lr(c,this[y](b));
    return d
    };

N.getProperty=function(a,b,c){
    Dr(this,a);
    T(this,b);
    return(a=(a=this.Pc(a,b))&&a.p)&&c in a?a[c]:i
    };

N.getProperties=function(a,b){
    Dr(this,a);
    T(this,b);
    var c=this.Pc(a,b);
    c||(c={
        v:i,
        f:i
    },this.F[a].c[b]=c);
    c.p||(c.p={});
    return c.p
    };

N.getTableProperties=function(){
    return this.Va
    };
N.getTableProperty=function(a){
    var b=this.Va;
    return b&&a in b?b[a]:i
    };

N.setTableProperties=function(a){
    this.Va=a
    };

N.setTableProperty=function(a,b){
    if(!this.Va)this.Va={};

    this.Va[a]=b
    };

Ka(N,function(a,b,c){
    this[cc](a,b,c,g,g)
    });
N.setFormattedValue=function(a,b,c){
    this[cc](a,b,g,c,g)
    };

N.setProperties=function(a,b,c){
    this[cc](a,b,g,g,c)
    };

N.setProperty=function(a,b,c,d){
    this[zc](a,b)[c]=d
    };
N.setCell=function(a,b,c,d,f){
    Dr(this,a);
    T(this,b);
    var h=this.Pc(a,b);
    h||(h={},this.F[a].c[b]=h);
    if(typeof c!="undefined")Er(this,b,c),h.v=c;
    typeof d!="undefined"&&(h.f=d);
    Bn(f)&&(h.p=En(f)?f:{})
    };

N.setRowProperties=function(a,b){
    Dr(this,a);
    this.F[a].p=b
    };

N.setRowProperty=function(a,b,c){
    this[Yb](a)[b]=c
    };

N.getRowProperty=function(a,b){
    Dr(this,a);
    var c=this.F[a];
    return(c=c&&c.p)&&b in c?c[b]:i
    };

N.getRowProperties=function(a){
    Dr(this,a);
    a=this.F[a];
    a.p||(a.p={});
    return a.p
    };
N.setColumnLabel=function(a,b){
    T(this,a);
    this.B[a].label=b
    };

N.setColumnProperties=function(a,b){
    T(this,a);
    this.B[a].p=b
    };

N.setColumnProperty=function(a,b,c){
    this[xb](a)[b]=c
    };

N.getColumnProperty=function(a,b){
    T(this,a);
    var c=this.B[a];
    return(c=c&&c.p)&&b in c?c[b]:i
    };

N.getColumnProperties=function(a){
    T(this,a);
    a=this.B[a];
    a.p||(a.p={});
    return a.p
    };
N.insertColumn=function(a,b,c,d){
    a!==this.B[B]&&T(this,a);
    Oo(Nr,b)||e(l("Invalid type: "+b+Ye));
    this.B[Hd](a,0,{
        id:d||J,
        label:c||J,
        pattern:J,
        type:b
    });
    for(b=0;b<this.F[B];b++)this.F[b].c[Hd](a,0,{
        v:i,
        f:i
    })
    };

N.addColumn=function(a,b,c){
    this.insertColumn(this.B[B],a,b,c);
    return this.B[B]-1
    };
N.Tj=function(a,b){
    var c={};

    if(An(b)==vl&&!Dn(b)){
        c.v=typeof b.v=="undefined"?i:b.v;
        var d=typeof b.f;
        d=="undefined"||d==ul?c.f=i:d==M?c.f=b.f:e(l("Formatted value ('f'), if specified, must be a string."));
        d=typeof b.p;
        d==vl?c.p=b.p:d!=ul&&d!="undefined"&&e(l("Properties ('p'), if specified, must be an Object."))
        }else c.v=xn(b)?b:i,c.f=i;
    Er(this,a,c.v);
    return c
    };
N.insertRows=function(a,b){
    a!==this.F[B]&&Dr(this,a);
    var c;
    if(typeof b==vl&&b[Lc]==oa)c=b;
    else if(typeof b==L){
        (b!=p[gb](b)||b<0)&&e(l("Invalid value for numOrArray: "+b+". If numOrArray is a number it should be a nonnegative integer."));
        c=[];
        for(var d=0;d<b;d++)c[d]=i
            }else e(l("Invalid value for numOrArray. Should be a number or an array of arrays of cells."));
    for(var d=[],f=0;f<c[B];f++){
        var h=c[f],j=[];
        if(h===i)for(h=0;h<this.B[B];h++)j[r]({
            v:i,
            f:i
        });
        else if(P(h)){
            h[B]!=this.B[B]&&e(l("Row given with size different than "+
                this.B[B]+" (the number of columns in the table)."));
            for(var m=0;m<h[B];m++)j[r](this.Tj(m,h[m]))
                }else e(l("Every row given must be either null or an array."));
        h={};

        h.c=j;
        d[r](h)
        }
        On(Go,this.F,a,0)[wd](i,d);
    return a+d[B]-1
    };

N.addRows=function(a){
    if(typeof a==L||typeof a==vl&&a[Lc]==oa)return this.insertRows(this.F[B],a);else e(l("Argument given to addRows must be either a number or an array"))
        };
N.addRow=function(a){
    if(typeof a==vl&&a[Lc]==oa)return this[jc]([a]);
    else if(typeof a=="undefined"||a==i)return this[jc](1);else e(l("If argument is given to addRow, it must be an array, or null"))
        };

N.getColumnRange=function(a){
    return Gr(this,a)
    };

N.getSortedRows=function(a){
    return Hr(this,a)
    };

N.sort=function(a){
    var a=Cr(this,a),b=this;
    Ko(this.F,function(c,d){
        for(var f=0;f<a[B];f++){
            var h=a[f],j=h.column,m=c.c[j],q=d.c[j],m=m?m.v:i,q=q?q.v:i,j=Fr(b[y](j),m,q);
            if(j!=0)return j*(h.desc?-1:1)
                }
                return 0
        })
    };
N.toJSON=function(){
    return qr({
        cols:this.B,
        rows:this.F,
        p:this.Va
        })
    };

N.getDistinctValues=function(a){
    return Ir(this,a)
    };

N.getFilteredRows=function(a){
    return Kr(this,a)
    };

N.removeRows=function(a,b){
    b<=0||(Dr(this,a),a+b>this.F[B]&&(b=this.F[B]-a),this.F[Hd](a,b))
    };

N.removeRow=function(a){
    this.removeRows(a,1)
    };

N.removeColumns=function(a,b){
    if(!(b<=0)){
        T(this,a);
        a+b>this.B[B]&&(b=this.B[B]-a);
        this.B[Hd](a,b);
        for(var c=0;c<this.F[B];c++)this.F[c].c[Hd](a,b)
            }
        };
N.removeColumn=function(a){
    this.removeColumns(a,1)
    };

function Or(a){
    var b=a.version||nf;
    this.hj=Oo(Pr,b)?b:nf;
    this.$e=a.status;
    this.nb=[];
    this.ob=[];
    this.ob=a.warnings||[];
    this.nb=a[Cd]||[];
    Qr(this.ob);
    Qr(this.nb);
    if(this.$e!=bj)this.Jg=a.sig,this.h=new U(a.table,this.hj)
        }
        function Qr(a){
    for(var b=0;b<a[B];b++){
        var c=a[b].detailed_message;
        if(c){
            var d=a[b];
            c=c?c[Db](Rr)&&!c[Db](Sr)?c:c[t](/&/g,fe)[t](/</g,he)[t](/>/g,ge)[t](/\"/g,ie):J;
            d.detailed_message=c
            }
        }
    }
var Rr=/^[^<]*(<a(( )+target=('_blank')?("_blank")?)?( )+(href=('[^']*')?("[^"]*")?)>[^<]*<\/a>[^<]*)*$/,Sr=/javascript((s)?( )?)*:/,Pr={
    qm:mf,
    rm:nf
};

N=Or[C];
N.Jg=i;
N.h=i;
N.isError=function(){
    return this.$e==bj
    };

N.hasWarning=function(){
    return this.$e==fn
    };

N.containsReason=function(a){
    for(var b=0;b<this.nb[B];b++)if(this.nb[b].reason==a)return!0;for(b=0;b<this.ob[B];b++)if(this.ob[b].reason==a)return!0;return!1
    };

N.getDataSignature=function(){
    return this.Jg
    };

N.getDataTable=function(){
    return this.h
    };
N.Cf=function(a){
    if(this[Jb]()&&this.nb&&this.nb[0]&&this.nb[0][a])return this.nb[0][a];
    if(this.hasWarning()&&this.ob&&this.ob[0]&&this.ob[0][a])return this.ob[0][a];
    return i
    };

N.getReasons=function(){
    var a=this.Cf(Tl);
    return xn(a)&&a!=J?[a]:[]
    };

N.getMessage=function(){
    return this.Cf(cl)||J
    };

N.getDetailedMessage=function(){
    return this.Cf(Ni)||J
    };

function Tr(a,b){
    var c=b||{};

    this.gf=c.sendMethod||$h;
    Oo(Ur,this.gf)||e(l("Send method not supported: "+this.gf));
    this.Kg=c.makeRequestParams_||{};

    uo(a)&&(a=this.Ck(a));
    var d=a,c=uo(d),d=ko(d[Db](jo)[5]||i),d=oo[Za](d);
    this.Xj=c&&d;
    this.Wj=a;
    this.Ag=Vr++;
    Wr[r](this)
    }
    var Ur={
    tm:kn,
    um:ln,
    nm:"scriptInjection",
    km:Xk,
    cm:$h
},Xr=new cq({
    "X-DataSource-Auth":Jh
}),Vr=0,Yr={};

Tr[C].vh=30;
var Wr=[],Zr=O.gadgets;
function $r(){
    for(var a=0;a<Wr[B];a++){
        var b=Wr[a];
        b.kf&&b.Kd()
        }
    }
    N=Tr[C];
N.Ck=function(a){
    a=new hr(a);
    a.La==433&&a.xc(i);
    var b=a.na,b=b[t](/\/ccc$/,hf);
    /\/pub$/[Za](b)&&(b=b[t](/\/pub$/,hf),a.nd(Nl,rf));
    a.wc(b);
    return a[sc]()
    };

function as(a){
    a[$c].Hg()?(a=Xn(a[$c].Zk()),a[Db](/^({.*})$/)?(a=ur(a),bs(a)):Qn(vr(a))):e(l("google.visualization.Query: "+a[$c].Yk()))
    }
    function bs(a){
    var b=a.reqId,c=Yr[b];
    c?(Yr[b]=i,c.Rd(a)):e(l("Missing query for request id: "+b))
    }
    N.mf=i;
N.Pd=i;
N.Yd=i;
N.Ma=i;
N.cf=i;
N.qc=i;
N.kf=!0;
N.Ab=0;
N.Te=i;
N.Ca=!1;
N.setRefreshInterval=function(a){
    (typeof a!=L||a<0)&&e(l("Refresh interval must be a non-negative number"));
    this.Ab=a;
    this.wh()
    };

N.jf=function(){
    if(this.Yd)ca[ab](this.Yd),this.Yd=i
        };

N.Hk=function(){
    this.Th(Jm,ah)
    };

N.Th=function(a,b,c){
    this.Rd({
        version:nf,
        status:bj,
        errors:[{
            reason:a,
            message:b,
            detailed_message:c
        }]
        })
    };
N.$j=function(a){
    var b={};

    this.Ma&&(b.tq=ja(this.Ma));
    var c=Wl+ja(this.Ag),d=this.Te;
    d&&(c+=Cf+d);
    this.cf&&(c+=Df+this.cf);
    b.tqx=c;
    if(this.qc){
        var c=[],f;
        for(f in this.qc)c[r](f+Af+this.qc[f]);b.tqh=c[I](Bf)
        }
        f=a;
    a=f[v](Yd);
    a!=-1&&(f=f[ud](0,a));
    c=f[v](Nf);
    d=a=J;
    d=[];
    c==-1?a=f:(a=f[ud](0,c),d=f[ud](c+1),d=d[Jc](ee));
    f=[];
    for(c=0;c<d[B];c++){
        var h={};

        h.name=d[c][Jc](Lf)[0];
        h.ff=d[c];
        f[r](h)
        }
        for(var j in b){
        d=b[j];
        h=!1;
        for(c=0;c<f[B];c++)if(f[c][gc]==j){
            f[c].ff=j+Lf+ba(d);
            h=!0;
            break
        }
        if(!h)c={},c.name=
            j,c.ff=j+Lf+ba(d),f[r](c)
            }
            b=a;
    if(f[B]>0){
        b+=Nf;
        j=[];
        for(c=0;c<f[B];c++)j[r](f[c].ff);
        b+=j[I](ee)
        }
        a=b;
    this.Ab&&(b=new hr(a),b.Uj(),a=b[sc]());
    return a
    };
N.Kd=function(){
    var a=this.$j(this.Wj);
    Yr[ja(this.Ag)]=this;
    var b=this.gf,c=pg;
    b==ln&&(b=kn,c=Yg);
    if(b==$h)if(/[?&]alt=gviz(&[^&]*)*$/[Za](a))b=Xk;
        else{
        var b=a.search(lo),d;
            b:{
            for(d=0;(d=a[v](Pm,d))>=0&&d<b;){
                var f=a[qd](d-1);
                if(f==38||f==63)if(f=a[qd](d+4),!f||f==61||f==38||f==35)break b;
                d+=5
                }
                d=-1
            }
            if(d<0)b=i;
        else{
            f=a[v](ee,d);
            if(f<0||f>b)f=b;
            d+=5;
            b=la(a[pc](d,f-d)[t](/\+/g,Pd))
            }
            b=b||$h;
        Oo(Ur,b)||(b=$h)
        }
        if(b==Xk)wn(oj)?this.dk(a,this.Kg):e(l("gadgets.io.makeRequest is not defined."));
    else{
        if(!(d=
            b==kn)){
            if(b=b==$h)d=(new hr(O[Oc][td])).ck(new hr(a))[sc](),b=O[Oc][td][Db](jo),d=d[Db](jo),b=b[3]==d[3]&&b[1]==d[1]&&b[4]==d[4];
            d=b
            }
            d?(b=g,d=a,c==Yg&&(a=a[Jc](Nf),a[B]>=1&&(d=a[0]),a[B]>=2&&(b=a[1])),dr[Gb](d,as,c,b,Xr)):(c=n[lc](fi)[0],b=this.Te===i,this.Xj&&b?(b=n[Lb](Dk),this.bk(b,a),c[Sa](b)):this.lf(a))
        }
    };

N.bk=function(a,b){
    var c=this;
    a.onerror=function(){
        c.lf(b)
        };

    a.onload=function(){
        c.lf(b)
        };

    Qa(a[Uc],sl);
    a.src=b+je+(new Date)[ic]()
    };
N.dk=function(a,b){
    if(b[Zr.io[jb].CONTENT_TYPE]==i)b[Zr.io[jb].CONTENT_TYPE]=Zr.io.ContentType.TEXT;
    if(b[Zr.io[jb].AUTHORIZATION]==i)b[Zr.io[jb].AUTHORIZATION]=Zr.io.AuthorizationType.SIGNED;
    b.OAUTH_ENABLE_PRIVATE_NETWORK==i&&(b.OAUTH_ENABLE_PRIVATE_NETWORK=!0);
    b.OAUTH_ADD_EMAIL==i&&(b.OAUTH_ADD_EMAIL=!0);
    Zr.io.makeRequest(a,Nn(this.ml,this),b);
    this.Gh()
    };

N.ml=function(a){
    if(a!=i&&a.data)Qn(vr(a.data));
    else{
        var b=J;
        a&&a[Cd]&&(b=a[Cd][I](Pd));
        this.Th(Yk,pj,b)
        }
    };

N.lf=function(a){
    this.Gh();
    Rn(a);
    this.wh()
    };
N.Gh=function(){
    var a=this;
    this.jf();
    this.Yd=ca[Fc](function(){
        a.Hk()
        },this.vh*1E3)
    };

N.Xg=function(){
    if(this.Pd)ca[ab](this.Pd),this.Pd=i
        };

N.wh=function(){
    this.Xg();
    if(this.Ab!=0&&this.kf&&this.Ca){
        var a=this;
        this.Pd=ca[Fc](function(){
            a.Kd()
            },this.Ab*1E3)
        }
    };

N.send=function(a){
    this.Ca=!0;
    this.mf=a;
    this.Kd()
    };

N.makeRequest=function(a,b){
    this.Ca=!0;
    this.mf=a;
    this.Wl=Xk;
    this.Kg=b||{};

    this.Kd()
    };

N.abort=function(){
    this.Ca=!1;
    this.jf();
    this.Xg()
    };
N.Rd=function(a){
    this.jf();
    a=new Or(a);
    if(!a.containsReason(tl)){
        this.Te=a[Jb]()?i:a.getDataSignature();
        var b=this.mf;
        b[F](b,a)
        }
    };

N.setTimeout=function(a){
    (typeof a!=L||ma(a)||a<=0)&&e(l("Timeout must be a positive number"));
    this.vh=a
    };

N.setRefreshable=function(a){
    typeof a!=gi&&e(l("Refreshable must be a boolean"));
    return this.kf=a
    };

N.setQuery=function(a){
    typeof a!=M&&e(l("queryString must be a string"));
    this.Ma=a
    };

N.Tl=function(a){
    this.cf=a;
    a!=i&&this.Kh(Sm,a)
    };
N.Kh=function(a,b){
    a=a[t](/\\/g,zh);
    b=b[t](/\\/g,zh);
    a=a[t](/:/g,Ah);
    b=b[t](/:/g,Ah);
    a=a[t](/;/g,Bh);
    b=b[t](/;/g,Bh);
    if(!this.qc)this.qc={};

    this.qc[a]=b
    };

function cs(){
    var a;
    ds||(ds=!0,O.IDIModule&&O.IDIModule.registerListener($r,{
        pollingInterval:100
    }),O.gadgets&&(es(Ze),this.Fh()));
    a=n;
    a=a.querySelectorAll&&a.querySelector&&(!ep||Ip(n)||sp(xf))?a.querySelectorAll(Uf):a[lc](Uf);
    this.ql=Sn(a[0])
    }
    var ds=!1;
cs[C].Nh=200;
function fs(){
    return!!O.gadgets&&!!O.gadgets.rpc
    }
    cs[C].Fh=function(){
    if(fs()){
        var a=O.gadgets;
        Gn(a.rpc.register)&&a.rpc.register(Ul,$r)
        }else this.Nh>0&&(this.Nh--,ca[Fc](Nn(this.Fh,this),100))
        };
cs[C].createQueryFromPrefs=function(a){
    var b=a.getString(Ih),c=b[Jd]();
    if(c[v](vk)==0||c[v](Ak)==0)b=la(b);
    b=new Tr(b);
    a=a.getInt(Hh);
    b[$b](a);
    return b
    };

cs[C].validateResponse=function(a){
    return this.ql(a)
    };

function es(a){
    if(fs()){
        var b=O.gadgets;
        try{
            b.rpc.getRelayUrl(a)||b.rpc.setRelayUrl(a,yk)
            }catch(c){
            Gn(b.rpc.setRelayUrl)&&b.rpc.setRelayUrl(a,yk)
            }
        }
}
O.gadgets&&!fs()&&Rn("http://www.gmodules.com/gadgets/rpc/rpc.v.js");
es(Ze);
function gs(a){
    var b=a.__eventTarget;
    if(!xn(b))b=new Rq,a.__eventTarget=b;
    return a=b
    }
    function hs(a){
    return function(b){
        a(b.Pl)
        }
    }
function is(a){
    this.wa=a
    }
    is[C].Kk=function(){
    return this.wa
    };

function js(a,b){
    jq[F](this,a);
    this.Pl=b
    }
    R(js,jq);
function ks(a,b,c,d){
    this.Ma=a;
    this.fb=b;
    this.V=c||{};

    this.Zb=d;
    this.Hc=i;
    if(d)this.Hc=this.af=Sn(d);
    (!b||!(Yi in b)||typeof b[gd]!=mj)&&e(l("Visualization must have a draw method."))
    }
    N=ks[C];
N.af=i;
N.dh=i;
N.fh=i;
N.h=i;
N.setOptions=function(a){
    this.V=a||{}
};

N.draw=function(){
    this.h&&this.fb[gd](this.h,this.V)
    };

N.Rl=function(a){
    var b=this.Zb;
    this.Hc=a?a:b?this.Hc=this.af:i
    };
N.sendAndDraw=function(){
    this.Hc||e(l("If no container was supplied, a custom error handler must be supplied instead."));
    var a=this;
    this.Ma[Gb](function(b){
        var c=a.dh;
        c&&c(b);
        a.Rd(b);
        (c=a.fh)&&c(b)
        })
    };

N.Rd=function(a){
    var b=this.Hc;
    if(b(a))this.h=a[qb](),this.fb[gd](this.h,this.V)
        };

N.setCustomResponseHandler=function(a){
    a==i?this.bm=i:(typeof a!=mj&&e(l("Custom response handler must be a function.")),this.dh=a)
    };
N.setCustomPostResponseHandler=function(a){
    if(a!=i)typeof a!=mj&&e(l("Custom post response handler must be a function.")),this.fh=a
        };

N.abort=function(){
    this.Ma[Ec]()
    };

function V(a){
    this.h=a;
    for(var b=[],a=a[nb](),c=0;c<a;c++)b[r](c);
    this.t=b;
    this.Ta=!0;
    this.Ra=i;
    this.Ne=[];
    this.Me=!0
    }
    N=V[C];
N.fj=function(){
    for(var a=0;a<this.t[B];a++)En(this.t[a])&&(this.Ne[a]=[]);
    this.Me=!1
    };

N.Kc=function(){
    this.Me=!0
    };

N.jk=function(){
    for(var a=[],b=this.h[xc](),c=0;c<b;c++)a[r](c);
    this.Ra=a;
    this.Kc()
    };
N.setColumns=function(a){
    for(var b=this.h,c=No(ls),d=0;d<a[B];d++){
        var f=a[d];
        if(Fn(f))T(b,f);
        else if(!En(f)||f.calc==i||f[z]==i)e(l('Invalid column input, expected either a number or an object with "calc" and "type" properties.'));
        else{
            var h=f.calc;
            if(Q(h))(!c||c&&!Bo(c,h))&&e(l('Unknown function "'+h+Ud)),f=f.sourceColumn,xn(f)&&T(b,f)
                }
            }
    this.t=Kn(a);
this.Kc()
};
N.$g=function(a,b){
    if(P(a)){
        Bn(b)&&e(l("If the first parameter is an array, no second parameter is expected"));
        for(var c=0;c<a[B];c++)Dr(this.h,a[c]);
        return Eo(a)
        }else if(An(a)==L){
        !An(b)==L&&e(l("If first parameter is a number, second parameter must be specified and be a number."));
        a>b&&e(l("The first parameter (min) must be smaller than or equal to the second parameter (max)."));
        Dr(this.h,a);
        Dr(this.h,b);
        for(var d=[],c=a;c<=b;c++)d[r](c);
        return d
        }else e(l("First parameter must be a number or an array."))
        };
N.setRows=function(a,b){
    this.Ra=this.$g(a,b);
    this.Ta=!1;
    this.Kc()
    };

N.getViewColumns=function(){
    return Kn(this.t)
    };

N.getViewRows=function(){
    if(this.Ta){
        for(var a=[],b=this.h[xc](),c=0;c<b;c++)a[r](c);
        return a
        }
        return Eo(this.Ra)
    };

N.hideColumns=function(a){
    this[Id](yo(this.t,function(b){
        return!Bo(a,b)
        }));
    this.Kc()
    };

N.hideRows=function(a,b){
    var c=this.$g(a,b);
    if(this.Ta)this.jk(),this.Ta=!1;
    this.setRows(yo(this.Ra,function(a){
        return!Bo(c,a)
        }));
    this.Kc()
    };
N.getViewColumnIndex=function(a){
    return wo(this.t,a)
    };

N.getViewRowIndex=function(a){
    if(this.Ta){
        if(a<0||a>=this.h[xc]())return-1;
        return a
        }
        return wo(this.Ra,a)
    };

N.getTableColumnIndex=function(a){
    T(this,a);
    a=this.t[a];
    return Fn(a)?a:-1
    };

N.getUnderlyingTableColumnIndex=function(a){
    a=this.getTableColumnIndex(a);
    if(a==-1)return a;
    Gn(this.h.getUnderlyingTableColumnIndex)&&(a=this.h.getUnderlyingTableColumnIndex(a));
    return a
    };

N.getTableRowIndex=function(a){
    Dr(this,a);
    return this.Ta?a:this.Ra[a]
    };
N.getUnderlyingTableRowIndex=function(a){
    a=this[Ub](a);
    Gn(this.h.getUnderlyingTableRowIndex)&&(a=this.h.getUnderlyingTableRowIndex(a));
    return a
    };

N.getNumberOfRows=function(){
    return this.Ta?this.h[xc]():this.Ra[B]
    };

N.getNumberOfColumns=function(){
    return this.t[B]
    };

N.getColumnId=function(a){
    T(this,a);
    a=this.t[a];
    return Fn(a)?this.h.getColumnId(a):a.id
    };

N.getColumnIndex=function(a){
    for(var b=0;b<this.t[B];b++){
        var c=this.t[b];
        if(En(c)&&c.id==a)return b
            }
            return this.getViewColumnIndex(this.h.getColumnIndex(a))
    };
N.getColumnLabel=function(a){
    T(this,a);
    a=this.t[a];
    return Fn(a)?this.h[Mb](a):a[Fd]
    };

N.getColumnPattern=function(a){
    T(this,a);
    a=this.t[a];
    return Fn(a)?this.h[Nc](a):i
    };

N.getColumnType=function(a){
    T(this,a);
    a=this.t[a];
    return Fn(a)?this.h[y](a):a[z]
    };

Ea(N,function(a,b){
    T(this,b);
    var c=this[Ub](a),d=this.t[b];
    return Fn(d)?this.h[A](c,d):this.kj(c,b)
    });
N.kj=function(a,b){
    this.Me&&this.fj();
    var c=this.Ne[b][a];
    if(!Bn(c)){
        var c=this.t[b],d=c.calc;
        Q(d)?(d=ls[d],c=d(this.h,a,c.sourceColumn)):c=d[F](i,this.h,a);
        this.Ne[b][a]=c
        }
        return c
    };

N.getFormattedValue=function(a,b){
    T(this,b);
    var c=this.t[b];
    return En(c)?Lr(this[A](a,b),this[y](b)):Fn(c)?this.h[Bd](this[Ub](a),c):J
    };

N.getProperty=function(a,b,c){
    T(this,b);
    b=this.t[b];
    return Fn(b)?this.h[vb](this[Ub](a),b,c):i
    };
N.getProperties=function(a,b){
    T(this,b);
    var c=this.t[b];
    return Fn(c)?this.h[zc](this[Ub](a),c):{}
};

N.getColumnProperty=function(a,b){
    T(this,a);
    var c=this.t[a];
    return Fn(c)?this.h[Kc](c,b):i
    };

N.getColumnProperties=function(a){
    T(this,a);
    a=this.t[a];
    return Fn(a)?this.h[xb](a):{}
};

N.getTableProperty=function(a){
    return this.h.getTableProperty(a)
    };

N.getTableProperties=function(){
    return this.h[Zb]()
    };

N.getRowProperty=function(a,b){
    return this.h.getRowProperty(this[Ub](a),b)
    };
N.getRowProperties=function(a){
    Dr(this,a);
    return this.h[Yb](this[Ub](a))
    };

N.getColumnRange=function(a){
    return Gr(this,a)
    };

N.getDistinctValues=function(a){
    return Ir(this,a)
    };

N.getSortedRows=function(a){
    return Hr(this,a)
    };

N.getFilteredRows=function(a){
    return Kr(this,a)
    };
N.toDataTable=function(){
    var a=this.h;
    Gn(a[Nb])&&(a=a[Nb]());
    var a=tr(a[Bc]()),b=this[nb](),c=this[xc](),d,f,h,j=[],m=[];
    for(d=0;d<b;d++){
        h=this.t[d];
        if(En(h)){
            f={};

            var q=g;
            for(q in h)f[q]=h[q];delete f.calc
            }else Fn(h)?f=a.cols[h]:e(l(Cg));
        j[r](f)
        }
        for(f=0;f<c;f++){
        var q=a.rows[this.Ta?f:this.Ra[f]],u=[];
        for(d=0;d<b;d++){
            h=this.t[d];
            var D;
            En(h)?D={
                v:this[A](f,d)
                }:Fn(h)?D=q.c[this.t[d]]:e(l(Cg));
            u[r](D)
            }
            q.c=u;
        m[r](q)
        }
        a.cols=j;
    a.rows=m;
    return a=new U(a)
    };
N.toJSON=function(){
    for(var a={},b=[],c=0;c<this.t[B];c++){
        var d=this.t[c];
        (!En(d)||Q(d.calc))&&b[r](d)
        }
        b[B]==0||(a.columns=b);
    this.Ta||(a.rows=Eo(this.Ra));
    return qr(a)
    };

var ls={
    emptyString:function(){
        return J
        },
    toString:function(a,b,c){
        return a[Bd](b,c)
        },
    fillFromTop:function(a,b,c){
        return Mr(a,b,c,!0)
        },
    fillFromBottom:function(a,b,c){
        return Mr(a,b,c,!1)
        }
    };

var X={
    Af:"google-visualization-errors"
};

X.vg=X.Af+ye;
X.Bh=X.Af+Af;
X.tf=X.Af+"-all-";
X.Ke=X.Bh+" container is null";
X.Oi="background-color: #c00000; color: white; padding: 2px;";
X.Qi="background-color: #fff4c2; color: black; white-space: nowrap; padding: 2px; border: 1px solid black;";
X.Ri="font: normal 0.8em arial,sans-serif; margin-bottom: 5px;";
X.Pi="font-size: 1.1em; color: #0000cc; font-weight: bold; cursor: pointer; padding-left: 10px; color: black;text-align: right; vertical-align: top;";
X.ug=0;
X.addError=function(a,b,c,d){
    X.Le(a)||e(l(X.Ke+". message: "+b));
    var c=X.Ti(b,c,d),f=c.errorMessage,b=c.detailedMessage,c=c.options,h=xn(c.showInTooltip)?!!c.showInTooltip:!0,j=(c[z]==fn?fn:bj)==bj?X.Oi:X.Qi;
    j+=c[Uc]?c[Uc]:J;
    var m=!!c.removable,d=Bp(),f=d.d(um,{
        style:j
    },d[mb](f)),j=X.vg+X.ug++,q=d.d(Vi,{
        id:j,
        style:X.Ri
        },f);
    if(b)h?f.title=b:(h=n[Lb](um),ra(h,b),d[Sa](q,d.d(Vi,{
        style:Fl
    },h)));
    if(m)b=d.d(um,{
        style:X.Pi
        },d[mb](sn)),b.onclick=On(X.Pe,q),d[Sa](f,b);
    X.Si(a,q);
    c.removeDuplicates&&X.Ui(a,
        q);
    return j
    };

X.removeAll=function(a){
    X.Le(a)||e(l(X.Ke));
    if(a=X.rf(a,!1))Qa(a[Uc],sl),Pp(a)
        };

X.addErrorFromQueryResponse=function(a,b){
    X.Le(a)||e(l(X.Ke));
    b||e(l(X.Bh+" response is null"));
    if(!b[Jb]()&&!b.hasWarning())return i;
    var c=b.getReasons(),d=!0;
    b[Jb]()&&(d=!(Bo(c,Xm)||Bo(c,Hk)));
    var c=b.getMessage(),f=b.getDetailedMessage(),d={
        showInTooltip:d
    };

    Ca(d,b[Jb]()?bj:fn);
    d.removeDuplicates=!0;
    return X[Ac](a,c,f,d)
    };

X.removeError=function(a){
    a=n[hb](a);
    if(X.uf(a))return X.Pe(a),!0;
    return!1
    };
X.getContainer=function(a){
    a=n[hb](a);
    if(X.uf(a))return a[Dd][Dd];
    return i
    };

X.createProtectedCallback=function(a,b){
    return function(){
        try{
            a[wd](i,arguments)
            }catch(c){
            Gn(b)?b(c):google[Qc][Cd][Ac](b,c[Sc])
            }
        }
};

X.Pe=function(a){
    var b=a[Dd];
    Qp(a);
    b[ac][B]==0&&Qa(b[Uc],sl)
    };

X.uf=function(a){
    if(Np(a)&&a.id&&a.id[fd](X.vg,0)==0&&(a=a[Dd])&&a.id&&a.id[fd](X.tf,0)==0&&a[Dd])return!0;
    return!1
    };
X.Ti=function(a,b,c){
    var d=xn(a)&&a?a:bj,f=J,h={},j=arguments[B];
    j==2?b&&An(b)==vl?h=b:f=xn(b)?b:f:j==3&&(f=xn(b)?b:f,h=c||{});
    d=Xn(d);
    f=Xn(f);
    return{
        errorMessage:d,
        detailedMessage:f,
        options:h
    }
};

X.Le=function(a){
    return xn(a)&&Np(a)
    };

X.rf=function(a,b){
    for(var c=a[ac],d=i,f=Bp(),h=0;h<c[B];h++)if(c[h].id&&c[h].id[fd](X.tf,0)==0){
        d=c[h];
        f.removeNode(d);
        break
    }!d&&b&&(d=X.tf+X.ug++,d=Kp(Vi,{
        id:d,
        style:Ui
    },i));
    d&&((c=a[Qb])?f.Xk(d,c):f[Sa](a,d));
    return d
    };
X.Si=function(a,b){
    var c=X.rf(a,!0);
    Qa(c[Uc],di);
    c[Sa](b)
    };

X.il=function(a,b){
    var c=X.rf(a,!0);
    xo(c&&c[ac],function(a){
        X.uf(a)&&b(a)
        })
    };

X.Ui=function(a,b){
    var c=/id="?google-visualization-errors-[0-9]*"?/,d=Tp(b),d=d[t](c,J),f=[];
    X.il(a,function(a){
        if(a!=b){
            var j=Tp(a),j=j[t](c,J);
            j==d&&f[r](a)
            }
        });
xo(f,X.Pe);
return f[B]
};

function ms(a,b,c,d){
    this.top=a;
    this.right=b;
    this.bottom=c;
    ua(this,d)
    }
    Na(ms[C],function(){
    return new ms(this.top,this[Kd],this[sd],this[x])
    });
Pa(ms[C],function(a){
    a=!this||!a?!1:a instanceof ms?a[x]>=this[x]&&a[Kd]<=this[Kd]&&a.top>=this.top&&a[sd]<=this[sd]:a.x>=this[x]&&a.x<=this[Kd]&&a.y>=this.top&&a.y<=this[sd];
    return a
    });
function ns(a,b,c,d){
    ua(this,a);
    this.top=b;
    pa(this,c);
    Ra(this,d)
    }
    Na(ns[C],function(){
    return new ns(this[x],this.top,this[s],this[H])
    });
ns[C].qj=function(a){
    var b=p.max(this[x],a[x]),c=p.min(this[x]+this[s],a[x]+a[s]);
    if(b<=c){
        var d=p.max(this.top,a.top),a=p.min(this.top+this[H],a.top+a[H]);
        if(d<=a)return ua(this,b),this.top=d,pa(this,c-b),Ra(this,a-d),!0
            }
            return!1
    };
Pa(ns[C],function(a){
    return a instanceof ns?this[x]<=a[x]&&this[x]+this[s]>=a[x]+a[s]&&this.top<=a.top&&this.top+this[H]>=a.top+a[H]:a.x>=this[x]&&a.x<=this[x]+this[s]&&a.y>=this.top&&a.y<=this.top+this[H]
    });
function os(a,b){
    var c=Dp(a);
    if(c[bc]&&c[bc].getComputedStyle&&(c=c[bc].getComputedStyle(a,i)))return c[b]||c.getPropertyValue(b);
    return J
    }
    function ps(a,b){
    return os(a,b)||(a.currentStyle?a.currentStyle[b]:i)||a[Uc][b]
    }
    function qs(a,b,c){
    var d,f=dp&&(Yo||ip)&&sp(tf);
    b instanceof Tn?(d=b.x,b=b.y):(d=b,b=c);
    ua(a[Uc],rs(d,f));
    a[Uc].top=rs(b,f)
    }
    function ss(a){
    var b=a[Va]();
    if(S)a=a.ownerDocument,b.left-=a[oc][Tb]+a[Wc][Tb],b.top-=a[oc][Wb]+a[Wc][Wb];
    return b
    }
function ts(a){
    if(S)return a.offsetParent;
    for(var b=Dp(a),c=ps(a,Jl),d=c==fj||c==Lh,a=a[Dd];a&&a!=b;a=a[Dd])if(c=ps(a,Jl),d=d&&c==ym&&a!=b[oc]&&a!=b[Wc],!d&&(a.scrollWidth>a[Dc]||a[Ob]>a[nd]||c==fj||c==Lh||c==Vl))return a;return i
    }
function us(a){
    for(var b=new ms(0,fa,fa,0),c=Bp(a),d=c.m[Wc],f=c.gk(),h;a=ts(a);)if((!S||a[Dc]!=0)&&(!ep||a[nd]!=0||a!=d)&&(a.scrollWidth!=a[Dc]||a[Ob]!=a[nd])&&ps(a,Dl)!=cn){
        var j=vs(a),m;
        m=a;
        if(dp&&!sp(tf)){
            var q=ha(os(m,ii));
            if(ws(m)){
                var u=m.offsetWidth-m[Dc]-q-ha(os(m,ji));
                q+=u
                }
                m=new Tn(q,ha(os(m,ki)))
            }else m=new Tn(m[Tb],m[Wb]);
        j.x+=m.x;
        j.y+=m.y;
        b.top=p.max(b.top,j.y);
        b.right=p.min(b[Kd],j.x+a[Dc]);
        b.bottom=p.min(b[sd],j.y+a[nd]);
        ua(b,p.max(b[x],j.x));
        h=h||a!=f
        }
        d=f[od];
    f=f[rc];
    ep?(b.left+=d,
        b.top+=f):(ua(b,p.max(b[x],d)),b.top=p.max(b.top,f));
    if(!h||ep)b.right+=d,b.bottom+=f;
    c=c.hk();
    b.right=p.min(b[Kd],d+c[s]);
    b.bottom=p.min(b[sd],f+c[H]);
    return b.top>=0&&b[x]>=0&&b[sd]>b.top&&b[Kd]>b[x]?b:i
    }
function vs(a){
    var b,c=Dp(a),d=ps(a,Jl),f=dp&&c[Fb]&&!a[Va]&&d==Lh&&(b=c[Fb](a))&&(b[Bb]<0||b[Cb]<0),h=new Tn(0,0),j;
    b=c?c[eb]==9?c:Dp(c):n;
    j=S&&!sp(9)&&!Bp(b).Lg()?b[Wc]:b[oc];
    if(a==j)return h;
    if(a[Va])b=ss(a),a=Bp(c).Yb(),h.x=b[x]+a.x,h.y=b.top+a.y;
    else if(c[Fb]&&!f)b=c[Fb](a),a=c[Fb](j),h.x=b[Bb]-a[Bb],h.y=b[Cb]-a[Cb];
    else{
        b=a;
        do{
            h.x+=b.offsetLeft;
            h.y+=b[Gd];
            b!=a&&(h.x+=b[Tb]||0,h.y+=b[Wb]||0);
            if(ep&&ps(b,Jl)==fj){
                h.x+=c[Wc][od];
                h.y+=c[Wc][rc];
                break
            }
            b=b.offsetParent
            }while(b&&b!=a);
        if(cp||ep&&d==
            Lh)h.y-=c[Wc][Gd];
        for(b=a;(b=ts(b))&&b!=c[Wc]&&b!=j;)if(h.x-=b[od],!cp||b[yd]!=kh)h.y-=b[rc]
            }
            return h
    }
    function xs(a,b,c){
    b instanceof Vn?(c=b[H],b=b[s]):c==g&&e(l("missing height argument"));
    pa(a[Uc],rs(b,!0));
    Ra(a[Uc],rs(c,!0))
    }
    function rs(a,b){
    typeof a==L&&(a=(b?p[cb](a):a)+Ol);
    return a
    }
function ys(a){
    if(ps(a,Ti)!=sl)return new Vn(a.offsetWidth,a.offsetHeight);
    var b=a[Uc],c=b.display,d=b.visibility,f=b.position;
    Ha(b,pk);
    b.position=Lh;
    Qa(b,Ek);
    var h=a.offsetWidth,a=a.offsetHeight;
    Qa(b,c);
    b.position=f;
    Ha(b,d);
    return new Vn(h,a)
    }
    function zs(a){
    var b=vs(a),a=ys(a);
    return new ns(b.x,b.y,a[s],a[H])
    }
    function As(a,b){
    var c=a[Uc];
    if(xl in c)c.opacity=b;
    else if(Rg in c)c.MozOpacity=b;
    else if(ej in c)c.filter=b===J?J:Uh+b*100+te
        }
        function Bs(a,b){
    Qa(a[Uc],b?J:sl)
    }
function ws(a){
    return bm==ps(a,Qi)
    }
    var Cs=dp?"MozUserSelect":ep?"WebkitUserSelect":i;
function Ds(a,b,c){
    c=!c?a[lc](ue):i;
    if(Cs){
        if(b=b?sl:J,a[Uc][Cs]=b,c)for(var a=0,d;d=c[a];a++)d[Uc][Cs]=b
            }else if(S||cp)if(b=b?wl:J,a[Vb](Wm,b),c)for(a=0;d=c[a];a++)d[Vb](Wm,b)
        };

function Es(){
    var a=wn(fk);
    xn(a)||(a=xk);
    var b=wn(ik);
    xn(b)||(b=sf);
    return a+gf+b
    }
    function Fs(a){
    for(var b=Es()+a,a=n[lc](Jg),c=0;c<a[B];c++)if(a[c]&&a[c][td]&&a[c][td]==b)return;a=n[Lb](Tk);
    a.href=b;
    a.rel=Am;
    Ca(a,Em);
    if(n[lc](nk)[B]==0){
        var b=n[lc](tk)[0],c=n[lc](fi)[0],d=n[Lb](nk);
        b[sb](d,c)
        }
        n[lc](nk)[0][Sa](a)
    };

function Gs(a,b){
    this.start=a<b?a:b;
    this.end=a<b?b:a
    }
    Na(Gs[C],function(){
    return new Gs(this[ed],this.end)
    });
function Hs(a,b){
    return a[ed]<=b&&a.end>=b
    };

function Is(){}
N=Is[C];
N.W=function(a){
    (!En(a)||!Gn(a[nb])||!Gn(a[xc]))&&e(l("Invalid data table."))
    };

N.ek=function(a){
    this.W(a);
    a=new google[Qc][jd](a);
    if(this.R(a))return a;
    a=this.Qj(a);
    a=this.Ob(a);
    a=this.Ug(a);
    return this.R(a)?a:i
    };

N.e=function(a,b,c){
    return c==a[y](b)
    };

N.indexOf=function(a,b){
    for(var c=0;c<a[nb]();c++)if(a[y](c)==b)return c;return-1
    };

N.Ue=function(a,b){
    return this.e(a,b,L)?this.Jb(a,b,function(a){
        return a>=0
        }):!1
    };
N.Jb=function(a,b,c){
    for(var d=p.min(a[xc](),20),f=0;f<d;f++){
        var h=a[A](f,b);
        if(h!=i&&!c(h))return!1
            }
            return!0
    };

N.Fg=function(a,b,c){
    if(!this.e(a,b,L))return!1;
    if(!this.e(a,c,L))return!1;
    var d=Nn(this.nj,this),f=Nn(this.oj,this);
    return this.Jb(a,b,d)&&this.Jb(a,c,f)
    };

N.nj=function(a){
    return Hs(new Gs(-90,90),a)&&!(ka(a)&&a%1==0)
    };

N.oj=function(a){
    return Hs(new Gs(-180,180),a)&&!(ka(a)&&a%1==0)
    };

N.Fa=function(a,b){
    var c=new google[Qc][jd](a);
    c[Id](b);
    return c
    };
N.ua=function(a,b){
    for(var c=a[nb](),d=0;d<c;d++)b(d)
        };

N.Cd=function(a,b){
    var c=this,d=0;
    this.ua(a,function(f){
        c.e(a,f,b)&&d++
    });
    return d
    };

N.Ob=function(a){
    var b=this,c=[],d=this.Cd(a,M);
    this.ua(a,function(f){
        b.e(a,f,L)?c[r](f):b.e(a,f,M)&&d==1&&c[r](f)
        });
    return this.Fa(a,c)
    };

N.Ug=function(a){
    if(this.Cd(a,M)==1){
        var b=this[v](a,M),c=[b];
        this.ua(a,function(a){
            a!=b&&c[r](a)
            });
        a=this.Fa(a,c)
        }
        return a
    };
N.Qj=function(a){
    var b=this,c=[];
    this.ua(a,function(d){
        b.e(a,d,M)?b.Jb(a,d,function(a){
            return/^[\s\xa0]*$/[Za](a)
            })||c[r](d):c[r](d)
        });
    return this.Fa(a,c)
    };

N.Bg=function(a){
    for(var b=a.getDistinctValues(0),c=p.min(a[xc](),20),d=0,f=0;f<c;f++){
        var h=a[A](f,1);
        (!h||Bo(b,h))&&d++
    }
    return d/c>0.6
    };

function Js(){}
R(Js,Is);
Js[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b<2)return!1;
    var c=a[y](0);
    if(c!=Ii&&c!=Ji)return!1;
    if(a[y](1)!=L)return!1;
    for(var c=0,d=1;d<b;d++){
        var f=a[y](d);
        if(f==L)c=0;
        else if(f==M){
            if(c++,c>2)return!1
                }else return!1
            }
            return!0
    };

Js[C].Ob=function(a){
    var b=this,c=[];
    this.ua(a,function(d){
        (b.e(a,d,M)||b.e(a,d,L)||b.e(a,d,Ii)||b.e(a,d,Ji))&&c[r](d)
        });
    return this.Fa(a,c)
    };
Js[C].Ug=function(a){
    var b=0;
    b+=this.Cd(a,Ii);
    b+=this.Cd(a,Ji);
    if(b==1){
        var c=this[v](a,Ii),c=c==-1?this[v](a,Ji):c,d=[c];
        this.ua(a,function(a){
            a!=c&&d[r](a)
            });
        a=this.Fa(a,d)
        }
        return a
    };

function Ks(){}
R(Ks,Is);
Ks[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b==0)return!1;
    for(var c=!this.e(a,0,L)?1:0,d=b>c;c<b;c++)if(!this.e(a,c,L)){
        d=!1;
        break
    }
    return d
    };

function Ls(){}
R(Ls,Is);
Ls[C].R=function(a){
    this.W(a);
    if(a[nb]()!=5)return!1;
    return this.e(a,0,M)&&this.e(a,1,L)&&this.e(a,2,L)&&this.e(a,3,L)&&this.e(a,4,L)
    };

Ls[C].Ob=function(a){
    var b=this,c=[];
    this.ua(a,function(d){
        (b.e(a,d,M)||b.e(a,d,L))&&c[r](d)
        });
    return this.Fa(a,c)
    };

function Ms(){}
R(Ms,Is);
Ms[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b==0)return!1;
    for(var c=!this.e(a,0,L)?1:0,d=b>c;c<b;c++)if(!this.e(a,c,L)){
        d=!1;
        break
    }
    return d
    };

function Ns(){}
R(Ns,Is);
Ns[C].R=function(a){
    return(new Ms).R(a)
    };

function Os(){}
R(Os,Is);
Os[C].R=function(a){
    this.W(a);
    return this.wk(a)||this.xk(a)
    };

Os[C].wk=function(a){
    var b=a[nb]();
    if(b<1||b>2)return!1;
    var c=!0;
    b==2&&(c=c&&this.e(a,0,M));
    return c=c&&this.Ue(a,b-1)
    };

Os[C].xk=function(a){
    var b=a[nb](),c=a[xc]();
    if(b==0||c!=1)return!1;
    for(var c=!0,d=0;d<b;d++)if(!this.e(a,d,L)){
        c=!1;
        break
    }
    return c
    };

function Ps(){}
R(Ps,Is);
Ps[C].R=function(a){
    return this.yf(a)||this.xf(a)
    };

Ps[C].yf=function(a){
    this.W(a);
    var b=a[nb]();
    if(b<2||b>4)return!1;
    var c=this.e(a,0,L),c=c&&this.e(a,1,L);
    b==3&&(c=c&&this.e(a,2,L));
    b==4&&(c=c&&this.e(a,3,M));
    return c&&this.Fg(a,0,1)
    };

Ps[C].xf=function(a){
    var b=a[nb]();
    if(b<1||b>3)return!1;
    var c=this.e(a,0,M);
    b==2&&(c=c&&this.e(a,1,L));
    b==3&&(c=c&&this.e(a,2,M));
    return c
    };

function Qs(){}
R(Qs,Is);
Qs[C].R=function(a){
    return this.yf(a)||this.xf(a)
    };

Qs[C].yf=function(a){
    this.W(a);
    var b=a[nb]();
    if(b<2||b>3)return!1;
    var c=this.e(a,0,L),c=c&&this.e(a,1,L);
    b==3&&(c=c&&this.e(a,2,M));
    return c&&this.Fg(a,0,1)
    };

Qs[C].xf=function(a){
    this.W(a);
    var b=a[nb]();
    if(b<1||b>2)return!1;
    if(!this.e(a,0,M))return!1;
    if(b==2&&!this.e(a,1,M))return!1;
    return!0
    };

function Rs(){}
R(Rs,Is);
Rs[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b<3)return!1;
    if(a[y](0)!=M)return!1;
    var c=a[y](1);
    if(c!=L&&c!=Ii&&c!=M)return!1;
    if(c==M&&!this.mk(a,1)&&!this.lk(a,1))return!1;
    if(c==L&&!this.Jb(a,1,function(a){
        return ka(a)&&a%1==0
        }))return!1;
    for(c=2;c<b;c++){
        var d=a[y](c);
        if(d!=L&&d!=M)return!1
            }
            return!0
    };

Rs[C].mk=function(a,b){
    return this.Jb(a,b,function(a){
        if(a[B]!=7)return!1;
        if(ma(a[ud](0,3)))return!1;
        if(a[lb](4)!=sh)return!1;
        if(ma(a[ud](6,7)))return!1;
        return!0
        })
    };
Rs[C].lk=function(a,b){
    return this.Jb(a,b,function(a){
        if(a[B]!=6)return!1;
        if(ma(a[ud](0,3)))return!1;
        if(a[lb](4)!=$g)return!1;
        if(ma(a[lb](5)))return!1;
        return!0
        })
    };

function Ss(){}
R(Ss,Is);
Ss[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b<2||b>3)return!1;
    var c=this.e(a,0,M)&&this.e(a,1,M);
    b==3&&(c=c&&this.e(a,2,M));
    return c&&this.Bg(a)
    };

Ss[C].Ob=function(a){
    var b=this,c=[];
    this.ua(a,function(d){
        b.e(a,d,M)&&c[r](d)
        });
    return this.Fa(a,c)
    };

function Ts(){}
R(Ts,Is);
Ts[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b<1||b>2)return!1;
    var c=this.e(a,b-1,L);
    return c=c&&this.Ue(a,b-1)
    };

function Us(){}
R(Us,Is);
Us[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b==0)return!1;
    for(var c=this.e(a,0,M)?1:0,d=b>c;c<b;c++)if(!this.e(a,c,L)){
        d=!1;
        break
    }
    return d
    };

function Vs(){}
R(Vs,Is);
Vs[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b<2)return!1;
    if(this.e(a,0,gi)||this.e(a,0,M))return!1;
    for(var c=!this.e(a,0,L)?1:0,d=b>c;c<b;c++)if(!this.e(a,c,L)){
        d=!1;
        break
    }
    return d
    };

Vs[C].Ob=function(a){
    var b=this,c=[];
    this.ua(a,function(d){
        !b.e(a,d,M)&&!b.e(a,d,gi)&&c[r](d)
        });
    return this.Fa(a,c)
    };

function Ws(){}
R(Ws,Is);
Ws[C].R=function(a){
    this.W(a);
    for(var b=!0,c=a[nb](),d=0;d<c;d++)if(!this.e(a,d,L)){
        b=!1;
        break
    }
    return b
    };

Ws[C].Ob=function(a){
    var b=this,c=[];
    this.ua(a,function(d){
        b.e(a,d,L)&&c[r](d)
        });
    return this.Fa(a,c)
    };

function Xs(){}
R(Xs,Is);
Xs[C].R=function(){
    return!0
    };

function Ys(){}
R(Ys,Is);
Ys[C].R=function(a){
    this.W(a);
    var b=a[nb]();
    if(b!=4)return!1;
    var c=this.e(a,0,M)&&this.e(a,1,M);
    b>2&&(c=c&&this.Ue(a,2))&&b>3&&(c=c&&this.e(a,3,L));
    return c&&this.Bg(a)
    };

Ys[C].Ob=function(a){
    var b=this,c=[];
    this.ua(a,function(d){
        (b.e(a,d,M)||b.e(a,d,L))&&c[r](d)
        });
    return this.Fa(a,c)
    };

var Zs=So("AnnotatedTimeLine",{
    format:new Js,
    T:3
},Sf,{
    format:new Ks,
    T:2
},Xf,{
    format:new Ms,
    T:2
},bg,{
    format:new Ms,
    T:2
},"FunctionChart",{
    format:new Ns,
    T:2
},"Gauge",{
    format:new Os,
    T:1
},"GeoMap",{
    format:new Ps,
    T:2
},Kg,{
    format:new Ms,
    T:2
},"ImageCandlestickChart",{
    format:new Ls,
    T:2
},Bg,{
    format:new Us,
    T:1
},"ImageSparkLine",{
    format:new Ws,
    T:1
},"Map",{
    format:new Qs,
    T:2
},"MotionChart",{
    format:new Rs,
    T:3
},"OrgChart",{
    format:new Ss,
    T:2
},"PieChart",{
    format:new Ts,
    T:2
},fh,{
    format:new Vs,
    T:2
},"Table",{
    format:new Xs,
    T:0
},"TreeMap",{
    format:new Ys,
    T:2
});
function $s(a,b){
    var c=b||{};

    Q(c)&&(c=tr(c));
    this.gg=c.containerId||i;
    this.qd=a;
    this.Oa=c[a+nh]||i;
    this.hg=c[a+Ug]||i;
    this.fb=i;
    this.Fe=c.dataSourceUrl||i;
    this.h=i;
    this.setDataTable(c.dataTable);
    this.V=c.options||{};

    this.Na=c.state||{};

    var d=c.packages;
    this.ig=Bn(d)?d:i;
    this.Ma=c.query||i;
    this.Ab=c.refreshInterval||i;
    this.jg=c.view||i
    }
var at={
    AnnotatedTimeLine:"annotatedtimeline",
    AreaChart:Ei,
    BarChart:Ei,
    CandlestickChart:Ei,
    ColumnChart:Ei,
    ComboChart:Ei,
    Gauge:"gauge",
    GeoChart:"geochart",
    GeoMap:"geomap",
    ImageAreaChart:"imageareachart",
    ImageBarChart:"imagebarchart",
    ImageCandlestickChart:"imagechart",
    ImageChart:"imagechart",
    ImageLineChart:"imagelinechart",
    ImagePieChart:"imagepiechart",
    ImageSparkLine:"imagesparkline",
    IntensityMap:"intensitymap",
    LineChart:Ei,
    Map:"map",
    MotionChart:"motionchart",
    OrgChart:"orgchart",
    PieChart:Ei,
    ScatterChart:Ei,
    Table:"table",
    Timeline:"timeline",
    TreeMap:"treemap",
    StringFilter:"controls"
};

N=$s[C];
N.Yg=i;
N.draw=function(a){
    a=Ep(a||J);
    Np(a)||(a=Ep(this.getContainerId()),Np(a)||e(l("The container is null or not defined.")));
    try{
        if(xn(this.Oa)||e(l("The "+this.qd+" type is not defined.")),this.Rg())this.eh(a);
        else{
            var b=Nn(this.eh,this,a),b=google[Qc][Cd].createProtectedCallback(b,Nn(this.hf,this,a));
            this.ok(b)
            }
        }catch(c){
    this.hf(a,c)
    }
};

N.toJSON=function(){
    return this.Mh(this[qb]())
    };
N.Mh=function(a){
    var b=this[rd](),c=g;
    a!==i&&(c=a instanceof google[Qc][Ya]?tr(a[Bc]()):tr(a[Nb]()[Bc]()));
    a={
        dataSourceUrl:this[Zc]()||g,
        dataTable:c,
        options:this[ib]()||g,
        state:this[md]()||g,
        packages:b===i?g:b,
        refreshInterval:this[kd]()||g,
        query:this[vd]()||g,
        view:this[wc]()||g
        };

    a[this.qd+nh]=this.Oa||g;
    a[this.qd+Ug]=this.getName()||g;
    return qr(a)
    };

N.getDataSourceUrl=function(){
    return this.Fe
    };

N.getDataTable=function(){
    return this.h
    };

N.Rh=function(){
    return this.Oa
    };

N.getName=function(){
    return this.hg
    };
N.Sh=function(){
    return this.fb
    };

N.getContainerId=function(){
    return this.gg
    };

N.getQuery=function(){
    return this.Ma
    };

N.getRefreshInterval=function(){
    return this.Ab
    };

N.getOption=function(a,b){
    var c=this.V[a],b=Bn(b)?b:i;
    return c=xn(c)?c:b
    };

N.getOptions=function(){
    return this.V
    };

N.getState=function(){
    return this.Na
    };

N.setDataSourceUrl=function(a){
    if(a!=this.Fe)this.$l=i;
    this.Fe=a
    };

N.setDataTable=function(a){
    this.h=a==i?i:Gn(a[Zb])?a:P(a)?google[Qc].arrayToDataTable(a):new google[Qc][Ya](a)
    };
N.Vh=function(a){
    this.Oa=a
    };

N.Uh=function(a){
    this.hg=a
    };

N.setContainerId=function(a){
    this.gg=a
    };

N.setQuery=function(a){
    this.Ma=a
    };

N.setRefreshInterval=function(a){
    this.Ab=a
    };

N.setOption=function(a,b){
    this.V[a]=xn(b)?b:g
    };

N.setOptions=function(a){
    this.V=a||{}
};

Ia(N,function(a){
    this.Na=a||{}
});
N.setPackages=function(a){
    this.ig=a
    };

N.setView=function(a){
    this.jg=a
    };

N.getSnapshot=function(){
    return new this[Lc](this.Mh(this.Yg||this[qb]()))
    };

N.getView=function(){
    return this.jg
    };
N.Rg=function(){
    var a=this.Oa,b=wn(a);
    Gn(b)||(b=wn(gk+a),Gn(b)||(b=i));
    return b
    };

N.getPackages=function(){
    return this.ig
    };

N.hf=function(a,b){
    var c=b&&b[Sc]||bj,d=google[Qc][Cd][Ac](a,c);
    google[Qc][fb][Ua](this,bj,{
        id:d,
        message:c
    })
    };

N.nl=function(a,b){
    var c=b.getMessage(),d=b.getDetailedMessage(),f=google[Qc][Cd].addErrorFromQueryResponse(a,b);
    google[Qc][fb][Ua](this,bj,{
        id:f,
        message:c,
        detailedMessage:d
    })
    };
N.Gl=function(){
    var a=this[rd]();
    if(!xn(a)){
        var b=this.Oa,b=b[t](gk,J),a=at[b];
        xn(a)||e(l("Invalid visualization type: "+b))
        }
        Q(a)&&(a=[a]);
    return a
    };
N.qh=function(a,b){
    var j;
    var c=this.Rg();
    c||e(l("Invalid "+this.qd+" type: "+this.Oa));
    var d;
    if(!this.fb||this.fb[Lc]!=c){
        d=new c(a);
        var f=this;
        xo([Rl,hm,bj,xm],function(a){
            google[Qc][fb].addListener(d,a,function(b){
                if(a==Rl)f.fb=d;
                (a==Rl||a==xm)&&Gn(d[md])&&f[qc](d[md][F](d));
                google[Qc][fb][Ua](f,a,b)
                })
            })
        }else d=this.fb;
    this.Yg=b;
    c=this[wc]();
    if(c==$h){
        c=this.Oa;
        if(c==Ag){
            var h=this[bd](ui);
            if(h==Pl||h==am)c=Bg
                }
                if(j=(c=Zs[c])&&c[Eb],c=j)b=(c=c.ek(b))?c[Nb]():b
            }else xn(c)&&(b=google[Qc][jd].fromJSON(b,
        c));
    this.ak(b);
    d[gd](b,this[ib](),this[md]())
    };

N.Ik=function(a,b){
    if(b[Jb]())this.nl(a,b);
    else{
        var c=b[qb]();
        this.qh(a,c)
        }
    };

N.ok=function(a){
    var a={
        packages:this.Gl(),
        callback:a
    },b=wn(ik);
    b===i&&(b=sf);
    google.load(dn,b,a)
    };

N.eh=function(a){
    var b=this[qb]();
    b?this.qh(a,b):(b=Nn(this.Ik,this,a),b=google[Qc][Cd].createProtectedCallback(b,Nn(this.hf,this,a)),this.sf(b,!0))
    };
N.sf=function(a,b){
    var c=typeof b==gi?b:!1,d=this[Zc]()||J,d=new google[Qc].Query(d),f=this[kd]();
    f&&c&&d[$b](f);
    (c=this[vd]())&&d[Vc](c);
    d[Gb](a)
    };
N.ak=function(a){
    var b=this.Oa;
    if(b==Sf||b==Xf||b==bg||b==Kg||b==fh){
        var c=this[bd](Zm,{}),d=this[bd](kk,{}),f={},h;
        h=b==fh||this[bd](lk)==!0?1:0;
        for(var j=a&&a[nb]()||0,m=h;m<j;m++)a[y](m)==L&&(h=a[Nc](m),Q(h)&&(f[h]=!0));
        h=0;
        for(var q in f)h++;if(h==1)a:{
            for(var u in f){
                f=u;
                break a
            }
            f=g
            }else f=i;
        h=f;
        h!=i&&(h=h[t](rf,lf),b==Xf?za(d,h):za(c,h));
        b==fh&&j>0&&(h=a[Nc](0),Q(h)&&(h=h[t](rf,lf),za(d,h)));
        this[Ld](Zm,c);
        this[Ld](kk,d)
        }
    };

function Y(a){
    $s[F](this,ri,a)
    }
    R(Y,$s);
N=Y[C];
N.Jl=$s[C].Sh;
N.setChartType=$s[C].Vh;
N.getChartType=$s[C].Rh;
N.setChartName=$s[C].Uh;
N.getChartName=$s[C].getName;
function Z(a){
    $s[F](this,Di,a)
    }
    R(Z,$s);
N=Z[C];
N.getControl=$s[C].Sh;
N.setControlType=$s[C].Vh;
N.getControlType=$s[C].Rh;
N.setControlName=$s[C].Uh;
N.getControlName=$s[C].getName;
function bt(a,b){
    (new Y(a))[gd](b)
    };

So(L,function(a){
    var b=ha(a);
    ma(b)&&e(l("Not a number "+a));
    return b
    },M,function(a){
    return a
    },gi,function(a){
    return a==Rm
    },Ii,function(){
    e(l(rh))
    },Ji,function(){
    e(l(rh))
    },Im,function(){
    e(l(rh))
    });
function ct(a){
    for(var b=0,c=0;c<a[B];c++)b+=a[c];
    return b
    };

function dt(a){
    this.V=a||{};

    Fs(kf)
    }
    za(dt[C],function(a,b){
    if(a[y](b)==L)for(var c=this.V.base||0,d=0;d<a[xc]();d++){
        var f=a[A](d,b),h=i,h=f<c?Wj:f>c?Yj:Xj;
        a[hd](d,b,wi,h)
        }
    });
function et(a){
    this.V=a||{};

    ft||(ft=Es()+jf)
    }
    var ft=i,gt={
    red:Pl,
    blue:ai,
    green:nj
};

function ht(a,b,c){
    b>0&&c[r](If,ft,a,af,b,Vd)
    }
za(et[C],function(a,b){
    if(a[y](b)==L){
        var c=this.V,d=c.min,f=c.max,h=i;
        if(d==i||f==i)h=a[ld](b),f==i&&(f=h.max),d==i&&(d=p.min(0,h.min));
        if(d>=f)h=h||a[ld](b),f=h.max,d=h.min;
        d==f&&(d==0?f=1:d>0?d=0:f=0);
        var h=f-d,j=c.base||0,j=p.max(d,p.min(f,j)),m=c[s]||100,q=c.showValue;
        q==i&&(q=!0);
        for(var u=p[cb]((j-d)/h*m),D=m-u,E=0;E<a[xc]();E++){
            var K=a[A](E,b),G=[],K=p.max(d,p.min(f,K)),sa=p.ceil((K-d)/h*m);
            G[r](Kf);
            ht(cm,1,G);
            var qa=it(c.colorPositive,ai),xa=it(c.colorNegative,Pl),W=c.drawZeroLine?1:0;
            u>
            0?K<j?(ht(en,sa,G),ht(xa,u-sa,G),W>0&&ht(nn,W,G),ht(en,D,G)):(ht(en,u,G),W>0&&ht(nn,W,G),ht(qa,sa-u,G),ht(en,m-sa,G)):(ht(qa,sa,G),ht(en,m-sa,G));
            ht(cm,1,G);
            K=a[vb](E,b,Fh);
            K==i&&(K=a[Bd](E,b),a[hd](E,b,Fh,K));
            q&&(G[r](rn),G[r](K));
            G[r](Ff);
            a[Pc](E,b,G[I](J))
            }
        }
    });
function it(a,b){
    a=(a||J)[Jd]();
    return gt[a]||b
    };

var jt={
    aliceblue:"#f0f8ff",
    antiquewhite:"#faebd7",
    aqua:"#00ffff",
    aquamarine:"#7fffd4",
    azure:"#f0ffff",
    beige:"#f5f5dc",
    bisque:"#ffe4c4",
    black:"#000000",
    blanchedalmond:"#ffebcd",
    blue:"#0000ff",
    blueviolet:"#8a2be2",
    brown:"#a52a2a",
    burlywood:"#deb887",
    cadetblue:"#5f9ea0",
    chartreuse:"#7fff00",
    chocolate:"#d2691e",
    coral:"#ff7f50",
    cornflowerblue:"#6495ed",
    cornsilk:"#fff8dc",
    crimson:"#dc143c",
    cyan:"#00ffff",
    darkblue:"#00008b",
    darkcyan:"#008b8b",
    darkgoldenrod:"#b8860b",
    darkgray:"#a9a9a9",
    darkgreen:"#006400",
    darkgrey:"#a9a9a9",
    darkkhaki:"#bdb76b",
    darkmagenta:"#8b008b",
    darkolivegreen:"#556b2f",
    darkorange:"#ff8c00",
    darkorchid:"#9932cc",
    darkred:"#8b0000",
    darksalmon:"#e9967a",
    darkseagreen:"#8fbc8f",
    darkslateblue:"#483d8b",
    darkslategray:"#2f4f4f",
    darkslategrey:"#2f4f4f",
    darkturquoise:"#00ced1",
    darkviolet:"#9400d3",
    deeppink:"#ff1493",
    deepskyblue:"#00bfff",
    dimgray:"#696969",
    dimgrey:"#696969",
    dodgerblue:"#1e90ff",
    firebrick:"#b22222",
    floralwhite:"#fffaf0",
    forestgreen:"#228b22",
    fuchsia:"#ff00ff",
    gainsboro:"#dcdcdc",
    ghostwhite:"#f8f8ff",
    gold:"#ffd700",
    goldenrod:"#daa520",
    gray:"#808080",
    green:"#008000",
    greenyellow:"#adff2f",
    grey:"#808080",
    honeydew:"#f0fff0",
    hotpink:"#ff69b4",
    indianred:"#cd5c5c",
    indigo:"#4b0082",
    ivory:"#fffff0",
    khaki:"#f0e68c",
    lavender:"#e6e6fa",
    lavenderblush:"#fff0f5",
    lawngreen:"#7cfc00",
    lemonchiffon:"#fffacd",
    lightblue:"#add8e6",
    lightcoral:"#f08080",
    lightcyan:"#e0ffff",
    lightgoldenrodyellow:"#fafad2",
    lightgray:"#d3d3d3",
    lightgreen:"#90ee90",
    lightgrey:"#d3d3d3",
    lightpink:"#ffb6c1",
    lightsalmon:"#ffa07a",
    lightseagreen:"#20b2aa",
    lightskyblue:"#87cefa",
    lightslategray:"#778899",
    lightslategrey:"#778899",
    lightsteelblue:"#b0c4de",
    lightyellow:"#ffffe0",
    lime:"#00ff00",
    limegreen:"#32cd32",
    linen:"#faf0e6",
    magenta:"#ff00ff",
    maroon:"#800000",
    mediumaquamarine:"#66cdaa",
    mediumblue:"#0000cd",
    mediumorchid:"#ba55d3",
    mediumpurple:"#9370d8",
    mediumseagreen:"#3cb371",
    mediumslateblue:"#7b68ee",
    mediumspringgreen:"#00fa9a",
    mediumturquoise:"#48d1cc",
    mediumvioletred:"#c71585",
    midnightblue:"#191970",
    mintcream:"#f5fffa",
    mistyrose:"#ffe4e1",
    moccasin:"#ffe4b5",
    navajowhite:"#ffdead",
    navy:"#000080",
    oldlace:"#fdf5e6",
    olive:"#808000",
    olivedrab:"#6b8e23",
    orange:"#ffa500",
    orangered:"#ff4500",
    orchid:"#da70d6",
    palegoldenrod:"#eee8aa",
    palegreen:"#98fb98",
    paleturquoise:"#afeeee",
    palevioletred:"#d87093",
    papayawhip:"#ffefd5",
    peachpuff:"#ffdab9",
    peru:"#cd853f",
    pink:"#ffc0cb",
    plum:"#dda0dd",
    powderblue:"#b0e0e6",
    purple:"#800080",
    red:"#ff0000",
    rosybrown:"#bc8f8f",
    royalblue:"#4169e1",
    saddlebrown:"#8b4513",
    salmon:"#fa8072",
    sandybrown:"#f4a460",
    seagreen:"#2e8b57",
    seashell:"#fff5ee",
    sienna:"#a0522d",
    silver:"#c0c0c0",
    skyblue:"#87ceeb",
    slateblue:"#6a5acd",
    slategray:"#708090",
    slategrey:"#708090",
    snow:"#fffafa",
    springgreen:"#00ff7f",
    steelblue:"#4682b4",
    tan:"#d2b48c",
    teal:"#008080",
    thistle:"#d8bfd8",
    tomato:"#ff6347",
    turquoise:"#40e0d0",
    violet:"#ee82ee",
    wheat:"#f5deb3",
    white:"#ffffff",
    whitesmoke:"#f5f5f5",
    yellow:"#ffff00",
    yellowgreen:"#9acd32"
};

function kt(a){
    var b={},a=ja(a),c=a[lb](0)==Yd?a:Yd+a;
    if(lt[Za](c))return b.Zd=mt(c),Ca(b,ok),b;
    else{
        a:{
            var d=a[Db](nt);
            if(d){
                var c=da(d[1]),f=da(d[2]),d=da(d[3]);
                if(c>=0&&c<=255&&f>=0&&f<=255&&d>=0&&d<=255){
                    c=[c,f,d];
                    break a
                }
            }
            c=[]
        }
        if(c[B])return b.Zd=ot(c[0],c[1],c[2]),Ca(b,Yl),b;
    else if(jt&&(c=jt[a[Jd]()]))return b.Zd=c,Ca(b,ol),b
        }
        e(l(a+" is not a valid color string"))
}
var pt=/#(.)(.)(.)/;
function mt(a){
    lt[Za](a)||e(l(me+a+"' is not a valid hex color"));
    a[B]==4&&(a=a[t](pt,Zd));
    return a[Jd]()
    }
function qt(a){
    a=mt(a);
    return[ga(a[pc](1,2),16),ga(a[pc](3,2),16),ga(a[pc](5,2),16)]
    }
    function ot(a,b,c){
    a=da(a);
    b=da(b);
    c=da(c);
    (ma(a)||a<0||a>255||ma(b)||b<0||b>255||ma(c)||c<0||c>255)&&e(l('"('+a+we+b+we+c+'") is not a valid RGB color'));
    a=rt(a[sc](16));
    b=rt(b[sc](16));
    c=rt(c[sc](16));
    return Yd+a+b+c
    }
    var lt=/^#(?:[0-9a-f]{3}){1,2}$/i,nt=/^(?:rgb)?\((0|[1-9]\d{0,2}),\s?(0|[1-9]\d{0,2}),\s?(0|[1-9]\d{0,2})\)$/i;
function rt(a){
    return a[B]==1?lf+a:a
    };

function st(a,b,c,d){
    Dn(a)&&(a=a[ic]());
    Dn(b)&&(b=b[ic]());
    P(a)&&(a=tt(a));
    P(b)&&(b=tt(b));
    this.lh=a;
    this.Ok=b;
    this.yk=c;
    this.Pk=d
    }
    Pa(st[C],function(a){
    var b=this.lh,c=this.Ok;
    if(a==i)return b==i&&c==i;else Dn(a)?a=a[ic]():P(a)&&(a=tt(a));
    return(b==i||a>=b)&&(c==i||a<c)
    });
st[C].Ch=function(){
    return this.Pk
    };

function ut(a,b,c,d,f){
    st[F](this,a,b,c,J);
    this.qf=b-a;
    if(this.qf<=0)this.qf=1;
    this.zk=qt(kt(d).Zd);
    this.Ak=qt(kt(f).Zd)
    }
    R(ut,st);
ut[C].Ch=function(a){
    var b;
    b=this.zk;
    var c=this.Ak,a=1-(a-this.lh)/this.qf,a=p.min(p.max(a,0),1);
    b=[p[cb](a*b[0]+(1-a)*c[0]),p[cb](a*b[1]+(1-a)*c[1]),p[cb](a*b[2]+(1-a)*c[2])];
    return ot(b[0],b[1],b[2])
    };

function vt(){
    this.$d=[]
    }
    vt[C].addRange=function(a,b,c,d){
    this.$d[r](new st(a,b,c,d))
    };

vt[C].addGradientRange=function(a,b,c,d,f){
    this.$d[r](new ut(a,b,c,d,f))
    };
za(vt[C],function(a,b){
    var c=a[y](b);
    if(c==L||c==M||c==Ii||c==Ji||c==Im)for(c=0;c<a[xc]();c++){
        for(var d=a[A](c,b),f=J,h=0;h<this.$d[B];h++){
            var j=this.$d[h];
            if(j.contains(d)){
                h=j.yk;
                d=j.Ch(d);
                h&&(f+=zi+h+Bf);
                d&&(f+=bi+d+Bf);
                break
            }
        }
        a[hd](c,b,zm,f)
        }
    });
function tt(a){
    return a[0]*36E5+a[1]*6E4+a[2]*1E3+(a[B]==4?a[3]:0)
    };

function wt(a){
    this.V=a||{}
}
za(wt[C],function(a,b){
    var c=a[y](b);
    if(!(c!=Ii&&c!=Ji)){
        var d=this.V;
        if(d.pattern!=i)c=new zr(d.pattern);
        else{
            var f=d.formatType||qm,h;
            if(c==Ii)switch(f){
                case Uk:
                    h=1;
                    break;
                case $k:
                    h=2;
                    break;
                case qm:
                    h=3;
                    break;
                default:
                    e(l(Dg+f+Ye))
                    }else if(c==Ji)switch(f){
                case Uk:
                    h=9;
                    break;
                case $k:
                    h=10;
                    break;
                case qm:
                    h=11;
                    break;
                default:
                    e(l(Dg+f+Ye))
                    }else e(l("Column type: required date or datetime found "+c));
            c=new zr(h)
            }
            d=d.timeZone;
        if(xn(d))var j=yr(-d*60);
        d=a[xc]();
        for(f=0;f<d;f++)h=a[A](f,b),h=h===i?J:j==i?c[Eb](h,
            yr(h[Md]())):c[Eb](h,j),a[Pc](f,b,h)
            }
        });
function xt(a){
    this.V=a||{}
}
za(xt[C],function(a,b){
    if(a[y](b)==L){
        var c=this.V,d=c.fractionDigits;
        d==i&&(d=2);
        var f=c.decimalSymbol||Ye,h=c.groupingSymbol;
        h==i&&(h=f==we?Ye:we);
        for(var j=c.prefix||J,m=c.suffix||J,q=c.negativeColor,c=c.negativeParens,u=0;u<a[xc]();u++){
            var D=a[A](u,b);
            if(D!=i){
                var E=D;
                c&&(E=p.abs(E));
                E=this.Dk(E,d,f,h);
                E=j+E+m;
                c&&D<0&&(E=qe+E+te);
                a[Pc](u,b,E);
                q&&D<0&&a[hd](u,b,zm,zi+q+Bf)
                }
            }
        }
});
xt[C].Dk=function(a,b,c,d){
    b==0&&(a=p[cb](a));
    var f=[];
    a<0&&(a=-a,f[r](ye));
    var h=p.pow(10,b),j=p[cb](a*h),a=ja(p[gb](j/h)),h=ja(j%h);
    if(a[B]>3&&d){
        j=a[B]%3;
        j>0&&(f[r](a[ud](0,j),d),a=a[ud](j));
        for(;a[B]>3;)f[r](a[ud](0,3),d),a=a[ud](3)
            }
            f[r](a);
    b>0&&(f[r](c),h[B]<b&&(h=qf+h),f[r](h[ud](h[B]-b)));
    return f[I](J)
    };

function yt(a){
    this.Ol=a||J
    }
    function zt(a,b,c,d,f,h,j){
    return h>0&&j[h-1]==yh?d:b[Bd](a,c[ga(f,10)])
    }
    za(yt[C],function(a,b,c,d){
    var f=b[0];
    c!=i&&An(c)==L&&(f=c);
    c=d||i;
    for(d=0;d<a[xc]();d++){
        var h=this.Ol[t](/{(\d+)}/g,On(zt,d,a,b)),h=h[t](/\\(.)/g,ae);
        c?a[hd](d,f,c,h):a[Pc](d,f,h)
        }
    });
k("google.visualization.NumberFormat",xt);
o(xt[C],kj,xt[C][Eb]);
k("google.visualization.ColorFormat",vt);
o(vt[C],kj,vt[C][Eb]);
o(vt[C],"addRange",vt[C][pd]);
o(vt[C],Ph,vt[C].addGradientRange);
k("google.visualization.BarFormat",et);
o(et[C],kj,et[C][Eb]);
k("google.visualization.ArrowFormat",dt);
o(dt[C],kj,dt[C][Eb]);
k("google.visualization.PatternFormat",yt);
o(yt[C],kj,yt[C][Eb]);
k("google.visualization.DateFormat",wt);
o(wt[C],kj,wt[C][Eb]);
k("google.visualization.TableNumberFormat",xt);
o(xt[C],kj,xt[C][Eb]);
k("google.visualization.TableColorFormat",vt);
o(vt[C],kj,vt[C][Eb]);
o(vt[C],"addRange",vt[C][pd]);
o(vt[C],Ph,vt[C].addGradientRange);
k("google.visualization.TableBarFormat",et);
o(et[C],kj,et[C][Eb]);
k("google.visualization.TableArrowFormat",dt);
o(dt[C],kj,dt[C][Eb]);
k("google.visualization.TablePatternFormat",yt);
o(yt[C],kj,yt[C][Eb]);
k("google.visualization.TableDateFormat",wt);
o(wt[C],kj,wt[C][Eb]);
function At(a){
    this.Aa=Bp();
    this.Zb=a;
    this.We=this.Gg=this.gj=this.Ga=this.Dg=this.lc=this.Dd=i;
    this.mc=hk+Bt++ +Gh;
    Ct[this.mc]=this;
    Fs(kf)
    }
    var Bt=0,Ct={},Dt=Es()+"/util/player.swf";
N=At[C];
N.sk=function(a){
    this.Dd=a[ed]||0;
    (this.lc=a.end||i)||e(l("end is mandatory."));
    this.Dg=a.step||1;
    this.Ga=a.current||this.Dd;
    this.gj=a.play||!1;
    this.Gg=a.timeInterval||100
    };

N.draw=function(a){
    a=a||{};

    this.sk(a);
    var b=this.Zb;
    this.Aa.He(b);
    b||e(l(dg));
    this.rk(a)
    };
N.rk=function(a){
    var b=this.Zb,a=new SWFObject(Dt,this.mc,a[s]||b[s]||500,a[H]||b[H]||25,zf,$d);
    a.addParam(al,dj);
    a.addParam(Th,Wh);
    a.addParam(Sh,Rm);
    a.addVariable(nl,this.mc);
    if(!b.id)b.id=this.mc;
    a.write(b.id)
    };

N.Jd=function(){
    n[hb](this.mc).setPos(this.Ga)
    };

N.vk=function(){
    n[hb](this.mc).init(this.Dd,this.lc);
    this.Jd()
    };

N.mh=function(a){
    if(a){
        if(this.Ga==this.lc)this.Ga=this.Dd;
        this.We=setInterval(Nn(this.ik,this),this.Gg)
        }else aa(this.We)
        };
N.ik=function(){
    this.Jd();
    google[Qc][fb][Ua](this,Il,{
        current:this.Ga
        });
    this.Ga+=this.Dg;
    if(this.Ga>=this.lc)this.Ga=this.lc,aa(this.We);
    this.Jd()
    };

function Et(a,b,c,d,f){
    this.aa=!!b;
    a&&this.nc(a,d);
    this.kb=f!=g?f:this.xa||0;
    this.aa&&(this.kb*=-1);
    this.Fd=!c
    }
    R(Et,$p);
N=Et[C];
N.ta=i;
N.xa=0;
N.Je=!1;
N.nc=function(a,b,c){
    if(this.ta=a)this.xa=Fn(b)?b:this.ta[eb]!=1?0:this.aa?-1:1;
    if(Fn(c))this.kb=c
        };

N.we=function(a){
    this.ta=a.ta;
    this.xa=a.xa;
    this.kb=a.kb;
    this.aa=a.aa;
    this.Fd=a.Fd
    };

Na(N,function(){
    return new Et(this.ta,this.aa,!this.Fd,this.xa,this.kb)
    });
N.pk=function(){
    var a=this.aa?1:-1;
    if(this.xa==a)this.xa=a*-1,this.kb+=this.xa*(this.aa?-1:1)
        };
Ma(N,function(){
    var a;
    if(this.Je){
        (!this.ta||this.Fd&&this.kb==0)&&e(Zp);
        a=this.ta;
        var b=this.aa?-1:1;
        if(this.xa==b){
            var c=this.aa?a[ad]:a[Qb];
            c?this.nc(c):this.nc(a,b*-1)
            }else(c=this.aa?a.previousSibling:a.nextSibling)?this.nc(c):this.nc(a[Dd],b*-1);
        this.kb+=this.xa*(this.aa?-1:1)
        }else this.Je=!0;
    (a=this.ta)||e(Zp);
    return a
    });
N.rj=function(){
    return this.xa==1
    };
N.splice=function(){
    var a=this.ta;
    this.pk();
    this.aa=!this.aa;
    Et[C].next[F](this);
    this.aa=!this.aa;
    for(var b=Cn(arguments[0])?arguments[0]:arguments,c=b[B]-1;c>=0;c--)a[Dd]&&a[Dd][sb](b[c],a.nextSibling);
    Qp(a)
    };

function Ft(a,b){
    Et[F](this,a,b,!0)
    }
    R(Ft,Et);
function Gt(a,b,c,d,f){
    var h;
    if(a){
        this.I=a;
        this.M=b;
        this.C=c;
        this.L=d;
        if(a[eb]==1&&a[yd]!=Vf)if(a=a[ac],b=a[b])this.I=b,this.M=0;
            else{
            if(a[B])this.I=a[a[B]-1];
            h=!0
            }
            if(c[eb]==1)(this.C=c[ac][d])?this.L=0:this.C=c
            }
            Ft[F](this,f?this.C:this.I,f);
    if(h)try{
        this.next()
        }catch(j){
        j!=Zp&&e(j)
        }
    }
    R(Gt,Ft);
N=Gt[C];
N.I=i;
N.C=i;
N.M=0;
N.L=0;
N.ka=function(){
    return this.I
    };

N.Ha=function(){
    return this.C
    };

N.mj=function(){
    return this.Je&&this.ta==this.C&&(!this.L||!this.rj())
    };

Ma(N,function(){
    this.mj()&&e(Zp);
    return Gt.b.next[F](this)
    });
N.we=function(a){
    this.I=a.I;
    this.C=a.C;
    this.M=a.M;
    this.L=a.L;
    this.ag=a.ag;
    Gt.b.we[F](this,a)
    };

Na(N,function(){
    var a=new Gt(this.I,this.M,this.C,this.L,this.ag);
    a.we(this);
    return a
    });
function Ht(){}
Ht[C].zg=function(a,b){
    var c=b&&!a[Ta](),d=a.n;
    try{
        return c?this.ja(d,0,1)>=0&&this.ja(d,1,0)<=0:this.ja(d,0,0)>=0&&this.ja(d,1,1)<=0
        }catch(f){
        return S||e(f),!1
        }
    };

Ht[C].Ph=function(){
    return new Gt(this.ka(),this.Sa(),this.Ha(),this.mb())
    };

function It(a){
    this.n=a
    }
    R(It,Ht);
function Jt(a){
    var b=Dp(a).createRange();
    if(a[eb]==3)b[vc](a,0),b[ub](a,a[B]);
    else if(Kt(a)){
        for(var c,d=a;(c=d[Qb])&&Kt(c);)d=c;
        b[vc](d,0);
        for(d=a;(c=d[ad])&&Kt(c);)d=c;
        b[ub](d,d[eb]==1?d[ac][B]:d[B])
        }else c=a[Dd],a=wo(c[ac],a),b[vc](c,a),b[ub](c,a+1);
    return b
    }
    function Lt(a,b,c,d){
    var f=Dp(a).createRange();
    f[vc](a,b);
    f[ub](c,d);
    return f
    }
    N=It[C];
Na(N,function(){
    return new this[Lc](this.n.cloneRange())
    });
N.getContainer=function(){
    return this.n.commonAncestorContainer
    };
N.ka=function(){
    return this.n.startContainer
    };

N.Sa=function(){
    return this.n.startOffset
    };

N.Ha=function(){
    return this.n.endContainer
    };

N.mb=function(){
    return this.n.endOffset
    };

N.ja=function(a,b,c){
    return this.n.compareBoundaryPoints(c==1?b==1?O.Range.START_TO_START:O.Range.START_TO_END:b==1?O.Range.END_TO_START:O.Range.END_TO_END,a)
    };

N.isCollapsed=function(){
    return this.n.collapsed
    };

N.select=function(a){
    this.Wd(Jp(Dp(this.ka())).getSelection(),a)
    };

N.Wd=function(a){
    a.removeAllRanges();
    a[pd](this.n)
    };
N.collapse=function(a){
    this.n[bb](a)
    };

function Mt(a){
    this.n=a
    }
    R(Mt,It);
Mt[C].Wd=function(a,b){
    var c=b?this.Ha():this.ka(),d=b?this.mb():this.Sa(),f=b?this.ka():this.Ha(),h=b?this.Sa():this.mb();
    a[bb](c,d);
    (c!=f||d!=h)&&a.extend(f,h)
    };

function Nt(a,b){
    this.n=a;
    this.aj=b
    }
    R(Nt,Ht);
function Ot(a){
    var b=Dp(a)[Wc].createTextRange();
    if(a[eb]==1)b.moveToElementText(a),Kt(a)&&!a[ac][B]&&b[bb](!1);
    else{
        for(var c=0,d=a;d=d.previousSibling;){
            var f=d[eb];
            if(f==3)c+=d[B];
            else if(f==1){
                b.moveToElementText(d);
                break
            }
        }
        d||b.moveToElementText(a[Dd]);
    b[bb](!d);
    c&&b.move(qi,c);
    b.moveEnd(qi,a[B])
    }
    return b
}
function Pt(a,b,c,d){
    var D;
    var f=a,h=b,j=c,m=d,q=!1;
    f[eb]==1&&(h=f[ac][h],q=!h,f=h||f[ad]||f,h=0);
    var u=Ot(f);
    h&&u.move(qi,h);
    if(f==j&&h==m)u[bb](!0);else q&&u[bb](!1),q=!1,j[eb]==1&&(D=(h=j[ac][m])||j[ad]||j,j=D,m=0,q=!h),f=Ot(j),f[bb](!q),m&&f.moveEnd(qi,m),u.setEndPoint(jg,f);
    m=new Nt(u,Dp(a));
    m.I=a;
    m.M=b;
    m.C=c;
    m.L=d;
    return m
    }
    N=Nt[C];
N.Qa=i;
N.I=i;
N.C=i;
N.M=-1;
N.L=-1;
Na(N,function(){
    var a=new Nt(this.n.duplicate(),this.aj);
    a.Qa=this.Qa;
    a.I=this.I;
    a.C=this.C;
    return a
    });
N.getContainer=function(){
    if(!this.Qa){
        var a=this.n.text,b=this.n.duplicate(),c=a[t](/ +$/,J);
        (c=a[B]-c[B])&&b.moveEnd(qi,-c);
        c=b.parentElement();
        b=b.htmlText[t](/(\r\n|\r|\n)+/g,Pd)[B];
        if(this[Ta]()&&b>0)return this.Qa=c;
        for(;b>c.outerHTML[t](/(\r\n|\r|\n)+/g,Pd)[B];)c=c[Dd];
        for(;c[ac][B]==1&&c.innerText==(c[Qb][eb]==3?c[Qb].nodeValue:c[Qb].innerText);){
            if(!Kt(c[Qb]))break;
            c=c[Qb]
            }
            a[B]==0&&(c=this.Pg(c));
        this.Qa=c
        }
        return this.Qa
    };
N.Pg=function(a){
    for(var b=a[ac],c=0,d=b[B];c<d;c++){
        var f=b[c];
        if(Kt(f)){
            var h=Ot(f),j=h.htmlText!=f.outerHTML;
            if(this[Ta]()&&j?this.ja(h,1,1)>=0&&this.ja(h,1,0)<=0:this.n.inRange(h))return this.Pg(f)
                }
            }
    return a
};

N.ka=function(){
    if(!this.I&&(this.I=this.Bc(1),this[Ta]()))this.C=this.I;
    return this.I
    };

N.Sa=function(){
    if(this.M<0&&(this.M=this.Qg(1),this[Ta]()))this.L=this.M;
    return this.M
    };

N.Ha=function(){
    if(this[Ta]())return this.ka();
    if(!this.C)this.C=this.Bc(0);
    return this.C
    };
N.mb=function(){
    if(this[Ta]())return this.Sa();
    if(this.L<0&&(this.L=this.Qg(0),this[Ta]()))this.M=this.L;
    return this.L
    };

N.ja=function(a,b,c){
    return this.n.compareEndPoints((b==1?gh:ig)+mh+(c==1?gh:ig),a)
    };
N.Bc=function(a,b){
    var c=b||this.getContainer();
    if(!c||!c[Qb])return c;
    for(var d=a==1,f=0,h=c[ac][B];f<h;f++){
        var j=d?f:h-f-1,m=c[ac][j],q;
        try{
            q=Qt(m)
            }catch(u){
            continue
        }
        var D=q.n;
        if(this[Ta]())if(Kt(m)){
            if(q.zg(this))return this.Bc(a,m)
                }else{
            if(this.ja(D,1,1)==0){
                this.M=this.L=j;
                break
            }
        }else if(this.zg(q)){
        if(!Kt(m)){
            d?this.M=j:this.L=j+1;
            break
        }
        return this.Bc(a,m)
        }else if(this.ja(D,1,0)<0&&this.ja(D,0,1)>0)return this.Bc(a,m)
        }
        return c
};
N.sj=function(a,b,c){
    return this.n.compareEndPoints((b==1?gh:ig)+mh+(c==1?gh:ig),Qt(a).n)
    };

N.Qg=function(a,b){
    var c=a==1,d=b||(c?this.ka():this.Ha());
    if(d[eb]==1){
        for(var d=d[ac],f=d[B],h=c?1:-1,j=c?0:f-1;j>=0&&j<f;j+=h){
            var m=d[j];
            if(!Kt(m)&&this.sj(m,a,a)==0)return c?j:j+1
                }
                return j==-1?0:j
        }else return f=this.n.duplicate(),h=Ot(d),f.setEndPoint(c?jg:ih,h),f=f.text[B],c?d[B]-f:f
        };

N.isCollapsed=function(){
    return this.n.compareEndPoints(hh,this.n)==0
    };

N.select=function(){
    this.n.select()
    };
N.collapse=function(a){
    this.n[bb](a);
    a?(this.C=this.I,this.L=this.M):(this.I=this.C,this.M=this.L)
    };

function Rt(a){
    this.n=a
    }
    R(Rt,It);
Rt[C].Wd=function(a){
    a[bb](this.ka(),this.Sa());
    (this.Ha()!=this.ka()||this.mb()!=this.Sa())&&a.extend(this.Ha(),this.mb());
    a.rangeCount==0&&a[pd](this.n)
    };

function St(a){
    this.n=a
    }
    R(St,It);
St[C].ja=function(a,b,c){
    if(sp(xf))return St.b.ja[F](this,a,b,c);
    return this.n.compareBoundaryPoints(c==1?b==1?O.Range.START_TO_START:O.Range.END_TO_START:b==1?O.Range.START_TO_END:O.Range.END_TO_END,a)
    };

St[C].Wd=function(a,b){
    a.removeAllRanges();
    b?a.setBaseAndExtent(this.Ha(),this.mb(),this.ka(),this.Sa()):a.setBaseAndExtent(this.ka(),this.Sa(),this.Ha(),this.mb())
    };

function Qt(a){
    if(S&&!up(9)){
        var b=new Nt(Ot(a),Dp(a));
        if(Kt(a)){
            for(var c,d=a;(c=d[Qb])&&Kt(c);)d=c;
            b.I=d;
            b.M=0;
            for(d=a;(c=d[ad])&&Kt(c);)d=c;
            b.C=d;
            b.L=d[eb]==1?d[ac][B]:d[B];
            b.Qa=a
            }else b.I=b.C=b.Qa=a[Dd],b.M=wo(b.Qa[ac],a),b.L=b.M+1;
        a=b
        }else a=ep?new St(Jt(a)):dp?new Mt(Jt(a)):cp?new Rt(Jt(a)):new It(Jt(a));
    return a
    }
function Kt(a){
    var b;
        a:if(a[eb]!=1)b=!1;
        else{
        switch(a[yd]){
            case Pf:case Qf:case Tf:case Vf:case Yf:case ng:case ug:case xg:case yg:case wg:case zg:case Jg:case Sg:case Tg:case Mg:case Wg:case Xg:case ch:case eh:
                b=!1;
                break a
                }
                b=!0
        }
        return b||a[eb]==3
    };

function Tt(a,b){
    a[Vb]($l,b);
    a.ym=b
    }
    function Ut(a,b,c){
    a[Vb](Yh+b,c)
    };

function Vt(a){
    this.k=a;
    a=S?ij:ei;
    this.si=Hq(this.k,S?hj:gj,this,!S);
    this.ti=Hq(this.k,a,this,!S)
    }
    R(Vt,Rq);
Ba(Vt[C],function(a){
    var b=new lq(a.Z);
    Ca(b,a[z]==hj||a[z]==gj?hj:ij);
    try{
        this[w](b)
        }finally{
        b.D()
        }
    });
Vt[C].j=function(){
    Vt.b.j[F](this);
    Lq(this.si);
    Lq(this.ti);
    delete this.k
    };

function Wt(a,b,c,d,f){
    if(!S&&(!ep||!sp(wf)))return!0;
    if(Yo&&f)return Xt(a);
    if(f&&!d)return!1;
    if(!c&&(b==17||b==18))return!1;
    if(S&&d&&b==a)return!1;
    switch(a){
        case 13:
            return!0;
        case 27:
            return!ep
            }
            return Xt(a)
    }
function Xt(a){
    if(a>=48&&a<=57)return!0;
    if(a>=96&&a<=106)return!0;
    if(a>=65&&a<=90)return!0;
    if(ep&&a==0)return!0;
    switch(a){
        case 32:case 63:case 107:case 109:case 110:case 111:case 186:case 189:case 187:case 188:case 190:case 191:case 192:case 222:case 219:case 220:case 221:
            return!0;
        default:
            return!1
            }
        };

function Yt(a){
    this.Eg=a
    }
    R(Yt,eq);
var Zt=new nq(0,100),$t=[];
N=Yt[C];
N.i=function(a,b,c,d,f){
    P(b)||($t[0]=b,b=$t);
    for(var h=0;h<b[B];h++)this.pl(Hq(a,b[h],c||this,d||!1,f||this.Eg||this));
    return this
    };

N.pl=function(a){
    this.o?this.o[a]=!0:this.wa?(this.o=Zt[Ib](),this.o[this.wa]=!0,this.wa=i,this.o[a]=!0):this.wa=a
    };
N.Y=function(a,b,c,d,f){
    if(this.wa||this.o)if(P(b))for(var h=0;h<b[B];h++)this.Y(a,b[h],c,d,f);
        else{
        a:{
            c=c||this;
            f=f||this.Eg||this;
            d=!!d;
            if(a=Kq(a,b,d))for(b=0;b<a[B];b++)if(a[b].ec==c&&a[b][wb]==d&&a[b].sd==f){
                a=a[b];
                break a
            }
            a=i
            }
            if(a)if(a=a.key,Lq(a),this.o)Po(this.o,a);
        else if(this.wa==a)this.wa=i
        }
        return this
    };

N.removeAll=function(){
    if(this.o){
        for(var a in this.o)Lq(a),delete this.o[a];Zt.jc(this.o);
        this.o=i
        }else this.wa&&Lq(this.wa)
        };

N.j=function(){
    Yt.b.j[F](this);
    this[dd]()
    };

Ba(N,function(){
    e(l("EventHandler.handleEvent not implemented"))
    });
function au(a,b,c){
    Oa(this,a);
    this.handle=b||a;
    this.oe=c||new ns(NaN,NaN,NaN,NaN);
    this.m=Dp(a);
    this.Ba=new Yt(this);
    Hq(this.handle,[Om,hl],this.Yf,!1,this)
    }
    R(au,Rq);
var bu=S||dp&&sp("1.9.3");
N=au[C];
Fa(N,0);
Ga(N,0);
va(N,0);
wa(N,0);
N.mg=0;
N.ng=0;
N.Dc=0;
N.Ec=0;
N.ga=!0;
N.gb=!1;
N.kg=0;
N.Li=0;
N.Wi=!1;
N.X=function(){
    return this.Ba
    };

N.j=function(){
    au.b.j[F](this);
    Jq(this.handle,[Om,hl],this.Yf,!1,this);
    this.Ba.D();
    delete this[$c];
    delete this.handle;
    delete this.Ba
    };
N.Yf=function(a){
    var b=a[z]==hl;
    if(this.ga&&!this.gb&&(!b||a.pe())){
        this.Be(a);
        if(this.kg==0)if(this.lg(a),this.gb)a[rb]();else return;else a[rb]();
        this.Mi();
        Fa(this,this.mg=a[mc]);
        Ga(this,this.ng=a[nc]);
        va(this,a[Bb]);
        wa(this,a[Cb]);
        this.Dc=this[$c].offsetLeft;
        this.Ec=this[$c][Gd];
        this.Fc=Bp(this.m).Yb();
        this.Li=Pn()
        }
    };
N.Mi=function(){
    var a=this.m,b=a[oc],c=!bu;
    this.Ba.i(a,[Nm,il],this.Vi,c);
    this.Ba.i(a,[Mm,ll],this.vd,c);
    bu?(b.setCapture(!1),this.Ba.i(b,Vk,this.vd)):this.Ba.i(Jp(a),ei,this.vd);
    S&&this.Wi&&this.Ba.i(a,Xi,kq);
    this.Yi&&this.Ba.i(this.Yi,em,this.Xi,c)
    };

N.lg=function(a){
    if(this[w](new cu(wm,this,a[mc],a[nc],a))!==!1)this.gb=!0
        };
N.vd=function(a,b){
    this.Ba[dd]();
    bu&&this.m.releaseCapture();
    if(this.gb)this.Be(a),this.gb=!1,this[w](new cu($i,this,a[mc],a[nc],a,this.xg(this.Dc),this.yg(this.Ec),b||a[z]==Lm));
    (a[z]==Mm||a[z]==Lm)&&a[rb]()
    };

N.Be=function(a){
    var b=a[z];
    b==Om||b==Nm?a.Ib(a.Z[tb][0],a[zb]):(b==Mm||b==Lm)&&a.Ib(a.Z.changedTouches[0],a[zb])
    };
N.Vi=function(a){
    if(this.ga){
        this.Be(a);
        var b=a[mc]-this[mc],c=a[nc]-this[nc];
        Fa(this,a[mc]);
        Ga(this,a[nc]);
        va(this,a[Bb]);
        wa(this,a[Cb]);
        if(!this.gb){
            var d=this.mg-this[mc],f=this.ng-this[nc];
            if(d*d+f*f>this.kg&&(this.lg(a),!this.gb)){
                this.vd(a);
                return
            }
        }
        c=this.Ng(b,c);
    b=c.x;
    c=c.y;
    this.gb&&this[w](new cu(ci,this,a[mc],a[nc],a,b,c))!==!1&&(this.Og(a,b,c,!1),a[rb]())
    }
};
N.Ng=function(a,b){
    var c=Bp(this.m).Yb();
    a+=c.x-this.Fc.x;
    b+=c.y-this.Fc.y;
    this.Fc=c;
    this.Dc+=a;
    this.Ec+=b;
    return new Tn(this.xg(this.Dc),this.yg(this.Ec))
    };

N.Xi=function(a){
    var b=this.Ng(0,0);
    Fa(a,this.Fc.x-this[mc]);
    Ga(a,this.Fc.y-this[nc]);
    this.Og(a,b.x,b.y,!0)
    };

N.Og=function(a,b,c){
    this.Hl(b,c);
    this[w](new cu(Wi,this,a[mc],a[nc],a,b,c))
    };

N.xg=function(a){
    var b=this.oe,c=!ma(b[x])?b[x]:i,b=!ma(b[s])?b[s]:0;
    return p.min(c!=i?c+b:fa,p.max(c!=i?c:-fa,a))
    };
N.yg=function(a){
    var b=this.oe,c=!ma(b.top)?b.top:i,b=!ma(b[H])?b[H]:0;
    return p.min(c!=i?c+b:fa,p.max(c!=i?c:-fa,a))
    };

N.Hl=function(a,b){
    ua(this[$c][Uc],a+Ol);
    this[$c][Uc].top=b+Ol
    };

function cu(a,b,c,d,f,h,j,m){
    jq[F](this,a);
    Fa(this,c);
    Ga(this,d);
    this.Xl=f;
    ua(this,Bn(h)?h:b.Dc);
    this.top=Bn(j)?j:b.Ec;
    this.Zl=b;
    this.Yl=!!m
    }
    R(cu,jq);
function du(){}
zn(du);
du[C].Nl=0;
du[C].Uk=function(){
    return Af+(this.Nl++)[sc](36)
    };

du.qa();
function eu(a){
    this.Aa=a||Bp();
    this.Ic=fu
    }
    R(eu,Rq);
eu[C].Vk=du.qa();
var fu=i;
function gu(a,b){
    switch(a){
        case 1:
            return b?Ri:Zi;
        case 2:
            return b?rk:Um;
        case 4:
            return b?Nh:Li;
        case 8:
            return b?hm:Vm;
        case 16:
            return b?si:Tm;
        case 32:
            return b?gj:ei;
        case 64:
            return b?yl:yi
            }
            e(l("Invalid component state"))
    }
    N=eu[C];
N.Ad=i;
N.r=!1;
N.k=i;
N.Ic=i;
N.je=i;
N.ya=i;
N.U=i;
N.Xa=i;
N.hi=!1;
N.Sb=function(){
    return this.Ad||(this.Ad=this.Vk.Uk())
    };

N.a=function(){
    return this.k
    };

N.fe=function(a){
    this.k=a
    };
N.X=function(){
    return this.Xb||(this.Xb=new Yt(this))
    };

N.ae=function(a){
    this==a&&e(l(ph));
    a&&this.ya&&this.Ad&&this.ya.ge(this.Ad)&&this.ya!=a&&e(l(ph));
    this.ya=a;
    eu.b.Qe[F](this,a)
    };

N.getParent=function(){
    return this.ya
    };

N.Qe=function(a){
    this.ya&&this.ya!=a&&e(l("Method not supported"));
    eu.b.Qe[F](this,a)
    };

N.A=function(){
    return this.Aa
    };

N.d=function(){
    this.k=this.Aa[Lb](Vi)
    };

N.Ia=function(a){
    this.Of(a)
    };
N.Of=function(a,b){
    this.r&&e(l(cg));
    this.k||this.d();
    a?a[sb](this.k,b||i):this.Aa.m[Wc][Sa](this.k);
    (!this.ya||this.ya.r)&&this.S()
    };

N.S=function(){
    this.r=!0;
    this.Qb(function(a){
        !a.r&&a.a()&&a.S()
        })
    };

N.ea=function(){
    this.Qb(function(a){
        a.r&&a.ea()
        });
    this.Xb&&this.Xb[dd]();
    this.r=!1
    };

N.j=function(){
    eu.b.j[F](this);
    this.r&&this.ea();
    this.Xb&&(this.Xb.D(),delete this.Xb);
    this.Qb(function(a){
        a.D()
        });
    !this.hi&&this.k&&Qp(this.k);
    this.ya=this.je=this.k=this.Xa=this.U=i
    };

N.Ul=function(a){
    this.je=a
    };
N.Ed=function(a,b){
    this.Ac(a,this.Ya(),b)
    };
N.Ac=function(a,b,c){
    a.r&&(c||!this.r)&&e(l(cg));
    (b<0||b>this.Ya())&&e(l("Child component index out of bounds"));
    if(!this.Xa||!this.U)this.Xa={},this.U=[];
    if(a[Wa]()==this)this.Xa[a.Sb()]=a,Co(this.U,a);
    else{
        var d=this.Xa,f=a.Sb();
        f in d&&e(l('The object already contains the key "'+f+Ud));
        d[f]=a
        }
        a.ae(this);
    Go(this.U,b,0,a);
    a.r&&this.r&&a[Wa]()==this?(c=this.P(),c[sb](a.a(),c[ac][b]||i)):c?(this.k||this.d(),b=this.Za(b+1),a.Of(this.P(),b?b.k:i)):this.r&&!a.r&&a.k&&a.S()
    };

N.P=function(){
    return this.k
    };
N.ne=function(){
    if(this.Ic==i)this.Ic=ws(this.r?this.k:this.Aa.m[Wc]);
    return this.Ic
    };

N.$b=function(a){
    this.r&&e(l(cg));
    this.Ic=a
    };

N.Cl=function(){
    return!!this.U&&this.U[B]!=0
    };

N.Ya=function(){
    return this.U?this.U[B]:0
    };

N.ge=function(a){
    if(this.Xa&&a){
        var b=this.Xa,a=a in b?b[a]:g;
        a=a||i
        }else a=i;
    return a
    };

N.Za=function(a){
    return this.U?this.U[a]||i:i
    };

N.Qb=function(a,b){
    this.U&&xo(this.U,a,b)
    };

N.Wc=function(a){
    return this.U&&a?wo(this.U,a):-1
    };
N.removeChild=function(a,b){
    if(a){
        var c=Q(a)?a:a.Sb(),a=this.ge(c);
        c&&a&&(Po(this.Xa,c),Co(this.U,a),b&&(a.ea(),a.k&&Qp(a.k)),a.ae(i))
        }
        a||e(l("Child is not in parent component"));
    return a
    };

N.Dl=function(a,b){
    return this[Xc](this.Za(a),b)
    };

N.He=function(a){
    for(;this.Cl();)this.Dl(0,a)
        };

function hu(a,b,c){
    eu[F](this,c);
    this.ma=a||fl;
    this.ve=!!b;
    this.$a=(new iu).da(ju,!0).da(ku,!1,!0)
    }
    R(hu,eu);
N=hu[C];
N.Sc=i;
N.Ii=!0;
N.Qf=!0;
N.ve=!1;
N.ud=!0;
N.Kf=!0;
N.ri=0.5;
N.ki=J;
N.la=J;
N.$a=i;
N.Tb=i;
N.s=!1;
N.$h=!1;
N.J=i;
N.G=i;
N.$c=i;
N.Rc=i;
N.Sf=i;
N.Qc=i;
N.tc=i;
N.Wa=i;
Da(N,function(a){
    this.la=a;
    this.tc&&ra(this.tc,a)
    });
N.of=function(){
    this.a()||this.Ia()
    };

N.P=function(){
    this.of();
    return this.tc
    };

N.cj=function(){
    this.of();
    return this.Rc
    };

N.bj=function(){
    this.of();
    return this.Wa
    };
N.di=function(){
    var a=new au(this.a(),this.$c);
    zp(this.$c,this.ma+Ve);
    return a
    };
N.d=function(){
    this.ji();
    var a=this.A();
    this.fe(a.d(Vi,{
        className:this.ma,
        tabIndex:0
    },this.$c=a.d(Vi,{
        className:this.ma+Te,
        id:this.Sb()
        },this.Rc=a.d(um,this.ma+We,this.ki),this.Qc=a.d(um,this.ma+Ue)),this.tc=a.d(Vi,this.ma+Fe),this.Wa=a.d(Vi,this.ma+Be),this.Gf=a.d(um,{
        tabIndex:0
    })));
    this.Sf=this.$c.id;
    Tt(this.a(),Oi);
    Ut(this.a(),Qk,this.Sf||J);
    this.la&&ra(this.tc,this.la);
    Bs(this.Qc,this.Qf);
    Bs(this.a(),!1);
    this.$a&&this.$a.ii(this.Wa)
    };
N.ji=function(){
    if(this.ve&&this.ud&&!this.G)this.G=this.A().d(Bk,{
        frameborder:0,
        style:hi,
        src:Ik
    }),La(this.G,this.ma+Ae),Bs(this.G,!1),As(this.G,0);
    else if((!this.ve||!this.ud)&&this.G)Qp(this.G),this.G=i;
    if(this.ud&&!this.J)this.J=this.A().d(Vi,this.ma+Ae),As(this.J,this.ri),Bs(this.J,!1);
    else if(!this.ud&&this.J)Qp(this.J),this.J=i
        };

N.Ia=function(a){
    this.r&&e(l(cg));
    this.a()||this.d();
    a=a||this.A().m[Wc];
    this.gi(a);
    hu.b.Ia[F](this,a)
    };

N.gi=function(a){
    this.G&&a[Sa](this.G);
    this.J&&a[Sa](this.J)
    };
N.S=function(){
    hu.b.S[F](this);
    this.Sc=new Vt(this.A().m);
    if(this.Kf&&!this.Tb)this.Tb=this.di();
    this.X().i(this.Qc,xi,this.fi).i(this.Sc,hj,this.ei);
    Tt(this.a(),Oi);
    this.Rc.id!==J&&Ut(this.a(),Qk,this.Rc.id)
    };

N.ea=function(){
    this.s&&this.N(!1);
    this.Sc.D();
    this.Sc=i;
    if(this.Tb)this.Tb.D(),this.Tb=i;
    hu.b.ea[F](this)
    };
N.N=function(a){
    if(a!=this.s){
        var b=this.A().m,c=Jp(b)||ca;
        this.r||this.Ia(b[Wc]);
        a?(this.Jf(),this.rb(),this.X().i(this.a(),Nk,this.Tc).i(this.a(),Ok,this.Tc).i(c,Xl,this.If)):this.X().Y(this.a(),Nk,this.Tc).Y(this.a(),Ok,this.Tc).Y(c,Xl,this.If);
        this.G&&Bs(this.G,a);
        this.J&&Bs(this.J,a);
        Bs(this.a(),a);
        a&&this[Kb]();
        (this.s=a)?this.X().i(this.Wa,xi,this.Hf):(this.X().Y(this.Wa,xi,this.Hf),this[w](Qh),this.$h&&this.D())
        }
    };
N.focus=function(){
    try{
        this.a()[Kb]()
        }catch(a){}
    if(this.$a){
        var b=this.$a.Xc;
        if(b)for(var c=this.A().m,d=this.Wa[lc](mi),f=0,h;h=d[f];f++)if(h[gc]==b){
            try{
                if(ep||cp){
                    var j=c[Lb](Gk);
                    j[Uc].cssText=Kl;
                    this.a()[Sa](j);
                    j[Kb]();
                    this.a()[Xc](j)
                    }
                    h[Kb]()
                }catch(m){}
            break
        }
        }
        };
N.Jf=function(){
    this.G&&Bs(this.G,!1);
    this.J&&Bs(this.J,!1);
    var a=this.A().m,b=Hp(Jp(a)||ca||ca),c=p.max(a[Wc].scrollWidth,b[s]),a=p.max(a[Wc][Ob],b[H]);
    this.G&&(Bs(this.G,!0),xs(this.G,c,a));
    this.J&&(Bs(this.J,!0),xs(this.J,c,a));
    if(this.Kf)b=ys(this.a()),this.Tb.oe=new ns(0,0,c-b[s],a-b[H])
        };

N.rb=function(){
    var a=this.A().m,b=Jp(a)||ca;
    if(ps(this.a(),Jl)==fj)var c=a=0;else c=this.A().Yb(),a=c.x,c=c.y;
    var d=ys(this.a()),b=Hp(b||ca);
    qs(this.a(),p.max(a+b[s]/2-d[s]/2,0),p.max(c+b[H]/2-d[H]/2,0))
    };
N.fi=function(){
    if(this.Qf){
        var a=this.$a,b=a&&a.Ie;
        b?(a=a.get(b),this[w](new lu(b,a))&&this.N(!1)):this.N(!1)
        }
    };

N.j=function(){
    hu.b.j[F](this);
    if(this.J)Qp(this.J),this.J=i;
    if(this.G)Qp(this.G),this.G=i;
    this.Gf=this.Wa=this.Qc=i
    };

N.Hf=function(a){
    if((a=this.nk(a[$c]))&&!a[Rc]){
        var a=a[gc],b=this.$a.get(a);
        this[w](new lu(a,b))&&this.N(!1)
        }
    };

N.nk=function(a){
    for(;a!=i&&a!=this.Wa;){
        if(a[yd]==Wf)return a;
        a=a[Dd]
        }
        return i
    };
N.Tc=function(a){
    var b=!1,c=!1,d=this.$a,f=a[$c];
    if(a[z]==Nk)if(this.Ii&&a[Pb]==27){
        var h=d&&d.Ie,f=f[yd]==dh&&!f[Rc];
        h&&!f?(c=!0,b=d.get(h),b=this[w](new lu(h,b))):f||(b=!0)
        }else a[Pb]==9&&a[xd]&&f==this.a()&&(c=!0);
    else if(a[Pb]==13){
        if(f[yd]==Wf)h=f[gc];
        else if(d){
            var j=d.Xc,m=j&&d.Ji(j),f=(f[yd]==jh||f[yd]==dh)&&!f[Rc];
            m&&!m[Rc]&&!f&&(h=j)
            }
            h&&(c=!0,b=this[w](new lu(h,ja(d.get(h)))))
        }
        if(b||c)a[Mc](),a[rb]();
    b&&this.N(!1)
    };

N.If=function(){
    this.Jf()
    };
N.ei=function(a){
    if(this.Gf==a[$c])a=this.ll,Gn(a)?this&&(a=Nn(a,this)):a&&typeof a[Xb]==mj?a=Nn(a[Xb],a):e(l(Eg)),Xq[Fc](a,0)
        };

N.ll=function(){
    S&&this.A().m[Wc][Kb]();
    this.a()[Kb]()
    };

function lu(a,b){
    Ca(this,Pi);
    this.key=a;
    this.caption=b
    }
    R(lu,jq);
function iu(a){
    this.Aa=a||Bp();
    cq[F](this)
    }
    R(iu,cq);
N=iu[C];
N.ma="goog-buttonset";
N.Xc=i;
N.k=i;
N.Ie=i;
N.set=function(a,b,c,d){
    cq[C].set[F](this,a,b);
    if(c)this.Xc=a;
    if(d)this.Ie=a;
    return this
    };

N.da=function(a,b,c){
    return this.set(a.key,a.caption,b,c)
    };
N.ii=function(a){
    this.k=a;
    this.Ia()
    };

N.Ia=function(){
    if(this.k){
        ra(this.k,J);
        var a=Bp(this.k);
        bq(this,function(b,c){
            var d=a.d(mi,{
                name:c
            },b);
            c==this.Xc&&La(d,this.ma+Ge);
            this.k[Sa](d)
            },this)
        }
    };

N.a=function(){
    return this.k
    };

N.A=function(){
    return this.Aa
    };

N.Ji=function(a){
    for(var b=this.Il(),c=0,d;d=b[c];c++)if(d[gc]==a||d.id==a)return d;return i
    };

N.Il=function(){
    return this.k[lc](Wf)
    };

var ju={
    key:"ok",
    caption:"OK"
},ku={
    key:"cancel",
    caption:"Cancel"
},mu={
    key:"yes",
    caption:"Yes"
},nu={
    key:"no",
    caption:"No"
};
(new iu).da(ju,!0,!0);
(new iu).da(ju,!0).da(ku,!1,!0);
(new iu).da(mu,!0).da(nu,!1,!0);
(new iu).da(mu).da(nu,!0).da(ku,!1,!0);
(new iu).da({
    key:"continue",
    caption:"Continue"
}).da({
    key:"save",
    caption:"Save"
}).da(ku,!0,!0);
function ou(a,b){
    a&&this.Rf(a,b)
    }
    R(ou,Rq);
N=ou[C];
N.k=i;
N.Gd=i;
N.Xe=i;
N.Hd=i;
N.jb=-1;
N.ib=-1;
var pu={
    "3":13,
    "12":144,
    "63232":38,
    "63233":40,
    "63234":37,
    "63235":39,
    "63236":112,
    "63237":113,
    "63238":114,
    "63239":115,
    "63240":116,
    "63241":117,
    "63242":118,
    "63243":119,
    "63244":120,
    "63245":121,
    "63246":122,
    "63247":123,
    "63248":44,
    "63272":46,
    "63273":36,
    "63275":35,
    "63276":33,
    "63277":34,
    "63289":144,
    "63302":45
},qu={
    Up:38,
    Down:40,
    Left:37,
    Right:39,
    Enter:13,
    F1:112,
    F2:113,
    F3:114,
    F4:115,
    F5:116,
    F6:117,
    F7:118,
    F8:119,
    F9:120,
    F10:121,
    F11:122,
    F12:123,
    "U+007F":46,
    Home:36,
    End:35,
    PageUp:33,
    PageDown:34,
    Insert:45
},ru={
    61:187,
    59:186
},su=S||ep&&sp(wf);
N=ou[C];
N.tj=function(a){
    if(ep&&(this.jb==17&&!a[Ic]||this.jb==18&&!a[tc]))this.ib=this.jb=-1;
    su&&!Wt(a[Pb],this.jb,a[xd],a[Ic],a[tc])?this[Xb](a):this.ib=dp&&a[Pb]in ru?ru[a[Pb]]:a[Pb]
    };

N.uj=function(){
    this.ib=this.jb=-1
    };
Ba(N,function(a){
    var b=a.Z,c,d;
    S&&a[z]==Ok?(c=this.ib,d=c!=13&&c!=27?b[Pb]:0):ep&&a[z]==Ok?(c=this.ib,d=b[Hb]>=0&&b[Hb]<63232&&Xt(c)?b[Hb]:0):cp?(c=this.ib,d=Xt(c)?b[Pb]:0):(c=b[Pb]||this.ib,d=b[Hb]||0,Yo&&d==63&&!c&&(c=191));
    var f=c,h=b.keyIdentifier;
    c?c>=63232&&c in pu?f=pu[c]:c==25&&a[xd]&&(f=9):h&&h in qu&&(f=qu[h]);
    a=f==this.jb;
    this.jb=f;
    b=new tu(f,d,a,b);
    try{
        this[w](b)
        }finally{
        b.D()
        }
    });
N.a=function(){
    return this.k
    };
N.Rf=function(a,b){
    this.Hd&&this.detach();
    this.k=a;
    this.Gd=Hq(this.k,Ok,this,b);
    this.Xe=Hq(this.k,Nk,this.tj,b,this);
    this.Hd=Hq(this.k,Pk,this.uj,b,this)
    };

N.detach=function(){
    if(this.Gd)Lq(this.Gd),Lq(this.Xe),Lq(this.Hd),this.Hd=this.Xe=this.Gd=i;
    this.k=i;
    this.ib=this.jb=-1
    };

N.j=function(){
    ou.b.j[F](this);
    this.detach()
    };

function tu(a,b,c,d){
    d&&this.Ib(d,g);
    Ca(this,Mk);
    Aa(this,a);
    this.charCode=b;
    this.repeat=c
    }
    R(tu,lq);
function uu(){}
var vu;
zn(uu);
N=uu[C];
N.lb=function(){};

N.d=function(a){
    return a.A().d(Vi,this.fc(a)[I](Pd),a.la)
    };

N.P=function(a){
    return a
    };

N.zd=function(a,b,c){
    if(a=a.a?a.a():a)if(S&&!sp(yf)){
        var d=this.sg(yp(a),b);
        d[r](b);
        On(c?zp:Ap,a)[wd](i,d)
        }else c?zp(a,b):Ap(a,b)
        };

N.Vg=function(a,b,c){
    this.zd(a,b,c)
    };

N.Rb=function(a){
    a.ne()&&this.$b(a.a(),!0);
    a[cd]()&&this.ub(a,a.s)
    };

N.qi=function(a){
    var b=this.lb();
    b&&Tt(a,b)
    };

N.ad=function(a,b){
    Ds(a,!b,!S&&!cp)
    };

N.$b=function(a,b){
    this.zd(a,this.pc()+Qe,b)
    };
N.pb=function(a){
    var b;
    if(a.ba(32)&&(b=a.O()))return Wp(b);
    return!1
    };

N.ub=function(a,b){
    var c;
    if(a.ba(32)&&(c=a.O())){
        if(!b&&a.Wg()){
            try{
                c.blur()
                }catch(d){}
            a.Wg()&&a.sb(i)
            }
            if(Wp(c)!=b)b?c.tabIndex=0:c.removeAttribute(Cm)
            }
        };

N.N=function(a,b){
    Bs(a,b)
    };

Ia(N,function(a,b,c){
    var d=a.a();
    if(d){
        var f=this.od(b);
        f&&this.zd(a,f,c);
        this.uc(d,b,c)
        }
    });
N.uc=function(a,b,c){
    vu||(vu=So(1,Si,4,Ml,8,im,16,ti,64,cj));
    (b=vu[b])&&Ut(a,b,c)
    };
Da(N,function(a,b){
    var c=this.P(a);
    if(c&&(Pp(c),b))if(Q(b))Sp(c,b);
        else{
        var d=function(a){
            if(a){
                var b=Dp(c);
                c[Sa](Q(a)?b[mb](a):a)
                }
            };

    P(b)?xo(b,d):Cn(b)&&!(rl in b)?xo(Eo(b),d):d(b)
        }
    });
N.O=function(a){
    return a.a()
    };

N.Q=function(){
    return Lj
    };

N.pc=function(){
    return this.Q()
    };

N.fc=function(a){
    var b=this.Q(),c=[b],d=this.pc();
    d!=b&&c[r](d);
    b=this.Yj(a[md]());
    c[r][wd](c,b);
    (a=a.Ea)&&c[r][wd](c,a);
    S&&!sp(yf)&&c[r][wd](c,this.sg(c));
    return c
    };
N.sg=function(a,b){
    var c=[];
    b&&(a=a[kb]([b]));
    xo([],function(d){
        Ao(d,On(Bo,a))&&(!b||Bo(d,b))&&c[r](d[I](Eh))
        });
    return c
    };

N.Yj=function(a){
    for(var b=[];a;){
        var c=a&-a;
        b[r](this.od(c));
        a&=~c
        }
        return b
    };

N.od=function(a){
    this.Ah||this.kl();
    return this.Ah[a]
    };

N.kl=function(){
    var a=this.pc();
    this.Ah=So(1,a+He,2,a+Me,4,a+ze,8,a+Re,16,a+Ee,32,a+Je,64,a+Oe)
    };

function wu(a,b){
    a||e(l("Invalid class name "+a));
    Gn(b)||e(l("Invalid decorator function "+b))
    }
    var xu={};

function yu(a,b,c){
    eu[F](this,c);
    if(!b){
        for(var b=this[Lc],d;b;){
            d=Hn(b);
            if(d=xu[d])break;
            b=b.b?b.b[Lc]:i
            }
            b=d?Gn(d.qa)?d.qa():new d:i
        }
        this.l=b;
    this.Xf(a)
    }
    R(yu,eu);
N=yu[C];
N.la=i;
N.Na=0;
N.sc=39;
N.Vd=255;
N.Qd=0;
N.s=!0;
N.Ea=i;
N.he=!0;
N.ie=!1;
N.me=function(a){
    this.r&&a!=this.he&&this.Pf(a);
    this.he=a
    };

N.O=function(){
    return this.l.O(this)
    };

N.Yc=function(){
    return this.ia||(this.ia=new ou)
    };

N.xl=function(a){
    if(a)this.Ea?Bo(this.Ea,a)||this.Ea[r](a):this.Ea=[a],this.l.Vg(this,a,!0)
        };
N.El=function(a){
    if(a&&this.Ea){
        Co(this.Ea,a);
        if(this.Ea[B]==0)this.Ea=i;
        this.l.Vg(this,a,!1)
        }
    };

N.zd=function(a,b){
    b?this.xl(a):this.El(a)
    };

N.d=function(){
    var a=this.l.d(this);
    this.fe(a);
    this.l.qi(a);
    this.ie||this.l.ad(a,!1);
    this.s||this.l.N(a,!1)
    };

N.P=function(){
    return this.l.P(this.a())
    };

N.S=function(){
    yu.b.S[F](this);
    this.l.Rb(this);
    if(this.sc&-2&&(this.he&&this.Pf(!0),this.ba(32))){
        var a=this.O();
        if(a){
            var b=this.Yc();
            b.Rf(a);
            this.X().i(b,Mk,this.Ja).i(a,gj,this.Zc).i(a,ei,this.sb)
            }
        }
};
N.Pf=function(a){
    var b=this.X(),c=this.a();
    a?(b.i(c,kl,this.se).i(c,hl,this.qb).i(c,ll,this.tb).i(c,jl,this.re),S&&b.i(c,Ki,this.Zf)):(b.Y(c,kl,this.se).Y(c,hl,this.qb).Y(c,ll,this.tb).Y(c,jl,this.re),S&&b.Y(c,Ki,this.Zf))
    };

N.ea=function(){
    yu.b.ea[F](this);
    this.ia&&this.ia.detach();
    this.s&&this[cd]()&&this.l.ub(this,!1)
    };

N.j=function(){
    yu.b.j[F](this);
    this.ia&&(this.ia.D(),delete this.ia);
    delete this.l;
    this.Ea=this.la=i
    };

Da(N,function(a){
    this.l[fc](this.a(),a);
    this.Xf(a)
    });
N.Xf=function(a){
    this.la=a
    };

N.vc=function(){
    var a=this.la;
    if(!a)return J;
    if(!Q(a))if(P(a))a=zo(a,Xp)[I](J);
        else{
        if(xp&&Fk in a)a=a.innerText[t](/(\r\n|\r|\n)/g,Nd);
        else{
            var b=[];
            Yp(a,b,!0);
            a=b[I](J)
            }
            a=a[t](/ \xAD /g,Pd)[t](/\xAD/g,J);
        a=a[t](/\u200B/g,J);
        S||(a=a[t](/ +/g,Pd));
        a!=Pd&&(a=a[t](/^\s*/,J))
        }
        return Wn(a)
    };

N.$b=function(a){
    yu.b.$b[F](this,a);
    var b=this.a();
    b&&this.l.$b(b,a)
    };

N.ad=function(a){
    this.ie=a;
    var b=this.a();
    b&&this.l.ad(b,a)
    };
N.N=function(a,b){
    if(b||this.s!=a&&this[w](a?rm:qk)){
        var c=this.a();
        c&&this.l.N(c,a);
        this[cd]()&&this.l.ub(this,a);
        this.s=a;
        return!0
        }
        return!1
    };

N.isEnabled=function(){
    return!this.za(1)
    };

N.Ka=function(a){
    this.rc(2,a)&&this[qc](2,a)
    };

N.Ca=function(){
    return this.za(4)
    };

N.setActive=function(a){
    this.rc(4,a)&&this[qc](4,a)
    };

N.bf=function(a){
    this.rc(8,a)&&this[qc](8,a)
    };

N.Pj=function(){
    return this.za(16)
    };

N.Rj=function(a){
    this.rc(16,a)&&this[qc](16,a)
    };

N.Wg=function(){
    return this.za(32)
    };
N.rh=function(a){
    this.rc(32,a)&&this[qc](32,a)
    };

N.ed=function(){
    return this.za(64)
    };

N.H=function(a){
    this.rc(64,a)&&this[qc](64,a)
    };

N.getState=function(){
    return this.Na
    };

N.za=function(a){
    return!!(this.Na&a)
    };

Ia(N,function(a,b){
    if(this.ba(a)&&b!=this.za(a))this.l[qc](this,a,b),this.Na=b?this.Na|a:this.Na&~a
        });
N.gh=function(a){
    this.Na=a
    };

N.ba=function(a){
    return!!(this.sc&a)
    };

N.pa=function(a,b){
    this.r&&this.za(a)&&!b&&e(l(cg));
    !b&&this.za(a)&&this[qc](a,!1);
    this.sc=b?this.sc|a:this.sc&~a
    };
N.ca=function(a){
    return!!(this.Vd&a)&&this.ba(a)
    };

N.Ek=function(a,b){
    this.Vd=b?this.Vd|a:this.Vd&~a
    };

N.cg=function(a,b){
    this.Qd=b?this.Qd|a:this.Qd&~a
    };

N.rc=function(a,b){
    return this.ba(a)&&this.za(a)!=b&&(!(this.Qd&a)||this[w](gu(a,b)))&&!this.Ze
    };

N.se=function(a){
    (!a[$a]||!Rp(this.a(),a[$a]))&&this[w](aj)&&this[cd]()&&this.ca(2)&&this.Ka(!0)
    };

N.re=function(a){
    if((!a[$a]||!Rp(this.a(),a[$a]))&&this[w](Rk))this.ca(4)&&this[kc](!1),this.ca(2)&&this.Ka(!1)
        };
N.qb=function(a){
    this[cd]()&&(this.ca(2)&&this.Ka(!0),a.pe()&&(this.ca(4)&&this[kc](!0),this.l.pb(this)&&this.O()[Kb]()));
    !this.ie&&a.pe()&&a[rb]()
    };

N.tb=function(a){
    this[cd]()&&(this.ca(2)&&this.Ka(!0),this.Ca()&&this.bc(a)&&this.ca(4)&&this[kc](!1))
    };

N.Zf=function(a){
    this[cd]()&&this.bc(a)
    };

N.bc=function(a){
    this.ca(16)&&this.Rj(!this.Pj());
    this.ca(8)&&this.bf(!0);
    this.ca(64)&&this.H(!this.ed());
    var b=new jq(Mh,this);
    if(a)for(var c=[Vh,Gi,dl,pm,Hl],d,f=0;d=c[f];f++)b[d]=a[d];
    return this[w](b)
    };
N.Zc=function(){
    this.ca(32)&&this.rh(!0)
    };

N.sb=function(){
    this.ca(4)&&this[kc](!1);
    this.ca(32)&&this.rh(!1)
    };

N.Ja=function(a){
    if(this.s&&this[cd]()&&this.ac(a))return a[rb](),a[Mc](),!0;
    return!1
    };

N.ac=function(a){
    return a[Pb]==13&&this.bc(a)
    };

Gn(yu)||e(l("Invalid component class "+yu));
Gn(uu)||e(l("Invalid renderer class "+uu));
var zu=Hn(yu);
xu[zu]=uu;
wu(Lj,function(){
    return new yu(i)
    });
function Au(){
    this.Dh=[]
    }
    R(Au,uu);
zn(Au);
N=Au[C];
N.ld=function(a){
    var b=this.Dh[a];
    if(!b){
        switch(a){
            case 0:
                b=this.pc()+Ke;
                break;
            case 1:
                b=this.pc()+De;
                break;
            case 2:
                b=this.pc()+Fe
                }
                this.Dh[a]=b
        }
        return b
    };

N.lb=function(){
    return bl
    };

N.d=function(a){
    var b=a.A().d(Vi,this.fc(a)[I](Pd),this.Hi(a.la,a.A()));
    this.Ki(a,b,a.ba(8)||a.ba(16));
    return b
    };

N.P=function(a){
    return a&&a[Qb]
    };

Da(N,function(a,b){
    var c=this.P(a),d=this.te(a)?c[Qb]:i;
    Au.b[fc][F](this,a,b);
    d&&!this.te(a)&&c[sb](d,c[Qb]||i)
    });
N.Hi=function(a,b){
    var c=this.ld(2);
    return b.d(Vi,c,a)
    };

N.te=function(a){
    if(a=this.P(a)){
        var a=a[Qb],b=this.ld(1);
        return!!a&&!!a.className&&a.className[v](b)!=-1
        }
        return!1
    };

N.Ki=function(a,b,c){
    if(c!=this.te(b))if(c?zp(b,Uj):Ap(b,Uj),b=this.P(b),c)c=this.ld(1),b[sb](a.A().d(Vi,c),b[Qb]||i);else b[Xc](b[Qb])
        };

N.od=function(a){
    switch(a){
        case 2:
            return this.ld(0);
        case 16:case 8:
            return Vj;
        default:
            return Au.b.od[F](this,a)
            }
        };

N.Q=function(){
    return Rj
    };

function Bu(a,b,c,d){
    yu[F](this,a,d||Au.qa(),c);
    this[Cc](b)
    }
    R(Bu,yu);
Ea(Bu[C],function(){
    var a=this.je;
    return a!=i?a:this.vc()
    });
Ka(Bu[C],function(a){
    this.Ul(a)
    });
Bu[C].vc=function(){
    var a=this.la;
    if(P(a))return a=zo(a,function(a){
        return Bo(yp(a),Sj)?J:Xp(a)
        })[I](J),Wn(a);
    return Bu.b.vc[F](this)
    };

Bu[C].tb=function(a){
    var b=this[Wa]();
    if(b){
        var c=b.bg;
        b.bg=i;
        if(b=c&&Fn(a[mc]))b=new Tn(a[mc],a[nc]),b=c==b?!0:!c||!b?!1:c.x==b.x&&c.y==b.y;
        if(b)return
    }
    Bu.b.tb[F](this,a)
    };

wu(Rj,function(){
    return new Bu(i)
    });
function Cu(a){
    return function(){
        return a
        }
    }
var Du=Cu(!1),Eu=Cu(!0);
function Fu(a,b,c,d,f,h,j,m){
    var q,u=c.offsetParent;
    if(u){
        var D=u[yd]==vg||u[yd]==Uf;
        if(!D||ps(u,Jl)!=ym)q=vs(u),D||(q=Un(q,new Tn(u[od],u[rc])))
            }
            u=zs(a);
    (D=us(a))&&u.qj(new ns(D[x],D.top,D[Kd]-D[x],D[sd]-D.top));
    var D=Bp(a),E=Bp(c);
    if(D.m!=E.m){
        var K=D.m[Wc],E=E.Mg(),G=new Tn(0,0),sa=Jp(Dp(K)),qa=K;
        do{
            var xa;
            if(sa==E)xa=vs(qa);
            else{
                var W=qa;
                xa=new Tn;
                if(W[eb]==1)if(W[Va])W=ss(W),xa.x=W[x],xa.y=W.top;
                    else{
                    var ia=Bp(W).Yb(),W=vs(W);
                    xa.x=W.x-ia.x;
                    xa.y=W.y-ia.y
                    }else{
                    var ia=Gn(W.pj),ya=W;
                    W[tb]?ya=W[tb][0]:
                    ia&&W.Z[tb]&&(ya=W.Z[tb][0]);
                    xa.x=ya[mc];
                    xa.y=ya[nc]
                    }
                }
            G.x+=xa.x;
        G.y+=xa.y
        }while(sa&&sa!=E&&(qa=sa.frameElement)&&(sa=sa.parent));
    K=Un(G,vs(K));
    S&&!D.Lg()&&(K=Un(K,D.Yb()));
    u.left+=K.x;
    u.top+=K.y
    }
    a=(b&4&&ws(a)?b^2:b)&-5;
b=new Tn(a&2?u[x]+u[s]:u[x],a&1?u.top+u[H]:u.top);
q&&(b=Un(b,q));
f&&(b.x+=(a&2?-1:1)*f.x,b.y+=(a&1?-1:1)*f.y);
var $;
if(j&&($=us(c))&&q)$.top=p.max(0,$.top-q.y),$.right-=q.x,$.bottom-=q.y,ua($,p.max(0,$[x]-q.x));
    a:{
    q=$;
    f=b[Yc]();
    $=0;
    a=(d&4&&ws(c)?d^2:d)&-5;
    d=ys(c);
    m=m?m[Yc]():d[Yc]();
    if(h||a!=0)a&2?f.x-=m[s]+(h?h[Kd]:0):h&&(f.x+=h[x]),a&1?f.y-=m[H]+(h?h[sd]:0):h&&(f.y+=h.top);
    if(j){
        if(q){
            h=f;
            $=0;
            if((j&65)==65&&(h.x<q[x]||h.x+m[s]>q[Kd]))j&=-2;
            if((j&132)==132&&(h.y<q.top||h.y+m[H]>q[sd]))j&=-5;
            if(h.x<q[x]&&j&1)h.x=q[x],$|=1;
            h.x<q[x]&&h.x+m[s]>q[Kd]&&j&16&&(m.width-=h.x+m[s]-q[Kd],$|=4);
            if(h.x+m[s]>q[Kd]&&j&1)h.x=p.max(q[Kd]-m[s],q[x]),$|=1;
            j&2&&($|=(h.x<q[x]?16:0)|(h.x+m[s]>q[Kd]?32:0));
            if(h.y<q.top&&j&4)h.y=q.top,$|=2;
            h.y>=q.top&&h.y+m[H]>q[sd]&&j&32&&(m.height-=h.y+m[H]-q[sd],
                $|=8);
            if(h.y+m[H]>q[sd]&&j&4)h.y=p.max(q[sd]-m[H],q.top),$|=2;
            j&8&&($|=(h.y<q.top?64:0)|(h.y+m[H]>q[sd]?128:0));
            j=$
            }else j=256;
        $=j;
        if($&496){
            c=$;
            break a
        }
    }
    qs(c,f);
    j=d==m?!0:!d||!m?!1:d[s]==m[s]&&d[H]==m[H];
    j||xs(c,m);
    c=$
    }
    return c
};

function Gu(){}
Gu[C].rb=function(){};

function Hu(a,b){
    this.element=a;
    this.kc=b
    }
    R(Hu,Gu);
Hu[C].rb=function(a,b,c){
    Fu(this[Ad],this.kc,a,b,g,c)
    };

function Iu(a,b,c){
    Hu[F](this,a,b);
    this.Mk=c
    }
    R(Iu,Hu);
Iu[C].zh=Du;
Iu[C].rb=function(a,b,c,d){
    var f=Fu(this[Ad],this.kc,a,b,i,c,10,d);
    if(f&496){
        var h=this.kc,j=b;
        f&48&&(h^=2,j^=2);
        f&192&&(h^=1,j^=1);
        f=Fu(this[Ad],h,a,j,i,c,10,d);
        f&496&&(this.Mk?(f=this.zh()?197:5,Fu(this[Ad],this.kc,a,b,i,c,f,d)):Fu(this[Ad],this.kc,a,b,i,c,0,d))
        }
    };

function Ju(a,b,c,d){
    Iu[F](this,a,b,c);
    this.dj=d
    }
    R(Ju,Iu);
Ju[C].zh=Eu;
Ju[C].rb=function(a,b,c,d){
    this.dj?Fu(this[Ad],this.kc,a,b,i,c,97,d):Ju.b.rb[F](this,a,b,c,d)
    };

function Ku(){}
R(Ku,uu);
zn(Ku);
N=Ku[C];
N.lb=function(){
    return mi
    };

N.uc=function(a,b,c){
    b==16?Ut(a,Ml,c):Ku.b.uc[F](this,a,b,c)
    };

N.d=function(a){
    var b=Ku.b.d[F](this,a),c=a.dd();
    c&&this.le(b,c);
    (c=a[A]())&&this[Cc](b,c);
    a.ba(16)&&this.uc(b,16,!1);
    return b
    };

Ea(N,yn);
Ka(N,yn);
N.dd=function(a){
    return a.title
    };

N.le=function(a,b){
    if(a)a.title=b||J
        };

N.Q=function(){
    return Jj
    };

function Lu(){}
R(Lu,Ku);
zn(Lu);
N=Lu[C];
N.lb=function(){};

N.d=function(a){
    this.Ni(a);
    return a.A().d(mi,{
        "class":this.fc(a)[I](Pd),
        disabled:!a[cd](),
        title:a.dd()||J,
        value:a[A]()||J
        },a.vc()||J)
    };

N.Rb=function(a){
    a.X().i(a.a(),xi,a.bc)
    };

N.ad=yn;
N.$b=yn;
N.pb=function(a){
    return a[cd]()
    };

N.ub=yn;
Ia(N,function(a,b,c){
    Lu.b[qc][F](this,a,b,c);
    if((a=a.a())&&b==1)a.disabled=c
        });
Ea(N,function(a){
    return a[pb]
    });
Ka(N,function(a,b){
    if(a)a.value=b
        });
N.uc=yn;
N.Ni=function(a){
    a.me(!1);
    a.Ek(255,!1);
    a.pa(32,!1)
    };

function Mu(a,b,c){
    yu[F](this,a,b||Lu.qa(),c)
    }
    R(Mu,yu);
N=Mu[C];
Ea(N,function(){
    return this.Vf
    });
Ka(N,function(a){
    this.Vf=a;
    this.l[Cc](this.a(),a)
    });
N.dd=function(){
    return this.Tf
    };

N.le=function(a){
    this.Tf=a;
    this.l.le(this.a(),a)
    };

N.j=function(){
    Mu.b.j[F](this);
    delete this.Vf;
    delete this.Tf
    };

N.S=function(){
    Mu.b.S[F](this);
    if(this.ba(32)){
        var a=this.O();
        a&&this.X().i(a,Pk,this.ac)
        }
    };

N.ac=function(a){
    if(a[Pb]==13&&a[z]==Mk||a[Pb]==32&&a[z]==Pk)return this.bc(a);
    return a[Pb]==32
    };

wu(Jj,function(){
    return new Mu(i)
    });
function Nu(){}
R(Nu,uu);
zn(Nu);
Nu[C].d=function(a){
    return a.A().d(Vi,this.Q())
    };

Da(Nu[C],function(){});
Nu[C].Q=function(){
    return Tj
    };

function Ou(a,b){
    yu[F](this,i,a||Nu.qa(),b);
    this.pa(1,!1);
    this.pa(2,!1);
    this.pa(4,!1);
    this.pa(32,!1);
    this.gh(1)
    }
    R(Ou,yu);
Ou[C].S=function(){
    Ou.b.S[F](this);
    Tt(this.a(),jm)
    };

wu(Tj,function(){
    return new Ou
    });
function Pu(){}
zn(Pu);
N=Pu[C];
N.lb=function(){};

N.Uf=function(a,b){
    if(a)a.tabIndex=b?0:-1
        };

N.d=function(a){
    return a.A().d(Vi,this.fc(a)[I](Pd))
    };

N.P=function(a){
    return a
    };

N.Rb=function(a){
    a=a.a();
    Ds(a,!0,dp);
    if(S)a.hideFocus=!0;
    var b=this.lb();
    b&&Tt(a,b)
    };

N.O=function(a){
    return a.a()
    };

N.Q=function(){
    return Kj
    };

N.fc=function(a){
    var b=this.Q(),c=[b,a.dc==sk?b+Le:b+Xe];
    a[cd]()||c[r](b+He);
    return c
    };

function Qu(a,b,c){
    eu[F](this,c);
    this.l=b||Pu.qa();
    this.dc=a||bn
    }
    R(Qu,eu);
N=Qu[C];
N.wg=i;
N.ia=i;
N.l=i;
N.dc=i;
N.s=!0;
N.ga=!0;
N.Ge=!0;
N.ha=-1;
N.K=i;
N.ke=!1;
N.pi=!1;
N.oi=!0;
N.ab=i;
N.O=function(){
    return this.wg||this.l.O(this)
    };

N.Yc=function(){
    return this.ia||(this.ia=new ou(this.O()))
    };

N.d=function(){
    this.fe(this.l.d(this))
    };

N.P=function(){
    return this.l.P(this.a())
    };
N.S=function(){
    Qu.b.S[F](this);
    this.Qb(function(a){
        a.r&&this.Ef(a)
        },this);
    var a=this.a();
    this.l.Rb(this);
    this.N(this.s,!0);
    this.X().i(this,aj,this.be).i(this,rk,this.ce).i(this,Um,this.de).i(this,yl,this.Zh).i(this,yi,this.Xh).i(a,hl,this.qb).i(Dp(a),ll,this.Yh).i(a,[hl,ll,kl,jl],this.Wh);
    this.pb()&&this.Ff(!0)
    };

N.Ff=function(a){
    var b=this.X(),c=this.O();
    a?b.i(c,gj,this.Zc).i(c,ei,this.sb).i(this.Yc(),Mk,this.Ja):b.Y(c,gj,this.Zc).Y(c,ei,this.sb).Y(this.Yc(),Mk,this.Ja)
    };
N.ea=function(){
    this.Vb(-1);
    this.K&&this.K.H(!1);
    this.ke=!1;
    Qu.b.ea[F](this)
    };

N.j=function(){
    Qu.b.j[F](this);
    if(this.ia)this.ia.D(),this.ia=i;
    this.l=this.K=this.ab=i
    };

N.be=function(){
    return!0
    };

N.ce=function(a){
    var b=this.Wc(a[$c]);
    if(b>-1&&b!=this.ha){
        var c=this.Wb();
        c&&c.Ka(!1);
        this.ha=b;
        c=this.Wb();
        this.ke&&c[kc](!0);
        this.oi&&this.K&&c!=this.K&&(c.ba(64)?c.H(!0):this.K.H(!1))
        }
        Ut(this.a(),Oh,a[$c].a().id)
    };

N.de=function(a){
    if(a[$c]==this.Wb())this.ha=-1;
    Ut(this.a(),Oh,J)
    };
N.Zh=function(a){
    if((a=a[$c])&&a!=this.K&&a[Wa]()==this)this.K&&this.K.H(!1),this.K=a
        };

N.Xh=function(a){
    if(a[$c]==this.K)this.K=i
        };

N.qb=function(a){
    this.ga&&this.Ub(!0);
    var b=this.O();
    b&&Wp(b)?b[Kb]():a[rb]()
    };

N.Yh=function(){
    this.Ub(!1)
    };

N.Wh=function(a){
    var b=this.qk(a[$c]);
    if(b)switch(a[z]){
        case hl:
            b.qb(a);
            break;
        case ll:
            b.tb(a);
            break;
        case kl:
            b.se(a);
            break;
        case jl:
            b.re(a)
            }
        };

N.qk=function(a){
    if(this.ab)for(var b=this.a();a&&a!==b;){
        var c=a.id;
        if(c in this.ab)return this.ab[c];
        a=a[Dd]
        }
        return i
    };
N.Zc=function(){};

N.sb=function(){
    this.Vb(-1);
    this.Ub(!1);
    this.K&&this.K.H(!1)
    };

N.Ja=function(a){
    if(this[cd]()&&this.s&&(this.Ya()!=0||this.wg)&&this.ac(a))return a[rb](),a[Mc](),!0;
    return!1
    };
N.ac=function(a){
    var b=this.Wb();
    if(b&&typeof b.Ja==mj&&b.Ja(a))return!0;
    if(this.K&&this.K!=b&&typeof this.K.Ja==mj&&this.K.Ja(a))return!0;
    if(a[xd]||a[Ic]||a.metaKey||a[tc])return!1;
    switch(a[Pb]){
        case 27:
            if(this.pb())this.O().blur();else return!1;
            break;
        case 36:
            this.Zi();
            break;
        case 35:
            this.$i();
            break;
        case 38:
            if(this.dc==bn)this.Se();else return!1;
            break;
        case 37:
            if(this.dc==sk)this.ne()?this.Re():this.Se();else return!1;
            break;
        case 40:
            if(this.dc==bn)this.Re();else return!1;
            break;
        case 39:
            if(this.dc==sk)this.ne()?
            this.Se():this.Re();else return!1;
            break;
        default:
            return!1
            }
            return!0
    };

N.Ef=function(a){
    var b=a.a(),b=b.id||(b.id=a.Sb());
    if(!this.ab)this.ab={};

    this.ab[b]=a
    };

N.Ed=function(a,b){
    Qu.b.Ed[F](this,a,b)
    };

N.Ac=function(a,b,c){
    a.cg(2,!0);
    a.cg(64,!0);
    (this.pb()||!this.pi)&&a.pa(32,!1);
    a.me(!1);
    Qu.b.Ac[F](this,a,b,c);
    c&&this.r&&this.Ef(a);
    b<=this.ha&&this.ha++
};
N.removeChild=function(a,b){
    if(a=Q(a)?this.ge(a):a){
        var c=this.Wc(a);
        c!=-1&&(c==this.ha?a.Ka(!1):c<this.ha&&this.ha--);
        (c=a.a())&&c.id&&Po(this.ab,c.id)
        }
        a=Qu.b[Xc][F](this,a,b);
    a.me(!0);
    return a
    };

N.N=function(a,b){
    if(b||this.s!=a&&this[w](a?rm:qk)){
        this.s=a;
        var c=this.a();
        c&&(Bs(c,a),this.pb()&&this.l.Uf(this.O(),this.ga&&this.s),b||this[w](this.s?Rh:Qh));
        return!0
        }
        return!1
    };

N.isEnabled=function(){
    return this.ga
    };

N.pb=function(){
    return this.Ge
    };
N.ub=function(a){
    a!=this.Ge&&this.r&&this.Ff(a);
    this.Ge=a;
    this.ga&&this.s&&this.l.Uf(this.O(),a)
    };

N.Vb=function(a){
    (a=this.Za(a))?a.Ka(!0):this.ha>-1&&this.Wb().Ka(!1)
    };

N.Ka=function(a){
    this.Vb(this.Wc(a))
    };

N.Wb=function(){
    return this.Za(this.ha)
    };

N.Zi=function(){
    this.Sd(function(a,b){
        return(a+1)%b
        },this.Ya()-1)
    };

N.$i=function(){
    this.Sd(function(a,b){
        a--;
        return a<0?b-1:a
        },0)
    };

N.Re=function(){
    this.Sd(function(a,b){
        return(a+1)%b
        },this.ha)
    };
N.Se=function(){
    this.Sd(function(a,b){
        a--;
        return a<0?b-1:a
        },this.ha)
    };

N.Sd=function(a,b){
    for(var c=b<0?this.Wc(this.K):b,d=this.Ya(),c=a[F](this,c,d),f=0;f<=d;){
        var h=this.Za(c);
        if(h&&this.Tg(h))return this.Sj(c),!0;
        f++;
        c=a[F](this,c,d)
        }
        return!1
    };

N.Tg=function(a){
    return a.s&&a[cd]()&&a.ba(2)
    };

N.Sj=function(a){
    this.Vb(a)
    };

N.Ub=function(a){
    this.ke=a
    };

function Ru(){}
R(Ru,uu);
zn(Ru);
Ru[C].Q=function(){
    return Qj
    };

function Su(a,b,c){
    yu[F](this,a,c||Ru.qa(),b);
    this.pa(1,!1);
    this.pa(2,!1);
    this.pa(4,!1);
    this.pa(32,!1);
    this.gh(1)
    }
    R(Su,yu);
wu(Qj,function(){
    return new Su(i)
    });
function Tu(){}
R(Tu,Pu);
zn(Tu);
Tu[C].lb=function(){
    return al
    };

Tu[C].vb=function(a,b){
    return Rp(a.a(),b)
    };

Tu[C].Q=function(){
    return Oj
    };

Tu[C].Rb=function(a){
    Tu.b.Rb[F](this,a);
    Ut(a.a(),mk,Rm)
    };

wu(Tj,function(){
    return new Ou
    });
function Uu(a,b){
    Qu[F](this,bn,b||Tu.qa(),a);
    this.ub(!1)
    }
    R(Uu,Qu);
N=Uu[C];
N.ye=!0;
N.Zj=!1;
N.Q=function(){
    return this.l.Q()
    };

N.vb=function(a){
    if(this.l.vb(this,a))return!0;
    for(var b=0,c=this.Ya();b<c;b++){
        var d=this.Za(b);
        if(typeof d.vb==mj&&d.vb(a))return!0
            }
            return!1
    };

N.cb=function(a){
    this.Ed(a,!0)
    };

N.hc=function(a,b){
    this.Ac(a,b,!0)
    };

N.Oc=function(a){
    return this.Za(a)
    };

N.wf=function(){
    return this.Ya()
    };
N.nc=function(a,b){
    var c=this.s;
    c||Bs(this.a(),!0);
    var d=this.a(),f=a,h=b,j=vs(d);
    if(f instanceof Tn)h=f.y,f=f.x;
    qs(d,d.offsetLeft+(f-j.x),d[Gd]+(h-j.y));
    c||Bs(this.a(),!1)
    };

N.zi=function(a){
    (this.ye=a)&&this.ub(!0)
    };

N.N=function(a,b,c){
    (b=Uu.b.N[F](this,a,b))&&a&&this.r&&this.ye&&this.O()[Kb]();
    this.bg=a&&c&&Fn(c[mc])?new Tn(c[mc],c[nc]):i;
    return b
    };

N.be=function(a){
    this.ye&&this.O()[Kb]();
    return Uu.b.be[F](this,a)
    };

N.Tg=function(a){
    return(this.Zj||a[cd]())&&a.s&&a.ba(2)
    };

function Vu(){}
R(Vu,Ku);
zn(Vu);
N=Vu[C];
N.d=function(a){
    var b={
        "class":Nj+this.fc(a)[I](Pd),
        title:a.dd()||J
        };

    return a.A().d(Vi,b,this.createButton(a.la,a.A()))
    };

N.lb=function(){
    return mi
    };

N.P=function(a){
    return a&&a[Qb][Qb]
    };

N.createButton=function(a,b){
    return b.d(Vi,Nj+(this.Q()+Pe),b.d(Vi,Nj+(this.Q()+Ne),a))
    };

N.Q=function(){
    return Mj
    };

function Wu(){}
R(Wu,Vu);
zn(Wu);
dp&&Da(Wu[C],function(a,b){
    var c=Wu.b.P[F](this,a&&a[Qb]);
    if(c){
        var d=this.createCaption(b,Bp(a)),f=c[Dd];
        f&&f.replaceChild(d,c)
        }
    });
N=Wu[C];
N.P=function(a){
    a=Wu.b.P[F](this,a&&a[Qb]);
    dp&&a&&a.__goog_wrapper_div&&(a=a[Qb]);
    return a
    };

N.createButton=function(a,b){
    return Wu.b.createButton[F](this,[this.createCaption(a,b),this.ij(b)],b)
    };

N.createCaption=function(a,b){
    return b.d(Vi,Nj+(this.Q()+Ce),a)
    };

N.ij=function(a){
    return a.d(Vi,Nj+(this.Q()+Ie),rn)
    };

N.Q=function(){
    return Pj
    };

function Xu(a,b,c,d){
    Mu[F](this,a,c||Wu.qa(),d);
    this.pa(64,!0);
    b&&this.bd(b);
    this.fa=new Wq(500)
    }
    R(Xu,Mu);
N=Xu[C];
N.Wf=!0;
N.qe=!1;
N.ee=!1;
N.ci=!1;
N.S=function(){
    Xu.b.S[F](this);
    this.g&&this.Vc(this.g,!0);
    Ut(this.a(),mk,Rm)
    };

N.ea=function(){
    Xu.b.ea[F](this);
    if(this.g){
        this.H(!1);
        this.g.ea();
        this.Vc(this.g,!1);
        var a=this.g.a();
        a&&Qp(a)
        }
    };

N.j=function(){
    Xu.b.j[F](this);
    this.g&&(this.g.D(),delete this.g);
    delete this.ai;
    this.fa.D()
    };
N.qb=function(a){
    Xu.b.qb[F](this,a);
    this.Ca()&&(this.H(!this.ed(),a),this.g&&this.g.Ub(this.ed()))
    };

N.tb=function(a){
    Xu.b.tb[F](this,a);
    this.g&&!this.Ca()&&this.g.Ub(!1)
    };

N.bc=function(){
    this[kc](!1);
    return!0
    };

N.li=function(a){
    this.g&&this.g.s&&!this.vb(a[$c])&&this.H(!1)
    };

N.vb=function(a){
    return a&&Rp(this.a(),a)||this.g&&this.g.vb(a)||!1
    };
N.ac=function(a){
    if(a[Pb]==32){
        if(a[rb](),a[z]!=Pk)return!1
            }else if(a[z]!=Mk)return!1;
    if(this.g&&this.g.s){
        var b=this.g.Ja(a);
        if(a[Pb]==27)return this.H(!1),!0;
        return b
        }
        if(a[Pb]==40||a[Pb]==38||a[Pb]==32)return this.H(!0),!0;
    return!1
    };

N.xe=function(){
    this.H(!1)
    };

N.mi=function(){
    this.Ca()||this.H(!1)
    };

N.sb=function(a){
    this.ee||this.H(!1);
    Xu.b.sb[F](this,a)
    };

N.zc=function(){
    this.g||this.bd(new Uu(this.A()));
    return this.g||i
    };
N.bd=function(a){
    var b=this.g;
    if(a!=b&&(b&&(this.H(!1),this.r&&this.Vc(b,!1),delete this.g),a))this.g=a,a.ae(this),a.N(!1),a.zi(this.ee),this.r&&this.Vc(a,!0);
    return b
    };

N.cb=function(a){
    this.zc().Ed(a,!0)
    };

N.hc=function(a,b){
    this.zc().Ac(a,b,!0)
    };

N.Oc=function(a){
    return this.g?this.g.Za(a):i
    };

N.wf=function(){
    return this.g?this.g.Ya():0
    };

N.N=function(a,b){
    var c=Xu.b.N[F](this,a,b);
    c&&!this.s&&this.H(!1);
    return c
    };
N.H=function(a,b){
    Xu.b.H[F](this,a);
    if(this.g&&this.za(64)==a){
        if(a)this.g.r||(this.ci?this.g.Ia(this.a()[Dd]):this.g.Ia()),this.Nf=us(this.a()),this.Lf=zs(this.a()),this.Mf(),this.g.Vb(-1);
        else if(this[kc](!1),this.g.Ub(!1),this.a()&&Ut(this.a(),Oh,J),xn(this.Uc)){
            this.Uc=g;
            var c=this.g.a();
            c&&xs(c,J,J)
            }
            this.g.N(a,!1,b);
        this.bi(a)
        }
    };
N.Mf=function(){
    if(this.g.r){
        var a=new Ju(this.ai||this.a(),this.Wf?5:7,!this.qe,this.qe),b=this.g.a();
        this.g.s||(Ha(b[Uc],pk),Bs(b,!0));
        if(!this.Uc&&this.qe)this.Uc=ys(b);
        a.rb(b,this.Wf?4:6,i,this.Uc);
        this.g.s||(Bs(b,!1),Ha(b[Uc],cn))
        }
    };

N.ni=function(){
    var a=zs(this.a()),b=us(this.a()),c;
    c=this.Lf;
    c=c==a?!0:!c||!a?!1:c[x]==a[x]&&c[s]==a[s]&&c.top==a.top&&c[H]==a[H];
    if(!(c=!c))c=this.Nf,c=c==b?!0:!c||!b?!1:c.top==b.top&&c[Kd]==b[Kd]&&c[sd]==b[sd]&&c[x]==b[x],c=!c;
    if(c)this.Lf=a,this.Nf=b,this.Mf()
        };
N.Vc=function(a,b){
    var c=this.X(),d=b?c.i:c.Y;
    d[F](c,a,Mh,this.xe);
    d[F](c,a,rk,this.ce);
    d[F](c,a,Um,this.de)
    };

N.ce=function(a){
    Ut(this.a(),Oh,a[$c].a().id)
    };

N.de=function(){
    this.g.Wb()||Ut(this.a(),Oh,J)
    };

N.bi=function(a){
    var b=this.X(),c=a?b.i:b.Y;
    c[F](b,this.A().m,hl,this.li,!0);
    this.ee&&c[F](b,this.g,ei,this.mi);
    c[F](b,this.fa,Hm,this.ni);
    a?this.fa[ed]():this.fa.stop()
    };

wu(Pj,function(){
    return new Xu(i)
    });
function Yu(a){
    this.Eb=[];
    this.Tk(a)
    }
    R(Yu,Rq);
N=Yu[C];
N.Gb=i;
N.Jh=i;
N.wf=function(){
    return this.Eb[B]
    };

N.Wk=function(a){
    return a?wo(this.Eb,a):-1
    };

N.Oc=function(a){
    return this.Eb[a]||i
    };

N.Tk=function(a){
    a&&(xo(a,function(a){
        this.Td(a,!1)
        },this),Fo(this.Eb,a))
    };

N.cb=function(a){
    this.hc(a,this.wf())
    };

N.hc=function(a,b){
    a&&(this.Td(a,!1),Go(this.Eb,b,0,a))
    };

N.yd=function(){
    return this.Gb
    };

N.Kb=function(a){
    if(a!=this.Gb)this.Td(this.Gb,!1),this.Gb=a,this.Td(a,!0);
    this[w](hm)
    };

N.rd=function(){
    return this.Wk(this.Gb)
    };
N.Eh=function(a){
    this.Kb(this.Oc(a))
    };

N.clear=function(){
    var a=this.Eb;
    if(!P(a))for(var b=a[B]-1;b>=0;b--)delete a[b];
    Ja(a,0);
    this.Gb=i
    };

N.j=function(){
    Yu.b.j[F](this);
    delete this.Eb;
    this.Gb=i
    };

N.Td=function(a,b){
    a&&(typeof this.Jh==mj?this.Jh(a,b):typeof a.bf==mj&&a.bf(b))
    };

function Zu(a,b,c,d){
    Xu[F](this,a,b,c,d);
    this.Sl(a)
    }
    R(Zu,Xu);
N=Zu[C];
N.u=i;
N.ue=i;
N.S=function(){
    Zu.b.S[F](this);
    this.Oe();
    this.dg()
    };

N.j=function(){
    Zu.b.j[F](this);
    if(this.u)this.u.D(),this.u=i;
    this.ue=i
    };

N.xe=function(a){
    this.Kb(a[$c]);
    Zu.b.xe[F](this,a);
    a[Mc]();
    this[w](Mh)
    };

N.ej=function(){
    var a=this.yd();
    Zu.b[Cc][F](this,a&&a[A]());
    this.Oe()
    };

N.bd=function(a){
    var b=Zu.b.bd[F](this,a);
    a!=b&&(this.u&&this.u.clear(),a&&(this.u?a.Qb(function(a){
        this.u.cb(a)
        },this):this.De(a)));
    return b
    };
N.Sl=function(a){
    this.ue=a;
    this.Oe()
    };

N.cb=function(a){
    Zu.b.cb[F](this,a);
    this.u?this.u.cb(a):this.De(this.zc())
    };

N.hc=function(a,b){
    Zu.b.hc[F](this,a,b);
    this.u?this.u.hc(a,b):this.De(this.zc())
    };

N.Kb=function(a){
    this.u&&this.u.Kb(a)
    };

N.Eh=function(a){
    this.u&&this.Kb(this.u.Oc(a))
    };

Ka(N,function(a){
    if(xn(a)&&this.u)for(var b=0,c;c=this.u.Oc(b);b++)if(c&&typeof c[A]==mj&&c[A]()==a){
        this.Kb(c);
        return
    }
    this.Kb(i)
    });
N.yd=function(){
    return this.u?this.u.yd():i
    };
N.rd=function(){
    return this.u?this.u.rd():-1
    };

N.De=function(a){
    this.u=new Yu;
    a&&a.Qb(function(a){
        this.u.cb(a)
        },this);
    this.dg()
    };

N.dg=function(){
    this.u&&this.X().i(this.u,hm,this.ej)
    };

N.Oe=function(){
    var a=this.yd();
    this[fc](a?a.vc():this.ue)
    };

N.H=function(a,b){
    Zu.b.H[F](this,a,b);
    this.ed()&&this.zc().Vb(this.rd())
    };

wu("goog-select",function(){
    return new Zu(i)
    });
function $u(a,b){
    this.Aa=Bp();
    this.Zb=a;
    this.Zg=[];
    Fs(kf);
    this.tk(b)
    }
    N=$u[C];
N.gc=i;
function av(a,b){
    var c=Bp(),d,f,h=i;
    switch(a){
        case 2:
            d=new hu(dk);
            h=Ql+d.Sb();
            f=c.d(Vi,i,c.d(Vi,{
            "class":ck
        },fg),c.d(li,i),c.d(Ll,i,c.d(Vi,{
            id:h
        },b[Sc])));
        break;
        case 3:
            d=new hu(Zj);
            f=c.d(Vi,i,c.d(Vi,{
            "class":ck
        },fg),c.d(li,i));
            var j=c.d(Vi,i,c.d(Ll,i,b[Sc]));
            c[Sa](f,j)
            }
            d[fc](f.innerHTML);
    ra(d.cj(),rg);
    ra(d.bj(),J);
    d.N(!0);
    h&&(c=Ep(h),(S&&!up(9)?Pt(c,0,c,1):ep?new St(Lt(c,0,c,1)):dp?new Mt(Lt(c,0,c,1)):cp?new Rt(Lt(c,0,c,1)):new It(Lt(c,0,c,1))).select())
    }
N.tk=function(a){
    var a=a||{},b=this.Zb,c=this.Aa;
    c.He(b);
    b||e(l(dg));
    var d=c.d(um,i),f=[c.d(um,i,$f),c.d(Vi,{
        "class":ek
    },tn)];
    this.gc=new Zu(f);
    if(a)for(f=0;f<a[B];f++){
        var h=i,j=a[f],m=j.datasource,q=j.gadget,u=j.userprefs,D=j[Qc],E=j[El],K=j[Uc]||gn;
        switch(j[z]){
            case Fi:
                h=this.Gc(f,On(function(a){
                ca[Xa]((new hr(a)).nd(Qm,Al),sg)
                },m),lg,$j);
            break;
            case uk:
                h=this.Gc(f,On(function(a,b){
                av(2,{
                    message:Hf+K+Wd+ba(a)+le+ba(b)+bv(u)+Vd
                    })
                },q,m),Zg,bk);
            break;
            case Jk:
                h=this.Gc(f,On(function(a,b,c){
                av(3,{
                    message:Gf+
                    ba(b)+pe+a+oe+ba(c)+re
                    })
                },m,E,D),Gg,bk);
            break;
            case tk:
                h=this.Gc(f,On(function(a){
                ca[Xa]((new hr(a)).nd(Qm,Bl),sg)
                },m),mg,$j);
            break;
            case Ck:
                h=this.Gc(f,On(function(a,b,c){
                ca[Xa](zk+ba(a)+le+ba(b)+bv(c))
                },q,m,u),Rf,ak);
            break;
            default:
                e(l("No such toolbar component as: "+j.toSource()))
                }
                h&&this.gc.cb(h)
        }
        Hq(this.gc,Mh,Nn(this.Gi,this));
    this.gc.Ia(d);
    c[Sa](b,d)
    };

N.Fk=function(){
    this.gc.Eh(-1)
    };

N.Gi=function(){
    this.Zg[this.gc.rd()]();
    this.Fk()
    };

N.Gc=function(a,b,c){
    c=new Bu(c);
    this.Zg[a]=b;
    return c
    };
function bv(a){
    if(!a)return J;
    var b=J,c;
    for(c in a)b+=ke+c+Lf+ba(a[c]);return b
    };

k("google.visualization.drawChart",bt);
k("google.visualization.drawFromUrl",function(a,b){
    var c=new hr(b||n[Oc][td]),d=c.hh(Kk),f;
    xn(d)?f=d:(f={},xo(c.$.Mb(),function(a){
        var b=c.hh(a);
        try{
            xn(b)&&(b=tr(b))
            }catch(d){}
        f[a]=b
        }),f.options=Kn(f));
    bt(f,a)
    });
k("google.visualization.createUrl",function(a,b){
    Q(a)&&(a=tr(a));
    var c=[],d,f;
    for(f in a)if(f==zl){
        var h=a[f],j;
        for(j in h)d=h[j],Q(d)||(d=qr(d)),c[r](j+Lf+Zn(d))
            }else d=a[f],Q(d)||(d=Gn(d[Bc])?d[Bc]():qr(d)),c[r](f+Lf+Zn(d));d=Es()+ef;
    d=d[t](/^https?:/,J);
    c=(b||d)+Nf+c[I](ee);
    c=c[t](/'/g,de);
    return c=c[t](/"/g,ce)
    });
k("google.visualization.createSnippet",function(a){
    var b=Es()+ff,b=b[t](/^https?:/,J),b=Jf+b+Xd,a=(new Y(a))[Bc](),a=a[t](/</g,he),a=a[t](/>/g,ge);
    b+=a;
    b+=Od;
    return b
    });
k("google.visualization.ChartWrapper",Y);
o(Y[C],Yi,Y[C][gd]);
o(Y[C],Km,Y[C][Bc]);
o(Y[C],"getSnapshot",Y[C].getSnapshot);
o(Y[C],xj,Y[C][Zc]);
o(Y[C],yj,Y[C][qb]);
o(Y[C],"getChartName",Y[C].getChartName);
o(Y[C],"getChartType",Y[C].getChartType);
o(Y[C],"getChart",Y[C].Jl);
o(Y[C],wj,Y[C].getContainerId);
o(Y[C],"getPackages",Y[C][rd]);
o(Y[C],"getQuery",Y[C][vd]);
o(Y[C],Ej,Y[C][kd]);
o(Y[C],"getView",Y[C][wc]);
o(Y[C],"getOption",Y[C][bd]);
o(Y[C],"getOptions",Y[C][ib]);
o(Y[C],"getState",Y[C][md]);
o(Y[C],"sendQuery",Y[C].sf);
o(Y[C],lm,Y[C].setDataSourceUrl);
o(Y[C],"setDataTable",Y[C].setDataTable);
o(Y[C],"setChartName",Y[C].setChartName);
o(Y[C],"setChartType",Y[C].setChartType);
o(Y[C],km,Y[C].setContainerId);
o(Y[C],"setPackages",Y[C].setPackages);
o(Y[C],nm,Y[C][Vc]);
o(Y[C],om,Y[C][$b]);
o(Y[C],"setView",Y[C].setView);
o(Y[C],"setOption",Y[C][Ld]);
o(Y[C],mm,Y[C].setOptions);
o(Y[C],"setState",Y[C][qc]);
k("google.visualization.ControlWrapper",Z);
o(Z[C],Yi,Z[C][gd]);
o(Z[C],Km,Z[C][Bc]);
o(Z[C],"getSnapshot",Z[C].getSnapshot);
o(Z[C],xj,Z[C][Zc]);
o(Z[C],yj,Z[C][qb]);
o(Z[C],"getControlName",Z[C].getControlName);
o(Z[C],"getControlType",Z[C].getControlType);
o(Z[C],"getControl",Z[C].getControl);
o(Z[C],wj,Z[C].getContainerId);
o(Z[C],"getPackages",Z[C][rd]);
o(Z[C],"getQuery",Z[C][vd]);
o(Z[C],Ej,Z[C][kd]);
o(Z[C],"getView",Z[C][wc]);
o(Z[C],"getOption",Z[C][bd]);
o(Z[C],"getOptions",Z[C][ib]);
o(Z[C],"getState",Z[C][md]);
o(Z[C],"sendQuery",Z[C].sf);
o(Z[C],lm,Z[C].setDataSourceUrl);
o(Z[C],"setDataTable",Z[C].setDataTable);
o(Z[C],"setControlName",Z[C].setControlName);
o(Z[C],"setControlType",Z[C].setControlType);
o(Z[C],km,Z[C].setContainerId);
o(Z[C],"setPackages",Z[C].setPackages);
o(Z[C],nm,Z[C][Vc]);
o(Z[C],om,Z[C][$b]);
o(Z[C],"setView",Z[C].setView);
o(Z[C],"setOption",Z[C][Ld]);
o(Z[C],mm,Z[C].setOptions);
o(Z[C],"setState",Z[C][qc]);
k("google.visualization.Player",At);
o(At[C],Yi,At[C][gd]);
k("onPlayBarEvent",function(a,b,c){
    a=Ct[a];
    switch(b){
        case Il:
            a.mh(!0);
            break;
        case Gl:
            a.mh(!1);
            break;
        case Rl:
            a.vk();
            break;
        case fm:case gm:
            a.Ga=p[gb](c),google[Qc][fb][Ua](a,Il,{
            current:a.Ga
            }),a.Jd()
            }
        });
k("google.visualization.drawToolbar",function(a,b){
    new $u(a,b)
    });
k("google.visualization.data.avg",function(a){
    return ct(a)/a[B]
    });
k("google.visualization.data.count",function(a){
    return a[B]
    });
k("google.visualization.data.group",function(a,b,c){
    function d(a,b,c,d){
        return b[F](i,c[A](d,a))
        }
        var f=[],h=[];
    xo(b,function(a){
        if(Fn(a))f[r](a);
        else if(An(a)==vl){
            var b=a.column;
            gl in a&&h[r]([b,{
                calc:On(d,b,a.modifier),
                type:a[z],
                label:a[Fd],
                id:a.id
                }]);
            f[r](b)
            }
        });
if(h[B]!=0){
    for(var j=new google[Qc][jd](a),m=j.getViewColumns(),q=a[xc](),u=0;u<q;u++)xo(h,function(a){
        m[a[0]]=a[1]
        });
    j[Id](m);
    a=j
    }
    var D=new google[Qc][Ya],E=[];
xo(f,function(c,d){
    var f=a[y](c),h=b[d][Fd]||a[Mb](c);
    D[zd](f,h,b[d].id);
    E[r](f)
    });
c=c||[];
xo(c,function(b){
    var c=b.column,c=b[Fd]||a[Mb](c);
    D[zd](b[z],c,b.id)
    });
var K=[];
xo(f,function(a){
    K[r]({
        column:a
    })
    });
for(var G=a[Rb](K),sa=[],qa=0;qa<c[B];qa++)sa[r]([]);
    for(qa=0;qa<G[B];qa++){
    xo(c,function(b,c){
        sa[c][r](a[A](G[qa],b.column))
        });
    j=!1;
    if(qa<G[B]-1){
        j=!0;
        for(q=0;q<f[B];q++){
            var u=a[A](G[qa],f[q]),xa=a[A](G[qa+1],f[q]);
            if(google[Qc].datautils.compareValues(E[q],u,xa)!=0){
                j=!1;
                break
            }
        }
        }
    if(!j){
    var W=D.addRow();
    xo(f,function(b,c){
        D[Cc](W,c,a[A](G[qa],b))
        });
    var ia=b[B];
    xo(c,function(a,
        b){
        var c=a.aggregation[F](this,sa[b]);
        D[Cc](W,ia+b,c)
        });
    for(j=0;j<G[B];j++)sa[j]=[]
        }
    }
return D
});
k("google.visualization.data.join",function(a,b,c,d,f,h){
    var j=c==Sk||c==lj,m=c==Zl||c==lj,q=new google[Qc][Ya],u=[];
    xo(d,function(c){
        var d=a[y](c[0]),f=b[y](c[1]);
        d!=f&&e(l("Key types do not match:"+d+xe+f));
        f=q[zd](d,a[Mb](c[0]));
        q[Ab](f,a[xb](c[0]));
        u[r](d)
        });
    var D=[],E=[];
    xo(d,function(a){
        D[r]({
            column:a[0]
            });
        E[r]({
            column:a[1]
            })
        });
    var K=a[Rb](D),G=b[Rb](E);
    xo(f,function(b){
        var c=q[zd](a[y](b),a[Mb](b));
        q[Ab](c,a[xb](b))
        });
    xo(h,function(a){
        var c=q[zd](b[y](a),b[Mb](a));
        q[Ab](c,b[xb](a))
        });
    for(var sa=
        !1,qa=0,xa=0,W=0;qa<K[B]||xa<G[B];){
        var ia=0,ya=[];
        if(xa>=G[B])if(j)ya[0]=K[qa],ia=-1;else break;
        else if(qa>=K[B])if(m)ya[1]=G[xa],ia=1;else break;
        else{
            ya[0]=K[qa];
            ya[1]=G[xa];
            for(var $=0;$<d[B];$++){
                var ia=a[A](ya[0],d[$][0]),cv=b[A](ya[1],d[$][1]),ia=google[Qc].datautils.compareValues(u[$],ia,cv);
                if(ia!=0)break
            }
            }
            if(sa&&ia!=0)sa=!1,xa++;
        else{
        if(ia==-1&&j||ia==1&&m||ia==0){
            q.addRow();
            var Se,dc;
            ia==-1&&j||ia==0&&c!=Zl?(Se=a,dc=0):(Se=b,dc=1);
            xo(d,function(a,b){
                c==lj?q[Cc](W,b,Se[A](ya[dc],a[dc])):
                q[cc](W,b,Se[A](ya[dc],a[dc]),Se[Bd](ya[dc],a[dc]),Se[zc](ya[dc],a[dc]))
                });
            if(ia==-1&&j||ia==0){
                var wk=d[B];
                xo(f,function(b,c){
                    q[cc](W,c+wk,a[A](ya[0],b),a[Bd](ya[0],b),a[zc](ya[0],b))
                    })
                }
                if(ia==1&&m||ia==0)wk=f[B]+d[B],xo(h,function(a,c){
                q[cc](W,c+wk,b[A](ya[1],a),b[Bd](ya[1],a),b[zc](ya[1],a))
                });
            W++
        }
        ia==1?xa++:qa++;
        ia==0&&(sa=!0)
        }
    }
    return q
});
k("google.visualization.data.max",function(a){
    if(a[B]==0)return i;
    for(var b=a[0],c=1;c<a[B];c++){
        var d=a[c];
        d!=i&&d>b&&(b=d)
        }
        return b
    });
k("google.visualization.data.min",function(a){
    if(a[B]==0)return i;
    for(var b=a[0],c=1;c<a[B];c++){
        var d=a[c];
        d!=i&&d<b&&(b=d)
        }
        return b
    });
k("google.visualization.data.month",function(a){
    return a[uc]()+1
    });
k("google.visualization.data.sum",ct);
k("__gvizguard__",!0);
k("google.visualization.Query",Tr);
o(Tr[C],Xk,Tr[C].makeRequest);
o(Tr[C],om,Tr[C][$b]);
o(Tr[C],nm,Tr[C][Vc]);
o(Tr[C],"send",Tr[C][Gb]);
o(Tr[C],"setRefreshable",Tr[C].setRefreshable);
o(Tr[C],"setTimeout",Tr[C][Fc]);
o(Tr[C],"setHandlerType",Tr[C].Tl);
o(Tr[C],"setHandlerParameter",Tr[C].Kh);
o(Tr,"setResponse",bs);
o(Tr[C],Kh,Tr[C][Ec]);
k("google.visualization.QueryResponse",Or);
o(Or[C],yj,Or[C][qb]);
o(Or[C],"isError",Or[C][Jb]);
o(Or[C],"hasWarning",Or[C].hasWarning);
o(Or[C],"getReasons",Or[C].getReasons);
o(Or[C],"getMessage",Or[C].getMessage);
o(Or[C],"getDetailedMessage",Or[C].getDetailedMessage);
k("google.visualization.DataTable",U);
o(U[C],"addColumn",U[C][zd]);
o(U[C],"addRow",U[C].addRow);
o(U[C],"addRows",U[C][jc]);
o(U[C],"clone",U[C][Yc]);
o(U[C],"getColumnId",U[C].getColumnId);
o(U[C],qj,U[C].getColumnIndex);
o(U[C],rj,U[C][Mb]);
o(U[C],sj,U[C][Nc]);
o(U[C],uj,U[C][Kc]);
o(U[C],tj,U[C][xb]);
o(U[C],vj,U[C][ld]);
o(U[C],"getColumnType",U[C][y]);
o(U[C],zj,U[C].getDistinctValues);
o(U[C],Aj,U[C].getFilteredRows);
o(U[C],Bj,U[C][Bd]);
o(U[C],Cj,U[C][nb]);
o(U[C],Dj,U[C][xc]);
o(U[C],"getProperties",U[C][zc]);
o(U[C],"getProperty",U[C][vb]);
o(U[C],Gj,U[C].getRowProperty);
o(U[C],Fj,U[C][Yb]);
o(U[C],"getSortedRows",U[C][Rb]);
o(U[C],Ij,U[C].getTableProperty);
o(U[C],Hj,U[C][Zb]);
o(U[C],"getValue",U[C][A]);
o(U[C],"insertColumn",U[C].insertColumn);
o(U[C],"insertRows",U[C].insertRows);
o(U[C],"removeColumn",U[C].removeColumn);
o(U[C],"removeColumns",U[C].removeColumns);
o(U[C],"removeRow",U[C].removeRow);
o(U[C],"removeRows",U[C].removeRows);
o(U[C],"setCell",U[C][cc]);
o(U[C],"setColumnLabel",U[C].setColumnLabel);
o(U[C],"setColumnProperties",U[C][Ab]);
o(U[C],"setColumnProperty",U[C].setColumnProperty);
o(U[C],"setFormattedValue",U[C][Pc]);
o(U[C],"setProperties",U[C].setProperties);
o(U[C],"setProperty",U[C][hd]);
o(U[C],"setRowProperties",U[C].setRowProperties);
o(U[C],"setRowProperty",U[C].setRowProperty);
o(U[C],"setTableProperties",U[C].setTableProperties);
o(U[C],"setTableProperty",U[C].setTableProperty);
o(U[C],"setValue",U[C][Cc]);
o(U[C],"sort",U[C].sort);
o(U[C],Km,U[C][Bc]);
k("google.visualization.DataView",V);
o(V,"fromJSON",function(a,b){
    Q(b)&&(b=tr(b));
    var c=new V(a),d=b.columns,f=b.rows;
    xn(d)&&c[Id](d);
    xn(f)&&c.setRows(f);
    return c
    });
o(V[C],"getColumnId",V[C].getColumnId);
o(V[C],qj,V[C].getColumnIndex);
o(V[C],rj,V[C][Mb]);
o(V[C],sj,V[C][Nc]);
o(V[C],uj,V[C][Kc]);
o(V[C],uj,V[C][Kc]);
o(V[C],tj,V[C][xb]);
o(V[C],vj,V[C][ld]);
o(V[C],"getColumnType",V[C][y]);
o(V[C],zj,V[C].getDistinctValues);
o(V[C],Aj,V[C].getFilteredRows);
o(V[C],Bj,V[C][Bd]);
o(V[C],Cj,V[C][nb]);
o(V[C],Dj,V[C][xc]);
o(V[C],"getProperties",V[C][zc]);
o(V[C],"getProperty",V[C][vb]);
o(V[C],Gj,V[C].getRowProperty);
o(V[C],Fj,V[C][Yb]);
o(V[C],"getSortedRows",V[C][Rb]);
o(V[C],"getTableColumnIndex",V[C].getTableColumnIndex);
o(V[C],"getUnderlyingTableColumnIndex",V[C].getUnderlyingTableColumnIndex);
o(V[C],"getTableRowIndex",V[C][Ub]);
o(V[C],"getUnderlyingTableRowIndex",V[C].getUnderlyingTableRowIndex);
o(V[C],Ij,V[C].getTableProperty);
o(V[C],Hj,V[C][Zb]);
o(V[C],"getValue",V[C][A]);
o(V[C],"getViewColumnIndex",V[C].getViewColumnIndex);
o(V[C],"getViewColumns",V[C].getViewColumns);
o(V[C],"getViewRowIndex",V[C].getViewRowIndex);
o(V[C],"getViewRows",V[C].getViewRows);
o(V[C],"hideColumns",V[C].hideColumns);
o(V[C],"hideRows",V[C].hideRows);
o(V[C],"setColumns",V[C][Id]);
o(V[C],"setRows",V[C].setRows);
o(V[C],"toDataTable",V[C][Nb]);
o(V[C],Km,V[C][Bc]);
k("google.visualization.GadgetHelper",cs);
o(cs[C],"createQueryFromPrefs",cs[C].createQueryFromPrefs);
o(cs[C],"validateResponse",cs[C].validateResponse);
k("google.visualization.errors",X);
o(X,"addError",X[Ac]);
o(X,"removeAll",X[dd]);
o(X,"removeError",X.removeError);
o(X,"addErrorFromQueryResponse",X.addErrorFromQueryResponse);
o(X,"getContainer",X.getContainer);
o(X,"createProtectedCallback",X.createProtectedCallback);
k("google.visualization.events.addListener",function(a,b,c){
    a=gs(a);
    b=Hq(a,b,hs(c));
    return new is(b)
    });
k("google.visualization.events.trigger",function(a,b,c){
    a=gs(a);
    b=new js(b,c);
    Qq(a,b)
    });
k("google.visualization.events.removeListener",function(a){
    a=a&&Gn(a.Kk)&&a.wa;
    if(Fn(a))return Lq(a);
    return!1
    });
k("google.visualization.events.removeAllListeners",function(a){
    var b=gs(a),b=Nq(b),c=a.__eventTarget;
    c&&typeof c.D==mj&&c.D();
    a.__eventTarget=g;
    return b
    });
k("google.visualization.QueryWrapper",ks);
o(ks[C],mm,ks[C].setOptions);
o(ks[C],Yi,ks[C][gd]);
o(ks[C],"setCustomErrorHandler",ks[C].Rl);
o(ks[C],"sendAndDraw",ks[C].sendAndDraw);
o(ks[C],"setCustomPostResponseHandler",ks[C].setCustomPostResponseHandler);
o(ks[C],"setCustomResponseHandler",ks[C].setCustomResponseHandler);
o(ks[C],Kh,ks[C][Ec]);
k("google.visualization.arrayToDataTable",function(a,b){
    var c=new U,d,f,h;
    P(a)||e(l("Not an array"));
    if(a[B]==0)return c;
    P(a[0])||e(l(Vg));
    var j=a[0][B];
    for(d=1;d<a[B];d++)(!P(a[d])||a[d][B]!=j)&&e(l(Vg));
    var m=(d=!b)?a[0]:[],q=d?a[db](1,a[B]):a,u=[];
    for(f=0;f<j;f++){
        var D=M;
        for(d=0;d<q[B];d++)if(h=q[d][f],xn(h)){
            Q(h)?D=M:Fn(h)?D=L:P(h)?D=Im:typeof h==gi?D=gi:Dn(h)?e(l("Date and datetime column types are not supported")):e(l("Invalid value in "+d+we+f));
            break
        }
        u[f]=D
        }
        for(f=0;f<j;f++)c[zd](u[f],m[f]);
    c[jc](q);
    return c
    });
k("google.visualization.datautils.compareValues",Fr);
})();

(function (){
    var h=void 0,i=null,n=Error,o=parseInt,s=String,t=document,u=google_exportProperty,v=Array,w=Math;
    function aa(a,c){
        return a.currentTarget=c
        }
        function ba(a,c){
        return a.type=c
        }
        function ca(a,c){
        return a.className=c
        }
        function da(a,c){
        return a.target=c
        }
    var x="appendChild",y="push",ea="trigger",fa="round",ga="slice",z="replace",ha="events",B="indexOf",ia="color",ja="getObject",ka="createElement",la="keyCode",ma="handleEvent",C="type",na="name",oa="getElementsByTagName",D="length",pa="propertyIsEnumerable",E="prototype",F="split",qa="visualization",G="style",H="call",I="apply",ra="navigator",J="",sa=" ",ta=" google-visualization-orgchart-linebottom",ua=" google-visualization-orgchart-lineleft",va=" google-visualization-orgchart-lineright",wa=" google-visualization-orgchart-node-",
    xa=' name="',ya=' type="',za='"',Aa="&",Ba="&amp;",Ca="&gt;",Da="&lt;",Ea="&quot;",Fa="(\\d*)(\\D*)",Ga=",",Ha=".",Ia="0",Ja="5.7",Ka="<",La=">",Ma="[object Array]",Na="[object Function]",Pa="[object Window]",K="array",Qa="call",Ra="center",Sa="class",Ta="collapse",Ua="column",Va="dblclick",Wa="for",L="function",Xa="g",Ya="google-visualization-orgchart-connrow-",Za="google-visualization-orgchart-linenode",$a="google-visualization-orgchart-node",ab="google-visualization-orgchart-noderow-",bb="google-visualization-orgchart-nodesel",
    cb="google-visualization-orgchart-space-",db="google-visualization-orgchart-table",eb="keypress",fb="large",gb="ltr",hb="medium",ib="mousedown",jb="mouseout",kb="mouseover",lb="native code",mb="null",nb="number",ob="object",pb="on",qb="onmouseout",rb="onmouseover",sb="ready",tb="row",ub="select",vb="selectedStyle",wb="small",xb="splice",yb="string",zb="style",Ab="table",Bb="tbody",Cb="td",Db="tr",Eb="window.event",Fb="\u00a0",M,N=this;
    function Gb(a,c){
        for(var b=a[F](Ha),d=c||N,f;f=b.shift();)if(d[f]!=i)d=d[f];else return i;return d
        }
        function Hb(){}
    function O(a){
        var c=typeof a;
        if(c==ob)if(a){
            if(a instanceof v)return K;
            else if(a instanceof Object)return c;
            var b=Object[E].toString[H](a);
            if(b==Pa)return ob;
            if(b==Ma||typeof a[D]==nb&&typeof a.splice!="undefined"&&typeof a[pa]!="undefined"&&!a[pa](xb))return K;
            if(b==Na||typeof a[H]!="undefined"&&typeof a[pa]!="undefined"&&!a[pa](Qa))return L
                }else return mb;
        else if(c==L&&typeof a[H]=="undefined")return ob;
        return c
        }
        function Ib(a){
        var c=O(a);
        return c==K||c==ob&&typeof a[D]==nb
        }
    function Jb(a){
        return typeof a==yb
        }
        function Kb(a){
        return O(a)==L
        }
        function Lb(a){
        a=O(a);
        return a==ob||a==K||a==L
        }
        var P="closure_uid_"+w.floor(w.random()*2147483648).toString(36),Mb=0;
    function Nb(a){
        return a[H][I](a.bind,arguments)
        }
        function Ob(a,c){
        var b=c||N;
        if(arguments[D]>2){
            var d=v[E][ga][H](arguments,2);
            return function(){
                var c=v[E][ga][H](arguments);
                v[E].unshift[I](c,d);
                return a[I](b,c)
                }
            }else return function(){
        return a[I](b,arguments)
        }
    }
function Q(){
    Q=Function[E].bind&&Function[E].bind.toString()[B](lb)!=-1?Nb:Ob;
    return Q[I](i,arguments)
    }
    function Pb(a,c){
    function b(){}
    b.prototype=c[E];
    a.$=c[E];
    a.prototype=new b
    };

function Qb(a,c,b){
    for(var d in a)c[H](b,a[d],d,a)
        }
        var Rb=["constructor","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","toLocaleString","toString","valueOf"];
function Sb(a){
    for(var c,b,d=1;d<arguments[D];d++){
        b=arguments[d];
        for(c in b)a[c]=b[c];for(var f=0;f<Rb[D];f++)c=Rb[f],Object[E].hasOwnProperty[H](b,c)&&(a[c]=b[c])
            }
        };

function Tb(){
    this.b={};

    this.n={};

    this.o={}
}
M=Tb[E];
M.fa=function(a){
    var a=a==tb?this.b:this.n,c=[],b;
    for(b in a)c[y](o(b,10));return c
    };

M.K=function(){
    return this.fa(tb)
    };

M.ua=function(){
    return this.fa(Ua)
    };

M.ta=function(){
    var a=[],c;
    for(c in this.o){
        var b=c[F](Ga);
        a[y]({
            row:o(b[0],10),
            column:o(b[1],10)
            })
        }
        return a
    };
M.getSelection=function(){
    for(var a=[],c=this.K(),b=this.ua(),d=this.ta(),f=0;f<c[D];f++){
        var e={};

        e.row=c[f];
        a[y](e)
        }
        for(f=0;f<b[D];f++)e={},e.column=b[f],a[y](e);
    for(f=0;f<d[D];f++)e={},e.row=d[f].row,e.column=d[f].column,a[y](e);
    return a
    };

M.pa=function(a){
    return this.b[s(a)]!=i
    };
M.setSelection=function(a){
    var c={},b={},d={};

    a||(a=[]);
    for(var f=0;f<a[D];f++){
        var e=a[f];
        e.row!=i&&e.column!=i?d[s(e.row+Ga+e.column)]=1:e.row!=i?c[e.row]=1:e.column!=i&&(b[e.column]=1)
        }
        var g=this.p(c,this.b),m=this.p(b,this.n),j=this.p(d,this.o),a=this.p(this.b,c),f=this.p(this.n,b),e=this.p(this.o,d);
    this.b=c;
    this.n=b;
    this.o=d;
    c=new Tb;
    c.b=g;
    c.n=m;
    c.o=j;
    b=new Tb;
    b.b=a;
    b.n=f;
    b.o=e;
    return new Ub(c,b)
    };

M.p=function(a,c){
    var b={},d;
    for(d in a)c[d]||(b[d]=1);return b
    };
function Ub(a,c){
    this.ma=a;
    this.na=c
    };

function Vb(a,c){
    if(c)return a[z](Wb,Ba)[z](Xb,Da)[z](Yb,Ca)[z](Zb,Ea);
    else{
        if(!$b.test(a))return a;
        a[B](Aa)!=-1&&(a=a[z](Wb,Ba));
        a[B](Ka)!=-1&&(a=a[z](Xb,Da));
        a[B](La)!=-1&&(a=a[z](Yb,Ca));
        a[B](za)!=-1&&(a=a[z](Zb,Ea));
        return a
        }
    }
var Wb=/&/g,Xb=/</g,Yb=/>/g,Zb=/\"/g,$b=/[&<>\"]/;
function ac(a,c){
    for(var b=0,d=s(a)[z](/^[\s\xa0]+|[\s\xa0]+$/g,J)[F](Ha),f=s(c)[z](/^[\s\xa0]+|[\s\xa0]+$/g,J)[F](Ha),e=w.max(d[D],f[D]),g=0;b==0&&g<e;g++){
        var m=d[g]||J,j=f[g]||J,k=RegExp(Fa,Xa),l=RegExp(Fa,Xa);
        do{
            var p=k.exec(m)||[J,J,J],q=l.exec(j)||[J,J,J];
            if(p[0][D]==0&&q[0][D]==0)break;
            b=bc(p[1][D]==0?0:o(p[1],10),q[1][D]==0?0:o(q[1],10))||bc(p[2][D]==0,q[2][D]==0)||bc(p[2],q[2])
            }while(b==0)
    }
    return b
    }
    function bc(a,c){
    if(a<c)return-1;
    else if(a>c)return 1;
    return 0
    };

var R=v[E],cc=R[B]?function(a,c,b){
    return R[B][H](a,c,b)
    }:function(a,c,b){
    b=b==i?0:b<0?w.max(0,a[D]+b):b;
    if(Jb(a)){
        if(!Jb(c)||c[D]!=1)return-1;
        return a[B](c,b)
        }
        for(;b<a[D];b++)if(b in a&&a[b]===c)return b;return-1
    },dc=R.forEach?function(a,c,b){
    R.forEach[H](a,c,b)
    }:function(a,c,b){
    for(var d=a[D],f=Jb(a)?a[F](J):a,e=0;e<d;e++)e in f&&c[H](b,f[e],e,a)
        };

function ec(a,c){
    var b=cc(a,c),d;
    (d=b>=0)&&R.splice[H](a,b,1);
    return d
    }
    function fc(){
    return R.concat[I](R,arguments)
    }
function gc(a){
    if(O(a)==K)return fc(a);
    else{
        for(var c=[],b=0,d=a[D];b<d;b++)c[b]=a[b];
        return c
        }
    }
function hc(a){
    return R.splice[I](a,ic(arguments,1))
    }
    function ic(a,c,b){
    return arguments[D]<=2?R[ga][H](a,c):R[ga][H](a,c,b)
    }
    function jc(a,c){
    R.sort[H](a,c||kc)
    }
    function kc(a,c){
    return a>c?1:a<c?-1:0
    };

var S,lc,mc,nc;
function oc(){
    return N[ra]?N[ra].userAgent:i
    }
    nc=mc=lc=S=!1;
var pc;
if(pc=oc()){
    var qc=N[ra];
    S=pc[B]("Opera")==0;
    lc=!S&&pc[B]("MSIE")!=-1;
    mc=!S&&pc[B]("WebKit")!=-1;
    nc=!S&&!mc&&qc.product=="Gecko"
    }
    var T=lc,rc=nc,sc=mc,tc=N[ra],uc=(tc&&tc.platform||J)[B]("Mac")!=-1,vc;
    a:{
        var wc=J,xc;
        if(S&&N.opera)var yc=N.opera.version,wc=typeof yc==L?yc():yc;
        else if(rc?xc=/rv\:([^\);]+)(\)|;)/:T?xc=/MSIE\s+([^\);]+)(\)|;)/:sc&&(xc=/WebKit\/(\S+)/),xc)var zc=xc.exec(oc()),wc=zc?zc[1]:J;
        if(T){
            var Ac,Bc=N.document;
            Ac=Bc?Bc.documentMode:h;
            if(Ac>parseFloat(wc)){
                vc=s(Ac);
                break a
            }
        }
        vc=wc
    }
    var Cc=vc,Dc={};

function U(a){
    return Dc[a]||(Dc[a]=ac(Cc,a)>=0)
    };

var Ec,Fc=!T||U("9");
!rc&&!T||T&&U("9")||rc&&U("1.9.1");
T&&U("9");
function Gc(a){
    return(a=a.className)&&typeof a[F]==L?a[F](/\s+/):[]
    }
    function Hc(a){
    var c=Gc(a),b=ic(arguments,1),d;
    d=c;
    for(var f=0,e=0;e<b[D];e++)cc(d,b[e])>=0||(d[y](b[e]),f++);
    d=f==b[D];
    ca(a,c.join(sa));
    return d
    }
    function Ic(a){
    var c=Gc(a),b=ic(arguments,1),d;
    d=c;
    for(var f=0,e=0;e<d[D];e++)cc(b,d[e])>=0&&(hc(d,e--,1),f++);
    d=f==b[D];
    ca(a,c.join(sa));
    return d
    };

function Jc(a,c){
    Qb(c,function(b,c){
        c==zb?a[G].cssText=b:c==Sa?ca(a,b):c==Wa?a.htmlFor=b:c in Kc?a.setAttribute(Kc[c],b):a[c]=b
        })
    }
    var Kc={
    cellpadding:"cellPadding",
    cellspacing:"cellSpacing",
    colspan:"colSpan",
    rowspan:"rowSpan",
    valign:"vAlign",
    height:"height",
    width:"width",
    usemap:"useMap",
    frameborder:"frameBorder",
    maxlength:"maxLength",
    type:"type"
};
function Lc(a,c,b,d){
    function f(b){
        b&&c[x](Jb(b)?a.createTextNode(b):b)
        }
        for(;d<b[D];d++){
        var e=b[d];
        if(Ib(e)&&!(Lb(e)&&e.nodeType>0)){
            var g;
                a:{
                if(e&&typeof e[D]==nb)if(Lb(e)){
                    g=typeof e.item==L||typeof e.item==yb;
                    break a
                }else if(Kb(e)){
                    g=typeof e.item==L;
                    break a
                }
                g=!1
                }
                dc(g?gc(e):e,f)
            }else f(e)
            }
        }
    function Mc(a){
    this.N=a||N.document||t
    }
    M=Mc[E];
M.j=function(){
    var a=this.N,c=arguments,b=c[0],d=c[1];
    if(!Fc&&d&&(d[na]||d[C])){
        b=[Ka,b];
        d[na]&&b[y](xa,Vb(d[na]),za);
        if(d[C]){
            b[y](ya,Vb(d[C]),za);
            var f={};

            Sb(f,d);
            d=f;
            delete d[C]
        }
        b[y](La);
        b=b.join(J)
        }
        b=a[ka](b);
    d&&(Jb(d)?ca(b,d):O(d)==K?Hc[I](i,[b].concat(d)):Jc(b,d));
    c[D]>2&&Lc(a,b,c,2);
    return b
    };

M.createElement=function(a){
    return this.N[ka](a)
    };

M.createTextNode=function(a){
    return this.N.createTextNode(a)
    };

M.appendChild=function(a,c){
    a[x](c)
    };

M.O=function(a){
    for(var c;c=a.firstChild;)a.removeChild(c)
        };

var Nc=new Function("a","return a");
var Oc;
!T||U("9");
T&&U("8");
function Pc(){}
Pc[E].da=!1;
Pc[E].F=function(){
    if(!this.da)this.da=!0,this.q()
        };

Pc[E].q=function(){};

function V(a,c){
    ba(this,a);
    da(this,c);
    aa(this,this.target)
    }
    Pb(V,Pc);
V[E].q=function(){
    delete this[C];
    delete this.target;
    delete this.currentTarget
    };

V[E].L=!1;
V[E].sa=!0;
function Qc(a,c){
    a&&this.C(a,c)
    }
    Pb(Qc,V);
M=Qc[E];
da(M,i);
M.relatedTarget=i;
M.offsetX=0;
M.offsetY=0;
M.clientX=0;
M.clientY=0;
M.screenX=0;
M.screenY=0;
M.button=0;
M.keyCode=0;
M.charCode=0;
M.ctrlKey=!1;
M.altKey=!1;
M.shiftKey=!1;
M.metaKey=!1;
M.ra=!1;
M.aa=i;
M.C=function(a,c){
    var b=ba(this,a[C]);
    V[H](this,b);
    da(this,a.target||a.srcElement);
    aa(this,c);
    var d=a.relatedTarget;
    if(d){
        if(rc){
            var f;
                a:{
                try{
                    Nc(d.nodeName);
                    f=!0;
                    break a
                }catch(e){}
                f=!1
                }
                f||(d=i)
            }
        }else if(b==kb)d=a.fromElement;
else if(b==jb)d=a.toElement;
this.relatedTarget=d;
this.offsetX=a.offsetX!==h?a.offsetX:a.layerX;
this.offsetY=a.offsetY!==h?a.offsetY:a.layerY;
this.clientX=a.clientX!==h?a.clientX:a.pageX;
this.clientY=a.clientY!==h?a.clientY:a.pageY;
this.screenX=a.screenX||0;
this.screenY=a.screenY||
0;
this.button=a.button;
this.keyCode=a[la]||0;
this.charCode=a.charCode||(b==eb?a[la]:0);
this.ctrlKey=a.ctrlKey;
this.altKey=a.altKey;
this.shiftKey=a.shiftKey;
this.metaKey=a.metaKey;
this.ra=uc?a.metaKey:a.ctrlKey;
this.state=a.state;
this.aa=a;
delete this.sa;
delete this.L
};

M.q=function(){
    Qc.$.q[H](this);
    this.aa=i;
    da(this,i);
    aa(this,i);
    this.relatedTarget=i
    };

function W(a,c){
    this.ba=c;
    this.h=[];
    this.qa(a)
    }
    Pb(W,Pc);
M=W[E];
M.M=i;
M.ea=i;
M.w=function(a){
    this.M=a
    };

M.getObject=function(){
    if(this.h[D])return this.h.pop();
    return this.ca()
    };

M.v=function(a){
    this.h[D]<this.ba?this.h[y](a):this.Z(a)
    };

M.qa=function(a){
    if(a>this.ba)throw n("[goog.structs.SimplePool] Initial cannot be greater than max");
    for(var c=0;c<a;c++)this.h[y](this.ca())
        };

M.ca=function(){
    return this.M?this.M():{}
};

M.Z=function(a){
    if(this.ea)this.ea(a);
    else if(Lb(a))if(Kb(a.F))a.F();else for(var c in a)delete a[c]
        };
M.q=function(){
    W.$.q[H](this);
    for(var a=this.h;a[D];)this.Z(a.pop());
    delete this.h
    };

var Rc,Sc=(Rc="ScriptEngine"in N&&N.ScriptEngine()=="JScript")?N.ScriptEngineMajorVersion()+Ha+N.ScriptEngineMinorVersion()+Ha+N.ScriptEngineBuildVersion():Ia;
function Tc(){}
var Uc=0;
M=Tc[E];
M.key=0;
M.m=!1;
M.X=!1;
M.C=function(a,c,b,d,f,e){
    if(Kb(a))this.Y=!0;
    else if(a&&a[ma]&&Kb(a[ma]))this.Y=!1;else throw n("Invalid listener argument");
    this.B=a;
    this.V=c;
    this.src=b;
    ba(this,d);
    this.capture=!!f;
    this.U=e;
    this.X=!1;
    this.key=++Uc;
    this.m=!1
    };

M.handleEvent=function(a){
    if(this.Y)return this.B[H](this.U||this.src,a);
    return this.B[ma][H](this.B,a)
    };

var Vc,Wc,Xc,Yc,Zc,$c,ad,bd,cd,dd,ed;
(function(){
    function a(){
        return{
            e:0,
            l:0
        }
    }
    function c(){
    return[]
    }
    function b(){
    function a(b){
        return g[H](a.src,a.key,b)
        }
        return a
    }
    function d(){
    return new Tc
    }
    function f(){
    return new Qc
    }
    var e=Rc&&!(ac(Sc,Ja)>=0),g;
    $c=function(a){
    g=a
    };

if(e){
    Vc=function(){
        return m[ja]()
        };

    Wc=function(a){
        m.v(a)
        };

    Xc=function(){
        return j[ja]()
        };

    Yc=function(a){
        j.v(a)
        };

    Zc=function(){
        return k[ja]()
        };

    ad=function(){
        k.v(b())
        };

    bd=function(){
        return l[ja]()
        };

    cd=function(a){
        l.v(a)
        };

    dd=function(){
        return p[ja]()
        };

    ed=function(a){
        p.v(a)
        };

    var m=
    new W(0,600);
    m.w(a);
    var j=new W(0,600);
    j.w(c);
    var k=new W(0,600);
    k.w(b);
    var l=new W(0,600);
    l.w(d);
    var p=new W(0,600);
    p.w(f)
    }else Vc=a,Wc=Hb,Xc=c,Yc=Hb,Zc=b,ad=Hb,bd=d,cd=Hb,dd=f,ed=Hb
    })();
var X={},Y={},Z={},fd={};
function gd(a,c,b,d,f){
    if(c)if(O(c)==K){
        for(var e=0;e<c[D];e++)gd(a,c[e],b,d,f);
        return i
        }else{
        var d=!!d,g=Y;
        c in g||(g[c]=Vc());
        g=g[c];
        d in g||(g[d]=Vc(),g.e++);
        var g=g[d],m=a[P]||(a[P]=++Mb),j;
        g.l++;
        if(g[m]){
            j=g[m];
            for(e=0;e<j[D];e++)if(g=j[e],g.B==b&&g.U==f){
                if(g.m)break;
                return j[e].key
                }
            }else j=g[m]=Xc(),g.e++;
        e=Zc();
        e.src=a;
        g=bd();
        g.C(b,e,a,c,d,f);
        b=g.key;
        e.key=b;
        j[y](g);
        X[b]=g;
        Z[m]||(Z[m]=Xc());
        Z[m][y](g);
        a.addEventListener?(a==N||!a.oa)&&a.addEventListener(c,e,d):a.attachEvent(hd(c),e);
        return b
        }else throw n("Invalid event type");
}
function id(a,c,b,d){
    if(!d.D&&d.W){
        for(var f=0,e=0;f<d[D];f++)if(d[f].m){
            var g=d[f].V;
            g.src=i;
            ad(g);
            cd(d[f])
            }else f!=e&&(d[e]=d[f]),e++;d.length=e;
        d.W=!1;
        e==0&&(Yc(d),delete Y[a][c][b],Y[a][c].e--,Y[a][c].e==0&&(Wc(Y[a][c]),delete Y[a][c],Y[a].e--),Y[a].e==0&&(Wc(Y[a]),delete Y[a]))
        }
    }
function hd(a){
    if(a in fd)return fd[a];
    return fd[a]=pb+a
    }
function jd(a,c,b,d,f){
    var e=1,c=c[P]||(c[P]=++Mb);
    if(a[c]){
        a.l--;
        a=a[c];
        a.D?a.D++:a.D=1;
        try{
            for(var g=a[D],m=0;m<g;m++){
                var j=a[m];
                j&&!j.m&&(e&=kd(j,f)!==!1)
                }
            }finally{
        a.D--,id(b,d,c,a)
        }
    }
return Boolean(e)
}
function kd(a,c){
    var b=a[ma](c);
    if(a.X){
        var d=a.key;
        if(X[d]){
            var f=X[d];
            if(!f.m){
                var e=f.src,g=f[C],m=f.V,j=f.capture;
                e.removeEventListener?(e==N||!e.oa)&&e.removeEventListener(g,m,j):e.detachEvent&&e.detachEvent(hd(g),m);
                e=e[P]||(e[P]=++Mb);
                m=Y[g][j][e];
                if(Z[e]){
                    var k=Z[e];
                    ec(k,f);
                    k[D]==0&&delete Z[e]
                }
                f.m=!0;
                m.W=!0;
                id(g,j,e,m);
                delete X[d]
            }
        }
    }
return b
}
$c(function(a,c){
    if(!X[a])return!0;
    var b=X[a],d=b[C],f=Y;
    if(!(d in f))return!0;
    var f=f[d],e,g;
    Oc===h&&(Oc=T&&!N.addEventListener);
    if(Oc){
        e=c||Gb(Eb);
        var m=!0 in f,j=!1 in f;
        if(m){
            if(e[la]<0||e.returnValue!=h)return!0;
                a:{
                var k=!1;
                if(e[la]==0)try{
                    e.keyCode=-1;
                    break a
                }catch(l){
                    k=!0
                    }
                    if(k||e.returnValue==h)e.returnValue=!0
                    }
                }
            k=dd();
    k.C(e,this);
    e=!0;
    try{
        if(m){
            for(var p=Xc(),q=k.currentTarget;q;q=q.parentNode)p[y](q);
            g=f[!0];
            g.l=g.e;
            for(var r=p[D]-1;!k.L&&r>=0&&g.l;r--)aa(k,p[r]),e&=jd(g,p[r],d,!0,k);
            if(j){
                g=
                f[!1];
                g.l=g.e;
                for(r=0;!k.L&&r<p[D]&&g.l;r++)aa(k,p[r]),e&=jd(g,p[r],d,!1,k)
                    }
                }else e=kd(b,k)
        }finally{
    if(p)p.length=0,Yc(p);
    k.F();
    ed(k)
    }
    return e
}
d=new Qc(c,this);
try{
    e=kd(b,d)
    }finally{
    d.F()
    }
    return e
});
function $(a){
    this.A=a;
    this.t={};

    this.f=[];
    this.k=[];
    this.z={};

    this.Q=i;
    this.g=[];
    this.G=Ec||(Ec=new Mc);
    this.b=new Tb
    }
    a:{
        var ld=Gb("google.loader.GoogleApisBase");
        ld!=i||(ld="http://ajax.googleapis.com/ajax");
        var md=Gb("google.visualization.Version");
        md!=i||(md="1.0");
        // comment by sommart.j
        // for(var nd=ld+"/static/modules/gviz/"+md+"/orgchart/orgchart.css",od=t[oa]("LINK"),pd=0;pd<od[D];pd++)if(od[pd]&&od[pd].href&&od[pd].href==nd)break a;var qd=t[ka]("link");
        for(var nd=ld+"/css/orgchart.css",od=t[oa]("LINK"),pd=0;pd<od[D];pd++)if(od[pd]&&od[pd].href&&od[pd].href==nd)break a;var qd=t[ka]("link");
        qd.href=nd;
        qd.rel="stylesheet";
        ba(qd,"text/css");
        if(t[oa]("head")[D]==0){
            var rd=t[oa]("html")[0],sd=t[oa]("body")[0],td=t[ka]("head");
            rd.insertBefore(td,sd)
            }
            t[oa]("head")[0][x](qd)
        }
M=$[E];
M.I=0;
M.draw=function(a,c){
    this.z=c=c||{};

    this.Q=a;
    this.k=[];
    if(!this.A)throw n("Container is not defined");
    if(!a)throw n("Data table is not defined");
    this.T(a,c)
    };
M.T=function(a,c){
    this.t={};

    this.f=[];
    this.g=[];
    var b=[];
    if(a.getNumberOfColumns()>=2)for(var d=0;d<a.getNumberOfRows();d++){
        var f={
            a:d,
            name:s(a.getValue(d,0)),
            i:a.getFormattedValue(d,0),
            parent:a.getFormattedValue(d,1),
            style:a.getRowProperty(d,zb),
            s:a.getRowProperty(d,vb)
            };

        if(a.getNumberOfColumns()==3)f.label=a.getFormattedValue(d,2);
        b[y](f)
        }
        for(var d=[],e,g=0;g<b[D];g++)if(e=b[g][na]){
        var m=b[g].parent;
        if(f=this.t[e]){
            if(f.a==-1)f.a=b[g].a,f.i=b[g].i,f.label=b[g].label,f.style=b[g][G],f.s=b[g].s
                }else this.t[e]=
            f={
                a:b[g].a,
                name:e,
                i:b[g].i,
                label:b[g].label,
                style:b[g][G],
                s:b[g].s,
                c:[]
            },d[y](f);
        m?(e=this.t[m],e||(this.t[m]=e={
            a:-1,
            name:m,
            i:m,
            c:[]
        },d[y](e)),f.parent=e):f.parent=i;
        f.a>=0&&(this.g[f.a]=f)
        }
        for(var b=0,m=d[D],j=this.f[0]=[],k=!1;m>0;){
        for(var l=!1,g=0;g<d[D];g++)if(f=d[g],f.u==i){
            if(k)f.parent=i,k=!1;
            e=f.parent;
            if(!e||e.u!=i)f.u=e?e.u+1:0,b=w.max(b,f.u),m--,l=!0,(e?e.c:j)[y](f)
                }
                k=!l
        }
        for(g=1;g<=b;g++)this.f[g]=[];
    for(g=0;g<j[D];g++)this.S(j[g]);
    this.ga(c);
    google[qa][ha][ea](this,sb,{})
    };
M.S=function(a){
    if(!this.r(a.a)){
        a=a.c;
        jc(a,function(a,b){
            return a.a-b.a
            });
        for(var c=0;c<a[D];c++){
            var b=a[c];
            this.f[b.u][y](b);
            this.S(b)
            }
        }
    };

M.R=function(a){
    var c=a.c,b=c[D];
    if(b==0)a.x=this.I++;
    else{
        for(var d=0;d<b;d++)this.R(c[d]);
        a.x=(c[0].x+c[b-1].x)/2
        }
    };
M.ga=function(a){
    var c=this.A;
    this.I=0;
    for(var b=this.f[0],d=0;d<b[D];d++)this.R(b[d]);
    b=a.size;
    b!=fb&&b!=wb&&(b=hb);
    var f=this.G,e=f.j(Ab,{
        "class":db,
        dir:gb,
        cellpadding:Ia,
        cellspacing:Ia,
        align:Ra
    }),g=f.j(Bb);
    f[x](e,g);
    var m=8*this.I-2,j=f.j(Db,i);
    f[x](g,j);
    for(var k=0;k<m;k++){
        var l=f.j(Cb,{
            "class":cb+b
            });
        f[x](j,l)
        }
        j=this.f[D]-1;
    for(k=0;k<=j;k++){
        var p=this.f[k],q,r;
        if(k>0){
            q=[];
            for(var A=0;A<p[D];A++)r=p[A],l=r.parent,d=w[fa](r.x*8+3),l.x>=r.x?((l=q[d])||(l=q[d]={}),l.borderLeft=!0):((l=q[--d])||
                (l=q[d]={}),l.borderRight=!0);
            this.J(q,m,g,Ya+b,b,a)
            }
            q=[];
        for(A=0;A<p[D];A++)r=p[A],d=w[fa](r.x*8),(l=q[d])||(l=q[d]={}),l.d=r,l.span=6;
        this.J(q,m,g,ab+b,b,a);
        if(k!=j){
            q=[];
            for(A=0;A<p[D];A++){
                r=p[A];
                var Oa=r.c;
                if(Oa[D]>0&&(d=w[fa](r.x*8+3),(l=q[d])||(l=q[d]={}),l.borderLeft=!0,!this.r(r.a))){
                    r=w[fa](Oa[Oa[D]-1].x*8+3);
                    for(d=w[fa](Oa[0].x*8+3);d<r;d++)(l=q[d])||(l=q[d]={}),l.borderBottom=!0
                        }
                    }
            this.J(q,m,g,Ya+b,b,a)
        }
    }
    f.O(c);
f[x](c,e)
};
M.J=function(a,c,b,d,f,e){
    var g=e.nodeClass||$a,m=this.G,d=m.j(Db,{
        "class":d
    });
    m[x](b,d);
    for(b=0;b<c;b++){
        var j=a[b],k=m.j(Cb,i);
        if(!j){
            for(var j={
                empty:!0
                },l=b+1;l<c&&!a[l];)l++;
            j.span=l-b
            }
            if((l=j.span)&&l>1)k.colSpan=l,b+=l-1;
        l=J;
        if(j.d){
            j.d.P=k;
            var l=g+wa+f,p=j.d.a;
            p>-1&&(gd(k,ib,Q(this.ja,this,p)),gd(k,kb,Q(this.la,this,p)),gd(k,jb,Q(this.ka,this,p)),this.z.allowCollapse&&gd(k,Va,Q(this.ia,this,p)))
            }else l=Za,j.borderLeft&&(l+=ua),j.borderRight&&(l+=va),j.borderBottom&&(l+=ta);
        if(l&&(ca(k,l),
            l[B](g)>-1)){
            if(e[ia])k[G].background=e[ia];
            this.H(k,j.d&&j.d[G])
            }
            l=j.d?j.d.i:Fb;
        j=j.d?j.d.label:i;
        if(j!=i)k.title=j;
        e.allowHtml?k.innerHTML=l:m[x](k,m.createTextNode(l));
        m[x](d,k)
        }
    };

M.getSelection=function(){
    return this.b.getSelection()
    };
M.setSelection=function(a){
    var c=this.z,b=this.b.setSelection(a);
    if(this.A){
        for(var a=c.selectedNodeClass||bb,d=b.na.K(),f=0;f<d[D];f++){
            var e=d[f],g=(e=e>=0?this.g[e]:i)?e.P:i;
            if(g){
                Ic(g,a);
                if(c[ia])g[G].background=c[ia];
                this.H(g,e[G])
                }
            }
        b=b.ma.K();
    for(f=0;f<b[D];f++)if(e=b[f],g=(e=e>=0?this.g[e]:i)?e.P:i){
        Hc(g,a);
        if(c.selectionColor)g[G].background=c.selectionColor;
        this.H(g,e.s)
        }
    }
};

M.ja=function(a){
    this.setSelection(this.b.pa(a)?i:[{
        row:a
    }]);
    google[qa][ha][ea](this,ub,{})
    };
M.la=function(a){
    google[qa][ha][ea](this,rb,{
        row:a
    })
    };

M.ka=function(a){
    google[qa][ha][ea](this,qb,{
        row:a
    })
    };

M.ia=function(a){
    this.collapse(a,!this.r(a))
    };

M.H=function(a,c){
    if(c)a[G].cssText=c
        };

M.ha=function(a,c){
    var b=this.g[a];
    b&&b.c&&b.c[D]!=0&&(c&&!(cc(this.k,a)>=0)?this.k[y](a):ec(this.k,a))
    };

M.r=function(a){
    return cc(this.k,a)>=0
    };

M.getCollapsedNodes=function(){
    return gc(this.k)
    };

M.getChildrenIndexes=function(a){
    a=this.g[a];
    if(!a)return[];
    for(var a=a.c,c=[],b=0;b<a[D];b++)c[y](a[b].a);
    return c
    };
M.collapse=function(a,c){
    var b=this.g[a];
    if(b&&b.c&&b.c[D]!=0&&(c&&!this.r(a)||!c&&this.r(a)))this.ha(a,c),this.G.O(this.A),this.T(this.Q,this.z),google[qa][ha][ea](this,Ta,{
        collapsed:c,
        a:a
    })
    };

google_exportSymbol("google.visualization.OrgChart",$);
u($[E],"draw",$[E].draw);
u($[E],"getSelection",$[E].getSelection);
u($[E],"setSelection",$[E].setSelection);
u($[E],"getChildrenIndexes",$[E].getChildrenIndexes);
u($[E],"getCollapsedNodes",$[E].getCollapsedNodes);
u($[E],Ta,$[E].collapse);
})();
google.loader.loaded({
    "module":"visualization",
    "version":"1.0",
    "components":["default","orgchart"]
    });
google.loader.eval.visualization = function() {
    eval(arguments[0]);
};

if (google.loader.eval.scripts && google.loader.eval.scripts['visualization']) {
    (function() {
        var scripts = google.loader.eval.scripts['visualization'];
        for (var i = 0; i < scripts.length; i++) {
            google.loader.eval.visualization(scripts[i]);
        }
        })();
google.loader.eval.scripts['visualization'] = null;
}
})();