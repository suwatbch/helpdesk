//**************************************************
//  Trial Version
//
//
//  Deluxe Tree (c) 2006 - 2009, by Deluxe-Tree.com
//  version 3.15
//  http://deluxe-tree.com
//  E-mail:  support@deluxe-menu.com
//
//  ------
//  Obfuscated by Javascript Obfuscator
//  http://javascript-source.com

//
//**************************************************

function dtreet_ext_getItemIDByIndex(tmi,t1i){
    var tv=tt[tmi].i[0];
    var j=0;
    while(j!=t1i&&tv){
        tv=_tl1l(tv);
        j++;
    }
    return tv?tv.id:null;
}
function dtreet_ext_getNextItemID(ti1){
    var tv=_tvi(ti1);
    tv=_tl1l(tv);
    if(!tv){
        return null;
    }
    return tv.id;
}
function dtreet_ext_getPrevItemID(ti1){
    var tv=_tvi(ti1);
    tv=_tI1(tv);
    if(!tv){
        return null;
    }
    return tv.id;
}
function dtreet_ext_getLastItemID(tmi){
    var tv=_tl1(tmi);
    return tv?tv.id:tv;
}
function dtreet_ext_showItem(ti1,tsh){
    var tv=_tvi(ti1);
    if(!tv){
        return null;
    }
    with(tv){
        if(til){
            return;
        }
        if(tt[tmi].tpx&&tvl==0){
            _toi(id).style.display=tsh?"":"none";
            _toi(id+"divXP").style.display=tsh?"":"none";
        }else{
            if(!tsh){
                _txe(tv,0);
            }
            _toi(id+"TR").style.display=tsh&&tiv?"":"none";
        }
        tih=!tsh;
        }
    }
    function dtreet_ext_expandItem(ti1,txe){
    var tv=_tvi(ti1);
    if(!tv){
        return null;
    }
    with(tv){
        if(tt[tmi].tpx&&tvl==0){
            if(tex!=txe){
                tt.I2(tv);
            }
        }else{
        _txe(tv,txe);
    }
}
}
function dtreet_ext_deleteItem(tmi,ti1){
    var tv=_tvi(ti1);
    if(!tv){
        return null;
    }
    with(tv){
        var tm=tt[tmi];
        with(tm){
            if(tpdi==tv.id){
                tpdi="";
            }
            tou--;
            }
            if(thc){
            while(i.length){
                dtreet_ext_deleteItem(tmi,i[0].id);
            }
        }
        if(tm.tpx&&!tvl){
        if(tsn&&tv1<7){
            dtreet_ext_showItem(ti1,0);
        }else{
            var tob=_toi(id);
            tob.parentNode.removeChild(tob);
            tob=_toi(id+"divXP");
            tob.parentNode.removeChild(tob);
        }
    }else{
    var trw=_toi(id+"TR");
    trw.parentNode.parentNode.deleteRow(trw.rowIndex);
}
var tps=_toi(tv.id+"space");
if(tps){
    tps.parentNode.removeChild(tps);
}
_tiic(_tpi,tnd+1,-1);
with(_tpi){
    var tsi=i.slice(0,tv.tnd);
    var tei=i.slice(tv.tnd+1,i.length);
    i=tsi.concat(tei);
    if(!i.length){
        thc=0;
        _tp(tm,tv);
    }
}
}
}
function _tr(tmi,tba,t1i,tbl,trl){
    var tcc=tba.i.length;
    if(!tcc){
        if(!tba.tvl){
            return 0;
        }else{
            return _toi(tba.id+"TR").rowIndex+1;
        }
    }
    if(t1i==tcc){
    return _toi(_tlll(tba).id+"TR").rowIndex+1;
}
var tv=_tI1(tba.i[t1i]);
if(tv.tvl>=trl){
    return _toi(tv.id+"TR").rowIndex+1;
}else{
    return 0;
}
}
function dtreet_ext_insertItem(tmi,td2,t1i,tpi){
    var tm=tt[tmi];
    if(td2){
        var tba=_tvi(td2);
        if(!tba){
            return null;
        }
        var tnll=tba.tvl+1;
    }else{
        var tba=tm;
        var tnll=0;
    }
    if(t1i==null){
        t1i=tba.i.length;
    }
    tpi[0]=tpi[0].substring(_tvl(tpi[0]),tpi[0].length);
    if(t1i<0){
        t1i=0;
    }
    if(t1i>tba.i.length){
        t1i=tba.i.length;
    }
    var tbl,tri;
    if(tm.tpx){
        if(tnll!=0){
            if(tnll==1){
                tbl=_toi(tba.id+"tbl");
            }else{
                tbl=_toi(tba.id+"TR").parentNode.parentNode;
            }
            tri=_tr(tmi,tba,t1i,tbl,1);
        }
    }else{
    if(tnll==0){
        tbl=_toi(tm.id+"tbl");
    }else{
        tbl=_toi(tba.id+"TR").parentNode.parentNode;
    }
    if(t1i==tba.i.length){
        tri=_toi(_tlll(tba).id+"TR").rowIndex+1;
    }else{
        tri=_toi(tba.i[t1i].id+"TR").rowIndex;
    }
}
_tbi(tba,t1i);
_tip(tm,tba,tpi,tnll,t1i);
var tvr=tcm.tv;
_tiv(tm,tvr);
var tnv=_tl1l(tba.i[t1i]);
if(tm.tph&&tnv){
    tvr.tptm=_tpm(tvr.tvl,tm.txl,tnv.tptm,tnv.tvl);
}
if(tm.tpx&&tnll==0){
    _toi(tm.id+"div").innerHTML+=tt.I(tm,tvr);
}else{
    var tnr=tbl.insertRow(tri);
    with(tvr){
        tnr.style.display=tiv&&!tih?"":"none";
        }
        tnr.id=tvr.id+"TR";
    var tdn=dtdo.createElement("TD");
    with(tdn){
        style.padding="0px";
        style.margin="0px";
        innerHTML=_tit(tm,tcm.tv,"",0);
        }
        tnr.appendChild(tdn);
}
_tp(tm,tvr);
}
function _tp(tm,tv){
    var tba=tv._tpi;
    if(tv.tvl>0){
        if(!tm.tpx||tm.tpx&&tv.tvl>1){
            with(_toi(tba.id+"btn")){
                src=tba.thc?tba.tex?tm.tbs[2]:tm.tbs[0]:tblankImage;
                style.cursor="pointer";
                }
            }
        }
}
function _tiic(tba,ti1f,tin){
    with(tba){
        for(var j=ti1f;j<i.length;j++){
            i[j].tnd+=tin;
        }
        }
    }
