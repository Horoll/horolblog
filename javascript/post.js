/**
 * Created by lkc on 2016/11/7.
 */
window.onload=function(){
    header();

    var ubb=document.getElementById('ubb');
    var ubbing=ubb.getElementsByTagName('li');
    var fm=document.getElementsByTagName('form')[0];
    var font=document.getElementById('font');
    var color=document.getElementById('color');
    var html=document.getElementsByTagName('html')[0];

    //在其它地方点一下，下拉框消失
    html.onmouseup=function(){
        font.style.display='none';
        color.style.display='none';
    };

    ubbing[0].onclick=function(){
        font.style.display='block';
    };
    ubbing[1].onclick=function(){
        content('[b][/b]');
    };
    ubbing[2].onclick=function(){
        content('[i][/i]');
    };
    ubbing[3].onclick=function(){
        content('[u][/u]');
    };
    ubbing[4].onclick=function(){
        content('[s][/s]');
    };
    ubbing[5].onclick=function(){
        color.style.display='block';
        fm.t.focus();
    };
    ubbing[6].onclick=function(){
        var url=prompt('请输入网址：','http://');
        if(url){
            if(/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(url)){
                content('[url]'+url+'[/url]');
            }else{
                alert('链接地址不符合要求');
            }
        }
    };
    ubbing[7].onclick=function(){
        var email=prompt('请输入邮箱地址：');
        if(email){
            if(/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/.test(email)){
                content('[email]'+email+'[/email]');
            }else{
                alert('邮箱地址不符合要求');
            }
        }
    };
    ubbing[8].onclick=function(){
        var img=prompt('请输入图片地址：');
        if(img){
            content('[img]'+img+'[/img]');
        }
    };
    ubbing[10].onclick=function(){
        content('[text-align=left][/text-align]');
    };
    ubbing[11].onclick=function(){
        content('[text-align=center][/text-align]');
    };
    ubbing[12].onclick=function(){
        content('[text-align=right][/text-align]');
    };
    function content(string){
        fm.content.value+=string;
    }
    fm.t.onclick=function(){
        showcolor(this.value);
    };

    //验证提交内容是否合法
    fm.onsubmit=function(){
        if(fm.title.value.length<2 || fm.title.value.length>40){
            alert('标题字数问题比较大啊');
            fm.title.focus();
            return false;
        }
        if(fm.content.value.length<10 || fm.content.value.length>99999){
            alert('博客字数问题比较大啊');
            fm.content.focus();
            return false;
        }
        if(fm.tag.value.length>40){
            alert('标签太长啦！');
            fm.tag.focus();
            return false;
        }
        return true;
    }
};
//选择字体大小
function font(size){
    document.getElementsByTagName('form')[0].content.value+='[size='+size+'][/size]';
}
function showcolor(color){
    document.getElementsByTagName('form')[0].content.value+='[color='+color+'][/color]';
}