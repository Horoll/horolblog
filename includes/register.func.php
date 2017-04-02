<?php

//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
}

if(!function_exists('_alert_back')) {
    exit('_alert_back函数不存在，请检查代码');
}

if(!function_exists('_mysql_string')) {
    exit('_mysql_string函数不存在，请检查代码');
}


/**
 * _check_uniqid():检查唯一标识符是否正确
 * @access public
 * @param string $_uniqid1 表单提交的唯一标识符
 * @param string $_uniqid2 生成session里的唯一标识符
 * @return string 转移处理后的唯一标识符
 */
function _check_uniqid($_uniqid1,$_uniqid2){
    if(strlen($_uniqid1)!=40 || $_uniqid1!=$_uniqid2){
        _alert_back('唯一标识符异常');
    }else
    return _mysql_string($_uniqid1);
}


/**
 * _check_username():过滤用户名
 * @access public
 * @param string $_username 输入的用户名
 * @param int $_min 最小长度，默认值2
 * @param int $_max 最大长度，默认值10
 * @return string   过滤、转义处理后的用户名
 */
function _check_username($_username,$_min=2,$_max=10){
    global $_system;
    //去掉两边的空格
    $_username=trim($_username);

    //判断长度
    if(mb_strlen($_username,'utf-8')<$_min || mb_strlen($_username,'utf-8')>$_max){
        _alert_back('用户名长度错误');
    }

    //去掉特殊字符
    $_char_pattern='/[<>\'\"\ \ ]/';
    if(preg_match_all($_char_pattern,$_username)){
        _alert_back('用户名中不得含有特殊字符');
    }

    //获得敏感字符(需要替换的字符串)，放在数组中
    $_string=explode('|',$_system['tg_string']);
    //用户名是否含有敏感字符串
    foreach($_string as $value){
        if(substr_count($_username,$value)!=0){
            _alert_back('用户名不得包含敏感字符');
        }
    }

    //将用户名转义输出，用于存到数据库
    return _mysql_string($_username);
}

/**
 * _check_password():过滤、检查、加密密码
 * @access public
 * @param string $_password 输入密码
 * @param int $_min_num      最短密码长度，默认只是6
 * @return string           返回加密后的密码
 */
function _check_password($_password,$_min_num=6){
    //判断密码
    if(strlen($_password)<6){
        _alert_back('密码长度不能小于'.$_min_num.'位');
    }
    //返回加密的密码
    return _mysql_string(md5(sha1($_password)));
}

/**
 * _comparison_password():过滤、检查、对比、加密密码
 * @access public
 * @param string $_password1 输入密码
 * @param string $_password2 重复密码
 * @param int $_min_num      最短密码长度，默认只是6
 * @return string           返回加密后的密码
 */
function _comparison_password($_password1,$_password2,$_min_num=6){
    //判断密码
    if(strlen($_password1)<6){
        _alert_back('密码长度不能小于'.$_min_num.'位');
    }
    //确认两次密码是否相同
    if($_password1!=$_password2) {
        _alert_back('两次输入密码不一致');
    }
    //返回加密的密码
    return _mysql_string(md5(sha1($_password1)));
}


/**
 * _check_question():处理密码提示
 * @access public
 * @param string $_question 输入的密码提示
 * @param int $_min 密码提示最小长度
 * @param int $_max 密码提示最长长度
 * @return string   过滤、转义处理后的密码提示
 */
function _check_question($_question,$_min=2,$_max=20){
    //判断密码提示长度
    if(mb_strlen($_question,'utf-8')<$_min || mb_strlen($_question,'utf-8')>$_max){
        _alert_back('安全问题长度错误');
    }
    //返回密码提示
    return _mysql_string($_question);
}


/**
 * _check_answer():处理提示答案
 * @access public
 * @param string $_question 输入的密码提示
 * @param string $_answer   输入的提示答案
 * @param int $_min 提示答案最小长度
 * @param int $_max 提示答案最大长度
 * @return string   加密后的合法提示答案
 */
function _check_answer($_question,$_answer,$_min=2,$_max=20){
    $_answer=trim($_answer);
    //判断提示答案长度
    if(mb_strlen($_answer,'utf-8')<$_min || mb_strlen($_answer,'utf-8')>$_max){
        _alert_back('问题答案长度错误');
    }
    //判断密码提示和提示答案是否一致
    if($_question===$_answer){
        _alert_back('密码提示和提示答案不能一致');
    }
    //加密返回
    return _mysql_string(md5(sha1($_answer)));
}


/**
 * _check_sex():处理性别选择
 * @accsess public
 * @param string $_sex 选择的性别
 * @return string 转义以后的性别
 */
function _check_sex($_sex){
    if($_sex==null){
        _alert_back('请选择性别');
    }elseif ($_sex!='男' && $_sex!='女'){
        _alert_back('请不要乱改表单');
    }
    return _mysql_string($_sex);
}


/**
 * _check_email:检查邮箱格式
 * @access public
 * @param string $_email 输入的邮箱地址
 * @return null 如果用户没填邮箱，返回NULL
 * @return string $_email 返回合法邮箱
 */
function _check_email($_email){
//    //邮箱地址为空时返回NULL
//    if($_email==NULL){
//        return NULL;
//    }
    if(!preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$_email))
        //用正则判断邮箱地址是否合法
    {
        _alert_back('邮箱格式不正确');
    }
    return _mysql_string($_email);
}


/**
 * _check_qq():检查qq格式
 * @access public
 * @param string $_qq 输入的qq号码
 * @return null 如果用户没填，返回NULL
 * @return string $_qq 返回合法的qq
 */
function _check_qq($_qq){
    //qq为空时返回NULL
    if($_qq==NULL){
        return NULL;
    }else{
        if(!preg_match('/^[1-9]{1}[0-9]{4,9}$/',$_qq)){
            _alert_back('QQ格式不正确');
        }
    }
    return _mysql_string($_qq);
}

/**
 * _check_content():判断发送的信息长度是否合法
 * @param string $_content 发送的信息内容
 * @param int $_min 最短长度（默认为0）
 * @param int $_max 最长长度（默认为200）
 * @return string  处理后的信息
 */
function _check_content($_content,$_min=0,$_max=200){
    global $_system;
    //去掉两边的空格
    $_content=trim($_content);
    //判断长度
    if(mb_strlen($_content,'utf-8')<$_min || mb_strlen($_content,'utf-8')>$_max){
        _alert_back('长度不合法');
    }
    //获得敏感字符(需要替换的字符串)，放在数组中
    $_string=explode('|',$_system['tg_string']);
    //使用循环依次替换敏感字符
    foreach($_string as $_value){
        $_content=str_ireplace($_value,'*',$_content);
    }

    return _mysql_string($_content);
}


/**
 * _check_gift()：判断提交的礼物数量是否合格
 * @access public
 * @param int $_num 表单提交的礼物数量
 * @return int 返回整数
 */
function _check_gift($_num){
    if($_num>0&&$_num<=100){
        return intval($_num);
    }else{
        _alert_back('请不要修改表单');
    }
    return null;
}

?>
