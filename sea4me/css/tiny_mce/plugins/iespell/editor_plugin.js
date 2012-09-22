(function(){
    tinymce.create("tinymce.plugins.IESpell",{
        init:function(a,b){
            var c=this,d;
            if(!tinymce.isIE){
                return
            }
            c.editor=a;
            a.addCommand("mceIESpell",function(){
                try{
                    d=new ActiveXObject("ieSpell.ieSpellExtension");
                    d.CheckDocumentNode(a.getDoc().documentElement)
                }catch(f){
                    if(f.number==-2146827859){
                        a.windowManager.confirm(a.getLang("iespell.download"),function(e){
                            if(e){
                                window.open("http://www.iespell.com/download.php","ieSpellDownload","")
                            }
                        })
                    }else{
                        a.windowManager.alert("Error Loading ieSpell: Exception "+f.number)
                    }
                }
            });
            a.addButton("iespell",{
                title:"iespell.iespell_desc",
                cmd:"mceIESpell"
            })
        },
        getInfo:function(){
            return{
                longname:"IESpell (IE Only)",
                author:"Moxiecode Systems AB",
                authorurl:"http://tinymce.moxiecode.com",
                infourl:"http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/iespell",
                version:tinymce.majorVersion+"."+tinymce.minorVersion
            }
        }
    });
    tinymce.PluginManager.add("iespell",tinymce.plugins.IESpell)
})();