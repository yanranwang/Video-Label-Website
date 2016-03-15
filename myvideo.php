<?php
session_start();
$name = $_SESSION['name'];
$group = $_SESSION['group'];

$video1 = $_REQUEST['video1'];
$video2 = $_REQUEST['video2'];
$relation = $_REQUEST['relation'];
//$user_IP = isset($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];//这里加上isset非常重要！
//$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];

//mysql_connect(sql_server,username,password,mysql库名)
$con = mysql_connect("localhost","root","901026","interest");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db_selected = mysql_select_db("interest", $con);


if($video1&&$video2) {
preg_match_all("/[1-9][0-9]?/",$video1,$str1);
preg_match_all("/[1-9][0-9]?/",$video2,$str2);
$stra=(int)$str1[0][1];
$strb=(int)$str2[0][1];
mysql_query("INSERT INTO `relationship`(`name`, `group`, `Video1`, `Video2`, `Relation`) VALUES ('$name',$group,$stra,$strb,$relation)");

}
//mysql_close($con);


$sql = "SELECT * from `relationship` WHERE `name` = '$name' AND `group` = $group";
$result = mysql_query($sql,$con);
$counter = 0;
while($row = mysql_fetch_array($result))
{
    $db_array[$counter][1] = $row['Video1'];
    $db_array[$counter][2] = $row['Video2'];
    $db_array[$counter][0] = $row['Relation'];
    $counter = $counter + 1;
	//print_r($row);echo "</br>";
}

function merge(&$arr,$left,$mid,$right)
{  
	global $db_array;
	global $counter;
	global $group;
    $result=array();

	$tmp=0;
	$i;$j;
	for($i=$left,$j=$mid+1;$i<=$mid&&$j<=$right;)
	{     $num = 0;$flag=0;
          while($num<$counter)
		  {
			  if(($db_array[$num][1]==$arr[$i]&&$db_array[$num][2]==$arr[$j])||($db_array[$num][1]==$arr[$j]&&$db_array[$num][2]==$arr[$i]))
			  {$flag=1;break;}
			  	 $num++;
		  }

          if($flag){

		        if($db_array[$num][0]!=2)//i<=j
			          $result[$tmp++]=$arr[$i++];
		        else
		             {
			          $result[$tmp++]=$arr[$j++];
		             }
		           }
	             
          else {
		  
		       $response = array ('video1'=>"$group/$arr[$i].mp4",'video2'=>"$group/$arr[$j].mp4",'status'=>0);
               echo json_encode($response);  //返回json数据的格式
		       die();
		       }

		  
      }
               
                while($i<=$mid)
		        $result[$tmp++]=$arr[$i++];
	           while($j<=$right)
		        $result[$tmp++]=$arr[$j++];
	           for($i=0;$i<$tmp;$i++)
		        $arr[$left+$i]=$result[$i];
	             

}


function mergesort(&$arr,$left,$right)//&$arr表示的是call by reference
{
		global $db_array;

	if($left<$right)
	{
		$t=(int)(($left+$right)/2);  
		mergesort($arr,$left,$t);
		mergesort($arr,$t+1,$right);
		merge($arr,$left,$t,$right);
	}

}
$arr=array(0=>1,1=>2,2=>3,3=>4,4=>5,5=>6,6=>7,7=>8,8=>9,9=>10,10=>11,11=>12,12=>13,13=>14,14=>15,15=>16,16=>17,17=>18,18=>19,19=>20,20=>21,21=>22,22=>23,23=>24,24=>25,25=>26,26=>27,27=>28,28=>29,29=>30);

mergesort($arr,0,29);
mysql_query("UPDATE `user` SET `Status`=TRUE WHERE `Name`='$name' AND `Group`=$group");
mysql_close($con);
$arr=implode("\n", $arr);     //为了写入文件时区分数组之间的元素。
file_put_contents("$name.@.$group.txt",$arr);     
$response = array ('video1'=>"",'video2'=>"",'status'=>1);
          echo json_encode($response); 
		       die();
      




//header('Location: /login.html');	//直接跳转到myvideo.html页面





?>