<?php
header('Content-type: text/html;charset=utf-8');
include('../ext_public/database.php');
$config = include('../Conf/config.php');
function js_unescape($str)
{
    $ret = '';
    $len = strlen($str);
    for ($i = 0; $i < $len; $i++) {
        if ($str[$i] == '%' && $str[$i + 1] == 'u') {
            $val = hexdec(substr($str, $i + 2, 4));
            if ($val < 0x7f)
                $ret .= chr($val);
            else if ($val < 0x800)
                $ret .= chr(0xc0 | ($val >> 6)) . chr(0x80 | ($val & 0x3f));
            else
                $ret .= chr(0xe0 | ($val >> 12)) . chr(0x80 | (($val >> 6) & 0x3f)) . chr(0x80 | ($val & 0x3f));
            $i += 5;
        } else if ($str[$i] == '%') {
            $ret .= urldecode(substr($str, $i, 3));
            $i += 2;
        } else
            $ret .= $str[$i];
    }
    return $ret;
}
mysql_query("SET NAMES 'utf8'");
$user = $_GET['username'];
if ($user == "" || $user == null) {
    echo "<FONT color=red>用户名不能为空！</FONT>";
    return;
}

$sql    = "select * from " . $config['db_prefix'] . "user where user='" . addslashes(js_unescape($user)) . "'";
$result = mysql_query($sql);
$num    = mysql_num_rows($result);
if ($num > 0) {
    echo "<font color=RED>该用户名已被人使用</font>";
    return false;
} else if ($num == 0) {
    echo "<font color=GREEN>该用户名未被人使用</font>";
} else {
    echo "<font color=RED>用户名验证程序出错</font>";
}
?>