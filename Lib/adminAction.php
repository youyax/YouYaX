<?php
class adminAction extends YouYaX
{
    public function login()
    {
    		$this->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/login.html");
    }
    public function validate()
    {
        $user = addslashes($_POST['user']);
        $pass = md5(addslashes($_POST['pass']));
        $sql  = "select * from " . C('db_prefix') . "admin where user='" . $user . "' and pass='" . $pass . "'";
        $num  = mysql_num_rows(mysql_query($sql));
        if ($num > 0) {
            $_SESSION['youyax_admin'] = $user;
            echo '<script>alert("登录成功~~~");</script>';
            $this->redirect("admin" . C('default_url') . "index" . C('static_url'));
        } else {
            echo '<script>alert("登录失败~~~");</script>';
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
    }
    public function logout()
    {
        unset($_SESSION['youyax_admin']);
        $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
    }
    public function index()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $this->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/index.html");
    }
    public function secindex()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $this->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/secindex.html");
    }
    public function tophead()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $this->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->assign('admin', $_SESSION['youyax_admin'])
             ->display("admin/tophead.html");
    }
    public function leftbar()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $this->assign('shtml', C('static_url'))
             ->assign('site', C('SITE'))
             ->assign('url', C('default_url'))
             ->display("admin/leftbar.html");
    }
    public function content()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $this->display("admin/content.html");
    }
    
    public function block()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $this->assign('site', C('SITE'));
        //$data=$this->select("select * from ".C('db_prefix')."big_block");
        $sql  = "select big.id,big.bzone from " . C('db_prefix') . "big_block big left join (select * from (select * from " . C('db_prefix') . "small_block order by ssort desc,szone desc)smalltmp group by smalltmp.bid ) tmp on big.id=tmp.bid order by tmp.ssort desc,big.id desc";
        $data = $this->select($sql);
        $this->assign("data", $data)
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/block.html");
    }
    public function delblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id      = getparam("id");
        $big_sql = "delete from " . C('db_prefix') . "big_block where id=" . $id;
        mysql_query($big_sql);
        $small_sql = "delete from " . C('db_prefix') . "small_block where bid=" . $id;
        mysql_query($small_sql);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "block" . C('static_url'));
    }
    public function editblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id   = $_POST["id"];
        $name = $_POST["bzone"];
        if (empty($name)) {
            $_SESSION['youyax_error'] = 2;
        } else {
            $t                        = T(C('db_prefix') . "big_block");
            $t2                       = $t->find($id);
            $t2->bzone                = $name;
            $_SESSION['youyax_error'] = 1;
            $t2->save();
        }
        $this->redirect("admin" . C('default_url') . "block" . C('static_url'));
    }
    public function addblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $name = $_POST["bzone"];
        if (!empty($name)) {
            $t        = T(C('db_prefix') . "big_block");
            $t->bzone = $name;
            $t->add();
            $_SESSION['youyax_error'] = 1;
        } else {
            $_SESSION['youyax_error'] = 2;
            echo '<script>alert("名称必填项");</script>';
        }
        $this->redirect("admin" . C('default_url') . "block" . C('static_url'));
    }
    public function sblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $this->assign('site', C('SITE'));
        $data = $this->select("select * from " . C('db_prefix') . "small_block where bid=" . getparam("id") . " order by ssort desc,szone desc");
        $this->assign("data", $data);
        $data1 = $this->select("select * from " . C('db_prefix') . "big_block");
        $this->assign("data1", $data1);
        $data3 = $this->find(C('db_prefix') . "big_block", "string", getparam("id"));
        $this->assign("data3", $data3)
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/sblock.html");
    }
    public function delsblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id        = getparam("id");
        $small_sql = "delete from " . C('db_prefix') . "small_block where id=" . $id;
        mysql_query($small_sql);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "block" . C('static_url'));
    }
    public function editsblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id    = $_POST["id"];
        $szone = $_POST["szone"];
        $mark  = $_POST["mark"];
        $bid   = $_POST["bid"];
        $ssort = $_POST['ssort'];
        //	 if(empty($szone)&&empty($mark)&&empty($bid)){
        //	 	$_SESSION['youyax_error']=2;
        // 	}else{
        $t     = T(C('db_prefix') . "small_block");
        $t2    = $t->find($id);
        if (!empty($szone))
            $t2->szone = $szone;
        if (!empty($mark))
            $t2->mark = $mark;
        if (!empty($bid))
            $t2->bid = $bid;
        if (!empty($ssort))
            $t2->ssort = $ssort;
        $_SESSION['youyax_error'] = 1;
        $t2->save();
        //	}
        $this->redirect("admin" . C('default_url') . "block" . C('static_url'));
    }
    public function addsblock()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $szone = $_POST["szone"];
        $mark  = $_POST["mark"];
        $bid   = $_POST["bid"];
        if (!empty($szone) && !empty($bid)) {
            $t        = T(C('db_prefix') . "small_block");
            $t->szone = $szone;
            $t->mark  = $mark;
            $t->bid   = $bid;
            $t->ssort = 0;
            $t->add();
            $_SESSION['youyax_error'] = 1;
        } else {
            $_SESSION['youyax_error'] = 2;
            echo '<script>alert("名称或隶属必填项");</script>';
        }
        $this->redirect("admin" . C('default_url') . "block" . C('static_url'));
    }
    public function admin()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        require("./ORG/Page/Fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "admin"));
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("&nbsp;", $showx);
        $sql    = $fenye->listcon("select * from " . C('db_prefix') . "admin order by id desc");
        $list   = $this->select($sql);
        $this->assign('data', $list)
             ->assign('page', $showx)
             ->assign('shtml', C('static_url'))
             ->assign('site', C('SITE'))
             ->assign('url', C('default_url'))
             ->display("admin/admin.html");
    }
    public function admin_add()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $user = addslashes($_POST['admin']);
        $pass = md5(addslashes($_POST['pass']));
        $arr  = $this->find(C('db_prefix') . "admin", "string", "user='" . $user . "'");
        if (empty($user) || empty($pass) || empty($_POST['ac'])) {
            $_SESSION['youyax_error'] = 2;
        } else {
            if ($_POST['ac'] == "add") {
                $t       = T(C('db_prefix') . "admin");
                $t->user = $user;
                $t->pass = $pass;
                $t->add();
                $_SESSION['youyax_error'] = 1;
            } elseif ($_POST['ac'] == "update") {
                if ($this->find(C('db_prefix') . "admin", "string", "user='" . $user . "'")) {
                    $data['pass'] = $pass;
                    $this->save($data, C('db_prefix') . "admin", "user='" . $user . "'");
                    $_SESSION['youyax_error'] = 1;
                } else {
                    $_SESSION['youyax_error'] = 2;
                }
            } else {
                $_SESSION['youyax_error'] = 2;
            }
        }
        $this->redirect("admin" . C('default_url') . "admin" . C('static_url'));
    }
    public function admin_del()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id = getparam("id");
        $t  = T(C('db_prefix') . "admin");
        $t2 = $t->find($id);
        $t2->delete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "admin" . C('static_url'));
    }
    public function mark1()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        require("./ORG/Page/Fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "mark1"));
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("&nbsp;", $showx);
        $sql    = $fenye->listcon("select * from " . C('db_prefix') . "mark1 order by id desc");
        $list   = $this->select($sql);
        $this->assign('data', $list)
             ->assign('page', $showx)
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->assign('site', C('SITE'))
             ->display("admin/mark1.html");
    }
    public function mark1_del()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id = getparam("id");
        $t  = T(C('db_prefix') . "mark1");
        $t2 = $t->find($id);
        $t2->delete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "mark1" . C('static_url'));
    }
    public function mark2()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        require("./ORG/Page/Fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "mark2"));
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("&nbsp;", $showx);
        $sql    = $fenye->listcon("select * from " . C('db_prefix') . "mark2 order by id desc");
        $list   = $this->select($sql);
        $this->assign('data', $list)
             ->assign('page', $showx)
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->assign('site', C('SITE'))
             ->display("admin/mark2.html");
    }
    public function mark2_del()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id = getparam("id");
        $t  = T(C('db_prefix') . "mark2");
        $t2 = $t->find($id);
        $t2->delete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "mark2" . C('static_url'));
    }
    public function reply()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        require("./ORG/Page/Fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "reply where id2!=1"));
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("&nbsp;", $showx);
        $sql    = $fenye->listcon("select * from " . C('db_prefix') . "reply  where id2!=1 order by id2 desc");
        $list   = $this->select($sql);
        $this->assign('list', $list)
             ->assign('page', $showx)
             ->assign('site', C('SITE'))
             ->assign('db_prefix', C('db_prefix'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/reply.html");
    }
    public function reply_del()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id = getparam("id2");
        $this->delete(C('db_prefix') . "reply", "id2=" . $id);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "reply" . C('static_url'));
    }
    public function talk()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        require("./ORG/Page/Fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "talk"));
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("&nbsp;", $showx);
        $sql    = $fenye->listcon("select * from " . C('db_prefix') . "talk order by id desc");
        $list   = $this->select($sql);
        $this->assign('list', $list)
             ->assign('page', $showx);
        $data1 = $this->select("select * from " . C('db_prefix') . "small_block");
        $this->assign("data1", $data1)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/talk.html");
    }
    public function movetalk()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id           = $_POST['id'];
        $t            = T(C('db_prefix') . "talk");
        $t2           = $t->find($id);
        $t2->parentid = $_POST['parentid'];
        $t2->save();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "talk" . C('static_url'));
    }
    public function talk_del()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id = getparam("id");
        $t  = T(C('db_prefix') . "talk");
        $t2 = $t->find($id);
        $t2->delete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "talk" . C('static_url'));
    }
    public function user()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        require("./ORG/Page/Fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "user"));
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("&nbsp;", $showx);
        $sql    = $fenye->listcon("select * from " . C('db_prefix') . "user order by id desc");
        $list   = $this->select($sql);
        $this->assign('data', $list)
             ->assign('page', $showx)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/user.html");
    }
    public function user_forbid()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id         = getparam("id");
        $t          = T(C('db_prefix') . "user");
        $t2         = $t->find($id);
        $t2->status = 2;
        $t2->save();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "user" . C('static_url'));
    }
    public function user_empty()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id   = getparam("id");
        $t    = T(C('db_prefix') . "user");
        $t2   = $t->find($id);
        $user = $t2->user;
        $this->delete(C('db_prefix') . "talk", "zuozhe='" . $user . "'");
        $this->delete(C('db_prefix') . "reply", "zuozhe1='" . $user . "'");
        $this->delete(C('db_prefix') . "mark1", "marker='" . $user . "'");
        $this->delete(C('db_prefix') . "mark2", "marker='" . $user . "'");
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "user" . C('static_url'));
    }
    public function user_unfor()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id         = getparam("id");
        $t          = T(C('db_prefix') . "user");
        $t2         = $t->find($id);
        $t2->status = 1;
        $t2->save();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "user" . C('static_url'));
    }
    public function user_del()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id = getparam("id");
        $t  = T(C('db_prefix') . "user");
        $t2 = $t->find($id);
        $t2->delete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "user" . C('static_url'));
    }
    public function setting()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $site_config = require("./Conf/site.config.php");
        $this->assign('site_config', $site_config)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/setting.html");
    }
    public function dosetting()
    {
        $site_config = require("./Conf/site.config.php");
        if (!empty($_POST['title'])) {
            $site_config['site_title'] = $_POST['title'];
        }
        $site_config['site_keywords']    = $_POST['keywords'];
        $site_config['site_description'] = $_POST['description'];
        $site_config['site_logo']        = $_POST['logo'];
        $site_config['site_foot']        = $_POST['foot'];
        $file                            = "<?php return " . var_export($site_config, true) . "; ?>";
        file_put_contents("./Conf/site.config.php", $file);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "setting" . C('static_url'));
    }
    public function mailset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $mail_config = require("./Conf/mail.config.php");
        $this->assign('mail_config', $mail_config)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/mailset.html");
    }
    public function domailset()
    {
        $mail_config                  = require("./Conf/mail.config.php");
        $mail_config['mail_Host']     = $_POST['host'];
        $mail_config['mail_Username'] = $_POST['huser'];
        $mail_config['mail_Password'] = $_POST['hpass'];
        $mail_config['mail_From']     = $_POST['ufrom'];
        $mail_config['mail_FromName'] = $_POST['uname'];
        $mail_config['mail_Subject']  = $_POST['utitle'];
        $mail_config['mail_Body']     = $_POST['ucon'];
        $file                         = "<?php return " . var_export($mail_config, true) . "; ?>";
        file_put_contents("./Conf/mail.config.php", $file);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "mailset" . C('static_url'));
    }
    public function seoset()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $config = require("./Conf/config.php");
        $this->assign('config', $config)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/seoset.html");
    }
    public function doseoset()
    {
        $config            = require("./Conf/config.php");
        $config['seo_set'] = $_POST['seostatus'];
        $file              = "<?php return " . var_export($config, true) . "; ?>";
        file_put_contents("./Conf/config.php", $file);
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "seoset" . C('static_url'));
    }
    public function talk_vote()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        require("./ORG/Page/Fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "vote"));
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("&nbsp;", $showx);
        $sql    = $fenye->listcon("select * from " . C('db_prefix') . "vote order by id desc");
        $list   = $this->select($sql);
        $this->assign('data', $list)
             ->assign('page', $showx)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/talk_vote.html");
    }
    public function talk_vote_del()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id = getparam("id");
        $t  = T(C('db_prefix') . "vote");
        $t2 = $t->find($id);
        $t2->delete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "talk_vote" . C('static_url'));
    }
    public function clear_vote(){
    	if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $sql="delete from " . C('db_prefix') . "vote where rid not in(select id from " . C('db_prefix') ."talk)";
        mysql_query($sql);
        $this->redirect("admin" . C('default_url') . "talk_vote" . C('static_url'));
    }
    public function vote_ip()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        require("./ORG/Page/Fenye.class.php");
        $countx = mysql_fetch_array(mysql_query("select count(*) as count from " . C('db_prefix') . "vote_ips"));
        $fenye  = new Fenye($countx['count'], 40);
        $showx  = $fenye->show();
        $showx  = implode("&nbsp;", $showx);
        $sql    = $fenye->listcon("select * from " . C('db_prefix') . "vote_ips order by id desc");
        $list   = $this->select($sql);
        $this->assign('data', $list)
             ->assign('page', $showx)
             ->assign('site', C('SITE'))
             ->assign('shtml', C('static_url'))
             ->assign('url', C('default_url'))
             ->display("admin/vote_ip.html");
    }
    public function vote_ip_del()
    {
        if (empty($_SESSION['youyax_admin'])) {
            $this->redirect("admin" . C('default_url') . "login" . C('static_url'));
        }
        $id = getparam("id");
        $t  = T(C('db_prefix') . "vote_ips");
        $t2 = $t->find($id);
        $t2->delete();
        $_SESSION['youyax_error'] = 1;
        $this->redirect("admin" . C('default_url') . "vote_ip" . C('static_url'));
    }
}
?>