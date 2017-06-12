<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>菜品展示</title>
	<link rel="stylesheet" href="css/bootstrap2.css" />
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<link rel="stylesheet" type="text/css" href="css/list_item.css" />
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/list_item.js"></script>
</head>
<body>
	<div class="con">
	    <!-- 头部图片 -->
		<header>
		    <div class="imgheader">
		    	<img class="imgcontent" src="img/food3.png" />
		    	<div class="mengban"></div>
	    		<img class="imgback" src="img/arrow_left.png" />
		    	<div class="header_bottom">
		    	    <img src="img/intro_3_02.png" />
		    		<span>5月大优惠、本店优惠酬宾活动已开始!</span>
		    	</div>
		    </div>
			<ul>
				<li class="on">点菜</li>
				<li>评价</li>
			</ul>
		</header>
		<!-- 中间内容 -->
		<section style="position:relative;" data-spy="scroll" data-target=".navbar" data-offset="50">
			<!-- 点菜部分菜单 -->
                <div class="tab_menu diancai">
                	<nav class="navbar navbar-inverse navbar-fixed-top navbar2"  style="float:left;width:30%;">
						<div class="container-fluid">
							<div >
					            <!-- 顶部导航区域 -->
								<div class="collapse navbar-collapse" id="myNavbar">
									<ul class="nav navbar-nav">
										<li>
											<a href="#section1">凉菜</a>
                                            <span class="count">1</span>
										</li>
										<li>
											<a href="#section2">精品凉菜</a>
											<span class="count">1</span>
										</li>
										<li><a href="#section3">家常菜</a></li>
										<li><a href="#section4">蒸菜</a></li>
										<li><a href="#section5">小吃</a></li>
										<li><a href="#section6">特色菜</a></li>
										<li><a href="#section7">汤羹类</a></li>
										<li><a href="#section8">酒水类</a></li>
									</ul>
								</div>

							</div>
						</div>
					</nav>    
				    <div style="float:right;width:70%;">
						<div id="section1" class="section container-fluid">
							<h1>凉菜</h1>
							<ul class="menu_list">
							<?php
							    error_reporting(0);
							    header("Content-type: text/html; charset=UTF-8");
								$con=mysql_connect("localhost","root","xueyingying");
								mysql_query("set names 'utf8'",$con);
								if(!$con){
								   die("连接数据库失败");
								}
							    mysql_select_db("hotel",$con);
							    $sql1="select * from dishes where dishtype='凉菜'";
							    $query1=mysql_query($sql1,$con);
							    while($row=mysql_fetch_array($query1)){
							    	echo "<li>";
							    	echo    "<div class='imgcontent'>";
							    	echo        "<img src='$row[dishimages]' />";
							    	echo     "</div>";
							    	echo    "<div class='introcontent'>";
							    	echo        "<h6>$row[dishname]</h6>";
							    	echo        "<dl>";
							    	echo            "<dt>销量";
							    	echo              $row['dishsell'];
							    	echo            "</dt>";
							    	echo            "<dd><span>$row[dishprice]</span> 元/份</dd>";
							    	echo        "</dl>";
							    	echo    "</div>";
							    	echo    "<div class='addcontent'>";
							    	echo        "<img class='addmenu' src='img/addmenu.png' />";
							    	echo        "<span>0</span>";
							    	echo        "<img class='submenu' src='img/submenu.png' />";
							    	echo    "</div>";
							    	echo "</li>";
							    }
							?>
								<!-- <li>
									<div class="imgcontent">
										<img src="img/dishes/pidandoufu.png"/>
									<div class="introcontent">
										<h6>皮蛋豆腐</h6>
										<dl>
											<dt>销量0</dt>
											<dd><span>17.1</span> 元/份</dd>
										</dl>
									</div>
									<div class="addcontent">
										<img class="addmenu" src="img/addmenu.png" />
										<span>1</span>
										<img class="submenu" src="img/submenu.png" />
									</div>
								</li> -->
							</ul>
						</div>
						<div id="section2" class="section container-fluid">
							<h1>精品凉菜</h1>
						    <ul class="menu_list">
							<?php
							    $sql2="select * from dishes where dishtype='精品凉菜'";
							    $query2=mysql_query($sql2,$con);
							    while($row=mysql_fetch_array($query2)){
							    	echo "<li>";
							    	echo    "<div class='imgcontent'>";
							    	echo        "<img src='$row[dishimages]' />";
							    	echo     "</div>";
							    	echo    "<div class='introcontent'>";
							    	echo        "<h6>$row[dishname]</h6>";
							    	echo        "<dl>";
							    	echo            "<dt>销量";
							    	echo              $row['dishsell'];
							    	echo            "</dt>";
							    	echo            "<dd><span>$row[dishprice]</span> 元/份</dd>";
							    	echo        "</dl>";
							    	echo    "</div>";
							    	echo    "<div class='addcontent'>";
							    	echo        "<img class='addmenu' src='img/addmenu.png' />";
							    	echo        "<span>0</span>";
							    	echo        "<img class='submenu' src='img/submenu.png' />";
							    	echo    "</div>";
							    	echo "</li>";
							    }
							?>    
						    </ul>
						</div>
						<div id="section3" class="section container-fluid">
							<h1>家常菜</h1>
							<ul class="menu_list">
							<?php
							    $sql3="select * from dishes where dishtype='家常菜'";
							    $query3=mysql_query($sql3,$con);
							    while($row=mysql_fetch_array($query3)){
							    	echo "<li>";
							    	echo    "<div class='imgcontent'>";
							    	echo        "<img src='$row[dishimages]' />";
							    	echo     "</div>";
							    	echo    "<div class='introcontent'>";
							    	echo        "<h6>$row[dishname]</h6>";
							    	echo        "<dl>";
							    	echo            "<dt>销量";
							    	echo              $row['dishsell'];
							    	echo            "</dt>";
							    	echo            "<dd><span>$row[dishprice]</span> 元/份</dd>";
							    	echo        "</dl>";
							    	echo    "</div>";
							    	echo    "<div class='addcontent'>";
							    	echo        "<img class='addmenu' src='img/addmenu.png' />";
							    	echo        "<span>0</span>";
							    	echo        "<img class='submenu' src='img/submenu.png' />";
							    	echo    "</div>";
							    	echo "</li>";
							    }
							?>    
						    </ul>
						</div>
						<div id="section4" class="section container-fluid">
							<h1>蒸菜</h1>
							<ul class="menu_list">
							<?php
							    $sql4="select * from dishes where dishtype='蒸菜'";
							    $query4=mysql_query($sql4,$con);
							    while($row=mysql_fetch_array($query4)){
							    	echo "<li>";
							    	echo    "<div class='imgcontent'>";
							    	echo        "<img src='$row[dishimages]' />";
							    	echo     "</div>";
							    	echo    "<div class='introcontent'>";
							    	echo        "<h6>$row[dishname]</h6>";
							    	echo        "<dl>";
							    	echo            "<dt>销量";
							    	echo              $row['dishsell'];
							    	echo            "</dt>";
							    	echo            "<dd><span>$row[dishprice]</span> 元/份</dd>";
							    	echo        "</dl>";
							    	echo    "</div>";
							    	echo    "<div class='addcontent'>";
							    	echo        "<img class='addmenu' src='img/addmenu.png' />";
							    	echo        "<span>0</span>";
							    	echo        "<img class='submenu' src='img/submenu.png' />";
							    	echo    "</div>";
							    	echo "</li>";
							    }
							?>    
						    </ul>
						</div>
						<div id="section5" class="section container-fluid">
							<h1>小吃</h1>
							<ul class="menu_list">
							<?php
							    $sql5="select * from dishes where dishtype='小吃'";
							    $query5=mysql_query($sql5,$con);
							    while($row=mysql_fetch_array($query5)){
							    	echo "<li>";
							    	echo    "<div class='imgcontent'>";
							    	echo        "<img src='$row[dishimages]' />";
							    	echo     "</div>";
							    	echo    "<div class='introcontent'>";
							    	echo        "<h6>$row[dishname]</h6>";
							    	echo        "<dl>";
							    	echo            "<dt>销量";
							    	echo              $row['dishsell'];
							    	echo            "</dt>";
							    	echo            "<dd><span>$row[dishprice]</span> 元/份</dd>";
							    	echo        "</dl>";
							    	echo    "</div>";
							    	echo    "<div class='addcontent'>";
							    	echo        "<img class='addmenu' src='img/addmenu.png' />";
							    	echo        "<span>0</span>";
							    	echo        "<img class='submenu' src='img/submenu.png' />";
							    	echo    "</div>";
							    	echo "</li>";
							    }
							?>    
						    </ul>
						</div>	
						<div id="section6" class="section container-fluid">
							<h1>特色菜</h1>
							<ul class="menu_list">
							<?php
							    $sql6="select * from dishes where dishtype='特色菜'";
							    $query6=mysql_query($sql6,$con);
							    while($row=mysql_fetch_array($query6)){
							    	echo "<li>";
							    	echo    "<div class='imgcontent'>";
							    	echo        "<img src='$row[dishimages]' />";
							    	echo     "</div>";
							    	echo    "<div class='introcontent'>";
							    	echo        "<h6>$row[dishname]</h6>";
							    	echo        "<dl>";
							    	echo            "<dt>销量";
							    	echo              $row['dishsell'];
							    	echo            "</dt>";
							    	echo            "<dd><span>$row[dishprice]</span> 元/份</dd>";
							    	echo        "</dl>";
							    	echo    "</div>";
							    	echo    "<div class='addcontent'>";
							    	echo        "<img class='addmenu' src='img/addmenu.png' />";
							    	echo        "<span>0</span>";
							    	echo        "<img class='submenu' src='img/submenu.png' />";
							    	echo    "</div>";
							    	echo "</li>";
							    }
							?>    
						    </ul>
						</div>
						<div id="section7" class="section container-fluid">
							<h1>汤羹类</h1>
							<ul class="menu_list">
							<?php
							    $sql7="select * from dishes where dishtype='汤羹类'";
							    $query7=mysql_query($sql7,$con);
							    while($row=mysql_fetch_array($query7)){
							    	echo "<li>";
							    	echo    "<div class='imgcontent'>";
							    	echo        "<img src='$row[dishimages]' />";
							    	echo     "</div>";
							    	echo    "<div class='introcontent'>";
							    	echo        "<h6>$row[dishname]</h6>";
							    	echo        "<dl>";
							    	echo            "<dt>销量";
							    	echo              $row['dishsell'];
							    	echo            "</dt>";
							    	echo            "<dd><span>$row[dishprice]</span> 元/份</dd>";
							    	echo        "</dl>";
							    	echo    "</div>";
							    	echo    "<div class='addcontent'>";
							    	echo        "<img class='addmenu' src='img/addmenu.png' />";
							    	echo        "<span>0</span>";
							    	echo        "<img class='submenu' src='img/submenu.png' />";
							    	echo    "</div>";
							    	echo "</li>";
							    }
							?>    
						    </ul>
						</div>
						<div id="section8" class="section container-fluid">
							<h1>酒水类</h1>
							<ul class="menu_list">
							<?php
							    $sql8="select * from dishes where dishtype='酒水类'";
							    $query8=mysql_query($sql8,$con);
							    while($row=mysql_fetch_array($query8)){
							    	echo "<li>";
							    	echo    "<div class='imgcontent'>";
							    	echo        "<img src='$row[dishimages]' />";
							    	echo     "</div>";
							    	echo    "<div class='introcontent'>";
							    	echo        "<h6>$row[dishname]</h6>";
							    	echo        "<dl>";
							    	echo            "<dt>销量";
							    	echo              $row['dishsell'];
							    	echo            "</dt>";
							    	echo            "<dd><span>$row[dishprice]</span> 元/份</dd>";
							    	echo        "</dl>";
							    	echo    "</div>";
							    	echo    "<div class='addcontent'>";
							    	echo        "<img class='addmenu' src='img/addmenu.png' />";
							    	echo        "<span>0</span>";
							    	echo        "<img class='submenu' src='img/submenu.png' />";
							    	echo    "</div>";
							    	echo "</li>";
							    }
							?>
							<!-- 增加一个空的li标签 -->
							<li></li>    
						    </ul>
						</div>
					</div>
                </div>
				
			<!-- 评论部分菜单 -->
                <div class="tab_menu comment">
                	<div class="comment_score">
                		<div class="total_score">
                			<h2>4.8</h2>
                			<p>综合评分</p>
                		</div>
                		<div class="part_score">
                			<dl>
                				<dt>菜品评分 <span>4.8</span></dt>
                                <dd>服务态度 <span>4.8</span></dd>
                 			</dl>
                		</div>
                		<div class="clear"></div>
                	</div>
                    <div class="comment_user">
                		<ol class="attitude">
                			<li class="quanbu">
                				<button>全部</button>
                			</li>
                			<li class="satisfy">
                				<button>满意</button>
                			</li>
                			<li class="common">
                				<button>一般</button>
                			</li>
                			<li class="poor">
                				<button>很差</button>
                			</li>
                		</ol>
                		<div class="comment_list comment_quanbu">
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
						    $sql="select * from comment";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
						    	echo "<li>";
						    	echo "<div class='user'>";
						    	echo "<img src='img/user_logo.png' />";
						    	echo "<span>$row[username]</span>";
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
                		<!-- 满意部分 -->
                		<div class="comment_list comment_satisfy">
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
						    $sql="select * from comment where attitude='满意'";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
						    	echo "<li>";
						    	echo "<div class='user'>";
						    	echo "<img src='img/user_logo.png' />";
						    	echo "<span>$row[username]</span>";
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
                			</ul>
                		</div>
                		<!-- 一般部分 -->
                		<div class="comment_list comment_common">
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
						    $sql="select * from comment where attitude='一般'";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
						    	echo "<li>";
						    	echo "<div class='user'>";
						    	echo "<img src='img/user_logo.png' />";
						    	echo "<span>$row[username]</span>";
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
                			</ul>
                		</div>
                		<!-- 很差部分 -->
                		<div class="comment_list comment_poor">
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
						    $sql="select * from comment where attitude='很差'";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
						    	echo "<li>";
						    	echo "<div class='user'>";
						    	echo "<img src='img/user_logo.png' />";
						    	echo "<span>$row[username]</span>";
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
                			</ul>
                		</div>
                    </div>
                </div>
		</section>
		<!-- 底部区域 -->
		<footer>
			<div class="gouwuche">
				<img src="img/gouwuche.png" />
				<div class="count"></div>
			</div>
			<dl>
				<dt><p>购物车是空的</p><span></span></dt>
			    <!-- <dd>配送费:5.00</dd> -->
			</dl>
            <button>选好了</button>
		</footer>
	</div>		
</body>
</html>