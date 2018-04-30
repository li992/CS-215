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
	$strArray=array();
	$counterr=0;
	$q3="SELECT * FROM REPOST ORDER BY DateAndTime DESC";
	$result2= mysqli_query($conn,$q3);
	if((mysqli_num_rows($result2)>0)&&($counterr<20)){
		while($row2 = mysqli_fetch_assoc($result2)){
			
			$Replied_postID=$row2["Replied_Blog"];
			$Replied_user=$row2["Replied_User"];
			
			$q4="SELECT * FROM POST where Blog_ID = '$Replied_postID'";
			$r4 = $conn->query($q4);
			$row4 = $r4->fetch_assoc();
			$past_post=$row4["Content"];
			$past_time=$row4["DateAndTime"];
			$Post_UID=$row4["Post_User"];
			
			$q5="SELECT * FROM USER where user_id = '$Post_UID'";
			$r5 = $conn->query($q5);
			$row5 = $r5->fetch_assoc();
			
			$getOriginUser="SELECT * FROM USER WHERE user_id='$Replied_user'";
			$rGOU=$conn->query($getOriginUser);
			$rowOU=$rGOU->fetch_assoc();
			
			$repostID=$row2["Repost_ID"];
			$repostDislike="SELECT * FROM Likes WHERE value=2 AND Repost_id='$repostID'";
			$getRepostDislike=mysqli_query($conn,$repostDislike);
			$nordl=mysqli_num_rows($getRepostDislike);
			$RepostLike="SELECT * FROM Likes WHERE value=1 AND Repost_id='$repostID'";
			$getRepostLike=mysqli_query($conn,$RepostLike);
			$norl=mysqli_num_rows($getRepostLike);
		

			$strArray[$counterr]="<div class='post' name='".$repostID."'>
						<Nav class='blogNav'><a href='profileR.php?email=".$rowOU["email"]."'>".$rowOU["username"]."</a><img src="."upload/".$rowOU["username"]." style='width:50px;height:40px;'/></Nav>
						<Section class='blogSection'>".$row2["DateAndTime"]."</Section>
						<article class='blogArticle'>".$row2["Comment"]."</article>
						<div class='repost'>
						RE:
						</div>
						<div class='blogDiv'>
						<Nav class='articleNav'>".$row5["username"]."<img src="."upload/".$row5["username"]." style='width:40px;height:32px;'/></Nav>
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
			$counterr+=1;
				}
			}
	echo json_encode($strArray);
	$conn->close();
}
?>