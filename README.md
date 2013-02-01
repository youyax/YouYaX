Program Name:YouYaX
Uses: php community
Author:YouCle
Donate:(If this program is to help you can donate, Paypal account: xujinliang1227@163.com)
Feature:
	This is a MVC structure php community
	1, small size
			The entire file to install the package size is approximately 1.28M, fully functional.
	2, easy development
			PHP development experience of webmaster can easily modify the function expansion.
	3, a clear structure
			Separation of code and page templates
	4, free
			Without limiting the installation directory, located in the root directory or subdirectory.
Code style:
	<?php
		//Controller wording
		class IndexAction extends YouYaX{
		 public function index(){
		   $this->assign('site','www.youyax.com');
		   $this->display('home/index.html');
		  }
		}
	?>
	
	//Template wording
	<html>
	<body>
	The Result：{site}
	</body>
	</html>
