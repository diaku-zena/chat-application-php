<?php
    include_once "config.php";

    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $output = "";
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%'");
    
    if(mysqli_num_rows($sql) > 0){

    } else {
        $output .= "Nenhum resultado encontrado!";
    }

    echo $output;
