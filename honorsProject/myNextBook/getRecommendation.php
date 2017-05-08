<?php
    session_start();
    require_once("connectVariables.php");
    $page_title = "Recommendations";
    require_once("header.php");
    require_once('navbar.php');
    const MIDDLE_RATING = 3;

    // Test if the user is logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password']))
    {
        // Connect to database
        $dbc = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME)
                or die("Error connecting to database");

        // Get the user's user_id from the database
        $current_user = $_SESSION['username'];
        $get_user_id_query = "SELECT user_id FROM user WHERE username='$current_user'";
        $user_id_result = mysqli_query($dbc, $get_user_id_query);
        $row = mysqli_fetch_row($user_id_result);
        $user_id = $row[0];

        // Get all the user's ratings from the database
        $get_user_ratings_query = "SELECT rating_id, user_id, book_id, rating " .
                "FROM user_rating WHERE user_id=$user_id";
        $user_ratings_result = mysqli_query($dbc, $get_user_ratings_query);

        // Get all other users' ratings from the database
        $get_other_ratings_query = "SELECT rating_id, user_id, book_id, rating " .
                "FROM user_rating WHERE user_id<>$user_id";
        $other_ratings_result = mysqli_query($dbc, $get_other_ratings_query);

        // If another user rated a book similarly to the user, add that user to an array,
        // as long as they haven't already been added, and add the rating_id to
        // another array
        $same_book_ratings_array = array(); // an array of the book id's rated similarly to the user's ratings
        $similar_users_array = array(); // list of user_id's that have similar ratings to the user
        $user_books_array = array(); // array of book id's that the user has read
        while ($user_rating = mysqli_fetch_assoc($user_ratings_result))
        {
            //echo $user_rating['book_id'] . " ";
            // if the user has rated a book, add the book_id to an array
            if (!in_array($user_rating['book_id'], $user_books_array))
            {
                array_push($user_books_array, $user_rating['book_id']);
            }

            while ($other_rating = mysqli_fetch_assoc($other_ratings_result))
            {
                // test if user's book_id matches another user's book_id
                if ($other_rating['book_id'] === $user_rating['book_id'])
                {
                    // If the current user's and other user's rating is similar,
                    // add the other user's user_id to an array if it hasn't
                    // been added already, and add the other user's rating_id
                    // to another array
                    if (($other_rating['rating'] > MIDDLE_RATING && $user_rating['rating'] > MIDDLE_RATING) ||
                            ($other_rating['rating'] < MIDDLE_RATING && $user_rating['rating'] < MIDDLE_RATING) ||
                            ($other_rating['rating'] == MIDDLE_RATING && $user_rating['rating'] == MIDDLE_RATING))
                    {
                        array_push($same_book_ratings_array, $other_rating['rating_id']);

                        if (!in_array($user_rating['user_id'], $similar_users_array))
                        {
                            array_push($similar_users_array,
                                    $other_rating['user_id']);
                        }
                    }
                }
            }
        }

        // Find the books the other users rated highly, but not ones the user has
        // already rated
        $likely_books_array = array(); // an array of books the user may like
        foreach ($similar_users_array as $user)
        {
            $high_ratings_query = "SELECT rating_id, user_id, book_id, rating " .
                    "FROM user_rating WHERE user_id=$user AND (rating=4 OR rating=5)";
            $high_ratings_results = mysqli_query($dbc, $high_ratings_query);
            while ($current_rating = mysqli_fetch_array($high_ratings_results))
            {
                if (!in_array($current_rating['book_id'], $user_books_array))
                {
                    array_push($likely_books_array, $current_rating['book_id']);
                }
            }
        }

        if (count($likely_books_array) > 0)
        {
            // Get the book_id, title, cover image, author, description, genre for 4
            // likely books from the database and display them
            $book_info_query = "SELECT id, title, first_name, last_name, cover, description " .
                    "FROM book JOIN author USING(author_id) WHERE id IN (" .
                    implode(', ',$likely_books_array) . ") ORDER BY RAND() LIMIT 4";
            $book_info_results = mysqli_query($dbc, $book_info_query);
            echo "<div class='container'>";
            echo "<div class='row'>";
            $counter = 1;
            while ($book_info = mysqli_fetch_array($book_info_results))
            {
                echo "<div class='bookDisplay col-sm-6'>";
                echo "<strong>" . $book_info['title'] . "</strong><br />";
                echo "By " . $book_info['first_name'] . " " . $book_info['last_name'] . "<br />";
                echo "<img src='" . $book_info['cover'] . "'alt='Cover image'/><br />";
                echo $book_info['description'];
                echo "</div>";

                if ($counter === 2) {
                    echo "</div><div class='row'>";
                }
                $counter++;
            }
            echo "</div>";
        }
        else
        {
            echo "<p>No books match your ratings so far. Rate more books and try again.</p>";
        }

        mysqli_close($dbc);
    }
    else
    {
?>
        <h3>Log in/sign up to get a recommendation</h3>
        <a href="login.php"><button type="button" class="btn btn-lg btn-info-outline">
            Log In
        </button></a>
        <a href="signup.php"><button type="button" class="btn btn-lg btn-info-outline">
            Sign Up
        </button></a>

<?php
    }
?>
</div>
</body>
</html>
