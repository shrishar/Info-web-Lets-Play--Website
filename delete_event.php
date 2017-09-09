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
        
            // Create connection
            $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $sql = "DELETE FROM event WHERE User_ID='$user_id' AND Event_ID='$event_id'";
    

            if ($conn->query($sql) === TRUE) {
                header('Location:my_events.php');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        
            $sql = "DELETE FROM discussion WHERE Event_ID='$event_id'";
        
            if ($conn->query($sql) === TRUE) {
                header('Location:my_events.php');
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

    $conn->close();

        
        ?>
        
        
        
        
    </body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
</html>