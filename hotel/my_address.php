<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>my_address(收货地址)</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<link rel="stylesheet" type="text/css" href="css/my_address.css" />
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/my_address.js"></script>
</head>
<body>
	<div class="con">
		<header>
			<img class="imgL" src="img/back.png" />
			<p class="header_title">收货地址</p>
		</header>
		<section>
			<!-- 新增收货地址的盒子，向页面追加信息 -->
			<ul>
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
			    $username=$_GET['username'];
			    $sql="select * from address where username='$username' ";
			    $query=mysql_query($sql,$con);
			    while($row=mysql_fetch_array($query)){
			    	echo "<li>"; 
			    	echo "<p class='address'>$row[address]</p>";
			    	echo "<span class='name'>$row[name]</span>";
			    	echo "<span class='tel'>$row[tel]</span>";
			    	echo "</li>";
			    }
				?>
			</ul>
		</section>
		<footer>
			<p>+</p>
			<span>新增地址</span>
		</footer>
	</div>
</body>
</html>