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
	

if (isset($_POST["submit"]))
{
	$v_name=$_FILES["poto"]["name"];
	$v_target="Profile/".$v_name;
	move_uploaded_file($_FILES["poto"]["tmp_name"],$v_target);
	$sts=$_POST["status"];
	$date=$_POST["dat"];
	
	$query="update user set profile_pic = '$v_target', birthday = '$date', status = '$sts' where account_id = '$v'";
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
Fill up your details
</div>

<div id="lf" style="margin-top: 10px; font-size: 5px; color: #1eb7f0; text-align: left;">
<form action="#" method="post" enctype="multipart/form-data">
<table style="width: 100%;">
<tr><td style="text-align: right;"><label>select a profile pic</label></td><td style="text-align: left; padding-left: 10px;"><input type="file" name="poto" id="poto" required></td></tr>
<tr><td style="text-align: right;"><label>status(134 characters only)</label></td><td style="text-align: left; padding-left: 10px;"><textarea maxlength="134" name="status" rows="10" cols="30" required></textarea></td></tr>
<tr><td style="text-align: right;"><label>birthday</label></td><td style="text-align: left; padding-left: 10px;"><input type="date" name="dat" required></td></tr>
<tr><td></td></tr>
<tr><td colspan="2" style="text-align: center;"><input type="submit" name="submit" value="get started" style="background-color: white; color: #1eb7f0; font-size: 30px; cursor: pointer; required"></td></tr>
</table>
</form>

</div>
</div>
</div>

</body>


</html>