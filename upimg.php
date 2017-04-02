<?php

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','upimg');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//接收上传图片
if(_formvalue('action')=='upload'){
    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //如果上传错误($_FILES['userfile']['error']不为0)
    //打印出上传错误的原因并且跳出
        if($_FILES['userfile']['error']!=0){
            switch($_FILES['userfile']['error']){
                case 1:echo "<script>alert('上传文件大小超过5M');history.back();</script>";
                    break;
                case 2:echo "<script>alert('上传文件大小超过5M');history.back();</script>";
                    break;
                case 3:echo"<script>alert('文件没有完全上传');history.back();</script>";
                    break;
                case 4:echo"<script>alert('没有上传任何文件');history.back();</script>";
                    break;
            }
            exit;
        }

    //设置上传文件格式
    $_files=array('image/jpeg','image/pjpeg','image/png','image/x-png','iamge/gif');

    //判断上传文件类型是否正确
    if(!in_array($_FILES['userfile']['type'],$_files)){
        _alert_back('不支持该文件格式');
    }

    //判断文件大小
    if($_FILES['userfile']['size']>_formvalue('MAX_FILE_SIZE')){
        _alert_back('图片大小不得超过5M');
    }

    /**
     * 获取文件扩展名:
     * 首先将文件名倒序，用explode以.分开，取数组中的第一个字符串
     * 再将第一个字符串倒序得到后缀名
     * 防止文件命中含有多个'.'，直接用explode分开可能得不到文件名最后的后缀名
     */
    $_filename=strrev($_FILES['userfile']['name']);
    $_tmp=explode('.',$_filename);
    $_extension=strrev($_tmp[0]);

    //获取完整的图片存放路径
    $_filedir='./photo/'.$_POST['dir'].'/'.time().'.'.$_extension;

    //移动图片到对应相册文件夹，图片名是当前时间戳.图片后缀
    if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
        if(move_uploaded_file($_FILES['userfile']['tmp_name'],$_filedir)){
            //_alert_close('上传成功');
            echo"<script>alert('上传成功');window.opener.document.getElementById('url').value='$_filedir';window.close();</script>";
            exit();
        }else{
            _alert_close('移动临时文件失败');
        }
    }else{
        _alert_back('临时文件不存在');
    }
}

//接收相册路径信息
if(!isset($_GET['dir'])) {
    _alert_close('不存在文件路径');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>选择图片</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <link rel="stylesheet" href="./style/upimg.css">
</head>
<body>
<div id="upimg" style="padding: 20px;">
    <h3>选择图片</h3>
    <form enctype="multipart/form-data" action="upimg.php" method="post">
        <dl>
            <dd><input type="hidden" name="action" value="upload" /></dd>
            <dd><input type="hidden" name="dir" value="<?php echo $_GET['dir']?>"></dd>
            <dd><input type="hidden" name="MAX_FILE_SIZE" value="5000000" /></dd>
            <dd><input type="file" name="userfile"  /></dd>
            <dd><input type="submit" value="上传" id="submit" /></dd>
        </dl>
    </form>
</div>
</body>
</html>