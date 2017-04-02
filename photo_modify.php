<?php
//打开session
session_start();

//定义一个常量，用来授权调用includes中的模块
define('IN_TG',true);
//定义一个常量，用来指定本页的内容
define('SCRIPT','photo_add');

//引入common文件
//用_FILE_转换成绝对路径，效率更高
require dirname(__FILE__).'/includes/common.inc.php';

//开始计时
$_start_time=_runtime();

//判断是否已经登录
if(!_login_sate()){
    _location('请先登录','./login.php');
}

//必须是管理员才有权限使用
if(!_manage_sate()){
    _location('没有管理员权限','./index.php');
}

//修改相册
if(_formvalue('action')=='modify'){
    //对比本地与数据库里的唯一标识符是否匹配，防止伪造cookie修改数据
    _uniqid();

    //调用register函数库
    include ROOT_PATH.'/includes/register.func.php';

    //创建一个数组，用来存放提交的合法数据
    $_clean=array();
    $_clean['id']=_formvalue('id');
    $_clean['name']=_check_username(_formvalue('name'));
    $_clean['type']=_formvalue('type');
    //当选择加密时才检查密码长度,否则密码为空
    if($_clean['type']==1){
        $_clean['password']=_check_password(_formvalue('password'));
    }else{
        $_clean['password']='';
    }
    $_clean['face']=_formvalue('url');
    $_clean['content']=_check_content(_formvalue('content'),0,20);
    $_clean=_mysql_string($_clean);
    //var_dump($_clean);

    _query("UPDATE
                    tg_dir
            SET
                    tg_name='{$_clean['name']}',
                    tg_type='{$_clean['type']}',
                    tg_password='{$_clean['password']}',
                    tg_face='{$_clean['face']}',
                    tg_content='{$_clean['content']}'
            WHERE
                    tg_id='{$_clean['id']}'
                    LIMIT 1
 ");
    //判断数据库里是否只改动（新增）了一条数据
    if(_affected_rows()==1){
        //关闭数据库
        _close();
        //跳转
        _location('修改相册成功','photo.php');
    }else{
        //关闭数据库
        _close();
        //跳转
        _alert_back('没有进行任何修改');
    }
}

//读取相册信息
if(isset($_GET['id'])){
    //按照id寻找相册信息
    $_row_photo=_fetch_array("SELECT
                                    tg_id,
                                    tg_name,
                                    tg_type,
                                    tg_face,
                                    tg_content,
                                    tg_dir
                              FROM
                                    tg_dir
                              WHERE
                                    tg_id='{$_GET['id']}'
                                    LIMIT 1
                            ");
    if(!$_row_photo){
        _alert_back('该相册不存在');
    }
    //var_dump($_row_photo);

    $_html=array();
    foreach($_row_photo as $_value1){
        foreach($_value1 as $_key=>$_value2){
            $_html[$_key]=_html($_value2);
        }
    }
    //var_dump($_html);
    if($_html['tg_type']==0){
        $_html['type']='<label><input type="radio" name="type" checked="checked" value="0" />  公开</label><label><input type="radio" name="type" value="1" />  加密</label>';
    }else{
        $_html['type']='<label><input type="radio" name="type" value="0" />  公开</label><label><input type="radio" name="type" checked="checked" value="1" />  加密</label>';
    }

}else{
    _alert_back('该相册不存在');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "
http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <title>修改相册</title>
    <link rel = "Shortcut Icon" href="./images/jumplist_useronline.ico">
    <?php include ROOT_PATH.'/includes/title.inc.php'?>
</head>
<body>
<?php
//调用header
require ROOT_PATH.'/includes/header.inc.php';
?>
<script type="text/javascript" src="javascript/photo_modify.js"></script>
    <div id="photo">
        <h2>修改相册</h2>
        <form method="post" action="photo_modify.php">
            <input type="hidden" name="action" value="modify"/>
            <dl>
                <dd>相册名称：<input type="text" name="name" class="text" value="<?php echo $_html['tg_name'];?>" /></dd>
                <dd>类型：<?php echo $_html['type'];?></dd>
                <dd id="password" <?php if($_html['tg_type']==1){echo 'style="display:block;"';}?>>密码：<input type="password" name="password" class="text"/></dd>
                <dd><a href="javascript:;" title="<?php echo $_html['tg_dir'];?>" id="upload">选择封面</a><input type="text" name="url" id="url" value="<?php echo $_html['tg_face'];?>" readonly="readonly" class="text"/></dd>
                <dd>相册描述：<textarea name="content"><?php echo $_html['tg_content']?></textarea></dd>
                <dd><input type="submit" value="修改相册" class="submit" /></dd>
            </dl>
            <input type="hidden" name="id" value="<?php echo $_GET['id']?>"/>
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