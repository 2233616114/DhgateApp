<?php 
    error_reporting(0);
    header("Content-type: text/html; charset=utf-8");
    //创建数据库连接
	$con=mysql_connect("localhost","root","xueyingying");
	if(!$con){
	   die("连接数据库失败");
	}
	//选择连接的数据库
    mysql_select_db("hotel",$con);
    $username=$_POST['username'];
    $password=$_POST['password'];
    //管理员登录，进行统计分析和客户管理
    if($username=="admin" && $password=="admin"){
        echo "<script>
        window.location.href='../manage.php';
        </script>";
    }
    $sql1="select * from user where username=$username";
    $query1=mysql_query($sql1,$con);
    $num1=mysql_num_rows($query1);
    if($username=="" || $password=="" ){
        echo "<script>
             alert('用户名和密码均不能为空!');
             window.location.href='../login.html';
        </script>";
    }else if($num1<=0){
    	echo "<script>
    	     alert('此用户不存在,请重新登录!');
             window.location.href='../login.html';
    	</script>";
    }else{
    	//用户存在数据库中
    	$row=mysql_fetch_array($query1);//输出查询结果
    	if($row['password']!=$password){
    		echo "<script>
    	     alert('该用户的密码错误，请重新输入密码!');
              window.location.href='../login.html';
    	</script>";
    	}else{
    		echo "<script>
    	     alert('用户登录成功!');
    	     window.location.href='../index.html';
             var s=window.localStorage;
             s.setItem('username',$username);
             s.setItem('search','[]');//记录搜索关键词 
    	</script>";
    	}
    }
    
?>