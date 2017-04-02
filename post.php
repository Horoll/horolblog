<?php
//打开session
session_start();


//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','post');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经处于登录状态
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//将博客写入数据库
if(_formvalue('action')=='post'){

    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //通过cookie的方法验证发帖的时间间隔
    if(isset($_COOKIE['post_time'])){
        if(!_timeinterval(time(),$_COOKIE['post_time'],$_system['tg_post'])){
            _alert_back('两次发表博客时间不得小于'.$_system['tg_post'].'秒');
        }
    }

    //通过数据库的方法验证发帖的时间间隔
    $_post_time=_fetch_array("SELECT tg_post_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1");
    if(!_timeinterval(time(),$_post_time[0]['tg_post_time'],$_system['tg_post'])){
        _alert_back('两次发表博客时间不得小于'.$_system['tg_post'].'秒');
    }

    //调用register数库,在程序中最好用include函数调用
    include ROOT_PATH.'/includes/register.func.php';

    //创建一个数组，用来存放提交的合法数据
    $_clean=array();
    //接收博客内容
    $_clean['username']=$_COOKIE['username'];
    $_clean['title']=_check_content(_formvalue('title'),2,40);
    $_clean['content']=_check_content(_formvalue('content'),10,99999);
    $_clean['tag']=_check_content(_formvalue('tag'),0,40);
    //转义输入内容
    $_clean=_mysql_string($_clean);
    //var_dump($_clean);

    //写入数据库
    _query("INSERT INTO tg_article
                          (
                            tg_username,
                            tg_tag,
                            tg_title,
                            tg_content,
                            tg_date
                          )
                    VALUES
                          (
                            '{$_clean['username']}',
                            '{$_clean['tag']}',
                            '{$_clean['title']}',
                            '{$_clean['content']}',
                            NOW()
                          )
          ");
    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //获取上一步insert操作产生的id
        $_clean['id']=mysqli_insert_id($_conn);
        //创建储存发帖时间的cookie，用于检测发帖间隔
        setcookie('post_time',time());
        //将最新的发帖时间戳写入数据库中
        $_now_time=time();
        _query("UPDATE tg_user SET tg_post_time=$_now_time WHERE tg_username='{$_clean['username']}'");
        //关闭数据库
        _close();
        //跳转
        _location('博客发表成功','article.php?id='.$_clean['id']);
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('博客发表失败');
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>发表博客</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <script type="text/javascript" src="javascript/post.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
    <div id="post">
        <h2>发表博客</h2>
        <form method="POST" action="post.php">
            <input type="hidden" name="action" value="post"/>
            <dl>
                <dd>标   题：<input type="text" name="title" id="title"/></dd>
                <dd>
                    <!--引入ubb-->
                    <?php include ROOT_PATH.'/includes/ubb.inc.php';?>
                    <textarea name="content"></textarea>
                </dd>
                <dd>标   签：<input type="text" name="tag" placeholder="请用逗号隔开" id="tag" /></dd>
                <dd><input type="submit"  name="register" value="发表" class="submit"/></dd>
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
