<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','member');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//获取用户信息
$_row=_fetch_array("SELECT tg_username,tg_sex,tg_email,tg_qq,tg_reg_time,tg_level,tg_switch,tg_autograph FROM tg_user WHERE tg_uniqid='{$_COOKIE['uniqid']}' LIMIT 1");
if(!$_row){
    _alert_back('用户不存在');
}

//转义用户信息中的标签语言，让信息能在页面正常显示
//先在循环外定义数组，防止在循环内反复定义浪费内存
$_html=array();
foreach($_row as $_value1){
    foreach($_value1 as $key=>$value2){
        $_html[$key]=_html($value2);
    }
}
switch($_html['tg_level']){
    case 0:
        $_html['tg_level']='用户';
        break;
    case 1:
        $_html['tg_level']='管理员';
        break;
    case 2:
        $_html['tg_level']='超级管理员';
        break;
    default:
        $_html['tg_level']='无法识别身份';
}
//print_r($_html);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<script type="text/javascript">header();</script>
<div id="member">
    <?php
    include './includes/member.inc.php';
    ?>
    <div id="member_main">
        <h2>个人资料</h2>
        <img src="<?php echo _face_dir($_html['tg_username'])?>" alt="<?php echo $_html['tg_username']?>">
        <dl>
            <dd>用 户 名：<?php echo $_html['tg_username']; ?></dd>
            <dd>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：<?php echo $_html['tg_sex']; ?></dd>
            <dd>签&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：<?php echo _ubb($_html['tg_autograph']).'&nbsp;&nbsp;'; if($_html['tg_switch']==1){echo '(使用)';}else {echo '(未使用)';}?></dd>
            <dd>电子邮箱：<?php echo $_html['tg_email']; ?></dd>
            <dd>&nbsp;&nbsp;Q&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q&nbsp;：<?php echo $_html['tg_qq']; ?></dd>
            <dd>注册时间：<?php echo $_html['tg_reg_time']; ?></dd>
            <dd>身&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;份：<?php echo $_html['tg_level']; ?></dd>
        </dl>
    </div>
</div>
<?php
//关闭数据库
_close();

//调用footer
require ROOT_PATH.'/includes/footer.inc.php';
?>
</body>
</html>