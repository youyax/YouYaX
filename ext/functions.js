var xmlhttp;
if (window.ActiveXObject) {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
} else {
    xmlhttp = new XMLHttpRequest()
}
function senddata() {
    serverpage = "yanzheng.php?username=" + escape(document.getElementById('username').value);
    xmlhttp.open("GET", serverpage);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("msg").innerHTML = xmlhttp.responseText
        }
    }
    xmlhttp.send(null)
}