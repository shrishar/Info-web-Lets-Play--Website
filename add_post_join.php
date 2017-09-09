<?php

    session_start();
    if (! (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
        header('Location: login.php');
    }
    
    include("config.php");
    
    $comment = $_POST["comment"];
    $userid = $_POST['userid'];
    $eventid = $_POST['eventid'];
    $ownerid = $_POST['ownerid'];
    $date =  date("Y-m-d h:i:sa");
    
    

    // Create connection
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT MAX(Comment_ID) AS maxid FROM discussion";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $comment_id = $row['maxid'] + 1;
            
        }
        
    }
    else {
        $comment_id = 1;
    }
    

    $sql = "INSERT INTO discussion (Event_ID, User_ID, Comment, Comment_ID, Date) 
    VALUES ('$eventid', '$userid', '$comment', '$comment_id', '$date')";
    

    if ($conn->query($sql) === TRUE) {
        header("Location: view_joined_event.php?user_id=$ownerid&event_id=$eventid");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    
	?>