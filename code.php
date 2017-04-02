<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','code');

//引入common，common已经调用了函数库文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//调用_code函数
//默认验证码大小：100*50，长度为4
//可以通过数据库的方法来设置验证码的各种属性
_code();

?>
