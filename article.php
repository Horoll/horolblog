<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','article');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//删除博客评论功能
if(isset($_GET['action']) && $_GET['action']=='delete_comment'){
    //检测唯一标识符
    _uniqid();

    //检测是否是管理员
    if(!_manage_sate()){
        _alert_back('只有管理员才能够推荐博客');
    }

    //判断评论是否存在
    if(!$_row=_fetch_array("SELECT tg_id FROM tg_article WHERE tg_id='{$_GET['id']}' LIMIT 1")){
        _alert_back('该评论不存在');
    }

    //找出该评论对应的博客id
    $_row=_fetch_array("SELECT tg_reid FROM tg_article WHERE tg_id='{$_GET['id']}' LIMIT 1");

    //删除评论
    _query("DELETE FROM tg_article WHERE tg_id='{$_GET['id']}' LIMIT 1");

    //更改数据库中的评论数量
    _query("UPDATE
                      tg_article
                SET
                      tg_commendcount=tg_commendcount-1
                WHERE
                      tg_id='{$_row[0]['tg_reid']}'
                AND
                      tg_reid=0");

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

//删除博客功能
if(isset($_GET['action']) && $_GET['action']=='delete_blog'){
    //检测唯一标识符
    _uniqid();

    //检测是否是管理员
    if(!_manage_sate()){
        _alert_back('只有管理员才能够推荐博客');
    }

    //判断博客是否存在
    if(!$_row=_fetch_array("SELECT tg_fine FROM tg_article WHERE tg_id='{$_GET['id']}' LIMIT 1")){
        _alert_back('该博客不存在');
    }

    //删除博客以及评论
    _query("DELETE FROM tg_article WHERE tg_id='{$_GET['id']}' OR tg_reid='{$_GET['id']}' ");

    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()>0){
        //关闭数据库
        _close();
        //跳转
        _location('博客删除成功','index.php');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('博客删除失败');
    }
}

//接收、处理博客加精功能
if(isset($_GET['action']) && $_GET['action']=='fine'){
    //检测唯一标识符
    _uniqid();

    //检测是否是管理员
    if(!_manage_sate()){
        _alert_back('只有管理员才能够推荐博客');
    }

    //判断博客是否存在
    if(!$_row=_fetch_array("SELECT tg_fine FROM tg_article WHERE tg_id='{$_GET['id']}' LIMIT 1")){
        _alert_back('该博客不存在');
    }

    //修改推荐状态
    if($_row[0]['tg_fine']==0){
        _query("UPDATE tg_article SET tg_fine=1 WHERE tg_id='{$_GET['id']}'");
    }else{
        _query("UPDATE tg_article SET tg_fine=0 WHERE tg_id='{$_GET['id']}'");

    }

    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //跳转
        _location('推荐状态修改成功','article.php?id='.$_GET['id']);
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('推荐状态修改失败');
    }
}

