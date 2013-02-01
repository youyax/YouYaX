<?php
	$config=include('../Conf/config.php');
	$con=mysql_connect($config['db_host'],$config['db_user'],$config['db_pwd']);
	mysql_select_db($config['db_name'],$con);
	mysql_query("set names utf8");
?>