<?php

//防止其他人调用这个模块
if(!defined('IN_TG')){
    exit('Accsee Defined!');
}

?>

<div id="member_sidebar">
    <h2>导航</h2>
    <dl>
        <dt>帐户管理:</dt>
        <dd><a href="member.php">个人资料</a></dd>
        <dd><a href="member_modify.php">修改资料</a></dd>
    </dl>
    <dl>
        <dt>消息:</dt>
        <dd><a href="member_message.php">我的信息</a></dd>
        <dd><a href="member_friend.php">好友申请</a></dd>
        <dd><a href="member_gift.php">我的礼物</a></dd>
        <dd><a href="member_photo.php">我的图片</a></dd>
        <dd><a href="member_guest.php">留言板</a></dd>
    </dl>
</div>