var NR_QUEUE=[];
if(typeof(window.NREUMQ)!=="undefined"){
    NR_QUEUE=NREUMQ
}else{
    if(typeof(window.EPISODES)!=="undefined"){
        NR_QUEUE=EPISODES.q
    }else{
        if(typeof(window.NREUM)!=="undefined"){
            NR_QUEUE=NREUM.q
        }
    }
}
var NREUM=NREUM||{};

NREUM.q=NR_QUEUE;
NREUM.targetOrigin=document.location.protocol+"//"+document.location.host;
NREUM.version=7;
NREUM.autorun=("undefined"!==typeof(NREUM.autorun)?NREUM.autorun:true);
NREUM.init=function(){
    NREUM.bDone=false;
    NREUM.cycle=0;
    NREUM.logging=false;
    NREUM.contentLoadFired=false;
    NREUM.marks={};
    
    NREUM.measures={};
    
    NREUM.starts={};
    
    NREUM.findStartTime();
    NREUM.addEventListener("beforeunload",NREUM.beforeUnload,false);
    NREUM.addEventListener("pagehide",NREUM.beforeUnload,false);
    NREUM.processQ();
    NREUM.beacon=null;
    NREUM.licenseKey=null;
    NREUM.applicationID=null;
    NREUM.transactionName=null;
    NREUM.txnParam=null;
    NREUM.unloaded=false;
    if(document.readyState==="complete"){
        NREUM.domContentLoaded()
    }else{
        if("undefined"!==typeof(document.addEventListener)){
            document.addEventListener("DOMContentLoaded",NREUM.domContentLoaded,false)
        }else{
            if("undefined"!==typeof(document.attachEvent)){
                document.attachEvent("onreadystatechange",NREUM.readyStateChange)
            }
        }
    }
    if(document.loaded){
        NREUM.onload()
    }else{
        NREUM.addEventListener("load",NREUM.onload,false)
    }
};

NREUM.processQ=function(){
    var a=NREUM.q.length;
    var d;
    var c;
    var b;
    for(b=0;b<a;b++){
        d=NREUM.q[b];
        c=d[0];
        if("mark"===c){
            NREUM.mark(d[1],d[2])
        }else{
            if("measure"===c){
                NREUM.measure(d[1],d[2],d[3])
            }else{
                if("done"===c){
                    NREUM.done(d[1])
                }else{
                    if(("nrf"===c)||("nrfinish"===c)){
                        NREUM.nrfinish("t",d[1],d[2],d[3],d[4],d[5],d[6],d[7])
                    }else{
                        if(("nrf2"===c)||("nrfinish2"===c)){
                            NREUM.nrfinish("to",d[1],d[2],d[3],d[4],d[5],d[6],d[7])
                        }else{
                            NREUM.dprint("Unknown queue command "+c)
                        }
                    }
                }
            }
        }
    }
};

NREUM.nrfinish=function(e,f,d,g,b,c,a,h){
    NREUM.dprint("NREUM: finish data received");
    NREUM.txnParam=e;
    NREUM.beacon=f;
    NREUM.licenseKey=d;
    NREUM.applicationID=g;
    NREUM.transactionName=b;
    NREUM.measures.qt=c;
    NREUM.measures.ap=a;
    NREUM.dom_end_time=h
};
    
NREUM.mark=function(a,b){
    NREUM.dprint("NREUM.mark: "+a+", "+b);
    if(!a){
        NREUM.dprint("Error: markName is undefined in NREUM.mark.");
        return
    }
    NREUM.marks[a]=parseInt(b||new Date().getTime(),10);
    if("firstbyte"===a){
        NREUM.measure("be","starttime","firstbyte");
        NREUM.dom_start_time=NREUM.marks.firstbyte
    }else{
        if("onload"===a){
            NREUM.measure("fe","firstbyte","onload")
        }else{
            if("domContent"===a){
                NREUM.measure("dc","firstbyte","domContent")
            }
        }
    }
};

