<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','photo_show');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//处理提交的密码
if(_formvalue('action')=='password'){

    //调用register数库,在程序中最好用include函数调用
    include ROOT_PATH.'/includes/login.func.php';
    $_clean=array();

    $_clean['id']=_formvalue('id');
    $_clean['password']=_check_password(_formvalue('password'));

    $_row=_fetch_array("SELECT tg_id,tg_name,tg_password FROM tg_dir WHERE tg_id='{$_clean['id']}' LIMIT 1");
    //var_dump($_row);

    //对比密码是否正确
    if($_clean['password']==$_row[0]['tg_password']){
        //生成cookie，cookie名为photo+相册id，值为相册名
        setcookie('photo'.$_row[0]['tg_id'],$_row[0]['tg_name']);

        //生成cookie后不会即使生效，需要转跳一下
        _location(null,'photo_show.php?id='.$_clean['id']);
    }else{
        _alert_back('密码输入错误');
    }
}

//删除图片
if(isset($_GET['action']) && $_GET['action']=='delete' && isset($_GET['id'])){
    //验证唯一标识符
    _uniqid();

    //判断是否是管理员
    if(!_manage_sate()){
        _alert_back('只有管理员才能删除图片');
    }

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
        _alert_back('删除成功');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('删除失败');
    }
    exit();
}

//读取相册id
if(isset($_GET['id'])){
    //按照id获取相册内容
    $_row_album=_fetch_array("SELECT tg_id,tg_name,tg_type FROM tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1");
    if(!$_row_album){
        _alert_back('该相册不存在');
    }
    //var_dump($_row_album);

    //分页模块
    //创建一个全局变量，在分页地址里加上相册的id
    global $_id;
    $_id='id='.$_GET['id'].'&';

    //求出该相册里的图片总数
    $_num=_num_rows("SELECT tg_id FROM tg_photo WHERE tg_sid='{$_GET['id']}' ");

    //得到分页模块所需要的全局变量
    _pageinfo($_num,$_system['tg_photo']);

    $_sql="SELECT
              *
      FROM
              tg_photo
      WHERE
              tg_sid='{$_GET['id']}'
      ORDER BY
              tg_date
      DESC
              LIMIT $_pagenum,$_pagesize";
    $_row=_fetch_array($_sql);
    //print_r($_row);

}else{
    _alert_back('该相册不存在');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <title><?php echo $_row_album[0]['tg_name'];?></title>
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<script type="text/javascript">header();</script>
    <div id="photo">
        <h2><?php echo $_row_album[0]['tg_name'];?></h2>
<!--        检测相册是否有密码-->
        <?php
        //有密码并且不存在cookie时候输入密码
        $_COOKIE['photo'.$_row_album[0]['tg_id']]=isset($_COOKIE['photo'.$_row_album[0]['tg_id']])?$_COOKIE['photo'.$_row_album[0]['tg_id']]:'';
        if($_row_album[0]['tg_type']==1 && $_COOKIE['photo'.$_row_album[0]['tg_id']]!=$_row_album[0]['tg_name']){
            echo '<form method="post" action="photo_show.php?id='.$_GET['id'].'">';
                echo '<input type="hidden" name="action" value="password">';
                echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
                echo '<dl id="password">';
                    echo    '<dt>请输入相册密码</dt>';
                    echo    '<dd><input type="password" name="password" id="password" /></dd>';
                    echo    '<dd><input type="submit" name="submit" value="确定" id="submit" /></dd>';
                echo '</dl>';
            echo '</form>';
        }
        //当没有密码或者有密码且cookie正确时现实内容
        else{
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
                    <dd>by:<?php echo $_html['tg_user']; ?></dd>
                    <dt><a href="photo_detail.php?id=<?php echo $_html['tg_id']; ?>" title="查看详情"><img
                                src="thumb.php?filename=<?php echo $_html['tg_dir']; ?>&&width=1000&&height=1000" alt="<?php echo $_html['tg_name']; ?>"/></a></dt>
                    <?php
                    //管理员有删除图片的权限
                    if(_manage_sate()){
                        echo '<dd class="delete"><a href="photo_show.php?action=delete&&id='.$_html['tg_id'].'">[删除]</a></dd>';
                    }
                    ?>
                    <dd class="browse">
                        浏览(<strong><?php echo $_html['tg_read_count'] ?></strong>)&nbsp;&nbsp;
                        &nbsp;评论(<strong><?php echo $_html['tg_comment_count'] ?></strong>)
                    </dd>
                </dl>
                <?php
            }
            echo '<p><a href="photo_add_img.php?id='.$_GET['id'].'">上传图片</a></p>';
            //调用分页模块
            _paging();
        }
    echo '</div>';
//关闭数据库
_close();

//调用footer
require ROOT_PATH.'/includes/footer.inc.php';
?>
</body>
</html>