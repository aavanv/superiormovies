<?php
function init_db_connection()
{
    $conn = mysqli_connect("localhost", "superiormovies", "superiormovies", "superiormovies", "3306");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
function close_db_connection($conn){
    mysqli_close($conn);
}
?>
