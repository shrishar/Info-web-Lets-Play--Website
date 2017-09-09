<?php
   include("config.php");

   if($_SERVER["REQUEST_METHOD"] == "POST") {
       
       
    $userid = $_POST["userName"];
    $firstname=$_POST["firstName"];
    $lastname=$_POST["lastName"];
    $password=$_POST["password"];
    $confirmpasswd=$_POST["confirm_password"];
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
      $new_file_name = $userid . '.' . $file_ext;
          
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"profile_pics/".$new_file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }
            
    $picpath = "profile_pics/".$new_file_name;
    
    
    if ($password === $confirmpasswd){
        // Create connection
        $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "INSERT INTO user (user_id, first_name,last_name ,password,address,email,contact,dob,userbio,picpath) 
        VALUES ('$userid', '$firstname',  '$lastname', '$password','$address','$email','$contact', '$date','$BIO','$picpath')";


        if ($conn->query($sql) === TRUE) {
            header('Location: login.php');    
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    else {
        echo "<h3>Confirm password should match the password</h3>";
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
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
   <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
   <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
  <script>
  $( function() {
    $( "#userDOB" ).datepicker({ dateFormat: 'yy-mm-dd' });
  } );
  </script>
  </head>
   <body >
	  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
	                 <h1><a href="login.php">Lets Play</a></h1>
	              </div>
	           </div>
	           <div class="col-md-5">
	              <div class="row">
	              </div>
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                       
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

      <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  
            
              
		  </div>
       <div class="row">
           <div class="col-md-6">
               <div class="content-box-large">
                   <div class="panel-heading">
					            <div class="panel-title">Register</div>
					        </div>
                     <div class="panel-body">
                         <form action=" " method="post" class="form-horizontal"  enctype="multipart/form-data">
                                  <div class="form-group">
								    <label  class="col-sm-2 control-label">User Name</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" name="userName" placeholder="Username" required>
								    </div>
								  </div>
                                   <div class="form-group">
								    <label  class="col-sm-2 control-label">First Name</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" name="firstName" placeholder="First Name" required>
								    </div>
								  </div>
                                     <div class="form-group">
								    <label  class="col-sm-2 control-label">Last Name</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" name="lastName" placeholder="Last Name" required>
								    </div>
								  </div>
                                 <div class="form-group">
								    <label  class="col-sm-2 control-label">Password</label>
								    <div class="col-sm-10">
								      <input type="password" class="form-control" name="password" placeholder="Password" required>
								    </div>
								  </div>
                              <div class="form-group">
								    <label  class="col-sm-2 control-label">Confirm Password</label>
								    <div class="col-sm-10">
								      <input type="password" class="form-control" name="confirm_password" placeholder="Password" required>
								    </div>
								  </div>
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Email</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" name="userEmail" placeholder="email" required>
								    </div>
								  </div>
                               <div class="form-group">
								    <label  class="col-sm-2 control-label">Address</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" name="userAddress" placeholder="Address" required>
								    </div>
								  </div>
                              <div class="form-group">
								    <label  class="col-sm-2 control-label">Contact</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" name="userContact" placeholder="contact" required>
								    </div>
								  </div>
                    
                              <div class="form-group">
								    <label  class="col-sm-2 control-label">Date of Birth</label>
								    <div class="col-sm-10">
								      <input type="text" class="form-control" id = "userDOB" name="userDOB" placeholder="Date of Birth" required>
								    </div>
								  </div>
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Upload a picture</label>
								    <div class="col-md-10">
												<input type="file" class="btn btn-default" id="exampleInputFile" name="image">
												<p class="help-block">
													Profile picture
												</p>
								    </div>
								  </div>
                             <div class="form-group">
								    <label  class="col-sm-2 control-label">Biography</label>
								    <div class="col-sm-10">
								    <textarea class="form-control" placeholder="Bio......" rows="3"  name="userBIO" required="required"></textarea>
								</div>
								  </div>
                             <div class="action">
                                <input type = "submit" class="btn btn-primary signup"  value = "Register"/><br />
			                </div> 
                         </form>
                   </div>
                   
               </div>
           </div>
           
       </div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <!-- <script src="https://code.jquery.com/jquery.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
   </body>
</html>