$(function(){
	//页面回退
	$(".imgback").on("click",function(){
		window.history.go(-1);
	});
	// 点菜和评论选项卡的效果切换
	$("header ul li").on("click",function(){
		var index=$(this).index();
		$(this).addClass("on").siblings().removeClass("on");
		$("section .tab_menu").eq(index).css("display","block").siblings().css("display","none");
	});
	
	// 加入购物车效果
	var menu_length=$(".menu_list li").length;//67.代表菜的种类共有67种
	$(".menu_list li .imgcontent").on("click",function(){
		var imgstring=$(this).find("img").attr("src");
        window.location.href="description.html?"+imgstring;
	});
	//进行点菜操作
	var s=window.localStorage;
	s.setItem('cart_dishname','[]');//购物车添加的商品名
    s.setItem('cart_dishprice','[]');//购物车添加的商品的价格
	var arr_dishname=JSON.parse(s.getItem("cart_dishname"));
	var arr_dishprice=JSON.parse(s.getItem("cart_dishprice"));
	// var number=0;//点菜初始化为0
	$(".menu_list li .addmenu").on("click",function(){
		//判断用户是否登录
		var username=s.getItem("username");
		if(username==null){
			alert("请先登录!");
			window.location.href="./login.html";
		}else{
			var dish_name=$(this).parents("li").find(".introcontent h6").text();
			var dish_price=$(this).parents("li").find(".introcontent dd span").text();
			arr_dishname.push(dish_name);
			s.setItem("cart_dishname",JSON.stringify(arr_dishname));
			arr_dishprice.push(dish_price);
			s.setItem("cart_dishprice",JSON.stringify(arr_dishprice));
            var ul_index=$(this).parents(".section").index();
            var li_index=$(this).parents("li").index();
            //商品总数加1
            $(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").text(parseInt($(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").text())+1);
            if($(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").text()<0){
	            $(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent .submenu").css("display","none");
				$(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").css("display","none");
            }else{
                $(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent .submenu").css("display","block");
				$(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").css("display","block");
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
	$(".menu_list li .submenu").on("click",function(){
		var dish_name=$(this).parents("li").find(".introcontent h6").text();
		var dish_price=$(this).parents("li").find(".introcontent dd span").text();
		arr_dishname.pop(dish_name);
		s.setItem("cart_dishname",JSON.stringify(arr_dishname));
		arr_dishprice.pop(dish_price);
		s.setItem("cart_dishprice",JSON.stringify(arr_dishprice));
		var ul_index=$(this).parents(".section").index();
        var li_index=$(this).parents("li").index();
		//商品总数减1
        $(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").text(parseInt($(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").text())-1);
        if($(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").text()<=0){
            $(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent .submenu").css("display","none");
			$(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").css("display","none");
        }else{
            $(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent .submenu").css("display","block");
			$(".section").eq(ul_index).find("li").eq(li_index).find(".addcontent span").css("display","block");
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
	// 评价按照评论进行查看
	$(".attitude li").on("click",function(){
		var index=$(this).index();
		$(".comment_list").eq(index).css("display","block").siblings(".comment_list").css("display","none");
	});
});