<?php
/**
 * File Name          : YouYa.php
 * Author             : xujinliang
 * Website            : http://www.youyax.com
 * Description        : The core of the YouYaX for PHP framework class files 
 * 
 数据库连接，选择数据库，类，类方法,loop,list,一维数组解析错，二维数组错，一维数组空，二维数组空,model
 
 */
class YouYaX
{
    public $array; //普通替换
    public $array_array; //一维数组
    public $array_two; //二维数组
    public $config;
    public $lang;
    public $array_url; //url地址栏参数
    public $youyax_url;
    function __construct()
    {
        $this->array       = array();
        $this->array_array = array(
            array()
        );
        $this->array_two   = array(); //二维数组
        $this->array_url   = array(); //url地址栏参数
        $this->config      = require("Conf/config.php");
        $this->config      = array_change_key_case($this->config);
        if ((!empty($this->config['db_host'])) && (!empty($this->config['db_user'])) && (!empty($this->config['db_name']))) {
            $db_host = $this->config['db_host'];
            $db_user = $this->config['db_user'];
            $db_pwd  = $this->config['db_pwd'];
            $db_name = $this->config['db_name'];
            try {
                $con = @mysql_connect($db_host, $db_user, $db_pwd);
                if (!$con)
                    throw new Exception('数据库连接失败！', "300");
            }
            catch (Exception $e) {
                $this->exception($e);
            }
            try {
                $selectdb = @mysql_select_db($db_name, $con);
                if (!$selectdb)
                    throw new Exception('选择数据库失败！', "301");
            }
            catch (Exception $e) {
                $this->exception($e);
            }
            mysql_query("SET NAMES UTF8");
        }
        if($this->config['seo_set']=='on'){
        	$script_name  = $_SERVER['SCRIPT_NAME'];
        	$script_name2 = substr($script_name,0,strpos($script_name,"/index.php"));
        	$this->youyax_url  = "http://" . $_SERVER['HTTP_HOST'] . $script_name2;
        }else{
        	$this->youyax_url  = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
        }
        if (isset($_SERVER['PATH_INFO'])) {
            $youyax_del_length  = strlen($_SERVER['PATH_INFO']) - strlen($this->config['static_url']) - 1;
            $youyax_url_address = substr($_SERVER['PATH_INFO'], 1, $youyax_del_length);
            $youyax_str         = preg_split("#" . $this->config['default_url'] . "#", $youyax_url_address, -1, PREG_SPLIT_NO_EMPTY);
            $youyax_array_param = array_slice($youyax_str, 2);
            if (sizeof($youyax_array_param) % 2 == 1) {
                $this->exception2();
            }
            for ($i = 0; $i < sizeof($youyax_array_param); $i = $i + 2) {
                $this->array_url[$youyax_array_param[$i]] = $youyax_array_param[$i + 1];
            }
        }
    }
    function exception2()
    {
        echo file_get_contents("Tpl/Public/exception2.html");
        exit;
    }
    function exception($e)
    {
        $info = new YouYaX();
        $info->assign('code', "系统异常编号: " . $e->getCode())->assign('msg', $e->getMessage());
        $info->display("Public/exception.html");
        exit;
    }
    function assign($obj, $quo)
    {
        if (is_array($quo)) {
            if (@is_array($quo[0])) {
                $this->array_two[$obj] = $quo;
            } else {
                $this->array_array[$obj] = $quo;
            }
        } else {
            $array2            = array();
            $key               = $obj;
            $obj               = $quo;
            $this->array[$key] = $obj;
        }
        return $this;
    }
    function deal($tp)
    {
        $txt = file_get_contents($tp);
        if (isset($_COOKIE['lang'])) {
            $this->lang                = require("lang/" . $_COOKIE['lang'] . "/lang.php");
            $this->array_array['lang'] = $this->lang;
        } else {
            if (!empty($this->config['default_language'])) {
                $this->lang                = require("lang/" . $this->config['default_language'] . "/lang.php");
                $this->array_array['lang'] = $this->lang;
            } else {
                $this->lang                = require("lang/cn/lang.php");
                $this->array_array['lang'] = $this->lang;
            }
        }
        if (getparam("l") != "" || getparam("l") != null) {
            $this->lang                = require("lang/" . getparam("l") . "/lang.php");
            $this->array_array['lang'] = $this->lang;
            setcookie("lang", getparam("l"), time() + 3600, "/");
        }
        
        //include替换
        $return = preg_match_all("/<\s*include\s+file=\"(.*)\"\s*>/", $txt, $inc);
        if ($return) {
            $inc1 = $inc[0]; //<include file="top.html">系列数组
            $inc2 = $inc[1]; //top.html 系列数组
            foreach ($inc2 as $v) {
                if (file_exists($v)) {
                    $sub = file_get_contents($v);
                    foreach ($inc1 as $v1) {
                        //区分大小写匹配
                        if (ereg($v, $v1)) {
                            $txt = str_replace($v1, $sub, $txt);
                        }
                    }
                } else {
                    exit("include标签解析出错!");
                }
            }
        }
        //--include替换
        //原样替换
        $return = preg_match_all("/<\s*original\s*>\s*(.+?)\s*<\s*\/original\s*>/s", $txt, $match);
        if ($return) {
            $ori = 0;
            foreach ($match[0] as $o0) {
                $match[1][$ori] = htmlspecialchars($match[1][$ori]);
                $match[1][$ori] = str_replace("|", "&#124;", $match[1][$ori]);
                $match[1][$ori] = str_replace("{", "&#123;", $match[1][$ori]);
                $match[1][$ori] = str_replace("}", "&#125;", $match[1][$ori]);
                $txt            = str_replace($match[0][$ori], $match[1][$ori], $txt);
                $ori++;
            }
        }
        //----原样替换
        //注释替换
        $return = preg_match_all("/<\s*comments\s*>\s*(.+?)\s*<\s*\/comments\s*>/s", $txt, $match);
        if ($return) {
            foreach ($match[0] as $v) {
                $txt = str_replace($v, '', $txt);
            }
        }
        //----注释替换
        //普通替换
        $return = preg_match_all('/\{(.*?)}/', $txt, $match);
        if ($return) {
            foreach ($match[0] as $v) {
                $x = strlen($v);
                $y = $x - 2;
                $z = substr($v, 1, $y);
                //	foreach($this->array as $v)
                //{
                if (array_key_exists($z, $this->array)) {
                    //if(in_array($v[$z],$v))
                    $txt = str_replace("{" . $z . "}", $this->array[$z], $txt);
                }
                //}
            }
        }
        //——普通替换
        //单个输出数组值
        //	var_dump($this->array_array);exit;
        $return = preg_match_all('/\{[^{$\s]*->[^{}\s]*}/', $txt, $single);
        if ($return) {
            foreach ($single[0] as $v) {
                $x   = strlen($v);
                $y   = $x - 2;
                $z   = substr($v, 1, $y); //title->0
                $z1  = preg_split('/->/', $z, -1, PREG_SPLIT_NO_EMPTY);
                $txt = str_replace($v, $this->array_array[$z1[0]][$z1[1]], $txt);
            }
        }
        //数组替换
        $return = preg_match_all("/<\s*loop\s*>\s*(.+?)\s*<\s*\/loop\s*>/s", $txt, $match);
        if ($return) {
            try {
                foreach ($match[1] as $lv) {
                    if (eregi("<\s*loop\s*>", $lv)) {
                        throw new Exception(htmlspecialchars("<loop>标签不能嵌套<loop>！"), "304");
                        break;
                    }
                }
            }
            catch (Exception $e) {
                $this->exception($e);
            }
            $result0 = $match[0]; //<loop><tr><td>{array}</td></tr></loop> 系列数组	<loop>{array2}</loop>	
            $result1 = $match[1]; //<tr><td>{array}</td></tr>    系列数组{array2}
            //var_dump($result1);exit;
            foreach ($result1 as $r1) {
                preg_match_all("/\{(.*)\}/", $r1, $match2);
                $result2 = $match2[0][0]; //{array}
                $result3 = $match2[1][0]; //array
                $result4 = $this->array_array[$result3]; //得到的数组
                try {
                    if (!is_array($result4))
                        throw new Exception(htmlspecialchars("<loop>标签解析出错，仅支持一维数组！"), "306");
                    /*
                    if(empty($result4))
                    throw new Exception(htmlspecialchars("<loop>解析一维数组值为空！"),"308");	
                    */
                }
                catch (Exception $e) {
                    $this->exception($e);
                }
                $result5 = '';
                //	unset($result5);   //result5 清零
                foreach ($result4 as $v) {
                    $result5 .= str_replace("{" . $result3 . "}", $v, $r1);
                }
                foreach ($result0 as $r0) {
                    if (ereg($result2, $r0))
                        $txt = str_replace($r0, $result5, $txt);
                }
            }
        }
        //--数组替换
        //__APP__     xxxx/index.php
        $txt         = str_replace("__APP__", $this->youyax_url, $txt);
        //__ROOT__    http:// localhost
        //  $youyax_url2="http://".$_SERVER['HTTP_HOST'];
        //  $txt=str_replace("__ROOT__",$youyax_url2,$txt);		
        
        //var_dump($inc);exit;
        $return = preg_match_all("/<\s*list\s*>\s*(.+?)\s*<\s*\/list\s*>/s", $txt, $tar); //二维数组
        if ($return) {
            try {
                foreach ($tar[1] as $vv) {
                    if (eregi("<\s*list\s*>", $vv)) {
                        throw new Exception(htmlspecialchars("<list>标签不能嵌套<list>！"), "305");
                        break;
                    }
                }
            }
            catch (Exception $e) {
                $this->exception($e);
            }
            $erwei1 = $tar[0]; //1st <list><tr><td>{array_two.id}</td><td>{array_two.user}</td></tr></list>    2nd <list><tr><td>{array_two2.id}</td><td>{array_two2.tt}</td></tr></list>  //一维数组
            //var_dump($erwei1);exit;
            $erwei2 = $tar[1]; //1st <tr><td>{array_two.id}</td><td>{array_two.user}</td></tr>    2nd <tr><td>{array_two2.id}</td><td>{array_two2.tt}</td></tr>
            //var_dump($erwei2);exit;		
            foreach ($erwei1 as $f2) {
                foreach ($erwei2 as $f1) { //未合
                    $final2 = "";
                    $final  = $f1;
                    //	dump($f1);
                    $f1_1   = preg_match_all("/\{(.+?)}/s", $f1, $f1_tmp);
                    //	dump($f1_tmp);exit;
                    //	$tar2=trim(strip_tags($f1));	//{array_two.id}{array_two.user}
                    //	$tar2=str_replace("}","}\s",$tar2);
                    //	$tar2=explode("\s",$tar2);
                    //	array_pop($tar2); //{array_two.id}{array_two.user}  $tar2数组形态
                    if ($f1_1) {
                        $tar2 = $f1_tmp[0];
                    }
                    $count = count($tar2);
                    //var_dump($tar2);exit;
                    $tar3  = $tar2[0]; //{array_two.id}
                    preg_match_all("/\{(.*)\}/", $tar3, $tt1);
                    try {
                        if (!ereg("\.", $tt1[1][0]))
                            throw new Exception(htmlspecialchars("<list>标签解析出错，仅支持二维数组！"), "307");
                    }
                    catch (Exception $e) {
                        $this->exception($e);
                    }
                    $str    = preg_split('/\./', $tt1[1][0], -1, PREG_SPLIT_NO_EMPTY);
                    //var_dump($str);exit;
                    $erwei4 = $str[0]; //array_two
                    $erwei5 = $str[1]; //1st id   2nd user
                    if (!empty($this->array_two[$erwei4])) {
                        foreach ($this->array_two[$erwei4] as $two) {
                            $i = 0; //循环标记
                            foreach ($tar2 as $v) {
                                $i++;
                                $tar33 = $v; //{array_two.id}
                                preg_match_all("/\{(.*)\}/", $tar33, $tt11);
                                $str1    = preg_split('/\./', $tt11[1][0], -1, PREG_SPLIT_NO_EMPTY);
                                //var_dump($str);exit;
                                $erwei44 = $str1[0]; //array_two
                                $erwei55 = $str1[1]; //1st id   2nd user
                                if (ereg("\|", $erwei55)) {
                                    $erwei55_tmp = explode("|", $erwei55);
                                    $final       = str_replace("{" . $erwei44 . "." . $erwei55 . "}", $erwei55_tmp[1]($two[$erwei55_tmp[0]]), $final);
                                    //var_dump($two[$erwei55]);exit;
                                    //var_dump($erwei2);exit;
                                } else {
                                    $final = str_replace("{" . $erwei44 . "." . $erwei55 . "}", $two[$erwei55], $final);
                                }
                                //var_dump($final);exit;
                            }
                            $final2 .= $final;
                            if ($i == $count)
                                $final = $f1;
                            //var_dump($final);exit;
                        }
                    }
                    //var_dump($final);exit;
                    //var_dump($final2);exit;
                    //if(ereg($f1,$f2))
                    if (strpos($f2, $f1)) {
                        $txt = str_replace($f2, $final2, $txt); //--二维数组结束
                    }
                }
            }
        }
        //var_dump($this->array_two[$erwei4]);exit;
        //链接替换可以选择性开启，和或符号"|"有干扰
        
        /*
        $txt=preg_replace("/\<\s*link\s*>/","<a href=",$txt);
        $txt=preg_replace("/\<\s*link\s+target=\'?_blank\'?>/","<a target='_blank' href=",$txt);
        $txt=preg_replace("/(?<!\|)\|(?!\|)/", '>', $txt);
        $txt=preg_replace("/<\s*\/link\s*>/","</a>",$txt);	
        */
        /*$return=preg_match_all("/<\?php\s+(([^?]|\?[^>])*)\s*\?>/is",$txt,$p);*/
        $return = preg_match_all("/<\s*php\s*>\s*(.+?)\s*<\s*\/php\s*>/s", $txt, $p);
        if ($return) {
            //var_dump($p);exit;
            $pnum = -1;
            foreach ($p[1] as $v) {
                ob_start();
                $pnum++;
                eval($v);
                $out = ob_get_clean();
                $txt = str_replace($p[0][$pnum], $out, $txt);
            }
        }
        eval("?>" . $txt);
    }
    public function display($tp)
    {
        //var_dump($this->array_two);exit('display');
        $tp = "Tpl/" . $tp;
        $this->deal($tp);
    }
    public function redirect($control)
    {
    	if($this->config['seo_set']=='on'){
        	$script_name  = $_SERVER['SCRIPT_NAME'];
        	$script_name2 = substr($script_name,0,strpos($script_name,"/index.php"));
        }else{
        	$script_name2 = $_SERVER['SCRIPT_NAME'];
        }
        $url = "http://" . $_SERVER['HTTP_HOST'] . $script_name2 . "/" . $control;
        echo "<script>window.location.href='" . $url . "';</script>";
    }
    /*-----------------------------------------数据库常规查询封装-------------------------------*/
    public function select($sql, $parameter = "")
    {
        $array_param = array();
        $result      = @mysql_query($sql);
        if (empty($parameter)) {
            while ($ar = @mysql_fetch_array($result)) {
                array_push($array_param, $ar);
            }
            return $array_param;
        } else {
            while ($ar = @mysql_fetch_array($result)) {
                array_push($array_param, $ar[$parameter]);
            }
            return $array_param;
        }
    }
    public function add($data = array(), $table)
    {
        mysql_query("set names utf8");
        $sql = "insert into " . $table . "(" . implode(",", array_keys($data)) . ") values('" . implode("','", array_values($data)) . "')";
        mysql_query($sql) or die(mysql_error());
    }
    public function find($table, $ext = "string", $param)
    {
        //在 param 中寻找与给定的正则表达式 pattern 所匹配的子串
        if (ereg("=", $param)) {
            $sql = "select * from " . $table . " where " . $param;
        } else {
            $param = "id=$param";
            $sql   = "select * from " . $table . " where " . $param;
        }
        $result = mysql_query($sql);
        $arr    = mysql_fetch_array($result);
        if (!empty($arr)) {
            switch ($ext) {
                case "number":
                    foreach ($arr as $k => $v) {
                        if (is_string($k)) {
                            unset($arr[$k]);
                        }
                    }
                    break;
                case "string":
                    foreach ($arr as $k => $v) {
                        if (is_numeric($k)) {
                            unset($arr[$k]);
                        }
                    }
                    break;
            }
        }
        return $arr;
    }
    public function save($data, $table, $param)
    {
        if (!ereg("[=><!]", $param))
            $param = "id=$param";
        foreach ($data as $k => $v) {
            $sql = "update " . $table . " set " . $k . "='" . $v . "' where " . $param;
            mysql_query($sql);
        }
    }
    public function delete($table, $param)
    {
        if (!ereg("[=><!]", $param))
            $param = "id=$param";
        $sql = "delete from " . $table . " where " . $param;
        mysql_query($sql);
    }
    /*-----------------------------------------数据库常规查询封装 end-------------------------------*/
    public function error($param = '')
    {
        $this->display("Public/error.html");
    }
    public function success($param = '')
    {
        $this->display("Public/success.html");
    }
    public function getparam($param)
    {
        if (in_array($param, array_keys($this->array_url))) {
            return $this->array_url[$param];
        }
    }
    public function validateTip($param, $_this)
    {
        $_this->assign('Tip', $param);
        $_this->display("Public/validation.html");
        exit;
    }
}
function getparam($param)
{
    $pa = new YouYaX();
    return $pa->getparam($param);
}
function dump($value)
{
    ob_start();
    var_dump($value);
    $out = ob_get_clean();
    echo "<pre>" . $out . "</pre>";
}

