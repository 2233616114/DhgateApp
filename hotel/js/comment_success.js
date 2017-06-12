$(function(){
	//页面后退
	$(".imgL").on("click",function(){
		window.history.go(-1);
	});
	//获得登录用户的用户名
	var s=window.localStorage;
	var username=s.getItem("username");
	// 查看全部评论
	$("section div").on("click",function(){
		window.location.href="./all_comment.php?username="+username;
	});
});