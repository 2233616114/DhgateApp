<?php  
   // 消除错误警告
   error_reporting(0);
   header("Content-type: text/html; charset=utf-8");
   //创建数据库连接
   $con=mysql_connect("localhost","root","xueyingying");
   if(!$con){
   	die("连接数据库失败");
   }
   //选择连接的数据库
   mysql_select_db("hotel",$con);

?>