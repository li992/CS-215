<?php

$validateL = true;
$reg_EmailL = "/^\w+@[a-zA-Z0-9_]+?\.[a-zA-Z0-9]{2,3}$/";
$reg_PswdL = "/^(\S*)?\d+(\S*)?$/";

$emailL = "";
$error = "";

if (isset($_POST["submittedL"]) && $_POST["submittedL"])
{
    $emailL = trim($_POST["email"]);
    $passwordL = trim($_POST["Pass"]);
    
    $db = new mysqli("localhost", "li992", "961209", "li992");
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

    $q="SELECT * FROM USER where email = '$emailL' AND password = '$passwordL'";
    $r = $db->query($q);

    $row = $r->fetch_assoc();
    if($emailL != $row["email"] && $passwordL != $row["password"])
    {
        $validateL = false;
        echo"part1";
    }
    else
    {
        $emailLMatch = preg_match($reg_EmailL, $emailL);
        if($emailL == null || $emailL == "" || $emailLMatch == false)
        {
            $validateL = false;
            echo"part2";
        }
        
        $pswdLen = strlen($passwordL);
        $passwordLMatch = preg_match($reg_PswdL, $passwordL);
        if($passwordL == null || $passwordL == "" || $pswdLen < 8 || $passwordLMatch == false)
        {
            $validateL = false;
            echo"part3";
        }
    }
    
    if($validateL == true)
    {

        session_start();
        $_SESSION["email"] = $row["email"];
        $_SESSION["uname"] = $row["username"];
        header("Location: index.php");
        $db->close();
        exit();
    }
    else 
    {
        $error = "The email/password combination was incorrect. Login failed.";
        $db->close();
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login Page</title>
<link rel="stylesheet" type="text/css" href="BlogCSS.css"/>
<script type="text/javascript" src="loginphp.js"></script>
</head>


<body>
<div id="LGIframework">
	<section id="Login">
		<strong >Please enter your Username and Password to login</strong>
		<form id="SignUp" method="post">
		<input type="hidden" name="submittedL" value="1"/>
			<table>
				<tr><td>Email: </td><td><input id="i1" type="text" name="email"></td></tr>
				<tr><td></td><td><span id="email_msg" class="err_msg"></span></td></tr>
				
				<tr><td>Password:</td><td> <input id="i2" type="password" name="Pass"></td></tr>
				<tr><td></td><td><span id="pswd_msg" class="err_msg"></span></td></tr>
				
				<tr><td></td><td><span id="info" class="err.msg"></span></td></tr>
			</table>
			<span class="err_msg"><?php echo $error?></span><br/>
			<input id="i3" type="submit" value="Login">
		</form>
		<script type = "text/javascript"  src = "Login-r.js" ></script>
	</section>

	<hr style="margin-top:27%;" />

	<section id="Register">
		<p>New user? Click here: <a href="register.php">Register</a></p>
	</section>
	
</div>

</body>
</html>