/*-----------------------------------------控制器入口类-------------------------------*/
class App
{
    static function run()
    {
        $model  = new validation();
        $config = require("Conf/config.php");
        if (empty($_SERVER['PATH_INFO'])) {
            if (empty($config['default_action'])) {
                try {
                    if (class_exists("IndexAction"))
                        $app = new IndexAction();
                    else
                        throw new Exception('无法加载模块Index!', "302");
                }
                catch (Exception $e) {
                    call_user_func(array(
                        "YouYaX",
                        'exception'
                    ), $e);
                }
            } else {
                try {
                    if (class_exists($config['default_action'] . "Action")) {
                        $class = $config['default_action'] . "Action";
                        $app   = new $class();
                    } else
                        throw new Exception('无法加载模块' . $config['default_action'], "302");
                }
                catch (Exception $e) {
                    call_user_func(array(
                        "YouYaX",
                        'exception'
                    ), $e);
                }
            }
            try {
                if (method_exists($app, 'index'))
                    $app->index();
                else
                    throw new Exception('无法加载方法index!', "303");
            }
            catch (Exception $e) {
                call_user_func(array(
                    "YouYaX",
                    'exception'
                ), $e);
            }
        } else {
            $str   = preg_split("#" . $config['default_url'] . "#", substr($_SERVER['PATH_INFO'], 1, strlen($_SERVER['PATH_INFO']) - strlen($config['static_url']) - 1), -1, PREG_SPLIT_NO_EMPTY);
            $class = $str[0] . "Action";
            try {
                if (class_exists($class))
                    $app = new $class();
                else
                    throw new Exception('无法加载模块' . $str[0] . '!', "302");
            }
            catch (Exception $e) {
                call_user_func(array(
                    "YouYaX",
                    'exception'
                ), $e);
            }
            try {
                if (method_exists($app, $str[1]))
                    $app->$str[1]();
                else
                    throw new Exception('无法加载方法' . $str[1], "303");
            }
            catch (Exception $e) {
                call_user_func(array(
                    "YouYaX",
                    'exception'
                ), $e);
            }
        }
    }
}
/*-----------------------------------------控制器入口类 end-------------------------------*/
function match($value, $field)
{
    $modelvalidation = new validation();
    return $modelvalidation->match($value, $field);
}
/*-----------------------------------------验证模型类-------------------------------*/
class Model
{
    public function match($val, $field)
    {
        header("Content-type: text/html; charset=utf-8");
        if (array_key_exists($field, $this->validation['rules']))
            $rules = $this->validation['rules'][$field];
        try {
            if (empty($rules))
                throw new Exception(htmlspecialchars("验证模型加载异常!"), "310");
        }
        catch (Exception $e) {
            call_user_func(array(
                "YouYaX",
                'exception'
            ), $e);
        }
        foreach ($rules as $k => $v) {
            if ($k == 'required' && $v == 'true') {
                $val = preg_replace("/\s*/", "", $val);
                $val = preg_replace("/&nbsp;*/", "", $val);
                if (empty($val) && $val != '0') {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'maxlength') {
                if (strlen($val) > $v) {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'minlength') {
                if (strlen($val) < $v) {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'max') {
                if ($val > $v) {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'min') {
                if ($val < $v) {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'email' && $v == 'true') {
                if (!preg_match('/^\w+@[a-zA-Z]+\.[a-zA-Z]{2,4}$/', $val)) {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'digital' && $v == 'true') {
                if (!preg_match('/^\d+$/', $val)) {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'letter' && $v == 'true') {
                if (!preg_match('/^[a-zA-Z]+$/', $val)) {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
            if ($k == 'alpha' && $v == 'true') {
                if (!preg_match('/^\w+$/', $val)) {
                    call_user_func(array(
                        "YouYaX",
                        'validateTip'
                    ), $this->validation['messages'][$field][$k], new YouYaX());
                }
            }
        }
        return true;
    }
}
/*-----------------------------------------验证模型类 end-------------------------------*/
/*-----------------------------------------数据库对象查询封装-------------------------------*/
class ActiveRecord
{
    public $table;
    public $data;
    public $obj;
    
    public function __construct($table)
    {
        $this->data  = array();
        $this->table = $table;
        $this->connect();
    }
    public function connect()
    {
        $config = array_change_key_case(require("Conf/config.php"));
        if ((!empty($config['db_host'])) && (!empty($config['db_user'])) && (!empty($config['db_name']))) {
            $db_host = $config['db_host'];
            $db_user = $config['db_user'];
            $db_pwd  = $config['db_pwd'];
            $db_name = $config['db_name'];
            $con     = mysql_connect($db_host, $db_user, $db_pwd);
            mysql_select_db($db_name, $con);
            mysql_query("SET NAMES UTF8");
        }
    }
    
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    
    public function add()
    {
        $sql = "insert into " . $this->table . "(" . implode(",", array_keys($this->data)) . ") values('" . implode("','", array_values($this->data)) . "')";
        mysql_query($sql);
        $callback = new ActiveRecord($this->table);
        return $callback;
    }
    
    public function find($id)
    {
        $data = mysql_query("select * from $this->table where id=" . $id);
        $num  = mysql_num_rows($data);
        if ($num) {
            $arr       = mysql_fetch_assoc($data);
            //$this->obj = new StdClass();
            $this->obj = new ARClass($this->table);
            foreach ($arr as $key => $value) {
                $this->obj->$key = $value;
            }
            return $this->obj;
        }
    }
    public function select($param = '')
    {
        $array = array();
        if ($param == '') {
            $res = mysql_query("select * from $this->table");
            while ($arr = mysql_fetch_array($res)) {
                $array[] = $arr;
            }
            return $array;
        } else {
            $data = split(",", $param);
            foreach ($data as $v) {
                $res = mysql_query("select * from $this->table where id=" . $v);
                $num = mysql_num_rows($res);
                if ($num) {
                    $arr     = mysql_fetch_array($res);
                    $array[] = $arr;
                }
            }
            return $array;
        }
    }
    public function save($obj)
    {
        foreach ($obj as $k => $v) {
            $sql = "update " . $this->table . " set " . $k . "='" . $v . "' where id=" . $obj->id;
            mysql_query($sql);
        }
        $callback = new ActiveRecord($this->table);
        return $callback;
    }
    public function delete($obj)
    {
        foreach ($obj as $k => $v) {
            $sql = "delete from " . $this->table . " where id=" . $obj->id;
            mysql_query($sql);
        }
        $callback = new ActiveRecord($this->table);
        return $callback;
    }
}

function T($table)
{
    $t = new ActiveRecord($table);
    return $t;
}

class ARClass
{
    public $table;
    public function __construct($table)
    {
        $this->table = $table;
    }
    public function save()
    {
        $save = new ActiveRecord($this->table);
        $save->save($this);
    }
    public function delete()
    {
        $save = new ActiveRecord($this->table);
        $save->delete($this);
    }
}
/*-----------------------------------------数据库对象查询封装 end-------------------------------*/

function C($param)
{
    $config = require("Conf/config.php");
    return $config[$param];
}
class Cache
{
    public $fileName;
    function __construct($time)
    {
        ob_start();
        $this->path = 'cache';
        if (!file_exists($this->path)) {
            mkdir($this->path);
        }
        $this->time     = $time;
        $this->fileType = 'php';
        $this->fileName = "./" . $this->path . "/" . md5($_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"]) . '.' . $this->fileType;
        if (file_exists($this->fileName) && ((filemtime($this->fileName) + $this->time) > time())) {
            $fp = fopen($this->fileName, "r");
            echo fread($fp, filesize($this->fileName));
            fclose($fp);
            ob_end_flush();
            exit;
        }
    }
    
    function endCache()
    {
        $fp = fopen($this->fileName, "w");
        fwrite($fp, ob_get_contents());
        fclose($fp);
        ob_end_flush();
    }
}
require("Common/common.php");
require("Common/common_ext.php");
?>