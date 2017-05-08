<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">My Next Book</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
<?php
    // Show appropriate links if the user is logged in
    if (isset($_SESSION['username']) && isset($_SESSION['password']))
    {
        // Get the user's ID
        $dbc = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME)
                or die("Error connecting to database");
        $get_user_id_query = "SELECT user_id FROM user WHERE username='" .
                $_SESSION['username'] . "'";
        $result = mysqli_query($dbc, $get_user_id_query);
        $row = mysqli_fetch_row($result);
        $user_id = $row[0];

        // Test whether user has rated at least 5 books
        $number_of_user_ratings_query = "SELECT count(*) FROM  user_rating WHERE user_id=$user_id";
        $result = mysqli_query($dbc, $number_of_user_ratings_query);
        $row = mysqli_fetch_row($result);
        $user_rating_number = $row[0];

        // If so, show the link to the recommendation page
        if ($user_rating_number >= 5)
        {


 ?>
                <li><a href="getRecommendation.php">Get Recommendation</a></li>

<?php
        }
        // If not, show a grayed-out link
        else
        {
?>

            <li class="disabled"><a href="getRecommendation.php">Get Recommendation</a></li>
<?php
        }

?>
        <li><a href="addBook.php">Add Books</a></li>
        <li><a href="index.php">Rate Books</a></li>
<?php
    }
    else
    {
?>
                <li><a href="login.php">Log In</a></li>
                <li><a href="signup.php">Sign Up</a></li>
<?php
    }
?>
                <li><a href="booksByGenre.php">Books by Genre</a></li>
            </ul>
        </div>
    </div>
</nav>
