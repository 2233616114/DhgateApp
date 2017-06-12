$(function(){
	$("footer p").on("click",function(){
		//判断用户收登录，如果未登录，则跳转至登录页面
		var ss=window.localStorage;
        var username=ss.getItem("username");
        if(username==null){
        	alert("该用户还未曾登录，请先登录");
        	window.location.href="./login.html";
        }else{
        	window.location.href="./my_add_address.html";
        }
	});
	$("header img").on("click",function(){
		window.history.go(-1);
	});
	
});