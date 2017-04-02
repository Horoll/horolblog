/**
 * Created by lkc on 2016/10/25.
 */
window.onload=function(){

    header();

    //局部刷新验证码
    code();

    //表单验证
    //能在前台验证的尽量先在前台先验证，节约服务器资源
    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){
        //验证密码长度
        if(fm.password1.value.length<6){
            alert('密码长度不得小于6位');
            fm.password1.value='';//清空
            fm.password1.focus();//将光标移动到用密码输入框
            return false;
        }
        //判断两次输入密码是否一致
        if(fm.password1.value!=fm.password2.value){
            alert('两次输入密码不一致');
            fm.password2.value='';//清空
            fm.password2.focus();//将光标移动到用重复密码输入框
            return false;
        }
        //验证码长度
        if(fm.code.value.length!=4){
            alert('验证码必须是4位');
            fm.code.value='';//清空
            fm.code.focus();//将光标移动到用验证码输入框
            return false;
        }
    return true;
    }
};