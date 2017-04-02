<?php
//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
}

if(!function_exists('_alert_back')) {
    exit('_alert_back函数不存在，请检查代码');
}

if(!function_exists('_mysql_string')) {
    exit('_mysql_string函数不存在，请检查代码');
}

/**
 * _check_username():过滤用户名
 * @access public
 * @param string $_username 输入的用户名
 * @param int $_min 最小长度，默认值2
 * @param int $_max 最大长度，默认值10
 * @return string   过滤、转义处理后的用户名
 */
function _check_username($_username,$_min=2,$_max=10){
    //去掉两边的空格
    $_username=trim($_username);

    //判断长度
    if(mb_strlen($_username,'utf-8')<$_min || mb_strlen($_username,'utf-8')>$_max){
        _alert_back('用户名长度错误');
    }

    //去掉特殊字符
    $_char_pattern='/[<>\'\"\ \ ]/';
    if(preg_match_all($_char_pattern,$_username)){
        _alert_back('用户名中不得含有特殊字符');
    }

    //将用户名转义输出，用于存到数据库
    return _mysql_string($_username);
}

/**
 * _check_password():过滤、检查、加密密码
 * @access public
 * @param string $_password 输入密码
 * @param int $_min_num      最短密码长度，默认只是6
 * @return string           返回加密后的密码
 */
function _check_password($_password,$_min_num=6){
    //判断密码
    if(strlen($_password)<6){
        _alert_back('密码长度不能小于'.$_min_num.'位');
    }
    //返回加密的密码
    return _mysql_string(md5(sha1($_password)));
}

/**
 * _check_time():返回密码是否保存的数值
 * @access public
 * @param string $_time 密码是否保存的数值
 * @return string
 */
function _check_time($_time){
    return _mysql_string($_time);
}

/**
 * _setcookies():建立两个用户登录的cookie
 * @access public
 * @param string $_username 用户名
 * @param string $_uniqid   唯一标识符
 * @param string $_time cookie存在时间
 */
function _setcookies($_username,$_uniqid,$_time=0){
    if($_time=='1'){
        //如果选择保存，则保存一个星期
        setcookie('username',$_username,time()+60*60*24*7);
        setcookie('uniqid',$_uniqid,time()+60*60*24*7);
    }else{
        //选择不保存，不设置时间，关闭浏览器时cookie就被销毁
        setcookie('username',$_username);
        setcookie('uniqid',$_uniqid);
    }
}

?>
