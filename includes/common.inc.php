<?php

//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
}

//设置字符编码为utf-8
header('Content-Type:text/html;charset=utf-8');

//将绝对路径设置成常量
define('ROOT_PATH',substr(dirname(__FILE__),0,-9));

//创建一个自动转义状态的常量
define('GPC',get_magic_quotes_gpc());

//调用主函数库
require ROOT_PATH.'/includes/global.func.php';

//调用mysql函数库
require ROOT_PATH.'/includes/mysql.func.php';

//拒绝PHP低版本
if(PHP_VERSION<'4.1.0'){
    exit('PHP版本太低！');
}

//初始化数据库常量
define('DB_USER','root');
define('DB_PWD','960921');
define('DB_HOST','localhost');
define('DB_NAME','testguest');

//数据库连接
_connect();
_select_db();
_set_names();


//新消息提醒
//从数据库里获取cookie里对应的username，并且状态为未读的消息的条数，显示在header里
//COUNT取得之后符合条件的字段的数量
//count是自定义的键名

//在未登录状态没有$_COOKIE['username']就不显示
if(isset($_COOKIE['username'])){
    $_message=_fetch_array("SELECT COUNT(tg_id) AS count FROM tg_message WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");
    $_friend=_fetch_array("SELECT COUNT(tg_id) AS count FROM tg_friend WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");
    $_gift=_fetch_array("SELECT COUNT(tg_id) AS count FROM tg_gift WHERE tg_state=0 AND tg_touser='{$_COOKIE['username']}'");

    //如果消息的条数大于0，则建立$_x_html变量，在header里显示出来
    if($_message[0]['count']!=0){
        $_message_html=$_message[0]['count'];
    }

    if($_friend[0]['count']!=0){
        $_friend_html=$_friend[0]['count'];
    }

    if($_gift[0]['count']!=0){
        $_gift_html=$_gift[0]['count'];
    }

}

//网站系统设置工作
//从数据库读取系统设置
$_row=_fetch_array("SELECT * FROM tg_system WHERE tg_id=1 LIMIT 1");
if($_row){
    //var_dump($_row);
    $_system=array();
    foreach($_row as $_value1){
        foreach($_value1 as $_key=>$_value2){
            $_system[$_key]=$_value2;
        }
    }
    //var_dump($_system);


}else{
    exit('系统设置错误！');
}

?>
