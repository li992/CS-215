<?php
session_start();

if(isset($_SESSION["email"]))
{
	//If somebody is logged in, display a welcome message
	$email=$_SESSION["email"];
	$conn = mysqli_connect("localhost","li992","961209","li992");
	if ($conn->connect_error)
	{
		die ("Connection failed: " . $conn->connect_error);
	}
	$q="SELECT * FROM USER where email = '$email'";
	$r = $conn->query($q);
	$row = $r->fetch_assoc();
	$username=$row["username"];
	$DOB=$row["DOB"];
	$userID=$row["user_id"];
	
	
// get like and dislike value and store it when it triggered
	if(isset($_POST["blogID"])){
		$inputBID=$_POST["blogID"];
		$inputRID=0;
		$testLike="SELECT * FROM Likes WHERE Repost_id='$inputRID' AND Post_id='$inputBID'AND User_id='$userID'";
		$testr=mysqli_query($conn,$testLike);
		if(mysqli_num_rows($testr)==0){
			$inputLike="INSERT INTO Likes (Repost_id,Post_id,User_id,value) VALUES ('$inputRID','$inputBID','$userID',1)";
			$conn->query($inputLike);
			$result=1;
		}
		else{
			$result=0;
		}
		echo $result;
		$conn->close();
	}
	
	if(isset($_POST["repostID"])){
		$inputBID=0;
		$inputRID=$_POST["repostID"];
		$testLike="SELECT * FROM Likes WHERE Repost_id='$inputRID' AND Post_id='$inputBID'AND User_id='$userID'";
		$testr=mysqli_query($conn,$testLike);
		if(mysqli_num_rows($testr)==0){
			$inputLike="INSERT INTO Likes (Repost_id,Post_id,User_id,value) VALUES ('$inputRID','$inputBID','$userID',1)";
			$conn->query($inputLike);
			$result=1;
		}
		else{
			$result=0;
		}
		echo $result;
		$conn->close();
	}
	
}
?>