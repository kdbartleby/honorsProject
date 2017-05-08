<?php
    session_start();
    $page_title = "Add Genre";
    require_once('header.php');
    require_once('connectVariables.php');
    if (isset($_SESSION['username']) && isset($_SESSION['password']))
    {
       // Connect to the database
        $dbc = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);

        if (isset($_POST['genreSubmit']))
        {
            $genre = mysqli_real_escape_string($dbc, trim($_POST['genreName']));
            $genreDescription = mysqli_real_escape_string($dbc, trim($_POST['genreDescription']));

            if (!empty($genre) && !empty($genreDescription))
            {
                // Check if the genre already exists in the table
                $genre_match_query = "SELECT * FROM genre WHERE genre_name = $genre";
                $genre_match_result = mysqli_query($dbc, $genre_match_query);

                if (empty($genre_match_result))
                {
                    $genre_add_query = "INSERT INTO genre(genre_name, genre_description)" .
                            "VALUES('$genre', '$genreDescription')";
                    mysqli_query($dbc, $genre_add_query);

                    // Confirm success
                    echo '<p>Your genre has been successfully added.</p>';
                    echo '<a href="index.php"><button type="button" class="btn btn-lg btn-info-outline">Find a book to read</button></a>' .
                            '<a href="addBook.php"><button type="button" class="btn btn-lg btn-info-outline">Add a book</button></a>';

                    mysqli_close($dbc);
                    exit();

                }
            }
            else
            {
                echo "<p>Please enter all the form information to continue</p>";
            }
            mysqli_close($dbc);
        }
?>
<form method="post" action="addGenre.php">
  <legend>Genre Information</legend>
  <label for="genreName">Genre</label>
  <input type="text" id="genreName" name="genreName">
  <label for="genreDescription" id="genreDescriptionLabel">Description</label>
  <textarea id="genreDescription" name="genreDescription" value="<?php if (!empty($genreDescription)) echo $genreDescription; ?>">
  </textarea>
  <input type="submit" id="genreSubmit" name="genreSubmit" value="Enter Genre" />

</form>


<a href="addBook.php"><button type="button" class="btn btn-lg btn-info-outline">
    Add Books
</button></a>
<a href="index.php"><button type="button" class="btn btn-lg btn-info-outline">
    Home
</button></a>
<?php
    }
    else
    {
?>
<h3>Please log in to add genres to the site.</h3>
<a href="login.php"><button type="button" class="btn btn-lg btn-info-outline">
    Log In
</button></a>
<a href="signup.php"><button type="button" class="btn btn-lg btn-info-outline">
    Sign Up
</button></a>

<?php
    }

?>
</body>
</html>
