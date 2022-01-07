<?php
    $conn = mysqli_connect("localhost", "elias", "sempre10", "chat");
    if(!$conn){
        echo "Database not conneted" . mysqli_connect_error();
    }