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
	           <div class="col-md-4">
	              <div class="row">
	              </div>
	           </div>
	           <div class="col-md-3">
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
                    <li><a href="UserManagement.php"><i class="glyphicon glyphicon-user"></i>Manage Users</a></li>
                    <li><a href="DispFeedback.php"><i class="glyphicon glyphicon-user"></i>Display Feedback</a></li>
                </ul>
		    </div>
      </div>

      <?php

      // Create connection
      $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM feedback";
      $result = $conn->query($sql);
      ?>
                            
      <div class="col-md-10">
               <div class="content-box-large">
                  <div class="panel-heading">
                    <div class="panel-title">Display Feedback</div>
                  </div>
      <div class="panel-body">
            <div class="table-responsive ">
              <table class="table table-hover">
                    <thead>
                      <tr>
                              <th>User Name</th>
                              <th>E-mail ID</th>
                              <th>Feedback</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>".$row["name"]."</td><td>".$row["email"]."</td><td>".$row["feedback"]."</td>";
                                    }                            
                                    echo "</table>";
                                } else {
                                    echo "0 results";
                                }
                                $conn->close();
                            ?>
                    </tbody>
              </table>
            </div>
      </div>
    </div>
  </div>
            </div>
          </div>
        </div>
      </div>
    </div>                          

    <!--<footer>
         <div class="container">
         
            <div class="copy text-center">
               Copyright 2014 <a href='#'>Website</a>
            </div>
            
         </div>
      </footer>-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>