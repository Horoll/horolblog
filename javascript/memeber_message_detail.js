/**
 * Created by lkc on 2016/11/3.
 */
window.onload=function(){
    header();
    var ret=document.getElementById('return');
    var del=document.getElementById('delete');

    //点击返回
    ret.onclick= function () {
        //用history.back()返回后不会刷新页面
        //history.back();
        location.href='member_message.php';
    };

    //点击删除
    del.onclick=function(){
        if(window.confirm('确定要删除信息吗？')){
            location.href='member_message_detail.php?action=delete&id='+this.name;
        }
    };
};