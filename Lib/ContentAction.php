<?php
class ContentAction extends YouYaX
{
    public function index()
    {
        header("Content-Type:text/html; charset=utf-8");
        $id = getparam("id");
        $_SESSION['youyax_talk_id']=$id;
        if (!is_numeric($id)) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "内容序号不为非数字!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        }
        $talk  = T(C('db_prefix') . "talk");
        $talk2 = $talk->find($id);
        if (empty($talk2)) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "内容不存在!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        }
        $parentid             = $talk2->parentid;
        $_SESSION['youyax_f'] = $parentid;
        $parentid_tmp         = $parentid > 10000 ? $parentid - 10000 : $parentid;
        $vtitle               = $talk2->title;
        $user                 = $_SESSION['youyax_user'];
        
        if ($_SESSION['youyax_id'] == 0) {
            mysql_query("update " . C('db_prefix') . "talk set num1=num1+1 where id=$id");
        }
        require("./ORG/Page/fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "talk left join " . C('db_prefix') . "reply on " . C('db_prefix') . "talk.id=$id and " . C('db_prefix') . "reply.rid=$id where " . C('db_prefix') . "reply.rid is not null"));
        if ($_COOKIE['record'] == 'yellow2') {
            $fenye = new Fenye($countx['count'], 10);
        } else if ($_COOKIE['record'] == 'shallow') {
            $fenye = new Fenye($countx['count'], 15);
        } else {
            $fenye = new Fenye($countx['count'], 20);
        }
        $showx   = $fenye->show();
        $showx   = implode("&nbsp;", $showx);
        $sql     = $fenye->listcon("select * from " . C('db_prefix') . "talk left join " . C('db_prefix') . "reply on " . C('db_prefix') . "talk.id=$id and " . C('db_prefix') . "reply.rid=$id where " . C('db_prefix') . "reply.rid is not null order by time2");
        $results = $this->select($sql);
        if (empty($results)) {
            $results = $this->select("select *  from " . C('db_prefix') . "talk," . C('db_prefix') . "reply  where " . C('db_prefix') . "talk.id=$id and " . C('db_prefix') . "reply.fuzhuid=1");
            $showx   = "";
        }
        $data1 = array();
        foreach ($results as $row) {
            array_push($data1, $row);
        }
        
        $this->assign('showx', $showx)
             ->assign('data1', $data1)
             ->assign('data1_0', strip_tags($data1[0]['title']))
             ->assign('user', $user);
        $_SESSION['youyax_id'] = 1;
        
        $mark1 = $this->select("select * from " . C('db_prefix') . "mark1");
        $this->assign('mark1', $mark1);
        
        $mark2 = $this->select("select * from " . C('db_prefix') . "mark2");
        $this->assign('mark2', $mark2);
        $vote_nums = 0;
        if ($vote_arr = $this->find(C('db_prefix') . "vote", "string", "rid=" . $id)) {
            $vote_options = unserialize($vote_arr['comb']);
            $this->assign('vote_options', $vote_options);
            foreach ($vote_options as $vot) {
                $vote_nums += $vot['nums'];
            }
            $this->assign('vote_nums', $vote_nums)
                 ->assign('vid', $vote_arr['id']);
        }
        
        $fsql = "select szone from " . C('db_prefix') . "small_block where id=" . $parentid_tmp;
        $fq   = mysql_fetch_array(mysql_query($fsql));
        $this->assign('cid', $id)
             ->assign('fq', $fq)
             ->assign('fqlink', $parentid_tmp);
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display('content/index.html');
    }
    public function mark1()
    {
        $tid = $_POST['id'];
        if (!is_numeric($tid)) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "评分序号不为非数字!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        }
        $content = $_POST['t'];
        $marker  = $_POST['user'];
        if ($_SESSION['youyax_user'] == $marker) {
            $checkuser2 = T(C('db_prefix') . 'talk');
            $checkuser  = $checkuser2->find($tid);
            $check      = $checkuser->zuozhe;
            if ($marker == "") {
                echo "<script>alert('未登陆用户不能评分');</script>";
            } elseif ($marker == $check) {
                echo "<script>alert('您不能给自己评分');</script>";
            } else {
                $user   = $this->find(C('db_prefix') . "user", "string", "user='" . $marker . "'");
                $pic    = $user['face'];
                $result = $this->find(C('db_prefix') . "mark1", "string", "tid=" . $tid . " and marker='" . $marker . "'");
                if ($result) {
                    echo "<script>alert('您不能重复评分');</script>";
                } else {
                    mysql_query("insert into " . C('db_prefix') . "mark1(tid,marker,pic,count,content) values(" . $tid . ",'" . $marker . "','" . $pic . "',1,'" . $content . "')");
                }
            }
            echo "<script>window.parent.location.href='" . $this->youyax_url . "/Content" . C('default_url') . "index" . C('default_url') . "id" . C('default_url') . $tid . C('static_url') . "';</script>";
        }
    }
    public function mark2()
    {
        $tid = $_POST['id'];
        if (!is_numeric($tid)) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "评分序号不为非数字!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        }
        $rid     = $_POST['id2'];
        $content = $_POST['t'];
        $marker  = $_POST['user'];
        if ($_SESSION['youyax_user'] == $marker) {
            $checkuser = $this->find(C('db_prefix') . "reply", "string", "id2='" . $rid . "'");
            $check     = $checkuser['zuozhe1'];
            if ($marker == "") {
                echo "<script>alert('未登陆用户不能评分');</script>";
            } elseif ($marker == $check) {
                echo "<script>alert('您不能给自己评分');</script>";
            } else {
                $user   = $this->find(C('db_prefix') . "user", "string", "user='" . $marker . "'");
                $pic    = $user['face'];
                $result = $this->find(C('db_prefix') . "mark2", "string", "rid=" . $rid . "  and marker='" . $marker . "'");
                if ($result) {
                    echo "<script>alert('您不能重复评分');</script>";
                } else {
                    mysql_query("insert into " . C('db_prefix') . "mark2(tid,rid,marker,pic,count,content) values(" . $tid . "," . $rid . ",'" . $marker . "','" . $pic . "',1,'" . $content . "')");
                }
            }
            echo "<script>window.parent.location.href='" . $this->youyax_url . "/Content" . C('default_url') . "index" . C('default_url') . "id" . C('default_url') . $tid . C('static_url') . "';</script>";
        }
    }
    public function edit1()
    {
        $article1 = getparam("id");
        if (!is_numeric($article1)) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "编辑序号不为非数字!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        }
        $result1            = $this->find(C('db_prefix') . "talk", "string", $article1);
        $result1['content'] = preg_replace("/<fieldset.*>.*<\/fieldset>/", '', $result1['content']);
        $this->assign('result1', $result1);
        $user = $_SESSION['youyax_user'];
        if ($user != $result1['zuozhe']) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "您似乎越权了!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        } else {
            $this->assign('user', $user)
                 ->assign('site', C('SITE'))
                 ->assign('shtml', C('static_url'))
                 ->assign('url', C('default_url'))
                 ->display("content/edit1.html");
        }
    }
    public function edit2()
    {
        $article2 = getparam("id");
        if (!is_numeric($article2)) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "编辑序号不为非数字!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        }
        $result2             = $this->find(C('db_prefix') . "reply", "string", "id2=" . $article2);
        $result2['content1'] = preg_replace("/<fieldset.*>.*<\/fieldset>/", '', $result2['content1']);
        $this->assign('result2', $result2);
        $user = $_SESSION['youyax_user'];
        if ($user != $result2['zuozhe1']) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "您似乎越权了!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        } else {
            $this->assign('user', $user)
                 ->assign('site', C('SITE'))
                 ->assign('shtml', C('static_url'))
                 ->assign('url', C('default_url'))
                 ->display("content/edit2.html");
        }
    }
    public function Quote1()
    {
        $article1           = getparam("id");
        $result1            = $this->find(C('db_prefix') . "talk", "string", $article1);
        $result1['content'] = preg_replace("/<fieldset.*>.*<\/fieldset>/", '', $result1['content']);
        $this->assign('result1', $result1);
        $user = $_SESSION['youyax_user'];
        $this->assign('user', $user);
        if(!empty($result1)){
					$_SESSION['youyax_cite']=$result1['zuozhe'].'  发表于  '.$result1['time1'];
				}
//        $results = $this->select("select t.id,r.rid,r.num2 from " . C('db_prefix') . "talk t left join " . C('db_prefix') . "reply r on t.id=$article1 and r.rid=$article1 where r.rid is not null");
//        if (empty($results))
//            $results = $this->select("select t.id,r.rid,r.num2  from " . C('db_prefix') . "talk t," . C('db_prefix') . "reply r where t.id=$article1 and r.fuzhuid=1");
//        $results = array_sort($results, "num2", SORT_DESC);
//        $this->assign('results', $results[0]);
        $this->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("content/quote.html");
    }
    public function Quote2()
    {
        $article2            = getparam("id2");
        $article1            = getparam("id");
        $result2             = $this->find(C('db_prefix') . "reply", "string", "id2=" . $article2);
        $result2['content1'] = preg_replace("/<fieldset.*>.*<\/fieldset>/", '', $result2['content1']);
        $this->assign('result2', $result2);
        $user = $_SESSION['youyax_user'];
        $this->assign('user', $user);
        if(!empty($result2)){
					$_SESSION['youyax_cite']=$result2['zuozhe1'].'  发表于  '.$result2['time2'];
					$_SESSION['youyax_id2'] =$result2['id2'];
				}
//        $results = $this->select("select t.id,r.rid,r.num2 from " . C('db_prefix') . "talk t left join " . C('db_prefix') . "reply r on t.id=$article1 and r.rid=$article1 where r.rid is not null");
//        if (empty($results))
//            $results = $this->select("select t.id,r.rid,r.num2  from " . C('db_prefix') . "talk t," . C('db_prefix') . "reply r where t.id=$article1 and r.fuzhuid=1");
//        $results = array_sort($results, "num2", SORT_DESC);
//        $this->assign('results', $results[0]);
        $this->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("content/quote.html");
    }
    public function delreply()
    {
        if (!empty($_SESSION['youyax_user'])) {
            $rid = getparam("rid");
            if (!is_numeric($rid)) {
                exit;
            }
            $radmin = addslashes(getparam("radmin"));
            $rpass  = addslashes(getparam("rpass"));
            if ($this->find(C('db_prefix') . "admin", "string", "user='" . $radmin . "' and pass='" . md5($rpass) . "'")) {
                $this->delete(C('db_prefix') . "reply", "id2=" . $rid);
                echo "删除成功";
            } else {
                echo "您没有管理员权限";
            }
        } else {
            echo "未登录用户没有权限";
        }
    }
    public function userinfo()
    {
        header("Content-Type:text/html; charset=utf-8");
        $username      = $_POST["quser"];
        $user_result   = $this->find(C('db_prefix') . "user", "string", "user='" . $username . "'");
        $sql_talk      = "select  title,id  from " . C('db_prefix') . "talk where zuozhe='" . $username . "' order by id desc limit 0,10";
        $talk_result   = $this->select($sql_talk);
        $online_result = $this->find(C('db_prefix') . "online", "string", "user='" . $username . "'");
        if ($online_result) {
            $this->assign("onlineinfo", "当前在线")
                 ->assign("ipinfo", $online_result['zone']);
        } else {
            $this->assign("onlineinfo", "当前离线")
                 ->assign("ipinfo", '————');
        }
        $this->assign("uinfo", $user_result)
             ->assign("tinfo", $talk_result)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("content/userinfo.html");
    }
}
?>