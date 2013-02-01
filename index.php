<?php
session_start();
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class LOAD{
	static function loadClass($class_name){
		$filename = "./Lib/".$class_name.".php";
		 if(is_file($filename)) return require($filename);
		}
}
$status = file_get_contents("./install/status.txt");
if ($status == "complete") {
    require("ORG/YouYa.php");
    require("Model/Model.php");
    spl_autoload_register(array('LOAD', 'loadClass'));
    App::run();
} else {
    echo '<script>window.location.href="./install";</script>';
}
?>