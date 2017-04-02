<?php

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','active_jump');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//当点击邮箱链接后，进行激活处理
if(isset($_GET['active'])&&isset($_GET['action'])&&$_GET['action']=='ok') {
    $_active = _mysql_string($_GET['active']);
    if (_fetch_array("SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")) {
        //将tg_active 设置为空，表示已经激活
        _query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
        if (_affected_rows()== 1) {
            _close();
        }else {
            _close();
            _alert_back('帐户激活失败');
        }
    }else {
        _alert_back('激活码不存在或账户已被激活');
    }
}else{
    _alert_back('非法操作');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>帐户激活</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<div id="active">
    <h2>帐户激活</h2>
    <p>已成功激活账户</p>
    <a href="login.php">现在登录</a>
</div>
<?php
//调用footer
require ROOT_PATH.'/includes/footer.inc.php';
?>
</body>
</html>