$(".module").change(function(){
	var mid = $.trim($(this).val());
	if (mid == ''|| mid == 0) {
		return false;
	}
	getColumn(mid);
});

function getColumn(mid){
	$.ajax({
		url:"/admin/writearticle",
		type:"post",
		data:{mid:mid},
		dataType:"json",
		success:function(data){
			var num = data.length;
			$(".column").empty();
			for (var i = 0; i < data.length; i++) {
				var option = $("<option>").val(data[i]['column_id']).text(data[i]['column_name']);
				$(".column").append(option);
			};
		}
	});
}