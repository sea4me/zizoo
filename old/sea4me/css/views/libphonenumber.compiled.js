var COMPILED=true,goog=goog||{};

goog.global=this;
goog.DEBUG=true;
goog.LOCALE="en";
goog.evalWorksForGlobals_=null;
goog.provide=function(a){
    if(!COMPILED){
        if(goog.getObjectByName(a)&&!goog.implicitNamespaces_[a])throw Error('Namespace "'+a+'" already declared.');
        for(var b=a;b=b.substring(0,b.lastIndexOf("."));)goog.implicitNamespaces_[b]=true
    }
    goog.exportPath_(a)
};
goog.setTestOnly=function(a){
    if(COMPILED&&!goog.DEBUG){
        a=a||"";
        throw Error("Importing test-only code into non-debug environment"+a?": "+a:".");
    }
};

if(!COMPILED)goog.implicitNamespaces_={};
    
goog.exportPath_=function(a,b,c){
    a=a.split(".");
    c=c||goog.global;
    !(a[0]in c)&&c.execScript&&c.execScript("var "+a[0]);
    for(var d;a.length&&(d=a.shift());)if(!a.length&&goog.isDef(b))c[d]=b;else c=c[d]?c[d]:c[d]={}
};
goog.getObjectByName=function(a,b){
    for(var c=a.split("."),d=b||goog.global,e;e=c.shift();)if(goog.isDefAndNotNull(d[e]))d=d[e];else return null;return d
};
    
goog.globalize=function(a,b){
    var c=b||goog.global,d;
    for(d in a)c[d]=a[d]
};
goog.addDependency=function(a,b,c){
    if(!COMPILED){
        var d;
        a=a.replace(/\\/g,"/");
        for(var e=goog.dependencies_,f=0;d=b[f];f++){
            e.nameToPath[d]=a;
            a in e.pathToNames||(e.pathToNames[a]={});
            e.pathToNames[a][d]=true
        }
        for(d=0;b=c[d];d++){
            a in e.requires||(e.requires[a]={});
            e.requires[a][b]=true
        }
    }
};
goog.require=function(a){
    if(!COMPILED)if(!goog.getObjectByName(a)){
        var b=goog.getPathFromDeps_(a);
        if(b){
            goog.included_[b]=true;
            goog.writeScripts_()
        }else{
            a="goog.require could not find: "+a;
            goog.global.console&&goog.global.console.error(a);
            throw Error(a);
        }
    }
};

goog.basePath="";
goog.nullFunction=function(){};
    
goog.identityFunction=function(a){
    return a
};
    
goog.abstractMethod=function(){
    throw Error("unimplemented abstract method");
};
goog.addSingletonGetter=function(a){
    a.getInstance=function(){
        return a.instance_||(a.instance_=new a)
    }
};
if(!COMPILED){
    goog.included_={};
        
    goog.dependencies_={
        pathToNames:{},
        nameToPath:{},
        requires:{},
        visited:{},
        written:{}
    };
    
    goog.inHtmlDocument_=function(){
        var a=goog.global.document;
        return typeof a!="undefined"&&"write"in a
    };
    
    goog.findBasePath_=function(){
        if(goog.global.CLOSURE_BASE_PATH)goog.basePath=goog.global.CLOSURE_BASE_PATH;
        else if(goog.inHtmlDocument_())for(var a=goog.global.document.getElementsByTagName("script"),b=a.length-1;b>=0;--b){
            var c=a[b].src,d=c.lastIndexOf("?");
            d=d==-1?c.length:d;
            if(c.substr(d-
                7,7)=="base.js"){
                goog.basePath=c.substr(0,d-7);
                break
            }
        }
    };
    
    goog.importScript_=function(a){
        var b=goog.global.CLOSURE_IMPORT_SCRIPT||goog.writeScriptTag_;
        if(!goog.dependencies_.written[a]&&b(a))goog.dependencies_.written[a]=true
    };
        
    goog.writeScriptTag_=function(a){
        if(goog.inHtmlDocument_()){
            goog.global.document.write('<script type="text/javascript" src="'+a+'"><\/script>');
            return true
        }else return false
    };
        
    goog.writeScripts_=function(){
        function a(f){
            if(!(f in d.written)){
                if(!(f in d.visited)){
                    d.visited[f]=
                    true;
                    if(f in d.requires)for(var g in d.requires[f])if(g in d.nameToPath)a(d.nameToPath[g]);
                        else if(!goog.getObjectByName(g))throw Error("Undefined nameToPath for "+g);
                }
                if(!(f in c)){
                    c[f]=true;
                    b.push(f)
                }
            }
        }
        var b=[],c={},d=goog.dependencies_,e;
        for(e in goog.included_)d.written[e]||a(e);for(e=0;e<b.length;e++)if(b[e])goog.importScript_(goog.basePath+b[e]);else throw Error("Undefined script input");
    };

    goog.getPathFromDeps_=function(a){
        return a in goog.dependencies_.nameToPath?goog.dependencies_.nameToPath[a]:
        null
    };
    
    goog.findBasePath_();
    goog.global.CLOSURE_NO_DEPS||goog.importScript_(goog.basePath+"deps.js")
}
goog.typeOf=function(a){
    var b=typeof a;
    if(b=="object")if(a){
        if(a instanceof Array)return"array";
        else if(a instanceof Object)return b;
        var c=Object.prototype.toString.call(a);
        if(c=="[object Window]")return"object";
        if(c=="[object Array]"||typeof a.length=="number"&&typeof a.splice!="undefined"&&typeof a.propertyIsEnumerable!="undefined"&&!a.propertyIsEnumerable("splice"))return"array";
        if(c=="[object Function]"||typeof a.call!="undefined"&&typeof a.propertyIsEnumerable!="undefined"&&!a.propertyIsEnumerable("call"))return"function"
    }else return"null";
    else if(b=="function"&&typeof a.call=="undefined")return"object";
    return b
};
    
