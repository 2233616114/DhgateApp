<!-- 引入连接数据库文件 -->
<?php 
    error_reporting(0);
    header("Content-type: text/html; charset=utf-8");
    // include "connectdb.php";
    //创建数据库连接
	$con=mysql_connect("localhost","root","xueyingying");
	if(!$con){
	   die("连接数据库失败");
	}
	//选择连接的数据库
    mysql_select_db("hotel",$con);
    //正则匹配
    $reg1 = "/^1\d{10}$/";//用于判断手机注册账号
    $reg2 = "/^[0-9A-Za-z]{8,16}$/";
    preg_match($reg1,$_POST['phone_number'],$result1);
    preg_match($reg2,$_POST['pwd_one'],$result2);
    if($result1[0]==""){
        echo "<script type='text/javascript'>              alert('账号格式有误,请重新输入!');
            window.location.href='../register.html';
                 </script>";
    }else if($result2[0]==""){
        echo "<script type='text/javascript'>              alert('密码格式输入不正确!');
            window.location.href='../register.html';
                 </script>";
    }else{
    	//检测该用户是否注册过
    	$sql1="select * from user where username='$_POST[phone_number]'";
    	$query=mysql_query($sql1,$con);
    	$num=mysql_num_rows($query);
    	if($num>0){
    		echo "<script type='text/javascript'>alert('该用户已经存在,请直接登录!');
    		    window.location.href='../login.html';
    		</script>";
    	}else{
    		//向数据库表中加入数据
    		$phone_number=$_POST['phone_number'];
    		$sql="insert into user(username,password)values($phone_number,'$_POST[pwd_one]')";
    		mysql_query($sql,$con);
    	    // echo $_POST['phone_number'];
    		echo "<script type='text/javascript'>              alert('用户注册成功!');
                window.location.href='../login.html';
    		     </script>";
    	}
    }
?>