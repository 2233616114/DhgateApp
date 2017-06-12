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
    $dishmess=$_GET['dishmess'];
    $time=$_GET['time'];
    $price=$_GET['dishprice'];//价格
    $attitude=$_GET['attitude'];
    $comment=$_GET['comment'];
    $orderid=$_GET['orderid'];
    // echo $orderid;
    $sql="INSERT INTO `comment`( `username`, `comments`, `attitude`, `dishmess`, `time`,`price`,`orderid`) VALUES ('$username','$comment','$attitude','$dishmess','$time','$price','$orderid')";
    if(mysql_query($sql,$con)){
        echo "评论成功!";

    }else{
        echo "评论失败!";
        echo mysql_error();
    }

    //在订单表中根据已经评论的订单号设置改单是否已经评论过
    $sql2="UPDATE `order` SET `comment_not`=1 where orderid='$orderid' ";
    if(mysql_query($sql2,$con)){
        echo "执行成功！";
    }else{
        echo "执行失败!";
    }
?>