

<?php
// if the $_POST is NOT empty (i.e. has some stuff in it) then something has been posted:

    include("config.php");
    
    $feedback = $_POST["feedback"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];


    // Create connection
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO feedback(feedback, name, email, phone) VALUES('$feedback', '$name', '$email', '$phone')";

    if ($conn->query($sql) === TRUE) {
        header('Location:index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

?>
