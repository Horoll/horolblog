<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','register');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否开放注册
if($_system['tg_register']==0){
    _location('尚未开放注册','./index.php');
}

//判断是否已经处于登录状态
if(_login_sate()){
    _location('登录状态下不能登录或注册','./index.php');
}


//判断表单是否提交
if(_formvalue('action')=='register'){

    if($_system['tg_code']==1){
        //防止恶意注册和表单伪造跨站攻击，需要先验证验证码
        _check_code(_formvalue('code'),$_SESSION['code']);
    }

    //调用register数库,在程序中最好用include函数调用
    include ROOT_PATH.'/includes/register.func.php';

    //创建一个数组，用来存放提交的合法数据
    $_clean=array();

    //验证并且存放唯一标识符，用于登陆时cookie验证
    $_clean['uniqid']=_check_uniqid(_formvalue('uniqid'),$_SESSION['uniqid']);
    //再生成一个唯一标识符，用来给用户进行激活处理
    $_clean['active']=_sha1_uniqid();
    //得到合法的用户名
    $_clean['username']=_check_username(_formvalue('username'));
    //得到加密的合法密码
    $_clean['password']=_comparison_password(_formvalue('password1'),_formvalue('password2'));
    //得到密码问题
    $_clean['question']=_check_question(_formvalue('question'));
    //得到加密的合法提示答案
    $_clean['answer']=_check_answer(_formvalue('question'),_formvalue('answer'));
    //得到性别
    $_clean['sex']=_check_sex(_formvalue('sex'));
    //得到合法的邮箱地址
    $_clean['email']=_check_email(_formvalue('email'));
    //得到合法的qq
    $_clean['qq']=_check_qq(_formvalue('qq'));

    //判断用户名是否已经存在
    $sql="SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'LIMIT 1";
    _is_repeat($sql,'该用户名已被注册');

    //转义输入内容
    $_clean=_mysql_string($_clean);

    //在本地生成储存邮箱地址和激活码的cookie
    setcookie('email',$_clean['email']);
    setcookie('active',$_clean['active']);

    //添加用户信息到数据库
    _query(
        "INSERT INTO tg_user(
                             tg_uniqid,
                             tg_active,
                             tg_username,
                             tg_password,
                             tg_question,
                             tg_answer,
                             tg_sex,
                             tg_email,
                             tg_qq,
                             tg_reg_time,
                             tg_last_time,
                             tg_last_ip
                             )
                      VALUES(
                             '{$_clean['uniqid']}',
                             '{$_clean['active']}',
                             '{$_clean['username']}',
                             '{$_clean['password']}',
                             '{$_clean['question']}',
                             '{$_clean['answer']}',
                             '{$_clean['sex']}',
                             '{$_clean['email']}',
                             '{$_clean['qq']}',
                             NOW(),
                             NOW(),
                             '{$_SERVER['REMOTE_ADDR']}'
                           )"
    );

    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //获取上一步insert操作产生的id
        $_clean['id']=mysqli_insert_id($_conn);
        //关闭数据库
        _close();
        //生成xml
        _set_xml('new',$_clean);
        //跳转
        _location('注册成功','active.php?username='.$_clean['username']);
    }else{
        //关闭数据库
        _close();
        //跳转
        _location('注册失败','register.php');
    }
}

//使用唯一标识符来防止恶意攻击，注意要放在 if(submit)外面，否则两者会错位
$_SESSION['uniqid']=$_uniqid=_sha1_uniqid();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>用户注册</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <!-- 调用js文件 -->
    <script type="text/javascript" src="javascript/code.js"></script>
    <script type="text/javascript" src="javascript/register.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
    <div id="register">
        <h2>用户注册</h2>
        <form method="POST" action="register.php">
            <input type="hidden" name="action" value="register"/>
            <input type="hidden" name="uniqid" value="<?php echo $_uniqid; ?>"/>
            <dl>
                <dt>请填写用户信息</dt>
                <dd>用 户 名：<label class="text"><input type="text" name="username" />*</label></dd>
                <dd>密    码：<label class="text"><input type="password" name="password1" />*</label></dd>
                <dd>确认密码：<label class="text"><input type="password" name="password2" />*</label></dd>
                <dd>安全问题：<label class="text"><input type="text" name="question" />*</label></dd>
                <dd>问题答案：<label class="text"><input type="text" name="answer" />*</label></dd>
                <dd>性    别：<label id="sex1">男<input type="radio" name="sex" value="男" /></label>
                             <label id="sex2">女<input type="radio" name="sex" value="女" /></label></dd>
                <dd>电子邮箱：<label class="text"><input type="text" name="email" />*</label></dd>
                <dd> Q    Q：<label class="text2"><input type="text" name="qq" /></label></dd>
                <?php if($_system['tg_code']==1){?>
                <dd>验 证 码：<label id="cod"><input type="text" name="code" /></label><img src="code.php" id="code" /></dd>
                <?php }?>
                <dd><input type="submit"  name="register" value="注册" class="submit"/></dd>
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
