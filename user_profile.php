<?php
   include('config.php');
   session_start();

   if (! (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
        header('Location: login.php');
    }
    
   $user_id = $_SESSION['login_user'];

   $user_check = $_SESSION['login_user'];

   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
   $ses_sql = mysqli_query($db,"select * from user where user_id = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['user_id'];
    $firstname=$row['first_name'];
    $lastname=$row['last_name'];
    $email=$row['email'];
    $contact=$row['contact'];
    $address=$row['address'];
    $date = $row['dob'];
    $BIO=$row['userbio'];
    $picpath = $row['picpath'];
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
       $_SESSION['login_user'] = $user_check;
        header('Location: update_profile.php');    
}
?>

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
       <div class="row">
           <div class="col-md-6">
               <div class="content-box-large">
                   <div class="panel-heading">
					            <div class="panel-title">Welcome <?php echo $login_session; ?></div>
					        </div>
        <div class="panel-body">
                         <form action=" " method="post" class="form-horizontal">
                                  <div class="form-group">
								    <label  class="col-sm-2 control-label">User Name</label>
								    <div class="col-sm-10">
								      <label class="form-control"><?php echo $login_session; ?></label>
								    </div>
								  </div>
                                   <div class="form-group">
								    <label  class="col-sm-2 control-label">First Name</label>
								    <div class="col-sm-10">
                                        <label class="form-control"><?php echo $firstname; ?></label>
								    </div>
								  </div>
                                     <div class="form-group">
								    <label  class="col-sm-2 control-label">Last Name</label>
								    <div class="col-sm-10">
								      <label class="form-control"><?php echo $lastname; ?></label>
								    </div>
								  </div>
            
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Email</label>
								    <div class="col-sm-10">
								      <label class="form-control"><?php echo $email; ?></label>
								    </div>
								  </div>
                               <div class="form-group">
								    <label  class="col-sm-2 control-label">Address</label>
								    <div class="col-sm-10">
								      <label class="form-control"><?php echo $address; ?></label>
								    </div>
								  </div>
                              <div class="form-group">
								    <label  class="col-sm-2 control-label">Contact</label>
								    <div class="col-sm-10">
                                        <label class="form-control"><?php echo $contact; ?></label>
								    </div>
								  </div>
                    
                              <div class="form-group">
								    <label  class="col-sm-2 control-label">Date of Birth</label>
								    <div class="col-sm-10">
								      <label class="form-control"><?php echo $date; ?></label>
								    </div>
								  </div>
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Biography</label>
								    <div class="col-sm-10">
								     <label class="form-control"><?php echo $BIO; ?></label>
								    </div>
								  </div>
                         </form>
                   </div>
               </div>
           </div>
           <div class="col-md-2">
                    <div class="content-box-large">
                        <div class="panel-body">
                            <?php echo '<img src="'. $picpath . '" width = 125 height =150/>';?>
                        </div>
                        
                </div>
            </div>
            </div>
          </div>
        </div>
        
            

    </body>
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
</html>