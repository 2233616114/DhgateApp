<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>all_comment(点击查看所有的评论)</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<link rel="stylesheet" type="text/css" href="css/all_comment.css" />
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/all_comment.js"></script>
</head>
<body>
	<div class="con">
		<header>
			<a href="">
				<img class="imgL" src="img/back.png" />
			</a>
			<p>全部评论</p>
		</header>
		<section>
			<div class="comment_list">
    			<ul>
    			<?php
    			error_reporting(0);
			    header("Content-type: text/html; charset=UTF-8");
			    //创建数据库连接
				$con=mysql_connect("localhost","root","xueyingying");
				$username=$_GET['username'];//获取用户名
				mysql_query("set names 'utf8'",$con);//设置数据库中的字段编码格式
				if(!$con){
				   die("连接数据库失败");
				}
				//选择连接的数据库
			    mysql_select_db("hotel",$con);
			    $sql="select * from comment where username='$username'";
			    $query=mysql_query($sql,$con);
			    while($row=mysql_fetch_array($query)){
			    	echo "<li>";
			    	echo "<div class='user'>";
			    	echo "<img src='img/user_logo.png' />";
			    	echo "<span>订单号:";
			    	echo $row['orderid'];
			    	echo "</span>";
			    	echo "</div>";
			    	echo "<div class='choose'>";
			    	echo "<p class='time'>$row[time]</p>";
			    	echo "<span class='dishname'>$row[dishmess]</span>";
			    	echo "<span class='attitudes'>$row[attitude]</span>";
			    	echo "</div>";
			    	echo "<div class='description'>
    						$row[comments]
    					</div>";
    			    echo "</li>";
			    }
    			?>
    				<!-- <li>
    					<div class="user">
    						<img src="img/user_logo.png" />
    						<span>13718446976</span>
    					</div>
    					<div class="choose">
    						<p class="time">2017-05-06 </p>
    						<span class="dishname">玉米羹</span>
    						<span class="attitudes">满意</span>
    					</div>
    					<div class="description">
    						味道挺好的，很值得品尝一下！味道挺好的，很值得品尝一下！味道挺好的，很值得品尝一下！味道挺好的，很值得品尝一下！
    					</div>
    				</li> -->
    				
    			</ul>
    		</div>
		</section>
		<footer>
            
		</footer>
	</div>
</body>
</html>