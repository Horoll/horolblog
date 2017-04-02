<?php

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','changeface');

//引入common
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

if(isset($_GET['action']) && $_GET['action']='done'){
    _alert_close('修改成功');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>修改头像</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <link rel="stylesheet" type="text/css" href="style/<?php echo SCRIPT;?>.css" />
    <link rel="stylesheet" href="croppic/assets/css/croppic.css">
</head>
<body>
<div>
    <h1>修改头像</h1>
</div>
<div id="updateface"></div>
<div id="button">
<a href="?action=done"><button id="close" type="button" >确定</button></a>
</div>
<!--引入、配置js-->
<script type="text/javascript" src="javascript/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="croppic/croppic.min.js"></script>
<script type="text/javascript">
    var cropperOptions = {
        uploadUrl:'img_save_to_file.php',
        cropUrl:'img_crop_to_file.php',
        modal:true,
        imgEyecandyOpacity:0.4,
        onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
        onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
        onImgDrag: function(){ console.log('onImgDrag') },
        onImgZoom: function(){ console.log('onImgZoom') },
        onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
        onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
        onReset:function(){ console.log('onReset') },
        onError:function(errormessage){ console.log('onError:'+errormessage) }
    };
    var updateface = new Croppic('updateface', cropperOptions);
</script>
</body>
</html>