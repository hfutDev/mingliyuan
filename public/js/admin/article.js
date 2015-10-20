$(".delete").click(function(){
	var aid = $.trim($(this).attr("data-href"));
	if (aid == '') {
		return false;
	}
	artDialog(
		{
			title:'删除提示',
			content:'确定要删除此文章吗？',
			fixed:true,
		},
		function(){
    		if(aid == ''){
    			alert('我真不知道你要删哪个？');
    			return false;
    		}
            var type = 'del';
            $.ajax({
            	url:"/admin/writearticle",
            	type:"post",
            	data:{
            		type:type,
            		aid:aid
            	},
            	success:function(data){
            		if (data == 'success') {
            			$("a[data-href='"+aid+"']").parent().parent().remove();
            		}
            		else {
            			alert("未成功删除");
            		}
            	}
            });
        },
		function(){
		}
	);
	return false;
});

$(".deleteimg").click(function(){
    var id = $.trim($(this).attr("data-href"));
    if (id == '') {
        return false;
    }
    artDialog(
        {
            title:'删除提示',
            content:'确定要删除此图片吗？',
            fixed:true,
        },
        function(){
            if(id == ''){
                alert('我真不知道你要删哪个？');
                return false;
            }
            var type = 'del';
            $.ajax({
                url:"/admin/writeimg",
                type:"post",
                data:{
                    type:type,
                    id:id
                },
                success:function(data){
                    if (data == 'success') {
                        $("a[data-href='"+id+"']").parent().parent().remove();
                    }
                    else {
                        alert("未成功删除");
                    }
                }
            });
        },
        function(){
        }
    );
    return false;
});

$('.delAll').bind('click',function(){
    artDialog(
		{
			title:'删除提示',
			content:'确定要删除选中的文章吗？',
			fixed:true,
		},
		function(){
			var aid = new Array();
            var i=0;
            var $tr=$('input:checkbox:checked').parent().parent();
            $('input:checkbox:checked').each(function(){
                var del=$.trim($(this).val());
                aid.push(del);
            });
    		
    		if(aid == ''){
    			alert('请选中要删除的文章');
    			return false;
    		}
            var type = 'del';
    		// ajax发送删除的数据
    		$.ajax({
            	url:'/admin/writearticle',
            	type:'POST',
            	data:{
                    type:type,
                    aid:aid,
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

$('.delAllImg').bind('click',function(){
    artDialog(
        {
            title:'删除提示',
            content:'确定要删除选中的图片吗？',
            fixed:true,
        },
        function(){
            var id = new Array();
            var i=0;
            var $tr=$('input:checkbox:checked').parent().parent();
            $('input:checkbox:checked').each(function(){
                var del=$.trim($(this).val());
                id.push(del);
            });
            
            if(id == ''){
                alert('请选中要删除的图片');
                return false;
            }
            var type = 'del';
            // ajax发送删除的数据
            $.ajax({
                url:'/admin/writeimg',
                type:'POST',
                data:{
                    type:type,
                    id:id,
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