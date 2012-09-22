(function(){
    var e=tinymce.each,r=tinymce.dom.Event,g;
    function p(t,s){
        while(t&&(t.nodeType===8||(t.nodeType===3&&/^[ \t\n\r]*$/.test(t.nodeValue)))){
            t=s(t)
        }
        return t
    }
    function b(s){
        return p(s,function(t){
            return t.previousSibling
        })
    }
    function i(s){
        return p(s,function(t){
            return t.nextSibling
        })
    }
    function d(s,u,t){
        return s.dom.getParent(u,function(v){
            return tinymce.inArray(t,v)!==-1
        })
    }
    function n(s){
        return s&&(s.tagName==="OL"||s.tagName==="UL")
    }
    function c(u,v){
        var t,w,s;
        t=b(u.lastChild);
        while(n(t)){
            w=t;
            t=b(w.previousSibling)
        }
        if(w){
            s=v.create("li",{
                style:"list-style-type: none;"
            });
            v.split(u,w);
            v.insertAfter(s,w);
            s.appendChild(w);
            s.appendChild(w);
            u=s.previousSibling
        }
        return u
    }
    function m(t,s,u){
        t=a(t,s,u);
        return o(t,s,u)
    }
    function a(u,s,v){
        var t=b(u.previousSibling);
        if(t){
            return h(t,u,s?t:false,v)
        }else{
            return u
        }
    }
    function o(u,t,v){
        var s=i(u.nextSibling);
        if(s){
            return h(u,s,t?s:false,v)
        }else{
            return u
        }
    }
    function h(u,s,t,v){
        if(l(u,s,!!t,v)){
            return f(u,s,t)
        }else{
            if(u&&u.tagName==="LI"&&n(s)){
                u.appendChild(s)
            }
        }
        return s
    }
    function l(u,t,s,v){
        if(!u||!t){
            return false
        }else{
            if(u.tagName==="LI"&&t.tagName==="LI"){
                return t.style.listStyleType==="none"||j(t)
            }else{
                if(n(u)){
                    return(u.tagName===t.tagName&&(s||u.style.listStyleType===t.style.listStyleType))||q(t)
                }else{
                    if(v&&u.tagName==="P"&&t.tagName==="P"){
                        return true
                    }else{
                        return false
                    }
                }
            }
        }
    }
    function q(t){
        var s=i(t.firstChild),u=b(t.lastChild);
        return s&&u&&n(t)&&s===u&&(n(s)||s.style.listStyleType==="none"||j(s))
    }
    function j(u){
        var t=i(u.firstChild),s=b(u.lastChild);
        return t&&s&&t===s&&n(t)
    }
    function f(w,v,s){
        var u=b(w.lastChild),t=i(v.firstChild);
        if(w.tagName==="P"){
            w.appendChild(w.ownerDocument.createElement("br"))
        }while(v.firstChild){
            w.appendChild(v.firstChild)
        }
        if(s){
            w.style.listStyleType=s.style.listStyleType
        }
        v.parentNode.removeChild(v);
        h(u,t,false);
        return w
    }
    function k(t,u){
        var s;
        if(!u.is(t,"li,ol,ul")){
            s=u.getParent(t,"li");
            if(s){
                t=s
            }
        }
        return t
    }
    tinymce.create("tinymce.plugins.Lists",{
        init:function(u,v){
            var s=false;
            function y(z){
                return z.keyCode===9&&(u.queryCommandState("InsertUnorderedList")||u.queryCommandState("InsertOrderedList"))
            }
            function w(z,B){
                var A=z.selection,C;
                if(B.keyCode===13){
                    C=A.getStart();
                    if(C.tagName=="BR"&&C.parentNode.tagName=="LI"){
                        C=C.parentNode
                    }
                    s=A.isCollapsed()&&C&&C.tagName==="LI"&&(C.childNodes.length===0||(C.firstChild.nodeName=="BR"&&C.childNodes.length===1));
                    return s
                }
            }
            function t(z,A){
                if(y(A)||w(z,A)){
                    return r.cancel(A)
                }
            }
            function x(C,E){
                if(!tinymce.isGecko){
                    return
                }
                var A=C.selection.getStart();
                if(E.keyCode!=8||A.tagName!=="IMG"){
                    return
                }
                function B(K){
                    var L=K.firstChild;
                    var J=null;
                    do{
                        if(!L){
                            break
                        }
                        if(L.tagName==="LI"){
                            J=L
                        }
                    }while(L=L.nextSibling);
                    return J
                }
                function I(K,J){
                    while(K.childNodes.length>0){
                        J.appendChild(K.childNodes[0])
                    }
                }
                var F;
                if(A.parentNode.previousSibling.tagName==="UL"||A.parentNode.previousSibling.tagName==="OL"){
                    F=A.parentNode.previousSibling
                }else{
                    if(A.parentNode.previousSibling.previousSibling.tagName==="UL"||A.parentNode.previousSibling.previousSibling.tagName==="OL"){
                        F=A.parentNode.previousSibling.previousSibling
                    }else{
                        return
                    }
                }
                var H=B(F);
                var z=C.dom.createRng();
                z.setStart(H,1);
                z.setEnd(H,1);
                C.selection.setRng(z);
                C.selection.collapse(true);
                var D=C.selection.getBookmark();
                var G=A.parentNode.cloneNode(true);
                if(G.tagName==="P"||G.tagName==="DIV"){
                    I(G,H)
                }else{
                    H.appendChild(G)
                }
                A.parentNode.parentNode.removeChild(A.parentNode);
                C.selection.moveToBookmark(D)
            }
            this.ed=u;
            u.addCommand("Indent",this.indent,this);
            u.addCommand("Outdent",this.outdent,this);
            u.addCommand("InsertUnorderedList",function(){
                this.applyList("UL","OL")
            },this);
            u.addCommand("InsertOrderedList",function(){
                this.applyList("OL","UL")
            },this);
            u.onInit.add(function(){
                u.editorCommands.addCommands({
                    outdent:function(){
                        var A=u.selection,B=u.dom;
                        function z(C){
                            C=B.getParent(C,B.isBlock);
                            return C&&(parseInt(u.dom.getStyle(C,"margin-left")||0,10)+parseInt(u.dom.getStyle(C,"padding-left")||0,10))>0
                        }
                        return z(A.getStart())||z(A.getEnd())||u.queryCommandState("InsertOrderedList")||u.queryCommandState("InsertUnorderedList")
                    }
                },"state")
            });
            u.onKeyUp.add(function(A,B){
                var C,z;
                if(y(B)){
                    A.execCommand(B.shiftKey?"Outdent":"Indent",true,null);
                    return r.cancel(B)
                }else{
                    if(s&&w(A,B)){
                        if(A.queryCommandState("InsertOrderedList")){
                            A.execCommand("InsertOrderedList")
                        }else{
                            A.execCommand("InsertUnorderedList")
                        }
                        C=A.selection.getStart();
                        if(C&&C.tagName==="LI"){
                            C=A.dom.getParent(C,"ol,ul").nextSibling;
                            if(C&&C.tagName==="P"){
                                if(!C.firstChild){
                                    C.appendChild(A.getDoc().createTextNode(""))
                                }
                                z=A.dom.createRng();
                                z.setStart(C.firstChild,1);
                                z.setEnd(C.firstChild,1);
                                A.selection.setRng(z)
                            }
                        }
                        return r.cancel(B)
                    }
                }
            });
            u.onKeyPress.add(t);
            u.onKeyDown.add(t);
            u.onKeyDown.add(x)
        },
        applyList:function(y,v){
            var C=this,z=C.ed,I=z.dom,s=[],H=false,u=false,w=false,B,G=z.selection.getSelectedBlocks();
            function E(t){
                if(t&&t.tagName==="BR"){
                    I.remove(t)
                }
            }
            function F(M){
                var N=I.create(y),t;
                function L(O){
                    if(O.style.marginLeft||O.style.paddingLeft){
                        C.adjustPaddingFunction(false)(O)
                    }
                }
                if(M.tagName==="LI"){}else{
                    if(M.tagName==="P"||M.tagName==="DIV"||M.tagName==="BODY"){
                        K(M,function(P,O,Q){
                            J(P,O,M.tagName==="BODY"?null:P.parentNode);
                            t=P.parentNode;
                            L(t);
                            E(O)
                        });
                        if(M.tagName==="P"||G.length>1){
                            I.split(t.parentNode.parentNode,t.parentNode)
                        }
                        m(t.parentNode,true);
                        return
                    }else{
                        t=I.create("li");
                        I.insertAfter(t,M);
                        t.appendChild(M);
                        L(M);
                        M=t
                    }
                }
                I.insertAfter(N,M);
                N.appendChild(M);
                m(N,true);
                s.push(M)
            }
            function J(Q,L,O){
                var t,P=Q,N,M;
                while(!I.isBlock(Q.parentNode)&&Q.parentNode!==I.getRoot()){
                    Q=I.split(Q.parentNode,Q.previousSibling);
                    Q=Q.nextSibling;
                    P=Q
                }
                if(O){
                    t=O.cloneNode(true);
                    Q.parentNode.insertBefore(t,Q);
                    while(t.firstChild){
                        I.remove(t.firstChild)
                    }
                    t=I.rename(t,"li")
                }else{
                    t=I.create("li");
                    Q.parentNode.insertBefore(t,Q)
                }while(P&&P!=L){
                    N=P.nextSibling;
                    t.appendChild(P);
                    P=N
                }
                if(t.childNodes.length===0){
                    t.innerHTML='<br _mce_bogus="1" />'
                }
                F(t)
            }
            function K(Q,T){
                var N,R,O=3,L=1,t="br,ul,ol,p,div,h1,h2,h3,h4,h5,h6,table,blockquote,address,pre,form,center,dl";
                function P(X,U){
                    var V=I.createRng(),W;
                    g.keep=true;
                    z.selection.moveToBookmark(g);
                    g.keep=false;
                    W=z.selection.getRng(true);
                    if(!U){
                        U=X.parentNode.lastChild
                    }
                    V.setStartBefore(X);
                    V.setEndAfter(U);
                    return !(V.compareBoundaryPoints(O,W)>0||V.compareBoundaryPoints(L,W)<=0)
                }
                function S(U){
                    if(U.nextSibling){
                        return U.nextSibling
                    }
                    if(!I.isBlock(U.parentNode)&&U.parentNode!==I.getRoot()){
                        return S(U.parentNode)
                    }
                }
                N=Q.firstChild;
                var M=false;
                e(I.select(t,Q),function(V){
                    var U;
                    if(V.hasAttribute&&V.hasAttribute("_mce_bogus")){
                        return true
                    }
                    if(P(N,V)){
                        I.addClass(V,"_mce_tagged_br");
                        N=S(V)
                    }
                });
                M=(N&&P(N,undefined));
                N=Q.firstChild;
                e(I.select(t,Q),function(V){
                    var U=S(V);
                    if(V.hasAttribute&&V.hasAttribute("_mce_bogus")){
                        return true
                    }
                    if(I.hasClass(V,"_mce_tagged_br")){
                        T(N,V,R);
                        R=null
                    }else{
                        R=V
                    }
                    N=U
                });
                if(M){
                    T(N,undefined,R)
                }
            }
            function D(t){
                K(t,function(M,L,N){
                    J(M,L);
                    E(L);
                    E(N)
                })
            }
            function A(t){
                if(tinymce.inArray(s,t)!==-1){
                    return
                }
                if(t.parentNode.tagName===v){
                    I.split(t.parentNode,t);
                    F(t);
                    o(t.parentNode,false)
                }
                s.push(t)
            }
            function x(M){
                var O,N,L,t;
                if(tinymce.inArray(s,M)!==-1){
                    return
                }
                M=c(M,I);
                while(I.is(M.parentNode,"ol,ul,li")){
                    I.split(M.parentNode,M)
                }
                s.push(M);
                M=I.rename(M,"p");
                L=m(M,false,z.settings.force_br_newlines);
                if(L===M){
                    O=M.firstChild;
                    while(O){
                        if(I.isBlock(O)){
                            O=I.split(O.parentNode,O);
                            t=true;
                            N=O.nextSibling&&O.nextSibling.firstChild
                        }else{
                            N=O.nextSibling;
                            if(t&&O.tagName==="BR"){
                                I.remove(O)
                            }
                            t=false
                        }
                        O=N
                    }
                }
            }
            e(G,function(t){
                t=k(t,I);
                if(t.tagName===v||(t.tagName==="LI"&&t.parentNode.tagName===v)){
                    u=true
                }else{
                    if(t.tagName===y||(t.tagName==="LI"&&t.parentNode.tagName===y)){
                        H=true
                    }else{
                        w=true
                    }
                }
            });
            if(w||u||G.length===0){
                B={
                    LI:A,
                    H1:F,
                    H2:F,
                    H3:F,
                    H4:F,
                    H5:F,
                    H6:F,
                    P:F,
                    BODY:F,
                    DIV:G.length>1?F:D,
                    defaultAction:D
                }
            }else{
                B={
                    defaultAction:x
                }
            }
            this.process(B)
        },
        indent:function(){
            var u=this.ed,w=u.dom,x=[];
            function s(z){
                var y=w.create("li",{
                    style:"list-style-type: none;"
                });
                w.insertAfter(y,z);
                return y
            }
            function t(B){
                var y=s(B),D=w.getParent(B,"ol,ul"),C=D.tagName,E=w.getStyle(D,"list-style-type"),A={},z;
                if(E!==""){
                    A.style="list-style-type: "+E+";"
                }
                z=w.create(C,A);
                y.appendChild(z);
                return z
            }
            function v(z){
                if(!d(u,z,x)){
                    z=c(z,w);
                    var y=t(z);
                    y.appendChild(z);
                    m(y.parentNode,false);
                    m(y,false);
                    x.push(z)
                }
            }
            this.process({
                LI:v,
                defaultAction:this.adjustPaddingFunction(true)
            })
        },
        outdent:function(){
            var v=this,u=v.ed,w=u.dom,s=[];
            function x(t){
                var z,y,A;
                if(!d(u,t,s)){
                    if(w.getStyle(t,"margin-left")!==""||w.getStyle(t,"padding-left")!==""){
                        return v.adjustPaddingFunction(false)(t)
                    }
                    A=w.getStyle(t,"text-align",true);
                    if(A==="center"||A==="right"){
                        w.setStyle(t,"text-align","left");
                        return
                    }
                    t=c(t,w);
                    z=t.parentNode;
                    y=t.parentNode.parentNode;
                    if(y.tagName==="P"){
                        w.split(y,t.parentNode)
                    }else{
                        w.split(z,t);
                        if(y.tagName==="LI"){
                            w.split(y,t)
                        }else{
                            if(!w.is(y,"ol,ul")){
                                w.rename(t,"p")
                            }
                        }
                    }
                    s.push(t)
                }
            }
            this.process({
                LI:x,
                defaultAction:this.adjustPaddingFunction(false)
            });
            e(s,m)
        },
        process:function(x){
            var B=this,v=B.ed.selection,y=B.ed.dom,A,s;
            function w(t){
                y.removeClass(t,"_mce_act_on");
                if(!t||t.nodeType!==1){
                    return
                }
                t=k(t,y);
                var C=x[t.tagName];
                if(!C){
                    C=x.defaultAction
                }
                C(t)
            }
            function u(t){
                B.splitSafeEach(t.childNodes,w)
            }
            function z(t,C){
                return C>=0&&t.hasChildNodes()&&C<t.childNodes.length&&t.childNodes[C].tagName==="BR"
            }
            A=v.getSelectedBlocks();
            if(A.length===0){
                A=[y.getRoot()]
            }
            s=v.getRng(true);
            if(!s.collapsed){
                if(z(s.endContainer,s.endOffset-1)){
                    s.setEnd(s.endContainer,s.endOffset-1);
                    v.setRng(s)
                }
                if(z(s.startContainer,s.startOffset)){
                    s.setStart(s.startContainer,s.startOffset+1);
                    v.setRng(s)
                }
            }
            g=v.getBookmark();
            x.OL=x.UL=u;
            B.splitSafeEach(A,w);
            v.moveToBookmark(g);
            g=null;
            B.ed.execCommand("mceRepaint")
        },
        splitSafeEach:function(t,s){
            if(tinymce.isGecko&&(/Firefox\/[12]\.[0-9]/.test(navigator.userAgent)||/Firefox\/3\.[0-4]/.test(navigator.userAgent))){
                this.classBasedEach(t,s)
            }else{
                e(t,s)
            }
        },
        classBasedEach:function(v,u){
            var w=this.ed.dom,s,t;
            e(v,function(x){
                w.addClass(x,"_mce_act_on")
            });
            s=w.select("._mce_act_on");
            while(s.length>0){
                t=s.shift();
                w.removeClass(t,"_mce_act_on");
                u(t);
                s=w.select("._mce_act_on")
            }
        },
        adjustPaddingFunction:function(u){
            var s,v,t=this.ed;
            s=t.settings.indentation;
            v=/[a-z%]+/i.exec(s);
            s=parseInt(s,10);
            return function(w){
                var y,x;
                y=parseInt(t.dom.getStyle(w,"margin-left")||0,10)+parseInt(t.dom.getStyle(w,"padding-left")||0,10);
                if(u){
                    x=y+s
                }else{
                    x=y-s
                }
                t.dom.setStyle(w,"padding-left","");
                t.dom.setStyle(w,"margin-left",x>0?x+v:"")
            }
        },
        getInfo:function(){
            return{
                longname:"Lists",
                author:"Moxiecode Systems AB",
                authorurl:"http://tinymce.moxiecode.com",
                infourl:"http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/lists",
                version:tinymce.majorVersion+"."+tinymce.minorVersion
            }
        }
    });
    tinymce.PluginManager.add("lists",tinymce.plugins.Lists)
}());