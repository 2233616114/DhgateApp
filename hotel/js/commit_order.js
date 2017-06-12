$(function(){
	$(".imgL").on("click",function(){
		window.history.go(-1);
	});
	//在页面上渲染数据
	var s=window.localStorage;//本地存储
	var arr_dishname=JSON.parse(s.getItem("cart_dishname"));
	var arr_dishprice=JSON.parse(s.getItem("cart_dishprice"));
	var username=s.getItem("username");
	var length=arr_dishname.length;
	var obj_dishname={};//初始化一个对象
	var obj_dishprice={};
	/*统计各道菜买的份数*/
	for(var i=0;i<length;i++){
		var s=arr_dishname[i];
		var result=obj_dishname[s];
		if(result){
			obj_dishname[s]+=1;
		}else{
			obj_dishname[s]=1;
		}
	}
	/*统计每道菜的价格*/
	for(var j=0;j<length;j++){
		obj_dishprice[arr_dishname[j]]=arr_dishprice[j];
	}
	console.log(JSON.stringify(obj_dishname));//统计每道菜出现的份数
	console.log(obj_dishprice);
	// 遍历一个对象
	for(var i in obj_dishname){
		// console.log(i+" "+obj_dishname[i]+"<br>");
		var string="<dl>"+
				   	"<dt>"+i+"</dt>"+
					"<dd>X "+obj_dishname[i]+"</dd>"+
					"<span>"+(obj_dishprice[i]*obj_dishname[i]).toFixed(2)+"</span>"+
				"</dl>";

	    $(".price_content").append(string);
	}
	//计算餐盒费
	function canhe_total(length){
		return length;
	}
	//计算总价
	function total_price(){
		var total=0;
		for(var i=0;i<arr_dishprice.length;i++){
			total+=parseFloat(arr_dishprice[i]);
		}
		total+=canhe_total(length)*1;
		return total.toFixed(2);
	}
	$(".canhe dd").text("X "+canhe_total(length));
	$(".canhe span").text(canhe_total(length).toFixed(2));
	$(".total span").text(total_price());
	// 点击确认下单生成订单
	function getTime(){
		var date=new Date();
		var year=date.getFullYear();
		var month=date.getMonth()+1;
        var day=date.getDate();
        var hour=date.getHours();
        var minute=date.getMinutes();
        return year+"-"+month+"-"+day+" "+hour+":"+minute;
	}
	$("footer button").on("click",function(){
		/*获取当前系统的时间*/
		var nowtime=getTime();
		/*用随机数的形式创建订单号*/
		var array=[];
		var order_string="";
		for(var i=0;i<10;i++){
			array[i]=Math.floor(Math.random()*10);
			order_string+=array[i];
		}
        var orderid=window.confirm(order_string);
        if(orderid==true){//确认生成订单
        	//获取菜单信息
        	//获取价格
        	//获取时间
        	//获取订单号
        	var tot_price=total_price();
        	var menu_mess="";
        	for(var i in obj_dishname){
        		menu_mess+=i+obj_dishname[i]+"份、";
        	}
        	$.ajax({
        		url:'./php/commit_order.php?orderid='+order_string+"&nowtime="+nowtime+"&total_price="+tot_price+"&menu_mess="+menu_mess+"&username="+username,
        		type:'get',
        		dataType:'text',
        		async:true,
        		success:function(data){
        			alert("订单已经提交成功,请耐心等待!")
        			console.log(data);
        			// 跳转至我的订单界面
        			// // 将用户的信息传至地址栏参数
        			window.location.href="./order.php?username="+username;
        		},
        		error:function(){
        			alert("数据发送请求失败!");
        		}
        	});
        }else{
        	//订单无效
        }
	});
}); 