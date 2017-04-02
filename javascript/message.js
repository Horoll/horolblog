/**
 * Created by lkc on 2016/11/2.
 */
window.onload=function(){
    //局部刷新验证码
    code();

    //先用js验证表单
    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){
        //验证信息内容长度
        if(fm.content.value.length>200){
            alert('信息内容太长啦！');
            fm.content.focus();//将光标移动到用密码输入框
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
    };
};