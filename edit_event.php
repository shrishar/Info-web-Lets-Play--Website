<?php 
    session_start();
    include("config.php");
    if (! (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
        header('Location: login.php');
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
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
   <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
   <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
  <script>
  $( function() {
    $( "#date" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>

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
	                 <h1><a href="user_home.php">Lets Play</a></h1>
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
                              
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i><?php echo $_SESSION['login_user']; ?><b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
	                          <li><a href="update_profile.php">Profile</a></li>
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
                    <li class="current"><a href="user_home.php"><i class="glyphicon glyphicon-home"></i> All Events</a></li>
                    <li><a href="my_events.php"><i class="glyphicon glyphicon-calendar"></i> My Events</a></li>
                </ul>
                
                    
                
             </div>
              <div class="sidebar content-box" style="display: block; text-align:center;">
                <a href="create_event.php" class="btn btn-success btn-lg" type="button" ><i class="glyphicon glyphicon-plus"></i> Create Event</a>
              
              </div>
              
		  </div>
        
        <?php
        if (empty($_POST)): ?>
        
        <?php
            $user_id =$_GET['user_id'];
            $event_id = $_GET['event_id'];
        
            // Create connection
            $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
        
        
                
            $sql = "SELECT DISTINCT User_ID,Event_ID,Location,Game_Type,Date,Time,Players_Reqd, COUNT(User_ID) AS Joined FROM event WHERE User_ID='$user_id' and Event_ID='$event_id' GROUP BY User_ID, Event_ID,Location,Game_Type,Date,Time,Players_Reqd";
            
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    
                    $location = $row["Location"];
                    $players_reqd = $row["Players_Reqd"];
                    $date = $row["Date"];
                    $time = $row["Time"];
                    $game_type = $row["Game_Type"];
                       
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        
        
        ?>
        
        <div class="row">
	  	        <div class="col-md-6">
	  					<div class="content-box-large">
                            <div class="panel-heading">
					            <div class="panel-title">Update Details</div>
					        </div>
                            <div class="panel-body">
        
                        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" class="form-horizontal">
                            <div class="form-group">
								    <label  class="col-sm-2 control-label">Game Type:</label>
								    <div class="col-sm-10">
                                     <input type="text" name="game" value="<?php echo $game_type; ?>" class="form-control">
                                    </div>
				            </div>
                            <div class="form-group">
								    <label  class="col-sm-2 control-label">Location</label>
								    <div class="col-sm-10">    
                                        <input type="text" name="location" value="<?php echo $location; ?>" class="form-control">
                                    </div>
                            </div>
                            <div class="form-group">
								    <label class="col-sm-2 control-label">Date</label>
								    <div class="col-sm-10">
                                        <input type="text" name="date" id ="date" value="<?php echo $date; ?>" class="form-control">
                                    </div>
                            </div>
                            <div class="form-group">
								    <label class="col-sm-2 control-label">Time</label>
								    <div class="col-sm-10">
                                        <input type="time" name="time" value="<?php echo $time; ?>" class="form-control">
                                    </div>
                            </div>
                            <div class="form-group">
								    <label class="col-sm-2 control-label">Players Required</label>
								    <div class="col-sm-10">
                                        <input type="number" name="p_reqd" value="<?php echo $players_reqd; ?>" class="form-control">
                                    </div>
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                            <div class="form-group">
								    <div class="col-sm-offset-2 col-sm-10">    
                                        <input type="submit" value="Update" class="btn btn-primary">
                                </div>
                            </div>
                            </form>
                        </div>            
                    </div>
                </div>
            </div>
            
            </div>
      </div>
        
 </body>
</html>
    
        
    <?php else: ?>
        
        <?php
        $gametype = $_POST["game"];
        $location = $_POST["location"];
        $date = $_POST["date"];
        $time = date('H:i:s', strtotime($_POST["time"]));
        $players_reqd = $_POST["p_reqd"];
        $user_id = $_POST["user_id"];
        $event_id = $_POST["event_id"];
        
        // Create connection
        $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
    
    

        $sql = "UPDATE event SET Game_Type='$gametype', Location='$location', Date='$date', Time='$time', Players_Reqd='$players_reqd' WHERE User_ID='$user_id' AND Event_ID='$event_id'";


        if ($conn->query($sql) === TRUE) {
            echo '<script language="javascript">';
            echo 'alert("Event Updated Successfully")';
            echo '</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

    
	?>
        
        
    <?php endif; ?>
          <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <!-- <script src="https://code.jquery.com/jquery.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

