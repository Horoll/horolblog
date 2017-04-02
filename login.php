<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','login');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经处于登录状态
if(_login_sate()){
    _location('登录状态下不能登录或注册','./index.php');
}

//处理登录
if(_formvalue('action')=='login'){
    if($_system['tg_code']==1){

        if(isset($_SESSION['code'])){
            //防止恶意注册和表单伪造跨站攻击，需要先验证验证码
            _check_code(_formvalue('code'),$_SESSION['code']);
        }else{
            _location(null,'login.php');
        }
    }

    //调用register数库,在程序中最好用include函数调用
    include ROOT_PATH.'/includes/login.func.php';

    //创建一个数组，用来存放提交的合法数据
    $_clean=array();
    $_clean['username']=_check_username(_formvalue('username'));
    $_clean['password']=_check_password(_formvalue('password'));
    $_clean['time']=_check_time(_formvalue('time'));

    //连接数据进行验证
    //$_row[0][0]:tg_username,$_row[0][1]:tg_uniqid,$_row[0][2]:tg_password,$_row[0][3]:tg_active
    $_row=_fetch_array("SELECT tg_username,tg_uniqid,tg_password,tg_active,tg_level FROM `tg_user` WHERE tg_username='{$_clean['username']}' LIMIT 1");
    if($_row){
        if($_row[0]['tg_password']!=$_clean['password']){
            _close();
            _session_destroy();
            _alert_back('密码输入错误');
        }elseif($_row[0]['tg_active']!=''){
            _close();
            _alert_back('该账户没有激活');
        }else{
            //成功登录，更新登录信息
            _query("UPDATE tg_user SET tg_last_time=NOW(),tg_last_ip='{$_SERVER['REMOTE_ADDR']}' ,tg_login_count=tg_login_count+1 WHERE tg_username='{$_row[0]['tg_username']}'");
            //当登录的是管理员时，生成session
            if($_row[0]['tg_level']>=1){
                setcookie('admin',$_row[0]['tg_username'],time()+60*60*24*7);
            }
            //生成cookie
            _setcookies($_row[0]['tg_username'],$_row[0]['tg_uniqid'],$_clean['time']);
            _close();
            _location(null,'index.php');
        }
    }else{
        _close();
        _alert_back('用户名不存在');
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <!-- 调用js文件 -->
    <script type="text/javascript" src="javascript/code.js"></script>
    <script type="text/javascript" src="javascript/login.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
    <div id="login">
        <h2>登录</h2>
        <form method="POST" action="login.php">
            <input type="hidden" name="action" value="login"/>
            <dl>
                <dt>请填写用户信息</dt>
                <dd>用 户 名：<label class="text"><input type="text" name="username" /></label></dd>
                <dd>密    码：<label class="text"><input type="password" name="password" /></label></dd>
                <dd>保存密码：<label id="choice1">保存<input type="radio" name="time" value="1" checked="checked" /></label>
                              <label id="choice2">不保存<input type="radio" name="time" value="0" /></label></dd>
                <?php     if($_system['tg_code']==1){?>
                    <dd>验 证 码：<label id="cod"><input type="text" name="code" /></label><img src="code.php" id="code" /></dd>
                <?php }?>
                <dd><input type="submit"  name="login" value="登录" class="submit"/></dd>
            </dl>
        </form>
    </div>
    <?php
    //关闭数据库
    _close();

    //调用footer
    require ROOT_PATH.'/includes/footer.inc.php';
    ?>
</body>
</html>
