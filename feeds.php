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

$query1 ="select Followed_User_id from follow where Following_User_id = '$v'";
$result1 = $con->query($query1);

$c=$result1->num_rows;
$c1=0;
if($c==0){
	$a="(".$v.")";}
else{
	$a="(".$v.",";
}
if($result1->num_rows > 0)
{	
	
	while ($row1 = $result1->fetch_assoc())
	{
		if($c1==$c-1){
		$a=$a.$row1["Followed_User_id"].')';}
		else{
		$a=$a.$row1["Followed_User_id"].',';}
		$c1++;
	}
}
//$result1 = (string)$result1;
$query = 'select photo,post,account_id,post_id from post where Account_id in '.$a.' and date = '.$date.' order by date desc, edit_time desc';
$result = $con->query($query) or die("died");

$querylchk='select post_id from post where Account_id in '.$a;
$resultlchk=$con->query($querylchk) or die("like died");
/*if (isset($_POST["la"]))
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

}*/
while ($rowlchk = $resultlchk->fetch_assoc())
{
	if(isset($_POST[$rowlchk["post_id"]]))
	{
		$quer='select * from likes where post_id ='.$rowlchk["post_id"].' and account_id = '.$v;
		$resul=$con->query($quer) or die("like died");
		$pl=$rowlchk["post_id"];
		$al=$v;
		if($resul->num_rows==0)
		{
			$querylar='insert into likes (post_id,account_id) values ('.$pl.','.$al.')';
			mysqli_query($con, $querylar)or die(mysqli_error($con));
		}
		else 
		{
			while($ro = $resul->fetch_assoc())
			{
				$querylar='delete from likes where like_id = '.$ro["Like_id"];
				mysqli_query($con, $querylar)or die(mysqli_error($con));
			}
		}
	}
}

if (isset($_POST["so"]))
{
	session_destroy();
	header("Location:signup.php");
	
}
if(isset($_POST["ap"]))
{
	$queryxz = 'select photo,post,post_id from post where date = '.$date.' and account_id = '.$v;
	$resultxz = $con->query($queryxz) or die("died");
	if($resultxz -> num_rows == 0)
	{
		header("Location:Post.php");
	}
	else 
	{
		header("Location:epost.php");
	}
}
?>



<link href="burger.css" rel="stylesheet">
<link href="main.css" rel="stylesheet">



</head>
<body>
<div style="margin-top: 0px; height: 58px; width: 100%; background-color: #343641; text-align:center; position: relative; z-index: -3; font-family: Freestyle Script Regular; font-size: 50px; color: #1eb7f0; font-weight:900;">dlogs...</div>
<div id="burger-holder" onclick="ReverseHamburgerMenuDisplay()">


        <button class="c-hamburger c-hamburger--htla" style=" z-index: 0; position: absolute;">
          <span>toggle menu</span>
        </button>

</div>
<div id="burger-menu" style="display:none;">

<?php 
$query5 = 'select user_id,profile_pic from user where Account_id = '.$v;
$result5 = $con->query($query5) or die("died");
if($result5->num_rows > 0)
{
while ($row5 = $result5->fetch_assoc())
{
	echo '<img src="'.$row5["profile_pic"].'" height="30%" width="100%" style="">';
	echo '<a href="user.php?aid='.$v.'">';
	echo '<div id="button2">'.$row5["user_id"].'</div></a>';
}
}
?>
<br>
<form action="" method="post">
<input type="submit"  id="button2" name="ap" value="post" >
<br>
<br>

<div id="button2"><a href="cusprof.php">Customize Profile</a></div>
<br>
<br>
<input type="submit" name="so" value="sign out" id="button2" style="margin-top:40%; border:0px;"> 
</form>




</div>

