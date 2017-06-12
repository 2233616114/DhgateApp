$(function(){
	//进行图片的自动轮播展示
	var timer=null;//设置定时器为空
	var num=0;  //自定义索引下标为0
	var len=$(".pic li").length;
	var width=$(".pic").width()/len;
	function auto(){
		num++;
		if(num>=len){
			num=0;
		}
		$("#pic").css("margin-left",(-width)+"px");
		$("#pic").animate({"margin-left":"0px"},700);
		$("#pic li").first().appendTo($("#pic"));//将第一张图片追加至ul的最后
		$("ol li").eq(num).addClass("on").siblings().removeClass("on");
	}
	timer=setInterval(auto,3000);

    // 点击右上角logo进行注册与登录实现
    var bool=true;
    $(".imgR").click(function(){

    	if(bool==true){
    		$("header ul").slideDown(200);
    		bool=false;
    	}else{
    		$("header ul").slideUp(200);
    		bool=true;
    	}
    });

    // 搜索功能
    $(".search input").on("focus",function(){
    	window.location.href="search.html";
    });
    // 点击订单，进行传参
    var s=window.localStorage;
    var username=s.getItem("username");
    $("footer ul").find("li").eq(2).find("a").on("click",function(){
        window.location.href="./order.php?username="+username;
    });
});