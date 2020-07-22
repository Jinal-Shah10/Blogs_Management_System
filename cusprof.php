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
	
	
if (isset($_POST["up"]))
{
	$v_name=$_FILES["poto"]["name"];
	$v_target="Profile/".$v_name;
	move_uploaded_file($_FILES["poto"]["tmp_name"],$v_target);

	
	$query="update user set profile_pic = '$v_target' where account_id = '$v'";
	mysqli_query($con, $query) or die(mysqli_error($con));
	
	header("Location:feeds.php");

}
if (isset($_POST["us"]))
{
	$sts=$_POST["status"];
	$query="update user set status = '$sts' where account_id = '$v'";
	mysqli_query($con, $query) or die(mysqli_error($con));

	header("Location:feeds.php");

}
if (isset($_POST["blkbtn"]))
{
	$blku=$_POST["blktxt"];
	$queryxz = 'select account_id from user where user_id = "'.$blku.'"';
	$resultxz = $con->query($queryxz) or die("died");
	while ($rowxyz=$resultxz->fetch_assoc())
	{
		$t=$rowxyz["account_id"];
		echo $t;
		echo $v;
		$query="insert into block (block_by,blocked) values ('$v','$t')";
		mysqli_query($con, $query) or die(mysqli_error($con));
		$queryrm="delete from follow where following_user_id = '$t' and followed_user_id = '$v'";
		mysqli_query($con, $queryrm) or die(mysqli_error($con));
	}
	header("Location:feeds.php");

}
if (isset($_POST["blkbtn1"]))
{
	$blku1=$_POST["blktxt1"];
	$queryxz = 'select account_id from user where user_id = "'.$blku1.'"';
	$resultxz = $con->query($queryxz) or die("died");
	while ($rowxyz=$resultxz->fetch_assoc())
	{
		$t=$rowxyz["account_id"];
		$query="delete from block where block_by = '$v' and blocked = '$t'";
		mysqli_query($con, $query) or die(mysqli_error($con));
	}
	header("Location:feeds.php");

}
if (isset($_POST["blkbtn2"]))
{
	$blku2=$_POST["blktxt2"];
	$queryxz = 'select account_id from user where user_id = "'.$blku2.'"';
	$resultxz = $con->query($queryxz) or die("died");
	while ($rowxyz=$resultxz->fetch_assoc())
	{
		$t=$rowxyz["account_id"];
		$queryrm="delete from follow where following_user_id = '$v' and followed_user_id = '$t'";
		mysqli_query($con, $queryrm) or die(mysqli_error($con));
	}
	header("Location:feeds.php");

}
if (isset($_POST["au"]))
{

	$uid=$_POST["add"];
	$query7 ='select account_id from user where user_id ="'.$uid.'"';
	$result7 = $con->query($query7) or die("died");
	if($result7->num_rows!=0)
	{
		$query100 ='select * from block where block_by ="'.$uid.'" and blocked = '.$v;
		$result100 = $con->query($query100) or die("died");
		if($result100->num_rows > 0)
		{
			echo '<script type="text/javascript">';
			echo 'alert("invalid username")';
			echo '</script>';
		}
		else
		{
			while ($row7 = $result7->fetch_assoc())
			{
				$now=$row7["account_id"];
			}
			$queryau='insert into follow values ('.$v.','.$now.','.$date.')';
			mysqli_query($con, $queryau);
		}
	}
	else
	{
		echo '<script type="text/javascript">';
		echo 'alert("invalid username")';
		echo '</script>';

	}
	header("Location:feeds.php");
	

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

<div style="width: 34%; height: 500px; background-color: white; margin-left: 35%; margin: 10% 33% 0 33%;">
<div id="sup">
Edit your details
</div>

<div id="lf" style="margin-top: 10px; font-size: 5px; color: #1eb7f0; text-align: left;">
<form action="#" method="post" enctype="multipart/form-data">
<table style="width: 100%;">
<tr><td style="text-align: left; padding-left: 10px;"><input type="file" name="poto" id="poto"></td><td style="text-align: right;"><input type="submit" name="up" value="change profile pic"></td></tr>
<tr><td style="text-align: right;"><input type="submit" value="update status" name="us"></td><td style="text-align: left; padding-left: 10px;"><textarea maxlength="34" name="status" rows="10" cols="30"></textarea></td></tr>
<tr><td style="text-align: left; padding-left: 10px;"><input type="text" name="blktxt"  placeholder="username"></td><td style="text-align: right;"><input type="submit" value="block this user" name="blkbtn"></td></tr>
<tr><td style="text-align: left; padding-left: 10px;"><input type="text" name="blktxt1"  placeholder="username"></td><td style="text-align: right;"><input type="submit" value="unblock this user" name="blkbtn1"></td></tr>
<tr><td style="text-align: left; padding-left: 10px;"><input type="text" name="blktxt2"  placeholder="username"></td><td style="text-align: right;"><input type="submit" value="unfollow this user" name="blkbtn2"></td></tr>
<tr><td style="text-align: left; padding-left: 10px;"><input type="text" name="add"  placeholder="username"></td><td style="text-align: right;"><input type="submit" value="follow this user" name="au"></td></tr>

<tr><td></td></tr>
</table>
</form>

</div>
</div>
</div>

</body>


</html>