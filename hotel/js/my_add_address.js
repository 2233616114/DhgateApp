$(function(){
	// 页面的回退
	$(".imgL").on("click",function(){
		window.history.go(-1);
	});
	var s=window.localStorage;//本地存储
	var username=s.getItem("username");//获取用户名
	$(".submit").on("click",function(){
		var name=$(".name").val();
		var tel=$(".tel").val();
		var address=$(".add").val();
		if(name=="" || tel=="" || address==""){
			alert("姓名、电话、以及联系地址均不能为空!");
		}else{

			//向后台发送ajax请求
			$.ajax({
				url:'./php/my_add_address.php?name='+name+"&tel="+tel+"&address="+address+"&username="+username,
				type:'get',
				async:true,
				success:function(data){
					console.log(data);
					alert("新增地址成功!");
					window.location.href='./my_address.php?username='+username;
				},
				error:function(){
					alert("数据发送请求失败!");
				}
			});
		}

	});


 
});