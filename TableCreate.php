
<?php
/// Create connection
$conn = new mysqli("localhost", "li992", "961209", "li992");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql1 = "CREATE TABLE USER (
		user_id INT NOT NULL AUTO_INCREMENT,
		username VARCHAR(255) NOT NULL,
		email VARCHAR(255) NOT NULL,
		password VARCHAR(30) NOT NULL,
		DOB DATE NOT NULL,
		PRIMARY KEY (user_id)
)";


$sql2 = "CREATE TABLE POST(
		Blog_ID INT NOT NULL AUTO_INCREMENT,
		Post_User VARCHAR(255) NOT NULL,
		Title TINYTEXT,
		Content TEXT,
		DateAndTime TIMESTAMP,
		PRIMARY KEY (Blog_ID),
		FOREIGN KEY (Post_User) REFERENCES USER(user_id)
)";


$sql3 = "CREATE TABLE REPOST(
		Repost_ID INT NOT NULL AUTO_INCREMENT,
		Replied_User VARCHAR(255) NOT NULL,
		Replied_Blog INT NOT NULL,
		Comment TEXT,
		DateAndTime TIMESTAMP,
		PRIMARY KEY (Repost_ID),
		FOREIGN KEY (Replied_User) REFERENCES USER(user_id),
		FOREIGN KEY (Replied_Blog) REFERENCES POST(Blog_ID)
)";

$sql4 = "CREATE TABLE Likes (
		Repost_id INT,
		Post_id INT,
		User_id INT NOT NULL,
		value INT,
		PRIMARY KEY (Repost_id,Post_id,User_id),
		FOREIGN KEY (Repost_id) REFERENCES REPOST(Repost_ID),
		FOREIGN KEY (Post_id) REFERENCES POST(Blog_ID),
		FOREIGN KEY (User_id) REFERENCES USER(user_id)		
)";

if ($conn->query($sql1) === TRUE) {
	echo "Table User created successfully"."<br/>";
} else {
	echo "Error creating table USER: " . $conn->error."<br/>";
}

if ($conn->query($sql2) === TRUE) {
	echo "Table POST created successfully"."<br/>";
} else {
	echo "Error creating table POST: " . $conn->error."<br/>";
}

if ($conn->query($sql3) === TRUE) {
	echo "Table REPOST created successfully"."<br/>";
} else {
	echo "Error creating table REPOST: " . $conn->error."<br/>";
}

if ($conn->query($sql4) === TRUE) {
	echo "Table Likes created successfully"."<br/>";
} else {
	echo "Error creating table Likes: " . $conn->error."<br/>";
}

$conn->close();
?>