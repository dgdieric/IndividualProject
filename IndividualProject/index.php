<!-- Login page -->

<?php	
	session_start();
	
	if(isset($_POST['loginSubmit'])) // If the user pressed the Submit button
	{
		// This will not be used if successful login
		$error = '<div class="alert alert-danger" role="alert"><b>Login Error:</b> Please enter a valid username and password.</div>';
		
		// Entered user information
		$uname = $_POST['username'];
		$pass = $_POST['password'];
		
		// Session Information
		$sess_id = "loggedin";

		//Admin login credentials
		if ($uname == "admin" && $pass == "password")
		{
		    $_SESSION["admin"] = $sess_id;
			
			//Redirect to landing page
			header('Location: theaters_admin.php');
		}

		//User login credentials
		if ($uname == "user" && $pass == "password")
		{
			$_SESSION["user"] = $sess_id;
			
			//Redirect to the landing page
			header('Location: theaters_user.php');
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Login</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
	
	<!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
</head>

<body>
	<div class="col-md-4"></div>	
	<div class="col-md-4" style="margin-top: 40px;">
		<br/>
		<div class="panel panel-default" style="box-shadow: 2px 2px 7px #888888;">
			<div class="panel-heading"><b>Login</b></div>
				<div class="panel-body">
				<?php
					//show login form
					echo '<form method="POST" action="index.php">
					<input type="text" size="10" name="username" class="form-control" value="'. $uname .'" placeholder="Username">
					<input type="password" size="10" name="password" style="margin-top: 5px;" class="form-control" placeholder="Password"><br>
					'.$error.'
					<button type="submit" name="loginSubmit" style="width: 100%;" class="btn btn-success">Submit</button>
				</form>';
				?>
				</div>
		</div>
		<!-- give option to continue without logging in -->
		<a href="theaters.php" style="text-decoration: none;"><span style="padding-right:3px;"></span>Continue as guest</a>
		
	</div>
	<div class="col-md-4"></div>
	</div>
	</center>
	</body>
	</html>	