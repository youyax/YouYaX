<?php
function fname($param){
    $sql = "select szone from " . C('db_prefix') . "small_block where id='" . $param . "' or id='".($param-10000)."'";
    $arr = mysql_fetch_array(mysql_query($sql));
    return $arr['szone'];
}
function setdate($param){
	return date('Y-m-d H:i:s',$param);
}
?>