goog.propertyIsEnumerableCustom_=function(a,b){
    if(b in a)for(var c in a)if(c==b&&Object.prototype.hasOwnProperty.call(a,b))return true;return false
};
    
goog.propertyIsEnumerable_=function(a,b){
    return a instanceof Object?Object.prototype.propertyIsEnumerable.call(a,b):goog.propertyIsEnumerableCustom_(a,b)
};
    
goog.isDef=function(a){
    return a!==undefined
};
    
goog.isNull=function(a){
    return a===null
};
goog.isDefAndNotNull=function(a){
    return a!=null
};
    
goog.isArray=function(a){
    return goog.typeOf(a)=="array"
};
    
goog.isArrayLike=function(a){
    var b=goog.typeOf(a);
    return b=="array"||b=="object"&&typeof a.length=="number"
};
    
goog.isDateLike=function(a){
    return goog.isObject(a)&&typeof a.getFullYear=="function"
};
    
goog.isString=function(a){
    return typeof a=="string"
};
    
goog.isBoolean=function(a){
    return typeof a=="boolean"
};
    
goog.isNumber=function(a){
    return typeof a=="number"
};
goog.isFunction=function(a){
    return goog.typeOf(a)=="function"
};
    
goog.isObject=function(a){
    a=goog.typeOf(a);
    return a=="object"||a=="array"||a=="function"
};
    
goog.getUid=function(a){
    return a[goog.UID_PROPERTY_]||(a[goog.UID_PROPERTY_]=++goog.uidCounter_)
};
    
goog.removeUid=function(a){
    "removeAttribute"in a&&a.removeAttribute(goog.UID_PROPERTY_);
    try{
        delete a[goog.UID_PROPERTY_]
    }catch(b){}
};

goog.UID_PROPERTY_="closure_uid_"+Math.floor(Math.random()*2147483648).toString(36);
goog.uidCounter_=0;
goog.getHashCode=goog.getUid;
goog.removeHashCode=goog.removeUid;
goog.cloneObject=function(a){
    var b=goog.typeOf(a);
    if(b=="object"||b=="array"){
        if(a.clone)return a.clone();
        b=b=="array"?[]:{};
        
        for(var c in a)b[c]=goog.cloneObject(a[c]);return b
    }
    return a
};
    
goog.bindNative_=function(a){
    return a.call.apply(a.bind,arguments)
};
goog.bindJs_=function(a,b){
    var c=b||goog.global;
    if(arguments.length>2){
        var d=Array.prototype.slice.call(arguments,2);
        return function(){
            var e=Array.prototype.slice.call(arguments);
            Array.prototype.unshift.apply(e,d);
            return a.apply(c,e)
        }
    }else return function(){
        return a.apply(c,arguments)
    }
};

goog.bind=function(){
    goog.bind=Function.prototype.bind&&Function.prototype.bind.toString().indexOf("native code")!=-1?goog.bindNative_:goog.bindJs_;
    return goog.bind.apply(null,arguments)
};
goog.partial=function(a){
    var b=Array.prototype.slice.call(arguments,1);
    return function(){
        var c=Array.prototype.slice.call(arguments);
        c.unshift.apply(c,b);
        return a.apply(this,c)
    }
};

goog.mixin=function(a,b){
    for(var c in b)a[c]=b[c]
};
        
