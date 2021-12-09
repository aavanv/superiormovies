<?php

require_once 'connection.php';

$conn = init_db_connection();

$tableRow = $_POST['tableRow'];
foreach($tableRow as $row){
    $movie_id = $row["id"];
    if (isset($row["rating"])) {
        $rating = $row["rating"];
        $query = "insert into movie_rating(movie_id, rating) values($movie_id, $rating)";
        $result = mysqli_query($conn, $query);
    }
}
echo "Data saved."
?>
