<?php

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','member_message_detail');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//删除信息模块
$_GET['action']=isset($_GET['action'])?$_GET['action']:'';
if($_GET['action']=='delete'){

    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //删除单条信息
    _query("DELETE FROM tg_gift WHERE tg_id='{$_GET['id']}' LIMIT 1");

    //判断数据库里是否只改动了一条数据
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //跳转
        _location('删除成功','member_gift.php');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('删除失败');
    }
}

//从收信页面跳转
if(isset($_GET['id'])){
    $_row=_fetch_array("SELECT tg_fromuser,tg_content,tg_date FROM tg_gift WHERE tg_id='{$_GET['id']}' LIMIT 1");
    if(!$_row){
        _alert_back('该信息不存在');
    }
    foreach($_row as $value1){
        foreach($value1 as $key=>$value2) {
            $_html[$key] = _html($value2);
        }
    }

    //将未读信息标记为已读(state设置成1)
    if(empty($_html['tg_state'])){
        _query("UPDATE tg_gift SET tg_state=1 WHERE tg_id='{$_GET['id']}' LIMIT 1");
    }
}else{
    _alert_back('非法操作');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>礼物</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <script type="text/javascript" src="javascript/memeber_gift_detail.js"></script>
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
        <h2>礼物</h2>
        <dl>
            <dd>送 礼 人：<?php echo $_html['tg_fromuser']?></dd>
            <dd>信息内容：<strong><?php echo $_html['tg_content']?></strong></dd>
            <dd>发送时间：<?php echo $_html['tg_date']?></dd>
            <input type="button" value="返回列表" class="button" id="return" />
            <input type="button" value="删除礼物" class="button" id="delete" name="<?php echo $_GET['id'];?>"/>
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
