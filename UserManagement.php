<?php 
    session_start();
    include("config.php");
    if (! (isset($_SESSION['loggedin_admin']) && $_SESSION['loggedin_admin'] == true)) {
        header('Location: admin_login.php');
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Lets Play</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a>Lets Play</a></h1>
	              </div>
	           </div>
	           <div class="col-md-5">
	              <div class="row">
	              </div>
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> Admin <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="logout.php">Logout</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

    <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <li><a href="AddGame-new.php"><i class="glyphicon glyphicon-home"></i>Add Game</a></li>
                    <li><a href="AddLocation-new.php"><i class="glyphicon glyphicon-globe"></i>Add Location</a></li>
                    <li class="current"><a href="UserManagement.php"><i class="glyphicon glyphicon-user"></i>Manage Users</a></li>
                    <li><a href="DispFeedback.php"><i class="glyphicon glyphicon-user"></i>Display Feedback</a></li>
                </ul>
		    </div>
      </div>

<?php
// if the $_POST is NOT empty (i.e. has some stuff in it) then something has been posted:
if (!empty($_POST)): ?>

    <?php
    $user_name = $_POST["user_name"];

    // Create connection
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

	if($user_name === 'No') {
		echo "User table is empty";
	}
	else {
		$sql = "DELETE FROM user WHERE First_name='$user_name'";

		if ($conn->query($sql) === TRUE) {
			echo "User Deleted successfully";
			//Remove the entry from dropdown box
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
    $conn->close();

	?>

<?php else: ?>

    <?php

    // Create connection
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT user_id, first_name FROM user";
    $result = $conn->query($sql);
    ?>
     <div class="row">
	  				     <div class="col-md-6">
	  					        <div class="content-box-large">
                                        <div class="panel-heading">
                                            <div class="panel-title">Manage Users</div>
                                        </div>
                            <div class="panel-body">
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" class="form-horizontal">
        <div class="box">
            <div class="content-wrap">
                <div class="form-group">
                <label  class="col-sm-2 control-label">User Name</label>
                <div class="col-sm-10">
								    
	<?php

    if ($result-> num_rows > 0) {
        
        echo "<select name='user_name' class='form-control'>";
		while($row = $result->fetch_assoc()) {
			echo '<option value="'.$row["first_name"].'">'.$row["first_name"].'</option>';
        }
        echo "</select>";
    } else {
    	echo "<select name='user_name' class='form-control'>";
    	echo '<option value="No">No user found</option>';
    	echo "</select>";
    }

    $conn->close();

    ?>
    </div>
    </div>
</div>
               
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10"> 
            <input type="submit" value="Delete User" class="btn btn-primary">
        </div>
    </div>
</div>
</div>
</form>
</div>
                        </div>
                </div>
            </div>
        </div>
      </div>

<?php endif; ?>
</body>
<script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
</html>