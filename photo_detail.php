<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','photo_detail');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//处理评论信息
if(_formvalue('action')=='rephoto'){
    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //通过cookie的方法验证评论的时间间隔
    if(isset($_COOKIE['post_time'])){
        if(!_timeinterval(time(),$_COOKIE['post_time'],$_system['tg_comment'])){
            _alert_back('两次评论时间间隔不得小于'.$_system['tg_comment'].'s');
        }
    }

    //通过数据库的方法验证评论的时间间隔
    $_comment_time=_fetch_array("SELECT tg_comment_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1");
    if(!_timeinterval(time(),$_comment_time[0]['tg_comment_time'],$_system['tg_comment'])){
        _alert_back('两次评论时间间隔不得小于'.$_system['tg_comment'].'s');
    }

    //调用register数库,在程序中最好用include函数调用
    include ROOT_PATH.'/includes/register.func.php';

    $_clean=array();
    $_clean['sid']=_formvalue('sid');
    $_clean['content']=_check_content(_formvalue('content'),4,500);
    $_clean['user']=$_COOKIE['username'];
    $_clean=_mysql_string($_clean);

    //写入数据库
    _query("INSERT INTO tg_photo_comment
                          (
                            tg_sid,
                            tg_user,
                            tg_content,
                            tg_date
                          )
                    VALUES
                          (
                            '{$_clean['sid']}',
                            '{$_clean['user']}',
                            '{$_clean['content']}',
                            NOW()
                          )
          ");
    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //评论数量+1
        _query("UPDATE
                      tg_photo
                SET
                      tg_comment_count=tg_comment_count+1
                WHERE
                      tg_id='{$_clean['sid']}'
              ");
        //创建储存评论时间的cookie，用于检测评论间隔
        setcookie('post_time',time());
        //将最新的评论时间戳写入数据库中
        $_now_time=time();
        _query("UPDATE tg_user SET tg_comment_time=$_now_time WHERE tg_username='{$_clean['user']}'");
        //关闭数据库
        _close();
        //跳转
        _location('评论成功','photo_detail.php?id='.$_clean['sid']);
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('评论失败');
    }
}

//删除评论
if(isset($_GET['action']) && $_GET['action']=='delete_comment'){
    //检测唯一标识符
    _uniqid();

    //检测是否是管理员
    if(!_manage_sate()){
        _alert_back('只有管理员才能够删除评论');
    }

    //判断评论是否存在
    if(!$_row=_fetch_array("SELECT tg_id FROM tg_photo_comment WHERE tg_id='{$_GET['id']}' LIMIT 1")){
        _alert_back('该评论不存在');
    }

    //找出该评论对应的博客id
    $_row=_fetch_array("SELECT tg_sid FROM tg_photo_comment WHERE tg_id='{$_GET['id']}' LIMIT 1");

    //删除评论
    _query("DELETE FROM tg_photo_comment WHERE tg_id='{$_GET['id']}' LIMIT 1");

    //更改数据库中的评论数量
    _query("UPDATE
                      tg_photo
                SET
                      tg_comment_count=tg_comment_count-1
                WHERE
                      tg_id='{$_row[0]['tg_sid']}'
          ");

    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()>0){
        //关闭数据库
        _close();
        //跳转
        _alert_back('评论删除成功');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('评论删除失败');
    }
}


//删除图片
if(isset($_GET['action']) && $_GET['action']=='delete_photo' && isset($_GET['id'])){
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
        _location('删除成功','photo_show.php?id='.$_id_album);
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('删除失败');
    }
    exit();
}


