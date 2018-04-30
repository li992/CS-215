<!DOCTYPE html>
<html>
<head>
<title>Index page with SignUp and Login</title>
<link rel="stylesheet" type="text/css" href="BlogCSS.css"/>
<script type="text/javascript" src="homepage.js"></script>
<script>

// Autofresh Ajax code 
function refresh(){
	xmlHttp = new XMLHttpRequest();
	xmlHttp.open("GET","profile.php",true);
	xmlHttp.onreadystatechange = function(){
		if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		    setTimeout("refresh()",5000);
		}
	}
	xmlHttp.send();
}

function blogLike(blogID){
	var blogLikeRequest = new XMLHttpRequest();
	var error=blogID+"B1";
	blogLikeRequest.onreadystatechange = function() {
        if (blogLikeRequest.readyState == 4 && blogLikeRequest.status == 200) {
           	var results = blogLikeRequest.responseText;
           	if(results==0){
				document.getElementById(error).innerHTML="You have left your feeling already";
               	}	           
        }
	}
    blogLikeRequest.open("POST", "like.php", true);
    blogLikeRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    blogLikeRequest.send("blogID="+ blogID);
}

function repostLike(repostID){
	var repostLikeRequest = new XMLHttpRequest();
	var error=repostID+"R1";
	repostLikeRequest.onreadystatechange = function() {
        if (repostLikeRequest.readyState == 4 && repostLikeRequest.status == 200) {
           	var results = repostLikeRequest.responseText; 
           	if(results==0){
				document.getElementById(error).innerHTML="You have left your feeling already";
               	}	  		            
        }
	}
    repostLikeRequest.open("POST", "like.php", true);
    repostLikeRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    repostLikeRequest.send("repostID="+ repostID);
}

function blogDislike(blogID){
	var xmlhttp = new XMLHttpRequest();
	var error=blogID+"B2";
	xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
           	var results = xmlhttp.responseText;   	
           	if(results==0){
				document.getElementById(error).innerHTML="You have left your feeling already";
               	}	 	            
        }
	}
    xmlhttp.open("POST", "dislike.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("blogID="+ blogID);
}

function repostDislike(repostID){
	var xmlhttp = new XMLHttpRequest();
	var error=repostID+"R2";
	xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
           	var results = xmlhttp.responseText;  
           	if(results==0){
				document.getElementById(error).innerHTML="You have left your feeling already";
               	}	 		            
        }
	}
    xmlhttp.open("POST", "dislike.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("repostID="+ repostID);
}

</script>
</head>
<body onload="refresh()" id="Body">

<?php
session_start();

