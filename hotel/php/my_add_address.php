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
    $name=$_GET['name'];
    $tel=$_GET['tel'];
    $address=$_GET['address'];
    echo $name." ".$tel." ".$address;
    $sql="INSERT INTO `address`( `name`, `tel`, `address`, `username`) VALUES ('$name','$tel','$address','$username')";
    if(mysql_query($sql,$con)){
        echo "新增地址成功!";
    }else{
        echo "新增地址失败!";
    }
?>
