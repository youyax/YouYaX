<?php
class MessageAction extends YouYaX
{
    public function send(){
     	header("Content-Type:text/html; charset=utf-8");
     	if(!empty($_SESSION['youyax_user'])){
	      $mto=addslashes($_POST['mto']);
	      $mcon=addslashes($_POST['mcon']);
	      if(empty($mcon)){
	      	echo '消息不能为空';
	      	exit;
	      }
	      if($_SESSION['youyax_user']==$mto){
	      	echo '您不能给自己发消息';
	      	exit;
	      }else{
	      	$data=array();
	      	$data['mfrom']=$_SESSION['youyax_user'];
	      	$data['mto']=$mto;
	      	$data['mcon']=$mcon;
	      	$data['time']=time();
	      	$this->add($data,C('db_prefix') . "message");
	      	$result=$this->find(C('db_prefix') . "message_status",'string',"muser='".$mto."'");
	      	if($result){
	      		$data2=array();
	      		$data2['mstatus']=1;
	      		$this->save($data2,C('db_prefix') . "message_status","muser='".$mto."'");
	      	}else{
		      	$data2=array();
		      	$data2['muser']  = $mto;
		      	$data2['mstatus']= 1;
		      	$this->add($data2,C('db_prefix') . "message_status");
	      	}
	      	echo '发送成功';
	      }
	    }else{
	    	echo '未登陆用户不能发送消息';
	    }
    }
    public function show(){
  	  $user = $_SESSION['youyax_user'];
      if ($user == "" || $user == null)
        $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
    	$data2=array();
  		$data2['mstatus']=0;
  		$this->save($data2,C('db_prefix') . "message_status","muser='".$_SESSION['youyax_user']."'");
    	$data=$this->select("select * from ". C('db_prefix') . "message where mto='".$_SESSION['youyax_user']."' order by id desc");
    	$this->assign('data',$data)
    	     ->assign('site', C('SITE'))
           ->assign('shtml', C('static_url'))
           ->assign('url', C('default_url'));
      $site_config = require("./Conf/site.config.php");
      $this->assign('site_config', $site_config)
    	     ->display("home/show.html");
    }
    public function delMess(){
    	$user = $_SESSION['youyax_user'];
      if ($user == "" || $user == null)
        $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
    	$id=addslashes(getparam("mid"));
    	$result=$this->find(C('db_prefix') . "message",'string',"mto='".$_SESSION['youyax_user']."' and id='".$id."'");
    	if($result){
    		$this->delete(C('db_prefix') . "message","mto='".$_SESSION['youyax_user']."' and id='".$id."'");
        $this->assign('jumpurl', $this->youyax_url . "/Message" . C('default_url') . "show" . C('static_url'))
             ->assign('msgtitle', '操作成功')
             ->assign('message', '消息已删除！')
             ->success();
        exit;
    	}else{
    		$this->assign('jumpurl', $this->youyax_url . "/Message" . C('default_url') . "show" . C('static_url'))
             ->assign('msgtitle', '操作失败')
             ->assign('message', '请仔细检查！')
             ->error();
        exit;
    	}
    }
}
?>