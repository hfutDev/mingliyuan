//预览大图
$(".basemanage-img").click(function() {
	var img = $(this).attr("src");
	artDialog({
		title: '图片查看',
		content: '<img height="500px" src="'+img+'" />',
		button: [
		{
            name: '关闭预览',
            callback: function () {
            },
            focus: true
        }
        ]
	});
});

//修改版块信息
$(".editbase").click(function() {
	var name = $(this).parent().parent().find('td:eq(0)').text();
	var mid = $(this).parent().parent().find('td:eq(0)').find('a').attr("data-mid");
	var title = $(this).parent().parent().find('td:eq(3)').html();
	var content = '<form id="base" style="width:100%;"><label for="base">板块名称：</label><input type="text" class="form-control base-name" value="'+name+'" placeholder="请输入板块名称"><br/><br></form>';
	artDialog(
	{
		title: '板块修改',
		content: content,
		width: '400px',
		yesText:'修改',
		fixed:true
	},
	function(){
		var name = $(".base-name").val();
		if ($.trim(name)=='') {
			artDialog({
				icon: 'error',
				content:"请填写完整",
				time:2
			});
			return false;
		}
		$.ajax({
			url:"/admin/basemanage/type/editmid",
			type:"post",
			data:{
				mid:mid,
				name:name
			},
			success:function(msg){
				if (msg == 'success') {
					artDialog({icon:'success',content:'修改成功',time:1.5});
					location.href=location.href;
				}
				else {
					artDialog({icon:'error',content:'修改失败',time:1.5});
					return false;
				}
			}
		});
	},
	function(){
	});
	return false;
});

//添加版块信息
$(".addmodule").click(function() {
	var content = '<form id="base" style="width:100%;"><label for="base">板块名称：</label><input type="text" class="form-control add-name" value="" placeholder="请输入板块名称"><br/><br> <br></form>';
	artDialog(
	{
		title: '添加板块',
		content: content,
		width: '400px',
		yesText:'添加',
		fixed:true
	},
	function(){
		var name = $(".add-name").val();
		var title = $(".add-title").val();
		if ($.trim(name)=='') {
			artDialog({
				icon: 'error',
				content:"请填写完整",
				time:2
			});
			return false;
		}
		$.ajax({
			url:"/admin/basemanage/type/addmid",
			type:"post",
			data:{
				name:name,
				title:title
			},
			success:function(msg){
				if (msg == 'success') {
					artDialog({icon:'success',content:'添加成功',time:1.5});
					window.location.reload();
				}
				else {
					artDialog({icon:'error',content:'添加失败',time:1.5});
					return false;
				}
			}
		});
	},
	function(){
	});
	return false;
});

//删除
$(".delbase").click(function(){
	var mid = $(this).attr("data-mid");
	artDialog(
		{
			title:"删除警告",
			content:"真的要删除这个版块吗？",
			fixed:true
		},
		function(){
			$.ajax({
				url:"/admin/basemanage/type/delmid",
				type:"post",
				data:{mid:mid},
				success:function(msg){
					if (msg == 'success') {
						artDialog({icon:"success",content:"删除成功",time:2});
						window.location.reload();
					}
					else {
						artDialog({icon:"error",content:"删除失败",time:2});
					}
				}
			});
		},
		function(){
		}
	);
	return false;
});


//修改二级版块信息
$(".editcol").click(function() {
	var name = $(this).parent().parent().find('td:eq(0)').text();
	var cid = $(this).parent().parent().find('td:eq(0)').find('a').attr("data-cid");
	var content = '<form id="base" style="width:100%;"><label for="base">板块名称：</label><input type="text" class="form-control col-name" value="'+name+'" placeholder="请输入板块名称"></form>';
	artDialog(
	{
		title: '板块修改',
		content: content,
		width: '400px',
		yesText:'修改',
		fixed:true
	},
	function(){
		var name = $(".col-name").val();
		if ($.trim(name)=='') {
			artDialog({
				icon: 'error',
				content:"请填写完整",
				time:2
			});
			return false;
		}
		$.ajax({
			url:"/admin/basemanage/type/editcid",
			type:"post",
			data:{
				cid:cid,
				name:name
			},
			success:function(msg){
				if (msg == 'success') {
					artDialog({icon:'success',content:'修改成功',time:1.5});
					location.href=location.href;
				}
				else {
					artDialog({icon:'error',content:'修改失败',time:1.5});
					return false;
				}
			}
		});
	},
	function(){
	});
	return false;
});

//添加二级版块信息
$(".addcolumn").click(function() {
	var module = $(".content-box-header").find('h3').text();
	var mid = $(".content-box-header").find('h3').attr('data-mid');
	var content = '<form id="base" style="width:100%;"><label for="base">所属板块：　<font style="font-size:20px">'+module+'</font></label><input type="text" class="form-control add-name" value="" placeholder="请输入二级板块名称"><br/></form>';
	artDialog(
	{
		title: '添加板块',
		content: content,
		width: '400px',
		yesText:'添加',
		fixed:true
	},
	function(){
		var name = $(".add-name").val();
		var title = $(".add-title").val();
		if ($.trim(name)=='') {
			artDialog({
				icon: 'error',
				content:"请填写完整",
				time:2
			});
			return false;
		}
		$.ajax({
			url:"/admin/basemanage/type/addcid",
			type:"post",
			data:{
				mid:mid,
				name:name,
				title:title
			},
			success:function(msg){
				if (msg == 'success') {
					artDialog({icon:'success',content:'添加成功',time:1.5});
					window.location.reload();
				}
				else {
					artDialog({icon:'error',content:'添加失败',time:1.5});
					return false;
				}
			}
		});
	},
	function(){
	});
	return false;
});

//删除二级板块
$(".delcol").click(function(){
	var cid = $(this).attr("data-cid");
	var $tr = $(this).parent().parent();
	artDialog(
		{
			title:"删除警告",
			content:"真的要删除这个版块吗？",
			fixed:true
		},
		function(){
			$.ajax({
				url:"/admin/basemanage/type/delcid",
				type:"post",
				data:{cid:cid},
				success:function(msg){
					if (msg == 'success') {
						artDialog({icon:"success",content:"删除成功",time:2});
						$tr.remove();
					}
					else {
						artDialog({icon:"error",content:"删除失败",time:2});
					}
				}
			});
		},
		function(){
		}
	);
	return false;
});