$(function(){
	// 页面回退效果
	$(".imgL").on("click",function(){
		window.history.go(-1);
	});
	var s=window.localStorage;//本地存储
    var username=s.getItem("username");
    var array=[];
    
	$("li").on("click",function(){
		//首先判断用户是否已经登录，登录过的则无需登录，否则重新登录在进行座位的预订
		if(username==null){
			alert("该用户还未登录，请登录后进行操作!");
			window.location.href="login.html";
		}else{
			var img_src=$(this).find("img").attr("src");
			if(img_src=="img/dingwei2.png"){//图标为红色，表示座位已经被预订
				alert("此位置已经被预定，请重新选择!");
			}else{
				$(this).find("img").attr("src","img/dingwei3.png");//图标为绿色，表示可以正在预定中
				$("footer input").css({"background-color":"#29CC6D","color":"#fff"});
				var row_index=$(this).parent().index();//第几排
				var col_index=$(this).index();//第几列
				// 追加li,将选的座位信息在页面上显示出来
				var string="<li>"+row_index+"排"+col_index+"座</li>";
				$(".message ol").append(string);
				// 添加到数组中
				array.push(row_index+"排"+col_index+"座");
			}
		}
	});
	// 点击提交按钮执行的操作，利用ajax进行与后台数据的交互
	$(".submit").on("click",function(){
		if(username==null){
			alert("该用户还未登录，请登录后进行操作!");
			window.location.href="login.html";
		}else{
			//判断时间是否在服务范围内，规定当天的7:00-18:00可以预订餐厅位置，逾期不予预订
			var date1=new Date();
			var year=date1.getFullYear();
			var month=date1.getMonth()+1;
			var day=date1.getDate();
			var hour=date1.getHours();
			var minute=date1.getMinutes();
			var second=date1.getSeconds();//获取秒数
		    if(hour<7 || hour>17){
		    	alert("不在系统的服务时间范围内，请在当天的7:00-18:00进行预订!");
		    	window.location.href='book_seat.html';//
		    }else{
		    	//获取当前系统的时间
		    	var time=year+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
		    	$.ajax({
					type:"get",
					url:"./php/book_seat.php?position="+array+"&username="+username+"&time="+time,
					dataType:"text",//字符串格式形式
					async:true,
					success:function(data){
						alert("您已预定位置成功!");
						$(".message ol").text("");      //把文字的内容清空
						data=data.slice(0,data.length-1);//去除最后一个空的字符串
						console.log(data);
					    //拆分成数组的形式
					    var arr_position=data.split(",");
					    console.log(arr_position);
					    for(var j=0;j<arr_position.length;j++){
					    	var row=arr_position[j][0];
					    	var col=arr_position[j][2];
					    	console.log(row+" "+col);
					    	$(".seat ul").eq(row-1).find("li").eq(col-1).find("img").attr("src","img/dingwei2.png");
					    }
					},
					error:function(){
						alert("请求失败!");
					}
				});
		    }
			
		}
		
	});
    $.ajax({
		type:"get",
		url:"./php/book_seat.php?position="+array+"&username="+username,
		dataType:"text",//字符串格式形式
		async:true,
		success:function(data){
			data=data.slice(0,data.length-1);//去除最后一个空的字符串
			console.log(data);
		    //拆分成数组的形式
		    var arr_position=data.split(",");
		    console.log(arr_position);
		    for(var j=0;j<arr_position.length;j++){
		    	var row=arr_position[j][0];
		    	var col=arr_position[j][2];
		    	console.log(row+" "+col);
		    	$(".seat ul").eq(row-1).find("li").eq(col-1).find("img").attr("src","img/dingwei2.png");
		    }
		},
		error:function(){
			alert("请求失败!");
		}
	});
    //获取当前系统的时间
    function gettime(){
    	var date=new Date();
    	var year=date.getFullYear();
    	var month=date.getMonth()+1;
    	var day=date.getDate();
    	var hour=date.getHours();//获取时
    	if(hour<10){
    		hour="0"+hour;
    	}
    	var minute=date.getMinutes();//获取分
    	if(minute<10){
    		minute="0"+minute;
    	}
    	return year+"-"+month+"-"+day+" "+hour+":"+minute;
    }
    $(".time").text(gettime());
});