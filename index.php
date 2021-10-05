


<head><title>Login</title>
</head>
<body>

	<?php
		$mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));	
	?>

<form action="actionlogin.php" method="POST">
Username:<br />
<input type="text" name="username">
<br />
Password:<br />
<input type="password" name="password">
<br />
<input type="submit" name="submit" value="Login">
<input type="hidden" name="refer" value="<?php echo (isset($_GET['refer'])) ? $_GET['refer'] : 'index.php'; ?>">
</form>
</body>
</html>