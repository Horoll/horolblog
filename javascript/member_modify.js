/**
 * Created by lkc on 2016/11/1.
 */
window.onload=function(){

    header();

    //局部刷新验证码
    code();

    //修改头像弹窗
    var changeface=document.getElementById('changeface');
    changeface.onclick=function () {
            centerWindow('changeface.php','修改头像',450,550);
    };

    //表单验证
    //能在前台验证的尽量先在前台先验证，节约服务器资源
    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){

        //验证用户名长度
        if(fm.username.value.length<2 || fm.username.value.length>10){
            alert('用户名长度错误');
            fm.username.value='';//清空
            fm.username.focus();//将光标移动到用户名输入框
            return false;
        }
        //验证特殊字符
        if(/[<>\'\"\ \  ]/.test(fm.username.value)){
            alert('用户名中不得含有特殊字符');
            fm.username.value='';//清空
            fm.username.focus();//将光标移动到用户名输入框
            return false;
        }
        //验证性别
        if(fm.sex.value==''){
            alert('请选择性别');
            return false;
        }else if(fm.sex.value!='男'&&fm.sex.value!='女'){
            alert('请不要乱改表单');
            return false;
        }
        //验证签名长度
        if(fm.autograph.value.length>40){
            alert('签名不能超过40字');
            fm.autograph.focus();//将光标移动到用户名输入框
            return false;
        }
        //验证邮箱格式
        if(!/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/.test(fm.email.value)){
            alert('邮箱地址格式不正确');
            fm.email.value='';//清空
            fm.email.focus();//将光标移动到用邮箱输入框
            return false;
        }
        //验证qq格式
        if(fm.qq.value!=''){
            if(!/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value)){
                alert('QQ格式不正确');
                fm.qq.value='';//清空
                fm.qq.focus();//将光标移动到用qq输入框
                return false;
            }
        }
        //验证码长度
        if(fm.code.value.length!=4){
            alert('验证码必须是4位');
            fm.code.value='';//清空
            fm.code.focus();//将光标移动到用验证码输入框
            return false;
        }
        return true;
    };

};

//弹出窗口函数
function  centerWindow(url,name,height,width){
    //使弹窗居中
    var left=(screen.width-width)/2;
    var top=(screen.height-height)/2;
    //设置弹窗大小、位置
    window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}