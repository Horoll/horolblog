
/**
 * Created by lkc on 2016/10/29.
 */
window.onload=function() {

    code();
    //登陆验证
    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){
        //验证用户名长度
        if(fm.username.value.length<2||fm.username.value.length>10){
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
        if(fm.password.value.length<6){
            alert('密码长度不得小于6位');
            fm.password.value='';//清空
            fm.password.focus();//将光标移动到用密码输入框
            return false;
        }
        //验证码长度
        if(fm.code.value.length!=4){
            alert('验证码必须是4位');
            fm.code.value='';//清空
            fm.code.focus();//将光标移动到用验证码输入框
            return false;
        }
    }
};