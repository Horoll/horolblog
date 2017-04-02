<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','index');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//获取xml文件内容
$_xml=_get_xml('xml/new.xml');

//读取博客列表
//求出博客总数
$_num=_num_rows("SELECT tg_id FROM tg_article WHERE tg_reid=0");
//echo $_num;

//得到分页模块所需要的全局变量
_pageinfo($_num,$_system['tg_article']);


//从数据库提取用博客信息(reid=0 )
//按照最近登录时间排序,从第$_pagenum+1个开始，每页20个用户
$_sql="SELECT tg_id,tg_title,tg_tag,tg_readcount,tg_commendcount,tg_fine FROM tg_article WHERE tg_reid=0 ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize";
$_row=_fetch_array($_sql);
//var_dump($_row);

//最新图片，找到最新上传时间的图片，并且属于非加密相册
$_row_photo=_fetch_array("SELECT 
                            tg_id,
                            tg_name,
                            tg_dir
                       FROM
                            tg_photo
                       WHERE 
                            tg_sid in (SELECT tg_id FROM tg_dir WHERE tg_type=0)
                       ORDER BY
                            tg_date 
                       DESC 
                            LIMIT 5
                    ");
if(!$_row_photo){
    $_row_photo['name']='';
    $_row_photo['id']='###';
    $_row_photo['dir']='photo/default.png';
}
//var_dump($_row_photo);
//echo count($_row_photo,0);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $_system['tg_webname'];?></title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
</head>
<?php include ROOT_PATH.'/includes/title.inc.php'?>
<link rel="stylesheet" href="unslider-master/src/scss/unslider.css">
<script type="text/javascript" src="javascript/blog.js"></script>
<script type="text/javascript" src="javascript/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="unslider-master/dist/js/unslider-min.js"></script>
<script>
    jQuery(document).ready(function($) {
        $('.ban').unslider({
            autoplay: true, arrows: false
        });
    });
</script>
<body>

<?php
    //调用header
    require ROOT_PATH.'/includes/header.inc.php';
?>

    <div id="list">
        <h2>博客</h2>
        <a href="post.php" class="post">写博客</a>
        <ul id="article">
            <?php
            $_html=array();
            foreach($_row as $value1){
                foreach($value1 as $key=>$value2){
                    $_html[$key]=_html($value2);
                }
                if(empty($_html['tg_tag'])){
                    $_html['tg_tag']='博客';
                }
            ?>
            <li>
                <?PHP
                if($_html['tg_fine']==1){
                    echo '<span>[推荐]</span>';
                }
                ?>
                [<?php echo _tag($_html['tg_tag']);?>]&nbsp;&nbsp;&nbsp;
                <em><strong>阅读(<?php echo $_html['tg_readcount']?>)</strong>
                    <strong>评论(<?php echo $_html['tg_commendcount']; ?>)</strong></em>
                <a href="article.php?id=<?php echo $_html['tg_id']?>"><?php echo _title($_html['tg_title'],20);?></a></li>
            <?php }?>
        </ul>
        <?php //调用分页模块
        _paging();?>
    </div>

    <div id="user">
        <h2>新用户</h2>
        <dl>
            <dd class="user"><?php echo $_xml['username'].'('.$_xml['sex'].')'; ?> </dd>
            <dt> <img src="<?php echo _face_dir($_xml['username']);?>" alt="<?php echo $_xml['username']?>" /></dt>
            <dd class="info" id="message"><a href="javascript:;" name="message" title="<?php echo $_xml['id']?>">发送信息</a></dd>
            <dd class="info" id="gift"><a href="javascript:;" name="gift" title="<?php echo $_xml['id']?>">送礼物</a></dd>
            <dd class="info" id="friend"><a href="javascript:;" name="friend" title="<?php echo $_xml['id']?>">加为好友</a></dd>
            <dd class="info" id="guest"><a href="javascript:;" name="guest" title="<?php echo $_xml['id'];?>">留言</a></dd>
            <dd id="email">邮箱：<a href="mailto:<?php echo $_xml['email'];?>"><?php echo $_xml['email'];?></a></dd>
        </dl>
    </div>
    <div id="img">
        <h2>最新图片</h2>
        <div class="ban">
            <ul>
                <?php foreach ($_row_photo as $_value1){
                foreach ($_value1 as $_key=>$_value2){
                    $_photo[$_key]=$_value2;
                }
                //var_dump($_photo);
                ?>
                <li>
                    <a href="photo_detail.php?id=<?php echo $_photo['tg_id'];?>" title="<?php echo $_photo['tg_name'];?>">
                    <img src="thumb.php?filename=<?php echo $_photo['tg_dir'];?>&&width=375&&height=275" alt="<?php echo $_photo['tg_name']; ?>" />
                    </a>
                </li>
            <?php }?>
            </ul>
        </div>
    </div>

<?php
    //调用footer
    require ROOT_PATH.'/includes/footer.inc.php';
?>
</body>
</html>



