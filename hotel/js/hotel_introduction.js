$(function(){
	var time=new Date();
	var hour=time.getHours();//获得当前的时间
    console.log(typeof hour);
    if(hour<=23 && hour>=7){
    	//alert("处于营业中");
    	$(".state").html("营业中");
    }else{
    	$(".state").html("未营业");
    }
    // 页面回退
    $(".back").on("click",function(){
    	window.history.go(-1);//页面回退
    });
});