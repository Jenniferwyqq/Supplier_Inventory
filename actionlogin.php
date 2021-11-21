<?php
	
session_start();
$mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));	

$username = $_POST['username'];
$password = $_POST['password'];
$refer = $_POST['refer'];

if ($username == '' || $password == '')
{
    // No login information
    header('Location: index.php?refer='. urlencode($_POST['refer']));
}
else
{
	$result = $mysqli->query("SELECT user_pass FROM employ WHERE employ.user_name = $username") or die($mysqli->error);
	
    if(mysqli_num_rows($result) == 1){
		$row = $result->fetch_assoc();
		if($password == $row['user_pass']){
			$_SESSION['message'] = "Welcome, Top Shoe!";
			$_SESSION['msg_type'] = "success";
			header('Location: main.php');
		} else {
			$_SESSION['message'] = "Incorrect password, please try again!";
			$_SESSION['msg_type'] = "danger";
			header('Location: index.php');
		}
	} else {
		header('Location: index.php');
	}

}
?>
