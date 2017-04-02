<?php

//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
}


/**
 * _runtime():用来获取当前精确时间的时间戳
 * @access public 函数对外公开
 * @return float 函数返回浮点型
 */
function _runtime(){
    $_mtime=explode(' ',microtime());
    return $_mtime[1]+$_mtime[0];
}

/**
 * _timeinterval():检测时间间隔是否大于设置的值
 * @param int $_nowtime 当前时间
 * @param int $_pretime 指定的过去的某个时间
 * @param int $_interval 设置的时间间隔
 * @return bool 如果大于设定的值，返回true；否则返回false
 */
function _timeinterval($_nowtime,$_pretime,$_setinterval){
    if($_nowtime-$_pretime>$_setinterval){
        return true;
    }else{
        return false;
    }
}

/**
 * _alert_back():弹出一个对话框框并且返回该页面
 * @access public
 * @param string $_info 对话框显示出的文字
 * @return void
 */
function _alert_back($_info){
    echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
    exit;
}

/**
 * _alert_close
 * @param string $_info 弹窗显示的信息
 */
function _alert_close($_info){
    echo "<script type='text/javascript'>alert('$_info');window.close();</script>";
    exit;
}

/**
 * _formvalue():根据表单name获取value
 * @access public
 * @param  string $key 表单的name
 * @return string 表单的value
 */
function _formvalue($name){
    return $_POST[$name]=isset($_POST[$name])?$_POST[$name]:'';
}


/**
 * _mysql_string():转义字符串或数组
 * @access public
 * @param string $_string 输入的字符串或数组
 * @return string 返回转义后的字符串
 */
function _mysql_string($_string){
    //如果开启了自动转义，就不需要转义
    if(!GPC){
        if(is_array($_string)){
            foreach($_string as $_key=>$_value){
                //采用递归将数组里所有元素转义
                $_string[$_key]=_mysql_string($_value);
            }
        }else{
            $_string=addslashes($_string);
        }
    }
    return $_string;
}

/**
 * _html():转义html标签
 * @param string $_string 原字符串或数组
 * @return string 转义以后的字符串
 */
function _html($_string){
    if(is_array($_string)){
        foreach($_string as $_key=>$_value){
            $_string[$_key]=_html($_value);
        }
    }else{
        $_string=htmlspecialchars($_string);
    }
    return $_string;
}

/**
 * _set_xml():生成存放用户信息的xml文件
 * @param string $_xmlfile 生成的xml文件名
 * @param array $_clean 存放用户信息的数组
 */
function _set_xml($_xmlfile,$_clean){

    $_fp=@fopen('xml/'.$_xmlfile.'.xml','w');
    if(!$_fp){
       exit('系统错误，文件不存在');
    }
    flock($_fp,LOCK_EX);

    //将数据写入xml文件
    $_string="<?xml version=\"1.0\" encodin=\"utf-8\"?>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="<vip>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    //id
    $_string="\t<id>{$_clean['id']}</id>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    //用户名
    $_string="\t<username>{$_clean['username']}</username>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    //性别
    $_string="\t<sex>{$_clean['sex']}</sex>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    //头像地址
//    $_string="\t<face>images/face/default.png</face>\r\n";
//    fwrite($_fp,$_string,strlen($_string));
    //邮箱地址
    $_string="\t<email>{$_clean['email']}</email>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="</vip>";
    fwrite($_fp,$_string,strlen($_string));
    flock($_fp,LOCK_UN);
    fclose($_fp);
}


/**
 * _get_xml():获取注册时生成的xml文件里的内容
 * @param string $_xmlpath:xml文件的路径
 * @return array:储存内容的数组
 */
function _get_xml($_xmlpath){
    //读取xml文件
    if(file_exists($_xmlpath)){
        //将xml文件的内容放进一个数组里
        $_xml=file_get_contents($_xmlpath);
        $_html=array();
        //正则表达式进行匹配
        preg_match_all('/<vip>(.*)<\/vip>/s',$_xml,$_dom);
        foreach($_dom[1] as $_value){
            preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
            preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
            preg_match_all('/<sex>(.*)<\/sex>/s',$_value,$_sex);
            preg_match_all('/<email>(.*)<\/email>/s',$_value,$_email);
        }
        $_html['id']=$_id[1][0];
        $_html['username']=$_username[1][0];
        $_html['sex']=$_sex[1][0];
        $_html['email']=$_email[1][0];
    }else{
        _alert_back('xml文件不存在');
    }
    return $_html;
}

