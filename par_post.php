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
$pid=$_GET["poid"];
$accid=$_GET["aid"];

$query = 'select photo,post,account_id,post_id from post where post_id = '.$pid.' order by date desc, time desc';
$result = $con->query($query) or die("died");
$querylw = 'select account_id from likes where Post_id = '.$pid;
$resultlw = $con->query($querylw);

if(isset($_POST["sot"]))
{
	$c=$_POST["com"];
	$quer="insert into comment (Account_id,Post_id,comment) values ('$v','$pid','$c')";
	mysqli_query($con, $quer)or die(mysqli_error($con));
	
}
if (isset($_POST["la"]))
{
	$pl=$_SESSION["pid"];
	$al=$_SESSION["aid"];
	$querylar='insert into likes (post_id,account_id) values ('.$pl.','.$al.')';
	mysqli_query($con, $querylar)or die(mysqli_error($con));
	unset($_SESSION["pid"]);
	unset($_SESSION["aid"]);
}
if (isset($_POST["lr"]))
{

	$pl=$_SESSION["lid"];
	$querylar='delete from likes where like_id = '.$pl;
	mysqli_query($con, $querylar)or die(mysqli_error($con));
	unset($_SESSION["lid"]);

}
if (isset($_POST["au"]))
{

	$uid=$_POST["add"];
	$query7 ='select account_id from user where user_id ="'.$uid.'"';
	$result7 = $con->query($query7) or die("died");
	if($result7->num_rows!=0)
	{
		while ($row7 = $result7->fetch_assoc())
		{
			$now=$row7["account_id"];
		}
		$queryau='insert into follow values ('.$now.','.$v.')';
		mysqli_query($con, $queryau)or die(mysqli_error($con));
	}
	else
	{
		echo '<script type="text/javascript">';
		echo 'alert("invalid usernam")';
		echo '</script>';

	}

}
if (isset($_POST["so"]))
{
	session_destroy();
	header("Location:signup.php");

}
?>
<html>
<head>
<link href="burger.css" rel="stylesheet">
<link href="main.css" rel="stylesheet">
<style>

input{

	border: 2px #1eb7f0 solid;
	border-radius: 5px;
	height: 40px;
	margin-down: 40px;
	width: 300px;
	
}

</style>
</head>
<body>

<div id="main">
<?php 
if($result->num_rows > 0)
{
	while ($row = $result->fetch_assoc())
	{
		$query3 ='select User_id from user where Account_id ='.$row["account_id"];
		$result3 = $con->query($query3);
		$queryc ='select count(post_id) as abc from comment where post_id ='.$row["post_id"];
		$resultc = $con->query($queryc);
		$queryl ='select count(post_id) as abc from likes where post_id ='.$row["post_id"];
		$resultl = $con->query($queryl);
		$queryco ='select * from comment where post_id ='.$row["post_id"];
		$resultco = $con->query($queryco);
		$querylb ='select * from likes where post_id ='.$row["post_id"].' and account_id = '.$v;
		$resultlb = $con->query($querylb) or die("died");
		echo '<div style="height:10%; width:100%; font-size:40px; font-weight:800; text-align:center;  font-family: Freestyle Script Regular;"><button style="background-color:#f07d15; color:white; font-size:30px; border:0;" onclick="goBack()">Go to Feeds</button></div>';
		while ($row3 = $result3->fetch_assoc())
		{
			echo '<div style="height:10%; width:100%; font-size:40px; font-weight:800; text-align:center;  font-family: Freestyle Script Regular;">'.$row3["User_id"].'</div>';
		}
		echo '<img src="'.$row["photo"].'" style="width:50%; margin:0 25% 0 25%; height:500px;">';
		echo '<div style="width:50%; height:auto; overflow:auto; color:#000000; background:#ffffff; font-size:22px; margin: 0 25% 0 25%">'.$row["post"].'</div>';
		
		echo '<div style="height:auto; width:50%; font-size:25px; font_weight:800; text-align:center; background:#343641; margin:0 25% 0 25%;"><p style="color:#1eb7f0; font-size:30px; font-weight:800;">Thoghts shared</p>';
		$color="white";
		$bcolor="black";
		while($rowco =  $resultco->fetch_assoc())
		{
			$querycu='select user_id from user where account_id ='.$rowco["Account_id"];
			$resultcu = $con->query($querycu);
			while ($rowcu = $resultcu->fetch_assoc())
			{
				
				echo '<div style="color:#f07d15; width:100%; text-align:left; background:'.$color.'">'.$rowcu["user_id"].'</div>';
				
			}
			echo '<div style="color:'.$bcolor.';width:100%; text-align:left; background:'.$color.'">'.$rowco["Comment"].'</div>';
			if($color=="white")
			{
				$color="#343641";
				$bcolor="white";
			}
			else
			{
				$color="white";
				$bcolor="black";
			}
		}
		echo '</div>';
		echo '<form action="#" method="post">
<input type="text" name="com" style="background-color: white; height: 30px; width:50%; margin: 10px 25% 0 25%; float:left;" placeholder="Share your thought here">
<input type="submit" name="sot" value="share" style="background-color: white; height: 30px; width:30%; margin: 10px 35% 0 35%; float:left;">

</form>';
		
		
		$queryl ='select count(post_id) as abc from likes where post_id ='.$row["post_id"];
		$resultl = $con->query($queryl);
		
		echo '<form method="post" action="#">';
		if($resultlb->num_rows!=0)
		{
			while ($rowlb = $resultlb->fetch_assoc())
			{
				echo '<input type="submit" name="lr" style="width:20%; height:50px; background-color:#f07d15; float:left; border:0px; color:white; font-weight:800; font-size:30px; margin: 10px 40% 0 40%;" value="liked" ><br>';
				$_SESSION["lid"]=$rowlb["Like_id"];
				$_SESSION["aid"]=$rowlb["Account_id"];
				$_SESSION["pid"]=$rowlb["Post_id"];
			}
		}
		else
		{
			$_SESSION["aid"]=$v;
			$_SESSION["pid"]=$row["post_id"];
			echo '<input type="submit" name="la" style="width:20%; height:50px; background-color:white; float:left; border:0px; color:#f07d15; font-weight:800; font-size:30px; margin: 10px 40% 0 40%;" value="like" ><br>';
		
		}
		echo '</form>';
		while ($rowl = $resultl->fetch_assoc())
		{
			echo '<a href="like.php?aid='.$row["account_id"].'&poid='.$row["post_id"].'"><div style="width:100%; background-color: #343641; height: 6%; color: #1eb7f0; font-size:20px; font-family:verdana; text-align:center; padding-bottom: 5px; float:left; margin-top:10px;">likes : '.$rowl["abc"].'</div></a>';
		}
		/*echo '<div style="height:500px; width:50%; font-size:25px; font_weight:800; text-align:center; background:#343641; color:white; overflow: scroll; margin: 0 25% 0 25%"><p style="background-color:#1eb7f0; font-size:30px;">liked by</p>';
		while ($rowlw = $resultlw->fetch_assoc())
		{
			$queryu='select * from user where account_id ='.$rowlw["account_id"];
			$resultu = $con->query($queryu);
			while ($rowu = $resultu->fetch_assoc())
			{	
				echo '<a href="user.php?aid='.$rowu["Account_id"].'">';
				echo '<br>'.$rowu["User_id"];
				echo '</a>';
			}
		}
		echo '</div>';*/
		
		
	}
}

?>

</div>
</body>
<script>
function goBack() {
	 window.location="feeds.php";
}
</script>
</html>