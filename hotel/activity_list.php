<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>activity_list活动列表</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<link rel="stylesheet" type="text/css" href="css/activity_list.css" />
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/activity_list.js"></script>
</head>
<body>
	<div class="con">
		<header>
			<a href="">
				<img class="imgL" src="img/back.png" />
			</a>
			<p>活动列表</p>
		</header>
		<section>
			<div class="list tuijian">
			    <div class="tuijian_img">
			    	<img src="img/tuijian.png" />
			    </div>
				<p>你的口味，我都懂得</p>
				<ul>
					<?php
					// 获取当前系统的时间
					$year=date("Y");
					$month=date("m");
					$month=substr($month,1);//字符串的截取
					$day=date("d");
					$time=$year."-".$month."-".$day;
					?>
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
					    //$rand_num=rand(4,69); 
					    $sql="select * from dishes where dish_activity_time='$time' and dishsell>=7 limit 3" ;
                        $query=mysql_query($sql,$con);
                        while($row=mysql_fetch_array($query)){
                        	echo "<li>";
	                        echo"<img class='dishimg' src='$row[dishimages]' />";
							echo"<p class='name'>$row[dishname]</p>";
							echo"<p class='price'>";
							echo"<img src='img/price.png' />";
						    echo"<span>$row[dishprice]</span>";
							echo"</p>";
							echo "</li>";
                        }
                    ?>
				</ul>
                <div class="clear"></div>
			</div>
			<div class="list tejia">
				<div class="tuijian_img">
			    	<img src="img/tejia.png" />
			    </div>
				<p>特价商品，一网打尽</p>
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
				    $sql="select * from dishes where dishdiscount=1 and dish_activity_time='$time' limit 3 ";
                    $query=mysql_query($sql,$con);
                    while($row=mysql_fetch_array($query)){
                        //$rand_count=rand(10,100)/10;
	                    echo "<li>";
	                    echo    "<img class='dishimg' src='$row[dishimages]' />";
	                    echo    "<div class='discount'>";
	                    echo    $row['dishsell'];
	                    echo    "折</div>";
	                    echo    "<p class='name'>$row[dishname]</p>";
	                    echo    "<p class='price'>";
	                    echo       "<img src='img/price.png' />";
	                    echo       "<span>";
	                    echo       sprintf("%.2f",$row[dishprice]*$row['dishsell']/10);
	                    echo       "</span>";
	                    echo    "</p>";
	                    echo    "<p class='del_price'>";
	                    echo       "<img src='img/del_price.png' />";
	                    echo       "<span>$row[dishprice]</span>";
	                    echo    "</p>";
	                    echo "</li>";
                    }
                    
                ?>
					

				</ul>
				<div class="clear"></div>
			</div>
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