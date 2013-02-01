<?php
$user  = addslashes($_GET['user']);
$pass  = addslashes($_GET['pass']);
$email = addslashes($_GET['email']);
$code  = addslashes($_GET['code']);
include('../ext_public/database.php');
$config = include('../Conf/config.php');
mysql_query("SET NAMES 'utf8'");
$sql    = "select * from " . $config['db_prefix'] . "user where user='" . $user . "' and pass='" . $pass . "' and email='" . $email . "' and codes='" . $code . "'";
$result = mysql_query($sql);
$num    = mysql_num_rows($result);
if ($num > 0) {
		$code = '';
    for ($i = 0; $i < 6; $i++) {
        $code .= mt_rand(0, 9);
    }
    $sql = "update " . $config['db_prefix'] . "user set status=1,codes='".$code."' where user='" . $user . "'";
    mysql_query($sql);
    $tip1 = "操作成功";
    $tip2 = "用户激活成功";
} else {
    $tip1 = "操作失败";
    $tip2 = "用户激活失败";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>页面提示</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
			body{
				background:#a6a6a6;
			}
			#exception{
  			font-family:'隶书';
				text-align:center;
				width:350px;
				height:60px;
				line-height:60px;
				background:#f4e1d5;
				position:fixed;
  			margin:auto;
  			left:0; right:0; top:0; bottom:0;
  			box-shadow: rgb(255, 255, 255) 0px 0px 100px;
  			-webkit-box-shadow: rgb(255, 255, 255) 0px 0px 100px;
  			-moz-border-radius: 20px;
  			-khtml-border-radius: 20px;
  			-webkit-border-radius: 20px;
  			border-radius: 20px;
}
		</style>
	</head>
	<body>
		<div id="exception">
				<span style="font-family:Tahoma;font-size:14px;display:block;height:14px;margin-top:-10px;"><?php
echo $tip1;
?></span>
				<span style="color:red;font-family:Verdana;font-size:14px;font-weight:700;display:block;height:14px;margin-top:6px;"><?php
echo $tip2;
?></span>
		</div>
	</body>
</html>