<?php
	session_start();
	$config=include('../Conf/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<script language="javascript">
			function show(n){
				document.form.t.value=""+n.options[n.selectedIndex].value;
			}
		</script>
	</head>
	<body bgcolor="#f1f7da">
	<?php
		if($_SESSION['youyax_user']==""){
			echo "<b>未登陆用户不能评分!</b>";
		}else{
	?>
		<h3 style="color:#0099cc;margin-bottom:20px;">评分</h3>
			<form name=form action="<?php echo $config['SITE']; ?>/index.php/Content<?php echo $config['default_url']; ?>mark1<?php echo $config['static_url']; ?>" method=post>
		<b>操作说明</b>&nbsp;&nbsp;<select name=sel onchange="show(this)">
												<option value="文不对题">文不对题</option>
												<option value="违规内容">违规内容</option>												
												<option value="我很赞同">我很赞同</option>
												<option value="精品文章">精品文章</option>
										 </select>
		<br>
		<textarea name=t cols=15 rows=5 style="width:160px"></textarea><br>
		<input type=hidden name=id value="<?php echo $_GET['id'];?>">
		<input type=hidden name=user value="<?php echo $_SESSION['youyax_user'];?>">
		<input type=submit value="确定">
	</form>
<?php 	}	?>
</body>
</html>
		