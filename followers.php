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
$querylw = 'select following_user_id from follow where followed_user_id = '.$v.' order by date desc';
$resultlw = $con->query($querylw);

echo '<body link="#1eb7f0" vlink="#1eb7f0">';
echo '<div style="height:10%; width:100%; font-size:40px; font-weight:800; text-align:center;  font-family: Freestyle Script Regular;"><button style="background-color:#f07d15; color:white; font-size:30px; border:0;" onclick="goBack()">Go to Feeds</button></div>';
echo '<div style="height:500px; width:50%; font-size:25px; font_weight:800; text-align:center; background:#343641; color:white; overflow: scroll; margin: 0 25% 0 25%"><p style="background-color:#1eb7f0; font-size:30px;">followers</p>';
while ($rowlw = $resultlw->fetch_assoc())
{
	$queryu='select * from user where account_id ='.$rowlw["following_user_id"];
	$resultu = $con->query($queryu);
	while ($rowu = $resultu->fetch_assoc())
	{
		echo '<a href="user.php?aid='.$rowu["Account_id"].'" style="text-decoration:none;">';
		echo $rowu["User_id"].'<br>';
		echo '</a>';
	}
}
echo "</body>";
echo '</div>';
?>
<script>
function goBack() {
	 window.location="feeds.php";
}
</script>