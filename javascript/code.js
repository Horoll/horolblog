
/**
 * Created by lkc on 2016/10/29.
 */
function code(){

    //局部刷新验证码
    var code = document.getElementById('code');
    code.onclick = function () {
        this.src = 'code.php?tm=' + Math.random();
    };
};