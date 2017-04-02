<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','photo_add');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//必须是管理员才有权限使用
if(!_manage_sate()){
    _location('没有管理员权限','./index.php');
}

if(_formvalue('action')=='adddir'){

    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //检查相册路径是否存在
    if(!is_dir('photo')){
        mkdir('photo',0777);
    }

    //调用register函数库
    include ROOT_PATH.'/includes/register.func.php';

    //创建一个数组，用来存放提交的合法数据
    $_clean=array();
    $_clean['name']=_check_username(_formvalue('name'));
    $_clean['type']=_formvalue('type');
    //当选择加密时才检查密码长度,否则密码为空
    if($_clean['type']==1){
        $_clean['password']=_check_password(_formvalue('password'));
    }else{
        $_clean['password']='';
    }
    $_clean['content']=_check_content(_formvalue('content'),0,20);
    $_clean['dir']=time();
    $_clean=_mysql_string($_clean);
    //var_dump($_clean);

    //在photo目录下创建以当前时间戳为文件名的文件夹
    if(!is_dir('photo/'.$_clean['dir'])){
        mkdir('photo/'.$_clean['dir'],0777);
    }

    //将数据写入数据库
    _query(
        "INSERT INTO tg_dir(
                             tg_name,
                             tg_type,
                             tg_password,
                             tg_content,
                             tg_dir,
                             tg_date
                             )
                      VALUES(
                             '{$_clean['name']}',
                             '{$_clean['type']}',
                             '{$_clean['password']}',
                             '{$_clean['content']}',
                             '{$_clean['dir']}',
                             NOW()
                           )"
    );
    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //跳转
        _location('添加相册成功','photo.php');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('添加相册失败');
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>添加相册</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<script type="text/javascript" src="javascript/photo_add.js"></script>
    <div id="photo">
        <h2>添加相册</h2>
        <form method="post" action="photo_add.php">
            <input type="hidden" name="action" value="adddir"/>
            <dl>
                <dd>相册名称：<input type="text" name="name" class="text"/></dd>
                <dd>类型：<label><input type="radio" name="type" checked="checked" value="0" />  公开</label><label><input type="radio" name="type" value="1" />  加密</label></dd>
                <dd id="password">密码：<input type="password" name="password" class="text"/></dd>
                <dd>相册描述：<textarea name="content"></textarea></dd>
                <dd><input type="submit" value="添加相册" class="submit" /></dd>
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