<?php

$video1 = $_REQUEST['video1'];
$relation = $_REQUEST['relation'];
$user_IP = isset($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];//这里加上isset非常重要！
$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];


//mysql_connect(sql_server,username,password,mysql库名)
$con = mysql_connect("localhost","root","901026","intereststar");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$db_selected = mysql_select_db("intereststar", $con);


if($video1) {
mysql_query("INSERT INTO 'relationship15'(User_ip,Video1, Relation) 
VALUES
('$user_IP','$video1','$relation')");
}
//mysql_close($con);

$sql = "SELECT * from relationship15 WHERE User_ip = '$user_IP'";
$result = mysql_query($sql,$con);
echo "typeaaaaaaaaaaaa";
var_dump($result);
$counter = mysql_num_rows($result);

//遍历所有127.0.0.1的行
if ($counter < 25) {
//$counter =+1;
$array = file("star15.txt");
$row = $array[$counter];
 $row = rtrim($row);
//$tmp = explode("@",$row);
  $video1 = $row;
 // $video2 = $tmp[1];

}

else echo('FINISHED');

mysql_close($con);



/*$var1 = rand(1,20);
do
{
$var2 = rand(1,20);
}
while ($var1==$var2);*/ 

//$video1 = "15medicine/$var1.mp4";//双引号可以使字符串中的$以变量形式处理
//$video2 = "15medicine/$var2.mp4";

//这是普通返回数据显示方式
//echo "video1: ".$video1." "."video2: ".$video2." "."relation: ".$relation;

$arr = array ('video1'=>$video1,'numb'=>$counter+1);
//var_dump($arr);这个函数会在php中显示变量值，但是使用会拦截下面echo的传递

echo json_encode($arr);  //返回json数据的格式


?>