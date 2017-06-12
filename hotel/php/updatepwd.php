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
    $username=$_POST['username'];
    $newpass=$_POST['newpassword'];
    if($username=="" || $newpass==""){
        echo "<script>;
             alert('请输入用户名和新密码!');
             window.location.href='../my_pwd.html';
             </script>";
    }else{//用户名和密码不为空的情况
        $sql="select * from user where username=$username";
        $query=mysql_query($sql,$con);//执行从数据库中查询是否有此注册用户
        $num=mysql_num_rows($query);
        // echo $num;
        if($num>0){
            $reg = "/^[0-9A-Za-z]{8,16}$/";
            preg_match($reg,$newpass,$result);
            if($result[0]==""){//密码输入格式不正确
                echo "<script>";
                echo "alert('密码必须为8-16位数字，字母或者字母和数字的组合!')";
                echo "</script>";
            }
            else{
                $sql2="UPDATE `user` SET `password`='$newpass' WHERE username='$username'";
                if(mysql_query($sql2,$con)){
                    echo "<script>;
                     alert('用户更改密码成功');
                     window.location.href='../my.html';//修改密码成功后跳转至我的页面
                     </script>";
                }else{
                    echo "<script>";
                    echo "alert('数据更新失败!')";
                    echo "</script>";
                }
            }
        }else{
            echo "<script>"; 
            echo "alert('此用户没有注册过!')";
            echo "</script>";
        }
    }
    
?>