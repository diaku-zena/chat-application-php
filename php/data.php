<?php
    while($row = mysqli_fetch_assoc($sql)){
        $sql2 = mysqli_query($conn, "SELECT * FROM messages WHERE (incoming_msg_id={$row['unique_id']} OR 
                                    outgoing_msg_id={$row['unique_id']}) AND (outgoing_msg_id={$outgoing_id} OR 
                                    incoming_msg_id={$outgoing_id}) ORDER BY msg_id DESC LIMIT 1");
        
        $row2 = mysqli_fetch_assoc($sql2);
        if(mysqli_num_rows($sql2) > 0){
            
            $result = $row2['msg'];
        } else {
            $result = "";
        }

        // Triming msg if word are more than 28
        (strlen($result) > 40) ? $msg = substr($result, 0, 40) . "..." : $msg = $result;

        // Adding You: text before msg if login id sends msg
        ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";

        // Checking if user is offline
        ($row["status"] == "Offline") ? $offline = "offline" : $offline = "";

        (strlen($msg) == "") ? $msg_res= "<small>Sem mensagem ainda</small>": $msg_res=$msg;
        $output .= '
        <a href="chat.php?user_id='. $row['unique_id'] .'">
            <div class="content">
                <img src="php/images/' . $row['image'] . '" alt="">
                <div class="details">
                    <span>' . $row["fname"] . ' '. $row["lname"] . '</span>
                    <p>' . $you . $msg_res . '</p>
                </div>
            </div>
            <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
        </a>';
    }
?>