<div id="main">
<span><br>
<br><br><br></span>
<?php 
if($result->num_rows > 0)
{
	while ($row = $result->fetch_assoc())
	{
		$query3 ='select User_id,account_id from user where Account_id ='.$row["account_id"];
		$result3 = $con->query($query3);
		$queryc ='select count(post_id) as abc from comment where post_id ='.$row["post_id"];
		$resultc = $con->query($queryc);
		$queryl ='select count(post_id) as abc from likes where post_id ='.$row["post_id"];
		$resultl = $con->query($queryl);
		$querylb ='select * from likes where post_id ='.$row["post_id"].' and account_id = '.$v;
		$resultlb = $con->query($querylb) or die("died");
		
	echo '<div class="style_prevu_kit1" style="width: 350px; height: 550px; margin: 150px 0px 0px 100px; float: left; cursor:pointer; ">';
	echo '<div style="height:10%; width:100%; text-align:center; float:left; font-size:40px; font-weight:800;  font-family: Freestyle Script Regular; color: white;" >';
		while ($row3 = $result3->fetch_assoc())
		{
			echo '<a href="user.php?aid='.$row3["account_id"].'">';
			echo $row3["User_id"];
			echo "</a>";
		}
	echo'</div>';
	echo '<a href="par_post.php?aid='.$row["account_id"].'&poid='.$row["post_id"].'">';
	echo '<img src="'.$row["photo"].'" style="width:100%; margin:0px; height:48%; float:left;">';		
	echo '<div style="width:100%; height:20%; overflow:auto; color:#000000; background:#ffffff; font-size:22px; float:left;">'.$row["post"].'</div>';
		while ($rowc = $resultc->fetch_assoc())
		{
			echo '<div style="width:100%; background-color: #343641; height: 6%; color: #1eb7f0; font-size:20px; font-family:verdana; text-align:center; float:left;">comments : '.$rowc["abc"].'</div>';
		}
		while ($rowl = $resultl->fetch_assoc())
		{
			echo '<div style="width:100%; background-color: #343641; height: 6%; color: #1eb7f0; font-size:20px; font-family:verdana; text-align:center; padding-bottom: 5px; float:left;">likes : '.$rowl["abc"].'</div>';
		}
		echo '</a>';
		$fu=$resultlb->num_rows;
		echo '<form method="post" action="feeds.php">';
		if($resultlb->num_rows!=0)
		{
			while ($rowlb = $resultlb->fetch_assoc())
			{
				echo '<input type="submit" name="'.$rowlb["Post_id"].'" style="width:100%; height:10%; background-color:#f07d15; float:left; border:0px; color:white; font-weight:800; font-size:30px;" value="liked" >';
			}
		}
		else
		{
				echo '<input type="submit" name="'.$row["post_id"].'" style="width:100%; height:10%; background-color:white; float:left; border:0px; color:#f07d15; font-weight:800; font-size:30px;" value="like" >';
		
		}
		echo '</form>';
	echo '</div>';
	}
}
?>

<span style="float: right; margin-top:800px;"> <br><br><br>
<br><br><br><br></span>

</div>

<script type="text/javascript">
document.getElementById("burger-menu").style.display="none";
function ReverseHamburgerMenuDisplay()
{
   var id = document.getElementById("burger-menu");
   var ids = document.getElementById("main");
   if( id.style.display == "none" ) { id.style.display = "block";ids.style.width="76%";  ids.style.margin ="0% 0% 0% 24%"; }
   else { id.style.display = "none"; ids.style.width="100%"; ids.style.margin ="0%"}
}
function HamburgerMenuItemOver(id) { id.style.backgroundColor = "#535766"; }
function HamburgerMenuItemOut(id) { id.style.backgroundColor = "#535766"; }


</script>
      
      
<script>
  (function() {

    "use strict";

    var toggles = document.querySelectorAll(".c-hamburger");

    for (var i = toggles.length - 1; i >= 0; i--) {
      var toggle = toggles[i];
      toggleHandler(toggle);
    };

    function toggleHandler(toggle) {
      toggle.addEventListener( "click", function(e) {
        e.preventDefault();
        (this.classList.contains("is-active") === true) ? this.classList.remove("is-active") : this.classList.add("is-active");
      });
    }

  })();
</script>

</body>
</html>