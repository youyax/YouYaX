<?php
class IndexAction extends YouYaX
{
    public function tongji()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $myIp = $_SERVER['HTTP_CLIENT_IP'];
        else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $myIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $myIp = $_SERVER['REMOTE_ADDR'];
        $myTime   = time();
        $lastTime = $myTime - 600;
        $query    = mysql_num_rows(mysql_query("select * from " . C('db_prefix') . "online where ip='" . $myIp . "'"));
        if ($query < 1) //无此IP，就增加一条在线记录
            {
            $c   = curl_init();
            $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=" . $myIp;
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            $iper = curl_exec($c);
            curl_close($c);
            $ips              = json_decode($iper);
            $str1             = $myIp;
            $str2             = $ips->country;
            $str3             = $ips->province;
            $str4             = $ips->city;
            $str5             = $ips->district;
            $str6             = $ips->isp;
            $zone             = $str1 . " ," . $str2 . $str3 . " ,(" . $str4 . ")" . $str5 . $str6;
            $data['ip']       = $myIp;
            $data['lasttime'] = $myTime;
            $data['user']     = $_SESSION['youyax_user'];
            $data['zone']     = $zone;
            $this->add($data, C('db_prefix') . "online");
        } else //有此用户，就更改此用户的最后活动时间
            {
            $data['lasttime'] = $myTime;
            $data['user']     = $_SESSION['youyax_user'];
            $this->save($data, C('db_prefix') . "online", "ip='" . $myIp . "'");
        }
        
