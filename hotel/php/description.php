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
    $imgstring=$_GET['url'];
    $sql="select dishimages,dishname,dishsell,dishprice,dishintro from dishes where dishimages='$imgstring'";
    $query=mysql_query($sql);
    $row=mysql_fetch_row($query);
    echo json_encode(array("dishes"=>$row)); 
 ?>