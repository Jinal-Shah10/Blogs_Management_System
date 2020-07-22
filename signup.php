<html>
<head>
<?php
include 'connection.php';
?>
<?php 
	if (isset($_POST["ssubmit"]))
	{	
		$nm=$_POST["nmtxt"];
		$ps=$_POST["pass"];
		$em=$_POST["email"];
		$us=$_POST["us"];
		$query="insert into user (name,password,email,user_id) values ('$nm','$ps','$em','$us')";
		mysqli_query($con, $query)or die(mysqli_error($con));
		session_start();
		$query1='select Account_id from user where email="'.$em.'"';
		$result1 = $con->query($query1) or die("dies");
		if($result1->num_rows > 0)
		{
			while ($row1 = $result1->fetch_assoc())
			{				
				$_SESSION["User"] = $row1["Account_id"];
			}
		}
		header("Location:firstlogin.php");
		
	}
	if (isset($_POST["lsubmit"]))
	{
		$ps=$_POST["pass"];
		$us=$_POST["us"];
		$query="select * from user where user_id='$us' and password='$ps'";
		$res=$con->query($query);
		session_start();
		if($res->num_rows != 0)
		{
			$query1='select Account_id from user where user_id="'.$us.'"';
			$result1 = $con->query($query1) or die("dies");
			if($result1->num_rows > 0)
			{
				while ($row1 = $result1->fetch_assoc())
				{	
					$_SESSION["User"] = $row1["Account_id"];	
				}
			}
			header("Location:feeds.php");
		}
		else
		{
			echo '<script>alert("invalid login details")</script>';
		}
	}
?>
<style type="text/css">
#sup{
	width: 50%;
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
<script type="text/javascript">
	function lin() {
		var log = document.getElementById("lf");
		var lin = document.getElementById("lin");
		var sup = document.getElementById("sup");
		var sig = document.getElementById("sf");
		if(log.style.display=="none")
		{
			lin.style.background="#ffffff";
			lin.style.color="#1eb7f0";
			sup.style.color="#ffffff";
			sup.style.background="#1eb7f0";
			log.style.display="block";
			sig.style.display="none";
		}

		
		
		
	}
	function sup() {
		var log = document.getElementById("lf");
		var lin = document.getElementById("lin");
		var sup = document.getElementById("sup");
		var sig = document.getElementById("sf");
		if(sig.style.display=="none")
		{
			sup.style.background="#ffffff";
			sup.style.color="#1eb7f0";
			lin.style.color="#ffffff";
			lin.style.background="#1eb7f0";
			sig.style.display="block";
			log.style.display="none";
		}
		
		
		
	}
</script>
<script type="text/javascript">

function checkEmail() {

    var email = document.getElementById('txtEmail');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
    alert('Please provide a valid email address');
    email.focus;
    return false;
 }
</script>
</head>
<body>

<div id="main" style="text-align: center;">

<div style="width: 500px; height: 500px; background-color: white; margin-left: 35%; margin-top: 10%;">

<div id="lin" onclick="lin()">
login
</div>

<div id="sup" onclick="sup()">
Sign up
</div>

<div id="lf" style="margin-top: 10px; font-size: 5px; color: #1eb7f0; display: none; text-align: left;">
<form action="#" method="post">
<table style="width: 100%;">
<tr><td style="text-align: right;"><label>User Name</label></td><td style="text-align: left; padding-left: 10px;"><input type="text" name="us"></td></tr>
<tr><td style="text-align: right;"><label>Password</label></td><td style="text-align: left; padding-left: 10px;"><input type="password" name="pass"></td></tr>
<tr><td colspan="2" style="text-align: center;"><input type="submit" name="lsubmit" value="login" style="background-color: white; color: #1eb7f0; font-size: 30px; cursor: pointer;"></td></tr>
</table>
</form>

</div>

<div id="sf" style="margin-top: 60px; font-size: 5px; color: #1eb7f0; text-align: left;">
<form action="#" method="post">
<table style="width: 100%;">
<tr><td style="text-align: right;"><label>Email</label></td><td style="text-align: left; padding-left: 10px;"><input id="txtEmail" type="email" name="email" onblur="Javascript:checkEmail();"></td></tr>
<tr><td style="text-align: right;"><label>Name</label></td><td style="text-align: left; padding-left: 10px;"><input type="text" name="nmtxt"></td></tr>
<tr><td style="text-align: right;"><label>User Name</label></td><td style="text-align: left; padding-left: 10px;"><input type="text" name="us"></td></tr>
<tr><td style="text-align: right;"><label>Password</label></td><td style="text-align: left; padding-left: 10px;"><input type="password" name="pass"></td></tr>
<tr><td colspan="2" style="text-align: center;"><input type="submit" name="ssubmit" value="signup" style="background-color: white; color: #1eb7f0; font-size: 30px; cursor: pointer;"></td></tr>
</table>
</form>
</div>

</div>

</div>

<script type="text/javascript">
document.getElementById("burger-menu").style.display="none";
function ReverseHamburgerMenuDisplay()
{
   var id = document.getElementById("burger-menu");
   var ids = document.getElementById("main");
   var idb = document.getElementById("bar");
   if( id.style.display == "none" ) { id.style.display = "block";ids.style.width="76%";  ids.style.margin ="0% 0% 0% 24%"; }
   else { id.style.display = "none"; ids.style.width="100%"; ids.style.margin ="0%";}
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
<script type="text/javascript">

function checkEmail() {

    var email = document.getElementById('txtEmail');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email.value)) {
    alert('Please provide a valid email address');
    email.focus;
    return false;
 }
</script>

</body>
</html>