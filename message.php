<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','message');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//发送信息
$_GET['action']=isset($_GET['action'])?$_GET['action']:'';
if($_GET['action']=='write'){
    if($_system['tg_code']==1) {
        //防止恶意注册和表单伪造跨站攻击，需要先验证验证码
        _check_code(_formvalue('code'), $_SESSION['code']);
    }
    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //调用register函数库
    include ROOT_PATH.'/includes/register.func.php';

    $_clean=array();
    $_clean['touser']=_formvalue('touser');
    $_clean['fromuser']=$_COOKIE['username'];
    $_clean['content']=_check_content($_POST['content']);

    //将提交的信息转义
    $_clean=_mysql_string($_clean);

    //检查touser 是否存在或者是否是本人
    $_row=_fetch_array("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['touser']}' LIMIT 1");
    if(!$_row){
        _alert_back('该用户不存在');
    }elseif ($_clean['touser']==$_COOKIE['username']){
        _alert_back('无法给自己发送信息');
    }

    //写入数据库
    _query("INSERT INTO
                          tg_message (
                          tg_touser,
                          tg_fromuser,
                          tg_content,
                          tg_date
                        )
                        VALUES(
                          '{$_clean['touser']}',
                          '{$_clean['fromuser']}',
                          '{$_clean['content']}',
                          NOW()
                        )
    ");
    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //跳转
        _alert_close('信息发送成功！');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('发送失败');
    }
    exit();
}

//获取id对应的username
if(isset($_GET['id'])){
    $_row=_fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1");
    if(!$_row){
        _alert_close('用户不存在');
    }
//    print_r($_row);
    $_html['touser']=_html($_row[0]['tg_username']);
}else{
    _alert_close('非法操作');
}

//判断touser是否是本人
if($_html['touser']==$_COOKIE['username']){
    _alert_close('无法给自己发送信息');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>发送信息</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <link rel="stylesheet" type="text/css" href="style/<?php echo SCRIPT;?>.css" />
    <script type="text/javascript" src="javascript/code.js"></script>
    <script type="text/javascript" src="javascript/message.js"></script>
</head>
<body>
<div id="message">
    <h3>发送信息</h3>
    <form method="post" action="?action=write">
        <dl>
            <dd>To:<input type="text" name="touser" value="<?php echo $_html['touser'];?>" class="text"></dd>
            <dd><textarea name="content"></textarea></dd>
            <?php if($_system['tg_code']==1){?>
            <dd id="cod">验 证 码 ： <input type="text" name="code" class="codeinput" /><img src="code.php" id="code" /></dd>
            <?php }?>
            <dd><input type="submit" value="发&nbsp;&nbsp;送" class="sub"/><dd>
        </dl>
    </form>
</div>
</body>
</html>