/**
 * Created by lkc on 2016/11/2.
 */
window.onload=function(){

    header();

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
};

//弹出窗口函数
function  centerWindow(url,name,height,width){
    //使弹窗居中
    var left=(screen.width-width)/2;
    var top=(screen.height-height)/2;
    //设置弹窗大小、位置
    window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}