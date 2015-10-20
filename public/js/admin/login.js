$("form").submit(function(){
	submitPwd();
	return false;
});

//提示框
$(".text-input").keydown(function(){
	$(".alt").html("请登录");
});

function submitPwd() {
	var username = $.trim($(".username").val());
	var pwd = $.trim($(".pwd").val());
	if (username == ""||pwd == "") {
		$(".alt").html("请填写完整");
		return false;
	}
	$.ajax({
		url:"/login/login",
		type:"post",
		data:{
			username:username,
			pwd:pwd
		},
		dataType:"json",
		success:function(msg){
			if (msg.status == 'success') {
				location.href = "/admin";
			}
			else {
				$(".alt").html("登陆失败，请检查用户名和密码");
			}
		}
	});
}