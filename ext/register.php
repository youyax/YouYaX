<?php
	session_start();
	$config=include('../Conf/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<script type="text/javascript" src="../ext/functions.js"></script>
<style type="text/css">
.button{
	font-family:Arial;
	font-size:14px;
	background:url('../Public/images/button2.png');
	width:62px;
	height:28px;
	line-height:28px;
	border:none;
	cursor:pointer;
}
input[type="text"],input[type="password"]{
	border:1px #dfdfdf solid;
	-webkit-border-radius:5px;
	border-radius:5px;
	height:24px
}
input[type="text"]:focus,input[type="password"]:focus{
	transition:border linear .2s,box-shadow linear .5s;
	-moz-transition:border linear .2s,-moz-box-shadow linear .5s;
	-webkit-transition:border linear .2s,-webkit-box-shadow linear .5s;
	-o-transition:border linear .2s,-webkit-box-shadow linear .5s;
	outline:none;
	box-shadow:0 0 10px rgba(124,105,56,.7);
	-moz-box-shadow:0 0 10px rgba(124,105,56,.7);
	-webkit-box-shadow:0 0 10px rgba(124,105,56,.7);
	-o-box-shadow:0 0 10px rgba(124,105,56,.7)
}
</style>
<title>注册</title>
<script language = "javascript" > 
function $(o) {
    return document.getElementById(o)
}
function check() {
    if (document.form.user.value == "") {
        $("msg").innerHTML = "<font color=red>用户名不能为空！</font>";
        document.form.user.focus();
        return false;
    }
    if (document.form.user.value.length > 6) {
        $("msg").innerHTML = "<font color=red>用户名长度不能超过6位！</font>";
        document.form.user.focus();
        return false;
    }
    if ((form.user.value).indexOf(" ") == 0) {
        $("msg").innerHTML = "<font color=red>用户名首字符不能为空</font>";
        return false;
    }
    if (document.form.pass.value == "") {
        $("msg").innerHTML = "<font color=red>密码不能为空！</font>";
        document.form.pass.focus();
        return false;
    }
    if (document.form.email.value == "") {
        $("msg").innerHTML = "<font color=red>邮箱不能为空！</font>";
        document.form.email.focus();
        return false;
    }
}
</script>
<style type="text/css">
	#form .error{ color:red;}
</style>
</head>
<body bgcolor="#f1f7da" style="overflow:hidden">
<form name=form id=form action="" method=post onsubmit="senddata();return check();">
<div id="msg"></div>
<table width=360px  height=130 cellspacing=0 cellpadding=0>
<tr><td style="font-family:arial;font-size:16px;">用户名</td><td><input style="width:130px" id="username" type="text" name="user"></td></tr>
<tr><td style="font-family:arial;font-size:16px;">密码</td><td><input style="width:130px" id="pass"  name="pass"  type=password onBlur="senddata();"  onFocus="senddata();" ></td></tr>
<tr><td style="font-family:arial;font-size:16px;">邮箱</td><td><input style="width:130px" id="email" type="text" name="email" ></td></tr>
<tr><td colspan=2><input type="submit"  class="button" name="sub" value="注册"></td></tr>
</table>
</form>
<?php
include('../ext_public/include.php');
if (isset($_POST['sub'])) {
    $user = addslashes($_POST['user']);
    $pass = md5(addslashes($_POST['pass']));
    $_POST['email']=addslashes($_POST['email']);
    if (empty($_POST['email'])) {
        echo "<script>alert('邮箱名必填');</script>";
        echo "<script>window.parent.location.href='" . url_site . "';</script>";
        exit;
    }
    $code = '';
    for ($i = 0; $i < 6; $i++) {
        $code .= mt_rand(0, 9);
    }
    include('../ext_public/database.php');
    $mailconf = require("../Conf/mail.config.php");
    if(empty($mailconf['mail_Host'])&&empty($mailconf['mail_Username'])&&empty($mailconf['mail_Password'])){
    	echo "<script>alert('请至后台配置邮件服务器验证');</script>";
    	exit;
    }
    require_once("../ext_public/phpmailer/class.phpmailer.php");
    mysql_query("SET NAMES 'utf8'");
    $sql    = "select * from " . $config['db_prefix'] . "user where user='" . $user . "'";
    $result = mysql_query($sql);
    $num    = mysql_num_rows($result);
    if ($num > 0) {
        echo "<script>alert('该用户名已被注册');</script>";
        echo "<script>window.parent.location.href='" . url_site . "';</script>";
    } else {
        $sql2    = "select * from " . $config['db_prefix'] . "user where email='" . $_POST['email'] . "'";
        $result2 = mysql_query($sql2);
        $num2    = mysql_num_rows($result2);
        if ($num2 > 0) {
            echo "<script>alert('邮箱名已被注册');</script>";
            echo "<script>window.parent.location.href='" . url_site . "';</script>";
        } else {
            $mail     = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host     = $mailconf['mail_Host'];
            $mail->SMTPAuth = true;
            $mail->Username = $mailconf['mail_Username'];
            $mail->Password = $mailconf['mail_Password'];
            $mail->From     = $mailconf['mail_From'];
            $mail->FromName = $mailconf['mail_FromName'];
            $mail->AddAddress($_POST['email']);
            $mail->IsHTML(true);
            $mail->CharSet  = "UTF-8";
            $mail->Encoding = "base64";
            $mail->Subject  = $mailconf['mail_Subject'];
            $mail->Body     = $mailconf['mail_Body'] . "<a href='" . url_site . "/ext/mail_active.php?user=" . $user . "&pass=" . $pass . "&email=" . $_POST['email'] . "&code=" . $code . "'>点此激活</a>";
            if (!$mail->Send()) {
                exit;
            }
            date_default_timezone_set('PRC');
            $sql = "insert into " . $config['db_prefix'] . "user(user,pass,status,email,complete,face,time,fatieshu,codes) values('" . $user . "','" . $pass . "',0,'" . $_POST['email'] . "','0','00.gif',now(),0,'" . $code . "')";
            mysql_query($sql);
            echo "<script>alert('注册成功,请至邮箱激活!');</script>";
            echo "<script>window.parent.location.href='" . url_site . "';</script>";
        }
    }
}
?>
</body>
</html>