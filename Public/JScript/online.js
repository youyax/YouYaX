var xmlhttp;
if (window.ActiveXObject)
 {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
 else
 {
    xmlhttp = new XMLHttpRequest();
}

function getonline() {
    if (document.getElementById("ip"))
    {
        alert("禁止重复查询！");
        return;

    }
    var mydiv = document.createElement("div");
    mydiv.setAttribute("id", "ip");
    mydiv.style.position = "absolute";
    var w = (window.screen.availWidth - 450) / 2 + "px";
    var h = (window.screen.availHeight - 350) / 2 + "px";
    mydiv.style.left = w;
    mydiv.style.top = h;
    mydiv.style.width = "450px";
    mydiv.style.height = "350px";
    mydiv.style.border = "1px solid #c2c2c2";
    mydiv.style.backgroundColor = "#ffffff";
    mydiv.style.zIndex = "99";
    mydiv.innerHTML = '<div align="right" id="ipclose" style="width:450px;height:16;background:#f9f9f9"><span style="font-size:14px;font-weight:600;cursor:pointer" onclick="var cdiv = document.getElementById(\'ip\'); cdiv.parentNode.removeChild(cdiv);">关闭</span></div> ' + 
    '<div id="ipcon" style="width:450px;height:334px;overflow-y:scroll"><img style="margin-left:220px;margin-top:156px;" src="' + rooturl + '/Public/images/load.gif"></div>';
    document.body.appendChild(mydiv);

    xmlhttp.open("POST", rooturl + "/index.php/Index" + url + "showip" + shtml, true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("data=1");
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var jsonObject = eval("(" + xmlhttp.responseText + ")");
            var con = "";
            for (var i in jsonObject)
            {
                con += jsonObject[i] + "<br>";

            }
            document.getElementById("ipcon").innerHTML = con;

        }

    }

}