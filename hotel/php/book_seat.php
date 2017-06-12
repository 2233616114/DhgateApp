<?php
    error_reporting(0);
    header("Content-type: text/html; charset=UTF-8");
    date_default_timezone_set('PRC');//设置东八区时间
    //创建数据库连接
	$con=mysql_connect("localhost","root","xueyingying");
	mysql_query("set names 'utf8'",$con);//设置数据库中的字段编码格式
	if(!$con){
	   die("连接数据库失败");
	}
	//选择连接的数据库
    mysql_select_db("hotel",$con);
    $position=$_GET['position'];
    $username=$_GET['username'];
    $time=$_GET['time'];
    //echo $time;
    // $time_ymd=explode(" ",$time);
    // echo $time_ymd[0];
    // 获得当前系统的时间
    $year=date("Y");
    $month=date("m");
    $day=date("d");
    $hour=date("H");
    $minute=date("i");
    $second=date("s");
    $book_time=strtotime($time);//预订时间的时间戳
    $now=$year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
    $now_time=strtotime($now);//当前系统时间的时间戳
    $timestart=strtotime($year."-".$month."-".$day." "."7:00:00");//获取当天7点时间的时间戳
    $timeend=strtotime($year."-".$month."-".$day." "."18:00:00");//获取当天18:00的时间戳
    //echo $timestart." ".$book_time." ".$timeend;
    $arr=explode(",",$position);//字符串切分成数组
    //根据时间判断，规定餐厅预订位置的时间，用户第一天预订的位置将在当天的18:00失效，系统设定时间
    if($book_time<=$timeend && $book_time>=$timestart){
        for($i=0;$i<count($arr);$i++){//遍历数组的长度
            $sql="UPDATE `desk` SET `choose_not`=1,`choose_time`='$time',`user`='$username' WHERE position='$arr[$i]' ";
            if($query=mysql_query($sql,$con)){
                //echo "数据插入成功!";
            }
            else{
                //echo "数据插入失败!";
            }
        } 
    }

    /*新增加的功能*/
    //如果预订座位的时间超过11个小时(39600秒)，则系统自动会把位置清空
    $subtime= $now_time-$book_time;
    //echo $now_time." ".$book_time." ";
    //echo $subtime;
    /*if ($subtime>39600) {
        $sql2="UPDATE `desk` SET `choose_not`=0,`choose_time`='',`user`='' WHERE `choose_not`=1 ";
        $query=mysql_query($sql2,$con);//更新数据库中的desk表的相应字段
    }*/
    
    // 从数据库中查询数据显示在页面上
    $sql_selected_desk="select * from desk where choose_not=1";
    $query=mysql_query($sql_selected_desk,$con);
    while($row=mysql_fetch_array($query)){
        echo $row['position'].",";
    }
 ?>