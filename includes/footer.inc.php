<?php

//防止其他人调用这个模块
if(!defined('IN_TG')){
    exit('Accsee Defined!');
}

?>
<!-- 将footer分离 -->
<div id="footer">
    <p>Powered by Horol</p>
    <!-- 通过时间函数减去开始时间常量得到执行耗时,保留小数点后4位数字 -->
    <p>程序执行耗时：<?php echo round(_runtime()-$_start_time,4); ?>s</p>
</div>