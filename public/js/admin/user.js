//批量删除
$('.del').bind('click',function(){
    artDialog(
		{
			title:'删除提示',
			content:'确定要删除选中的用户吗？',
			fixed:true,
		},
		function(){
			var uid=[],i=0;
            var $tr=$('input:checkbox:checked').parent().parent();
            $('input:checkbox:checked').each(function(){
                var del=$.trim($(this).val());
                uid.push(del);
            });
    		
    		if(uid == ''){
    			alert('请选中要删除的用户');
    			return false;
    		}
            var type = 'del';
    		// ajax发送删除的数据
    		$.ajax({
            	url:'/admin/usermanager',
            	type:'POST',
            	data:{
                    type:type,
                    uid:uid,
                },
            	success:function(msg){
                	if (msg == 'success'){
                		alert('删除成功');
                		$tr.remove();
                	}
                	else if(msg == 'emptyError'){
                		alert('请选择要删除的对象');
                	}
                	else{
                		alert('未能成功删除');
                	}
                	
            	}
        	});
		},
		function(){
		}
		);
return false;
});

$(".delUser").click(function(){
    var uid = $.trim($(this).attr("data-uid"));
    var $tr=$(this).parent().parent();
    if (uid == '') {
        return false;
    }
    artDialog(
        {
            title:'删除提示',
            content:'确定要删除这个用户吗？',
            fixed:true,
        },
        function(){
            var type = 'del';
            // ajax发送删除的数据
            $.ajax({
                url:'/admin/usermanager',
                type:'POST',
                data:{
                    type:type,
                    uid:uid,
                },
                success:function(msg){
                    if (msg == 'success'){
                        alert('删除成功');
                        $tr.remove();
                    }
                    else if(msg == 'emptyError'){
                        alert('请选择要删除的对象');
                    }
                    else{
                        alert('未能成功删除');
                    }
                    
                }
            });
        },
        function(){
        }
        );
    return false;
});

//添加用户
$('.adduser').bind('click',function(){
    var info='<form role="form" id="addForm"><label for="username">用户名：</label><input class="form-control" id="username" type="text" name="username" placeholder="请输入用户名"/><br><br><label>密码：</label><input class="form-control" id="pwd" type="password" name="pwd" placeholder="请输入密码"/><br/>';
    artDialog(
        {
            id: 'student-form',
            title: '添加用户',
            content: info,
            width:"290px",
            yesText: '添加',
            fixed:true
        },  
    function(){
        var username =$.trim($('input[name="username"]').val());
        var pwd = $.trim($('input[name="pwd"]').val());

        if(username=="" || pwd==""){
            alert('请将信息填写完整');
            return false;
        }
        else{
         var type = 'add';
         $.ajax({
             url:'/admin/usermanager',
             type:'POST',
             data:{
                type:type,
                username:username,
                pwd:pwd
             },
             success:function(msg){

                if(msg == 'success'){
                    alert('添加成功');
                    window.location.reload();
                }
                else if(msg == 'exist'){
                    alert('此用户名已存在');
                }
                else if(msg == 'emptyError'){
                    alert('请保证填写内容完整且合理');
                }
                else{
                    alert('添加失败');
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


//编辑用户信息
$('.editUser').bind('click',function(){
    var oldname = $(this).parent().parent().find('td:eq(1)').text();
    var uid = $(this).attr('data-uid');
    var editUser = '<form id="changeTiku"><label for="username">用户名：</label><input type="text" class="form-control edit-name" value="'+oldname+'" placeholder="请输入用户名"><br/><label for="pwd">密码：</label><input type="password" class="form-control edit-pwd" value="" placeholder="请输入密码"></form>';
    artDialog(
    {
        id:'user-form',
        title:'更新用户信息',
        content:editUser,
        yesText:'更新',
        fixed:true
    },
    function(){
        var username = $.trim($('.edit-name').val()),
            pwd = $.trim($('.edit-pwd').val()),
            type = 'update';
        if (username == '' || pwd == '' || uid == '') {
            alert('请填写完整');
            return false;
        }else{
            $.ajax({
                url:'/admin/usermanager',
                type:'POST',
                data:{
                    type:type,
                    username:username,
                    pwd:pwd,
                    uid:uid
                },
                success:function(msg){
                    if(msg == 'success') {
                        alert('更新成功');
                        window.location.reload();
                    }
                    else if(msg == 'exist'){
                        alert("此用户名已存在");
                    }
                    else if(msg == 'emptyError'){
                        alert("请保证填写内容完整且合理");
                    }
                    else {
                        alert('更新失败');
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
