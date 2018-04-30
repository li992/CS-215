<?php
$validateS = true;
$error = "";
$reg_Email = "/^\w+@[a-zA-Z0-9_]+?\.[a-zA-Z0-9]{2,3}$/";
$reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
$reg_Bday = "/^\d{1,2}\/\d{1,2}\/\d{4}$/";
$emailS = "";
$dateS = "mm/dd/yyyy";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/************************data check*********************************/
if (isset($_POST["submittedS"]) && $_POST["submittedS"])
{
	$nameErr = $emailErr = $dateErr = "";
	$name = $email = "";
	$emailS = trim($_POST["email"]);
	$dateS = trim($_POST["user_date"]);
	$passwordS = trim($_POST["Pass"]);
	$passwordR = trim($_POST["Passr"]);
	$uname = trim($_POST["uname"]);
	$okay=true;
//username check
	if (empty($_POST["uname"])) {
   		$nameErr = "Name is required";
   		$okay=false;
  	} else {
    	$name = test_input($_POST["uname"]);
    	if (!preg_match("/^[a-zA-Z0-9_-]+$/",$name)) {
      		$nameErr = "Please enter the correct format for Username. (No leading or trailing spaces)"; 
    		$okay=false;
    	}
  	}
//DOB check
	if(empty($_POST["user_date"])){
		$dateErr = "Date of birth is required";
		$okay=false;
	}
//email check
	if (empty($_POST["email"])) {
    	$emailErr = "Email is required";
    	$okay=false;
  	} else {
    	$email = test_input($_POST["email"]);
    	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      	$emailErr = "Email address empty or wrong format. example: username@somewhere.sth"; 
      	$okay=false;
    	}
  	}
/*********************************file upload check***************************/
  	$target_dir = "upload/";
  	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  	$uploadOk = 1;
  	$imageInfo="";
  	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
  	if(isset($_POST["submit"])) {
  		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  		if($check !== false) {
  			$imageInfo= "File is an image - " . $check["mime"] . ".";
  			$uploadOk = 1;
  		} else {
  			$imageInfo= "File is not an image."."<br /submittedS>";
  			$uploadOk = 0;
  			$okay=false;
  		}
  	}
  	// Check if file already exists
  	if (file_exists($target_file)) {
  		$imageInfo= "Sorry, file already exists."."<br />";
  		$uploadOk = 0;
  		$okay=false;
  	}
  	// Check file size
  	if ($_FILES["fileToUpload"]["size"] > 500000) {
  		$imageInfo= "Sorry, your file is too large."."<br />";
  		$uploadOk = 0;
  		$okay=false;
  	}
  	// Allow certain file formats
  	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  		$imageInfo= "Sorry, only JPG, JPEG, PNG & GIF files are allowed."."<br />";
  		$uploadOk = 0;
  		$okay=false;
  	}
 	 // Check if $uploadOk is set to 0 by an error
  	if ($uploadOk == 0) {
  		$imageInfo= "Sorry, your file was not uploaded."."<br />";
  		// if everything is ok, try to upload file
  	}
  	else {
  		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  			$imageInfo= "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  			$fileName=$_FILES['fileToUpload']['name'];
  			$name=explode('.',$fileName);
  			$newName=$uname;
  			rename($target_dir.$fileName,$target_dir.$newName);
  		}
  		else {
  			$imageInfo= "Sorry, there was an error uploading your file.";
  		}
  	}
  	

  	if($okay==true)
  	{
  		$db = new mysqli("localhost", "li992", "961209", "li992");
  		if ($db->connect_error)
  		{
  			die ("Connection failed: " . $db->connect_error);
  		}
  		
  		$q1 = "SELECT * FROM USER WHERE email = '$emailS'";
  		$r1 = $db->query($q1);
  		
  		// if the email address is already taken.
  		if($r1->num_rows > 0)
  		{
  			$validateS = false;
  		}
  		else
  		{
  			$emailMatch = preg_match($reg_Email, $emailS);
  			if($emailS == null || $emailS == "" || $emailMatch == false)
  			{
  				$validateS = false;
  			}
  		
  		
  			$pswdLenS = strlen($passwordS);
  			$pswdMatch = preg_match($reg_Pswd, $passwordS);
  			if($passwordS == null || $passwordS == "" || $pswdLenS < 8 || $pswdMatch == false)
  			{
  				$validateS = false;
  			}
  		
  			$bdayMatch = preg_match($reg_Bday, $dateS);
  			if($dateS == null || $dateS == "" || $bdayMatch == false)
  			{
  				$validateS = false;
  			}
  		}
  		
  		if($validateS == true)
  		{
  			$dateFormatS = date("Y-m-d", strtotime($dateS));
  			$q2="INSERT INTO USER (email,password,DOB,username) VALUES ('$emailS','$passwordS','$dateFormatS','$uname')";
  			$r2 = $db->query($q2);
  		
  			if ($r2 === true)
  			{
  				header("Location: Login.php");
  				$db->close();
  				exit();
  			}
  		}
  		else
  		{
  			$errorS = "email address is not available. Signup failed.";
  			$db->close();
  		}
  	}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register Page</title>
<link rel="stylesheet" type="text/css" href="BlogCSS.css"/>
<script type="text/javascript" src="register.js"> </script> 
</head>

<body>
<div id="RGTframework">

	<strong>Please enter the information shows below: </strong><span class="err_msg">(* required field.)</span>
	<form id="SignUp" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		Username:<input type="text" name="uname"/><span id="uname_msg" class="err_msg" >*<?php echo $nameErr;?></span>
		<br>
		E-mail: <input type="email" name="email"/><span id="email_msg" class="err_msg" >*<?php echo $emailErr;?></span>
		<br>
		Password: <input type="password" name="Pass"/><span id="pswd_msg" class="err_msg"></span>
		<br>
		Re-Enter Password:<input type="password" name="Passr"/><span id="pswdr_msg" class="err_msg"></span>		
		<br>
		Date of Birth:<input type="date" name="user_date"/><span id="date_msg" class="err_msg" >*<?php echo $dateErr;?></span>
		<br>
		Upload an Image:<input type="file"  name="fileToUpload" id="fileToUpload"/><span id="img_msg" class="err_msg">*<?php echo $imageInfo;?></span>
		<br>
		<input type="hidden" name="submittedS" value="1"/><br>
		
		<a href=""><input  type="submit" value="Comfirm"></a>
		<a href="Login.php"><input  type="button" value="Cancel" ></a>
	</form>
	<script type = "text/javascript"  src = "register-r.js" ></script>
</div>
</body>
</html>