document.onreadystatechange = function()
 {
    if (document.readyState == "complete")
    {
        var h = document.getElementById("scon").offsetHeight - document.getElementById("swrap").offsetHeight;
        var s = document.getElementById("slider").offsetHeight - document.getElementById("slider_btn").offsetHeight;
        var result = h / s;
        document.getElementById("slider_btn").onmousedown = function(e) {
            var e = e || window.event;
            var posY = e.clientY - this.offsetTop;
            document.onmousemove = function(e) {
                document.getElementsByTagName('body')[0].className = 'no-user-select';
                var e = e || window.event;
                var y = e.clientY - posY;
                if (y < 0) {
                    document.getElementById("slider_btn").style.top = "0px";

                } else if (y > document.getElementById("slider").offsetHeight - document.getElementById("slider_btn").offsetHeight) {
                    document.getElementById("slider_btn").style.top = document.getElementById("slider").offsetHeight - document.getElementById("slider_btn").offsetHeight + "px";

                } else {
                    document.getElementById("slider_btn").style.top = y + "px";
                    document.getElementById("scon").style.top = '-' + (y * result) + 'px';

                }

            }

        }
        document.onmouseup = function() {
            document.onmousemove = null;
            document.getElementsByTagName('body')[0].className = '';

        }

    }

}