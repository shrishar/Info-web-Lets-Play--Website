<?php 
    session_start();
    include("config.php");
    if (! (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
        header('Location: login.php');
    }
?>
<?php
   $user_check = $_SESSION['login_user'];

   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
   $ses_sql = mysqli_query($db,"select * from user where user_id = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['user_id'];
    $firstname=$row['first_name'];
    $lastname=$row['last_name'];
    $email=$row['email'];
    $password=$row['password'];
    $contact=$row['contact'];
    $address=$row['address'];
    $date = $row['dob'];
    $BIO=$row['userbio'];
    $picpath = $row['picpath'];
 if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_pic_id = $_SESSION['login_user'];
    $firstname=$_POST["firstName"];
    $lastname=$_POST["lastName"];
    $password=$_POST["password"];
    $email=$_POST["userEmail"];
    $contact=$_POST["userContact"];
    $address=$_POST["userAddress"];
    $date = $_POST["userDOB"];
    $BIO=$_POST["userBIO"];
    
     
    if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size >= 2097152){
         $errors[]='File size must be less than 2 MB';
      }
      
      $temp = explode(".", $_FILES["file"]["name"]);
      $new_file_name = $user_pic_id . '.' . $file_ext;
          
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"profile_pics/".$new_file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
            
    $picpath = "profile_pics/".$new_file_name; 

    

    // Create connection
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    $sql = "UPDATE user SET first_name='$firstname',last_name='$lastname',password='$password',address='$address',email='$email',contact='$contact',dob='$date',userbio='$BIO', picpath='$picpath' where user_id='$user_check'";
    

    if ($conn->query($sql) === TRUE) {
        echo "Record Updated successfully";
        $_SESSION['login_user'] = $user_check;
        header('Location: user_profile.php');    
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

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
                         <form action=" " method="post" class="form-horizontal" enctype="multipart/form-data">
                            
                                   <div class="form-group">
								    <label  class="col-sm-2 control-label">First Name</label>
								    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="firstName" value=<?php echo $firstname; ?>>
								    </div>
								  </div>
                                     <div class="form-group">
								    <label  class="col-sm-2 control-label">Last Name</label>
								    <div class="col-sm-10">
								     <input class="form-control" type="text" name="lastName" value=<?php echo $lastname; ?>>
								    </div>
								  </div>
            
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Email</label>
								    <div class="col-sm-10">
								      <input class="form-control" type="text"  name="userEmail" value=<?php echo $email; ?>>
								    </div>
								  </div>
                                <div class="form-group">
								    <label  class="col-sm-2 control-label">Password</label>
								    <div class="col-sm-10">
								     <input class="form-control" type="password"  name="userPassword" value=<?php echo $password; ?>> 
								    </div>
								  </div>
                               <div class="form-group">
								    <label  class="col-sm-2 control-label">Address</label>
								    <div class="col-sm-10">
								     <input class="form-control" type="text"  name="userAddress" value=<?php echo $address; ?>>
								    </div>
								  </div>
                              <div class="form-group">
								    <label  class="col-sm-2 control-label">Contact</label>
								    <div class="col-sm-10">
								      <input class="form-control" type="text"  name="userContact" value=<?php echo $contact; ?>>
								    </div>
								  </div>
                    
                              <div class="form-group">
								    <label  class="col-sm-2 control-label">Date of Birth</label>
								    <div class="col-sm-10">
								     <input class="form-control" type="date"  name="userDOB" value=<?php echo $date; ?> >
								    </div>
								  </div>
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Upload a picture</label>
								    <div class="col-md-10">
												<input type="file" class="btn btn-default" id="exampleInputFile" name="image">
												<p class="help-block">
													Change Profile picture
												</p>
								    </div>
								  </div>
                             
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Biography</label>
								    <div class="col-sm-10">
								     <input class="form-control" type="text"  name="userBIO" value=<?php echo $BIO; ?>>
								    </div>
								  </div>
                             <div class="action">
                                <input type = "submit" class="btn btn-primary signup"  name="update" value="Finish Updating"/><br />
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
        <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
        
    </body>
                <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
</html>