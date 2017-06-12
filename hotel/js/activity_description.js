$(function(){
	//页面回退
	$(".back").on("click",function(){
		window.history.go(-1);//页面回退
	});
	//进行点菜操作
	var s=window.localStorage;
	s.setItem('cart_dishname','[]');//购物车添加的商品名
    s.setItem('cart_dishprice','[]');//购物车添加的商品的价格
	var arr_dishname=JSON.parse(s.getItem("cart_dishname"));
	var arr_dishprice=JSON.parse(s.getItem("cart_dishprice"));
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
				"<div class='addcontent'>"+
					"<img class='addmenu' src='img/addmenu.png' />"+
					"<span>0</span>"+
					"<img class='submenu' src='img/submenu.png' />"+
				"</div>"+
			"</div>"+
			"<div class='intro'>"+
				"<h3>商品简介</h3>"+
				"<p>"+data.dishes[4]+"</p>"+
			"</div>";
			$("section").append(string);//追加到页面
            // 点击加点菜品
			$("section .addmenu").on("click",function(){
				//判断用户是否登录
				var username=s.getItem("username");
				if(username==null){
					alert("请先登录!");
					window.location.href="./login.html";
				}else{
					var dish_price=$(this).parents(".price_add").find("p span").text();
		            var dish_name=$(this).parents("section").find(".dishname h3").text();
					console.log(dish_name+" "+dish_price);
					arr_dishname.push(dish_name);
					s.setItem("cart_dishname",JSON.stringify(arr_dishname));
					arr_dishprice.push(dish_price);
					s.setItem("cart_dishprice",JSON.stringify(arr_dishprice));
		            //商品总数加1
		            $(".addcontent span").text(parseInt($(".addcontent span").text())+1);
		            if($(".addcontent span").text()<0){
			            $(".addcontent .submenu").css("display","none");
						$(".addcontent span").css("display","none");
		            }else{
		                $(".addcontent .submenu").css("display","block");
						$(".addcontent span").css("display","block");
		            }
		            // 计算购物车的总价
					if(arr_dishprice.length<=0){
						$("footer .gouwuche .count").css("display","none");
						$("footer dt p").text("购物车是空的");
					    $("footer dt span").text("");
					}else{
						$("footer .gouwuche .count").css("display","block");
						$("footer .gouwuche .count").text(arr_dishprice.length);
						$("footer dt p").text("共计:");
						$("footer dt span").text(count_total(arr_dishprice));
						
					}
					
				}
			});
			// 点击减少菜品的按钮
			$(".submenu").on("click",function(){
				var dish_price=$(this).parents(".price_add").find("p span").text();
		        var dish_name=$(this).parents("section").find(".dishname h3").text();
				arr_dishname.pop(dish_name);
				s.setItem("cart_dishname",JSON.stringify(arr_dishname));
				arr_dishprice.pop(dish_price);
				s.setItem("cart_dishprice",JSON.stringify(arr_dishprice));
				//商品总数减1
		        $(".addcontent span").text(parseInt($(".addcontent span").text())-1);
	            if($(".addcontent span").text()<=0){
		            $(".addcontent .submenu").css("display","none");
					$(".addcontent span").css("display","none");
	            }else{
	                $(".addcontent .submenu").css("display","block");
					$(".addcontent span").css("display","block");
	            }
		        // 计算购物车的总价
				if(arr_dishprice.length<=0){
					$("footer .gouwuche .count").css("display","none");
					$("footer dt p").text("购物车是空的");
					$("footer dt span").text("");
				}else{
					$("footer .gouwuche .count").css("display","block");
					$("footer .gouwuche .count").text(arr_dishprice.length);
					$("footer dt p").text("共计:");
					$("footer dt span").text(count_total(arr_dishprice));
					
				}
			});
		},
		error:function(){
			alert("数据请求失败!");
		}
	});
	// 计算购物车的总价
	function count_total(arr_dishprice){
		var count=0;
		for(var i=0;i<arr_dishprice.length;i++){
			count+=parseFloat(arr_dishprice[i]);
		}
		return count.toFixed(2);
	}
	//点击选好了，生成订单
	$("footer button").on("click",function(){
		var length=arr_dishname.length;
		if(length<=0){
			alert("请选择菜品!");
		}else{
			window.location.href="./commit_order.html";
		}
	});
});