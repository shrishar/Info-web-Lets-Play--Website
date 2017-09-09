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
      
      <?php
            
          $arr1 = array();
          $arr2 = array();

          $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          $sql = "SELECT Name FROM game";
          $result = $conn->query($sql);

          if ($result-> num_rows > 0) {
              
            while($row = $result->fetch_assoc()) {
               $arr1[] = $row["Name"];
              }
          }

          $sql = "SELECT Name FROM location";
          $result = $conn->query($sql);

          if ($result-> num_rows > 0) {
              
            while($row = $result->fetch_assoc()) {
               $arr2[] = $row["Name"];
              }
          }
          $conn->close();
            
            ?>
      
      <script>
          
        $(document).ready(function(){$(function() {
            var jArray1= <?php echo json_encode($arr1 ); ?>;
            var jArray2= <?php echo json_encode($arr2 ); ?>;

            $( "#game" ).autocomplete({
               source: jArray1
            });

            $( "#location" ).autocomplete({
               source: jArray2
            });

         });
    });
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
                <a href="create_event.php" class="btn btn-success btn-lg" type="button" >Create Event</a>
              
              </div>
              
		  </div>
<?php 
// if the $_POST is NOT empty (i.e. has some stuff in it) then something has been posted:
if (!empty($_POST)): ?>
    
    
    <?php
    $gametype = $_POST["game"];
    $location = $_POST["location"];
    $date = $_POST["date"];
    $time = date('H:i:s', strtotime($_POST["time"]));
    $players_reqd = $_POST["p_reqd"];
    $player_id = $_SESSION['login_user'];
    $user_id = $_SESSION['login_user'];
    
    

    // Create connection
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "SELECT MAX(Event_ID) AS maxid FROM event";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            $event_id = $row['maxid'] + 1;
            
        }
        
    }
    else {
        $event_id = 1;
    }
    

    $sql = "INSERT INTO event (Event_ID, User_ID, Game_Type, Location, Date, Time, Player_ID, Players_Reqd) 
    VALUES ('$event_id', '$user_id', '$gametype', '$location', '$date', '$time', '$player_id', '$players_reqd')";
    

    if ($conn->query($sql) === TRUE) {
        echo '<script language="javascript">';
        echo 'alert("Event Created Successfully")';
        echo '</script>';
        header("Location: event_details.php?user_id=$user_id&event_id=$event_id");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    
	?>.<br>  
	
<?php else: ?>
            
    <div class="row">
	  				<div class="col-md-6">
	  					<div class="content-box-large">
                            <div class="panel-heading">
					            <div class="panel-title">Enter Event Details</div>
					        </div>
                            <div class="panel-body">
                                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post" class="form-horizontal">
                                    <div class="form-group">
								    <label  class="col-sm-2 control-label">Game</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" id="game" name="game" placeholder="Game type" required>
								    </div>
								  </div>
								  <div class="form-group ">
								    <label  class="col-sm-2 control-label">Location</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" id="location" name="location" placeholder="Location" required>
								    </div>
								  </div>
								  <div class="form-group">
								    <label class="col-sm-2 control-label">Date</label>
								    <div class="col-sm-10">
								       <input type="text" class="form-control" id="date" name="date" placeholder="Date" required>
								    </div>
								  </div>
								  <div class="form-group">
								    <label class="col-sm-2 control-label">Time</label>
								    <div class="col-sm-10">
								       <input type="time" class="form-control" id="time" name="time" placeholder="Time" required>
								    </div>
								  </div>
                                  <div class="form-group">
								    <label class="col-sm-2 control-label">Players Required</label>
								    <div class="col-sm-10">
								       <input type="number" class="form-control" id="p_reqd" name="p_reqd" placeholder="Players Required">
								    </div>
								  </div>
                                  <div class="form-group">
								    <div class="col-sm-offset-2 col-sm-10">
								      <input type="submit" value="Create" class="btn btn-primary">
								    </div>
								  </div>
                                </form>
                            </div>
                    </div>
        </div>
            </div>
            
            
  
<?php endif; ?>
            
<!-- <footer>
         <div class="container">
         
            <div class="copy text-center">
               Copyright 2014 <a href='#'>Website</a>
            </div>
            
         </div>
      </footer> -->          
                
</body>
          <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://code.jquery.com/jquery.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
    
</html>