<?php
    session_start();
    include_once "config.php";

    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $pswrd = mysqli_real_escape_string($conn, $_POST["pswrd"]);

    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($pswrd)){
        // Checking user email is valid or not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // if the email is valid
            //checking if the email already exists in the databases
            $sql = mysqli_query($conn, "SELECT email From users WHERE email = '{$email}'");

            if(mysqli_num_rows($sql) > 0){ // if email already exist
                echo $email . " - Este email já existe";
            } else {
                // Let's check the user uploaded file
                if(isset($_FILES["image"])){ // if the image is uploaded
                    $img_name = $_FILES["image"]['name']; // getting the user uploaded file name
                    $img_type = $_FILES["image"]['type']; // getting the user uploaded file type
                    $tmp_name = $_FILES["image"]["tmp_name"]; // This temporaty name is used to save/move file in pur folder

                    // let's explode image and get the extension like jpg, png
                    $img_explode = explode(".", $img_name);
                    $img_ext = end($img_explode); // Here we get the extension of an user uploaded img

                    $extensions = ["png", "jpej", "jpg"]; // There are some valid extensions and we've store them in array

                    if(in_array($img_ext, $extensions)){
                        $time = time(); // This will return us the current time
                                        // We need this time beacuse when you uploading user image tin our folder we rename user file 
                                        // with current time, so all the image file will have a unique name
                        
                        // let's move the user uploaded image to our particular folder
                        $new_img_name = $time . $img_name;
                        
                        if(move_uploaded_file($tmp_name, "images/" . $new_img_name)){ // if user upload img move to our folder sucessfully
                            $status = "Active now"; // When a user signed up, then his status will be active now)
                            $random_id = rand(time(), 10000000); // creaates a random id for user

                            //echo "{$random_id}, '{$fname}', '{$lname}', '{$email}', '{$pswrd}', '{$new_img_name}', '{$status}'";

                            // let's insert all user data inside table
                            $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, pswrd, image, status) VALUES({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$pswrd}', '{$new_img_name}', '{$status}')");
                            
                             if($sql2){ // If these datas inserted
                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'");

                                if(mysqli_num_rows($sql3) > 0){
                                    $row = mysqli_fetch_assoc($sql3);
                                    $_SESSION["unique_id"] = $row["unique_id"];
                                    echo "success";
                                }
                             } else {
                                 echo "Something went wrong!";
                             }
                        }
                    } else {
                        echo "Por favor, selecione uma imagem do tipo - jpg, jpeg, png!";
                    }
                } else {
                    echo "Por favor, selecione uma imagem";
                }
            }
        } else {
            echo "$email - este email nao é válido";
        }
    } else {
        echo "Preencha os campos obrigatorios";
    } 