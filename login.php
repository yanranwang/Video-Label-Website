<?php

$name=$_POST['name'];

$group=$_POST['groupnum'];

$flag = 0;

if(!$name || !$group) {

echo "���������Ϊ�գ���<a href=\"login.html\">���µ�¼</a>";

die();

}


$con = mysql_connect("localhost","root","901026","interest");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


$db_selected = mysql_select_db("interest", $con);
$sql = "SELECT * FROM `user` WHERE `Name` = '$name'";
$result = mysql_query($sql,$con);   //mysql_query�����������ִ�в��ɹ�����Ϊ������
$counter = mysql_num_rows($result);
//var_dump($result);

if(!$counter){          //�Ƿ���ڸ��û�
 mysql_query("INSERT INTO `user`(`Name`, `Group`, `Status`) VALUES ('$name',$group,FALSE)");//�Ƿ���ڸ��û�
 $flag = 1;
}

else { 
	$flag1 = 0;//���û��Ƿ���������,flag1=0����û����
	while($row = mysql_fetch_array($result)){
	if($row['Group'] == $group) 
		$flag1 = 1;
	}

    if($flag1) { //��������
		$var1 =  mysql_query("SELECT * FROM `user` WHERE `Name` = '$name' AND `Group` = $group");
		$var2 =  mysql_fetch_array($var1);
		if($var2['Status']){   //�����Ѿ����
          echo "�����Ѿ���ɣ�����ѡ����һ�飬��<a href=\"login.html\">���µ�¼</a>";
          die();
		}
	    else{$flag = 1;}		//����δ���
	}


	else{   //δ��������
		$flag2 = 0; //�Ѿ����������Ƿ���δ��ɵģ�flag2=0���������鶼�Ѿ����
		 mysql_data_seek($result,0);//ָ�븴λ���������ǳ���Ҫ������mysql_data_seek($result,$row_num)
	    while($row = mysql_fetch_array($result)){
	    if($row['Status'] == FALSE) 
		   {$flag2 = 1;
	       break;
		   }
	    }


        if($flag2) {
           echo "����һ����δ��ɣ�ѡ���δ��ɵ��飬��<a href=\"login.html\">���µ�¼</a>";
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
         header('Location: /myvideo.html');	//ֱ����ת��myvideo.htmlҳ��
		 }


?>

