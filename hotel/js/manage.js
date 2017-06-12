$(function(){
	//点我
	$("ul li").on("click",function(){
		var index=$(this).index();
		$(".content div").eq(index).css("display","block");
		$(".content div").eq(index).siblings("div").css("display","none");
	});
});