function _tbi(tba,t1i){
    _tiic(tba,t1i,1);
    with(tba){
        var tsi=i.slice(0,t1i);
        var tei=i.slice(t1i,i.length);
        i=tsi.concat([null]).concat(tei);
        }
    }
    function dtreet_ext_setPressedItem(tmi,ti1){
    _tsII(tt[tmi],ti1);
}
function dtreet_ext_changeItem(tmi,ti1,tpi){
    var tm=tt[tmi];
    var tv=_tvi(ti1);
    if(!tv){
        return null;
    }
    with(tv){
        if(tpi[0]){
            text=tpi[0];
        }
        if(typeof tpi[1]!=_un){
            link=_tlt(tpi[1]);
        }
        if(typeof tpi[6]!=_un){
            target=_tgt(tpi[6]);
        }
        if(typeof tpi[5]!=_un){
            tip=dtree_getParam(tpi[5],"");
        }
        if(typeof tpi[7]!=_un){
            tst=_tsi(tm,tpi[7]);
        }
        if(typeof tpi[2]!=_un||typeof tpi[3]!=_un||typeof tpi[4]!=_un){
            tic=_t1pp(_tic(tpi),tpathPrefix_img);
        }
        var to=_toi(id);
        to.title=tip;
        if(tm.tpx&&!tvl){
            _ttll(to,ti1,0);
        }else{
            _ti(to,ti1,0);
        }
        t1d=target=="_"?1:0;
        with(_toi(tv.id+"font")){
            innerHTML=text;
            _tf(tv,style,0,tm.tpdi==tv.id);
            }
        }
    }
function dtreet_ext_getItemParams(tmi,ti1){
    var tv=_tvi(ti1);
    if(!tv){
        return null;
    }
    with(tv){
        var iparams=[id,tnd,_tpi.id,tvl,thc,i.length,tex,text,link,target,tip,align,tic,tih,t1d,tiv];
        }
        return iparams;
}
function dtreet_ext_getMenuParams(tmi){
    with(tt[tmi]){
        var iparams=[id,i.length,tou,tpdi];
        }
        return iparams;
}