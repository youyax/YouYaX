document.onreadystatechange = function()
 {
    if (document.readyState == "complete")
    {
        var url = window.location.href;
        var url_array = url.split("=");
        var page = url_array[1];
        var uclass = document.getElementsByTagName("a");
        for (var n in uclass)
        {
            if (uclass[n].id == page && uclass[n].id != undefined)
            {
                uclass[n].style.background = "#f2d699";
            }
        }
    }
}
var xmlhttp;
if (window.ActiveXObject)
 {
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}
 else
 {
    xmlhttp = new XMLHttpRequest();
}
function showdiv(e) {
    var e = window.event || e;
    document.getElementById("czz1div").style.left = e.clientX - 10 + "px";
    document.getElementById("czz1div").style.top = e.clientY - 10 + "px";
    document.getElementById("czz1div").style.display = "block";
}
function hidediv() {
    document.getElementById("czz1div").style.display = "none";
}
function showdiv2() {
    document.getElementById("czz1div").style.display = "block";
}
function hidediv2() {
    document.getElementById("czz1div").style.display = "none";
}
function showdivn(id, e) {
    var e = window.event || e;
    document.getElementById("czzdiv" + id).style.left = e.clientX - 10 + "px";
    document.getElementById("czzdiv" + id).style.top = e.clientY - 10 + document.documentElement.scrollTop + document.body.scrollTop + "px";
    document.getElementById("czzdiv" + id).style.display = "block";
}
function hidedivn(id) {
    document.getElementById("czzdiv" + id).style.display = "none";
}
function showdiv4(id) {
    document.getElementById("czzdiv" + id).style.display = "block";
}
function hidediv4(id) {
    document.getElementById("czzdiv" + id).style.display = "none";
}
function check(){
    if (document.form1.zuozhe1.value == "")
    {
        Tip("您没有权限发帖，请先登陆", 2);
        if (!document.getElementById("Tip"))
        {
            alert("您没有权限发帖，请先登陆");
        }
        return false;
    }
    if (document.getElementById("content").value == "")
    {
        Tip("回复内容不能为空！", 1);
        if (!document.getElementById("Tip"))
        {
            alert("回复内容不能为空！");
        }
        return false;
    }
}
function showmarkone(){
    var w = (window.screen.availWidth - 200) / 2 + "px";
    var h = (window.screen.availHeight - 250) / 2 + "px";
    document.getElementById("markone").style.cssText = "position:fixed;left:" + w + ";top:" + h + ";z-index:99;width:200px;height:250px;border:5px solid #b2b3b7;background-color:#f1f7da;";
    document.getElementById("markone").style.display = "block";
}
function turnmarkone(){
    document.getElementById("markone").style.display = "none";
}
function showmark(m){
    var w = (window.screen.availWidth - 200) / 2 + "px";
    var h = (window.screen.availHeight - 250) / 2 + "px";
    document.getElementById("mark" + m).style.cssText = "position:fixed;left:" + w + ";top:" + h + ";z-index:99;width:200px;height:250px;border:5px solid #b2b3b7;background-color:#f1f7da;";
    document.getElementById("mark" + m).style.display = "block";
}
function turnmark(m){
    document.getElementById("mark" + m).style.display = "none";
}
function show(val){
	var w = (window.screen.availWidth - 300) / 2 + "px";
  var h = (window.screen.availHeight - 70) / 2 + "px";
	var mess=document.createElement("div");
	mess.id="ms";
	mess.style.cssText = "position:fixed;left:" + w + ";top:" + h + ";z-index:99;width:300px;height:70px;border:10px solid rgba(0,0,0,0.3);background-clip:padding-box;background-color:#efece7;";
	mess.innerHTML='<div align="right" style="height:14px;font-size:14px">'+
 '<span style="cursor:pointer;" onclick="document.getElementById(\'ms\').parentNode.removeChild(document.getElementById(\'ms\'));">close</span>'+
'</div>'+
'<div style="width:280px;height:40px;margin-left:10px;margin-top:2px;overflow:hidden">'+
	'<textarea id="ta" placeholder="向 '+val+' 发送短消息" style="float:left;width:230px;width:200px\9;_width:200px;height:40px;border:none;background:#a2b08c;resize:none;overflow:hidden"></textarea>'+
	'<div style="width:40px;height:40px;background:#40aa53;color:#fff;text-align:center;float:left;margin-left:4px;font-size:14px;">'+
	 '<span onclick="send(\''+val+'\',document.getElementById(\'ta\').value)" style="position:relative;top:12px;cursor:pointer">发送</span>'+
	'</div>'+
'</div>';
	document.body.appendChild(mess);
}
function send(val,tc){
	xmlhttp.open("POST", rooturl + "/index.php/Message" + url + "send" + shtml, true);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp.send("mto="+val+"&mcon="+tc);
  xmlhttp.onreadystatechange = function() {
  if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
  		alert(xmlhttp.responseText);
  	}
  }
}