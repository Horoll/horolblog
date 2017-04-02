<?php
//防止其他人调用这个模块
if(!defined('IN_TG')) {
    exit('Accsee Defined!');
}

/**
 * _connect():连接数据库
 * @access public
 * @return void
 */
function _connect()
{
    //定义全局变量$_conn,在函数外部也能调用
    global $_conn;
    $_conn=mysqli_connect(DB_HOST, DB_USER,DB_PWD);
    if (!$_conn) {
        exit('数据库连接失败：'.mysqli_error($_conn));
    }
}

/**
 * _select_db():选择数据库
 * @access public
 * @return void
 */
function _select_db(){
    global $_conn;
    if(!mysqli_select_db($_conn,DB_NAME)){
        exit('找不到数据库'.mysqli_error($_conn));
    }
}

/**
 * _set_names():设置字符编码
 * @access public
 * @return void
 */
function _set_names(){
    global $_conn;
    if(!mysqli_query($_conn,'SET NAMES UTF8')){
        exit('字符编码错误'.mysqli_error($_conn));
    }
}

/**
 * _query():执行sql语句
 * @access public
 * @param string $_sql sql操作语句
 * @return string 返回结果集
 */
function _query($_sql){
    global $_conn;
    if(!$result=mysqli_query($_conn,$_sql)){
        exit('SQL执行失败'.mysqli_error($_conn).mysqli_errno($_conn));
    }
    return $result;
}

/**
 * _fetch_array():根据sql语句遍历数据库。返回一个数组，键名是数据库的表单结构名
 * @access public
 * @param string $_sql sql操作语句
 * @return array|null
 */
function _fetch_array($_sql){
    return mysqli_fetch_all(_query($_sql),MYSQLI_ASSOC);
}

/**
 * _num_rows():返回数据库中查找条件的数据个数
 * @access public
 * @param string $_sql sql操作语句
 * @return int 返回数据个数
 */
function _num_rows($_sql){
    return mysqli_num_rows(_query($_sql));
}

/**
 * _affected_rows():返回数据库里被影响到的数据条数
 * @access public
 * @return int 返回影响到的记录数
 */
function _affected_rows(){
    global $_conn;
    return mysqli_affected_rows($_conn);
}

/**
 * _is_repeat():判断数据在数据库里是否已经存在
 * @access public
 * @param string $_sql sql操作语句
 * @param string $_info 弹窗上显示的文字
 * @return void
 */
function _is_repeat($_sql,$_info){
    if(_fetch_array($_sql)){
        _alert_back($_info);
    }
}

/**
 * _close():关闭数据库
 * @access public
 */
function _close(){
    global $_conn;
    if(!mysqli_close($_conn)){
        exit('数据库关闭异常'.mysqli_error($_conn));
    }
}

?>
