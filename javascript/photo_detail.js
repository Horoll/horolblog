/**
 * Created by lkc on 2016/12/6.
 */
window.onload=function(){

    header();
    //删除图片
    var delete_photo = document.getElementById('delete_photo');
    delete_photo.onclick=function () {
        if(window.confirm('确定要该图片吗？')){
            location.href='?action=delete_photo&id='+this.name;
        }
    };

    //删除评论
    var delete_comment = document.getElementsByClassName('delete_comment');
    for(var i=0;i<delete_comment.length;i++){
        delete_comment[i].onclick=function () {
            if(window.confirm('确定要该评论吗？')){
                location.href='?action=delete_comment&id='+this.name;
            }
        };
    }

    //用于用户信息的点击
    //取得message数组
    var message = document.getElementsByName('message');
    var friend = document.getElementsByName('friend');
    var gift = document.getElementsByName('gift');
    var guest = document.getElementsByName('guest');
    //测试长度是否正确
    //alert(message.length);

    //用循环实现点击每个用户的链接弹出对应id的弹窗

    //发送信息功能弹窗
    for(var i=0;i<message.length;i++){
        message[i].onclick=function(){
            //测试id是否对应
            //alert(this.title);

            //弹出窗口
            centerWindow('message.php?id='+this.title,'message',475,650);
        };
    }

    for(var i=0;i<friend.length;i++){
        friend[i].onclick=function(){
            //弹出窗口
            centerWindow('friend.php?id='+this.title,'friend',475,650);
        };
    }

    for(var i=0;i<gift.length;i++){
        gift[i].onclick=function(){
            //弹出窗口
            centerWindow('gift.php?id='+this.title,'gift',475,650);
        };
    }

    for(var i=0;i<guest.length;i++){
        guest[i].onclick=function(){
            //弹出窗口
            centerWindow('guest.php?id='+this.title,'guest',475,650);
        };
    }

    //用于评论的
    var ubb=document.getElementById('ubb');
    var fm=document.getElementsByTagName('form')[0];
    var font=document.getElementById('font');
    var color=document.getElementById('color');
    var html=document.getElementsByTagName('html')[0];

    //在其它地方点一下，下拉框消失
    html.onmouseup=function(){
        font.style.display='none';
        color.style.display='none';
    };

    //当登陆后 ubb存在 才执行js代码
    if(ubb!=null){
        var ubbing=ubb.getElementsByTagName('li');
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
            if(fm.content.value.length<4 || fm.content.value.length>99999){
                alert('评论不能少于4个字');
                fm.content.focus();
                return false;
            }
            return true;
        };
    }
};

//弹出窗口函数
function  centerWindow(url,name,height,width){
    //使弹窗居中
    var left=(screen.width-width)/2;
    var top=(screen.height-height)/2;
    //设置弹窗大小、位置
    window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}
//选择字体大小
function font(size){
    document.getElementsByTagName('form')[0].content.value+='[size='+size+'][/size]';
}
function showcolor(color){
    document.getElementsByTagName('form')[0].content.value+='[color='+color+'][/color]';
}