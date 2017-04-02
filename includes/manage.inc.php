<?php

//防止其他人调用这个模块
if(!defined('IN_TG')){
    exit('Accsee Defined!');
}

?>

<div id="member_sidebar">
    <h2>导航</h2>
    <dl>
        <dt>系统管理:</dt>
        <dd><a href="manage.php">后台信息</a></dd>
        <dd><a href="manage_set.php">系统设置</a></dd>
    </dl>
    <dl>
        <dt>用户管理</dt>
        <dd><a href="manage_member.php">用户列表</a></dd>
        <dd><a href="manage_job.php">权限设置</a></dd>
    </dl>
</div>