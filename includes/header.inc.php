<?php

//防止其他人调用这个模块
if(!defined('IN_TG')){
    exit('Accsee Defined!');
}

?>

<!-- 将header分离 -->
<script type="text/javascript" src="javascript/header.js"></script>
<div id="header">
    <h1>班级博客留言系统</h1>
    <?php
    if(isset($_COOKIE['uniqid'])){ ?>
        <ul>
            <li><a href="index.php">首页</a></li>
            <li><a id="checkuser" href="member.php"><img id="face" src="<?php echo _face_dir($_COOKIE['username']); ?>" alt="<?php $_COOKIE['username']?>"></a></li>
            <li><a id="checknews" href="#">消息</a></li>
            <li><a href="blog.php">用户列表</a></li>
            <li><a href="photo.php">相册</a></li>
        </ul>
    <?php }else{?>
            <ul id="nonelogin">
                <li><a href="index.php">首页</a></li>
                <li><a href="login.php">登录</a></li>
            <?php if($_system['tg_register']==1){
                echo '<li><a href="register.php">注册</a></li>';
            }?>
            </ul>
        <?php }?>
    <div id="user">
        <a href="member.php">个人中心</a>
        <?php
        //检验是否是管理员
        if(_manage_sate()){
            echo '<a href="manage.php">管理</a>';
        }?>
        <a href="logout.php">退出</a>
    </div>
    <div id="news">
        <?php
        if(isset($_message_html)) {
            echo '<strong><a href="./member_message.php">新消息&nbsp;&nbsp;('.$_message_html.')</a></strong>';
        }else{
            echo '<strong><a href="./member_message.php">我的信息</a></strong>';
        }
        if(isset($_friend_html)) {
            echo '<strong><a href="./member_friend.php">好友申请&nbsp;&nbsp;('.$_friend_html.')</a></strong>';
        }else{
            echo '<strong><a href="./member_friend.php">我的好友</a></strong>';
        }
        if(isset($_gift_html)){
            echo '<strong><a href="./member_gift.php">新礼物&nbsp;&nbsp;&nbsp;('.$_gift_html.')</a></strong>';
        }else{
            echo '<strong><a href="./member_gift.php">我的礼物</a></strong>';
        }
        ?>
    </div>
</div>