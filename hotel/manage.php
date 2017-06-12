<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>manage(后台管理)</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<link rel="stylesheet" type="text/css" href="css/manage.css" />
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/manage.js"></script>
</head>
<body>
	<div class="con">
	    <header>
	    	<p>后台管理</p>
	    	<a href="./login.html">退出登录</a>
	    </header>
		<section>
			<ul>
			    <li>点我</li>
				<li>客户管理</li>
				<li>统计分析</li>
			</ul>

			<div class="content">
			    <div class="tishi">
			    	管理员只能查看用户信息，不能对用户随意更改和删除!
			    </div>
				<div class="user_manage">
					<table>
						<tr>
							<th>用户</th>
							<th>密码</th>
						</tr>
						<!-- 从数据库中读取用户名和密码，方便后台管理员查看 -->
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
					    $sql="select * from user";
					    $query=mysql_query($sql,$con);
					    while($row=mysql_fetch_array($query)){
						    echo "<tr>";
						    echo "<td>$row[username]</td>";
						    echo "<td>...</td>";
						    echo "</tr>";
					    }
						?>
						<!-- <tr>
							<td>13718446976</td>
							<td>xueyingying1234</td>
						</tr>  -->
					</table>
				</div>
				<div class="summary">
					<table>
						<tr>
							<th>种类</th>
							<th>详细信息介绍</th>
						</tr>
						<tr>
							<td>凉菜</td>
							<td>
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
						    $sql="select * from dishes where dishtype='凉菜'";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
							    echo $row['dishname']."、" ;
						    }
							?>
							</td>
						</tr>
						<tr>
							<td>家常菜</td>
							<td>
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
						    $sql="select * from dishes where dishtype='家常菜'";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
							    echo $row['dishname']."、" ;
						    }
							?>
							</td>
						</tr>
						<tr>
							<td>特色菜</td>
							<td>
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
						    $sql="select * from dishes where dishtype='特色菜'";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
							    echo $row['dishname']."、" ;
						    }
							?>
							</td>
						</tr>
						<tr>
							<td>汤羹类</td>
							<td>
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
						    $sql="select * from dishes where dishtype='汤羹类'";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
							    echo $row['dishname']."、" ;
						    }
							?>
							</td>
						</tr>
						<tr>
						    <td>酒水类</td>
						    <td>
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
						    $sql="select * from dishes where dishtype='酒水类'";
						    $query=mysql_query($sql,$con);
						    while($row=mysql_fetch_array($query)){
							    echo $row['dishname']."、" ;
						    }
							?>
						    </td>
						</tr>
					</table>
				</div>
			</div>
		</section>
		<footer>
			
		</footer>
	</div>
</body>
</html>