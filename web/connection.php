<?php

function init_db_connection()
{
    $host = "127.0.0.1";
    $user = "superiormovies";
    $pass = "superiormovies";
    $db = "superiormovies";
    $port = 3306;

    $conn = mysqli_connect($host, $user, $pass, $db, $port);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
function close_db_connection($conn){
    mysqli_close($conn);
}
?>
