<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','manage_member');

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

//批量删除
$_GET['action']=isset($_GET['action'])?$_GET['action']:'';
$_POST['ids']=isset($_POST['ids'])?$_POST['ids']:'';
if($_GET['action']=='delete'){
//    var_dump($_POST['ids']);

    //当有选中的信息时才执行，否则报错
    if($_POST['ids']!=''){
//        将ids里的内容拿出来放到$_clean[]里面
        $_clean=array();
        $_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
//        var_dump($_clean);

        //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
        _uniqid();

        //批删除操作
        _query("DELETE FROM tg_user WHERE tg_id IN ({$_clean['ids']})");

        //判断数据库里是否只改动了一条数据
        if(_affected_rows()){
            //关闭数据库
            _close();
            //跳转
            _location('删除成功','manage_member.php');
        }else{
            //关闭数据库
            _close();
            //跳转
            _alert_back('删除失败');
        }
        exit();
    }else{
        _alert_back('请选择要删除的信息');
    }
}

//求出用户人数
$_num=_num_rows("SELECT tg_id FROM tg_user WHERE tg_level=0 ");

//得到分页模块所需要的全局变量
_pageinfo($_num,7);

//从数据库提取用id、发信人、信息内容、发送时间,获取一个数组$_row
//按照发送时间排序,从第$_pagenum+1个开始
$_sql="SELECT tg_id,tg_username,tg_reg_time FROM tg_user WHERE tg_level=0 ORDER BY tg_reg_time  LIMIT $_pagenum,$_pagesize";
$_row=_fetch_array($_sql);
//print_r($_row);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
    <head>
        <meta charset="UTF-8">
        <title>用户设置</title>
        <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
        <?php include ROOT_PATH.'/includes/title.inc.php'?>
        <script type="text/javascript" src="javascript/member_message.js"></script>
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
                <h2>用户设置</h2>
                <form method="post" action="manage_member.php?action=delete">
                <table>
                    <tr>
                        <th>id</th>
                        <th>用户名</th>
                        <th>注册时间</th>
                        <th>身份</th>
                        <th>选择</th>
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
                        <td>用户</td>
                        <td><input name="ids[]" value="<?php echo $_html['tg_id'];?>" type="checkbox" /></td>
                    </tr>
                    <?php }
                    //调用分页模块
                    _paging();
                    ?>
                    <tr><td colspan="5"><label for="all">全选<input type="checkbox" name="chkall" id="all"/></label><input id="delete" type="submit" value="删除"/></td></tr>
                </table>
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
