<?php
    require_once('navbar.php');
    require_once('connectVariables.php');
    $dbc = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);

    $query = "SELECT title, first_name, last_name, year_published, " .
            "description, genre_name, cover " .
            "FROM book JOIN author USING (author_id) " .
            "JOIN genre USING (genre_id) " .
            "WHERE genre_name = '$genre_name' ORDER BY last_name";

    $books = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($books))
    {
        echo "<article>";
        echo "<img src=\"" . $row['cover'] . "\" /><br />";
        echo "<strong>" . $row['title'] . "</strong><br />";
        echo "By " . $row['first_name'] . " " . $row['last_name'] . "<br />";
        echo "Published in " . $row['year_published'] . "<br />";
        echo $row['description'];
        echo "</article><br />";
    }
    mysqli_close($dbc);

?>
