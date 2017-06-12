$(function(){
	//页面回退
	$(".imgL").on("click",function(){
		window.history.go(-1);
	});
    //获取当前的用户名
    var s=window.localStorage;
    var username=s.getItem("username");
	//接受地址栏参数信息
	var URL=window.location.search;
    var url=decodeURI(URL.substr(1));
    var url2=url.substring(0,url.length-1);
	var arr=url2.split("&");
	var obj={};
	for(var i=0;i<arr.length;i++){
		var arrdata=arr[i].split("=");
		obj[arrdata[0]]=arrdata[1];
	}
	console.log(obj.username);
	console.log(obj.dishmess);
	var time=getTime();
	console.log(time);
	// 获取当前的日期
    function getTime(){
        var date=new Date();
        var year=date.getFullYear();
        var month=date.getMonth()+1;
        var day=date.getDate();
        var hour=date.getHours();
        var minute=date.getMinutes();
        return year+"-"+month+"-"+day+" "+hour+":"+minute;
    }
    // 点击发布
    $("footer input").on("click",function(){
    	var attitude=$("select").val();
    	var comment=$("textarea").val();

    	//向后台发送ajax请求
    	$.ajax({
    		url:'./php/comment.php?username='+obj.username+"&dishprice="+obj.dishprice+"&dishmess="+obj.dishmess+"&time="+time+"&attitude="+attitude+"&comment="+comment+"&orderid="+obj.orderid,
    		type:'get',
    		async:true,
    		success:function(data){
    			console.log(data);
    			alert("发表评论成功!");
                //跳转至发表评论成功界面
                window.location.href="./comment_success.html";
    		},
    		error:function(){
    			alert("数据发送请求失败!");
    		}

    	});
    });

});