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
       
         <div class="col-md-10">
             <div class="row">
		          <div class="col-md-8 panel-info">
                      <div class="content-box-header panel-heading">
	  					    <div class="panel-title ">Event Details</div>
						
		  			         </div>
		  			 <div class="content-box-large box-with-header">
        <?php 
            $user_id =$_GET['user_id'];
            $event_id = $_GET['event_id'];
            $logged_user = $_SESSION['login_user'];
        
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
                    if ($row["User_ID"] != $logged_user){
                        $location = $row["Location"];
                        $players_reqd = $row["Players_Reqd"];
                        $date = $row["Date"];
                        $time = $row["Time"];
                        $game_type = $row["Game_Type"];
                        $created_user = $row["User_ID"];
                    }     
                }

            } else {
                echo "0 results";
            }             
        ?> 
                           
                        <div class="panel-body" >
                            <h3 align="center">Game:</h3> <h3 align="center"><b><?php echo  $game_type?></b></h3>
		  					<table class="table" >
                                
				              <thead>
				                <tr>
				                  <th style ="text-align: center;" ><i class="glyphicon glyphicon-calendar"></i>: <b><?php echo  $date ?></b></th>
				                  <th style ="text-align: center;"><i class="glyphicon glyphicon-time"></i>: <b><?php echo  $time ?></b></th>
				                </tr>
				              </thead>
				              <thead>
				                <tr>
				                  <th style ="text-align: center;"><i class="glyphicon glyphicon-globe"></i>: <b><?php echo  $location ?></b></th>
				                  <th style ="text-align: center;"><i class="glyphicon glyphicon-user"></i>: <b><?php echo  $created_user?></b></th>
				                </tr>
                                </thead>
				
				            </table>
                        
                           
		  				</div>
             </div>
          </div>
         <div class="col-md-4 panel-info">
              <div class="content-box-header panel-heading">
	  					<div class="panel-title ">Joined Players</div>
						
		      </div>
		  			<div class="content-box-large box-with-header">
                        <div class="panel-body">
                            <table class="table">
                     <?php 
                            $sql = "INSERT INTO event (Event_ID, User_ID, Game_Type, Location, Date, Time, Player_ID, Players_Reqd) 
                            VALUES ('$event_id', '$user_id', '$game_type', '$location', '$date', '$time', '$logged_user', '$players_reqd')";

                            if ($conn->query($sql) === TRUE) {
                                echo '<script language="javascript">';
                                echo 'alert("Joined successfully")';
                                echo '</script>';
                            } else {
                                //echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                            
                            $sql = "SELECT Player_ID FROM event WHERE User_ID='$user_id' and Event_ID='$event_id'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr><td><a href="view_other_user_profile.php?view_user='.$row["Player_ID"].'">'.$row["Player_ID"].'</a></td></tr>';

                                }
                                
                            } else {
                                echo "0 results";
                            }

                         
                   ?>       
                        </table>
                </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-4 panel-info">
                <div class="content-box-large box-with-header" style="display: block; text-align:center;">
              
                <?php 
                             echo '<a href="leave_event.php?user_id='.$_GET["user_id"].'&event_id='.$_GET["event_id"].'&player_id='.$logged_user.'" class="btn btn-danger btn-lg"> <i class="glyphicon glyphicon-remove"></i> Leave</a>';    
                ?>
                </div>
              </div>
        </div>
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-2">
		  	
              
    </div>
     <div class="col-md-10">
             <div class="row">
		          <div class="col-md-8 panel-info">
                      <div class="content-box-header panel-heading">
	  					    <div class="panel-title ">Discussion Forum</div>
						      
		  			         </div>
                <div class="content-box-large box-with-header">
		  			 <div class="panel-body">
                        <form action="add_post_join.php" method="post" class="form-horizontal">
                            <div class="form-group"> 
								<div class="col-sm-10">
								    <textarea class="form-control" placeholder="Comment......" rows="3"  name="comment" required="required"></textarea>
								</div>
				            </div>
                            <input type="hidden" name="userid" value="<?php echo $logged_user; ?>">
                            <input type="hidden" name="ownerid" value="<?php echo $user_id; ?>">
                            <input type="hidden" name="eventid" value="<?php echo $event_id; ?>">
                            <div class="form-group">
								<div class="col-sm-offset-8 col-sm-10">
								    <input type="submit" value="Post" class="btn btn-primary">
								</div>
				            </div>
                         </form>
        <?php         
                

                $sql = "SELECT User_ID, Comment, Date FROM discussion WHERE Event_ID='$event_id' ORDER by Date DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo '<h4>'.$row["User_ID"].':</h4><i>'.$row["Date"].'</i><br><b>'. $row['Comment'].'</b><br>';

                    }
                } else {
                    echo "0 discussions";
                }
            $conn->close();
    ?>
                         
                      </div>
                 </div>
             </div>
         </div>
    </div>
       </div>
      </div>


   <!-- <footer>
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