/**
 * _title():截取一段信息前n个字作为标题，默认15个字
 * @access public
 * @param string $_string 输入的内容
 * @return string 截取的字符串开头
 */
function _title($_string,$_length=15){
    if(mb_strlen($_string,'utf-8')>$_length){
        $_string=mb_substr($_string,0,$_length,'utf-8').'...';
    }
    return $_string;
}

/**
 * _tag():返回tag里第一个逗号前的字符串，最大长度为5
 * @access public
 * @param string $_tag tag的内容
 * @return string 显示在首页的tag
 */
function _tag($_tag,$_length=3){
    $_tag=_title(strtok($_tag,',，'),$_length);
    return $_tag;
}
/**
 * _ubb():将ubb标签转换成html标签，在页面显示出效果
 * @access public
 * @param string $_string 从数据库里读取的博客内容
 * @return mixed|string
 */
function _ubb($_string){
    $_string=nl2br($_string);
    $_string=preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$_string);
    $_string=preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
    $_string=preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
    $_string=preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline">\1</span>',$_string);
    $_string=preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$_string);
    $_string=preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
    $_string=preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" target="_blank">\1</a>',$_string);
    $_string=preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:\1">\1</a>',$_string);
    $_string=preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="图片" />',$_string);
    $_string=preg_replace('/\[text-align=(.*)\](.*)\[\/text-align\]/U','<div style="text-align:\1">\2</div>',$_string);
    return $_string;
}

/**
 * _face_dir():获取指定用户名的头像，若没有上传头像，则用默认头像
 * @param string $_username 用户名
 * @return string 返回头像图片的地址
 */
function _face_dir($_username){
    if(file_exists('./images/face/'.$_username.'.png')){
        return './images/face/'.$_username.'.png';
    }else{
        return  './images/face/default.png';
    }
}

/**
 *  _pageinfo():得到出分页所需要的全局变量
 * @param int $_num 用户总数
 * @param int $_size 每个页面要显示的用户个数
 * 生成的全局变量：
 * $_page：当前所在的页数
 * $_pageabsolute：总页数
 * $_pagenum：当前页面从第几个用户开始显示
 * $_pagesize：每页显示的用户数量
 */
function _pageinfo($_num,$_size){
    global $_page,$_pageabsolute,$_pagenum,$_pagesize;

    //接收当前的页数,没有点击按钮时，默认为第一页
    if(!isset($_GET['page'])){
        $_page=1;
    }elseif(!is_numeric($_GET['page'])) {
        $_page = 1;
    }elseif ($_GET['page']<1) {
        $_page = 1;
    }elseif (!is_int($_GET['page'])){
        $_page=intval($_GET['page']);
    }else {
        $_page = $_GET['page'];
    }
    $_pagesize=$_size;
    //求出应有的总页数，用ceil函数进一取整
    $_pageabsolute=ceil($_num/$_pagesize);
    //当前页面从第几条开始
    $_pagenum=($_page-1)*$_pagesize;
}


/**
 * _paging():分页模块
 * @access public
 * @return void
 * 需要的全局变量：
 * $_page：当前所在的页数
 * $_pageabsolute：总页数
 */
