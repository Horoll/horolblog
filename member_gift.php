<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','member_gift');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//批量删除
$_GET['action']=isset($_GET['action'])?$_GET['action']:'';
$_POST['ids']=isset($_POST['ids'])?$_POST['ids']:'';
if($_GET['action']=='delete'){
    //var_dump($_POST['ids']);

    //当有选中的信息时才执行，否则报错
    if($_POST['ids']!=''){
//        将ids里的内容拿出来放到$_clean[]里面
        $_clean=array();
        $_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
//        var_dump($_clean);

        //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
        _uniqid();

        //批删除操作
        _query("DELETE FROM tg_gift WHERE tg_id IN ({$_clean['ids']})");

        //判断数据库里是否只改动了一条数据
        if(_affected_rows()){
            //关闭数据库
            _close();
            //跳转
            _location('删除成功','member_gift.php');
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
$_num=_num_rows("SELECT tg_id FROM tg_gift WHERE tg_touser='{$_COOKIE['username']}'");

//得到分页模块所需要的全局变量
_pageinfo($_num,7);

//从数据库提取用id、发信人、信息内容、发送时间,获取一个数组$_row
//按照发送时间排序,从第$_pagenum+1个开始
$_sql="SELECT tg_id,tg_fromuser,tg_number,tg_content,tg_date FROM tg_gift WHERE tg_touser='{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize";
$_row=_fetch_array($_sql);
//print_r($_row);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>我的礼物</title>
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
    include './includes/member.inc.php';
    ?>
    <div id="member_main">
        <h2>我的礼物</h2>
        <form method="post" action="member_gift.php?action=delete">
            <table>
                <tr>
                    <th>谁送的</th>
                    <th>礼物数量</th>
                    <th>信息内容</th>
                    <th>发送时间</th>
                    <th>选择</th>
                </tr>
                <?php
                    $_html=array();
                    $_html['count']=0;
                    foreach($_row as $value1){
                    foreach($value1 as $key=>$value2){
                        $_html[$key]=_html($value2);
                    }
                        //算出总的礼物数
                        $_html['count']+=$_html['tg_number'];
                    ?>
                    <tr>
                        <td><?php echo $_html['tg_fromuser'];?></td>
                        <td><?php echo $_html['tg_number'];?>个礼物</td>
                        <td><a href="member_gift_detail.php?id=<?php echo $_html['tg_id'];?>" title="<?php echo $_html['tg_content'];?>"><?php echo _title($_html['tg_content']);?></a></td>
                        <td><?php echo $_html['tg_date'];?></td>
                        <td><input name="ids[]" value="<?php echo $_html['tg_id'];?>" type="checkbox" /></td>
                    </tr>
                <?php
                }
                //调用分页模块
                _paging();
                ?>
                <tr><td colspan="5">共<?php echo $_html['count'];?>个礼物</td></tr>
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