        $this->delete(C('db_prefix') . "online", "lasttime<" . $lastTime);
        $num = mysql_num_rows(mysql_query("select * from " . C('db_prefix') . "online"));
        return $num;
    }
    public function index()
    {
        header("Content-Type:text/html; charset=utf-8");
        if ($_SESSION['youyax_data'] == 1) {
            $bz   = $_SESSION['youyax_bz'];
            $user = $_SESSION['youyax_user'];
            if ($bz != 1)
                $bz = 0;
            if ($bz == 0) {
                $_SESSION['youyax_user'] = "";
                $user                    = "";
                $_SESSION['youyax_data'] = 0;
            }
        } else {
            $_SESSION['youyax_user'] = "";
            $_SESSION['youyax_bz']   = "";
            $bz                      = 0;
            $user                    = "";
        }
        $this->assign('bz', $bz)
             ->assign('user', $user);
        $tongji = $this->tongji();
        $this->assign('count', $tongji);
        $sql_block   = "select * from " . C('db_prefix') . "small_block order by ssort desc,bid desc,szone desc";
        $query_block = mysql_query($sql_block);
        $data_block  = array();
        $data_big    = array();
        $time1       = date("Y-m-d");
        $time1 .= " 00:00:00";
        $time2 = date("Y-m-d");
        $time2 .= " 23:59:59";
        while ($arr_block = mysql_fetch_array($query_block)) {
            $data_block[] = $arr_block;
            
            $bsql                        = "select * from " . C('db_prefix') . "big_block where id=" . $arr_block['bid'];
            $barr                        = mysql_fetch_array(mysql_query($bsql));
            $data_big[$arr_block['bid']] = $barr['bzone'];
            
            ${'zhuti' . $arr_block['id']} = mysql_num_rows(mysql_query("select * from " . C('db_prefix') . "talk where parentid=" . $arr_block['id']));
            $this->assign("zhuti" . $arr_block['id'], ${'zhuti' . $arr_block['id']});
            
            ${'tiezi1' . $arr_block['id']} = mysql_num_rows(mysql_query("select * from " . C('db_prefix') . "talk where parentid=" . $arr_block['id']));
            ${'tiezi2' . $arr_block['id']} = mysql_num_rows(mysql_query("select * from " . C('db_prefix') . "reply where parentid2=" . $arr_block['id']));
            ${'tiezi' . $arr_block['id']}  = ${'tiezi1' . $arr_block['id']} + ${'tiezi2' . $arr_block['id']};
            $this->assign("tiezi" . $arr_block['id'], ${'tiezi' . $arr_block['id']});
            
            ${'arc' . $arr_block['id']} = $this->find(C('db_prefix') . "talk", "string", "parentid=" . $arr_block['id'] . " order by timeup desc");
            $this->assign("arc" . $arr_block['id'], ${'arc' . $arr_block['id']});
            
            ${'today1' . $arr_block['id']} = $this->select("select  count(*) as count1 from " . C('db_prefix') . "talk where parentid in " . "(".$arr_block['id'].",".(int)($arr_block['id']+10000).")". " and time1 between '" . $time1 . "' and '" . $time2 . "'");
            ${'today2' . $arr_block['id']} = $this->select("select  count(*) as count2 from " . C('db_prefix') . "reply where parentid2 in" . "(".$arr_block['id'].",".(int)($arr_block['id']+10000).")". " and time2 between '" . $time1 . "' and '" . $time2 . "'");
            ${'today' . $arr_block['id']}  = ${'today1' . $arr_block['id']}[0][count1] + ${'today2' . $arr_block['id']}[0][count2];
            $this->assign("today" . $arr_block['id'], ${'today' . $arr_block['id']});
            
        }
        $message_result=$this->find(C('db_prefix') . "message_status",'string',"muser='".$_SESSION['youyax_user']."'");
        if($message_result['mstatus']=='1'){
        	$this->assign('message_status','display');
        }else{
        	$this->assign('message_status','none');
        }
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)
             ->assign('data_big', $data_big)
             ->assign('data_block', $data_block)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display('home/index.html');
    }
    public function logout()
    {
        header("Content-Type:text/html; charset=utf-8");
        $_SESSION['youyax_user'] = "";
        $_SESSION['youyax_bz']   = "";
        echo "<script>window.location.href='" . C('SITE') . "';</script>";
    }
    public function self()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
        $this->assign('user', $user)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'));
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)
             ->display("home/self.html");
    }
    public function saveself()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
        $face = $_POST['face'];
        mysql_query("update " . C('db_prefix') . "user set  face='" . $face . "'  where user='" . $user . "'");
        mysql_query("update " . C('db_prefix') . "talk set  face='" . $face . "'  where zuozhe='" . $user . "'");
        mysql_query("update " . C('db_prefix') . "reply set  face1='" . $face . "'  where zuozhe1='" . $user . "'");
        mysql_query("update " . C('db_prefix') . "mark2 set  pic='" . $face . "'  where marker='" . $user . "'");
        mysql_query("update " . C('db_prefix') . "mark1 set  pic='" . $face . "'  where marker='" . $user . "'");
        $this->assign('jumpurl', $this->youyax_url . "/Index" . C('default_url') . "self" . C('static_url'))
             ->assign('msgtitle', '操作成功')
             ->assign('message', '图片更新成功！')
             ->success();
    }
    public function mypub()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
        $sql   = "select * from (select id,title,time1,zuozhe from " . C('db_prefix') . "talk where zuozhe='" . $user . "') t left join (select zuozhe1,rid from " . C('db_prefix') . "reply  order by id2 desc) tmp on t.id=tmp.rid group by t.id order by t.time1 desc";
        $count = mysql_num_rows(mysql_query($sql));
        if($count<=0){
        	$show='';
        	$result='';
        }else{
        require("./ORG/Page/Fenye.class.php");
        $fenye  = new Fenye($count, 50);
        $show   = $fenye->show();
        $show   = implode("&nbsp;", $show);
        $sql2   = $fenye->listcon($sql);
        $result = $this->select($sql2);
      	}
        $this->assign('page', $show)
             ->assign("mypubinfo", $result)
             ->assign('user', $user)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'));
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)
             ->display("home/mypub.html");
    }
    public function myrep()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
        $sql   = "select * from (select * from (select zuozhe1,num2,rid,time2 from " . C('db_prefix') . "reply where zuozhe1='" . $user . "' order by time2 desc) tmp group by tmp.rid desc) r left join (select id,zuozhe,title from " . C('db_prefix') . "talk) t on r.rid=t.id order by r.time2 desc";
        $count = mysql_num_rows(mysql_query($sql));
        if($count<=0){
        	$show='';
        	$result='';
        }else{
        require("./ORG/Page/Fenye.class.php");
        $fenye  = new Fenye($count, 50);
        $show   = $fenye->show();
        $show   = implode("&nbsp;", $show);
        $sql2   = $fenye->listcon($sql);
        $result = $this->select($sql2);
      	}
        $this->assign('page', $show)
             ->assign("myrepinfo", $result)
             ->assign('user', $user)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'));
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)
             ->display("home/myrep.html");
    }
    public function chpsd()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
        $this->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'));
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)
             ->display("home/chpsd.html");
    }
    public function dochpsd()
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
        if ($this->find(C('db_prefix') . "user", "string", "user='" . $user . "' and pass='" . md5(addslashes($_POST['oldpass'])) . "'")) {
            mysql_query("update " . C('db_prefix') . "user set  pass='" . md5(addslashes($_POST['newpass'])) . "'  where user='" . $user . "'");
            $this->assign('jumpurl', $this->youyax_url . "/Index" . C('default_url') . "chpsd" . C('static_url'))
                 ->assign('msgtitle', '操作成功')
                 ->assign('message', '密码更新成功！')
                 ->success();
        } else {
        		$this->assign('jumpurl', $this->youyax_url . "/Index" . C('default_url') . "chpsd" . C('static_url'))
                 ->assign('msgtitle', '操作错误')
                 ->assign('message', '原密码输入有误')
                 ->error();
        }
    }
    public function resize($filename)
    {
        $user = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
        $album       = "./Public/pic/upload";
        $filenameall = $album . "/" . $filename;
        // File and new size
        // Content type
        //		header('Content-type: image/jpeg');
        // Get new sizes
        list($width, $height) = getimagesize($filenameall);
        list($font, $back) = explode(".", $filename); //获取扩展名
        $newwidth  = 90;
        $newheight = 90;
        // Load
        $thumb     = imagecreatetruecolor($newwidth, $newheight);
        switch (strtolower($back)) {
            case 'gif':
                $source = imagecreatefromgif($filenameall);
                break;
            case 'jpg':
            case 'jpeg':
                $source = imagecreatefromjpeg($filenameall);
                break;
            case 'png':
                $source = imagecreatefrompng($filenameall);
                break;
            default:
                break;
        }
        // Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        // Output
        $name = time() . ".jpg";
        imagejpeg($thumb, $album . "/" . $name);
        
        $oldface  = mysql_fetch_array(mysql_query("select * from  " . C('db_prefix') . "user  where user='" . $user . "'"));
        $oldface2 = $oldface['face'];
        mysql_query("update " . C('db_prefix') . "user set  face='upload/" . $name . "'   where user='" . $user . "'");
        mysql_query("update " . C('db_prefix') . "talk set  face='upload/" . $name . "'   where zuozhe='" . $user . "'");
        mysql_query("update " . C('db_prefix') . "reply set  face1='upload/" . $name . "'   where zuozhe1='" . $user . "'");
        mysql_query("update " . C('db_prefix') . "mark2 set  pic='upload/" . $name . "'   where marker='" . $user . "'");
        mysql_query("update " . C('db_prefix') . "mark1 set  pic='upload/" . $name . "'   where marker='" . $user . "'");
        if (ereg("upload", $oldface2)) {
            @unlink("./Public/pic/$oldface2");
        }
        @unlink("./Public/pic/upload/$filename");
    }
    public function upload()
    {
        $album = "./Public/pic/upload";
        $user  = $_SESSION['youyax_user'];
        if ($user == "" || $user == null)
            $this->redirect("Index" . C('default_url') . "index" . C('static_url'));
        if (is_dir($album) != true) {
            mkdir($album);
        }
        if (isset($_FILES["file"]["tmp_name"])) {
            $filename = $_FILES["file"]["name"];
            list($font, $back) = explode(".", $filename); //获取扩展名
            $type=array('jpg','jpeg','png','gif');
            if(!in_array($back,$type)) exit;
            if (!preg_match("/^[\x4e00-\x9fa5]+$/", $font)) {
                echo "<script>alert('上传文件不能有中文,空格!');</script>";
                $this->redirect("Index/self" . C('static_url'));
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $album . "/" . $filename)) {
                    $this->resize($filename);
                    $this->assign('jumpurl', $this->youyax_url . "/Index" . C('default_url') . "self" . C('static_url'))
                         ->assign('msgtitle', '操作成功')
                         ->assign('message', '图片更新成功！')
                         ->success();
                } else {
                    echo "<script>alert('上传文件失败!');</script>";
                    echo "<script>history.back();</script>";
                }
            }
        }
    }
    public function showip()
    {
        $iparr = array();
        $query = mysql_query("select zone from " . C('db_prefix') . "online");
        while ($arr = mysql_fetch_array($query)) {
            $iparr[] = $arr['zone'];
        }
        echo json_encode($iparr);
    }
}
?>