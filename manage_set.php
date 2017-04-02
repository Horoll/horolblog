<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','manage_set');

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

//修改系统信息
if(_formvalue('action')=='set'){
    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    $_clean=array();
    $_clean['webname']=_formvalue('webname');
    $_clean['article']=_formvalue('article');
    $_clean['blog']=_formvalue('blog');
    $_clean['album']=_formvalue('album');
    $_clean['photo']=_formvalue('photo');
    $_clean['string']=_formvalue('string');
    $_clean['post']=_formvalue('post');
    $_clean['comment']=_formvalue('comment');
    $_clean['code']=_formvalue('code');
    $_clean['register']=_formvalue('register');
    $_clean=_mysql_string($_clean);
    //var_dump($_clean);

    //写入数据库
    _query("UPDATE tg_system SET
                                  tg_webname='{$_clean['webname']}',
                                  tg_article='{$_clean['article']}',
                                  tg_blog='{$_clean['blog']}',
                                  tg_album='{$_clean['album']}',
                                  tg_photo='{$_clean['photo']}',
                                  tg_string='{$_clean['string']}',
                                  tg_post='{$_clean['post']}',
                                  tg_comment='{$_clean['comment']}',
                                  tg_code='{$_clean['code']}',
                                  tg_register='{$_clean['register']}'
                              WHERE
                                  tg_id=1
                                  LIMIT 1
");

    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //跳转
        _location('系统修改成功','manage_set.php');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('没有任何数据被修改');
    }
}

//从数据库获取系统设置信息
$_rows=_fetch_array("SELECT * FROM tg_system WHERE tg_id=1 LIMIT 1");
if($_rows){
    //再循环外定义数组
    $_html=array();
    foreach($_rows as $_value1){
        foreach($_value1 as $_key=>$_value2){
            $_html[$_key]=$_value2;
        }
    }
    $_html=_html($_html);
    //var_dump($_html);

    //博客显示数量
    if($_html['tg_article']==10){
        $_html['article']='<select name="article" class="select"><option value="10" selected="selected">每页10篇</option><option value="15">每页15篇</option></select>';
    }elseif($_html['tg_article']==15){
        $_html['article']='<select name="article" class="select"><option value="10">每页10篇</option><option value="15" selected="selected">每页15篇</option></select>';
    }

    //用户显示数量
    if($_html['tg_blog']==20){
        $_html['blog']='<select name="blog" class="select"><option value="15">每页15个</option><option value="20" selected="selected">每页20个</option></select>';
    }elseif($_html['tg_blog']==15){
        $_html['blog']='<select name="blog" class="select"><option value="15" selected="selected">每页15个</option><option value="20">每页20个</option></select>';
    }

    //相册显示数量
    if($_html['tg_album']==16){
        $_html['album']='<select name="album" class="select"><option value="12">每页12个</option><option value="16" selected="selected">每页16个</option></select>';
    }elseif($_html['tg_album']==12){
        $_html['album']='<select name="album"" class="select"><option value="12" selected="selected">每页12个</option><option value="16">每页16个</option></select>';
    }

    //图片显示数量
    if($_html['tg_photo']==5){
        $_html['photo']='<select name="photo" class="select"><option value="5" selected="selected">每页5张</option><option value="10">每页10张</option></select>';
    }elseif($_html['tg_photo']==10){
        $_html['photo']='<select name="photo" class="select"><option value="5">每页5张</option><option value="10" selected="selected">每页10张</option></select>';
    }

    //发表博客时间间隔
    if($_html['tg_post']==30){
        $_html['post']='<label><input type="radio" name="post" value="30" checked="checked" />30秒</label><label><input type="radio" name="post" value="60" />1分钟</label><label><input type="radio" name="post" value="180" />3分钟</label>';
    }elseif($_html['tg_post']==60){
        $_html['post']='<label><input type="radio" name="post" value="30" />30秒</label><label><input type="radio" name="post" value="60" checked="checked" />1分钟</label><label><input type="radio" name="post" value="180" />3分钟</label>';
    }elseif($_html['tg_post']==180){
        $_html['post']='<label><input type="radio" name="post" value="30" />30秒</label><label><input type="radio" name="post" value="60" />1分钟</label><label><input type="radio" name="post" value="180"  checked="checked"/>3分钟</label>';
    }

    //发表评论时间间隔
    if($_html['tg_comment']==15){
        $_html['comment']='<label><input type="radio" name="comment" value="15" checked="checked" />15秒</label><label><input type="radio" name="comment" value="30" />30秒</label><label><input type="radio" name="comment" value="45" />45秒</label>';
    }elseif($_html['tg_comment']==30){
        $_html['comment']='<label><input type="radio" name="comment" value="15" />15秒</label><label><input type="radio" name="comment" value="30" checked="checked" />30秒</label><label><input type="radio" name="comment" value="45" />45秒</label>';
    }elseif($_html['tg_comment']==45){
        $_html['comment']='<label><input type="radio" name="comment" value="15" />15秒</label><label><input type="radio" name="comment" value="30" />30秒</label><label><input type="radio" name="comment" value="45"  checked="checked"/>45秒</label>';
    }

    //是否开启验证码
    if($_html['tg_code']==1){
        $_html['code']='<label><input type="radio" name="code" value="1" checked="checked" />开启</label><label><input type="radio" name="code" value="0" />关闭</label>';
    }elseif($_html['tg_code']==0){
        $_html['code']='<label><input type="radio" name="code" value="1" />开启</label><label><input type="radio" name="code" value="0" checked="checked" />关闭</label>';
    }

    //是否开放注册
    if($_html['tg_register']==1){
        $_html['register']='<label><input type="radio" name="register" value="1" checked="checked" />开启</label><label><input type="radio" name="register" value="0" />关闭</label>';
    }elseif($_html['tg_register']==0){
        $_html['register']='<label><input type="radio" name="register" value="1" />开启</label><label><input type="radio" name="register" value="0" checked="checked" />关闭</label>';
    }

}else{
    _alert_back('系统数据异常');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>系统设置</title>
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
        <h2>系统设置</h2>
        <form action="manage_set.php" method="post">
            <input type="hidden" name="action" value="set" />
            <dl>
                <dd>网站名称：<input type="text" name="webname" class="text" value="<?php echo $_html['tg_webname']?>" /></dd>
                <dd>主页每页文章显示数量： <?php echo $_html['article']?></dd>
                <dd>每页用户显示数量：<?php echo $_html['blog']?></dd>
                <dd>每页相册显示数量：<?php echo $_html['album']?></dd>
                <dd>每页图片显示数量：<?php echo $_html['photo']?></dd>
                <dd>非法字符过滤：<input type="text" name="string" class="text" value="<?php echo $_html['tg_string']?>" />&nbsp;&nbsp;&nbsp;*请用|隔开</dd>
                <dd>发表博客间隔：<?php echo $_html['post']?></dd>
                <dd>发表评论间隔：<?php echo $_html['comment']?></dd>
                <dd>是否启用验证码：<?php echo $_html['code']?></dd>
                <dd>是否开放注册：<?php echo $_html['register']?></dd>
                <input type="submit" value="修改系统设置" class="submit" />
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