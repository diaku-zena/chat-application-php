<?php
    session_start();

    if(!isset($_SESSION["unique_id"])){
        header("../login.php");
    } else {
        include_once "config.php";

        $outgoing_id = mysqli_real_escape_string($conn, $_POST["outgoing_id"]);
        $incoming_id = mysqli_real_escape_string($conn, $_POST["incoming_id"]);
        $output = "";

        $sql = mysqli_query($conn, "SELECT * FROM messages WHERE 
        (outgoing_msg_id='$outgoing_id' and incoming_msg_id=$incoming_id) OR 
        (outgoing_msg_id='$incoming_id' and incoming_msg_id=$outgoing_id) ORDER BY msg_id ASC");

        if(mysqli_num_rows($sql) > 0){
            while($row = mysqli_fetch_assoc($sql)){
                if($row["outgoing_msg_id"] === $outgoing_id){// If this is equal to, then he is a msg sender
                    $output .= '
                            <div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row["msg"] . '</p>
                                </div>
                            </div>
                            ';
                } else { // He is a msg receiver
                    $user_id = $_POST['incoming_id'];
                    $sql2 = mysqli_query($conn, "SELECT image from users WHERE unique_id=$user_id");
                    $img = mysqli_fetch_assoc($sql2);

                    $output .= '
                            <div class="chat incoming">
                            <img src="php/images/'. $img["image"] . '" alt="">
                            <div class="details">
                                <p> ' . $row['msg'] . '</p>
                            </div>
                        </div>';
                }
            }
        } else {
            $output .= "Nao existe mensagens ainda";
        }

        echo $output;

    }
?>