//接收、处理评论
if(_formvalue('action')=='rearticle'){

    if(!_login_sate()){
        _alert_back('请先登录');
    }

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
    $_clean['reid']=_formvalue('reid');
    $_clean['content']=_check_content(_formvalue('content'),4,500);
    $_clean['username']=$_COOKIE['username'];
    $_clean=_mysql_string($_clean);

    //写入数据库
    _query("INSERT INTO tg_article
                          (
                            tg_reid,
                            tg_username,
                            tg_content,
                            tg_date
                          )
                    VALUES
                          (
                            '{$_clean['reid']}',
                            '{$_clean['username']}',
                            '{$_clean['content']}',
                            NOW()
                          )
          ");
    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //评论数量+1
        _query("UPDATE
                      tg_article
                SET
                      tg_commendcount=tg_commendcount+1
                WHERE
                      tg_id='{$_clean['reid']}'
                AND
                      tg_reid=0");
        //创建储存评论时间的cookie，用于检测评论间隔
        setcookie('post_time',time());
        //将最新的评论时间戳写入数据库中
        $_now_time=time();
        _query("UPDATE tg_user SET tg_comment_time=$_now_time WHERE tg_username='{$_clean['username']}'");
        //关闭数据库
        _close();
        //跳转
        _location('评论成功','article.php?id='.$_clean['reid']);
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('评论失败');
    }
}

//从数据库获取博客信息
if(isset($_GET['id'])){
    //按id寻找博客信息
    $_rows_blog=_fetch_array("SELECT
                                    *
                              FROM
                                    tg_article
                              WHERE
                                    tg_id='{$_GET['id']}'
                              AND
                                    tg_reid=0
                                    LIMIT 1
                              ");
    if(!$_rows_blog){
        _alert_back('博客不存在');
    }
    //var_dump($_rows_blog);

    //在循环外定义$_html_blog数组，用于存放博客的信息
    $_html_blog=array();
    foreach($_rows_blog as $_value1){
        foreach($_value1 as $_key=>$_value2){
            //将博客信息经过_html函数转义
            $_html_blog[$_key]=_html($_value2);
        }
    }
    //var_dump($_html_blog);

    //累计阅读量
    _query("UPDATE
                  tg_article
            SET
                  tg_readcount=tg_readcount+1
            WHERE
                  tg_id='{$_GET['id']}' ");
    $_html_blog['tg_readcount']++;

    //获取用户信息
    $_rows_user=_fetch_array("SELECT
                                    tg_id,tg_email,tg_sex,tg_switch,tg_autograph
                              FROM
                                    tg_user
                              WHERE
                                    tg_username='{$_rows_blog[0]['tg_username']}'
                                    LIMIT 1");
    if(!$_rows_user){
        _alert_back('该用户已被管理员删除');
    }
    //var_dump($_rows_user);

    //建立$_html_user数组，用于存放博客作者的信息
    $_html_user=array();
    foreach($_rows_user as $value1){
        foreach($value1 as $key=>$value2){
            $_html_user[$key]=$value2;
        }
    }
    $_html_user=_html($_html_user);
    //var_dump($_html_user);

    //当博客作者与当前用户相同时，允许修改博客
    if(isset($_COOKIE['username'])){
        if($_COOKIE['username']==$_rows_blog[0]['tg_username']){
            //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
            _uniqid();
            $_row_blog['subject_modify']='【修改】';
        }
    }

    //分页模块
    //创建一个全局变量，在分页地址里加上博客的id
    global $_id;
    $_id='id='.$_GET['id'].'&';
    //echo $_id;

    //求出评论总数
    $_num=_num_rows("SELECT tg_id FROM tg_article WHERE tg_reid='{$_GET['id']}'");
    //echo $_num;

    //得到分页模块所需要的全局变量
    _pageinfo($_num,10);

    //从数据库获取用评论的用户名、内容、时间
    //按照最近评论时间排序,从第$_pagenum+1个开始，每页10个评论
    $_sql="SELECT
                tg_id,tg_username,tg_content,tg_date
          FROM
                tg_article
          WHERE
                tg_reid='{$_GET['id']}'
          ORDER BY
                  tg_date DESC
                  LIMIT $_pagenum,$_pagesize";
    $_row_comment=_fetch_array($_sql);
//    var_dump($_row_comment);
}else{
    _alert_back('非法操作');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>博客内容</title>
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <script type="text/javascript" src="javascript/article.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>

<div id="article">
    <h2>博客内容</h2>
    <div id="subject">
        <dl>
            <dd class="user"><?php echo $_html_blog['tg_username'].'('.$_html_user['tg_sex'].')'; ?> </dd>
            <dt> <img src="<?php echo _face_dir($_html_blog['tg_username'])?>" alt="<?php echo $_html_blog['tg_username']?>" /></dt>
            <dd class="info" id="message"><a href="javascript:;" name="message" title="<?php echo $_html_user['tg_id'];?>">发送信息</a></dd>
            <dd class="info" id="gift"><a href="javascript:;" name="gift" title="<?php echo $_html_user['tg_id'];?>">送礼物</a></dd>
            <dd class="info" id="friend"><a href="javascript:;" name="friend" title="<?php echo $_html_user['tg_id'];?>">加为好友</a></dd>
            <dd class="info" id="guest"><a href="javascript:;" name="guest" title="<?php echo $_html_user['tg_id'];?>">留言</a></dd>
            <dd id="email">邮箱：<a href="mailto:<?php echo $_html_user['tg_email'];?>"><?php echo $_html_user['tg_email'];?></a></dd>
        </dl>
        <div class="content">
            <div class="blog">
                <?PHP
                if($_html_blog['tg_fine']==1){
                    echo '<p id="fine">【推荐！】</p>';
                }
                ?>
                <?php echo $_html_blog['tg_username'];?>发表于：<?php echo $_html_blog['tg_date'];?><span><?php echo $_html_blog['tg_tag'];?></span>
            </div>
            <p class="line"></p>
            <h3><?php echo $_html_blog['tg_title'];?></h3>
            <div class="detail">
                <?php echo _ubb($_html_blog['tg_content']);?>
            </div>
            <p class="sign"><?php if(!empty($_html_user['tg_autograph'])&&$_html_user['tg_switch']==1) echo '——&nbsp;   '._ubb($_html_user['tg_autograph']);?></p>
            <p class="line"></p>
                <div class="read">
                    <!-- 管理员有推荐、删除的权限 -->
                    <?php if (_manage_sate()){
                        if($_html_blog['tg_fine']==0){
                            echo '<a href="article.php?action=fine&&id='.$_GET['id'].'">【推荐】</a>';
                        }else{
                            echo '<a href="article.php?action=fine&&id='.$_GET['id'].'">【取消推荐】</a>';
                        }
                        echo '<a id="delete_blog" href="javascript:;" name="'.$_GET['id'].'" >【删除】</a>';
                     }?>
                    <a href="article_modify.php?id=<?php echo $_GET['id'];?>"><?php if(isset($_row_blog['subject_modify'])) echo $_row_blog['subject_modify'];?></a>&nbsp;&nbsp;&nbsp;
                    <?php if(!empty($_html_blog['tg_last_modify_date'])) echo '最后修改于：'.$_html_blog['tg_last_modify_date'];?>&nbsp;&nbsp;&nbsp;
                    阅读(<?php echo $_html_blog['tg_readcount'];?>)&nbsp;&nbsp;&nbsp;评论(<?php echo $_html_blog['tg_commendcount'];?>)
            </div>
        </div>
    </div>
    <p class="line"></p>
    <!-- 发表回复 -->
    <?php
        //必须登录才能评论
        if(_login_sate()){?>
        <div id="rearticle">
            <h2>评论</h2>
            <form method="post" action="article.php">
                <input type="hidden" name="action" value="rearticle" />
                <input type="hidden" name="reid" value="<?php echo $_GET['id']?>" />
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

        <!-- 评论内容 -->
        <?php }
        //在循环定义存放外评论信息的数组
        $_content_comment=array();
         //在循环定义存放外用户信息的数组
        $_html_blog=array();
        //再循环外定义楼层变量,通过当前的页面数正确显示楼层
        $_floor=$_num-($_page-1)*$_pagesize;

        //双循环获得每层评论的评论信息和对应的用户信息
        foreach($_row_comment as $_value1){
            foreach($_value1 as $_key=>$_value2){
                $_html_comment[$_key]=_html($_value2);
            }
            //print_r($_html_comment);
            //找出每条评论对应的用户信息
            $_sql="SELECT
                          tg_id,tg_email,tg_sex,tg_switch,tg_autograph
                  FROM
                          tg_user
                  WHERE
                          tg_username='{$_html_comment['tg_username']}'
                          LIMIT 1";
            $_user_comment=_fetch_array($_sql);
            //print_r($_user_commend);
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
            <dd class="user"><?php echo $_html_comment['tg_username'].'('.$_html_user['tg_sex'].')'; ?> </dd>
            <dt> <img src="<?php echo _face_dir($_html_comment['tg_username']);?>" alt="<?php echo $_html_comment['tg_username']?>" /></dt>
            <dd class="info" id="message"><a href="javascript:;" name="message" title="<?php echo $_html_user['tg_id'];?>">发送信息</a></dd>
            <dd class="info" id="gift"><a href="javascript:;" name="gift" title="<?php echo $_html_user['tg_id'];?>">送礼物</a></dd>
            <dd class="info" id="friend"><a href="javascript:;" name="friend" title="<?php echo $_html_user['tg_id'];?>">加为好友</a></dd>
            <dd class="info" id="guest"><a href="javascript:;" name="guest" title="<?php echo $_html_user['tg_id'];?>">留言</a></dd>
            <dd id="email">邮箱：<a href="mailto:<?php echo $_html_user['tg_email'];?>"><?php echo $_html_user['tg_email'];?></a></dd>
        </dl>
        <div class="content">
            <div class="blog">
                <?php echo $_html_comment['tg_username'];?>评论于：<?php echo $_html_comment['tg_date'];?><span><?php echo $_floor;?>L</span>
                <?php
                //管理员有删除的权限
                if(_manage_sate()){
                    echo '<a class="delete_comment" href="javascript:;" name="'.$_html_comment['tg_id'].'">【删除】</a>';
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