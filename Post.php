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
	if($resultxz -> num_rows != 0)
	{
		header("Location:epost.php");
	}
	

if (isset($_POST["submit"]))
{
	$v_name=$_FILES["poto"]["name"];
	$v_target="Images/".$v_name;
	move_uploaded_file($_FILES["poto"]["tmp_name"],$v_target);
	$po=$_POST["post1"];
	date_default_timezone_set('Asia/Kolkata');
	$dt=new DateTime();
	$date=$dt->format('y-m-d');
	
	
	$time=$dt->format('H:i:s');
	$query="insert into post (account_id,post,photo,time,date,edit_time) values ('$v','$po','$v_target','$time','$date','$time')";
	mysqli_query($con, $query) or die(mysqli_error($con));
	
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

<div style="width: 500px; height: 500px; background-color: white; margin-left: 35%; margin-top: 10%;">
<div id="sup">
Post
</div>

<div id="lf" style="margin-top: 10px; font-size: 5px; color: #1eb7f0; text-align: left;">
<form action="#" method="post" enctype="multipart/form-data">
<table style="width: 100%;">
<tr><td style="text-align: right;"><label>Upload a daily pic</label></td><td style="text-align: left; padding-left: 10px;"><input type="file" name="poto" id="poto"></td></tr>
<tr><td style="text-align: right;"><label>post</label></td><td style="text-align: left; padding-left: 10px;"><textarea name="post1" rows="10" cols="30"></textarea></td></tr>
<tr><td></td></tr>
<tr><td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="post" style="background-color: white; color: #1eb7f0; font-size: 30px; cursor: pointer;"></td></tr>
</table>
</form>

</div>
</div>
</div>

</body>


</html>