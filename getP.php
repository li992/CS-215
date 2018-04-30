<?php
session_start();
$_SESSION["email"]="li992@uregina.ca";
//If nobody is logged in, display login and signup page.
if(isset($_SESSION["email"]))
{
	//If somebody is logged in, display a welcome message
	$email=$_SESSION["email"];
	$conn = mysqli_connect("localhost","li992","961209","li992");
	if ($conn->connect_error)
	{
		die ("Connection failed: " . $conn->connect_error);
	}
	
	$counterp=0;
	$query="SELECT * FROM POST ORDER BY DateAndTime DESC";
	$result= mysqli_query($conn,$query);
	$strArray=array();
	if(mysqli_num_rows($result)>0){
		while(($row2 = mysqli_fetch_assoc($result))&&($counterp<20)){
			$post_user=$row2["Post_User"];
			$q0="SELECT * FROM USER WHERE user_id = '$post_user'";
			$r0=$conn->query($q0);
			$row0=$r0->fetch_assoc();
				
		
			$blogID=$row2["Blog_ID"];
			$postDislike="SELECT * FROM Likes WHERE value=2 AND Post_id='$blogID'";
			$getPostDislike=mysqli_query($conn,$postDislike);
			$nodl=mysqli_num_rows($getPostDislike);
			$postLike="SELECT * FROM Likes WHERE value=1 AND Post_id='$blogID'";
			$getPostLike=mysqli_query($conn,$postLike);
			$nol=mysqli_num_rows($getPostLike);
			$strArray[$counterp]="<div class='post' name='".$row2["Blog_ID"]."'>
						<Nav class='blogNav'><a href='profileR.php?email=".$row0["email"]."'>".$row0["username"]."</a><img src="."upload/".$row0["username"]." style='width:50px;height:40px;'/></Nav>
						<Section class='blogSection'>".$row2["DateAndTime"]."</Section>
						<article class='blogArticle'>".$row2["Content"]."</article>
						<footer class='blogFooter'><a href='Repost.php?id=".$row2["Blog_ID"]."'>Repost</a></footer>
						<aside class='blogAside1'><table><tr><td>$nol</td><td>
						<input style='top:-7%' type='image' src='Like.png' class='like' value='".$row2["Blog_ID"]."' onclick='blogLike(".$row2["Blog_ID"].")'/></td></tr></table>
						<span style='position:absolute;top:50px' class='err_msg' id='".$row2["Blog_ID"]."B1'></span>
						</aside>
						<aside class='blogAside2'><table><tr><td>$nodl</td><td>
						<input style='top:-7%' type='image' src='dislike.png' class='like' value='".$row2["Blog_ID"]."' onclick='blogDislike(".$row2["Blog_ID"].")'/></td></table>
    					<span style='position:absolute;top:50px' class='err_msg' id='".$row2["Blog_ID"]."B2'></span>
						</aside>
						</div>";
			$counterp+=1;
		}	
	}	
	echo json_encode($strArray);
	$conn->close();
}
?>