<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "doan";
	// tao connect
	$conn = new mysqli($servername, $username, $password, $dbname);
	// kiem tra connect
	if ($conn->connect_error) {
	    die("Kết nối thất bại :( <br>" . $conn->connect_error);
	}
?>

