/**
 * Created by lkc on 2016/12/8.
 */
function header() {
    var checkuser=document.getElementById('checkuser');
    var checknews=document.getElementById('checknews');
    var user=document.getElementById('user');
    var news=document.getElementById('news');
    checkuser.onmouseover=function () {
        user.style.display="block";
    };
    checkuser.onmouseout=function () {
        user.style.display="none";
    };
    user.onmouseover=function () {
        user.style.display="block";
    };
    user.onmouseout=function () {
        user.style.display="none";
    };
    checknews.onmouseover=function () {
        news.style.display="block";
    };
    checknews.onmouseout=function () {
        news.style.display="none";
    };
    news.onmouseover=function(){
        news.style.display="block";
    };
    news.onmouseout=function(){
        news.style.display="none";
    };
}
