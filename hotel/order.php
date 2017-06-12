<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>order(订单页面)</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<link rel="stylesheet" type="text/css" href="css/order.css" />
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/order.js"></script>
</head>
<body>
	<div class="con">
		<!--头部 -->
		<header>
			<img class="imgL" src="img/back.png" />
			<p class="header_title">订单</p>
		</header>	
		<!-- 生成的订单 -->
        <section>
	        <p>我的订单</p>
	        <a>全部订单></a>
	        <div class="clear"></div>
	        <ul> 
	            <?php
	                error_reporting(0);
				    header("Content-type: text/html; charset=UTF-8");
					$con=mysql_connect("localhost","root","xueyingying");
					mysql_query("set names 'utf8'",$con);//设置数据库中的字段编码格式
					if(!$con){
					   die("连接数据库失败");
					}
					//选择连接的数据库
				    mysql_select_db("hotel",$con);
				    $username=$_GET['username'];
	                $sql="SELECT * FROM `order` where order_user=$username";
				    $query=mysql_query($sql);
				    while($row=mysql_fetch_array($query)){
					    echo "<li>";
	        	    	echo      "<div class='user'>";			echo         "<img src='img/shaozhanggui_logo.png' />";
				        echo         "<span>少掌柜饭店</span>";
				        echo         "<span class='order'>订单号:";
				        echo         $row['orderid'];
				        echo         "</span>";
					    echo      "</div>";
					    echo      "<p class='time'>$row[ordertime]</p>";
					    echo      "<p class='dishname'>$row[ordermess]</p>";
					    echo      "<p class='price'>";
                        echo          "<img src='img/price3.png' />";
					    echo	      "<span>$row[orderprice]</span>";
					    echo      "</p>";
					    if($row['comment_not']==0){
					    	echo      "<button>评论</button>"; 
					    }else{
					    	echo      "<button>已评论</button>";
					    }
	        	        echo "</li>"; 
				    }
	            ?>

	        	<!-- <li>
	        		<div class="user">
						<img src="img/shaozhanggui_logo.png" />
				        <span>少掌柜饭店</span>
					</div>
					<p class="time">2017-05-06</p>
					<p class="dishname">玉米羹</p>
					<p class="price">
                        <img src="img/price3.png" />
						<span>22.0</span>
					</p>
	        	</li>
	        	<li>
	        		<div class="user">
						<img src="img/shaozhanggui_logo.png" />
				        <span>少掌柜饭店</span>
					</div>
					<p class="time">2017-05-06</p>
					<p class="dishname">玉米羹</p>
					<p class="price">
                        <img src="img/price3.png" />
						<span>22.0</span>
					</p>
					<button>评论</button>
	        	</li> -->
	        </ul>
        </section>
        <!-- 底部 -->
		<footer>
			<ul class="footer_menu">
				<li>
					<a href="index.html">
						<img src="img/home.png" />
						
					</a>
					<p>首页</p>
				</li>
				<li>
					<a href="activity_list.php">
						<img src="img/activity.png" />
						
					</a>
					<p>活动</p>
				</li>
				<li>
					<a>
						<img src="img/orders.png" />
					</a>
					<p>订单</p>
				</li>
				<li>
					<a href="my.html">
						<img src="img/my.png" />
					</a>
					<p>我的</p>
				</li>
			</ul>
		</footer>
	</div>
</body>
</html>