<?php 

    //connect to database
    $conn = mysqli_connect('localhost', 'USERNAME', 'PASSWORD', 'DATABASE_NAME');

    // check connection
    if (!$conn){
        echo 'Connection error: ' .mysqli_connect_error();
    }

?>