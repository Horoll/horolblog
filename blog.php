<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','blog');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//求出用户人数
$_num=_num_rows("SELECT tg_id FROM tg_user");

//得到分页模块所需要的全局变量
_pageinfo($_num,$_system['tg_blog']);


//从数据库提取用id、用户名、性别,获取一个数组$_row
//按照最近登录时间排序,从第$_pagenum+1个开始，每页20个用户
$_sql="SELECT tg_id,tg_username,tg_sex FROM tg_user ORDER BY tg_last_time DESC LIMIT $_pagenum,$_pagesize";
$_row=_fetch_array($_sql);
//print_r($_row);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>用户列表</title>
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <script type="text/javascript" src="javascript/blog.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
    <div id="blog">
        <h2>用户列表</h2>
        <?php
        $_html=array();
        foreach($_row as $value1){
            foreach($value1 as $key=>$value2){
                $_html[$key]=_html($value2);
            }
            ?>
        <dl>
            <dd class="user"><?php echo $_html['tg_username']; ?> (<?php echo $_html['tg_sex']; ?>)</dd>
            <dt> <img src="<?php echo _face_dir($_html['tg_username'])?>" alt="<?php echo $_html['tg_username']; ?>" /></dt>
            <dd class="info" id="message"><a href="javascript:;" name="message" title="<?php echo $_html['tg_id'];?>">发送信息</a></dd>
            <dd class="info" id="gift"><a href="javascript:;" name="gift" title="<?php echo $_html['tg_id'];?>">送礼物</a></dd>
            <dd class="info" id="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['tg_id'];?>">加为好友</a></dd>
            <dd class="info" id="guest"><a href="javascript:;" name="guest" title="<?php echo $_html['tg_id'];?>">留言</a></dd>
        </dl>
        <?php }
        //调用分页模块
        _paging();
        ?>
    </div>
<?php
//关闭数据库
_close();

//调用footer
require ROOT_PATH.'/includes/footer.inc.php';
?>
</body>
</html>