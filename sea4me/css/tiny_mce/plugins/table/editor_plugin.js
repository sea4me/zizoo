(function(c){
    var d=c.each;
    function b(f,g){
        var h=g.ownerDocument,e=h.createRange(),j;
        e.setStartBefore(g);
        e.setEnd(f.endContainer,f.endOffset);
        j=h.createElement("body");
        j.appendChild(e.cloneContents());
        return j.innerHTML.replace(/<(br|img|object|embed|input|textarea)[^>]*>/gi,"-").replace(/<[^>]+>/g,"").length==0
    }
    function a(H,G,K){
        var f,L,D,o;
        t();
        o=G.getParent(K.getStart(),"th,td");
        if(o){
            L=F(o);
            D=I();
            o=z(L.x,L.y)
        }
        function A(N,M){
            N=N.cloneNode(M);
            N.removeAttribute("id");
            return N
        }
        function t(){
            var M=0;
            f=[];
            d(["thead","tbody","tfoot"],function(N){
                var O=G.select("> "+N+" tr",H);
                d(O,function(P,Q){
                    Q+=M;
                    d(G.select("> td, > th",P),function(W,R){
                        var S,T,U,V;
                        if(f[Q]){
                            while(f[Q][R]){
                                R++
                            }
                        }
                        U=h(W,"rowspan");
                        V=h(W,"colspan");
                        for(T=Q;T<Q+U;T++){
                            if(!f[T]){
                                f[T]=[]
                            }
                            for(S=R;S<R+V;S++){
                                f[T][S]={
                                    part:N,
                                    real:T==Q&&S==R,
                                    elm:W,
                                    rowspan:U,
                                    colspan:V
                                }
                            }
                        }
                    })
                });
                M+=O.length
            })
        }
        function z(M,O){
            var N;
            N=f[O];
            if(N){
                return N[M]
            }
        }
        function h(N,M){
            return parseInt(N.getAttribute(M)||1)
        }
        function s(O,M,N){
            if(O){
                N=parseInt(N);
                if(N===1){
                    O.removeAttribute(M,1)
                }else{
                    O.setAttribute(M,N,1)
                }
            }
        }
        function j(M){
            return M&&(G.hasClass(M.elm,"mceSelected")||M==o)
        }
        function k(){
            var M=[];
            d(H.rows,function(N){
                d(N.cells,function(O){
                    if(G.hasClass(O,"mceSelected")||O==o.elm){
                        M.push(N);
                        return false
                    }
                })
            });
            return M
        }
        function r(){
            var M=G.createRng();
            M.setStartAfter(H);
            M.setEndAfter(H);
            K.setRng(M);
            G.remove(H)
        }
        function e(M){
            var N;
            c.walk(M,function(P){
                var O;
                if(P.nodeType==3){
                    d(G.getParents(P.parentNode,null,M).reverse(),function(Q){
                        Q=A(Q,false);
                        if(!N){
                            N=O=Q
                        }else{
                            if(O){
                                O.appendChild(Q)
                            }
                        }
                        O=Q
                    });
                    if(O){
                        O.innerHTML=c.isIE?"&nbsp;":'<br data-mce-bogus="1" />'
                    }
                    return false
                }
            },"childNodes");
            M=A(M,false);
            s(M,"rowSpan",1);
            s(M,"colSpan",1);
            if(N){
                M.appendChild(N)
            }else{
                if(!c.isIE){
                    M.innerHTML='<br data-mce-bogus="1" />'
                }
            }
            return M
        }
        function q(){
            var M=G.createRng();
            d(G.select("tr",H),function(N){
                if(N.cells.length==0){
                    G.remove(N)
                }
            });
            if(G.select("tr",H).length==0){
                M.setStartAfter(H);
                M.setEndAfter(H);
                K.setRng(M);
                G.remove(H);
                return
            }
            d(G.select("thead,tbody,tfoot",H),function(N){
                if(N.rows.length==0){
                    G.remove(N)
                }
            });
            t();
            row=f[Math.min(f.length-1,L.y)];
            if(row){
                K.select(row[Math.min(row.length-1,L.x)].elm,true);
                K.collapse(true)
            }
        }
        function u(S,Q,U,R){
            var P,N,M,O,T;
            P=f[Q][S].elm.parentNode;
            for(M=1;M<=U;M++){
                P=G.getNext(P,"tr");
                if(P){
                    for(N=S;N>=0;N--){
                        T=f[Q+M][N].elm;
                        if(T.parentNode==P){
                            for(O=1;O<=R;O++){
                                G.insertAfter(e(T),T)
                            }
                            break
                        }
                    }
                    if(N==-1){
                        for(O=1;O<=R;O++){
                            P.insertBefore(e(P.cells[0]),P.cells[0])
                        }
                    }
                }
            }
        }
        function C(){
            d(f,function(M,N){
                d(M,function(P,O){
                    var S,R,T,Q;
                    if(j(P)){
                        P=P.elm;
                        S=h(P,"colspan");
                        R=h(P,"rowspan");
                        if(S>1||R>1){
                            s(P,"rowSpan",1);
                            s(P,"colSpan",1);
                            for(Q=0;Q<S-1;Q++){
                                G.insertAfter(e(P),P)
                            }
                            u(O,N,R-1,S)
                        }
                    }
                })
            })
        }
        function p(V,S,Y){
            var P,O,X,W,U,R,T,M,V,N,Q;
            if(V){
                pos=F(V);
                P=pos.x;
                O=pos.y;
                X=P+(S-1);
                W=O+(Y-1)
            }else{
                P=L.x;
                O=L.y;
                X=D.x;
                W=D.y
            }
            T=z(P,O);
            M=z(X,W);
            if(T&&M&&T.part==M.part){
                C();
                t();
                T=z(P,O).elm;
                s(T,"colSpan",(X-P)+1);
                s(T,"rowSpan",(W-O)+1);
                for(R=O;R<=W;R++){
                    for(U=P;U<=X;U++){
                        if(!f[R]||!f[R][U]){
                            continue
                        }
                        V=f[R][U].elm;
                        if(V!=T){
                            N=c.grep(V.childNodes);
                            d(N,function(Z){
                                T.appendChild(Z)
                            });
                            if(N.length){
                                N=c.grep(T.childNodes);
                                Q=0;
                                d(N,function(Z){
                                    if(Z.nodeName=="BR"&&G.getAttrib(Z,"data-mce-bogus")&&Q++<N.length-1){
                                        T.removeChild(Z)
                                    }
                                })
                            }
                            G.remove(V)
                        }
                    }
                }
                q()
            }
        }
        function l(Q){
            var M,S,P,R,T,U,N,V,O;
            d(f,function(W,X){
                d(W,function(Z,Y){
                    if(j(Z)){
                        Z=Z.elm;
                        T=Z.parentNode;
                        U=A(T,false);
                        M=X;
                        if(Q){
                            return false
                        }
                    }
                });
                if(Q){
                    return !M
                }
            });
            for(R=0;R<f[0].length;R++){
                if(!f[M][R]){
                    continue
                }
                S=f[M][R].elm;
                if(S!=P){
                    if(!Q){
                        O=h(S,"rowspan");
                        if(O>1){
                            s(S,"rowSpan",O+1);
                            continue
                        }
                    }else{
                        if(M>0&&f[M-1][R]){
                            V=f[M-1][R].elm;
                            O=h(V,"rowSpan");
                            if(O>1){
                                s(V,"rowSpan",O+1);
                                continue
                            }
                        }
                    }
                    N=e(S);
                    s(N,"colSpan",S.colSpan);
                    U.appendChild(N);
                    P=S
                }
            }
            if(U.hasChildNodes()){
                if(!Q){
                    G.insertAfter(U,T)
                }else{
                    T.parentNode.insertBefore(U,T)
                }
            }
        }
        function g(N){
            var O,M;
            d(f,function(P,Q){
                d(P,function(S,R){
                    if(j(S)){
                        O=R;
                        if(N){
                            return false
                        }
                    }
                });
                if(N){
                    return !O
                }
            });
            d(f,function(S,T){
                var P,Q,R;
                if(!S[O]){
                    return
                }
                P=S[O].elm;
                if(P!=M){
                    R=h(P,"colspan");
                    Q=h(P,"rowspan");
                    if(R==1){
                        if(!N){
                            G.insertAfter(e(P),P);
                            u(O,T,Q-1,R)
                        }else{
                            P.parentNode.insertBefore(e(P),P);
                            u(O,T,Q-1,R)
                        }
                    }else{
                        s(P,"colSpan",P.colSpan+1)
                    }
                    M=P
                }
            })
        }
        function n(){
            var M=[];
            d(f,function(N,O){
                d(N,function(Q,P){
                    if(j(Q)&&c.inArray(M,P)===-1){
                        d(f,function(T){
                            var R=T[P].elm,S;
                            S=h(R,"colSpan");
                            if(S>1){
                                s(R,"colSpan",S-1)
                            }else{
                                G.remove(R)
                            }
                        });
                        M.push(P)
                    }
                })
            });
            q()
        }
        function m(){
            var N;
            function M(Q){
                var P,R,O;
                P=G.getNext(Q,"tr");
                d(Q.cells,function(S){
                    var T=h(S,"rowSpan");
                    if(T>1){
                        s(S,"rowSpan",T-1);
                        R=F(S);
                        u(R.x,R.y,1,1)
                    }
                });
                R=F(Q.cells[0]);
                d(f[R.y],function(S){
                    var T;
                    S=S.elm;
                    if(S!=O){
                        T=h(S,"rowSpan");
                        if(T<=1){
                            G.remove(S)
                        }else{
                            s(S,"rowSpan",T-1)
                        }
                        O=S
                    }
                })
            }
            N=k();
            d(N.reverse(),function(O){
                M(O)
            });
            q()
        }
        function E(){
            var M=k();
            G.remove(M);
            q();
            return M
        }
        function J(){
            var M=k();
            d(M,function(O,N){
                M[N]=A(O,true)
            });
            return M
        }
        function B(O,N){
            var P=k(),M=P[N?0:P.length-1],Q=M.cells.length;
            d(f,function(S){
                var R;
                Q=0;
                d(S,function(U,T){
                    if(U.real){
                        Q+=U.colspan
                    }
                    if(U.elm.parentNode==M){
                        R=1
                    }
                });
                if(R){
                    return false
                }
            });
            if(!N){
                O.reverse()
            }
            d(O,function(T){
                var S=T.cells.length,R;
                for(i=0;i<S;i++){
                    R=T.cells[i];
                    s(R,"colSpan",1);
                    s(R,"rowSpan",1)
                }
                for(i=S;i<Q;i++){
                    T.appendChild(e(T.cells[S-1]))
                }
                for(i=Q;i<S;i++){
                    G.remove(T.cells[i])
                }
                if(N){
                    M.parentNode.insertBefore(T,M)
                }else{
                    G.insertAfter(T,M)
                }
            })
        }
        function F(M){
            var N;
            d(f,function(O,P){
                d(O,function(R,Q){
                    if(R.elm==M){
                        N={
                            x:Q,
                            y:P
                        };
                
                        return false
                    }
                });
                return !N
            });
            return N
        }
        function w(M){
            L=F(M)
        }
        function I(){
            var O,N,M;
            N=M=0;
            d(f,function(P,Q){
                d(P,function(S,R){
                    var U,T;
                    if(j(S)){
                        S=f[Q][R];
                        if(R>N){
                            N=R
                        }
                        if(Q>M){
                            M=Q
                        }
                        if(S.real){
                            U=S.colspan-1;
                            T=S.rowspan-1;
                            if(U){
                                if(R+U>N){
                                    N=R+U
                                }
                            }
                            if(T){
                                if(Q+T>M){
                                    M=Q+T
                                }
                            }
                        }
                    }
                })
            });
            return{
                x:N,
                y:M
            }
        }
        function v(S){
            var P,O,U,T,N,M,Q,R;
            D=F(S);
            if(L&&D){
                P=Math.min(L.x,D.x);
                O=Math.min(L.y,D.y);
                U=Math.max(L.x,D.x);
                T=Math.max(L.y,D.y);
                N=U;
                M=T;
                for(y=O;y<=M;y++){
                    S=f[y][P];
                    if(!S.real){
                        if(P-(S.colspan-1)<P){
                            P-=S.colspan-1
                        }
                    }
                }
                for(x=P;x<=N;x++){
                    S=f[O][x];
                    if(!S.real){
                        if(O-(S.rowspan-1)<O){
                            O-=S.rowspan-1
                        }
                    }
                }
                for(y=O;y<=T;y++){
                    for(x=P;x<=U;x++){
                        S=f[y][x];
                        if(S.real){
                            Q=S.colspan-1;
                            R=S.rowspan-1;
                            if(Q){
                                if(x+Q>N){
                                    N=x+Q
                                }
                            }
                            if(R){
                                if(y+R>M){
                                    M=y+R
                                }
                            }
                        }
                    }
                }
                G.removeClass(G.select("td.mceSelected,th.mceSelected"),"mceSelected");
                for(y=O;y<=M;y++){
                    for(x=P;x<=N;x++){
                        if(f[y][x]){
                            G.addClass(f[y][x].elm,"mceSelected")
                        }
                    }
                }
            }
        }
        c.extend(this,{
            deleteTable:r,
            split:C,
            merge:p,
            insertRow:l,
            insertCol:g,
            deleteCols:n,
            deleteRows:m,
            cutRows:E,
            copyRows:J,
            pasteRows:B,
            getPos:F,
            setStartCell:w,
            setEndCell:v
        })
    }
    c.create("tinymce.plugins.TablePlugin",{
        init:function(f,g){
            var e,l,h=true;
            function k(o){
                var n=f.selection,m=f.dom.getParent(o||n.getNode(),"table");
                if(m){
                    return new a(m,f.dom,n)
                }
            }
            function j(){
                f.getBody().style.webkitUserSelect="";
                if(h){
                    f.dom.removeClass(f.dom.select("td.mceSelected,th.mceSelected"),"mceSelected");
                    h=false
                }
            }
            d([["table","table.desc","mceInsertTable",true],["delete_table","table.del","mceTableDelete"],["delete_col","table.delete_col_desc","mceTableDeleteCol"],["delete_row","table.delete_row_desc","mceTableDeleteRow"],["col_after","table.col_after_desc","mceTableInsertColAfter"],["col_before","table.col_before_desc","mceTableInsertColBefore"],["row_after","table.row_after_desc","mceTableInsertRowAfter"],["row_before","table.row_before_desc","mceTableInsertRowBefore"],["row_props","table.row_desc","mceTableRowProps",true],["cell_props","table.cell_desc","mceTableCellProps",true],["split_cells","table.split_cells_desc","mceTableSplitCells",true],["merge_cells","table.merge_cells_desc","mceTableMergeCells",true]],function(m){
                f.addButton(m[0],{
                    title:m[1],
                    cmd:m[2],
                    ui:m[3]
                })
            });
            if(!c.isIE){
                f.onClick.add(function(m,n){
                    n=n.target;
                    if(n.nodeName==="TABLE"){
                        m.selection.select(n);
                        m.nodeChanged()
                    }
                })
            }
            f.onPreProcess.add(function(n,o){
                var m,p,q,s=n.dom,r;
                m=s.select("table",o.node);
                p=m.length;
                while(p--){
                    q=m[p];
                    s.setAttrib(q,"data-mce-style","");
                    if((r=s.getAttrib(q,"width"))){
                        s.setStyle(q,"width",r);
                        s.setAttrib(q,"width","")
                    }
                    if((r=s.getAttrib(q,"height"))){
                        s.setStyle(q,"height",r);
                        s.setAttrib(q,"height","")
                    }
                }
            });
            f.onNodeChange.add(function(o,m,r){
                var q;
                r=o.selection.getStart();
                q=o.dom.getParent(r,"td,th,caption");
                m.setActive("table",r.nodeName==="TABLE"||!!q);
                if(q&&q.nodeName==="CAPTION"){
                    q=0
                }
                m.setDisabled("delete_table",!q);
                m.setDisabled("delete_col",!q);
                m.setDisabled("delete_table",!q);
                m.setDisabled("delete_row",!q);
                m.setDisabled("col_after",!q);
                m.setDisabled("col_before",!q);
                m.setDisabled("row_after",!q);
                m.setDisabled("row_before",!q);
                m.setDisabled("row_props",!q);
                m.setDisabled("cell_props",!q);
                m.setDisabled("split_cells",!q);
                m.setDisabled("merge_cells",!q)
            });
            f.onInit.add(function(n){
                var m,q,r=n.dom,o;
                e=n.windowManager;
                n.onMouseDown.add(function(s,t){
                    if(t.button!=2){
                        j();
                        q=r.getParent(t.target,"td,th");
                        m=r.getParent(q,"table")
                    }
                });
                r.bind(n.getDoc(),"mouseover",function(w){
                    var u,t,v=w.target;
                    if(q&&(o||v!=q)&&(v.nodeName=="TD"||v.nodeName=="TH")){
                        t=r.getParent(v,"table");
                        if(t==m){
                            if(!o){
                                o=k(t);
                                o.setStartCell(q);
                                n.getBody().style.webkitUserSelect="none"
                            }
                            o.setEndCell(v);
                            h=true
                        }
                        u=n.selection.getSel();
                        try{
                            if(u.removeAllRanges){
                                u.removeAllRanges()
                            }else{
                                u.empty()
                            }
                        }catch(s){}
                        w.preventDefault()
                    }
                });
                n.onMouseUp.add(function(B,C){
                    var t,v=B.selection,D,E=v.getSel(),s,w,u,A;
                    if(q){
                        if(o){
                            B.getBody().style.webkitUserSelect=""
                        }
                        function z(F,H){
                            var G=new c.dom.TreeWalker(F,F);
                            do{
                                if(F.nodeType==3&&c.trim(F.nodeValue).length!=0){
                                    if(H){
                                        t.setStart(F,0)
                                    }else{
                                        t.setEnd(F,F.nodeValue.length)
                                    }
                                    return
                                }
                                if(F.nodeName=="BR"){
                                    if(H){
                                        t.setStartBefore(F)
                                    }else{
                                        t.setEndBefore(F)
                                    }
                                    return
                                }
                            }while(F=(H?G.next():G.prev()))
                        }
                        D=r.select("td.mceSelected,th.mceSelected");
                        if(D.length>0){
                            t=r.createRng();
                            w=D[0];
                            A=D[D.length-1];
                            t.setStart(w);
                            t.setEnd(w);
                            z(w,1);
                            s=new c.dom.TreeWalker(w,r.getParent(D[0],"table"));
                            do{
                                if(w.nodeName=="TD"||w.nodeName=="TH"){
                                    if(!r.hasClass(w,"mceSelected")){
                                        break
                                    }
                                    u=w
                                }
                            }while(w=s.next());
                            z(u);
                            v.setRng(t)
                        }
                        B.nodeChanged();
                        q=o=m=null
                    }
                });
                n.onKeyUp.add(function(s,t){
                    j()
                });
                if(n&&n.plugins.contextmenu){
                    n.plugins.contextmenu.onContextMenu.add(function(u,s,w){
                        var z,v=n.selection,t=v.getNode()||n.getBody();
                        if(n.dom.getParent(w,"td")||n.dom.getParent(w,"th")||n.dom.select("td.mceSelected,th.mceSelected").length){
                            s.removeAll();
                            if(t.nodeName=="A"&&!n.dom.getAttrib(t,"name")){
                                s.add({
                                    title:"advanced.link_desc",
                                    icon:"link",
                                    cmd:n.plugins.advlink?"mceAdvLink":"mceLink",
                                    ui:true
                                });
                                s.add({
                                    title:"advanced.unlink_desc",
                                    icon:"unlink",
                                    cmd:"UnLink"
                                });
                                s.addSeparator()
                            }
                            if(t.nodeName=="IMG"&&t.className.indexOf("mceItem")==-1){
                                s.add({
                                    title:"advanced.image_desc",
                                    icon:"image",
                                    cmd:n.plugins.advimage?"mceAdvImage":"mceImage",
                                    ui:true
                                });
                                s.addSeparator()
                            }
                            s.add({
                                title:"table.desc",
                                icon:"table",
                                cmd:"mceInsertTable",
                                value:{
                                    action:"insert"
                                }
                            });
                            s.add({
                                title:"table.props_desc",
                                icon:"table_props",
                                cmd:"mceInsertTable"
                            });
                            s.add({
                                title:"table.del",
                                icon:"delete_table",
                                cmd:"mceTableDelete"
                            });
                            s.addSeparator();
                            z=s.addMenu({
                                title:"table.cell"
                            });
                            z.add({
                                title:"table.cell_desc",
                                icon:"cell_props",
                                cmd:"mceTableCellProps"
                            });
                            z.add({
                                title:"table.split_cells_desc",
                                icon:"split_cells",
                                cmd:"mceTableSplitCells"
                            });
                            z.add({
                                title:"table.merge_cells_desc",
                                icon:"merge_cells",
                                cmd:"mceTableMergeCells"
                            });
                            z=s.addMenu({
                                title:"table.row"
                            });
                            z.add({
                                title:"table.row_desc",
                                icon:"row_props",
                                cmd:"mceTableRowProps"
                            });
                            z.add({
                                title:"table.row_before_desc",
                                icon:"row_before",
                                cmd:"mceTableInsertRowBefore"
                            });
                            z.add({
                                title:"table.row_after_desc",
                                icon:"row_after",
                                cmd:"mceTableInsertRowAfter"
                            });
                            z.add({
                                title:"table.delete_row_desc",
                                icon:"delete_row",
                                cmd:"mceTableDeleteRow"
                            });
                            z.addSeparator();
                            z.add({
                                title:"table.cut_row_desc",
                                icon:"cut",
                                cmd:"mceTableCutRow"
                            });
                            z.add({
                                title:"table.copy_row_desc",
                                icon:"copy",
                                cmd:"mceTableCopyRow"
                            });
                            z.add({
                                title:"table.paste_row_before_desc",
                                icon:"paste",
                                cmd:"mceTablePasteRowBefore"
                            }).setDisabled(!l);
                            z.add({
                                title:"table.paste_row_after_desc",
                                icon:"paste",
                                cmd:"mceTablePasteRowAfter"
                            }).setDisabled(!l);
                            z=s.addMenu({
                                title:"table.col"
                            });
                            z.add({
                                title:"table.col_before_desc",
                                icon:"col_before",
                                cmd:"mceTableInsertColBefore"
                            });
                            z.add({
                                title:"table.col_after_desc",
                                icon:"col_after",
                                cmd:"mceTableInsertColAfter"
                            });
                            z.add({
                                title:"table.delete_col_desc",
                                icon:"delete_col",
                                cmd:"mceTableDeleteCol"
                            })
                        }else{
                            s.add({
                                title:"table.desc",
                                icon:"table",
                                cmd:"mceInsertTable"
                            })
                        }
                    })
                }
                if(!c.isIE){
                    function p(){
                        var s;
                        for(s=n.getBody().lastChild;s&&s.nodeType==3&&!s.nodeValue.length;s=s.previousSibling){}
                        if(s&&s.nodeName=="TABLE"){
                            n.dom.add(n.getBody(),"p",null,'<br mce_bogus="1" />')
                        }
                    }
                    if(c.isGecko){
                        n.onKeyDown.add(function(t,v){
                            var s,u,w=t.dom;
                            if(v.keyCode==37||v.keyCode==38){
                                s=t.selection.getRng();
                                u=w.getParent(s.startContainer,"table");
                                if(u&&t.getBody().firstChild==u){
                                    if(b(s,u)){
                                        s=w.createRng();
                                        s.setStartBefore(u);
                                        s.setEndBefore(u);
                                        t.selection.setRng(s);
                                        v.preventDefault()
                                    }
                                }
                            }
                        })
                    }
                    n.onKeyUp.add(p);
                    n.onSetContent.add(p);
                    n.onVisualAid.add(p);
                    n.onPreProcess.add(function(s,u){
                        var t=u.node.lastChild;
                        if(t&&t.childNodes.length==1&&t.firstChild.nodeName=="BR"){
                            s.dom.remove(t)
                        }
                    });
                    p()
                }
            });
            d({
                mceTableSplitCells:function(m){
                    m.split()
                },
                mceTableMergeCells:function(n){
                    var o,p,m;
                    m=f.dom.getParent(f.selection.getNode(),"th,td");
                    if(m){
                        o=m.rowSpan;
                        p=m.colSpan
                    }
                    if(!f.dom.select("td.mceSelected,th.mceSelected").length){
                        e.open({
                            url:g+"/merge_cells.htm",
                            width:240+parseInt(f.getLang("table.merge_cells_delta_width",0)),
                            height:110+parseInt(f.getLang("table.merge_cells_delta_height",0)),
                            inline:1
                        },{
                            rows:o,
                            cols:p,
                            onaction:function(q){
                                n.merge(m,q.cols,q.rows)
                            },
                            plugin_url:g
                        })
                    }else{
                        n.merge()
                    }
                },
                mceTableInsertRowBefore:function(m){
                    m.insertRow(true)
                },
                mceTableInsertRowAfter:function(m){
                    m.insertRow()
                },
                mceTableInsertColBefore:function(m){
                    m.insertCol(true)
                },
                mceTableInsertColAfter:function(m){
                    m.insertCol()
                },
                mceTableDeleteCol:function(m){
                    m.deleteCols()
                },
                mceTableDeleteRow:function(m){
                    m.deleteRows()
                },
                mceTableCutRow:function(m){
                    l=m.cutRows()
                },
                mceTableCopyRow:function(m){
                    l=m.copyRows()
                },
                mceTablePasteRowBefore:function(m){
                    m.pasteRows(l,true)
                },
                mceTablePasteRowAfter:function(m){
                    m.pasteRows(l)
                },
                mceTableDelete:function(m){
                    m.deleteTable()
                }
            },function(n,m){
                f.addCommand(m,function(){
                    var o=k();
                    if(o){
                        n(o);
                        f.execCommand("mceRepaint");
                        j()
                    }
                })
            });
            d({
                mceInsertTable:function(m){
                    e.open({
                        url:g+"/table.htm",
                        width:400+parseInt(f.getLang("table.table_delta_width",0)),
                        height:320+parseInt(f.getLang("table.table_delta_height",0)),
                        inline:1
                    },{
                        plugin_url:g,
                        action:m?m.action:0
                    })
                },
                mceTableRowProps:function(){
                    e.open({
                        url:g+"/row.htm",
                        width:400+parseInt(f.getLang("table.rowprops_delta_width",0)),
                        height:295+parseInt(f.getLang("table.rowprops_delta_height",0)),
                        inline:1
                    },{
                        plugin_url:g
                    })
                },
                mceTableCellProps:function(){
                    e.open({
                        url:g+"/cell.htm",
                        width:400+parseInt(f.getLang("table.cellprops_delta_width",0)),
                        height:295+parseInt(f.getLang("table.cellprops_delta_height",0)),
                        inline:1
                    },{
                        plugin_url:g
                    })
                }
            },function(n,m){
                f.addCommand(m,function(o,p){
                    n(p)
                })
            })
        }
    });
    c.PluginManager.add("table",c.plugins.TablePlugin)
})(tinymce);