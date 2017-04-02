<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','member_photo');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//删除图片
if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['id'])){
    //验证唯一标识符
    _uniqid();

    if(isset($_COOKIE['username'])){
        //从数据库获得图片路径
        $_row_photo=_fetch_array("SELECT tg_dir,tg_sid FROM tg_photo WHERE tg_id='{$_GET['id']}'  LIMIT 1");
        //判断图片id是否存在
        if(!$_row_photo){
            _alert_back('该图片不存在');
        }

        $_dir=$_row_photo[0]['tg_dir'];
        $_id_album=$_row_photo[0]['tg_sid'];
        //判断图片路径是否存在
        if(!file_exists($_dir)){
            _alert_back('图片路径不存在');
        }
        //删除文件夹里的图片
        unlink($_dir);

        //删除数据库里的图片信息
        _query("DELETE FROM tg_photo WHERE tg_id='{$_GET['id']}'");

        //同时删除该图片的所有评论
        _query("DELETE FROM tg_photo_comment WHERE tg_sid='{$_GET['id']}'");

        //判断删除的这张图片是否是相册封面
        //若果是，则将相册封面改为相册里最新的图片
        //如果相册里没有其它图片了，则将封面地址变为空
        $_face_album=_fetch_array("SELECT tg_face FROM tg_dir WHERE tg_id='{$_id_album}' LIMIT 1");
        if($_face_album[0]['tg_face']==$_dir){
            //首先找出属于该相册最新的图片
            $_face_new=_fetch_array("SELECT tg_dir FROM tg_photo WHERE tg_sid='{$_id_album}' ORDER BY tg_date DESC LIMIT 1");

            //如果存在图片，将这张图片地址赋值给相册封面
            //如果不存在，将相册封面赋值为空
            if($_face_new){
                _query("UPDATE tg_dir SET tg_face='{$_face_new[0]['tg_dir']}' WHERE tg_id='{$_id_album}' ");
            }else{
                _query("UPDATE tg_dir SET tg_face='' WHERE tg_id='{$_id_album}' ");
            }
        }
        //判断数据库里是否有数据改动
        if(_affected_rows()){
            //关闭数据库
            _close();
            //跳转
            _location('删除成功','photo_show.php?id='.$_id_album);
        }else{
            //关闭数据库
            _close();
            //跳转
            _alert_back('删除失败');
        }
    }else{
        _alert_back('没有权限删除');
    }
}

//读取该用户上传的图片
if(isset($_COOKIE['username'])){

    //求出该用户的图片总数
    $_num=_num_rows("SELECT tg_id FROM tg_photo WHERE tg_user='{$_COOKIE['username']}' ");

    //得到分页模块所需要的全局变量
    _pageinfo($_num,1);

    $_sql="SELECT
              *
      FROM
              tg_photo
      WHERE
              tg_user='{$_COOKIE['username']}'
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
    <title>我的图片</title>
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
        <h2>我的图片</h2>
        <?php
        $_html = array();
        foreach ($_row as $_value1)  {
        foreach ($_value1 as $_key => $_value2) {
        $_html[$_key] = _html($_value2);
        }
        //print_r($_html);
        ?>
        <dl>
            <dd class="name"><a
                    href="photo_detail.php?id=<?php echo $_html['tg_id'] ?>"><?php echo $_html['tg_name']; ?></a>
            </dd>
            <dt><a href="photo_detail.php?id=<?php echo $_html['tg_id']; ?>" title="查看详情"><img
                        src="thumb.php?filename=<?php echo $_html['tg_dir']; ?>&&width=650&&height=350" alt="<?php echo $_html['tg_name']; ?>"/></a></dt>
            <?php
            if(isset($_COOKIE['username'])){
                //判断数据库中的tg_level是否为1
                $_level=_fetch_array("SELECT tg_level FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1");
                if($_level[0]['tg_level']==1){
                    echo '<dd class="delete"><a href="photo_show.php?action=delete&&id='.$_html['tg_id'].'">[删除]</a></dd>';
                }
            }
            ?>
            <dd class="browse">
                浏览(<strong><?php echo $_html['tg_read_count'] ?></strong>)&nbsp;&nbsp;
                &nbsp;评论(<strong><?php echo $_html['tg_comment_count'] ?></strong>)
            </dd>
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