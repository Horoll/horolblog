<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','article_modify');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经处于登录状态
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//处理提交的修改后的博客
if(_formvalue('action')=='modify'){
    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //调用register数库,在程序中最好用include函数调用
    include ROOT_PATH.'/includes/register.func.php';

    //创建一个数组，用来存放提交的合法数据
    $_clean=array();
    //接收博客内容
    $_clean['id']=_formvalue('id');
    $_clean['title']=_check_content(_formvalue('title'),2,40);
    $_clean['content']=_check_content(_formvalue('content'),10,99999);
    $_clean['tag']=_check_content(_formvalue('tag'),0,40);
    //转义输入内容
    $_clean=_mysql_string($_clean);
//    var_dump($_clean);

    //更改数据库里的数据
    _query("UPDATE tg_article SET
                                    tg_tag='{$_clean['tag']}',
                                    tg_title='{$_clean['title']}',
                                    tg_content='{$_clean['content']}',
                                    tg_last_modify_date=NOW()
                              WHERE
                                  tg_id='{$_clean['id']}'
              ");
    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //跳转
        _location('博客修改成功','article.php?id='.$_clean['id']);
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('博客修改失败');
    }
}

//获得博客的信息
if(isset($_GET['id'])){
    //按id寻找博客信息
    $_rows_blog=_fetch_array("SELECT
                                    tg_username,tg_title,tg_tag,tg_content
                              FROM
                                    tg_article
                              WHERE
                                    tg_id='{$_GET['id']}'
                              AND
                                    tg_reid=0 LIMIT 1");
    if(!$_rows_blog){
        _alert_back('博客不存在');
    }
    //var_dump($_rows_blog);

    //当博客作者和当前用户为同一人时才能修改
    if($_COOKIE['username']!=$_rows_blog[0]['tg_username']){
        _alert_back('你没有权限修改此博客');
    }

    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //在循环外定义$_html_blog数组，用于存放博客的信息
    $_html_blog=array();
    foreach($_rows_blog as $_value1){
        foreach($_value1 as $_key=>$_value2){
            //将博客信息经过_html函数转义
            $_html_blog[$_key]=_html($_value2);
        }
    }
    //var_dump($_html_blog);
}else{
    _alert_back('非法操作');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>修改博客</title>
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <script type="text/javascript" src="javascript/post.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
    <div id="post">
        <h2>修改博客</h2>
        <form method="POST" action="article_modify.php">
            <input type="hidden" name="action" value="modify"/>
            <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>
            <dl>
                <dd>标   题：<input type="text" name="title" value="<?php echo $_html_blog['tg_title'];?>" id="title"/></dd>
                <dd>
                    <!--引入ubb-->
                    <?php include ROOT_PATH.'/includes/ubb.inc.php';?>
                    <textarea name="content"><?php echo $_html_blog['tg_content'];?></textarea>
                </dd>
                <dd>标   签：<input type="text" name="tag" value="<?php echo $_html_blog['tg_tag'];?>" id="tag" /></dd>
                <dd><input type="submit"  name="register" value="修改" class="submit"/></dd>
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
