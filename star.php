<?php

$video1 = $_REQUEST['video1'];
$relation = $_REQUEST['relation'];
$user_IP = isset($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];//�������isset�ǳ���Ҫ��
$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];


//mysql_connect(sql_server,username,password,mysql����)
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

//��������127.0.0.1����
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

//$video1 = "15medicine/$var1.mp4";//˫���ſ���ʹ�ַ����е�$�Ա�����ʽ����
//$video2 = "15medicine/$var2.mp4";

//������ͨ����������ʾ��ʽ
//echo "video1: ".$video1." "."video2: ".$video2." "."relation: ".$relation;

$arr = array ('video1'=>$video1,'numb'=>$counter+1);
//var_dump($arr);�����������php����ʾ����ֵ������ʹ�û���������echo�Ĵ���

echo json_encode($arr);  //����json���ݵĸ�ʽ


?>