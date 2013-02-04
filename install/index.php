<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>YouYaX开源论坛 &rsaquo; 调整配置文件</title>
</head>
<body>
	<?php
$status = file_get_contents("./status.txt");
if ($status != "complete") {
?>
<link rel="stylesheet" href="css/install.css?ver=3.4.2" type="text/css" />
<h1 id="logo"><img title="YouYaX开源论坛，作者：xujinliang" src="../Public/images/logo.gif?ver=20121006" /></h1>
<?php
	if(isset($_POST['submit'])&&$_GET['step']==2){
		$conf=file_get_contents("../Conf/config.php");
		$conf=str_replace("{host}",$_POST['dbhost'],$conf);
		$conf=str_replace("{name}",$_POST['dbname'],$conf);
		$conf=str_replace("{user}",$_POST['uname'],$conf);
		$conf=str_replace("{pass}",$_POST['pwd'],$conf);
		$conf=str_replace("{prefix}",$_POST['prefix'],$conf);
		$conf=str_replace("{lang}",$_POST['lang'],$conf);
		$conf=str_replace("{url}",$_POST['url'],$conf);
		$conf=str_replace("{html}",$_POST['shtml'],$conf);
		$conf=str_replace("{action}",$_POST['action'],$conf);
		$conf=str_replace("{site}",$_POST['root'],$conf);
		file_put_contents("../Conf/config.php",$conf);
		echo '../Conf/config.php 配置成功！<br>';
		
		$public=file_get_contents("../Public/JScript/public.js");
		$public=str_replace("{site}",$_POST['root'],$public);
		$public=str_replace("{url}",$_POST['url'],$public);
		$public=str_replace("{html}",$_POST['shtml'],$public);
		file_put_contents("../Public/JScript/public.js",$public);
		echo '../Public/JScript/public.js 配置成功！<br>';
		
		$datasql=file_get_contents("./demo.sql");
		$datasql=str_replace("{prefix}",$_POST['prefix'],$datasql);
		file_put_contents("./demo.sql",$datasql);
		echo './demo.sql 配置成功！<br>';
		
		$sql=file_get_contents("./demo.sql");
		$con=mysql_connect($_POST['dbhost'],$_POST['uname'],$_POST['pwd']);
		mysql_select_db($_POST['dbname'],$con);
		mysql_query("set names utf8");
		$sql_arr=explode(";",$sql);
		$sql_arr_count=sizeof($sql_arr);
		for($i=0;$i < $sql_arr_count;$i++){
			mysql_query($sql_arr[$i]);
		}
		mysql_query("insert into ".$_POST['prefix']."admin(user,pass) values('".$_POST['auser']."','".md5($_POST['apass'])."')");
		echo '数据库语句执行配置成功！<br>';
		echo '<a target="_balnk" href="'.$_POST['root'].'">论坛主页</a><br>';
		echo '<a target="_balnk" href="'.$_POST['root'].'/index.php/admin'.$_POST['url'].'login'.$_POST['shtml'].'">论坛后台管理地址</a><br>';
		file_put_contents("./status.txt","complete");
		exit;
	}
}else{
	?>
<style type="text/css">
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
	body{
				background:#a6a6a6;
			}
</style>
	<div id="exception">
				<span style="font-family:Tahoma;font-size:14px;display:block;height:14px;margin-top:-10px;">操作错误</span>
				<span style="color:red;font-family:Verdana;font-size:14px;font-weight:700;display:block;height:14px;margin-top:6px;">重新安装，需清空status.txt</span>
		</div>
<?php
}
if ($status != "complete") {
?>
<form method="post" action="index.php?step=2">
	<p>请在下方填写您的数据库连接信息。如果您不确定，请联系您的服务提供商。PHP版本<5.3。</p>
	<table class="form-table">
		<tr>
			<th scope="row"><label for="dbname">数据库名</label></th>
			<td><input name="dbname" id="dbname" type="text" size="25" value=""/></td>
			<td>将 YouYaX开源论坛 安装到哪个数据库？</td>
		</tr>
		<tr>
			<th scope="row"><label for="uname">用户名</label></th>
			<td><input name="uname" id="uname" type="text" size="25" value=""/></td>
			<td>您的 MySQL 用户名</td>
		</tr>
		<tr>
			<th scope="row"><label for="pwd">密码</label></th>
			<td><input name="pwd" id="pwd" type="text" size="25" value=""/></td>
			<td>&hellip;及其密码</td>
		</tr>
		<tr>
			<th scope="row"><label for="dbhost">数据库主机</label></th>
			<td><input name="dbhost" id="dbhost" type="text" size="25" value="localhost" /></td>
			<td>如果填写 <code>localhost</code> 之后论坛不能正常工作的话，请向主机服务提供商索要数据库信息。</td>
		</tr>
		<tr>
			<th scope="row"><label for="prefix">数据表前缀</label></th>
			<td><input name="prefix" id="prefix" type="text" size="25" value="youyax_" /></td>
			<td>建议填写，防止数据表重复</td>
		</tr>
		<tr>
			<th scope="row"><label for="lang">默认语言</label></th>
			<td><input type="radio" name="lang" value="cn" checked>中文 &nbsp;&nbsp; <input type="radio" name="lang" value="en">英文</td>
			<td>如果有语言包文件时，该选项起作用</td>
		</tr>
		<tr>
			<th scope="row"><label for="url">URL分隔符</label></th>
			<td><input name="url" id="url" type="text" size="25" value="/" /></td>
			<td>url地址栏分隔符，默认"/"</td>
		</tr>
		<tr>
			<th scope="row"><label for="shtml">伪静态设置</label></th>
			<td><input name="shtml" id="shtml" type="text" size="25" value=".html" /></td>
			<td>如不要设置伪静态，请清空该文本框</td>
		</tr>
		<tr>
			<th scope="row"><label for="action">默认控制器</label></th>
			<td><input name="action" id="action" type="text" size="25" value="" /></td>
			<td>如不填，则默认运行IndexAction,如需填写，请填写例如"Index"</td>
		</tr>
		<tr>
			<th scope="row"><label for="auser">管理员帐户</label></th>
			<td><input name="auser" id="auser" type="text" size="25" value="" placeholder="必填项"/></td>
			<td>后台管理员帐户</td>
		</tr>
		<tr>
			<th scope="row"><label for="apass">管理员密码</label></th>
			<td><input name="apass" id="apass" type="text" size="25" value="" placeholder="必填项"/></td>
			<td>后台管理员密码</td>
		</tr>
		<tr>
			<th scope="row"><label for="root">论坛网址</label></th>
			<td><input name="root" id="root" type="text" size="25" value="" placeholder="必填项"/></td>
			<td>填写例如"http://xxx.com 或带子目录http://xxx.com/xxx"</td>
		</tr>
	</table>
		<p class="step"><input name="submit" type="submit" value="提交" class="button" /></p>
</form>
<?php
}
?>
</body>
</html>
