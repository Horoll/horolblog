<?php

//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','friend');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//添加好友
$_GET['action']=isset($_GET['action'])?$_GET['action']:'';
if($_GET['action']=='add') {
    if($_system['tg_code']==1){
        //防止恶意注册和表单伪造跨站攻击，需要先验证验证码
        _check_code(_formvalue('code'), $_SESSION['code']);
    }
    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //调用register函数库
    include ROOT_PATH . '/includes/register.func.php';

    $_clean = array();
    $_clean['touser'] = _formvalue('touser');
    $_clean['fromuser'] = $_COOKIE['username'];
    $_clean['content'] = _check_content($_POST['content']);

    //将提交的信息转义
    $_clean = _mysql_string($_clean);

    //检查touser 是否存在或者是否是本人
    $_row=_fetch_array("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['touser']}' LIMIT 1");
    if(!$_row){
        _alert_back('该用户不存在');
    }elseif ($_clean['touser']==$_COOKIE['username']){
        _alert_back('无法添加自己为好友');
    }

    //数据库验证是否已经是好友,要判断两次(互为好友，申请人和接受人可以互换)。注意要加上加括号，否则优先级出错
    $_row=_fetch_array("SELECT
                                      tg_state
                                FROM
                                      tg_friend
                                WHERE
                                      (tg_touser='{$_clean['touser']}' AND tg_fromuser='{$_clean['fromuser']}')
                                OR
                                      (tg_touser='{$_clean['fromuser']}' AND tg_fromuser='{$_clean['touser']}')
                                LIMIT
                                      1
                     ");
    if($_row) {
        if ($_row[0]['tg_state'] == 0) {
            _alert_close('已经发送过好友申请');
        } elseif ($_row[0]['tg_state'] == 1) {
            _alert_close('你们已经是好友了');
        }
    }

    //添加好友信息
    _query("INSERT INTO
                          tg_friend
                           (
                          tg_touser,
                          tg_fromuser,
                          tg_content,
                          tg_date
                          )
              VALUES
                          (
                          '{$_clean['touser']}',
                          '{$_clean['fromuser']}',
                          '{$_clean['content']}',
                          NOW()
                          )
             ");
    //判断数据库里是否只改动（新增）了一条数据
    if (_affected_rows() == 1) {
        //关闭数据库
        _close();
        //跳转
        _alert_close('好友申请发送成功');
    }else {
        //关闭数据库
        _close();
        //跳转
        _alert_back('好友申请发送失败');
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
}else {
    _alert_close('非法操作');
}

//判断touser是否是本人
if($_html['touser']==$_COOKIE['username']){
    _alert_close('无法添加自己为好友');
}

//数据库验证是否已经是好友,要判断两次(互为好友，申请人和接受人可以互换)。注意要加上加括号，否则优先级出错
$_row=_fetch_array("SELECT
                                      tg_state
                                FROM
                                      tg_friend
                                WHERE
                                      (tg_touser='{$_html['touser']}' AND tg_fromuser='{$_COOKIE['username']}')
                                OR
                                      (tg_touser='{$_COOKIE['username']}' AND tg_fromuser='{$_html['touser']}')
                                LIMIT
                                      1
                     ");
if($_row){
    if($_row[0]['tg_state']==0){
        _alert_close('已经发送过好友申请');
    }elseif($_row[0]['tg_state']==1){
        _alert_close('你们已经是好友了');
    }
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
    <h3>添加好友</h3>
    <form method="post" action="?action=add">
        <dl>
            <dd>To:<input type="text" name="touser" value="<?php echo $_html['touser'];?>" class="text"></dd>
            <dd><textarea name="content">hi,加个好友吧..</textarea></dd>
            <?php if($_system['tg_code']==1){?>
            <dd id="cod">验 证 码 ： <input type="text" name="code" class="codeinput" /><img src="code.php" id="code" /></dd>
            <?php }?>
            <dd><input type="submit" value="发&nbsp;&nbsp;送" class="sub"/><dd>
        </dl>
    </form>
</div>
</body>
</html>