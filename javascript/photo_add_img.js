/**
 * Created by lkc on 2016/11/16.
 */
window.onload=function(){
    header();
    var up=document.getElementById('upload');
    up.onclick=function(){
        centerWindow('upimg.php?dir='+this.title,'选择图片',350,650);
    };

    var fm=document.getElementsByTagName('form')[0];
    fm.onsubmit=function(){
         //判断图片名称长度
         if(fm.name.value.length>10){
             alert('图片名称不得大于10位');
             fm.name.focus();
             return false;
         }
        //判断是否选择图片
        if(fm.url.value.length==0){
            alert('请选择图片');
            return false;
        }
        //判断图片描述长度
        if(fm.name.content.length>200){
            alert('图片描述不得大于200位');
            fm.content.focus();
            return false;
        }
    };
    return true;
};

//弹出窗口函数
function  centerWindow(url,name,height,width){
    //使弹窗居中
    var left=(screen.width-width)/2;
    var top=(screen.height-height)/2;
    //设置弹窗大小、位置
    window.open(url,name,'height='+height+',width='+width+',top='+top+',left='+left);
}