function _paging(){
    //设置全局变量，用于接收外部的变量
    global $_page,$_pageabsolute,$_id;

    //判断$_page是否合法
    if(!is_numeric($_page)){
        $_page=1;
    }elseif (!is_int($_page)){
        $_page=intval($_page);
    }elseif ($_page<0){
        $_page=1;
    }elseif ($_page>$_pageabsolute){
        $_page=$_pageabsolute;
    }
    //当总页数>1页时才显示
    if($_pageabsolute>1&&$_pageabsolute<7){
        echo '<div id="page">';
        echo '<ul>';
        if($_page!=1){
            echo '<li class="page"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'" class="pagechange">上一页</a></li>';
        }
        for($i=1;$i<=$_pageabsolute;$i++){
            if($_page==($i)){
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$i.'" class="numb" id="selected">'.($i).'</a></li>';
            }else{
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$i.'" class="numb">'.($i).'</a></li>';
            }
        }
        if($_page!=$_pageabsolute){
            echo '<li class="page"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'" class="pagechange">下一页</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    //当总页数>=7页时，只保留三个数字
    if($_pageabsolute>=7){
        echo '<div id="page">';
        echo '<ul>';
        //当页数为1时，不现实上一页
        if($_page!=1){
            echo '<li class="page"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'" class="pagechange">上一页</a></li>';
        }

        switch ($_page){
            case 1;
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_page.'" class="numb" id="selected">'.($_page).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page=2" class="numb">2</a></li>';
                echo '<li>……</li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'" class="numb">'.($_pageabsolute).'</a></li>';
                break;
            case 2;
                echo '<li class="number"><a href="' . SCRIPT . '.php?' . $_id . 'page=1" class="numb">1</a></li>';
                echo '<li class="number"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $_page . '" class="numb" id="selected">' . ($_page) . '</a></li>';
                echo '<li class="number"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . ($_page + 1) . '" class="numb">' . ($_page + 1) . '</a></li>';
                echo '<li>……</li>';
                echo '<li class="number"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $_pageabsolute . '" class="numb">' . ($_pageabsolute) . '</a></li>';
                break;
            case 3;
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page=1" class="numb">1</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'" class="numb">'.($_page-1).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_page.'" class="numb" id="selected">'.($_page).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'" class="numb">'.($_page+1).'</a></li>';
                echo '<li>……</li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'" class="numb">'.($_pageabsolute).'</a></li>';
                break;
            case $_pageabsolute;
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page=1" class="numb">1</a></li>';
                echo '<li>……</li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'" class="numb">'.($_page-1).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_page.'" class="numb" id="selected">'.($_page).'</a></li>';
                break;
            case $_pageabsolute-1;
                echo '<li class="number"><a href="' . SCRIPT . '.php?' . $_id . 'page=1" class="numb">1</a></li>';
                echo '<li>……</li>';
                echo '<li class="number"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . ($_page - 1) . '" class="numb">' . ($_page - 1) . '</a></li>';
                echo '<li class="number"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . $_page . '" class="numb" id="selected">' . ($_page) . '</a></li>';
                echo '<li class="number"><a href="' . SCRIPT . '.php?' . $_id . 'page=' . ($_page + 1) . '" class="numb">' . ($_page + 1) . '</a></li>';
                break;
            case $_pageabsolute-2;
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page=1" class="numb">1</a></li>';
                echo '<li>……</li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'" class="numb">'.($_page-1).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_page.'" class="numb" id="selected">'.($_page).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'" class="numb">'.($_page+1).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'" class="numb">'.($_pageabsolute).'</a></li>';
                break;
            default;
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page=1" class="numb">1</a></li>';
                echo '<li>……</li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'" class="numb">'.($_page-1).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_page.'" class="numb" id="selected">'.($_page).'</a></li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'" class="numb">'.($_page+1).'</a></li>';
                echo '<li>……</li>';
                echo '<li class="number"><a href="'.SCRIPT.'.php?'.$_id.'page='.$_pageabsolute.'" class="numb">'.($_pageabsolute).'</a></li>';
                break;
        }

        //当页数为最后一页时，不显示下一页
        if($_page!=$_pageabsolute){
            echo '<li class="page"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page+1).'" class="pagechange">下一页</a></li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}


/**
 * _location():弹出一个对话框并且转跳到另一个界面
 * @access public
 * @param string $_info 对话框上显示的信息
 * @param string $_url  转跳的页面地址
 * @return void
 */
function _location($_info,$_url){
    if($_info==null){
        header('Location:'.$_url);
    }else{
        echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
        exit;
    }

}

/**
 * _login_sate():判断是否已经登录
 * @access public
 * @return bool
 */
function _login_sate(){
    return (isset($_COOKIE['uniqid']));
}

/**
 * _login_sate():判断是否为管理员登陆
 * @access public
 * @return bool
 */
function _manage_sate(){
    return ( isset($_COOKIE['username']) && isset($_COOKIE['uniqid']) && isset($_COOKIE['admin']) );
}

/**
 * _session_destroy():如果存在session，清除所有session
 */
function _session_destroy(){
    if(isset($_SESSION)){
        session_destroy();
    }
}


/**
 * _cookie_destroy():删除cookie和session
 * @access public
 * @param string $_cookie cookie的name
 */
function _cookie_destroy($_cookie){
    setcookie($_cookie,'',time()-1);
    _session_destroy();
}


/**
 * _sha1_uniqid()：生成一个唯一标识符
 * @access public
 * @return string 返回一个唯一标识符
 */
function _sha1_uniqid(){
    return _mysql_string(sha1(uniqid(rand(),true)));
}


/**
 * _uniqid()：判断唯一标识符是否正常,用于修改、删除等敏感操作
 * 通过username cookie 找到当前用户名对应的uniqid，并与本地cookie的uniqid进行对比
 * @return array|null 如果正常，返回唯一标识符；如果异常，弹出报错
 */
function _uniqid(){
    if(!isset($_COOKIE['username'])){
        _alert_back('请先登录哦');
    }
    $_row=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1");
    if($_row[0]['tg_uniqid']!=$_COOKIE['uniqid'])
        _alert_back('唯一标识符异常');
    return $_COOKIE['uniqid'];
}

/**
 * _check_code()：检查验证码输入是否正确
 * @access public
 * @param string $_code1 输入的验证码
 * @param string $_code2 后台生成的验证码
 * @return void
 */
function _check_code($_code1,$_code2){
    if($_code1!=$_code2){
        _alert_back('验证码输入错误');
    }
}


/**
 * _delete_dir():删除一个文件夹以及文件夹里所有文件或文件夹
 * @param string $dir 文件夹路径
 * @return bool 是否删除成功
 */
function _delete_dir($dir)
{
    //打开目录句柄
    $dh = opendir($dir);
    //依次读取目录下的文件
    while ($file = readdir($dh))
    {
        //当
        if ($file != "." && $file != "..")
        {
            //获得文件完整路径
            $fullpath = $dir . "/" . $file;
            //如果不是目录（是文件），就直接删除
            if (!is_dir($fullpath))
            {
                unlink($fullpath);
            }
            //如果是文件夹，则递归
            else{
                _delete_dir($fullpath);
            }
        }
    }
    closedir($dh);

    //最后删除剩余的空文件夹
    if (rmdir($dir))
    {
        return true;
    } else
    {
        return false;
    }
}

/**
 * _code():生成验证码图片
 * @access pulic
 * @param int $_width 验证码宽度
 * @param int $_height 验证码高度
 * @param int $_rnd_code 验证码位数
 * @return void
 */
function _code($_width=100,$_height=50,$_rnd_code=4){
    $_nmsg=NULL;
//随机0-15的随机数，并且转换为十六进制，循环4位
    for($i=0;$i<$_rnd_code;$i++){
        $_nmsg.=dechex(mt_rand(0,15));
    }

    /**
     * 将生成的验证码保存在session里
     * session是一个数组，每个元素保存验证码的一个字符
     */
    $_SESSION['code']=$_nmsg;

//创建验证码图片
    $_img=imagecreatetruecolor($_width,$_height);

//选择验证码图片背景色
    $_backgroundcolor=imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));

//将背景颜色填充到验证码图片上
    imagefill($_img,0,0,$_backgroundcolor);

//在图片上随机画出6条线
    for($i=0;$i<6;$i++){
        //随机颜色
        $_rnd_color=imagecolorallocate($_img,mt_rand(0,200),mt_rand(0,200),mt_rand(0,200));

        //随机出线条的位置，长度
        imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_rnd_color);
    }

//随机雪花
    for($i=0;$i<10;$i++){
        //随机颜色
        $_rnd_color=imagecolorallocate($_img,mt_rand(150,200),mt_rand(150,200),mt_rand(150,200));

        //随机出雪花位置
        imagestring($_img,mt_rand(1,5),mt_rand(0,$_width),mt_rand(0,$_height),'*',$_rnd_color);
    }

//将验证码转换成图片显示在背景图上
    for($i=0;$i<strlen($_SESSION['code']);$i++){
        //随机颜色
        $_rnd_color=imagecolorallocate($_img,mt_rand(0,150),mt_rand(0,150),mt_rand(0,150));

        //随机验证码大小、位置
        imagestring($_img,5,$i*$_width/strlen($_SESSION['code'])+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rnd_color);
    }

//输出图像
    header('Content-Type:image/png');
    imagepng($_img);

//销毁图像
    imagedestroy($_img);
}




/**_thumb():根据设置的最大宽度，生成缩略图
 * @param string $_filename 图片路径
 * @param int $_maxwidth 图片允许的最大宽度
 * @param int $_maxheight 图片允许的最大高度
 */
function _thumb($_filename,$_maxwidth,$_maxheight){
    //生成缩略图
    //生成png标头文件
    header('Content-type:image/png');

    /**
     * 获取文件扩展名:
     * 首先将文件名倒序，用explode以.分开，取数组中的第一个字符串
     * 再将第一个字符串倒序得到后缀名
     * 防止文件命中含有多个'.'，直接用explode分开可能得不到文件名最后的后缀名
     */
    $_strrev=strrev($_filename);
    $_tmp=explode('.',$_strrev);
    $_extension=strrev($_tmp[0]);

    //获得文件信息，长、高
    list($_width,$_height)=getimagesize($_filename);

    //首先根据设置的最大宽度对图片进行缩放
    if($_width>$_maxwidth){
        $_new_width=$_maxwidth;
        $_new_height=$_height/$_width*$_new_width;
    }else{
        $_new_width=$_width;
        $_new_height=$_height;
    }

    //如果缩放后的高度大于$_maxheight，再对图片进行缩放
    if($_new_height>$_maxheight){
        $_new_width=$_width/$_height*$_maxheight;
        $_new_height=$_maxheight;
    }

    //创建一个新大小的画布
    $_new_image=imagecreatetruecolor($_new_width,$_new_height);
    //按照已有的图片创建一个画布
    switch($_extension){
        case 'jpg':$_image=imagecreatefromjpeg($_filename);
            break;
        case 'png':$_image=imagecreatefrompng($_filename);
            break;
        case 'gif':$_image=imagecreatefromgif($_filename);
            break;
    }

    //将原图采集后重新复制到新图上，就形成了缩略图
    imagecopyresampled($_new_image,$_image,0,0,0,0,$_new_width,$_new_height,$_width,$_height);
    //生成新的png图
    imagepng($_new_image);
    //销毁
    imagedestroy($_new_image);
    imagedestroy($_image);
}


/**
 * _send_mail():发送邮件函数（需要提前调用email.class.php文件）
 * @param string $smtpemailto 对方邮箱
 * @param string $mailsubject 邮件主题
 * @param string $mailbody 邮件内容
 * @param string $mailtype 邮件类型（默认为HTML）
 * @return bool 邮件是否发送成功
 */
function _send_mail($smtpemailto,$mailsubject,$mailbody,$mailtype='HTML'){

    date_default_timezone_set('PRC');  // 'Asia/Chongqing' or 'PRC'
    $smtpserver = "smtp.126.com";//SMTP服务器
    $smtpserverport =25;//SMTP服务器端口
    $smtpusermail = "horol_lkc@126.com";//SMTP服务器的用户邮箱
    $smtpuser = "horol_lkc";//SMTP服务器的用户帐号
    $smtppass = "l87550513";//不是邮箱登录密码，是用来授权第三方登录的授权码
    $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $smtp->debug = false;//是否显示发送的调试信息
    $res=$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
    return $res;
}

?>
