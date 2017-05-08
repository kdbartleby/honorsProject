<?php
    session_start();
    $page_title = 'Sign Up';
    require_once('header.php');
    require_once('connectVariables.php');
    require_once('navbar.php');

    if (isset($_POST['submit']))
    {
        $dbc = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD,
                DATABASE_NAME);
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
        $confirmPassword = mysqli_real_escape_string($dbc, trim($_POST['confirmPassword']));

        // Submit button is pressed; attempt to add data to database
        if (!empty($email) && !empty($username) && !empty($password) &&
                ($confirmPassword === $password))
        {
            $query = "INSERT INTO user(email, username, password)
                    VALUES('$email', '$username', '$password')";
            mysqli_query($dbc, $query);

            //  set username and password session and redirect to home page
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;

            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) .
                    '/index.php';
            header('Location: ' . $home_url);

        }
        // If any of the fields are empty, send this error
        else if (empty($email) || empty($username) || empty($password) ||
                empty($confirmPassword))
        {
            echo('<p class="error">Please enter information into all fields to continue</p>');
        }
        else if ($confirmPassword !== $password)
        {
            echo('<p class="error">The password and confirm password fields must match');
        }
    }
?>
  <div class="row">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-6">
          <form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' onsubmit "return validateForm()";>
            <div class="form-group">
                <label for='email'>Email</label>
                <input type='text' class="form-control" name='email' id='email' value='<?php if (!empty($email)) echo $email; ?>' />
            </div>

            <div class="form-group">
                <label for='username'>Username</label>
                <input type='text' class="form-control" name='username' id='username' value='<?php if (!empty($username)) echo $username; ?>' />
            </div>

            <div class="form-group">
                <label for='password'>Password</label>
                <input type='password' class="form-control" name='password' id='password' />
            </div>

            <div class="form-group">
                <label for='confirmPassword'>Confirm Password</label>
                <input type='password' class="form-control" name='confirmPassword' id='confirmPassword' />
            </div>

            <div class="buttonHolder">
                <button type="submit" class="btn btn-info-outline" name="submit" id="submit">Submit</button>
            </div>
          </form>
      </div>
      <div class="col-sm-3">
      </div>
  </div>
</body>
</html>
