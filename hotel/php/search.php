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
    $search=$_GET['search'];//根据什么进行检索查询后台数据库
    // echo $search;
    $sql="SELECT dishimages,dishname,dishtype FROM `dishes` WHERE dishtype like '%$search%' or dishname like '%$search%' or dishprice='$search' or dishintro like '%$search%'";//模糊查询
    $query=mysql_query($sql);//执行查询
    $dishes=array();//数据集
    while($row=mysql_fetch_array($query)){
    	$dishes[] = $row;
    }
    echo json_encode(array("datalist"=>$dishes)); //向前台返回json数据   
 ?>