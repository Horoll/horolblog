/**
 * Created by lkc on 2016/11/14.
 */
window.onload=function(){
    header();
    var appoint=document.getElementById('appoint');
    var resign=document.getElementById('resign');
    var retire=document.getElementById('retire');
    if(appoint&&resign){
        appoint.onclick=function(){
            centerWindow('manage_job_appoint.php','任命管理员',350,500);
        };
        resign.onclick=function(){
            centerWindow('manage_job_resign.php','辞退管理员',350,500);
        };
    }else{
        retire.onclick=function(){
            if(window.confirm('确定要辞去管理员职务吗？')){
                location.href='manage_job.php?action=retire&username='+this.name;
            }
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