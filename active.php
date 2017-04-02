<?php

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','active');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//引入email类
require dirname(__FILE__).'/includes/email.class.php';

//开始计时
$_start_time=_runtime();

//判断是否是从注册界面跳转而来
if(!isset($_GET['username'])){
    _alert_back('非法操作');
}

if(isset($_COOKIE['email']) && $_COOKIE['active']){
    //发送激活码邮件
    $url='http://10.2.130.178/project/Hrorl.blog/Horol.blog1.2/active_ok.php?action=ok&&active='.$_COOKIE['active'];
    $activationcode='激活码：'.$_COOKIE['active'];
    $smtpemailto=$_COOKIE['email'];
    $mailsubject='欢迎注册Horol.blog';
    $mailbody='<p>请点击以下链接激活你的账户：</p>
           <p><a href="'.$url.'">'.$activationcode.'</a></p>';
    if(!_send_mail($smtpemailto,$mailsubject,$mailbody)){
        _location('激活码邮件发送失败','register.php');
    }
    //销毁储存信息的cookie
    _cookie_destroy('email');
    _cookie_destroy('active');
}else{
    _alert_back('获取邮箱地址和激活码错误');
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
        <p>您好，<?php echo $_GET['username'];?></p>
        <p>注册码已发送至您的邮箱，请登陆邮箱进行激活..</p>
    </div>
    <?php
    //关闭数据库
    _close();

    //调用footer
    require ROOT_PATH.'/includes/footer.inc.php';
    ?>
</body>
</html>