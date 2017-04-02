/**
 * Created by lkc on 2016/10/25.
 */
window.onload=function(){

    //局部刷新验证码
    code();

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
        //验证密码提示长度
        if(fm.question.value.length<2 || fm.question.value.length>20){
            alert('安全问题长度错误');
            fm.question.value='';//清空
            fm.question.focus();//将光标移动到用密码提示输入框
            return false;
        }
        //验证提示答案长度
        if(fm.answer.value.length<2 || fm.answer.value.length>20){
            alert('问题答案长度错误');
            fm.answer.value='';//清空
            fm.answer.focus();//将光标移动到用密码提示输入框
            return false;
        }
        //判断密码提示和提示答案是否一致
        if(fm.answer.value==fm.question.value){
            alert('密码提示和提示答案不能一致');
            fm.answer.value='';//清空
            fm.answer.focus();//将光标移动到用重复密码输入框
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
    }

};