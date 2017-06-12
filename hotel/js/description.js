$(function(){
	//页面回退
	$(".back").on("click",function(){
		window.history.go(-1);//页面回退
	});
	//接收地址栏传过来的参数
	var URL=window.location.search;
    var url=decodeURI(URL.substr(1));
	$.ajax({
		url:"./php/description.php?url="+url,
		type:"get",
		dataType:"json",
		async:true,
		success:function(data){
			// console.log(data.dishes[0]);
			//将后台的json数据渲染到页面
			var string="<div class='imgcontent'>"+
				"<img src='"+data.dishes[0]+"' />"+
			"</div>"+
			"<div class='dishname'>"+
				"<h3>"+data.dishes[1]+"</h3>"+
				"<p>销量"+data.dishes[2]+"</p>"+
			"</div>"+
			"<div class='price_add'>"+
				"<p>"+
				    "<img src='img/price.png' />"+
					"<span>"+data.dishes[3]+"</span>"+
				"</p>"+
				/*"<div class='addcontent'>"+
					"<img class='addmenu' src='img/addmenu.png' />"+
					"<span>1</span>"+
					"<img class='submenu' src='img/submenu.png' />"+
				"</div>"+*/
			"</div>"+
			"<div class='intro'>"+
				"<h3>商品简介</h3>"+
				"<p>"+data.dishes[4]+"</p>"+
			"</div>";
			$("section").append(string);//追加到页面
		},
		error:function(){
			alert("数据请求失败!");
		}
	});
});