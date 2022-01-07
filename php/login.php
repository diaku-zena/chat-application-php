<?php
    session_start();
    include_once "config.php";

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pswrd = mysqli_real_escape_string($conn, $_POST["pswrd"]);

    if(!empty($email) && !empty($pswrd)){
        // checking the user email and password, and if it matches to dabase any table row email and pass
        $sql = mysqli_query($conn, "SELECT * From users WHERE email='{$email}' and pswrd='$pswrd'");

        if(mysqli_num_rows($sql) > 0){ // user's credencial matches
            $row = mysqli_fetch_assoc($sql);
            $status = "Activo Agora";

            $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$row['unique_id']}");

            if($sql2){
                $_SESSION["unique_id"] = $row["unique_id"];
                echo "success";
            }
        } else {
            echo "Email ou palavra-passe está incorreta";            
        }  
      
    } else {
        echo "Por favor, preencha os campos vazios";
        
    }