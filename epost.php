<html>
<head>
<?php 
session_start();
if(!isset($_SESSION["User"]))
{
	header("Location:signup.php");
}

?>
<?php
	include 'connection.php';
	$v=$_SESSION["User"];
	date_default_timezone_set('Asia/Kolkata');
	$dt=new DateTime();
	$date=$dt->format('y-m-d');
	$date="'".$date."'";
	$queryxz = 'select photo,post,post_id from post where date = '.$date.' and account_id = '.$v;
	$resultxz = $con->query($queryxz) or die("died");
	if($resultxz -> num_rows == 0)
	{
		header("Location:Post.php");
	}
?>
<?php

$c = $_SESSION["User"];
if (isset($_POST["submit"]))
{
	
	$po=$_POST["post1"];
	date_default_timezone_set('Asia/Kolkata');
	$dt=new DateTime();
	$date=$dt->format('y-m-d');
	$pid=$_SESSION["poid"];
	$time=$dt->format('H:i:s');
	$query="update post set post = '$po', edit_time = '$time' where post_id= '$pid'";
	mysqli_query($con, $query) or die(mysqli_error($con));
	unset($_SESSION["poid"]);
	
	header("Location:feeds.php");

}
if(isset($_POST["upic"]))
{
	$v_name=$_FILES["poto"]["name"];
	$v_target="Images/".$v_name;
	move_uploaded_file($_FILES["poto"]["tmp_name"],$v_target);
	$pid=$_SESSION["poid"];
	date_default_timezone_set('Asia/Kolkata');
	$dt=new DateTime();
	$date=$dt->format('y-m-d');
	$time=$dt->format('H:i:s');
	$query="update post set photo = '$v_target', edit_time = '$time' where post_id= '$pid'";
	mysqli_query($con, $query) or die(mysqli_error($con));
}


?>
<style type="text/css">
#sup{
	width: 100%;
	height: 15%;
	text-align: center;
	background-color: #FFFFFF;
	color: white;
	font-size: 50px;
 	font-family: Freestyle Script Regular;
 	border-bottom: 10px #1eb7f0 solid;
	margin-top: -17%;
	color: #1eb7f0;
	cursor: pointer; 
}

#lin{
	width: 50%;
	height: 15%;
	text-align: center;
	background-color: #1eb7f0;
	color: white;
	font-size: 50px;
	font-family: Freestyle Script Regular;
	border-bottom: 10px #1eb7f0 solid;
	float: right;
	cursor: pointer;
	
}
input{
	border: 2px #1eb7f0 solid;
	border-radius: 5px;
	height: 40px;
	margin-down: 40px;
	width: 300px;
	
}
td{
	width: 50%;
	font-size: 25px; color: #1eb7f0;
}
</style>
<link href="burger.css" rel="stylesheet">
<link href="main.css" rel="stylesheet">
</head>

<body>

<div id="main" style="text-align: center;">

<div style="width: 700px; height: 740px; background-color: white; margin-left: 35%; margin-top: 10%;">
<div id="sup">
edit your daily post
</div>

<div id="lf" style="margin-top: 10px; font-size: 5px; color: #1eb7f0; text-align: left;">
<form action="#" method="post" enctype="multipart/form-data">
<table style="width: 100%;">
<?php 
date_default_timezone_set('Asia/Kolkata');
$dt=new DateTime();
$date=$dt->format('y-m-d');
$date="'".$date."'";
$query = 'select photo,post,post_id from post where date = '.$date.' and account_id = '.$c;
$result = $con->query($query) or die("died");
while ($row = $result->fetch_assoc())
{
	echo '<tr><td style="text-align: center;" colspan="2"><img src="'.$row["photo"].'" style="width:90%; margin:0 5% 0 5%; height:300px; float:left;"></td></tr>';
	echo '<tr><td style="text-align: right;"><input type="submit" name="upic" value="Upload a daily pic"></td><td style="text-align: left; padding-left: 10px;"><input type="file" name="poto" id="poto"></td></tr>';
	
	echo '<tr><td style="text-align: center;" colspan="2">edit your post</td></tr>';
	echo '<tr><td style="text-align: center; padding-left: 10px;" colspan="2"><textarea name="post1" rows="10" cols="30" >'.$row["post"].'</textarea></td></tr>';
	echo '<tr><td></td></tr>';
	echo '<tr><td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="post" style="background-color: white; color: #1eb7f0; font-size: 30px; cursor: pointer;"></td></tr>';
	$_SESSION["poid"]=$row["post_id"];
}
?>
</table>
</form>

</div>
</div>
</div>

</body>


</html>
