<?php

$name=$_POST['name'];

$group=$_POST['groupnum'];

$flag = 0;

if(!$name || !$group) {

echo "姓名或组号为空，请<a href=\"login.html\">重新登录</a>";

die();

}


$con = mysql_connect("localhost","root","901026","interest");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


$db_selected = mysql_select_db("interest", $con);
$sql = "SELECT * FROM `user` WHERE `Name` = '$name'";
$result = mysql_query($sql,$con);   //mysql_query返回类型如果执行不成功，则为布尔型
$counter = mysql_num_rows($result);
//var_dump($result);

if(!$counter){          //是否存在该用户
 mysql_query("INSERT INTO `user`(`Name`, `Group`, `Status`) VALUES ('$name',$group,FALSE)");//是否存在该用户
 $flag = 1;
}

else { 
	$flag1 = 0;//该用户是否做过该组,flag1=0代表没做过
	while($row = mysql_fetch_array($result)){
	if($row['Group'] == $group) 
		$flag1 = 1;
	}

    if($flag1) { //做过该组
		$var1 =  mysql_query("SELECT * FROM `user` WHERE `Name` = '$name' AND `Group` = $group");
		$var2 =  mysql_fetch_array($var1);
		if($var2['Status']){   //该组已经完成
          echo "该组已经完成，返回选择另一组，请<a href=\"login.html\">重新登录</a>";
          die();
		}
	    else{$flag = 1;}		//该组未完成
	}


	else{   //未做过该组
		$flag2 = 0; //已经做得组中是否有未完成的，flag2=0代表其他组都已经完成
		 mysql_data_seek($result,0);//指针复位！！！！非常重要！！！mysql_data_seek($result,$row_num)
	    while($row = mysql_fetch_array($result)){
	    if($row['Status'] == FALSE) 
		   {$flag2 = 1;
	       break;
		   }
	    }


        if($flag2) {
           echo "还有一组尚未完成，选择该未完成的组，请<a href=\"login.html\">重新登录</a>";
           die();
                 }
       else{
           mysql_query("INSERT INTO `user`(`Name`, `Group`, `Status`) VALUES  ('$name',$group,FALSE)");
           $flag = 1;
           }
	   }
}

mysql_close($con);

	if($flag)
	{
		//echo "flag: ".$flag.</br>;
		session_start();
       $_SESSION['name']= $name;
       $_SESSION['group']= $group;
         header('Location: /myvideo.html');	//直接跳转到myvideo.html页面
		 }


?>

