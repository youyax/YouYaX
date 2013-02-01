<?php
class ListAction extends YouYaX
{
    public function transform($txt)
    {
        $txt      = htmlspecialchars($txt, ENT_QUOTES, "UTF-8");
        //$txt=str_replace('&amp;','&', $txt);
        //$txt=str_replace(' ', '&nbsp;', $txt);
        $huanhang = array(
            "\r\n",
            "\n",
            "\r"
        );
        $txt      = str_replace($huanhang, '<br>', $txt);
        /*字体替换*/
        if(preg_match_all("/\[face=(.*?)](.+?)\[\/face]/is", $txt, $face)){
        	for ($i = 0; $i < sizeof($face[0]); $i++) {
            $tmp = preg_replace("/\[face=(.*?)](.+?)\[\/face]/is", '<span style="font-family:' . $face[1][$i] . '">' . $face[2][$i] . '</span>', $face[0][$i]);
            $txt = str_replace($face[0][$i], $tmp, $txt);
          }
        }
        /*--字体替换*/
        
        /*大小替换*/
        if(preg_match_all("/\[size=(.*?)](.+?)\[\/size]/is", $txt, $size)){
        	for ($i = 0; $i < sizeof($size[0]); $i++) {
            if (substr($size[1][$i], 0, 2) > 24)
                $size[1][$i] = "25px";
            $tmp = preg_replace("/\[size=(.*?)](.+?)\[\/size]/is", '<span style="font-size:' . $size[1][$i] . '">' . $size[2][$i] . '</span>', $size[0][$i]);
            $txt = str_replace($size[0][$i], $tmp, $txt);
          }
        }
        /*--大小替换*/
        
        /*加粗替换*/
        if(preg_match_all("/\[b](.+?)\[\/b]/is", $txt, $bold)){
        	for ($i = 0; $i < sizeof($bold[0]); $i++) {
            $tmp = preg_replace("/\[b](.+?)\[\/b]/is", '<span style="font-weight:bold">' . $bold[1][$i] . '</span>', $bold[0][$i]);
            $txt = str_replace($bold[0][$i], $tmp, $txt);
          }
        }
        /*--加粗替换*/
        
        /*倾斜替换*/
        if(preg_match_all("/\[i](.+?)\[\/i]/is", $txt, $tilt)){
        	for ($i = 0; $i < sizeof($tilt[0]); $i++) {
            $tmp = preg_replace("/\[i](.+?)\[\/i]/is", '<span style="font-style:italic">' . $tilt[1][$i] . '</span>', $tilt[0][$i]);
            $txt = str_replace($tilt[0][$i], $tmp, $txt);
          }
        }
        /*--倾斜替换*/
        
        /*下划线替换*/
        if(preg_match_all("/\[u](.+?)\[\/u]/is", $txt, $under)){
        	for ($i = 0; $i < sizeof($under[0]); $i++) {
            $tmp = preg_replace("/\[u](.+?)\[\/u]/is", '<span style="text-decoration:underline">' . $under[1][$i] . '</span>', $under[0][$i]);
            $txt = str_replace($under[0][$i], $tmp, $txt);
          }
        }
        /*--下划线替换*/
        
        /*颜色替换*/
        if(preg_match_all("/\[color=(.*?)](.+?)\[\/color]/is", $txt, $color)){
        	for ($i = 0; $i < sizeof($color[0]); $i++) {
            $tmp = preg_replace("/\[color=(.*?)](.+?)\[\/color]/is", '<span style="color:' . $color[1][$i] . '">' . $color[2][$i] . '</span>', $color[0][$i]);
            $txt = str_replace($color[0][$i], $tmp, $txt);
        	}
      	}
        /*--颜色替换*/
        
        /*超链接替换*/
        if(preg_match_all("/\[url=(.*?)](.+?)\[\/url]/is", $txt, $Hyperlink)){
        	for ($i = 0; $i < sizeof($Hyperlink[0]); $i++) {
        	if(!preg_match_all("/javascript:/is",strtolower($Hyperlink[1][$i]),$tmp)){
            $tmp = preg_replace("/\[url=(.*?)](.+?)\[\/url]/is", '<a style="text-decoration:underline" href="' . $Hyperlink[1][$i] . '">' . $Hyperlink[2][$i] . '</a>', $Hyperlink[0][$i]);
            $txt = str_replace($Hyperlink[0][$i], $tmp, $txt);
          	}
        	}
      	}
        /*--超链接替换*/
        
        /*本地图片替换*/
        if(preg_match_all("/\[img=(.*?)]\[\/img]/is", $txt, $localimg)){
        	for ($i = 0; $i < sizeof($localimg[0]); $i++) {
        	$tmp_img = substr($localimg[1][$i],strrpos($localimg[1][$i],".")+1);
        	if(in_array($tmp_img,array('jpg','jpeg','png','gif','JPEG','JPG','PNG','GIF'))){
            $tmp = preg_replace("/\[img=(.*?)]\[\/img]/is", '<img src="' . $localimg[1][$i] . '">', $localimg[0][$i]);
            $txt = str_replace($localimg[0][$i], $tmp, $txt);
          	}
        	}
      	}
        /*--本地图片替换*/
        
        /*音乐替换*/
        if(preg_match_all("/\[music=(.*?)]\[\/music]/is", $txt, $music)){
        	for ($i = 0; $i < sizeof($music[0]); $i++) {
        	$tmp_mus = substr($music[1][$i],strrpos($music[1][$i],".")+1);
        	if(in_array($tmp_mus,array('mp3','MP3'))){
            $tmp = preg_replace("/\[music=(.*?)]\[\/music]/is", '<embed type="audio/midi" src="' . $music[1][$i] . '"></embed>', $music[0][$i]);
            $txt = str_replace($music[0][$i], $tmp, $txt);
          	}
        	}
      	}
        /*--音乐替换*/
        
        /*视频替换*/
        if(preg_match_all("/\[video=(.*?)]\[\/video]/is", $txt, $video)){
        	for ($i = 0; $i < sizeof($video[0]); $i++) {
            /*	$tmp=preg_replace("/\[video=(.*?)]\[\/video]/is",'<object type="application/x-shockwave-flash" data="'.$video[1][$i].'" width="450" height="300" >'.
            '<param name="movie" value="'.$video[1][$i].'"  />'.
            '<param name="quality" value="high" />'.
            '<param name="play" value="false" />'.
            '<param name="loop" value="false" />'.
            '<param name="menu" value="false" />'.
            '<param name="scale" value="default" />'.
            '<param name="wmode" value="transparent">',$video[0][$i]);
            */
          $tmp_vid = substr($video[1][$i],strrpos($video[1][$i],".")+1);
        	if(in_array($tmp_vid,array('swf','SWF'))){
            $tmp = preg_replace("/\[video=(.*?)]\[\/video]/is", '<param name="wmode" value="transparent"><embed wmode="transparent" src="' . $video[1][$i] . '" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="450" height="300"></embed>', $video[0][$i]);
            $txt = str_replace($video[0][$i], $tmp, $txt);
          	}
        	}
      	}
        /*--视频替换*/
        
        /*代码替换*/
        if(preg_match_all("/\[code=([^\[]*)](.+?)\[\/code]/is", $txt, $cod)){
					for ($i = 0; $i < sizeof($cod[0]); $i++) {
				    $txt = str_replace($cod[0][$i], '<pre><code style="line-height:20px;"  class='.$cod[1][$i].">" . $cod[2][$i] . '</code></pre>', $txt);
				  }
				}
				 /*--代码替换*/
        return $txt;
    }
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
        if (!is_numeric(getparam("f"))) {
            $this->assign("msgtitle", "操作错误!")
                 ->assign("message", "列表序号不为非数字!")
                 ->assign("jumpurl", C('SITE'))
                 ->error();
            exit;
        }
        $_SESSION['youyax_f'] = getparam("f");
        
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
        
