
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Creating New Blog</title>
<link rel="stylesheet" type="text/css" href="BlogCSS.css"/>
<script type="text/javascript" src="newBlog.js"></script>
</head>

<body>

<?php
session_start();
$ID=$_GET['id'];
if($ID!=0){
	$_SESSION['id']=$ID;
}
//session_start();

//If nobody is logged in, display login and signup page.
if(isset($_SESSION["email"]))
  {	
	$RBID=$_SESSION['id'];
    
    //echo $ID;
    if (isset($_POST["submittedS"]) && $_POST["submittedS"])
      {
	$validateS = true;
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	$unameS=$_SESSION["uname"];
	$emailS=$_SESSION["email"];
	$error="";
	
	if(empty($_POST["Comment"])){
	  $CommentL="";
	  $validateS=false;
	}
	else{
	  $CommentL = test_input($_POST["Comment"]);
	}
	
	$db = new mysqli("localhost", "li992", "961209", "li992");
	if ($db->connect_error)
	  {
	    die ("Connection failed: " . $db->connect_error);
	  }
	$q1 = "SELECT * FROM USER WHERE email = '$emailS'";
	$r1 = $db->query($q1);
	$row = $r1->fetch_assoc();

	if($validateS == true)
	  {
	    $userID = $row["user_id"];
	    $q2="INSERT INTO REPOST (Replied_Blog,Replied_User,Comment) VALUES ('$RBID','$userID','$CommentL')";
	    $r2 = $db->query($q2);
	
	    if ($r2 === true)
	    {
		header("Location: index.php");
		$db->close();
		exit();
	    }
	  }
	else
	  {
	    $errorS = "Validate false";
	    $db->close();
	  }
      }
    ?>
     <div id="NBframework">
	 <strong>Write Your Repost in the Box Below: </strong>
	 <form id="newBlog" method="POST" style="width:80%;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	 Reposting: <br/>
	 <input type="text" id="Blog" maxlength="150" name="Comment"/><br/>
	 <span id="notice" style="font-size:70%;color:red;"><?php echo $errorS;?></span><br/>
	 <input type="hidden" name="submittedS" value="1"/>
	 <input id="i5" type="submit" value="confirm" />
	 <a href = "index.php"><input id="i6" type="button" value="Cancel" ></a>
	 </form>
	 <script type = "text/javascript"  src = "newBlog-r.js" ></script>
     </div>
<?php 
 }
else
{
	header("Location: index.php");

}
?>

</body>
</html>
