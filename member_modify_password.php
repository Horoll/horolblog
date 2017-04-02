<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','member_modify_password');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//接收、处理表单
if(_formvalue('action')=='modify_password'){

    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    if($_system['tg_code']==1) {
        //防止恶意注册和表单伪造跨站攻击，需要先验证验证码
        _check_code(_formvalue('code'), $_SESSION['code']);
    }

    //调用register函数库
    include ROOT_PATH.'/includes/register.func.php';

    //检查安全问题回答是否正确
    $_row_answer=_fetch_array("SELECT tg_question,tg_answer FROM tg_user WHERE tg_uniqid='{$_COOKIE['uniqid']}' LIMIT 1");

    $_clean['anwser']=_check_answer($_row_answer[0]['tg_question'],_formvalue('answer'));

    if ($_clean['anwser']!=$_row_answer[0]['tg_answer']){
        _alert_back('安全问题回答错误');
    }

    //创建一个数组，用来存放提交的合法数据
    $_clean=array();

    $_clean['password']=_comparison_password(_formvalue('password1'),_formvalue('password2'));

    _query("UPDATE tg_user SET
                              tg_password='{$_clean['password']}'
                           WHERE
                              tg_uniqid='{$_COOKIE['uniqid']}'
    ");

    //判断是否修改成功(只改动了一条数据)
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        _location('密码修改成功','member.php');
    }else{
        //关闭数据库
        _close();
        //跳转
        _location('密码修改失败','member_modify.php');
    }
}

//获取用户信息
$_row=_fetch_array("SELECT
                          tg_question
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
    <script type="text/javascript" src="javascript/member_modify_password.js"></script>
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
        <h2>修改密码</h2>
        <form method="post" action="member_modify_password.php">
            <input type="hidden" name="action" value="modify_password"/>
            <dl>
                <dd>你的安全问题：<?php echo $_html['tg_question']?></dd>
                <dd>请输入答案：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="answer" /></dd>
                <dd>请输入新的密码：<input type="password" name="password1" /></dd>
                <dd>请再次输入密码：<input type="password" name="password2" /></dd>
                <?php if($_system['tg_code']==1){?>
                <dd>验 证 码 ： <input type="text" name="code" id="codeinput"/><img src="code.php" id="code" /></dd>
                <?php }?>
                <input type="submit" value="修改密码" class="submit"/>
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