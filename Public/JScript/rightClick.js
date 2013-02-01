function Dialog(e) {
    if (document.getElementById("Dialog").style.display == "block") {
        Tip("不能重复打开对话框", 2);
        if (!document.getElementById("Tip"))
        {
            alert("不能重复打开对话框");

        }
        return false;

    }
    var e = e || window.event;
    var srcObj = e.srcElement || e.target;
    var lists = srcObj.getAttribute("list");
    var listsstr = lists.split("-");
    if (srcObj.tagName.toLowerCase() == "li" || srcObj.tagName.toLowerCase() == "a") {
        var sps = ['con_one', 'con_two', 'con_three', 'con_four'];
        for (var i = 0; i < sps.length; i++) {
            var styles = (i == listsstr[0]) ? 'block': 'none';
            document.getElementById(sps[i]).style.display = styles;

        }
        document.getElementById("c1").innerHTML = "序号是 " + listsstr[1] + " 的主题颜色设置";
        document.getElementById("c2").innerHTML = "序号是 " + listsstr[1] + " 的主题置顶？";
        document.getElementById("c3").innerHTML = "序号是 " + listsstr[1] + " 的主题转移？";
        document.getElementById("c4").innerHTML = "序号是 " + listsstr[1] + " 的主题删除？";
        document.getElementById("topicid").value = listsstr[1];
        document.getElementById("action").value = listsstr[0];
        document.getElementById("Dialog").style.display = "block";

    }

}
document.oncontextmenu = function(e) {
    var e = e || window.event;
    var srcObj = e.srcElement || e.target;
    if (srcObj.tagName.toLowerCase() != "body")
    return false;

}
function whichElement(e, vid) {
    var e = e || window.event;
    if (e.button == 2 || (document.all && e.button == 0))
    {
        if (document.getElementById("pri")) {
            document.getElementById("pri").parentNode.removeChild(document.getElementById("pri"));

        }
        var mydiv = document.createElement("div");
        mydiv.setAttribute("id", "pri");
        var w = e.clientX + "px";
        var h = (e.clientY + document.documentElement.scrollTop + document.body.scrollTop) + "px";

        mydiv.style.cssText = "position:absolute;left:" + w + ";top:" + h + ";width:80px;height:80px;background-color:#eeeeee";
        mydiv.innerHTML = "<ul style=\"margin:0px;padding:0px;width:80px;list-style-type:none;\">" + 
        "<li list=\"0-" + vid + "\" style=\"width:80px;height:20px;line-height:20px;\" onmouseover=\"this.style.background='#dfdfdf'\" onmouseout=\"this.style.background='#eeeeee'\"><a style=\"font-family:Arial;font-size:12px;font-weight:normal;text-decoration:none;cursor:pointer;padding-left:12px;\" href=\"javascript:void(0)\" list=\"0-" + vid + "\">主题颜色</a></li>" + 
        "<li list=\"1-" + vid + "\" style=\"width:80px;height:20px;line-height:20px;\" onmouseover=\"this.style.background='#dfdfdf'\" onmouseout=\"this.style.background='#eeeeee'\"><a style=\"font-family:Arial;font-size:12px;font-weight:normal;text-decoration:none;cursor:pointer;padding-left:12px;\" href=\"javascript:void(0)\" list=\"1-" + vid + "\">帖子置顶</a></li>" + 
        "<li list=\"2-" + vid + "\" style=\"width:80px;height:20px;line-height:20px;\" onmouseover=\"this.style.background='#dfdfdf'\" onmouseout=\"this.style.background='#eeeeee'\"><a style=\"font-family:Arial;font-size:12px;font-weight:normal;text-decoration:none;cursor:pointer;padding-left:12px;\" href=\"javascript:void(0)\" list=\"2-" + vid + "\">帖子转移</a></li>" + 
        "<li list=\"3-" + vid + "\" style=\"width:80px;height:20px;line-height:20px;\" onmouseover=\"this.style.background='#dfdfdf'\" onmouseout=\"this.style.background='#eeeeee'\"><a style=\"font-family:Arial;font-size:12px;font-weight:normal;text-decoration:none;cursor:pointer;padding-left:12px;\" href=\"javascript:void(0)\" list=\"3-" + vid + "\">帖子删除</a></li>" + 
        "</ul>";
        document.body.appendChild(mydiv);
        if (document.all) {
            document.getElementById("pri").attachEvent("onclick", 
            function() {
                Dialog.call(document.getElementById("pri"))
            });

        } else {
            document.getElementById("pri").addEventListener("click", Dialog);

        }

    }
    if (e.button == 1 || (!document.all && e.button == 0))
    {
        var srcObj = e.srcElement || e.target;
        var obj = document.getElementById("pri");
        if (srcObj != obj && srcObj.tagName.toLowerCase() != "li" && srcObj.tagName.toLowerCase() != "a")
        {
            document.getElementById("pri").parentNode.removeChild(document.getElementById("pri"));

        }

    }

}

function self()
 {
    if (document.all) {
        window.event.returnValue = false;

    }

}