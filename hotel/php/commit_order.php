<?php
    error_reporting(0);
    header("Content-type: text/html; charset=UTF-8");
    //创建数据库连接
	$con=mysql_connect("localhost","root","xueyingying");
	mysql_query("set names 'utf8'",$con);//设置数据库中的字段编码格式
	if(!$con){
	   die("连接数据库失败");
	}
	//选择连接的数据库
    mysql_select_db("hotel",$con);
    $nowtime=$_GET['nowtime'];
    $menu_mess=$_GET['menu_mess'];
    $orderid=$_GET['orderid'];
    $total_price=$_GET['total_price'];
    echo $nowtime." ".$menu_mess." ".$orderid." ".$total_price;
    $username=$_GET['username'];
    echo $username;
    $sql="INSERT INTO `order`(`orderid`, `ordermess`, `ordertime`, `orderprice`, `order_user`) VALUES ('$orderid','$menu_mess','$nowtime','$total_price','$username')";
    if(mysql_query($sql,$con)){
    	echo "<script>
    	         alert('订单已经提交成功!');
    	      </script>";
    }else{
    	echo "<script>
    	         alert('订单提交失败!');
    	      </script>";
    }
?>