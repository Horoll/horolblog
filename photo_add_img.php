<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','photo_add_img');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//添加已上传的图片信息
if(_formvalue('action')=='addimg'){
    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    if(empty(_formvalue('url'))){
        _alert_back('请选择图片');
    }

    //调用register函数库
    include ROOT_PATH.'/includes/register.func.php';

    //接受表单数据
    $_clean=array();
    $_clean['name']=_check_username(_formvalue('name'),0,10);
    $_clean['dir']=_formvalue('url');
    $_clean['content']=_check_content(_formvalue('content'));
    $_clean['sid']=_formvalue('sid');
    $_clean['user']=$_COOKIE['username'];
    $_clean=_mysql_string($_clean);

    //写入数据库
    _query("INSERT INTO
                       tg_photo
                       (
                          tg_name,
                          tg_dir,
                          tg_content,
                          tg_sid,
                          tg_user,
                          tg_date
                       )
                       VALUES
                       (
                          '{$_clean['name']}',
                          '{$_clean['dir']}',
                          '{$_clean['content']}',
                          '{$_clean['sid']}',
                          '{$_clean['user']}',
                          NOW()
                       )
           ");

    //判断该相册是否已经有封面，若没有，将上传的这张图片作为封面
    $_row_face=_fetch_array("SELECT tg_face FROM tg_dir WHERE tg_id='{$_clean['sid']}' LIMIT 1");
    if(empty($_row_face[0]['tg_face'])){
        _query("UPDATE tg_dir SET tg_face='{$_clean['dir']}' WHERE tg_id='{$_clean['sid']}'");
    }

    //判断数据库里是否只改动（增加）了数据
    if(_affected_rows()>=1){
        //关闭数据库
        _close();
        //跳转
        _location('添加图片成功','photo_show.php?id='.$_clean['sid']);
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('添加图片失败');
    }
}

//读取相册id
if(isset($_GET['id'])){
    //按照id获取相册内容
    $_row=_fetch_array("SELECT tg_id,tg_dir FROM tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1");
    if(!$_row){
        _alert_back('该相册不存在');
    }
    //将数据库中的值转义呈现在页面上
    $_html=array();
    foreach($_row as $_value1){
        foreach($_value1 as $_key=>$_value2){
            $_html[$_key]=_html($_value2);
        }
    }
   //var_dump($_html);

}else{
    _alert_back('该相册不存在');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>添加图片</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<script type="text/javascript" src="javascript/photo_add_img.js"></script>
    <div id="photo">
        <h2>添加图片</h2>
        <form method="post" action="photo_add_img.php">
            <input type="hidden" name="action" value="addimg"/>
            <input type="hidden" name="sid" value="<?php echo $_html['tg_id'];?>">
            <dl>
                <dd>图片名称：<input type="text" name="name" class="text"/></dd>
                <dd><a href="javascript:;" title="<?php echo $_html['tg_dir'];?>" id="upload">选择图片</a><input type="text" name="url" id="url" readonly="readonly" class="text"/></dd>
                <dd>图片描述：<textarea name="content"></textarea></dd>
                <dd><input type="submit" value="添加图片" class="submit" /></dd>
            </dl>
        </form>
    </div>
<?php
//关闭数据库
_close();

//调用footer
require ROOT_PATH.'/includes/footer.inc.php';
?>
</body>
</html>
