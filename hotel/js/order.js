$(function(){
	//页面回退
	$(".imgL").on("click",function(){
		window.history.go(-1);
	});
	// 点击订单，进行传参
    var s=window.localStorage;
    var username=s.getItem("username");
    $("footer ul").find("li").eq(2).find("a").on("click",function(){
        window.location.href="./order.php?username="+username;
    });
    s.removeItem("cart_dishprice");
    s.removeItem("cart_dishname");
    // 点击评论，将订单消息传至下一个页面
    $("section ul li button").on("click",function(){

        var index=$(this).parent().index();
        var dishmess=$(this).parent().find(".dishname").text();
        var dishprice=$(this).parent().find(".price span").text();//获得系统的价格
        var orderid=$(this).parent().find(".order").text().substr(4);
        //首先判断用户是否登录
        if(username==null){
            alert("请先登录!");
            window.location.href="./login.html";
        }else{//用户登录，可以开始评价
            //判断用户是否已经添加过评论
            if($(this).text()=="已评论"){
                alert("此用户已经添加过评论!");
            }else{
                //对未评论的订单进行评论
                //跳转至评论页面,同样把订单号也传递过去=
                window.location.href="./comment.html?username="+username+"&dishprice="+dishprice+"&orderid="+orderid+"&dishmess="+dishmess;
            }
            
        }
    });
});