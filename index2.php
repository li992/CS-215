<!DOCTYPE html>
<html>
<head>
<title>Index page with SignUp and Login</title>
<link rel="stylesheet" type="text/css" href="BlogCSS.css"/>
<script type="text/javascript" src="index2.js"></script>
</head>

<?php
session_start();

//If nobody is logged in, display login and signup page.
if(isset($_SESSION["email"]))
{
?>
<body onload="refresh()" >
	<div class="HOMEframework">
		<article class="homeArticle" id="atk">
		</article>
		
		<header class="headSticky">
			<a href="index.php" style="postion:absolute;float:left; left:20px;">
				<input style="width:120px;height:30px;margin-top:9%;" type="button" value="Home" >
			</a>
			<a href="Logout.php" style="position:absolute; float:right; right:20px;">
				<input style="width:120px;height:30px;margin-top:9%;" type="button" value="Log-out">
			</a>

		</header>
		<aside class="asideSticky">
			<a href="profile.php" id="user">
				<img src="<?php echo "upload/".$_SESSION["uname"];?>" name="Husky" style="position:relative;margin-left:25%; margin-top:10px;width:120px;height:100px;">
			</a><br/>
			<a href="profile.php" style="margin-left:25%;"><?php echo $_SESSION["uname"];?></a>
			<hr />	
			<div style="width:100%;height:5%;">			
				<a href="newBlog.php" style="postion:relative;float:left; left:20px;">
					<input style="width:120px;height:30px;margin-top:9%;" type="button" value="Post a Blog">
				</a>
			</div>

			<div style="width:100%;height:5%;">			
				<a href="index.php" style="postion:relative;float:left; left:20px;">
					<input style="width:120px;height:30px;margin-top:9%;" type="button" value="Post a Photo">
				</a>
			</div>	
			
			<br/>	
			<hr/>
		</aside>
		<footer class="footerSticky">
		</footer>
	</div>
<?php 
}

else
{
	header("Location:Login.php");

}
?>
<script type = "text/javascript"  src = "index2-r.js" ></script>
</body>
</html>