<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','member_modify');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}


//判断修改的信息是否合法
if(_formvalue('action')=='modify'){

    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    if($_system['tg_code']==1) {
        //防止恶意注册和表单伪造跨站攻击，需要先验证验证码
        _check_code(_formvalue('code'), $_SESSION['code']);
    }
    //调用register函数库
    include ROOT_PATH.'/includes/register.func.php';

    //创建一个数组，用来存放提交的合法数据
    $_clean=array();

    //得到合法的用户名
    $_clean['username']=_check_username(_formvalue('username'));
    //得到性别
    $_clean['sex']=_check_sex(_formvalue('sex'));
    //得到合法的邮箱地址
    $_clean['email']=_check_email(_formvalue('email'));
    //得到合法的qq
    $_clean['qq']=_check_qq(_formvalue('qq'));
    //获得签名和签名状态
    $_clean['switch']=_formvalue('switch');
    $_clean['autograph']=_check_content(_formvalue('autograph'),0,40);

    //判断修改后的用户名是否已经存在
    //当用户名被修改后才判断
    if($_clean['username']!=$_COOKIE['username']){
        $sql="SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'LIMIT 1";
        _is_repeat($sql,'该用户名已存在');
    }

    _query("UPDATE tg_user SET
                              tg_username='{$_clean['username']}',
                              tg_sex='{$_clean['sex']}',
                              tg_email='{$_clean['email']}',
                              tg_qq='{$_clean['qq']}',
                              tg_switch='{$_clean['switch']}',
                              tg_autograph='{$_clean['autograph']}'
                           WHERE
                              tg_uniqid='{$_COOKIE['uniqid']}'
    ");

    //判断是否修改成功(只改动了一条数据)
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //如果修改了用户名，删除以前的username cookie，生成新的cookie
        if($_clean['username']!=$_COOKIE['username']){
            _cookie_destroy('username');
            setcookie('username',$_clean['username'],time()+60*60*24*7);
        }
        _location('修改成功','member.php');
    }else{
        //关闭数据库
        _close();
        //跳转
        _location('没有修改任何资料','member_modify.php');
    }
}

//获取用户信息
$_row=_fetch_array("SELECT
                          tg_username,
                          tg_sex,
                          tg_email,
                          tg_qq,
                          tg_switch,
                          tg_autograph
                    FROM
                          tg_user
                    WHERE
                          tg_uniqid='{$_COOKIE['uniqid']}'
                          LIMIT 1");
if(!$_row){
    _alert_back('用户不存在');
}

//转义用户信息中的标签语言，让信息能在页面正常显示
foreach($_row as $_value1){
    foreach($_value1 as $key=>$value2){
        $_html[$key]=_html($value2);
    }
}
//var_dump($_html);

if($_html['tg_sex']=='男'){
    $_html['sex']='<label class="sex"><input type="radio" name="sex" value="男" class="check" checked="checked" />男</label> <label class="sex"><input type="radio" name="sex" value="女" class="check" />女</label>';
}else{
    $_html['sex']='<label class="sex"><input type="radio" name="sex" value="男" class="check" />男</label> <label class="sex"><input type="radio" name="sex" value="女" class="check"  checked="checked" />女</label>';
}

if($_html['tg_switch']==1){
    $_html['switch']='<label class="sign"><input type="radio" name="switch" value="1" class="check" checked="checked" />开启</label> <label class="sex"><input type="radio" name="switch" value="0" class="check" />关闭</label>';
}else{
    $_html['switch']='<label class="sign"><input type="radio" name="switch" value="1" class="check" />开启</label> <label class="sex"><input type="radio" name="switch" value="0" class="check"  checked="checked" />关闭</label>';
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
    <script type="text/javascript" src="javascript/code.js"></script>
    <script type="text/javascript" src="javascript/member_modify.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<div id="member">
    <?php
    include './includes/member.inc.php';
    ?>
    <div id="member_main">
        <h2>修改资料</h2>
        <img id="face" src="<?php echo _face_dir($_html['tg_username'])?>" alt="<?php echo $_html['tg_username']?>">
        <a  id="changeface" href="javascript:;">修改头像</a>
        <form method="post" action="member_modify.php">
            <input type="hidden" name="action" value="modify"/>
            <dl>
                <dd>用 户 名：<input type="text" name="username" value="<?php echo $_html['tg_username']; ?>" /><a href="member_modify_password.php">修改密码</a></dd>
                <dd>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：<?php echo $_html['sex']; ?></dd>
                <dd>签&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：<?php echo $_html['switch']; ?>
                    &nbsp;&nbsp;（可以使用ubb代码）
                    <p><textarea name="autograph"><?php echo $_html['tg_autograph'];?></textarea></p>
                </dd>
                <dd>电子邮箱：<input type="text" name="email" value="<?php echo $_html['tg_email'] ?>" /></dd>
                <dd>&nbsp;&nbsp;Q&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Q&nbsp;：<input type="text" name="qq" value="<?php echo $_html['tg_qq'] ?>" /></dd>
                <?php if($_system['tg_code']==1){?>
                <dd>验 证 码 ： <input type="text" name="code" id="codeinput"/><img src="code.php" id="code" /></dd>
                <?php }?>
                <input type="submit" value="修改资料" class="submit"/>
            </dl>
        </form>
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