NREUM.measure=function(c,b,e){
    NREUM.dprint("NREUM.measure: "+c+", "+b+", "+e);
    if(!c){
        NREUM.dprint("Error: episodeName is undefined in NREUM.measure.");
        return
    }
    var a;
    if("undefined"===typeof(b)){
        if("number"===typeof(NREUM.marks[c])){
            a=NREUM.marks[c]
        }else{
            a=new Date().getTime()
        }
    }else{
        if("number"===typeof(NREUM.marks[b])){
            a=NREUM.marks[b]
        }else{
            if("number"===typeof(b)){
                a=b
            }else{
                NREUM.dprint("Error: unexpected startNameOrTime in NREUM.measure: "+b);
                return
            }
        }
    }
    var d;
    if("undefined"===typeof(e)){
        d=new Date().getTime()
    }else{
        if("number"===typeof(NREUM.marks[e])){
            d=NREUM.marks[e]
        }else{
            if("number"===typeof(e)){
                d=e
            }else{
                NREUM.dprint("NREUM: Error: unexpected endNameOrTime in NREUM.measure: "+e);
                return
            }
        }
    }
    NREUM.starts[c]=parseInt(a,10);
    NREUM.measures[c]=parseInt(d-a,10)
};

NREUM.done=function(a){
    NREUM.bDone=true;
    NREUM.mark("done");
    if(NREUM.autorun){
        NREUM.sendBeacon()
    }
    if("function"===typeof(a)){
        a()
    }
};

NREUM.getMarks=function(){
    return NREUM.marks
};
    
NREUM.getMeasures=function(){
    return NREUM.measures
};
    
NREUM.getStarts=function(){
    return NREUM.starts
};
    
NREUM.sendBeacon=function(){
    NREUM.processQ();
    NREUM.domContentLoaded();
    if((NREUM.licenseKey===null)||(NREUM.applicationID===null)){
        NREUM.dprint("NREUM: licenseKey or applicationID has not been set");
        return
    }
    if(NREUM.dom_end_time&&NREUM.dom_start_time){
        NREUM.dprint("NREUM: picking up DOM processing time from embedded JS");
        NREUM.mark("domContent",NREUM.dom_end_time)
    }
    var e=NREUM.getMeasures();
    var a="";
    var d;
    for(d in e){
        a+=d+"="+e[d]+"&"
    }
    var c;
    if(a){
        c=((("http:"===document.location.protocol)?"http:":"https:")+"//"+NREUM.beacon+"/1/"+NREUM.licenseKey);
        c+="?a="+NREUM.applicationID+"&";
        c+=a;
        if(NREUM.transactionName!==null&&NREUM.transactionName.length>0){
            c+=(NREUM.txnParam+"="+encodeURIComponent(NREUM.transactionName));
            c+=("&v="+NREUM.version)
        }
        var b=new Image();
        b.src=c;
        NREUM.dprint("NREUM: (new) data sent",c)
    }
};

NREUM.inlineHit=function(c,b,a,d,f,e){
    NREUM.cycle+=1;
    if((NREUM.licenseKey===null)||(NREUM.applicationID===null)){
        NREUM.dprint("NREUM: licenseKey or applicationID has not been set");
        return
    }
    img=new Image();
    url=((("http:"===document.location.protocol)?"http:":"https:")+"//"+NREUM.beacon+"/1/"+NREUM.licenseKey);
    url+="?a="+NREUM.applicationID+"&";
    url+="t="+c+"&";
    url+="qt="+b+"&";
    url+="ap="+a+"&";
    url+="be="+d+"&";
    url+="dc="+f+"&";
    url+="fe="+e+"&";
    url+="c="+NREUM.cycle;
    img.src=url;
    NREUM.dprint("NREUM Inline: "+url)
};
    
NREUM.findStartTime=function(){
    var a=NREUM.findStartWebTiming()||NREUM.findStartGToolbar()||NREUM.findStartCookie();
    if(a){
        NREUM.mark("starttime",a)
    }else{
        NREUM.dprint("NREUM: Error: couldn't find a start time")
    }
};

NREUM.findStartWebTiming=function(){
    var a;
    var b=window.performance||window.mozPerformance||window.msPerformance||window.webkitPerformance;
    if("undefined"!==typeof(b)&&"undefined"!==typeof(b.timing)&&"undefined"!==typeof(b.timing.navigationStart)){
        a=b.timing.navigationStart;
        NREUM.dprint("NREUM.findStartWebTiming: startTime = "+a)
    }
    return a
};
    
NREUM.findStartGToolbar=function(){
    var a;
    if("undefined"!==typeof(window.external)&&"undefined"!==typeof(window.external.pageT)){
        a=(new Date().getTime())-window.external.pageT
    }else{
        if("undefined"!==typeof(window.gtbExternal)&&"undefined"!==typeof(window.gtbExternal.pageT)){
            a=(new Date().getTime())-window.gtbExternal.pageT()
        }else{
            if("undefined"!==typeof(window.chrome)&&"undefined"!==typeof(window.chrome.csi)){
                a=(new Date().getTime())-window.chrome.csi().pageT
            }
        }
    }
    if(a){
        NREUM.dprint("NREUM.findStartGToolbar: startTime = "+a)
    }
    return a
};

