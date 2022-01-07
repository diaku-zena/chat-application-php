<?php
    session_start();

    
    if(isset($_SESSION["unique_id"])){ //If user is loged id then come into this page, otherwise go to login page
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);

        if(isset($logout_id)){
            $status = "Offline";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id=$logout_id");

            if($sql){
                session_destroy();
                session_unset();

                header("location: ../login.php");
            }
        } else {
            header("location: ../users.php");
        }

    } else {
        header("location: ../login.php");
    }
?>