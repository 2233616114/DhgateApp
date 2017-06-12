$(function(){
	$(".imgL").on("click",function(){
		window.history.go(-1);
	});
	// 点击订单，进行传参
    var s=window.localStorage;
    var username=s.getItem("username");
    $("footer ul").find("li").eq(2).find("a").on("click",function(){
        window.location.href="./order.php?username="+username;
    });
    // 获取点击的菜品，将信息传到下一个页面的地址栏,传图片的路径
    $(".list ul li img").on("click",function(){
        var imgstring=$(this).attr("src");
        window.location.href="./activity_description.html?"+imgstring;
    });
});