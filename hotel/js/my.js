$(function(){
    // 页面回退
    $(".imgL").on("click",function(){
            window.history.go(-1);
    });
	$(".exit").on("click",function(){
		//出现弹窗，提示是否确认退出，如果确认退出，则用户退出登录
		var string=window.confirm("亲，您确定要退出账号吗?");
                if(string==true){
                	var s=window.localStorage;
                	s.removeItem("username");//清除本地存储的用户账号
                        s.removeItem('cart_dishname');
                        s.removeItem('cart_dishprice');
                        // s.clear();
                }else{
                	
                }
	});

    var s=window.localStorage;//本地存储
    var username=s.getItem("username");
    if(username!=null){
        $(".login_mess").text(username); 
    }
    else{
        $(".login_mess").text("立即登录");
    }
    //点击底部订单页面跳转
    $("footer ul").find("li").eq(2).find("a").on("click",function(){
        window.location.href="./order.php?username="+username;
    });

    // 点击收货地址页面
    $("section ul li").eq(0).find("a").on("click",function(){
        window.location.href="./my_address.php?username="+username;
    });
    // 点击我的评论
    $("section ul li a.comment").on("click",function(){
        window.location.href="./all_comment.php?username="+username;
    });
});