//If nobody is logged in, display login and signup page.
if(isset($_SESSION["email"]))
{
	//If somebody is logged in, display a welcome message
	echo "Welcome, " .$_SESSION["uname"]. "<br />" ;

	$email=$_SESSION["email"];
	$db = new mysqli("localhost", "li992", "961209", "li992");
	if ($db->connect_error)
		{
			die ("Connection failed: " . $db->connect_error);
		}
	$q="SELECT * FROM USER where email = '$email'";
	$r = $db->query($q);
	$row = $r->fetch_assoc();

	$username=$row["username"];
	$DOB=$row["DOB"];
	$userID=$row["user_id"];
?>
	<div class="Profileframework">
		<article class="profileArticle">
			<div style="height:450px;">
				<img src="<?php echo "upload/".$username;?>" name="garfield" style="position:relative;margin-left:23%; margin-top:10px; width:394px; height:300px; ">
				<br/>
				<hr />
				<form>
				<table>
				<tr><td>Username:</td><td><?php echo $username; ?></td></tr>
				<tr></tr>
				<tr><td>Email:</td><td><?php echo $email; ?></td></tr>
				<tr></tr>
				<tr><td>Date of Birth: </td><td><?php echo $DOB; ?></td></tr>				
				</table>
				</form>
			</div>
			<hr />
			<?php	
			$conn = mysqli_connect("localhost","li992","961209","li992");
			
			echo "<p>Past Posts are showing Below:</p><br/>";
			$counterp=0;
			$q2="SELECT * FROM POST ORDER BY DateAndTime DESC";
			$result= mysqli_query($conn,$q2);
			if(mysqli_num_rows($result)>0){
				while(($row2 = mysqli_fetch_assoc($result))&&($counterp<20)){
					$post_user=$row2["Post_User"];
					$q0="SELECT * FROM USER WHERE user_id = '$post_user'";
					$r0=$db->query($q0);
					$row0=$r0->fetch_assoc();
					$blogID=$row2["Blog_ID"];
					
					$postLike="SELECT * FROM Likes WHERE value=1 AND Post_id='$blogID'";
					$postDislike="SELECT * FROM Likes WHERE value=2 AND Post_id='$blogID'";
					$getPostLike=mysqli_query($conn,$postLike);
					$getPostDislike=mysqli_query($conn,$postDislike);
					$nol=mysqli_num_rows($getPostLike);
					$nodl=mysqli_num_rows($getPostDislike);
					$counterp+=1;
					echo $counterp."<div class='post' name='".$row2["Blog_ID"]."'>
						<Nav class='blogNav'><a href='profileR.php?email=".$row0["email"]."'>".$row0["username"]."</a><img src="."upload/".$row0["username"]." style='width:50px;height:40px;'/></Nav>
						<Section class='blogSection'>".$row2["DateAndTime"]."</Section>
						<article class='blogArticle'>".$row2["Content"]."</article>
						<footer class='blogFooter'><a href='Repost.php?id=".$blogID."'>Repost</a></footer>
						<aside class='blogAside1'><table><tr><td>$nol</td><td>
						<input style='top:-7%' type='image' src='Like.png' class='like' value='".$blogID."' onclick='blogLike(".$blogID.")'/></td></tr></table>
						<span style='position:absolute;top:50px' class='err_msg' id='".$blogID."B1'></span>
						</aside>
						<aside class='blogAside2'><table><tr><td>$nodl</td><td>
						<input style='top:-7%' type='image' src='dislike.png' class='like' value='".$blogID."' onclick='blogDislike(".$blogID.")'/></td></table>
    					<span style='position:absolute;top:50px' class='err_msg' id='".$blogID."B2'></span>
						</aside>
						</div>";
						}
				}
			else{
				echo "<p>No new moment avaliable right now.</p>";
			}
			
			
			// Repost List
			echo "<p>Repost form here:</p>";
			$counterr=0;
			$q3="SELECT * FROM REPOST where Replied_User = '$userID' ORDER BY DateAndTime DESC";
			$result2= mysqli_query($conn,$q3);
			if((mysqli_num_rows($result2)>0)&&($counterr<20)){
				while($row2 = mysqli_fetch_assoc($result2)){
					
					$Replied_postID=$row2["Replied_Blog"];
					$q4="SELECT * FROM POST where Blog_ID = '$Replied_postID'";
					$r4 = $db->query($q4);
					$row4 = $r4->fetch_assoc();
					$past_post=$row4["Content"];
					$past_time=$row4["DateAndTime"];
					$Post_UID=$row4["Post_User"];
					$q5="SELECT * FROM USER where user_id = '$Post_UID'";
					$r5 = $db->query($q5);
					$row5 = $r5->fetch_assoc();
					
					$repostLike="SELECT * FROM Likes WHERE value=1 AND Repost_id='$blogID'";
					$repostDislike="SELECT * FROM Likes WHERE value=2 AND Post_id='$blogID'";
					$getrePostLike=mysqli_query($conn,$repostLike);
					$getrePostDislike=mysqli_query($conn,$repostDislike);
					$norl=mysqli_num_rows($getrePostLike);
					$nordl=mysqli_num_rows($getrePostDislike);
					
					$counterr+=1;
					echo $counterr."<div class='post' name='".$row2["Repost_ID"]."'>
						<Nav class='blogNav'>".$username."<img src="."upload/".$username." style='width:50px;height:40px;'/></Nav>
						<Section class='blogSection'>".$row2["DateAndTime"]."</Section>
						<article class='blogArticle'>".$row2["Comment"]."</article>
						<div class='repost'>
						RE:
						</div>
						<div class='blogDiv'>
						<Nav class='blogNav'><a href='profileR.php?email=".$row0["email"]."'>".$username."</a><img src="."upload/".$username." style='width:50px;height:40px;'/></Nav>
						<Section class='articleSection'>".$past_time."</Section>
						<article class='articleArticle'>".$past_post."</article>
					</div>
						<footer class='blogFooter'></footer>
						<aside class='blogAside1'><table><tr><td>$norl</td><td>
						<input style='top:-7%' type='image' src='Like.png' class='like' value='".$repostID."' onclick='repostLike(".$repostID.")'/></td></tr></table>
						<span style='left:200px' class='err_msg' id='".$repostID."R1'></span>
						</aside>
						<aside class='blogAside2'><table><tr><td>$nordl</td><td>
						<input style='top:-7%' type='image' src='dislike.png' class='like' value='".$repostID."' onclick='repostDislike(".$repostID.")'/></td></tr></table>
						<span style='left:200px' class='err_msg' id='".$repostID."R2'></span>
						</aside>
						</div>";
				}
			}
			?>
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
			<p style="margin-left:20px;">User's Profile</p>
			<hr />	
			<div style="width:100%;height:5%;">			
				<a style="postion:relative;float:left; left:20px;">
					<input style="width:120px;height:30px;margin-top:9%;" type="button" value="Change Profile" >
				</a>
			</div>

			<div style="width:100%;height:5%;">			
				<a style="postion:relative;float:left; left:20px;">
					<input style="width:120px;height:30px;margin-top:9%;" type="button" value="Chang Password" >
				</a>
			</div>	
			
			<br/>	
			<hr/>
		</aside>
	

		
		
		<footer class="footerSticky">
		
		</footer>
	
	</div>
		<script type = "text/javascript"  src = "profile-r.js" ></script>
<?php 
}


else
{
	header("Location: index.php");
}
?>

</body>
</html>
