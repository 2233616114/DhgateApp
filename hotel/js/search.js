$(function(){
	//页面回退
	$(".img_back").on("click",function(){
		window.history.go(-1);
	});
	//点击搜索按钮
	$("header .submit").on("click",function(){
		var search_str=$("input.search").val();
		// ajax向页面发送请求
		$.ajax({
			type:"get",
			url:"./php/search.php?search="+search_str,
			dataType:"json",
			async:true,
			success:function(data){
				var length=data.datalist.length;
	            // console.log(data.datalist);//数组
	            $.each(data.datalist,function(keys,val){
	            	// console.log(val.dishimages);
	            	var string="";
	            	string+="<li>"+
					"<div class='imgcontent'>"+
						"<img src='"+val.dishimages+"'/>"+
					"</div>"+
					"<div class='introcontent'>"+
						"<h6>"+val.dishname+"</h6>"+
						"<dl>"+
							"<dd>"+val.dishtype+"</dd>"+
						"</dl>"+
					"</div>"+
					"<p class='address'>海淀区西北旺</p>"+
				    "</li>";
				    $("section ul").append(string);

				    //地址栏传参
				    $("section ul li .imgcontent").on("click",function(){
				    	var imgstring=$(this).find("img").attr("src");
				    	window.location.href="./activity_description.html?"+imgstring;
				    });
	            });
			},
			error:function(){
				alert("请求发送失败!");
			}
		});
	});
});