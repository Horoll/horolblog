<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','photo_detail');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

if($_GET['id']){
    $_row_photo=_fetch_array("SELECT tg_name,tg_dir FROM tg_photo WHERE tg_id='{$_GET['id']}' LIMIT 1");
    //var_dump($_row_photo);

    if(!$_row_photo){
        _alert_back('该图片不存在');
    }
    $_html=array();
    foreach($_row_photo as $_value1){
        foreach($_value1 as $_key=>$_value2){
            $_html[$_key]=_html($_value2);
        }
    }
    //var_dump($_html);
}else{
    _alert_back('该图片不存在');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <link rel="stylesheet" href="./style/photo_complete.css">
    <title><?php echo $_html['tg_name'];?></title>
</head>
<body>
    <div>
        <img src="<?php echo $_html['tg_dir'];?>" alt="<?php echo $_html['tg_name'];?>" />
    </div>
<?php
//关闭数据库
_close();

?>
</body>
</html>