<?php
//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','logout');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//判断是否已经处于登录状态
if(!_login_sate()){
    _location('请先登录','./login.php');
}
//删除两个cookie和session
_cookie_destroy('username');
_cookie_destroy('uniqid');

//销毁管理员cookie
if(isset($_COOKIE['admin'])){
    _cookie_destroy('admin');
}

//返回主页面
_location(null,'./index.php');
?>
