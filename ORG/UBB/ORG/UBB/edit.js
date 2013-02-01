//made by xujinliang
var global_web_editor_obj;
//var global_web_editor_mouseY1;
//var global_web_editor_mouseY2;
function web_editor(json) {
    this.json = json;
    this.txt = '';
    this.$ = function(o) {
        document.getElementById(o).bind = function(actions, fun) {
            if (document.all) {
                this.attachEvent("on" + actions, 
                function(event) {
                    fun.call(this)
                });

            }
            else {
                this.addEventListener(actions, fun);

            }

        };
        return document.getElementById(o);

    };

}
function activeFun(json) {
    var _this = this;

    _this.$("web_editor_con2").style.display = "block";

    _this.$("web_editor_family").bind("mouseover", 
    function() {
        _this.over();

    });
    _this.$("web_editor_family_select").bind("change", 
    function() {
        _this.onfont(_this.$("web_editor_family_select").value);
        _this.$("web_editor_family_select").value = '';

    });
    _this.$("web_editor_font").bind("mouseover", 
    function() {
        _this.over();

    });
    _this.$("web_editor_font_select").bind("change", 
    function() {
        _this.onfontsize(_this.$("web_editor_font_select").value);
        _this.$("web_editor_font_select").value = '';

    });
    _this.$("web_editor_bold").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_bold").bind("mouseout", 
    function() {
        _this.out();

    });
    _this.$("web_editor_bold").bind("click", 
    function() {
        _this.onbold();

    });
    _this.$("web_editor_tilt").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_tilt").bind("mouseout", 
    function() {
        _this.out();

    });
    _this.$("web_editor_tilt").bind("click", 
    function() {
        _this.ontilt();

    });
    _this.$("web_editor_under").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_under").bind("mouseout", 
    function() {
        _this.out();

    });
    _this.$("web_editor_under").bind("click", 
    function() {
        _this.onunder();

    });
    _this.$("web_editor_color").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_color").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.colordiv(event);
        global_web_editor_obj = _this;

    });
    _this.$("web_editor_face").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_face").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.facediv(json, event);
        global_web_editor_obj = _this;

    });
    _this.$("web_editor_img").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_img").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.onimg(json, event);
        global_web_editor_obj = _this;

    });
    _this.$("web_editor_url").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_url").bind("click", 
    function() {
        _this.onurl();

    });
    _this.$("web_editor_music").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_music").bind("click", 
    function() {
        _this.onmusic();

    });
    _this.$("web_editor_flash").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_flash").bind("click", 
    function() {
        _this.onflash();

    });
    _this.$("web_editor_code").bind("mouseover", 
    function() {
        _this.over();
        _this.focusin();

    });
    _this.$("web_editor_code").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.codediv(json, event);
        global_web_editor_obj = _this;

    });
    _this.$("web_editor_con2").bind("blur", 
    function() {
        _this.onassign();

    });
    _this.$("web_editor_con2").bind("mousemove", 
    function() {
        _this.onassign();

    });
    _this.$("web_editor_about").bind("click", 
    function(e) {
        var event = e || window.event;
        _this.onabout(event);

    });
    //	_this.$("web_editor_dragbar").bind("mousedown",function(){
    //		 this.style.cursor="n-resize";
    //		 global_web_editor_mouseY1=event.clientY;		 
    //	});	
    //	_this.$("web_editor_dragbar").bind("mouseup",function(){
    //		 this.style.cursor="n-resize";
    //		 global_web_editor_mouseY1=event.clientY;		 
    //	});	
    //	_this.$("web_editor_dragbar").bind("mousemove",function(){
    //		 this.style.cursor="n-resize";
    //		 _this.$("web_editor_dragbar").style.position="relative";
    //		 _this.$("web_editor_dragbar").style.top=event.clientY;
    //		 global_web_editor_mouseY2=event.clientY;
    //		 _this.$("web_editor_con2").style.height=_this.$("web_editor_con2").offsetHeight+(global_web_editor_mouseY2-global_web_editor_mouseY1)+"px";
    //	});	

}
web_editor.prototype = {
    over: function() {
        if (document.all) {
            if (document.selection && document.selection.createRange().parentElement().name == 'content_textarea')
            {
                this.txt = document.selection.createRange();

            }

        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            this.txt = obj.value.substring(startPos, endPos);

        }

    },
    out: function() {
        this.txt = '';

    },
    focusin: function() {
        this.$("web_editor_con2").focus();

    },
    onbold: function() {
        if (document.all) {
            this.txt.text = '[b]' + this.txt.text + '[/b]';

        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[b]' + this.txt + '[/b]') + obj.value.substring(endPos);

        }

    },
    ontilt: function() {
        if (document.all) {
            this.txt.text = '[i]' + this.txt.text + '[/i]';

        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[i]' + this.txt + '[/i]') + obj.value.substring(endPos);

        }

    },
    onunder: function() {
        if (document.all) {
            this.txt.text = '[u]' + this.txt.text + '[/u]';

        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, '[u]' + this.txt + '[/u]') + obj.value.substring(endPos);

        }

    },
    onfont: function(value) {
        if (document.all) {
            this.txt.text = "[face=" + value + "]" + this.txt.text + "[/face]";

        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[face=" + value + "]" + this.txt + "[/face]") + obj.value.substring(endPos);

        }

    },
    onfontsize: function(value) {
        if (document.all) {
            this.txt.text = "[size=" + value + "]" + this.txt.text + "[/size]";

        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[size=" + value + "]" + this.txt + "[/size]") + obj.value.substring(endPos);

        }

    },
    oncolor: function(value) {
        if (document.all) {
            this.txt.text = "[color=" + value + "]" + this.txt.text + "[/color]";

        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[color=" + value + "]" + this.txt + "[/color]") + obj.value.substring(endPos);

        }

    },
    onimage: function(value) {
        if (document.all) {
            //this.txt.pasteHTML("<img src='"+this.json.host+"/ORG/UBB/image/face/"+value+".gif'>");
            //document.selection.empty();
            this.txt.text = "[img=" + this.json.host + "/ORG/UBB/image/face/" + value + ".gif][/img]";

        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            obj.value = obj.value.substring(0, startPos) + "[img=" + this.json.host + "/ORG/UBB/image/face/" + value + ".gif][/img]" + obj.value.substring(startPos);

        }

    },
    onimg: function(json, event) {
        if (!document.getElementById("simg"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "simg");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
            mydiv.style.width = "362px";
            mydiv.style.height = "150px";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "100";
            mydiv.innerHTML = '<div id="imgwrapper">' + 
            '<div align="right" style="width:100%;height:20px;background:#fbfbfb"><span onclick="var cdiv=document.getElementById(\'simg\');cdiv.parentNode.removeChild(cdiv);" style="font-family:Arial;font-size:14px;color:#000000;cursor:pointer">close</span></div>' + 
            '<div style="width:100%;height:130px;">' + 
            '<label style="font-size:14px;margin-bottom: 20px;display: block;">上传图片(最大2MB，JPG、JPEG、GIF或PNG文件)</label>' + 
            '<form style="margin-bottom: 10px;" name="formlocalimg" action="' + json.host + '/ORG/UBB/UploadForEditor.class.php" method="post" enctype="multipart/form-data" target="file_frame">' + 
            '<input type="file" name="file" style="width:300px;height:24px;"><span style="text-align:center;margin-left:10px;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;" onclick="formlocalimg.submit()">上传</span><br>' + 
            '<iframe name="file_frame" style="display:none;"></iframe>' + 
            '</form>' + 
            '<label style="font-size:14px;margin-bottom:10px;display: block;">网络图片地址</label>' + 
            '<input type="text" id="onlineimg" placeholder="请输入正确的图片格式" style="border:1px solid #d8d8d8;-webkit-border-radius:6px;border-radius:6px;outline:none;width:300px;height:24px;"><span style="text-align:center;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;position:relative;left:10px;top:-2px;" onclick="global_web_editor_obj.ononlineimg(document.getElementById(\'onlineimg\').value)">插入</span>' + 
            '</div>' + 
            '</div>';
            document.body.appendChild(mydiv);

        }

    },
    ononlineimg: function(value) {
        if (value != "" && value != null)
        {
            if (document.all) {
                //this.txt.pasteHTML("<img src='"+url+"'>");
                //document.selection.empty();
                this.txt.text = "[img=" + value + "][/img]";

            }
            else {
                var obj = this.$("web_editor_con2");
                var startPos = obj.selectionStart;
                obj.value = obj.value.substring(0, startPos) + "[img=" + value + "][/img]" + obj.value.substring(startPos);

            }

        }

    },
    onurl: function() {
        var value = prompt("请输入超链接地址", "http://")
        if (value != "" && value != null)
        {
            if (document.all) {
                this.txt.text = "[url=" + value + "]" + this.txt.text + "[/url]";

            }
            else {
                var obj = this.$("web_editor_con2");
                var startPos = obj.selectionStart;
                var endPos = obj.selectionEnd;
                if (this.txt == "" && this.txt != null)
                this.txt = value;
                obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[url=" + value + "]" + this.txt + "[/url]") + obj.value.substring(endPos);

            }

        }

    },
    onmusic: function() {
        var url = prompt("请输入音乐链接地址", "http://")
        if (url != "" && url != null)
        {
            if (document.all) {
                //this.txt.pasteHTML("<embed autostart=false src='"+url+"'></embed>");
                //document.selection.empty();
                this.txt.text = "[music=" + url + "]" + this.txt.text + "[/music]";

            }
            else {
                var obj = this.$("web_editor_con2");
                var startPos = obj.selectionStart;
                obj.value = obj.value.substring(0, startPos) + "[music=" + url + "][/music]" + obj.value.substring(startPos);

            }

        }

    },
    onflash: function() {
        var url = prompt("请输入视频链接地址", "http://")
        if (url != "" && url != null)
        {
            if (document.all) {
                /*	
				this.txt.pasteHTML('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="450" height="300">'+
 '<param name="movie" value="'+url+'" />'+
'<param name="quality" value="high" />'+
'<param name="wmode" value="transparent">'+
'<embed wmode="transparent" src="'+url+'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="450" height="300"></embed>'+
'</object>');
					document.selection.empty();
					*/
                this.txt.text = "[video=" + url + "]" + this.txt.text + "[/video]";

            }
            else {
                var obj = this.$("web_editor_con2");
                var startPos = obj.selectionStart;
                obj.value = obj.value.substring(0, startPos) + "[video=" + url + "][/video]" + obj.value.substring(startPos);
                /*		obj.value=obj.value.substring(0,startPos)+'<object type="application/x-shockwave-flash" data="'+url+'" width="450" height="350" >'+
'<param name="movie" value="'+url+'" />'+
'<param name="quality" value="high" />'+
'<param name="play" value="false" />'+
'<param name="loop" value="false" />'+
'<param name="menu" value="false" />'+
'<param name="scale" value="default" />'+
'<param name="wmode" value="transparent">'+
'</object>'+obj.value.substring(startPos);
*/

            }

        }

    },
    onassign: function() {

        this.$("content").value = this.$("web_editor_con2").value;

    },
    onabout: function(event) {
        if (!document.getElementById("sabout"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "sabout");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
            mydiv.style.width = "250px";
            mydiv.style.height = "130px";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "99";
            mydiv.innerHTML = "<table width=250 height=130 border=0>" + 
            "<tr >" + 
            "<td  height=16 valign=top style=\"text-align:right;background:#fbfbfb\"><span onclick=\"var cdiv = document.getElementById('sabout');cdiv.parentNode.removeChild(cdiv);\" style=\"font-family:Arial;font-size:14px;color:#000000;cursor:pointer\">close</span></td>" + 
            "</tr >" + 
            "<tr >" + 
            "<td height=114 style=\"font-size:12px;font-weight:bold\" valign=top align=left>名称：web-editor<br><br>用途：JavaScript社区编辑器<br><br>作者：YouCle<br><br>生产日期：2012</td>" + 
            "</tr></table>";
            document.body.appendChild(mydiv);
        }
    },
    colordiv: function(event) {
        if (!document.getElementById("scolor"))
        {
            var mydiv = document.createElement("div");
            mydiv.setAttribute("id", "scolor");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv.style.position = "absolute";
            mydiv.style.left = w;
            mydiv.style.top = h;
            mydiv.style.width = "200px";
            mydiv.style.height = "120px";
            mydiv.style.border = "1px solid #e6e6e6";
            mydiv.style.backgroundColor = "#ffffff";
            mydiv.style.zIndex = "99";
            mydiv.innerHTML = "<table width=200 height=80 border=0 style=\"border-collapse:separate;\">" + 
            "<tr >" + 
            "<td colspan=8  style=\"text-align:right;background:#fbfbfb\"><span onclick=\"var cdiv = document.getElementById('scolor');cdiv.parentNode.removeChild(cdiv);\" style=\"font-family:Arial;font-size:14px;color:#000000;cursor:pointer\">close</span></td>" + 
            "</tr >" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#000000\" onclick=\"global_web_editor_obj.oncolor('#000000')\"></td>" + 
            "<td height=10 width=20  style=\"background:#333333\" onclick=\"global_web_editor_obj.oncolor('#333333')\"></td>" + 
            "<td height=10 width=20 style=\"background:#666666\" onclick=\"global_web_editor_obj.oncolor('#666666')\"></td>" + 
            "<td height=10 width=20  style=\"background:#999999\" onclick=\"global_web_editor_obj.oncolor('#999999')\"></td>" + 
            "<td height=10 width=20 style=\"background:#aaaaaa\" onclick=\"global_web_editor_obj.oncolor('#aaaaaa')\"></td>" + 
            "<td height=10 width=20 style=\"background:#cccccc\" onclick=\"global_web_editor_obj.oncolor('#cccccc')\"></td>" + 
            "<td height=10 width=20 style=\"background:#f0f0f0\" onclick=\"global_web_editor_obj.oncolor('#f0f0f0')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ffffff\" onclick=\"global_web_editor_obj.oncolor('#ffffff')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20  style=\"background:#000131\" onclick=\"global_web_editor_obj.oncolor('#000131')\"></td>" + 
            "<td height=10 width=20 style=\"background:#020064\" onclick=\"global_web_editor_obj.oncolor('#020064')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00019f\" onclick=\"global_web_editor_obj.oncolor('#00019f')\"></td>" + 
            "<td height=10 width=20 style=\"background:#0100c8\" onclick=\"global_web_editor_obj.oncolor('#0100c8')\"></td>" + 
            "<td height=10 width=20 style=\"background:#0002fc\" onclick=\"global_web_editor_obj.oncolor('#0002fc')\"></td>" + 
            "<td height=10 width=20 style=\"background:#3134fa\" onclick=\"global_web_editor_obj.oncolor('#3134fa')\"></td>" + 
            "<td height=10 width=20 style=\"background:#9a99ff\" onclick=\"global_web_editor_obj.oncolor('#9a99ff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#cccdfb\" onclick=\"global_web_editor_obj.oncolor('#cccdfb')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#003500\" onclick=\"global_web_editor_obj.oncolor('#003500')\"></td>" + 
            "<td height=10 width=20 style=\"background:#006509\" onclick=\"global_web_editor_obj.oncolor('#006509')\"></td>" + 
            "<td height=10 width=20 style=\"background:#009d00\" onclick=\"global_web_editor_obj.oncolor('#009d00')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00cd07\" onclick=\"global_web_editor_obj.oncolor('#00cd07')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00ff00\" onclick=\"global_web_editor_obj.oncolor('#00ff00')\"></td>" + 
            "<td height=10 width=20 style=\"background:#3cf93e\" onclick=\"global_web_editor_obj.oncolor('#3cf93e')\"></td>" + 
            "<td height=10 width=20 style=\"background:#96fa98\" onclick=\"global_web_editor_obj.oncolor('#96fa98')\"></td>" + 
            "<td height=10 width=20 style=\"background:#cdffce\" onclick=\"global_web_editor_obj.oncolor('#cdffce')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#360000\" onclick=\"global_web_editor_obj.oncolor('#360000')\"></td>" + 
            "<td height=10 width=20 style=\"background:#680003\" onclick=\"global_web_editor_obj.oncolor('#680003')\"></td>" + 
            "<td height=10 width=20 style=\"background:#940100\" onclick=\"global_web_editor_obj.oncolor('#940100')\"></td>" + 
            "<td height=10 width=20 style=\"background:#cc0002\" onclick=\"global_web_editor_obj.oncolor('#cc0002')\"></td>" + 
            "<td height=10 width=20 style=\"background:#f8000b\" onclick=\"global_web_editor_obj.oncolor('#f8000b')\"></td>" + 
            "<td height=10 width=20 style=\"background:#fa3b28\" onclick=\"global_web_editor_obj.oncolor('#fa3b28')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ff9895\" onclick=\"global_web_editor_obj.oncolor('#ff9895')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ffcbd1\" onclick=\"global_web_editor_obj.oncolor('#ffcbd1')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#363000\" onclick=\"global_web_editor_obj.oncolor('#363000')\"></td>" + 
            "<td height=10 width=20 style=\"background:#6e6102\" onclick=\"global_web_editor_obj.oncolor('#6e6102')\"></td>" + 
            "<td height=10 width=20 style=\"background:#a99200\" onclick=\"global_web_editor_obj.oncolor('#a99200')\"></td>" + 
            "<td height=10 width=20 style=\"background:#c2d200\" onclick=\"global_web_editor_obj.oncolor('#c2d200')\"></td>" + 
            "<td height=10 width=20 style=\"background:#fff80a\" onclick=\"global_web_editor_obj.oncolor('#fff80a')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ffff2b\" onclick=\"global_web_editor_obj.oncolor('#ffff2b')\"></td>" + 
            "<td height=10 width=20 style=\"background:#fff89b\" onclick=\"global_web_editor_obj.oncolor('#fff89b')\"></td>" + 
            "<td height=10 width=20 style=\"background:#fffcc2\" onclick=\"global_web_editor_obj.oncolor('#fffcc2')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#003335\" onclick=\"global_web_editor_obj.oncolor('#003335')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00666c\" onclick=\"global_web_editor_obj.oncolor('#00666c')\"></td>" + 
            "<td height=10 width=20 style=\"background:#009f9d\" onclick=\"global_web_editor_obj.oncolor('#009f9d')\"></td>" + 
            "<td height=10 width=20 style=\"background:#00cecf\" onclick=\"global_web_editor_obj.oncolor('#00cecf')\"></td>" + 
            "<td height=10 width=20 style=\"background:#05feff\" onclick=\"global_web_editor_obj.oncolor('#05feff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#3afefd\" onclick=\"global_web_editor_obj.oncolor('#3afefd')\"></td>" + 
            "<td height=10 width=20 style=\"background:#9affff\" onclick=\"global_web_editor_obj.oncolor('#9affff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ceffff\" onclick=\"global_web_editor_obj.oncolor('#ceffff')\"></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td height=10 width=20 style=\"background:#310034\" onclick=\"global_web_editor_obj.oncolor('#310034')\"></td>" + 
            "<td height=10 width=20 style=\"background:#620360\" onclick=\"global_web_editor_obj.oncolor('#620360')\"></td>" + 
            "<td height=10 width=20 style=\"background:#90039f\" onclick=\"global_web_editor_obj.oncolor('#90039f')\"></td>" + 
            "<td height=10 width=20 style=\"background:#db00ce\" onclick=\"global_web_editor_obj.oncolor('#db00ce')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ff00fe\" onclick=\"global_web_editor_obj.oncolor('#ff00fe')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ff30ff\" onclick=\"global_web_editor_obj.oncolor('#ff30ff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ff97ff\" onclick=\"global_web_editor_obj.oncolor('#ff97ff')\"></td>" + 
            "<td height=10 width=20 style=\"background:#ffccff\" onclick=\"global_web_editor_obj.oncolor('#ffccff')\"></td>" + 
            "</tr></table>";
            document.body.appendChild(mydiv);
        }
    },
    oncode: function(value) {
        if (document.all) {
            this.txt.text = "[code=" + value + "]" + this.txt.text + "[/code]";
        }
        else {
            var obj = this.$("web_editor_con2");
            var startPos = obj.selectionStart;
            var endPos = obj.selectionEnd;
            obj.value = obj.value.substring(0, startPos) + this.txt.replace(this.txt, "[code=" + value + "]" + this.txt + "[/code]") + obj.value.substring(endPos);
        }
    },
    codediv: function(json, event) {
    	if (!document.getElementById("scode"))
        {
            var mydiv3 = document.createElement("div");
            mydiv3.setAttribute("id", "scode");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv3.style.position = "absolute";
            mydiv3.style.left = w;
            mydiv3.style.top = h;
            mydiv3.style.width = "250px";
            mydiv3.style.height = "100px";
            mydiv3.style.border = "1px solid #e6e6e6";
            mydiv3.style.backgroundColor = "#ffffff";
            mydiv3.style.zIndex = "100";
            mydiv3.innerHTML = '<div style="width:250px;">' + 
            '<div align="right" style="width:100%;height:20px;background:#fbfbfb"><span onclick="var cdiv=document.getElementById(\'scode\');cdiv.parentNode.removeChild(cdiv);" style="font-family:Arial;font-size:14px;color:#000000;cursor:pointer">close</span></div>' + 
            '<div style="width:100%;height:100px;">' + 
            '<label style="font-size:14px;margin-bottom: 20px;display: block;">选择你要显示高亮的代码类型</label>' +  
            '<select id="codesel" style="width:100px;"><option value="">请选择类型</option><option value="xml">XML</option><option value="javascript">JavaScript</option><option value="php">PHP</option><option value="sql">SQL</option></select><span style="text-align:center;margin-left:10px;width:42px;height:24px;font-size:13px;line-height:24px;background:#4184ca;color:#fff;display:inline-block;cursor:pointer;" onclick="global_web_editor_obj.oncode(document.getElementById(\'codesel\').value)">确定</span>' + 
            '</div>' + 
            '</div>';
            document.body.appendChild(mydiv3);
        }
    },
    facediv: function(json, event) {
        if (!document.getElementById("sface"))
        {
            var mydiv2 = document.createElement("div");
            mydiv2.setAttribute("id", "sface");
            var w = event.clientX + "px";
            var h = event.clientY + Math.max(document.body.scrollTop, document.documentElement.scrollTop) + "px";
            mydiv2.style.position = "absolute";
            mydiv2.style.left = w;
            mydiv2.style.top = h;
            mydiv2.style.width = "400px";
            mydiv2.style.height = "224px";
            mydiv2.style.border = "1px solid #e6e6e6";
            mydiv2.style.backgroundColor = "#ffffff";
            mydiv2.style.zIndex = "100";
            mydiv2.innerHTML = "<table width=400 height=210 border=0 cellspacing=0 cellpadding=0>" + 
            "<tr>" + 
            "<td colspan=8 style=\"text-align:right;background:#fbfbfb\"><span onclick=\"var cdiv = document.getElementById('sface');cdiv.parentNode.removeChild(cdiv);\" style=\"font-family:Arial;font-size:14px;color:#000000;cursor:pointer\">close</span></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td><img onclick=\"global_web_editor_obj.onimage('00')\" width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/00.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('01')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/01.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('02')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/02.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('03')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/03.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('04')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/04.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('05')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/05.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('06')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/06.gif'></td>" + 
            "<td><img   onclick=\"global_web_editor_obj.onimage('07')\" width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/07.gif'></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td><img onclick=\"global_web_editor_obj.onimage('08')\"  width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/08.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('09')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/09.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('10')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/10.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('11')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/11.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('12')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/12.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('13')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/13.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('14')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/14.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('15')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/15.gif'></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('16')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/16.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('17')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/17.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('18')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/18.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('19')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/19.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('20')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/20.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('21')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/21.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('22')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/22.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('23')\"  width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/23.gif'></td>" + 
            "</tr>" + 
            "<tr>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('24')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/24.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('25')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/25.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('26')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/26.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('27')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/27.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('28')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/28.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('29')\" width=50 height=50  src='" + json.host + "/ORG/UBB/image/face/29.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('30')\" width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/30.gif'></td>" + 
            "<td><img  onclick=\"global_web_editor_obj.onimage('31')\" width=50 height=50 src='" + json.host + "/ORG/UBB/image/face/31.gif'></td>" + 
            "</tr>" + 
            "</table>";
            document.body.appendChild(mydiv2);

        }

    },
    create: function(json) {
        this.$(json.id).style.width = json.w + "px";
        this.$(json.id).innerHTML = '<div style="width:' + json.w + 'px;background:#f0f0ee">' + 
        '<div  id="web_editor_title" style="display:table;width:100%">' + 
        '<span id="web_editor_family">' + 
        '<select id="web_editor_family_select">' + 
        '<option value="">字体</option>' + 
        '<option value="宋体">宋体</option>' + 
        '<option value="黑体">黑体</option>' + 
        '<option value="隶书">隶书</option>' + 
        '<option value="楷体">楷体</option>' + 
        '<option value="华文新魏">华文新魏</option>' + 
        '<option value="Arial">Arial</option>' + 
        '<option value="Verdana">Verdana</option>' + 
        '<option value="Tahoma">Tahoma</option>' + 
        '</select>' + 
        '</span>' + 
        '<span id="web_editor_font">' + 
        '<select id="web_editor_font_select">' + 
        '<option value="">大小</option>' + 
        '<option value="10px">10</option>' + 
        '<option value="11px">11</option>' + 
        '<option value="12px">12</option>' + 
        '<option value="13px">13</option>' + 
        '<option value="14px">14</option>' + 
        '<option value="16px">16</option>' + 
        '<option value="18px">18</option>' + 
        '<option value="24px">24</option>' + 
        '</select>' + 
        '</span>' + 
        '<span title="加粗" id="web_editor_bold" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -60px -42px"></span>' + 
        '<span title="倾斜" id="web_editor_tilt" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -85px -42px"></span>' + 
        '<span title="下划线" id="web_editor_under" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -110px -42px"></span>' + 
        '<span title="颜色" id="web_editor_color" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -138px -42px"></span>' + 
        '<span title="超链接" id="web_editor_url" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -201px -42px"></span>' + 
        '<span title="表情" id="web_editor_face" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -338px -155px"></span>' + 
        '<span title="图片" id="web_editor_img" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -367px -155px"></span>' + 
        '<span title="音乐" id="web_editor_music" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -396px -155px"></span>' + 
        '<span title="视频" id="web_editor_flash" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -424px -155px"></span>' + 
        '<span title="代码" id="web_editor_code" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -470px -155px"></span>' +
        '<span title="关于" id="web_editor_about" style="background:url(' + json.host + '/ORG/UBB/image/bg.gif) no-repeat  -448px -155px"></span>' + 
        '</div>' + 
        '<textarea id="web_editor_con2"  name="content_textarea" style="border:1px solid #cccccc;resize:vertical;height:' + json.h + 'px;"></textarea>' + 
        '<input type="hidden" name="content" id="content">' + 
        '</div>';
        activeFun.call(this, json);

    }

}
function web_editor_init(ID, W, H, HOST)
 {
    var json = {
        id: ID,
        w: W,
        h: H,
        host: HOST
    };
    var web_edit = new web_editor(json);
    web_edit.create(json);

}