//按图片id获取图片信息
if(isset($_GET['id'])){
    $_row_photo=_fetch_array("SELECT * FROM tg_photo WHERE tg_id='{$_GET['id']}' LIMIT 1");
    //var_dump($_row_photo);
    if(!$_row_photo){
        _alert_back('该图片不存在');
    }
    $_html=array();
    foreach($_row_photo as $_value1){
        foreach($_value1 as $_key=>$_value2){
            $_html[$_key]=_html($_value2);
        }
    }
    //var_dump($_html);

    /**
     * 防止更改网址图片id查看加密相册内的图片
     * 根据图片sid判断相册是否加密
     * 若是加密的，再判断是否有该相册名的cookie
     */
    //根据图片sid 找出对应相册的信息
    $_row_album=_fetch_array("SELECT tg_id,tg_name,tg_type FROM tg_dir WHERE tg_id='{$_html['tg_sid']}'");
    //var_dump($_row_album);

    //判断是否加密或者是否存在正确的ccokie
    $_COOKIE['photo'.$_row_album[0]['tg_id']]=isset($_COOKIE['photo'.$_row_album[0]['tg_id']])?$_COOKIE['photo'.$_row_album[0]['tg_id']]:'';
    if($_row_album[0]['tg_type']==1 && $_COOKIE['photo'.$_row_album[0]['tg_id']]!=$_row_album[0]['tg_name']){
        _alert_back('该图片已被加密');
    }


    //更新浏览次数
    _query("UPDATE tg_photo SET tg_read_count='{$_html['tg_read_count']}'+1 WHERE tg_id='{$_GET['id']}' ");
    $_html['tg_read_count']++;


    //分页模块
    //创建一个全局变量，在分页地址里加上博客的id
    global $_id;
    $_id='id='.$_GET['id'].'&';
    //echo $_id;

    //求出评论总数
    $_num=_num_rows("SELECT tg_id FROM tg_photo_comment WHERE tg_sid='{$_GET['id']}'");
    //echo $_num;

    //得到分页模块所需要的全局变量
    _pageinfo($_num,10);

    //从数据库获取用评论的用户名、内容、时间
    //按照最近评论时间排序,从第$_pagenum+1个开始，每页10个评论
    $_sql="SELECT
                tg_id,tg_user,tg_content,tg_date
          FROM
                tg_photo_comment
          WHERE
                tg_sid='{$_GET['id']}'
          ORDER BY
                  tg_date DESC
                  LIMIT $_pagenum,$_pagesize";
    $_row_comment=_fetch_array($_sql);
//    var_dump($_row_comment);

}else{
    _alert_back('该图片不存在');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $_html['tg_name'];?></title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <script type="text/javascript" src="javascript/photo_detail.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
    <div id="photo">
        <div>
            <h2><?php echo $_html['tg_name'];?></h2>
            <dl class="detail">
                <dd>by:<?php echo $_html['tg_user'];?></dd>
                <dt><a href="photo_complete?id=<?php echo $_html['tg_id'];?>" title="点击察看原图"><img src="thumb.php?filename=<?php echo $_html['tg_dir'];?>&&width=1000&&height=1000" /></a></dt>
                <?php
                //管理员有删除图片的权限
                if(_manage_sate()){
                    echo '<dd class="delete_photo"><a id="delete_photo" name="'.$_html['tg_id'].'" href="javascript:;">【删除】</a></dd>';
                }
                ?>
                <dd class="browse">浏览(<strong><?php echo $_html['tg_read_count']?></strong>)
                    &nbsp;&nbsp;&nbsp;评论(<strong><?php echo $_html['tg_comment_count']?></strong>)</dd>
                <dd class="content"><?php echo $_html['tg_content'];?></dd>
            </dl>
        </div>
        
        <!-- 发表评论-->
        <?php
        //必须登录才能评论
        if(_login_sate()){?>
        <div id="rephoto">
            <h2>评论</h2>
            <form method="post" action="photo_detail.php">
                <input type="hidden" name="action" value="rephoto" />
                <input type="hidden" name="sid" value="<?php echo $_GET['id']?>" />
                <dl>
                    <dd>
                        <!--引入ubb-->
                        <?php include ROOT_PATH.'/includes/ubb.inc.php';?>
                        <textarea name="content"></textarea>
                    </dd>
                    <dd><input type="submit"  name="register" value="发表评论" class="submit"/></dd>
                </dl>
            </form>
            <p class="line"></p>
        </div>
        <?php }?>

        <?php
        //在循环定义存放外评论信息的数组
        $_content_commend=array();
        //在循环定义存放外用户信息的数组
        $_html_blog=array();
        //再循环外定义楼层变量,通过当前的页面数正确显示楼层
        $_floor=$_num-($_page-1)*$_pagesize;

        //双循环获得每层评论的评论信息和对应的用户信息
        foreach($_row_comment as $_value1){
            foreach($_value1 as $_key=>$_value2){
                $_html_comment[$_key]=_html($_value2);
            }
            //var_dump($_html_comment);
            //找出每条评论对应的用户信息
            $_sql="SELECT
                          tg_id,tg_email,tg_sex,tg_switch,tg_autograph
                  FROM
                          tg_user
                  WHERE
                          tg_username='{$_html_comment['tg_user']}'
                          LIMIT 1";
            $_user_comment=_fetch_array($_sql);
            //print_r($_user_commend);
            //得到用户信息
            foreach($_user_comment as $value1){
                foreach($value1 as $key=>$value2){
                    $_html_user[$key]=$value2;
                }
            }
            $_html_user=_html($_html_user);
            //var_dump($_html_user);
            ?>
            <div class="re">
                <dl>
                    <dd class="user"><?php echo $_html_comment['tg_user'].'('.$_html_user['tg_sex'].')'; ?> </dd>
                    <dt> <img src="<?php echo _face_dir($_html_comment['tg_user']);?>" alt="<?php echo $_html_comment['tg_user'];?>" /></dt>
                    <dd class="info" id="message"><a href="javascript:;" name="message" title="<?php echo $_html_user['tg_id'];?>">发送信息</a></dd>
                    <dd class="info" id="gift"><a href="javascript:;" name="gift" title="<?php echo $_html_user['tg_id'];?>">送礼物</a></dd>
                    <dd class="info" id="friend"><a href="javascript:;" name="friend" title="<?php echo $_html_user['tg_id'];?>">加为好友</a></dd>
                    <dd class="info" id="guest"><a href="javascript:;" name="guest" title="<?php echo $_html_user['tg_id'];?>">留言</a></dd>
                    <dd id="email">邮箱：<a href="mailto:<?php echo $_html_user['tg_email'];?>"><?php echo $_html_user['tg_email'];?></a></dd>
                </dl>
                <div class="content">
                    <div class="blog">
                        <?php echo $_html_comment['tg_user'];?>评论于：<?php echo $_html_comment['tg_date'];?><span><?php echo $_floor;?>L</span>
                        <?php
                        //管理员能够删除评论
                        if(_manage_sate()){
                            echo '<a class="delete_comment" name="'.$_html_comment['tg_id'].'" href="javascript:;">【删除】</a>';
                        }
                        ?>
                    </div>
                    <p class="line"></p>
                    <div class="detail">
                        <?php echo _ubb($_html_comment['tg_content']);?>
                    </div>
                    <p class="sign"><?php if(!empty($_html_user['tg_autograph'])&&$_html_user['tg_switch']==1) echo '——&nbsp;'._ubb($_html_user['tg_autograph']);?></p>
                </div>
                <p class="line"></p>
            </div>
            <?php
            //每循环一次，楼层-1，最小为1L
            $_floor--;
        }
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