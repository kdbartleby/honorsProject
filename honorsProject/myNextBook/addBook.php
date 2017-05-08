<?php
    session_start();
    $page_title = 'Submit Book';
    require_once('header.php');
    require_once('connectVariables.php');
    require_once('appvars.php');
    require_once('navbar.php');

    $dbc = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME)
            or die("Connection Failed: " . mysqli_connect_error());


    if (isset($_SESSION['username']) && isset($_SESSION['password']))
    {

        if (isset($_POST['submit']))
        {
            // Grab the profile data from the POST
            $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
            $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
            $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
            $genre = mysqli_real_escape_string($dbc, trim($_POST['genre']));
            $publish_year = mysqli_real_escape_string($dbc, trim($_POST['publish_year']));
            $description = mysqli_real_escape_string($dbc, trim($_POST['description']));
            $cover = mysqli_real_escape_string($dbc, trim($_FILES['cover']['name']));
            $cover_type = $_FILES['cover']['type'];
            $cover_size = $_FILES['cover']['size'];
            list($cover_width, $cover_height) = getimagesize($_FILES['cover']['tmp_name']);
            $error = false;
            // Validate and move the uploaded picture file, if necessary

            if (!empty($cover))
            {
                if ((($cover_type == 'image/gif') || ($cover_type == 'image/jpeg') || ($cover_type == 'image/pjpeg') ||
                  ($cover_type == 'image/png')) && ($cover_size > 0) && ($cover_size <= MAXFILESIZE) &&
                  ($cover_width <= MAXIMGWIDTH) && ($cover_height <= MAXIMGHEIGHT))
                {
                    if ($_FILES['cover']['error'] == 0)
                    {
                          // Move the file to the target upload folder
                          $target = UPLOADPATH . basename($cover);
                          if (move_uploaded_file($_FILES['cover']['tmp_name'], $target))
                          {
                          }
                          else {
                              // The new picture file move failed, so delete the temporary file and set the error flag
                              @unlink($_FILES['cover']['tmp_name']);
                              $error = true;
                              echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
                          }
                    }
                }
                else {
                    // The picture file is not valid, so delete the temporary file and set the error flag
                    @unlink($_FILES['cover']['tmp_name']);
                    $error = true;
                    echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MAXFILESIZE / 1024) .
                      ' KB and ' . MAXIMGWIDTH . 'x' . MAXIMGHEIGHT . ' pixels in size.</p>';
                }
            }


            // Insert the book data into the database
            if (!$error)
            {
                if (!empty($title) && !empty($first_name) && !empty($last_name) && !empty($genre) &&
                        !empty($publish_year) && !empty($description))
                {
                    // Check if the author's name is already present in the author table
                    $author_match_query = "SELECT author_id, first_name, last_name FROM author";
                    $data = mysqli_query($dbc, $author_match_query);
                    while($row = mysqli_fetch_array($data))
                    {
                        if($row['first_name'] === $first_name && $row['last_name'] === $last_name)
                        {
                            // The author's name is already present, so just insert book info
                            $author_id = $row['author_id'];
                        }
                    }

                    if (!isset($author_id))
                    {
                        // The author isn't in the database yet, so insert their info
                        $author_query = "INSERT INTO author (first_name, last_name)
                                VALUES ('$first_name', '$last_name')";
                        mysqli_query($dbc, $author_query);

                        // assigns the last ID inserted to the table to $author_id
                        $author_id = mysqli_insert_id($dbc);
                    }

                    // Only set the cover column if there is a cover
                    if (!empty($cover))
                    {
                        $book_query = "INSERT INTO book (title, author_id, genre_id,
                                description, year_published, cover)
                                VALUES ('$title', $author_id, $genre, '$description',
                                $publish_year, 'images/$cover')";
                    }
                    else
                    {
                        $book_query = "INSERT INTO book (title, author_id, genre_id,
                                description, year_published)
                                VALUES ('$title', $author_id, $genre, '$description',
                                $publish_year)";
                    }
                    mysqli_query($dbc, $book_query);

                    // Confirm success with the user
                    echo '<p>Your book has been successfully added.</p>';
                    echo '<a href="index.php"><button type="button" class="btn btn-lg btn-info-outline">Find a book to read</button></a>' .
                            '<a href="addBook.php"><button type="button" class="btn btn-lg btn-info-outline">Add another book</button></a>';

                    mysqli_close($dbc);
                    exit();
                }
            }
            else
            {
                echo '<p class="error">You must enter all of the book data (the picture is optional).</p>';
            }
        } // End of check for book form submission
?>

<div class="row">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-6">
      <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm();">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAXFILESIZE; ?>" />
        <fieldset>
          <legend>Book Information</legend>
          <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title" value="<?php if (!empty($title)) echo $title; ?>" />
          </div>

          <div class="form-group">
              <label for="firstname">Author first name</label>
              <input type="text" class="form-control"  id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name; ?>" />
          </div>

          <div class="form-group">
              <label for="lastname">Author last name</label>
              <input type="text" class="form-control"  id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" />
          </div>

          <div class="form-group">
              <label for="genre">Genre</label>
              <select class="form-control" id="genre" name="genre">
<?php
    $genre_query = "SELECT genre_id, genre_name FROM genre ORDER BY genre_name";
    $populate_dropdown_query = mysqli_query($dbc, $genre_query)
        or die("<p>Error selecting genre</p>");
    while ($row = mysqli_fetch_array($populate_dropdown_query))
    {
        echo "<option value=\"" . $row['genre_id'] . "\">" . $row['genre_name'] . "</option>";
    }

?>
              </select>
          </div>

          <div class="form-group">
              <label for="publish_year">Year Published</label>
              <input type="text" class="form-control" id="publish_year" name="publish_year" value="<?php if (!empty($publish_year)) echo $publish_year; ?>" /><br />
          </div>

          <div class="form-group">
              <label for="description">Description</label>
              <textarea id="description" class="form-control" name="description" value="<?php if (!empty($description)) echo $description; ?>"></textarea> <br />
          </div>

          <div class="form-group">
              <label for="cover">Cover Image</label>
              <input type="file" class="form-control" id="cover" name="cover" />
          </div>
        </fieldset>

        <div class="buttonHolder">
            <button type="submit" class="btn btn-info-outline" name="submit" id="submit">Enter Book</button>
        </div>
    </form>
    </div>
    <div class="col-sm-3">
    </div>
</div>

<h3>Don't see the right genre for your book? Add another genre here:</h3>
<div class="row">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-6">
        <form method="post" action="addGenre.php">

          <legend>Genre Information</legend>
          <div class="form-group">
              <label for="genreName">Genre</label>
              <input type="text" class="form-control" id="genreName" name="genreName">
          </div>

          <div class="form-group">
              <label for="genreDescription" id="genreDescriptionLabel">Description</label>
              <textarea class="form-control" id="genreDescription" name="genreDescription" value="<?php if (!empty($genreDescription)) echo $genreDescription; ?>"></textarea>
          </div>
          <div class="buttonHolder">
              <button type="submit" class="btn btn-info-outline" name="submit" id="submit">Enter Genre</button>
          </div>

        </form>
    </div>
    <div class="col-sm-3">
    </div>
</div>

<?php
    }
    else
    {
?>
    <h3>Please log in to add books to the site.</h3>
    <a href="login.php"><button type="button" class="btn btn-lg btn-info-outline">
        Log In
    </button></a>
    <a href="signup.php"><button type="button" class="btn btn-lg btn-info-outline">
        Sign Up
    </button></a>

<?php
    }
    mysqli_close($dbc);
?>
</body>
</html>
