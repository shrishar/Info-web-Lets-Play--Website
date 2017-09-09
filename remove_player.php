<?php 
    session_start();
    include("config.php");
    if (! (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
        header('Location: login.php');
    }
?>
<html>
    <head>
        <title>Lets Play</title>
    </head>
    
    <body>
    <?php 
            $user_id =$_GET['user_id'];
            $event_id = $_GET['event_id'];
            $player_id = $_GET['player_id'];
        
            // Create connection
            $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $sql = "DELETE FROM event WHERE User_ID='$user_id' AND Event_ID='$event_id' AND Player_ID='$player_id'";
    

            if ($conn->query($sql) === TRUE) {
                echo '<script language="javascript">';
                echo 'alert("Removed Successfully")';
                header('Location:my_events.php');
                echo '</script>';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

    $conn->close();

        
        ?>
        
        
        
        
    </body>
</html>