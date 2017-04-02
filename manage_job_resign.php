<?php

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','manage_job_appoint');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//检测是否是管理员
if(!_manage_sate()){
    _location('没有管理员权限','./index.php');
}

//检测权限是否是超级管理员
$_row=_fetch_array("SELECT tg_level FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1");
if($_row[0]['tg_level']<=1){
    _alert_back('没有权限执行此操作');
}

//任命管理员
if(_formvalue('action')=='resign'){
    //检验唯一标识符
    _uniqid();

    //调用register数库,在程序中最好用include函数调用
    include ROOT_PATH.'/includes/register.func.php';

    //检验提交的用户名
    $_clean['username']=_check_username(_formvalue('username'));

    $_row=_fetch_array("SELECT tg_level FROM tg_user WHERE tg_username='{$_clean['username']}' LIMIT 1 ");

    if(!$_row){
        _alert_back('该用户不存在');
    }

    if($_row[0]['tg_level']==0){
        _alert_back('该用户不是管理员');
    }else{
        //修改数据库
        _query("UPDATE tg_user SET tg_level=0 WHERE tg_username='{$_clean['username']}' LIMIT 1");

        //判断数据库里是否只改动（新增）了一条数据
        if(_affected_rows()==1){
            //关闭数据库
            _close();
            //关闭窗口
            _alert_close('辞退管理员成功');
        }else{
            //关闭数据库
            _close();
            //跳转
            _alert_back('辞退管理员失败');
        }
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>辞退管理员</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <link rel="stylesheet" type="text/css" href="style/<?php echo SCRIPT;?>.css" />
</head>
<body>
<div>
    <h1>辞退管理员</h1>
    <form method="post" action="manage_job_resign.php">
        <input type="hidden" name="action" value="resign" />
        <dl>
            <dd><input type="text" name="username" placeholder="请输入用户名" id="text" /></dd>
            <dd><input type="submit" value="辞&nbsp;&nbsp;退" id="sub" /><dd>
        </dl>
    </form>
</div>
</body>
</html>