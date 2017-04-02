<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','manage');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//检测有没有$_SESSION['admin']存在
if(!_manage_sate()){
    _location('没有管理员权限','./index.php');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>后台信息</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<script type="text/javascript">
    header();
</script>
<div id="member">
    <?php
    include './includes/manage.inc.php';
    ?>
    <div id="member_main">
        <h2>后台信息</h2>
        <dl>
            <dd>服务器主机名：<?php echo $_SERVER['SERVER_NAME']; ?></dd>
            <dd>服务器版本：<?php echo PHP_OS; ?></dd>
            <dd>通信协议名称/版本：<?php echo $_SERVER['SERVER_PROTOCOL']?></dd>
            <dd>服务器IP：<?php echo $_SERVER['SERVER_ADDR']; ?></dd>
            <dd>客户端IP：<?php echo $_SERVER['REMOTE_ADDR']; ?></dd>
            <dd>服务器端口：<?php echo $_SERVER['SERVER_PORT']; ?></dd>
            <dd>客户端端口：<?php echo $_SERVER['REMOTE_PORT']; ?></dd>
            <dd>HOST头部内容：<?php echo $_SERVER['HTTP_HOST']; ?></dd>
            <dd>服务器主目录：<?php echo $_SERVER['DOCUMENT_ROOT']; ?></dd>
            <dd>服务器系统盘：<?php echo $_SERVER['SystemRoot']; ?></dd>
            <dd>脚本执行目录：<?php echo $_SERVER['SCRIPT_FILENAME']; ?></dd>
            <dd>Apache/PHP版本：<?php echo $_SERVER['SERVER_SOFTWARE']; ?></dd>
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