        $_SESSION['youyax_id'] = 0; //用于记录浏览次数
        $zd_sql                = "select *  from " . C('db_prefix') . "talk left join (select * from " . C('db_prefix') . "reply order by num2 desc) " . C('db_prefix') . "reply  on " . C('db_prefix') . "talk.id=" . C('db_prefix') . "reply.rid and " . C('db_prefix') . "talk.parentid=" . C('db_prefix') . "reply.parentid2 where " . C('db_prefix') . "talk.parentid=" . (int) ($_SESSION['youyax_f'] + 10000) . "  group by id order by " . C('db_prefix') . "talk.timeup desc";
        $zd_data               = $this->select($zd_sql);
        $this->assign('zd_data', $zd_data);
        $count = mysql_num_rows(mysql_query("select * from " . C('db_prefix') . "talk where parentid=" . $_SESSION['youyax_f']));
        require("./ORG/Page/Fenye.class.php");
        $fenye = new Fenye($count, 20);
        $show  = $fenye->show();
        $show  = implode("&nbsp;", $show);
        $sql   = $fenye->listcon("select *  from " . C('db_prefix') . "talk left join (select * from " . C('db_prefix') . "reply order by num2 desc) " . C('db_prefix') . "reply  on " . C('db_prefix') . "talk.id=" . C('db_prefix') . "reply.rid and " . C('db_prefix') . "talk.parentid=" . C('db_prefix') . "reply.parentid2 where " . C('db_prefix') . "talk.parentid=" . $_SESSION['youyax_f'] . "  group by id order by " . C('db_prefix') . "talk.timeup desc");
        $data  = $this->select($sql);
        if (empty($data)) {
            $show = "";
        }
        $fsql       = "select szone from " . C('db_prefix') . "small_block where id=" . $_SESSION['youyax_f'];
        $f          = mysql_fetch_array(mysql_query($fsql));
        $tongji     = $this->tongji();
        $small_sql  = "select id,szone from " . C('db_prefix') . "small_block";
        $small_data = $this->select($small_sql);
        $this->assign('small_data', $small_data)
             ->assign('count', $tongji);
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)
             ->assign('f', $f)
             ->assign('data', $data)
             ->assign('page', $show)
             ->assign('bz', $bz)
             ->assign('user', $user)
             ->assign('site', C('SITE'))
             ->assign('seo_status', C('seo_set'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display('list/index.html');
    }
    public function logout()
    {
        $_SESSION['youyax_user'] = "";
        $_SESSION['youyax_bz']   = "";
        $this->assign('site', C('SITE'));
        echo "<script>window.location.href='" . C('SITE') . "';</script>";
    }
    public function fatie()
    {
        $user = $_SESSION['youyax_user'];
        $this->assign('user', $user)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display('list/fatie.html');
    }
    public function vote()
    {
        $user = $_SESSION['youyax_user'];
        $this->assign('user', $user)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display('list/vote.html');
    }
    public function insert1()
    {
        if (match($_SESSION['youyax_user'], "session_user")) {
            if ($_SESSION['youyax_user'] == addslashes($_POST['zuozhe'])) {
                $t1 = addslashes($_POST['zuozhe']);
                $t2 = mb_substr(addslashes($_POST['title']), 0, 30, 'utf-8');
                if (filter_var($t2, FILTER_VALIDATE_REGEXP, array(
                    "options" => array(
                        "regexp" => "/[<>]/"
                    )
                ))) {
                    echo "<script>alert('标题不允许出现< 、>字符!');</script>";
                    echo "<script>history.back();</script>";
                    exit;
                }
               $t3 = addslashes($_POST['content']);
               if (match($t3, "content")) {
                if (!empty($_POST['lival'])) {
                    $lival    = $_POST['lival'];
                    $li_count = count($lival);
                    if (match($li_count, "lival")) {
                        $vote_tmp = array();
                        $vote_arr = array();
                        for ($m = 0; $m < $li_count; $m++) {
                            $vote_tmp['options'] = mb_substr(htmlspecialchars($lival[$m], ENT_QUOTES, "UTF-8"), 0, 20, 'utf-8');
                            $vote_tmp['nums']    = 0;
                            $vote_arr[]          = $vote_tmp;
                        }
                        mysql_query("insert into " . C('db_prefix') . "vote(rid,comb) values(0,'" . addslashes(serialize($vote_arr)) . "')");
                        $voteid = mysql_insert_id();
                    }
                }
                    $t3 = $this->transform($t3);
                    if (preg_match_all("/<embed[^>]*?\/\s*>/", $t3, $arr)) {
                        $val = "";
                        foreach ($arr[0] as $v) {
                            if (!preg_match_all("/wmode\s*=\s*\'\s*transparent\s*\'/", $v, $arr2)) {
                                $v1 = preg_replace("/\/>/", " wmode='transparent' />", $v);
                                $v2 = preg_replace("/<embed src/", "<param name='wmode' value='transparent' /><embed src", $v1);
                                $t3 = str_replace($v, $v2, $t3);
                            }
                        }
                    }
                    $user = $this->find(C('db_prefix') . "user", "string", "user='" . $t1 . "'");
                    $t4   = $user['face'];
                    $t5   = $user['time'];
                    $t6   = $user['fatieshu'];
                    $t6   = $t6 + 1;
                    mysql_query("insert into " . C('db_prefix') . "talk(fatieshu1,timezc1,face,zuozhe,title,content,time1,timeup,parentid) values(" . $t6 . ",'" . $t5 . "','" . $t4 . "','" . $t1 . "','" . $t2 . "','" . $t3 . "',now(),now()," . $_SESSION['youyax_f'] . ")");
                    if (!empty($_POST['lival'])) {
                        $talkid = mysql_insert_id();
                        mysql_query("update " . C('db_prefix') . "vote set rid=" . $talkid . " where id='" . $voteid . "'");
                    }
                    mysql_query("update " . C('db_prefix') . "talk set face='" . $t4 . "',timezc1='" . $t5 . "', fatieshu1='" . $t6 . "'  where  zuozhe='" . $t1 . "'");
                    mysql_query("update " . C('db_prefix') . "reply set fatieshu2=" . $t6 . " where  zuozhe1='" . $t1 . "'");
                    mysql_query("update " . C('db_prefix') . "user set fatieshu=" . $t6 . " where  user='" . $t1 . "'");
                    $this->redirect("List".C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'));
                }
            } else {
                $_SESSION['youyax_user'] = "";
                $_SESSION['youyax_data'] = 0;
                echo "<script>alert('非法操作，请重新登陆');</script>";
                echo "<script>history.back();</script>";
            }
        }
    }
    public function insert2()
    {
        if (match($_SESSION['youyax_user'], "session_user")) {
            if ($_SESSION['youyax_user'] == addslashes($_POST['zuozhe1'])) {
                $t1 = addslashes($_POST['zuozhe1']);
                $t2 = addslashes($_POST['content']);
                if (match($t2, "content")) {
                    $t2 = $this->transform($t2);
                    if (preg_match_all("/\[quote](.+?)\[\/quote]/is", $t2, $quo)) {
                    				$quote_id2 		= trim($_SESSION['youyax_id2']);
                    			if(!empty($quote_id2)){
                    				$quote_result = $this->find(C('db_prefix') . "reply", "string", "id2=" . $quote_id2);
                    				preg_match_all("/<fieldset.*>.*<\/fieldset>/", $quote_result['content1'], $quo_result_tmp);
                    				$quote_result['content1']=$quo_result_tmp[0][0];
                    			}else{
                    				$quote_result['content1']='';
                    			}
                        for ($i = 0; $i < sizeof($quo[0]); $i++) {
                            $tmp = preg_replace("/\[quote](.+?)\[\/quote]/is", '<fieldset style="font-size: 12px;border: 1px solid #CCC;padding: 0 10px 10px;margin: 10px;overflow-x: hidden;word-wrap: break-word;"><legend>'.htmlspecialchars(trim($_SESSION['youyax_cite']), ENT_QUOTES, "UTF-8").'</legend>' . $quote_result['content1'].strip_tags($quo[1][$i]) . '</fieldset>', strip_tags($quo[0][$i]));
                            $t2  = str_replace($quo[0][$i], $tmp, $t2);
                        }
                        $huanhang = array(
                            "\r\n",
                            "\n",
                            "\r"
                        );
                        $t2       = str_replace($huanhang, '<br>', $t2);
                    }
                    if (preg_match_all("/<embed[^>]*?\/\s*>/", $t2, $arr)) {
                        $val = "";
                        foreach ($arr[0] as $v) {
                            if (!preg_match_all("/wmode\s*=\s*\'\s*transparent\s*\'/", $v, $arr2)) {
                                $v1 = preg_replace("/\/>/", " wmode='transparent' />", $v);
                                $v2 = preg_replace("/<embed src/", "<param name='wmode' value='transparent' /><embed src", $v1);
                                $t2 = str_replace($v, $v2, $t2);
                            }
                        }
                    }
                    //$t2=str_replace("'",'"',$t2);
                    $t3 = $_SESSION['youyax_talk_id'];
                    $recount_query = mysql_query("select num2,rid,id2 from " . C('db_prefix') . "reply where rid=" . $t3 . " order by id2 desc");
                    if ($recount_query) {
                        $recount_arr = mysql_fetch_array($recount_query);
                        $t4          = $recount_arr['num2'] + 1;
                    } else {
                        $t4 = 1;
                    }
                    $user = $this->find(C('db_prefix') . "user", "string", "user='" . $t1 . "'");
                    $t5   = $user['face'];
                    $t6   = $user['time'];
                    $t7   = $user['fatieshu'];
                    mysql_query("insert into " . C('db_prefix') . "reply(fatieshu2,timezc2,face1,zuozhe1,content1,rid,num2,time2,parentid2) values(" . $t7 . ",'" . $t6 . "','" . $t5 . "','" . $t1 . "','" . $t2 . "'," . $t3 . "," . $t4 . ",now()," . $_SESSION['youyax_f'] . ")");
                    mysql_query("update " . C('db_prefix') . "talk set timeup=now() where id=$t3");
                    mysql_query("update " . C('db_prefix') . "reply set face1='" . $t5 . "',timezc2='" . $t6 . "', fatieshu2='" . $t7 . "'  where  zuozhe1='" . $t1 . "'");
                    $this->redirect("Content".C('default_url') . "index" . C('default_url') . "id" . C('default_url') . $t3 . C('static_url') . "#" . $t4);
                }
            } else {
                $_SESSION['youyax_user'] = "";
                $_SESSION['youyax_data'] = 0;
                echo "<script>alert('非法操作，请重新登陆');</script>";
                echo "<script>history.back();</script>";
            }
        }
    }
    public function Quick()
    {
        switch ($_POST['action']) {
            case 0:
                if (!empty($_SESSION['youyax_user'])) {
                    $user = addslashes($_POST['auser0']);
                    $pass = md5(addslashes($_POST['apass0']));
                    $sql  = "select * from " . C('db_prefix') . "admin where user='" . $user . "' and pass='" . $pass . "'";
                    $num  = mysql_num_rows(mysql_query($sql));
                    if ($num > 0) {
                        $colors        = $_POST['colors'];
                        $topicid       = $_POST['topicid'];
                        $arr           = $this->find(C('db_prefix') . "talk", 'string', $topicid);
                        $title         = "<font color=" . $colors . ">" . strip_tags($arr['title']) . "</font>";
                        $data['title'] = addslashes($title);
                        $this->save($data, C('db_prefix') . "talk", $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                             ->assign('msgtitle', '操作成功')
                             ->assign('message', '主题颜色设置成功！')
                             ->success();
                    } else {
                    		$this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                             ->assign('msgtitle', '操作失败')
                             ->assign('message', '您没有管理员权限！')
                             ->error();
                    }
                } else {
                		$this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                         ->assign('msgtitle', '操作失败')
                         ->assign('message', '未登录用户没有权限！')
                         ->error();
                }
                break;
            case 1:
                if (!empty($_SESSION['youyax_user'])) {
                    $user = addslashes($_POST['auser1']);
                    $pass = md5(addslashes($_POST['apass1']));
                    $sql  = "select * from " . C('db_prefix') . "admin where user='" . $user . "' and pass='" . $pass . "'";
                    $num  = mysql_num_rows(mysql_query($sql));
                    if ($num > 0) {
                        $topicid          = $_POST['topicid'];
                        $arr              = $this->find(C('db_prefix') . "talk", 'string', $topicid);
                        $arr['title']     = preg_replace("/\[[^]]*]/", "", strip_tags($arr['title']));
                        $title            = "<font color=green>[置顶]</font>" . $arr['title'];
                        $arr['parentid']  = $arr['parentid'] > 10000 ? $arr['parentid'] : ($arr['parentid'] + 10000);
                        $data['parentid'] = (int) ($arr['parentid']);
                        $data['title']    = $title;
                        $this->save($data, C('db_prefix') . "talk", $topicid);
                        $data['parentid2'] = (int) ($arr['parentid']);
                        $this->save($data, C('db_prefix') . "reply", "rid=" . $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                             ->assign('msgtitle', '操作成功')
                             ->assign('message', '主题置顶成功！')
                             ->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                             ->assign('msgtitle', '操作失败')
                             ->assign('message', '您没有管理员权限！')
                             ->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                         ->assign('msgtitle', '操作失败')
                         ->assign('message', '未登录用户没有权限！')
                         ->error();
                }
                break;
            case 2:
                if (!empty($_SESSION['youyax_user'])) {
                    $user = addslashes($_POST['auser2']);
                    $pass = md5(addslashes($_POST['apass2']));
                    $sql  = "select * from " . C('db_prefix') . "admin where user='" . $user . "' and pass='" . $pass . "'";
                    $num  = mysql_num_rows(mysql_query($sql));
                    if ($num > 0) {
                        $topicid          = $_POST['topicid'];
                        $arr              = $this->find(C('db_prefix') . "talk", 'string', $topicid);
                        $data['parentid'] = $_POST['small_zone'];
                        $data['title']    = preg_replace("/\[[^]]*]/", "", strip_tags($arr['title']));
                        $this->save($data, C('db_prefix') . "talk", $topicid);
                        $data['parentid2'] = $_POST['small_zone'];
                        $this->save($data, C('db_prefix') . "reply", "rid=" . $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                             ->assign('msgtitle', '操作成功')
                             ->assign('message', '主题转移成功！')
                             ->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                             ->assign('msgtitle', '操作失败')
                             ->assign('message', '您没有管理员权限！')
                             ->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                         ->assign('msgtitle', '操作失败')
                         ->assign('message', '未登录用户没有权限！')
                         ->error();
                }
                break;
            case 3:
                if (!empty($_SESSION['youyax_user'])) {
                    $user = addslashes($_POST['auser3']);
                    $pass = md5(addslashes($_POST['apass3']));
                    $sql  = "select * from " . C('db_prefix') . "admin where user='" . $user . "' and pass='" . $pass . "'";
                    $num  = mysql_num_rows(mysql_query($sql));
                    if ($num > 0) {
                        $topicid = $_POST['topicid'];
                        $this->delete(C('db_prefix') . "talk", $topicid);
                        $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                             ->assign('msgtitle', '操作成功')
                             ->assign('message', '主题删除成功！')
                             ->success();
                    } else {
                        $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                             ->assign('msgtitle', '操作失败')
                             ->assign('message', '您没有管理员权限！')
                             ->error();
                    }
                } else {
                    $this->assign('jumpurl', $this->youyax_url . "/List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'))
                         ->assign('msgtitle', '操作失败')
                         ->assign('message', '未登录用户没有权限！')
                         ->error();
                }
                break;
        }
    }
    public function editupdate1()
    {
        if ($_SESSION['youyax_user'] == addslashes($_POST['zuozhe'])) {
            $id = addslashes($_POST['id']);
            if (!is_numeric($id)) {
                $this->assign("msgtitle", "操作错误!")
                     ->assign("message", "编辑序号不为非数字!")
                     ->assign("jumpurl", C('SITE'))
                     ->error();
                exit;
            }
            if (match($_POST['content'], "content")) {
                $content = $this->transform($_POST['content']);
								$_SESSION['youyax_f'] = $_SESSION['youyax_f'] > 10000 ? $_SESSION['youyax_f']-10000 : $_SESSION['youyax_f'];
                if ($this->find(C('db_prefix') . "talk", "string", "zuozhe='" . $_POST['zuozhe'] . "'  and id=" . $id)) {
                    $data['content'] = $content;
                    $this->save($data, C('db_prefix') . "talk", "zuozhe='" . $_POST['zuozhe'] . "'  and id=" . $id);
                    $this->redirect("List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'));
                } else {
                    echo "<script>alert('您似乎越权了!');</script>";
                    echo "<script>history.back();</script>";
                    exit;
                }
            }
        }
    }
    public function editupdate2()
    {
        if ($_SESSION['youyax_user'] == addslashes($_POST['zuozhe'])) {
            $id = addslashes($_POST['id2']);
            if (!is_numeric($id)) {
                $this->assign("msgtitle", "操作错误!")
                     ->assign("message", "编辑序号不为非数字!")
                     ->assign("jumpurl", C('SITE'))
                     ->error();
                exit;
            }
            if (match($_POST['content'], "content")) {
                $content = $this->transform($_POST['content']);
								$_SESSION['youyax_f'] = $_SESSION['youyax_f'] > 10000 ? $_SESSION['youyax_f']-10000 : $_SESSION['youyax_f'];
                if ($this->find(C('db_prefix') . "reply", "string", "zuozhe1='" . $_POST['zuozhe'] . "'  and id2=" . $id)) {
                    $data['content1'] = $content;
                    $this->save($data, C('db_prefix') . "reply", "zuozhe1='" . $_POST['zuozhe'] . "'  and id2=" . $id);
                    $this->redirect("List" . C('default_url') . "index" . C('default_url') . "f" . C('default_url') . $_SESSION['youyax_f'] . C('static_url'));
                } else {
                    echo "<script>alert('您似乎越权了!');</script>";
                    echo "<script>history.back();</script>";
                    exit;
                }
            }
        }
    }
}
?>