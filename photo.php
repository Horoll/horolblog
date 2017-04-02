<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','photo');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//删除相册
if(isset($_GET['action']) && isset($_GET['id']) && $_GET['action']=='delete'){
    //验证唯一标识符
    _uniqid();

    //判断是否是管理员
    if(!_manage_sate()) {
        _alert_back('只有管理员才能删除相册');
    }

    //找出相册所在的路径
    $_row_alubm=_fetch_array("SELECT tg_dir FROM tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1");

    //找出相册里的图片id
    $_row_photo=_fetch_array("SELECT tg_id FROM tg_photo WHERE tg_sid='{$_GET['id']}'");

    //删除属于这些图片的评论
    foreach ($_row_photo as $_comment_id){
        _query("DELETE FROM tg_photo_comment WHERE tg_sid='{$_comment_id['tg_id']}'");
    }

    //删除数据库中属于该相册的图片信息
    _query("DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'");

    //删除数据库中的相册信息
    _query("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");

    //删除相册文件夹
    _delete_dir('photo/'.$_row_alubm[0]['tg_dir']);

    //跳转
    _location('相册删除成功','photo.php');
}

//求出相册总数
$_num=_num_rows("SELECT tg_id FROM tg_dir");

//得到分页模块所需要的全局变量
_pageinfo($_num,$_system['tg_album']);


//从数据库提取用id、用户名、性别,获取一个数组$_row
//按照最近登录时间排序,从第$_pagenum+1个开始，每页20个用户
$_sql="SELECT tg_id,tg_name,tg_type,tg_face FROM tg_dir ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize";
$_row=_fetch_array($_sql);
//print_r($_row);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>相册</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<script type="text/javascript">header();</script>
    <div id="photo">
        <h2>相册</h2>
        <?php
        $_html=array();
        foreach($_row as $value1) {
            foreach ($value1 as $key => $value2){
                $_html[$key] = _html($value2);
            }
            //判断相册是公开还是加密
            if($_html['tg_type']==0){
                $_html['tg_type']='公开';
            }else{
                $_html['tg_type']='加密';
            }
            //，则用默认图片
            if(empty($_html['tg_face'])){
                $_html['tg_face']='./photo/default.png';
            }
            //var_dump($_html);

            //统计相册中有多少张图片
            $_html['photo_number']=_fetch_array("SELECT COUNT(*) AS count FROM tg_photo WHERE tg_sid='{$_html['tg_id']}'");
            //echo ($_html['photo_number'][0]['count']);

            ?>
            <dl>
                <dt><a name="jump" href="photo_show.php?id=<?php echo $_html['tg_id']?>" title="<?php echo $_html['tg_name'];?>"><img src="thumb.php?filename=<?php echo $_html['tg_face'];?>&&width=175&&height=170" alt="<?php echo $_html['tg_name']; ?>" /></a></dt>
                <dd class="name"><a name="jump" href="photo_show.php?id=<?php echo $_html['tg_id']?>"><?php echo $_html['tg_name']; ?></a>&nbsp;&nbsp;(<?php echo $_html['tg_type']; ?>)&nbsp;&nbsp;[<?php echo $_html['photo_number'][0]['count'];?>]</dd>
                <?php
                 if(_manage_sate()){
                         echo '<dd class="manage"><a href="photo_modify.php?id='.$_html['tg_id'].'">修改</a></dd>';
                         echo '<dd class="manage"><a href="photo.php?action=delete&&id='.$_html['tg_id'].'">删除</a></dd>';
                 }
                ?>
            </dl>
            <?php
        }
        //管理员拥有添加相册的权限
        if(_manage_sate()){
            echo '<p><a href="photo_add.php">添加相册</a></p>';
        }
        ?>
        <p><a href="#"></a></p>
        <?php
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