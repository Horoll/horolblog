/**
 * Created by lkc on 2016/11/18.
 */
window.onload=function(){
    header();
    var up=document.getElementById('upload');
    //打开选择的封面弹窗
    up.onclick=function(){
        centerWindow('upimg.php?dir='+this.title,'选择图片',350,650);
    };

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
        //判断相册描述长度
        if(fm.name.content.length>200){
            alert('相册描述不得大于200位');
            fm.content.focus();
            return false;
        }
        return true;
    };
};

//弹出窗口函数
function  centerWindow(url,name,height,width) {
    //使弹窗居中
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;
    //设置弹窗大小、位置
    window.open(url, name, 'height=' + height + ',width=' + width + ',top=' + top + ',left=' + left);
}
