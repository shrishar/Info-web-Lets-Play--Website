<?php 
    session_start();
    include("config.php")
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Let's Play Admin</title>
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
  <body class="login-bg">
  	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-12">
	              <!-- Logo -->
	              <div class="logo">
	                  <h1><a href="index.php">Admin Login Lets Play</a></h1>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>

	<?php
	if (!empty($_POST)): ?>

    <?php
    $user_id = $_POST["user_id"];
    $passwd = $_POST["passwd"];

    // Create connection
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT User_id FROM login WHERE User_id='$user_id' AND Password='$passwd'";
	$res = $conn->query($sql);
    if ($res->num_rows > 0) {
        $_SESSION['admin_user'] = $user_id;
        $_SESSION['loggedin_admin'] = true;
        header('Location: AddGame-new.php');    
      } else {
         $error = "";
        echo '<script language="javascript">';
        echo 'alert("Your Login Name or Password is invalid")';
        echo '</script>';
        header('Location: admin_login.php');
      }
    ?>

    
    <?php 
    

    $conn->close();

	?>

	<?php else: ?>
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
		
	<div class="page-content container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-wrapper">
			        <div class="box">
			            <div class="content-wrap">
			                <h6>Sign In</h6>
			                <input class="form-control" type="text" placeholder="User ID" name="user_id" required="This field is empty">
			                <input class="form-control" type="password" placeholder="Password" name="passwd" required="This field is empty">
			                <div class="action">
			                    <input type="submit" class="btn btn-primary signup" value="Login">
			                </div>                
			            </div>
			        </div>

			    </div>
			</div>
		</div>
	</div>
	</form>
	<?php endif; ?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>