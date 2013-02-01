/* 注册脚本  start */
document.getElementById("a1").onclick = function() {
    var w = (document.body.clientWidth - 400) / 2 + "px";
    var h = (window.screen.availHeight - 250) / 2 + "px";
    document.getElementById("register").style.cssText = "position:absolute;top:" + h + ";left:" + w + ";width:400px;height:200px;background-color:#f1f7da;border:5px solid #b2b3b7;z-index:9;display:block;overflow:hidden;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;";
    for (var i = 0; i <= 50; i++) {
        (function() {
            var mt = i;
            setTimeout(function() {
                document.getElementById("register").style.filter = "alpha(opacity=" + (2 * mt) + ")";
                document.getElementById("register").style.MozOpacity = mt / 50;
                document.getElementById("register").style.opacity = mt / 50;
                document.getElementById("register").style.top = (window.screen.availHeight - 300) / 2 + mt + "px";

            },
            (mt + 1) * 10);

        })();

    }

}
document.getElementById("rt").onmousedown = function(e) {
    var event = e || window.event;
    x1 = event.clientX - getLeft(document.getElementById("register"));
    y1 = event.clientY - getTop(document.getElementById("register"));
    var witchButton = false;
    if (document.all && event.button == 1) {
        witchButton = true;
    }
    else {
        if (event.button == 0) witchButton = true;
    }
    if (witchButton)
    {
        document.onmousemove = function(e) {
            var event = e || window.event;
            document.getElementById("register").style.left = event.clientX - x1 + "px";
            document.getElementById("register").style.top = event.clientY - y1 + "px";

        }

    }

}
document.getElementById("rt").onmouseup = function(event) {
    document.onmousemove = null;

}
document.getElementById("register").getElementsByTagName("b")[0].onclick = function() {
    var topreg = getTop(document.getElementById("register"));
    for (var i = 50; i >= 0; i--) {
        (function() {
            var mt = i;
            setTimeout(function() {
                if (mt == 0) {
                    document.getElementById("register").style.display = "none";

                }
                document.getElementById("register").style.filter = "alpha(opacity=" + (2 * mt) + ")";
                document.getElementById("register").style.MozOpacity = mt / 50;
                document.getElementById("register").style.opacity = mt / 50;
                document.getElementById("register").style.top = topreg - (50 - mt) + "px";

            },
            (51 - mt) * 10);

        })();

    }

}
/* 注册脚本  end */

/* 登录脚本  start */
document.getElementById("a2").onclick = function() {
    var w = (document.body.clientWidth - 400) / 2 + "px";
    var h = (window.screen.availHeight - 200) / 2 + "px";
    document.getElementById("login").style.cssText = "position:absolute;top:" + h + ";left:" + w + ";width:400px;height:200px;background-color:#f1f7da;border:5px solid #b2b3b7;z-index:9;display:block;overflow:hidden;filter:alpha(opacity=0);-moz-opacity:0;opacity:0;";
    for (var i = 0; i <= 50; i++) {
        (function() {
            var mt = i;
            setTimeout(function() {
                document.getElementById("login").style.filter = "alpha(opacity=" + (2 * mt) + ")";
                document.getElementById("login").style.MozOpacity = mt / 50;
                document.getElementById("login").style.opacity = mt / 50;
                document.getElementById("login").style.top = (window.screen.availHeight - 300) / 2 + mt + "px";

            },
            (mt + 1) * 10);

        })();

    }

}
document.getElementById("lt").onmousedown = function(e) {
    var event = e || window.event;
    x1 = event.clientX - getLeft(document.getElementById("login"));
    y1 = event.clientY - getTop(document.getElementById("login"));
    var witchButton = false;
    if (document.all && event.button == 1) {
        witchButton = true;
    }
    else {
        if (event.button == 0) witchButton = true;
    }
    if (witchButton)
    {
        document.onmousemove = function(e) {
            var event = e || window.event;
            document.getElementById("login").style.left = event.clientX - x1 + "px";
            document.getElementById("login").style.top = event.clientY - y1 + "px";

        }

    }

}
document.getElementById("lt").onmouseup = function() {
    document.onmousemove = null;

}
document.getElementById("login").getElementsByTagName("b")[0].onclick = function() {
    var toplog = getTop(document.getElementById("login"));
    for (var i = 50; i >= 0; i--) {
        (function() {
            var mt = i;
            setTimeout(function() {
                if (mt == 0) {
                    document.getElementById("login").style.display = "none";

                }
                document.getElementById("login").style.filter = "alpha(opacity=" + (2 * mt) + ")";
                document.getElementById("login").style.MozOpacity = mt / 50;
                document.getElementById("login").style.opacity = mt / 50;
                document.getElementById("login").style.top = toplog - (50 - mt) + "px";

            },
            (51 - mt) * 10);

        })();

    }

}
/* 登录脚本  end */
