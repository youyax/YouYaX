<?php
session_start();
$config = include('../Conf/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>登陆</title>
<script type="text/javascript" src="../Public/JScript/public.js"></script>
<script type="text/javascript" src="../Public/JScript/Tip2.js"></script>
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
	border: 1px #dfdfdf solid;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	height:24px;
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
-o-box-shadow:0 0 10px rgba(124,105,56,.7);
}
</style>
</head>
<body bgcolor="#f1f7da">
<?php
include('../ext_public/include.php');
if (isset($_POST['sub'])) {
    include('../ext_public/database.php');
    mysql_query("SET NAMES 'utf8'");
    $sql    = "select* from " . $config['db_prefix'] . "user where user='" . addslashes($_POST['user']) . "'  and pass='" . md5(addslashes($_POST['pass'])) . "' and status=1 and complete=0";
    $user   = $_POST['user'];
    $result = mysql_query($sql);
    $num    = mysql_num_rows($result);
    if ($num == 1) {
        $_SESSION['youyax_data'] = 1;
        $_SESSION['youyax_user'] = $user;
        $_SESSION['youyax_bz']   = 1;
        echo "<script>Tip('登陆成功',3,1,'parent');</script>";
    } else {
        $_SESSION['youyax_data'] = 0;
        echo "<script>Tip('输入有误 or 尚未激活！',2,1,'parent');</script>";
    }
}
?>
	<form action="" method=post>
	<table width=360px  height=150 cellspacing=0 cellpadding=0>
	<tr><td style="font-family:arial;font-size:16px;">用户名</td><td><input type=text id=username name=user style="width:130px;"></td></tr>
	<tr><td style="font-family:arial;font-size:16px;">密码</td><td><input id=pass name=pass type=password style="width:130px"></td></tr>
	<tr><td colspan=2><input  type="submit" name="sub" class="button" value="登陆" /></td></tr>
	</table>
</form>
</body>
</html>
