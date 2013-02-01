<?php
class validation extends Model
{
    /*
    required maxlength minlength email digital letter alpha
    */
    public $validation = array(
    	"rules"   => 
    						array(
    							//此处输入验证规则
        					'session_user' => array('required' => 'true'), 
        					'content'      => array('required' => 'true'), 
        					'lival'        => array('min' => 2, 'max' => 15), 
        					'vote'         => array('required' => 'true')
        				 ), 
       "messages"=>
       					 array(
    						 //此处输入错误提示信息
        					'session_user' => array('required' => '您没有权限发帖，请先登陆'), 
        					'content'      => array('required' => '内容不能为空'),
         					'lival'        => array('min' => '投票选项至少为2项', 'max' => '投票选项至多为15项'), 
         					'vote'         => array('required' => '投票选项不能为空')
                 )
    );
}
?>