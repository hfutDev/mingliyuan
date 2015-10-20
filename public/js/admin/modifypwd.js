$(".modifypwd").click(function(){
	var oldname = $(this).parent().parent().find('td:eq(1)').text();
    var uid = $(this).attr('data-uid');
    var editUser = '<form id="changeTiku"><label for="username">密码：</label><input type="password" class="form-control mPwd" value="'+oldname+'" placeholder="请输入密码"><br/><br><label for="pwd">重复密码：</label><input type="password" class="form-control cPwd" value="" placeholder="请输入密码"></form>';
    artDialog(
    {
        id:'modify-form',
        title:'修改密码',
        content:editUser,
        yesText:'修改',
        fixed:true
    },
    function(){
        var mPwd = $.trim($('.mPwd').val()),
            cPwd = $.trim($('.cPwd').val()),
            type = 'update';
        if (mPwd == '' || cPwd == '' || type == '') {
            alert('请填写完整');
            return false;
        }
        else if(mPwd != cPwd){
        	alert("两次密码不一样");
        	return false;
        }
        else{
            $.ajax({
                url:'/admin/modifypwd',
                type:'POST',
                data:{
                    type:type,
                    mPwd:mPwd,
                    cPwd:cPwd
                },
                success:function(msg){
                    if(msg == 'success') {
                        alert('修改成功');
                    }
                    else if(msg == 'emptyError'){
                        alert("请保证填写内容完整且合理");
                    }
                    else {
                        alert('修改失败');
                    }
                }
            });
        }
    },
    function(){
    }
    );
	return false;
});