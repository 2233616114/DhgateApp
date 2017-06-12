;(function(){
	//页面的回退
	$(".imgL").on("click",function(){
		window.history.go(-1);//页面回退
	});
	//左右滑动图片进行订餐系统的介绍
	var width=$(".main").width();
	var len=$("#main section").length;//长度为3
	var i=0;
	$("body").on("swipeRight",function(){
		i--;
		if(i<0){
			i=0;
		}
		var w=-width*i;
		$(".img").css({
			"-webkit-transform":"translate3d("+w+"px,0,0)",
			"-webkit-transition":"all 1s"
		});
	});
	$("body").on("swipeLeft",function(){
		i++;
		if(i>len-1){
			i=len-1;
		}
		console.log(i);
		var w=-width*i;
		$(".img").css({
			"-webkit-transform":"translate3d("+w+"px,0,0)",
			"-webkit-transition":"all 1s"
		});
	});
})(Zepto)