goog.now=Date.now||function(){
    return+new Date
};
goog.globalEval=function(a){
    if(goog.global.execScript)goog.global.execScript(a,"JavaScript");
    else if(goog.global.eval){
        if(goog.evalWorksForGlobals_==null){
            goog.global.eval("var _et_ = 1;");
            if(typeof goog.global._et_!="undefined"){
                delete goog.global._et_;
                goog.evalWorksForGlobals_=true
            }else goog.evalWorksForGlobals_=false
        }
        if(goog.evalWorksForGlobals_)goog.global.eval(a);
        else{
            var b=goog.global.document,c=b.createElement("script");
            c.type="text/javascript";
            c.defer=false;
            c.appendChild(b.createTextNode(a));
            b.body.appendChild(c);
            b.body.removeChild(c)
        }
    }else throw Error("goog.globalEval not available");
};

goog.typedef=true;
goog.getCssName=function(a,b){
    var c;
    c=goog.cssNameMapping_?goog.cssNameMappingStyle_=="BY_WHOLE"?function(d){
        return goog.cssNameMapping_[d]||d
    }:function(d){
        for(var e=d.split("-"),f=[],g=0;g<e.length;g++){
            var h=goog.cssNameMapping_[e[g]];
            if(!h)return d;
            f.push(h)
        }
        return f.join("-")
    }:function(d){
        return d
    };
        
    return b?a+"-"+c(b):c(a)
};
goog.setCssNameMapping=function(a,b){
    goog.cssNameMapping_=a;
    goog.cssNameMappingStyle_=b
};
    
goog.getMsg=function(a,b){
    var c=b||{},d;
    for(d in c){
        var e=(""+c[d]).replace(/\$/g,"$$$$");
        a=a.replace(RegExp("\\{\\$"+d+"\\}","gi"),e)
    }
    return a
};
    
goog.exportSymbol=function(a,b,c){
    goog.exportPath_(a,b,c)
};
    
goog.exportProperty=function(a,b,c){
    a[b]=c
};
    
goog.inherits=function(a,b){
    function c(){}
    c.prototype=b.prototype;
    a.superClass_=b.prototype;
    a.prototype=new c;
    a.prototype.constructor=a
};
goog.base=function(a,b){
    var c=arguments.callee.caller;
    if(c.superClass_)return c.superClass_.constructor.apply(a,Array.prototype.slice.call(arguments,1));
    for(var d=Array.prototype.slice.call(arguments,2),e=false,f=a.constructor;f;f=f.superClass_&&f.superClass_.constructor)if(f.prototype[b]===c)e=true;
        else if(e)return f.prototype[b].apply(a,d);if(a[b]===c)return a.constructor.prototype[b].apply(a,d);else throw Error("goog.base called from a method of one name to a method of a different name");
};
goog.scope=function(a){
    a.call(goog.global)
};
    
goog.debug={};
    
goog.debug.Error=function(a){
    this.stack=Error().stack||"";
    if(a)this.message=String(a)
};
        
goog.inherits(goog.debug.Error,Error);
goog.debug.Error.prototype.name="CustomError";
goog.string={};
    
goog.string.Unicode={
    NBSP:"\u00a0"
};

goog.string.startsWith=function(a,b){
    return a.lastIndexOf(b,0)==0
};
    
goog.string.endsWith=function(a,b){
    var c=a.length-b.length;
    return c>=0&&a.indexOf(b,c)==c
};
    
goog.string.caseInsensitiveStartsWith=function(a,b){
    return goog.string.caseInsensitiveCompare(b,a.substr(0,b.length))==0
};
    
goog.string.caseInsensitiveEndsWith=function(a,b){
    return goog.string.caseInsensitiveCompare(b,a.substr(a.length-b.length,b.length))==0
};
goog.string.subs=function(a){
    for(var b=1;b<arguments.length;b++){
        var c=String(arguments[b]).replace(/\$/g,"$$$$");
        a=a.replace(/\%s/,c)
    }
    return a
};
    
goog.string.collapseWhitespace=function(a){
    return a.replace(/[\s\xa0]+/g," ").replace(/^\s+|\s+$/g,"")
};
    
goog.string.isEmpty=function(a){
    return/^[\s\xa0]*$/.test(a)
};
    
goog.string.isEmptySafe=function(a){
    return goog.string.isEmpty(goog.string.makeSafe(a))
};
    
goog.string.isBreakingWhitespace=function(a){
    return!/[^\t\n\r ]/.test(a)
};
    
goog.string.isAlpha=function(a){
    return!/[^a-zA-Z]/.test(a)
};
goog.string.isNum