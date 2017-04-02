/**
 * Created by lkc on 2016/11/14.
 */
window.onload=function(){
    header();
    var fm=document.getElementsByTagName('form')[0];
    var password=document.getElementById('password');

    //选中公开，隐藏密码框
    fm[2].onclick=function(){
        password.style.display='none';
    };
    //当选中加密时，弹出密码框
    fm[3].onclick=function(){
        password.style.display='block';
    };

    fm.onsubmit=function(){
        //验证相册名称长度
        if (fm.name.value.length < 2 || fm.name.value.length > 10){
            alert('相册名长度错误');
            fm.name.focus();//将光标移动到用户名输入框
            return false;
        }
        //如果选中加密，验证密码长度
        if(fm[3].checked){
            if (fm.password.value.length < 6 || fm.password.value.length > 20){
                alert('密码长度错误');
                fm.password.value = '';
                fm.password.focus();//将光标移动到用户名输入框
                return false;
            }
        }
        return true;
    }
};