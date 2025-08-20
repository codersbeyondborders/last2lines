<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
/**
 *
 * @author     Abdul Wajid <abdulwajid635@gmail.com>
 * @copyright  2016 Abdul Wajid
 * @version    1.0.0
 */

?>

<?php 
//confirm_logged_in();
$message ='';
// START FORM PROCESSING
/*** New Entry **/
	if(isset($_POST['newCarousalSubmit'])){
		$flag = false;
		$carousal_content = null;
		
		if(isset($_POST['carousal_content']))
		$carousal_content = mysql_prep($_POST['carousal_content']);
		
		if($carousal_content != null)
			$flag = true;
		else 
			$flag = false;
		
		if($flag){
			//success
				
			// Create carousalPoem.txt
			$carousalFile = "../carousalPoem.txt";
			
			$carousalFileLink = fopen($carousalFile, 'w+') or die("Can't open the file.");
			
			
			
			$pieces = explode("\\r\\n", $carousal_content);
			for($i=0;$i<count($pieces);$i++)
			//echo $pieces[$i]."<br/>";
			fwrite($carousalFileLink, $pieces[$i].PHP_EOL);
		
			fclose($carousalFileLink);
				
			
			$message = "Carousal File created successfully.";
			}else{
			$message = "Oops!! Something Went Wrong.<br/>
			Please enter some content.";
			
			}
}


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
<body class="set-body">

  
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php">L2L ADMIN

                </a>
            </div>

            <div class="notifications-wrapper">
                <ul class="nav">



                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-cogs"></i><i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user pull-right">
                            
                            
                            <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>
        <!-- /. NAV TOP  -->
        
		 <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    
                    <li class="active">
                        <a  href="dashboardNewEntry.php"><i class="fa fa-plus "></i>New Couplet</a>

                    </li>
                    <li>
                        <a href="dashboardSearchCouplet.php"><i class="fa fa-search "></i>Search Couplet</a>

                    </li>
					<li>
                        <a href="dashboardDeleteCouplet.php"><i class="fa fa-times "></i>Delete Couplet</a>

                    </li>
					<li>
                        <a href="dashboardEditCouplet.php"><i class="fa fa-pencil-square-o "></i>Edit Couplet</a>

                    </li>
					<li>
                        <a href="dashboardSearchToken.php"><i class="fa fa-search "></i>Search Token</a>

                    </li>
					<li>
                        <a href="dashboardNewChapter.php"><i class="fa fa-plus"></i>New Chapter</a>

                    </li>
					<li>
                        <a href="dashboardEditChapter.php"><i class="fa fa-pencil-square-o "></i>Edit Chapter</a>

                    </li>
					<li>
                        <a href="dashboardAllChapters.php"><i class="fa fa-star "></i>All Chapters</a>

                    </li>
					<li>
                        <a href="imageUploader/imageUploader.php"><i class="fa fa-upload "></i>Upload Guidelines Image</a>

                    </li>
					<li>
                        <a href="#"><i class="fa fa-plus "></i>New carousal</a>

                    </li>
                </ul>
            </div>

        </nav>
        <!-- /. SIDEBAR MENU (navbar-side) -->
        <div id="page-wrapper" class="page-wrapper-cls">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">DASHBOARD </h1>
                    </div>
                </div>
                <div class="row">
                   
                </div>

                
                                <div class="row space-get">
                    <div class="col-md-12">
					<h2>New Carousal</h2>
					<hr/>
                        <!-- COMPOSE MESSAGE START -->
						<?php if (!empty($message)) {echo "<br/><p class=\"text-danger\">" . $message . "</p>";} ?>
						
						<form class="Compose-Message"
						action="dashboardNewCarousal.php" method="post"
						>
                            <div class="panel panel-success">
                                
                                <div class="panel-body">
                                    
                                    

                                    
									<label>Enter Contents Here</label>
                                    <textarea class="form-control"name="carousal_content" rows="8" cols="40"></textarea>
									
                                    
                                    
									
                                    <hr />
                                    <input  type="submit" name="newCarousalSubmit" value="submit" class="btn btn-success"/>
                                </div>
                                
                            </div>
                        </form>
                        <!-- COMPOSE MESSAGE END -->
                    </div>
   
   
					

                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
			
			<!--Previous Carousal-->
			<div class="row">
				<section class="container">
				<h2>Current Carousal</h2>
				
					<?php
					$poemFileName = "../carousalPoem.txt"; 
$handle = fopen($poemFileName, "r");

//$handle = fopen("poem.txt", "r");
if ($handle) {
	
    while (($line = fgets($handle)) !== false) {
        $line = str_replace("\n", "", $line);
		//echo "<p>".htmlspecialchars($line)."</p>";
		echo htmlspecialchars($line);
		echo "<br/>";
		
		
    }
    fclose($handle);
}
					
					
					
					?>
				</section>
            </div>
			<!--Previous Carousal-->
				
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
    <!-- CHARTS SCRIPTS -->
    <script src="assets/js/Chart.js"></script>
    <!-- CHARTS SCRIPTS SCRIPTS-->
    <script src="assets/js/custom-charts.js"></script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php
	// 5. Close connection
	mysqli_close($connection);
?>