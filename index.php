<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
	<body>
		<?php
			$mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));	
		?>
		
		<div class="row justify-content-center">
		<form action="actionlogin.php" method="POST">
		
		<input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
            <h1><label><b>Username:</b><br /></label></h1>
            <input type="text" style="font-size:24px" name="username" class="form-control" 
                   value="" placeholder="Enter your name">
            </div>
			
			 <div class="form-group">
            <h1><label><b>Password:</b><br /></label></h1>
            <input type="text" style="font-size:24px" name="password" class="form-control" 
                   value="" placeholder="Enter your password">
            </div>
			<br \>
			<input type="submit" class="btn btn-primary btn-lg" name="submit" value="Login">
			<input type="hidden" name="refer" value="<?php echo (isset($_GET['refer'])) ? $_GET['refer'] : 'index.php'; ?>">
		</form>
	</body>
</html>
