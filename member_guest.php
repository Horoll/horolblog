<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','member_guest');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//读取该用户的留言
if(isset($_COOKIE['username'])){

    //求出该用户的图片总数
    $_num=_num_rows("SELECT tg_id FROM tg_guest WHERE tg_touser='{$_COOKIE['username']}' ");

    //得到分页模块所需要的全局变量
    _pageinfo($_num,2);

    $_sql="SELECT
              *
      FROM
              tg_guest
      WHERE
              tg_touser='{$_COOKIE['username']}'
      ORDER BY
              tg_date
      DESC
              LIMIT $_pagenum,$_pagesize";
    $_row=_fetch_array($_sql);
    //var_dump($_row);

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>留言板</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<script type="text/javascript">header();</script>
<div id="member">
    <?php
    include './includes/member.inc.php';
    ?>
    <div id="member_main">
        <h2>留言板</h2>
        <?php
        $_html = array();
        foreach ($_row as $_value1)  {
        foreach ($_value1 as $_key => $_value2) {
        $_html[$_key] = _html($_value2);
        }
        //print_r($_html);
        ?>
        <dl>
            <dt class="fromuser"><?php echo $_html['tg_fromuser'];?>：</dt>
            <dd class="content"><?php echo $_html['tg_content'];?></dd>
            <dd class="date"><?php echo $_html['tg_date'];?></dd>
        </dl>
        <?php
        }
        //调用分页模块
        _paging();
        ?>
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