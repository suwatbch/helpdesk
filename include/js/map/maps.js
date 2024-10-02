(function(){
    function a(d){
        this.t={};

        this.tick=function(e,f,c){
            this.t[e]=[c!=undefined?c:(new Date).getTime(),f]
            };

        this.tick("start",null,d)
        }
        var b=new a;
    window.gmapstiming={
        Timer:a,
        load:b
    };

    try{
        var g=null;
        if(window.chrome&&window.chrome.csi)g=Math.floor(window.chrome.csi().pageT);
        if(g==null)if(window.gtbExternal)g=window.gtbExternal.pageT();
        if(g==null)if(window.external)g=window.external.pageT;
        if(g)window.gmapstiming.pt=g
            }catch(h){};

})();
gmapstiming.timers_ = {
    start:(new Date).getTime()
    };

gmapstiming.tick_ = function(x) {
    gmapstiming.timers_[x] = (new Date).getTime();
};

var _stats = 1;
var G_INCOMPAT = false;
function GScript(src) {
    document.write('<' + 'script src="' + src + '"' +' type="text/javascript"><' + '/script>');
}
function GBrowserIsCompatible() {
    if (G_INCOMPAT) return false;
    return true;
}
function GApiInit() {
    if (GApiInit.called) return;
    GApiInit.called = true;
    window.GAddMessages && GAddMessages({
        160: '\x3cH1\x3eข้อผิดพลาดของเซิร์ฟเวอร์\x3c/H1\x3e เซิร์ฟเวอร์เกิดข้อผิดพลาดชั่วขณะและไม่สามารถดำเนินการให้เสร็จสิ้นตามคำขอของคุณได้ \x3cp\x3eโปรดรอสักครู่แล้วลองอีกครั้ง\x3c/p\x3e',
        1415: '.',
        1416: ',',
        1547: 'ไมล์',
        1616: 'กม.',
        4100: 'ม.',
        4101: 'ฟุต',
        10018: 'กำลังโหลด...',
        10021: 'ขยาย',
        10022: 'ย่อ',
        10024: 'ลากเพื่อซูม',
        10029: 'กลับไปที่ผลลัพธ์ล่าสุด',
        10049: 'แผนที่',
        10050: 'ดาวเทียม',
        10093: 'ข้อกำหนดในการให้บริการ',
        10111: 'แผนที่',
        10112: 'ดาวเทียม',
        10116: 'ไฮบริด',
        10117: 'ผสม',
        10120: 'ขออภัย เราไม่มีแผนที่ที่ขยายถึงระดับนี้สำหรับภูมิภาคนี้\x3cp\x3eลองย่อส่วนเพื่อดูในมุมที่กว้างขึ้น\x3c/p\x3e',
        10121: 'ขออภัย เราไม่มีภาพที่ขยายถึงระดับนี้สำหรับภูมิภาคนี้ \x3cp\x3eลองย่อส่วนเพื่อดูในมุมที่กว้างขึ้น\x3c/p\x3e',
        10507: 'หันไปทางซ้าย',
        10508: 'หันไปทางขวา',
        10509: 'หันขึ้นด้านบน',
        10510: 'หันลงด้านล่าง',
        10511: 'แสดงแผนที่ถนน',
        10512: 'แสดงภาพสถานที่โดยรอบ',
        10513: 'แสดงภาพพร้อมชื่อถนน',
        10806: 'คลิกเพื่อดูพื้นที่นี้ใน Google แผนที่',
        10807: 'การจราจร',
        10808: 'แสดงการจราจร',
        10809: 'ซ่อนการจราจร',
        12150: '%1$s บน %2$s',
        12151: '%1$s บน %2$s บริเวณ %3$s',
        12152: '%1$s บน %2$s ระหว่าง %3$s และ %4$s',
        10985: 'ขยาย',
        10986: 'ย่อ',
        11047: 'ศูนย์กลางแผนที่ที่นี่',
        11089: '\x3ca href\x3d\x22javascript:void(0);\x22\x3eขยาย\x3c/a\x3e เพื่อดูการจราจรในบริเวณนี้',
        11259: 'เต็มจอ',
        11751: 'แสดงแผนที่เส้นทางพร้อมภูมิประเทศ',
        11752: 'รูปแบบ:',
        11757: 'เปลี่ยนรูปแบบแผนที่',
        11758: 'ภูมิประเทศ',
        11759: 'ภูมิประเทศ',
        11794: 'แสดงป้ายกำกับ',
        11303: 'ความช่วยเหลือสำหรับมุมมองถนน',
        11274: 'หากต้องการใช้มุมมองถนน คุณต้องติดตั้ง Adobe Flash Player เวอร์ชัน %1$d ขึ้นไป',
        11382: 'รับ Flash Player รุ่นล่าสุด',
        11314: 'ขออภัย ในขณะนี้มุมมองถนนไม่สามารถใช้ได้เนื่องจากมีความต้องการใช้งานมาก\x3cbr\x3eโปรดลองอีกครั้งในภายหลัง!',
        1559: 'N',
        1560: 'S',
        1561: 'W',
        1562: 'E',
        1608: 'NW',
        1591: 'NE',
        1605: 'SW',
        1606: 'SE',
        11907: 'ภาพนี้ไม่สามารถใช้งานได้อีกต่อไป',
        10041: 'ความช่วยเหลือ',
        12471: 'ตำแหน่งปัจจุบัน',
        12492: 'Earth',
        12823: 'Google ได้ปิดการใช้งาน Maps API สำหรับแอพพลิเคชั่นนี้ โปรดดูข้อกำหนดในการให้บริการสำหรับข้อมูลเพิ่มเติม:·%1$s',
        12822: 'http://code.google.com/apis/maps/terms.html',
        12915: 'ปรับปรุงแผนที่',
        12916: 'Google, Europa Technologies',
        13171: 'ไฮบริด 3 มิติ',
        0: ''
    });
}
var GLoad;
(function() {
    GLoad = function(apiCallback) {
        var callee = arguments.callee;
        if (!callee.called) {
            gmapstiming.tick_('e');
        }
        GApiInit();
        var opts = {
            export_legacy_names:true,
            tile_override:[{
                maptype:0,
                min_zoom:7,
                max_zoom:7,
                rect:[{
                    lo:{
                        lat_e7:330000000,
                        lng_e7:1246050000
                    },
                    hi:{
                        lat_e7:386200000,
                        lng_e7:1293600000
                    }
                },{
                lo:{
                    lat_e7:366500000,
                    lng_e7:1297000000
                },
                hi:{
                    lat_e7:386200000,
                    lng_e7:1320034790
                }
            }],
        uris:["http://mt0.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt1.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt2.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt3.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26"]
        },{
        maptype:0,
        min_zoom:8,
        max_zoom:9,
        rect:[{
            lo:{
                lat_e7:330000000,
                lng_e7:1246050000
            },
            hi:{
                lat_e7:386200000,
                lng_e7:1279600000
            }
        },{
        lo:{
            lat_e7:345000000,
            lng_e7:1279600000
        },
        hi:{
            lat_e7:386200000,
            lng_e7:1286700000
        }
    },{
    lo:{
        lat_e7:348900000,
        lng_e7:1286700000
    },
    hi:{
        lat_e7:386200000,
        lng_e7:1293600000
    }
},{
    lo:{
        lat_e7:354690000,
        lng_e7:1293600000
    },
    hi:{
        lat_e7:386200000,
        lng_e7:1320034790
    }
}],
uris:["http://mt0.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt1.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt2.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt3.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26"]
},{
    maptype:0,
    min_zoom:10,
    max_zoom:19,
    rect:[{
        lo:{
            lat_e7:329890840,
            lng_e7:1246055600
        },
        hi:{
            lat_e7:386930130,
            lng_e7:1284960940
        }
    },{
    lo:{
        lat_e7:344646740,
        lng_e7:1284960940
    },
    hi:{
        lat_e7:386930130,
        lng_e7:1288476560
    }
},{
    lo:{
        lat_e7:350277470,
        lng_e7:1288476560
    },
    hi:{
        lat_e7:386930130,
        lng_e7:1310531620
    }
},{
    lo:{
        lat_e7:370277730,
        lng_e7:1310531620
    },
    hi:{
        lat_e7:386930130,
        lng_e7:1320034790
    }
}],
uris:["http://mt0.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt1.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt2.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26","http://mt3.gmaptiles.co.kr/mt/v=kr1.13\x26hl=th\x26src=api\x26"]
},{
    maptype:3,
    min_zoom:7,
    max_zoom:7,
    rect:[{
        lo:{
            lat_e7:330000000,
            lng_e7:1246050000
        },
        hi:{
            lat_e7:386200000,
            lng_e7:1293600000
        }
    },{
    lo:{
        lat_e7:366500000,
        lng_e7:1297000000
    },
    hi:{
        lat_e7:386200000,
        lng_e7:1320034790
    }
}],
uris:["http://mt0.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt1.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt2.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt3.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26"]
},{
    maptype:3,
    min_zoom:8,
    max_zoom:9,
    rect:[{
        lo:{
            lat_e7:330000000,
            lng_e7:1246050000
        },
        hi:{
            lat_e7:386200000,
            lng_e7:1279600000
        }
    },{
    lo:{
        lat_e7:345000000,
        lng_e7:1279600000
    },
    hi:{
        lat_e7:386200000,
        lng_e7:1286700000
    }
},{
    lo:{
        lat_e7:348900000,
        lng_e7:1286700000
    },
    hi:{
        lat_e7:386200000,
        lng_e7:1293600000
    }
},{
    lo:{
        lat_e7:354690000,
        lng_e7:1293600000
    },
    hi:{
        lat_e7:386200000,
        lng_e7:1320034790
    }
}],
uris:["http://mt0.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt1.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt2.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt3.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26"]
},{
    maptype:3,
    min_zoom:10,
    rect:[{
        lo:{
            lat_e7:329890840,
            lng_e7:1246055600
        },
        hi:{
            lat_e7:386930130,
            lng_e7:1284960940
        }
    },{
    lo:{
        lat_e7:344646740,
        lng_e7:1284960940
    },
    hi:{
        lat_e7:386930130,
        lng_e7:1288476560
    }
},{
    lo:{
        lat_e7:350277470,
        lng_e7:1288476560
    },
    hi:{
        lat_e7:386930130,
        lng_e7:1310531620
    }
},{
    lo:{
        lat_e7:370277730,
        lng_e7:1310531620
    },
    hi:{
        lat_e7:386930130,
        lng_e7:1320034790
    }
}],
uris:["http://mt0.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt1.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt2.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26","http://mt3.gmaptiles.co.kr/mt/v=kr1p.12\x26hl=th\x26src=api\x26"]
}],
jsmain:"http://maps.gstatic.com/intl/th_ALL/mapfiles/310c/maps2.api/main.js",
experiment_ids:[200988],
bcp47_language_code:"th",
obliques_urls:["http://khmdb0.google.com/kh?v=37\x26","http://khmdb1.google.com/kh?v=37\x26"],
token:1433732793,
jsmodule_base_url:"http://maps.gstatic.com/intl/th_ALL/mapfiles/310c/maps2.api",
generic_tile_urls:["http://mt0.google.com/vt?hl=th\x26src=api\x26","http://mt1.google.com/vt?hl=th\x26src=api\x26"]
};

var pageArgs = {
    timers: gmapstiming.timers_
    };

apiCallback(["http://mt0.google.com/vt/lyrs\x3dm@147\x26hl\x3dth\x26src\x3dapi\x26","http://mt1.google.com/vt/lyrs\x3dm@147\x26hl\x3dth\x26src\x3dapi\x26"], ["http://khm0.google.com/kh/v\x3d81\x26","http://khm1.google.com/kh/v\x3d81\x26"], ["http://mt0.google.com/vt/lyrs\x3dh@147\x26hl\x3dth\x26src\x3dapi\x26","http://mt1.google.com/vt/lyrs\x3dh@147\x26hl\x3dth\x26src\x3dapi\x26"],"ABQIAAAAeNsNnRXUdrpgSw3qfvhz5hRHchrjOSPM-moa2HMmJZw-0fE6VhTsARfVd9x1Dg8TowZALqHIOcO20g","","",true,"google.maps.",opts,["http://mt0.google.com/vt/lyrs\x3dt@126,r@147\x26hl\x3dth\x26src\x3dapi\x26","http://mt1.google.com/vt/lyrs\x3dt@126,r@147\x26hl\x3dth\x26src\x3dapi\x26"],null  ,pageArgs);
if (!callee.called) {
    callee.called = true;
    gmapstiming.tick_('f');
}
}
})();
function GUnload() {
    if (window.GUnloadApi) {
        GUnloadApi();
    }
}
var _mIsRtl = false;
var _mF = [ ,,,,,20,4096,"bounds_cippppt.txt","cities_cippppt.txt","local/add/flagStreetView",true,,400,,,,,,,"/maps/c/ui/HovercardLauncher/dommanifest.js",,,,false,,,,,,,true,,,,,,,,"http://maps.google.com/maps/stk/fetch",0,,true,,,,true,,,,"http://maps.google.com/maps/stk/style",,"107485602240773805043.00043dadc95ca3874f1fa",,,false,1000,,"http://cbk0.google.com",false,,"ar,iw",,,,,,,,,"http://pagead2.googlesyndication.com/pagead/imgad?id\x3dCMKp3NaV5_mE1AEQEBgQMgieroCd6vHEKA",,,,,,false,,,,,"SS",,,,,,,,true,,,,,,true,,,,,"","1",,false,false,,true,,,,,,,,true,500,"http://chart.apis.google.com/chart?cht\x3dqr\x26chs\x3d80x80\x26chld\x3d|0\x26chl\x3d",,,,true,,,,,false,,,false,,true,,,true,,,,,,,,10,,true,true,,,,30,"infowindow_v1","",false,true,22,'http://khm.google.com/vt/lbw/lyrs\x3dm\x26hl\x3dth\x26','http://khm.google.com/vt/lbw/lyrs\x3ds\x26hl\x3dth\x26','http://khm.google.com/vt/lbw/lyrs\x3dy\x26hl\x3dth\x26','http://khm.google.com/vt/lbw/lyrs\x3dp\x26hl\x3dth\x26',,,false,"AT,AU,BE,BR,CA,CH,CN,CZ,DE,DK,FI,FR,GB,HK,HU,IE,IN,IT,KR,MX,MY,NL,NO,NZ,PL,PR,PT,RU,SE,SG,TH,TW,US",,,"windows-ie,windows-firefox,windows-chrome,macos-safari,macos-firefox,macos-chrome",true,,20000,600,30,,,,,,false,false,,,"maps.google.com",,,,,"",true,,,,true,"4:http://gt%1$d.google.com/mt?v\x3dgwm.fresh\x26","4:http://gt%1$d.google.com/mt?v\x3dgwh.fresh\x26",true,false,,,0.25,,"107485602240773805043.0004561b22ebdc3750300",,,,,false,,,true,,8,,,,,false,"https://cbks0.google.com",,true,,,,,,false,,,,,,,,false,,,true,true,false,,,,true,"http://mt0.google.com/vt/ft",,,"http://chart.apis.google.com/chart",,,,,,,'0.25',false,,,,,false,,2,160,,,,true,false,,,,,,,45,true,,false,true,true,,,,true,false,,,false,false,,,,false,false,,,,,false,,,,,true,,"DE,CH,LI,AT,BE,PL,NL,HU,GR,HR,CZ,SK,TR,BR,EE,ES,AD,SE,NO,DK,FI,IT,VA,SM,IL,CL,MX,AR,BG,PT",false,,"25",true,25,"Home for sale",,,,true,,,false,"4:https://gt%1$d.google.com/mt?v\x3dgwm.fresh\x26","4:https://gt%1$d.google.com/mt?v\x3dgwh.fresh\x26",,,,,"",,,false,true,,,,false,"1.x",,false,false,,,,,false,,,,,false,,,,,24,6,2,,,0,,,,,,,true,,,,false,,,false,,"/maps/c/u/0",true,100,10000,10,,8,,,,,,true,,false,,,3,5,,"windows-firefox,windows-ie,windows-chrome,macos-firefox,macos-safari,macos-chrome",true,,,false,false,true,,,,,false,,false,,,false,,false,,false,false,,,,true,,,"2",,'',true,false,18,false,,600,,,false,"http://www.google.com/maps/photos",true,,true,false,true,,false,,,,false,,,false,true,true,true,false,,,"AT,AU,BE,BR,CA,CH,CN,CZ,DE,DK,FI,FR,GB,HK,HU,IE,IN,IT,KR,MX,MY,NL,NO,NZ,PL,PR,PT,RU,SE,SG,TH,TW,US",false ];
var _mHost = "http://maps.google.com";
var _mUri = "/maps";
var _mDomain = "google.com";
var _mStaticPath = "http://maps.gstatic.com/intl/th_ALL/mapfiles/";
var _mJavascriptVersion = G_API_VERSION = "310c";
var _mTermsUrl = "http://www.google.com/intl/th_ALL/help/terms_maps.html";
var _mLocalSearchUrl = "http://www.google.com/uds/solutions/localsearch/gmlocalsearch.js";
var _mHL = "th";
var _mGL = "";
var _mTrafficEnableApi = true;
var _mTrafficTileServerUrls = ["http://mt0.google.com/mapstt","http://mt1.google.com/mapstt","http://mt2.google.com/mapstt","http://mt3.google.com/mapstt"];
var _mCityblockLatestFlashUrl = "http://maps.google.com/local_url?q=http://www.adobe.com/shockwave/download/download.cgi%3FP1_Prod_Version%3DShockwaveFlash&amp;dq=&amp;file=api&amp;v=2&amp;key=ABQIAAAAeNsNnRXUdrpgSw3qfvhz5hRHchrjOSPM-moa2HMmJZw-0fE6VhTsARfVd9x1Dg8TowZALqHIOcO20g&amp;s=ANYYN7manSNIV_th6k0SFvGB4jz36is1Gg";
var _mCityblockFrogLogUsage = false;
var _mCityblockInfowindowLogUsage = false;
var _mCityblockUseSsl = false;
var _mSatelliteToken = "fzwq1P89PWeWuO1Eqrha2fKQzQPdNRbUwD1Qeg";
var _mMapCopy = "ข้อมูลแผนที่ \x26#169;2011";
var _mSatelliteCopy = "ภาพ \x26#169;2011";
var _mGoogleCopy = "\x26#169;2011 Google";
var _mPreferMetric = false;
var _mDirectionsEnableApi = true;
var _mLayersTileBaseUrls = ['http://mt0.google.com/mapslt','http://mt1.google.com/mapslt','http://mt2.google.com/mapslt','http://mt3.google.com/mapslt'];
var _mLayersFeaturesBaseUrl = "http://mt0.google.com/vt/ft";
function GLoadMapsScript() {
    if (!GLoadMapsScript.called && GBrowserIsCompatible()) {
        GLoadMapsScript.called = true;
        gmapstiming.tick_('d');
        GScript("http://maps.gstatic.com/intl/th_ALL/mapfiles/310c/maps2.api/main.js");
    }
}(function() {
    if (!window.google) window.google = {};

    if (!window.google.maps) window.google.maps = {};

    var ns = window.google.maps;
    ns.BrowserIsCompatible = GBrowserIsCompatible;
    ns.Unload = GUnload;
})();
GLoadMapsScript();