<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','manage_job');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//检测是否是管理员
if(!_manage_sate()){
    _location('没有管理员权限','./index.php');
}


//管理员辞职
if(isset($_GET['action'])&&$_GET['action']=='retire'){
    //检测唯一标识符
    _uniqid();

    //检验是否是本人辞职
    if($_COOKIE['username']!=$_GET['username']){
        _alert_back('非本人操作');
    }

    //修改用户等级
    _query("UPDATE tg_user SET tg_level=0 WHERE tg_username='{$_COOKIE['username']}' LIMIT 1");

    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //清除管理员的cookie
        _cookie_destroy('admin');
        //跳转
        _location('已经辞去管理员职务','index.php');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('辞职失败');
    }
}

//求出用户人数
$_num=_num_rows("SELECT tg_id FROM tg_user WHERE tg_level=1 ");

//得到分页模块所需要的全局变量
_pageinfo($_num,7);

//从数据库提取用id、发信人、信息内容、发送时间,获取一个数组$_row
//按照发送时间排序,从第$_pagenum+1个开始
$_sql="SELECT tg_id,tg_username,tg_reg_time FROM tg_user WHERE tg_level=1 ORDER BY tg_reg_time  LIMIT $_pagenum,$_pagesize";
$_row=_fetch_array($_sql);
//print_r($_row);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>权限设置</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
    <script type="text/javascript" src="javascript/manage_job.js"></script>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<div id="member">
    <?php
    include './includes/manage.inc.php';
    ?>
    <div id="member_main">
        <h2>权限设置</h2>
        <form method="post" action="manage_job.php?action=delete">
            <table>
                <tr>
                    <th>id</th>
                    <th>管理员</th>
                    <th>注册时间</th>
                </tr>
                <?php
                $_html=array();
                foreach($_row as $value1){
                    foreach($value1 as $key=>$value2) {
                        $_html[$key] = _html($value2);
                    }
                    ?>
                    <tr>
                        <td><?php echo $_html['tg_id'];?></td>
                        <td><?php echo $_html['tg_username'];?></td>
                        <td><?php echo $_html['tg_reg_time'];?></td>
                    </tr>
                <?php }
                //调用分页模块
                _paging();
                ?>
            </table>
            <div id="sub">
                <?php
                $_row=_fetch_array("SELECT tg_level FROM tg_user WHERE tg_username='{$_COOKIE['admin']}' LIMIT 1");
                if($_row[0]['tg_level']>1){
                    echo '<a id="appoint" href="javascript:;">任命管理员</a>';
                    echo '<a id="resign" href="javascript:;">辞退管理员</a>';
                }else{
                    echo '<a id="retire" href="javascript:;" name="'.$_COOKIE['username'].'">辞职</a>';
                }
                ?>
            </div>
        </form>
    </div>
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
