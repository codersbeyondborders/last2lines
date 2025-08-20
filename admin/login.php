<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/constants.php"); ?>
<?php 
if (logged_in()) {
		redirect_to("dashboard.php");
	}
?>
<?php 
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = "You are now logged out.";
		} 
		
// START FORM PROCESSING
	if (isset($_POST['adminSubmitButton'])) {
		if(isset($_POST['username']))
		$username = $_POST['username'];
		
		if(isset($_POST['password']))
		$password = $_POST['password'];
		
		if(ADMIN_USER_ONE == $username && ADMIN_PASS_ONE == $password){
			$_SESSION['user_id'] = $username;
			redirect_to("dashboard.php");
		
		
		}else if(ADMIN_USER_TWO == $username && ADMIN_PASS_TWO == $password){
			$_SESSION['user_id'] = $username;
			redirect_to("dashboard.php");
		
		}else{
			$message = "Username/password combination incorrect.<br />
					Please try again.";
		
		}
		
		
		
		
		
		
		
	
	}

	?>

<?php
/**
 *
 * @author     Abdul Wajid <abdulwajid635@gmail.com>
 * @copyright  2016 Abdul Wajid
 * @version    1.0.0
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Free Html Bootstrap Admin Template" />
    <meta name="author" content="" />
    <meta name="keywords" content="bootstrap, template,admin,free template" />
    <link rel="canonical" href="http://www.htmladmin.com/">
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- Favicon Icon ( put .ico favicon URL in href below ) -->
    <link rel="icon" href="#" />
    <title>Last Two Lines</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!--CUSTOM STYLES-->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body >
	
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">L2L ADMIN
                     
                </a>
            </div>

           
        </nav>
        <!-- /. NAV TOP  -->
        
        
        <div id="page-wrapper" class="page-wrapper-cls" style="min-height:600px!important"  >
            <form action="login.php" method="post" id="page-inner" style="min-height:600px!important">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Please Login :</h1>
						
						<?php if (!empty($message)) {echo "<br/><p class=\"text-danger\">" . $message . "</p>";} ?>
						
                    </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                   
                    
                    
                     <label>Enter Username : </label>
                        <input type="text" name="username"class="form-control">
                        <label>Enter Password :  </label>
                        <input type="password" name="password" class="form-control">
                        <hr>
                        <input type="submit" name="adminSubmitButton" value="Login"
                </div>
                
                   

            </div>
                <!-- /. PAGE INNER  -->
            </form>
            <!-- /. PAGE WRAPPER  -->
        </div>
    </div>
    <!-- /. WRAPPER  -->
    <footer>
        <p>copyright&nbsp;&copy;&nbsp;<?php echo date('Y');?>&nbsp;<a href="http://www.last2Lines.com">Last2Lines.com</a>
								&nbsp;|&nbsp;All Rights Reserved.</p>
    </footer>
    <!-- /. FOOTER  -->

    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.11.1.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php
	// 5. Close connection
	mysqli_close($connection);
?>