NREUM.findStartCookie=function(){
    var k=document.cookie.split(" ");
    var e,d;
    for(e=0;e<k.length;e++){
        if(0===k[e].indexOf("NREUM=")){
            var f,g;
            var c=k[e].substring("NREUM=".length).split("&");
            var b,a;
            for(d=0;d<c.length;d++){
                if(0===c[d].indexOf("s=")){
                    b=c[d].substring(2)
                }else{
                    if(0===c[d].indexOf("p=")){
                        g=c[d].substring(2);
                        if(g.charAt(g.length-1)===";"){
                            g=g.substr(0,g.length-1)
                        }
                    }else{
                        if(0===c[d].indexOf("r=")){
                            f=c[d].substring(2);
                            if(f.charAt(f.length-1)===";"){
                                f=f.substr(0,f.length-1)
                            }
                        }
                    }
                }
            }
            if(f){
                var h=encodeURIComponent(document.referrer);
                a=(h===f);
                if(!a){
                    a=encodeURIComponent(document.location)===f&&h===g
                }
            }
            if(a&&b){
                NREUM.dprint("NREUM.findStartCookie: startTime = "+b);
                return b
            }
        }
    }
    return undefined
};

NREUM.beforeUnload=function(a){
    if(!NREUM.unloaded){
        var b=new Date();
        b.setTime(b.getTime()+60000);
        document.cookie="NREUM=s="+Number(new Date())+"&r="+encodeURIComponent(document.location)+"&p="+encodeURIComponent(document.referrer)+"; expires="+b.toGMTString()+"; path=/";
        NREUM.unloaded=true
    }
};

NREUM.onload=function(a){
    NREUM.mark("onload");
    if(NREUM.autorun){
        NREUM.done()
    }
};

NREUM.domContentLoaded=function(a){
    if(!NREUM.contentLoadFired){
        NREUM.mark("domContent",new Date().getTime());
        NREUM.contentLoadFired=true
    }
};

NREUM.readyStateChange=function(a){
    if(document.readyState==="complete"){
        NREUM.domContentLoaded()
    }
};

NREUM.drawEpisodes=function(f,s){
    if(!f){
        return
    }
    if("undefined"===typeof(s)){
        s=1
    }
    var d=NREUM.getStarts();
    var h=NREUM.getMeasures();
    var l=NREUM.getMarks();
    var t=[];
    var e;
    var b;
    for(e in h){
        if(h.hasOwnProperty(e)){
            b=d[e];
            t.push([b,b+h[e],e])
        }
    }
    for(e in l){
        if(l.hasOwnProperty(e)){
            if("undefined"===typeof(h[e])){
                b=l[e];
                t.push([b,b,e])
            }
        }
    }
    t.sort(NREUM.sortEpisodes);
    var o=t[0][0];
    var c=t[0][1];
    var n=t.length;
    var m;
    for(m=1;m<n;m++){
        if(t[m][1]>c){
            c=t[m][1]
        }
    }
    var r=f.clientWidth||f.offsetWidth;
    var k=r/(c-o);
    var j="";
    for(m=0;m<t.length;m++){
        b=t[m][0];
        var a=t[m][1];
        var q=a-b;
        e=t[m][2];
        var g=parseInt(k*(b-o),10)+40;
        var p=parseInt(k*q,10);
        j+='<div style="font-size: 10pt; position: absolute; left: '+g+"px; top: "+(m*30)+"px; width: "+p+'px; height: 16px;"><div style="background: #EEE; border: 1px solid; padding-bottom: 2px;"><nobr style="padding-left: 4px;">'+e+(0<q?" - "+q+"ms":"")+"</nobr></div></div>\n"
    }
    f.innerHTML=j
};

NREUM.sortEpisodes=function(d,c){
    if(d[0]===c[0]){
        if(d[1]===c[1]){
            return 0
        }
        if(d[1]>c[1]){
            return -1
        }
        return 1
    }
    if(d[0]<c[0]){
        return -1
    }
    return 1
};
    
NREUM.addEventListener=function(c,b,a){
    if("undefined"!==typeof(window.attachEvent)){
        return window.attachEvent("on"+c,b)
    }else{
        if(window.addEventListener){
            return window.addEventListener(c,b,a)
        }
    }
};

if("undefined"!==typeof(console)&&"undefined"!==typeof(console.log)){
    NREUM.dprint=function(a){
        if(NREUM.logging){
            console.log(a)
        }
    }
}else{
    NREUM.dprint=function(a){}
}
NREUM.init();