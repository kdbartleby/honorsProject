<?php
    session_start();
    $page_title = 'Rate books';
    require_once('header.php');
    require_once('connectVariables.php');
    require_once('navbar.php');

    if (isset($_SESSION['username']) && isset($_SESSION['password']))
    {
        $dbc = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME)
                or die("Error connecting to database");
        $get_user_id_query = "SELECT user_id FROM user WHERE username='" .
                $_SESSION['username'] . "'";
        $result = mysqli_query($dbc, $get_user_id_query);
        $row = mysqli_fetch_row($result);
        $user_id = $row[0];


?>

<!--<h3>What type of book would you like to read?</h3>

<a href="fiction.php"><button type="button" class="btn btn-lg btn-info-outline">
    Fiction
</button></a>

<a href="nonfiction.php"><button type="button" class="btn btn-lg btn-info-outline">
    Non-Fiction
</button></a>
-->


<?php

        if(isset($_POST['submit']))
        {
            // test if the user has rated each book then add the rating to the database
            $already_added_query = "SELECT book_id FROM user_rating WHERE user_id=$user_id";
            $already_added_query_results = mysqli_query($dbc, $already_added_query);
            for ($counter = 1; $counter < 7; $counter++)
            {
                if (isset($_POST["rating$counter"]))
                {
                    $already_added = false;
                    while ($already_added_book = mysqli_fetch_row($already_added_query_results))
                    {
                        if ($already_added_book === $_POST["id$counter"])
                        {
                            $already_added = true;
                        }
                    }

                    if (!$already_added)
                    {
                        $add_rating_query = "INSERT INTO user_rating(user_id, book_id, rating)" .
                                " VALUES('$user_id', '" . $_POST["id$counter"] . "', '" .
                                $_POST["rating$counter"] . "')";
                        echo $add_rating_query;
                        mysqli_query($dbc, $add_rating_query);
                    }
                }
            }
        }

        // Test whether user has rated at least 5 books
        $number_of_user_ratings_query = "SELECT COUNT(*) FROM  user_rating WHERE user_id=$user_id";
        $result = mysqli_query($dbc, $number_of_user_ratings_query);
        $row = mysqli_fetch_row($result);
        $user_rating_number = $row[0];

        // If so, show the link to the recommendation page
        if ($user_rating_number < 5)
        {
?>
<h3>Rate at least 5 books to get a recommendation</h3>

<?php
        }
?>

<form method="post" action=<?php echo $_SERVER['PHP_SELF'] ?> name="ratingForm">

<?php

        // Display 5 books the user hasn't rated yet and a form to rate them
        $query = "SELECT id, title, CONCAT(first_name, ' ', last_name) author, cover FROM book JOIN author USING(author_id) " .
                "WHERE id NOT IN (SELECT book_id FROM user_rating WHERE user_id=$user_id) " .
                "ORDER BY RAND() LIMIT 6";

        $booksToRate = mysqli_query($dbc, $query);

        $counter = 1;
        while ($row = mysqli_fetch_array($booksToRate))
        {
            $id = $row['id'];
            $title = $row['title'];
            $author = $row['author'];
            $cover = $row['cover'];

            if ($counter === 1 || $counter === 4)
            {
                echo "<div class=row>";
            }

            echo "<div class='col-sm-4 bookDisplay'>";
            echo "<strong>$title</strong> <br />$author";

            echo "<div class=cover-image>";
            echo "<img src=$cover alt='Cover Image' /><br />";
            echo "</div>";

            echo "<select class='form-control' name='rating$counter' id='rating$counter'>
                    <option value=''
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>

                    </select>
                    <input type='hidden' name='id$counter' id='id$counter' value='$id' />";

            echo "</div>";

            if ($counter === 3 || $counter === 6)
            {
                echo "</div>";
            }

            $counter++;
        }
    mysqli_close($dbc);
?>
    <div class="buttonHolder">
        <button type="submit" class="btn btn-lg btn-info-outline" name="submit" id="submit">Submit</button>
    </div>
</form>

<?php
    }
    else
    {

?>
<h3>Log in or sign up</h3>
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
