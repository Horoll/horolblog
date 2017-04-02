/**
 * Created by lkc on 2016/11/3.
 */
window.onload=function(){
    header();
    var all=document.getElementById('all');
    var form=document.getElementsByTagName('form')[0];
    all.onclick= function () {
        //form.elements获取表单内的数据
        for(var i=0;i<form.elements.length;i++){

            //当点击全选后，如果单个框状态不是勾选的话，就把全选框的状态赋值给单选框
            if(form.elements[i].name!='chkall'){
                form.elements[i].checked=form.chkall.checked;
            }
        }
    };
    form.onsubmit=function(){
        if(confirm('确定要删除选中的信息？')){
            return true;
        }
            return false;
    }
};