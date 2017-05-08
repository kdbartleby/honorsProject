<?php
	// This is the login page
	session_start();
	$page_title = 'Log In';
	require_once('header.php');
	require_once('connectVariables.php');
	require_once('navbar.php');

	$error_message = "";

	// Try to log the user in, if not logged in already
	if (!isset($_SESSION['user_id']))
	{
		if (isset($_POST['submit']))
		{
			$dbc = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);

			$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
			$password = mysqli_real_escape_string($dbc, trim($_POST['password']));

			if (!empty($email) && !empty($password))
			{
				// Look up username and password in the database
				$query = "SELECT user_id, username, password FROM user WHERE email = " .
						"'$email' AND password = '$password'";
				$data = mysqli_query($dbc, $query);

				if (mysqli_num_rows($data) === 1)
				{
					// Login is OK; set userID and username session
					$row = mysqli_fetch_array($data);
					$_SESSION['username'] = $row['username'];
					$_SESSION['password'] = $row['password'];
					$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
							'/index.php';

				}
				else
				{
					// Incorrect username/password; send error message
					$error_message = 'Please enter a valid email and password.';
				}
			}
			else
			{
				// Username/password weren't entered; send error message
				$error_message = 'Please enter your email and password to log in';
			}
		}
	}

	// If the session variable(s) are empty, show the error message and the form
	if (empty($_SESSION['username']) || empty($_SESSION['password']))
	{
		echo '<p class="error">' . $error_message . '</p>';

?>
	<div class="row">
		<div class="col-sm-3">
		</div>
		<div class="col-sm-6">
		  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm();">

			<div class="form-group">
			    <label for="email">Email</label>
			    <input type="text" class="form-control" name="email" id="email" value="<?php if (!empty($email)) echo $email; ?>"/>
			</div>

			<div class="form-group">
			    <label for="password">Password</label>
			    <input type="password" class="form-control" name="password" id="password" value="<?php if (!empty($password)) echo $password; ?>" />
			</div>

			<div class="buttonHolder">
		    	<button type="submit" class="btn btn-info-outline" name="submit" id="submit">Submit</button>
			</div>
		  <form>
	  </div>
      <div class="col-sm-3">
      </div>
  </div>


<?php
	}
	else
	{
		// Confirm successful Login
		echo ('<p>You are logged in as ' . $_SESSION['username'] . '.</p>');
?>
<a href="addBook.php"><button type="button" class="btn btn-lg btn-info-outline">
    Add Books
</button></a>

<a href="index.php"><button type="button" class="btn btn-lg btn-info-outline">
    Rate Books
</button></a>

<?php
	}
?>
</body>
</html>
